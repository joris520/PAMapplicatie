<?php

/**
 * Description of AssessmentActionController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/competence/EmployeeAssessmentService.class.php');
require_once('modules/model/service/assessmentProcess/AssessmentProcessService.class.php');
require_once('modules/model/valueobjects/assessmentProcess/AssessmentProcessResultValueObject.class.php');

require_once('modules/model/state/assessmentProcess/AssessmentProcessActionState.class.php');

class AssessmentProcessController
{
    //
    static function processAction(  $bossId,
                                    $action,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $hasError = false;
        $messages = array();
        $resultValueObject = AssessmentProcessResultValueObject::create($bossId, $action);

        // TODO: functies met acties (zoals markSelfassessmentDone) uitwerken
        switch($action) {
            case AssessmentProcessActionState::NONE:
            case AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS:
            case AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS:
            case AssessmentProcessActionState::CANCEL_SELFASSESSMENT:
                $status = AssessmentProcessStatusValue::UNUSED;
                break;
            case AssessmentProcessActionState::INVITE_SELFASSESSMENT:
                $status = AssessmentProcessStatusValue::INVITED;
                break;
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                $status = AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED;
                list($employeeCount, $closedCount, $updatedCount) = self::processMarkSelfassessmentComplete($bossId, $assessmentCycle);
                $resultValueObject->setEmployeeCount($employeeCount);
                $resultValueObject->setClosedCount($closedCount);
                $resultValueObject->setUpdatedCount($updatedCount);
                break;
            case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                $status = AssessmentProcessStatusValue::INVITED;
                $employeeCount = self::processUndoSelfassessmentComplete($bossId, $assessmentCycle);
                $resultValueObject->setEmployeeCount($employeeCount);
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $status = AssessmentProcessStatusValue::EVALUATION_SELECTED;
                list($employeeCount, $evaluationCount) = self::processMarkEvaluationSelectedDone($bossId, $assessmentCycle);
                $resultValueObject->setEmployeeCount($employeeCount);
                $resultValueObject->setInvitationCount($evaluationCount);
                break;
            case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $status = AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED;
                $employeeCount = self::processUndoMarkEvaluationSelectedDone($bossId, $assessmentCycle);
                $resultValueObject->setEmployeeCount($employeeCount);
                break;
            case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
                $status = AssessmentProcessStatusValue::EVALUATION_READY;
                break;
            case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
                $status = AssessmentProcessStatusValue::EVALUATION_SELECTED;
                break;
        }
        $resultValueObject->setStatus($status);

        if ($status != AssessmentProcessStatusValue::UNUSED) {
            BossAssessmentProcessService::updateProcessStatus($bossId, $status, $assessmentCycle);
        }
        return array($hasError, $messages, $resultValueObject);
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // processstappen
    //////////////////////////////////////////////////////////////////////////////////////////////////////////

    static function processMarkSelfassessmentComplete(  $bossId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        BaseQueries::startTransaction();

        // alle employees bij de boss opzoeken
        $bossEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_ARRAY);
        $employeeCount = count($bossEmployeeIds);

        // verder werken met kommalijst
        $employeeIds = implode(',', $bossEmployeeIds);

        // van de medewerkers de proces status ophalen, we hoeven alleen de "invited" te hebben
        $employeeAssessmentProcessValueObjects = EmployeeAssessmentProcessService::getValueObjects( $employeeIds,
                                                                                                    AssessmentProcessStatusValue::INVITED,
                                                                                                    $assessmentCycle,
                                                                                                    EmployeeAssessmentProcessService::USE_HASH_ID_AS_KEY);
        $invitationHashIdKeys = array_keys($employeeAssessmentProcessValueObjects);
        $selectedHashIds = implode('","',$invitationHashIdKeys);

        // alle invitations dicht zetten
        // stap 1: dichtzetten uitnodigingen
        $closedCount = EmployeeSelfAssessmentInvitationService::closeInvitationsByHashId($selectedHashIds);

        // stap 2: bereken per score het verschil tussen medewerker en leidinggevende en sla dit op in de ingevulde uitnodiging
        $diffScoreCount = AssessmentProcessService::fillSelfAssessmentDiffScoresByHashId(   $employeeIds,
                                                                                            $selectedHashIds,
                                                                                            $assessmentCycle,
                                                                                            AssessmentInvitationStatusValue::CLOSED);

        // (performance: alleen van de closedInvitations de verdere acties vervolgen.)
        // voorbereiding voor volgende stappen.
        // haal alle afgesloten uitnodigingen op, array met employee als key
        // stap 3: sommeer per uitnodiging de verschillen, hier opgehalen bij de uitnodigingen
        $closedInvitations = EmployeeSelfAssessmentInvitationService::getValueObjects(  $employeeIds,
                                                                                        $assessmentCycle,
                                                                                        AssessmentInvitationStatusValue::CLOSED,
                                                                                        EmployeeSelfAssessmentInvitationService::USE_EMPLOYEE_ID_AS_KEY,
                                                                                        EmployeeSelfAssessmentInvitationService::CALCULATE_SUM_DIFFS);

        $closedInvitationsKeys = array_keys($closedInvitations);
        $selectedEmployeeIds = implode(',',$closedInvitationsKeys);
        if (!empty($selectedEmployeeIds)) {
            // stap 4: sommeer per medewerker van de gesloten uitnodigingen de leidinggevende scores.
            // dit komt terug als een IdValue, som per medewerker, indien gevuld.
            $sumScoreIdValues = AssessmentProcessService::getSumScoreIdValues($selectedEmployeeIds, $assessmentCycle);

            list($minValue, $maxValue) = self::findMinAndMaxValues($sumScoreIdValues);

            foreach($closedInvitations as $closedInvitation) {
                $employeeId = $closedInvitation->getEmployeeId();

                $sumScoreIdValue = $sumScoreIdValues[$employeeId];
                $sumScore = !empty($sumScoreIdValue) ? $sumScoreIdValue->getValue() : NULL;

                $scoreRank = AssessmentProcessScoreRankingValue::NO_RANKING;
                $evaluationRequestStatus = AssessmentProcessEvaluationRequestValue::NOT_REQUESTED;
                // stap 5: eerst de ranking gebaseerd op verschil met leidinggevende
                if ($closedInvitation->getSomDiffScore() >= APPLICATION_ASSESSMENT_SCORE_DIFF_TRESHOLD) {
                    $scoreRank = AssessmentProcessScoreRankingValue::RANKING_DIFF;
                }
                // stap 6: ranking high en dan low
                // stap 7: als in high of low dan request zetten
                if (!is_null($sumScore)) {
                    if ($sumScore == $maxValue) {
                        $scoreRank = AssessmentProcessScoreRankingValue::RANKING_HIGH;
                        $evaluationRequestStatus = AssessmentProcessEvaluationRequestValue::REQUESTED;
                    }
                    if ($sumScore == $minValue) {
                        $scoreRank = AssessmentProcessScoreRankingValue::RANKING_LOW;
                        $evaluationRequestStatus = AssessmentProcessEvaluationRequestValue::REQUESTED;
                    }
                }
                // stap 7: ranking en de scores verwerken in een nieuw employee process record...
                $employeeAssessmentProcess = EmployeeAssessmentProcessService::getValueObject(  $employeeId,
                                                                                                AssessmentProcessStatusValue::INVITED,
                                                                                                $assessmentCycle);
                $employeeAssessmentProcess->setAssessmentDate(          REFERENCE_DATE);
                $employeeAssessmentProcess->setInvitationHashId(        $closedInvitation->getHashId());
                $employeeAssessmentProcess->setAssessmentProcessStatus( AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED);
                $employeeAssessmentProcess->setScoreSum(                $sumScore);
                $employeeAssessmentProcess->setScoreRank(               $scoreRank);
                $employeeAssessmentProcess->setEvaluationRequestStatus( $evaluationRequestStatus);

                //$debugData[] = $employeeAssessmentProcess;

                EmployeeAssessmentProcessService::updateValidated($employeeId, $employeeAssessmentProcess);
            }
        }
        BaseQueries::finishTransaction();

        return array($employeeCount, $closedCount, $diffScoreCount);
    }

    private static function findMinAndMaxValues(Array $sumScoreIdValues)
    {
        $minValue = NULL;
        $maxValue = NULL;

        foreach($sumScoreIdValues as $sumScoreIdValue) {
            $sumScoreValue = $sumScoreIdValue->getValue();
            $minValue = (empty($minValue) || $sumScoreValue < $minValue) ? $sumScoreValue : $minValue;
            $maxValue = (empty($maxValue) || $sumScoreValue > $maxValue) ? $sumScoreValue : $maxValue;
        }

        return array($minValue, $maxValue);
    }

    // via de actie 'undo afronden invullen zelfevaluaties' worden de verwerkte uitnodigingen "open" gezet,
    // en de berekeningen "leeg" gemaakt.
    // dit gebeurt per leidinggevende (zoco)
    static function processUndoSelfassessmentComplete(  $bossId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        BaseQueries::startTransaction();

        // alle employees bij de boss opzoeken
        $bossEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_ARRAY);
        $employeeCount = count($bossEmployeeIds);

        // verder werken met kommalijst
        $employeeIds = implode(',', $bossEmployeeIds);

        // alle medewerker procesStatus ophalen die "AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED" zijn
        $employeeAssessmentProcessValueObjects = EmployeeAssessmentProcessService::getValueObjects( $employeeIds,
                                                                                                    AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                                                                                                    $assessmentCycle,
                                                                                                    EmployeeAssessmentProcessService::USE_HASH_ID_AS_KEY);
        $invitationHashIdKeys = array_keys($employeeAssessmentProcessValueObjects);
        $selectedHashIds = implode('","',$invitationHashIdKeys);

        // alle invitations weer "open" zetten
        EmployeeSelfAssessmentInvitationService::uncloseInvitationsByHashId($selectedHashIds);

        foreach($employeeAssessmentProcessValueObjects as $employeeAssessmentProcess)
        {
            $employeeId = $employeeAssessmentProcess->getEmployeeId();

            $employeeAssessmentProcess->setAssessmentDate(          REFERENCE_DATE);
            //$employeeAssessmentProcess->setInvitationHashId(        $closedInvitation->getHashId());
            $employeeAssessmentProcess->setAssessmentProcessStatus( AssessmentProcessStatusValue::INVITED);
            $employeeAssessmentProcess->setScoreSum(                NULL);
            $employeeAssessmentProcess->setScoreRank(               NULL);
            $employeeAssessmentProcess->setEvaluationRequestStatus( AssessmentProcessEvaluationRequestValue::NOT_REQUESTED);

            EmployeeAssessmentProcessService::updateValidated($employeeId, $employeeAssessmentProcess);

        }
        BaseQueries::finishTransaction();

        return $employeeCount;
    }

    static function processMarkEvaluationSelectedDone(  $bossId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        BaseQueries::startTransaction();

        // alle employees bij de boss opzoeken
        $bossEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_ARRAY);
        $employeeCount = count($bossEmployeeIds);

        // verder werken met kommalijst
        $employeeIds = implode(',', $bossEmployeeIds);

        // alle medewerker procesStatus ophalen, die "AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED" zijn
        $employeeAssessmentProcessValueObjects = EmployeeAssessmentProcessService::getValueObjects( $employeeIds,
                                                                                                    AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                                                                                                    $assessmentCycle,
                                                                                                    EmployeeAssessmentProcessService::USE_QUERY_SORTING);

        $evaluationRequestedCount = 0;
        foreach($employeeAssessmentProcessValueObjects as $employeeAssessmentProcess)
        {
            $employeeId = $employeeAssessmentProcess->getEmployeeId();
            if ($employeeAssessmentProcess->getEvaluationRequestStatus() == AssessmentProcessEvaluationRequestValue::REQUESTED) {
                $evaluationRequestedCount++;
            }

            $employeeAssessmentProcess->setAssessmentDate(          REFERENCE_DATE);
            //$employeeAssessmentProcess->setInvitationHashId(        $closedInvitation->getHashId());
            $employeeAssessmentProcess->setAssessmentProcessStatus( AssessmentProcessStatusValue::EVALUATION_SELECTED);
//            $employeeAssessmentProcess->setScoreSum(                NULL);
//            $employeeAssessmentProcess->setScoreRank(               NULL);
//            $employeeAssessmentProcess->setEvaluationRequestStatus( AssessmentProcessScoreRankingValue::NO_RANKING);
            EmployeeAssessmentProcessService::updateValidated($employeeId, $employeeAssessmentProcess);

        }
        BaseQueries::finishTransaction();

        return array($employeeCount, $evaluationRequestedCount);
    }

    static function processUndoMarkEvaluationSelectedDone(  $bossId,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        BaseQueries::startTransaction();

        // alle employees bij de boss opzoeken
        $bossEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_ARRAY);
        $employeeCount = count($bossEmployeeIds);

        // verder werken met kommalijst
        $employeeIds = implode(',', $bossEmployeeIds);

        // alle medewerker procesStatus ophalen, die "AssessmentProcessStatusValue::EVALUATION_SELECTED" zijn
        $employeeAssessmentProcessValueObjects = EmployeeAssessmentProcessService::getValueObjects( $employeeIds,
                                                                                                    AssessmentProcessStatusValue::EVALUATION_SELECTED,
                                                                                                    $assessmentCycle,
                                                                                                    EmployeeAssessmentProcessService::USE_QUERY_SORTING);

        foreach($employeeAssessmentProcessValueObjects as $employeeAssessmentProcess)
        {
            $employeeId = $employeeAssessmentProcess->getEmployeeId();

            $employeeAssessmentProcess->setAssessmentDate(          REFERENCE_DATE);
            //$employeeAssessmentProcess->setInvitationHashId(        $closedInvitation->getHashId());
            $employeeAssessmentProcess->setAssessmentProcessStatus( AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED);
//            $employeeAssessmentProcess->setScoreSum(                NULL);
//            $employeeAssessmentProcess->setScoreRank(               NULL);
//            $employeeAssessmentProcess->setEvaluationRequestStatus( AssessmentProcessScoreRankingValue::NO_RANKING);
            EmployeeAssessmentProcessService::updateValidated($employeeId, $employeeAssessmentProcess);

        }
        BaseQueries::finishTransaction();

        return $employeeCount;

    }

}


?>
