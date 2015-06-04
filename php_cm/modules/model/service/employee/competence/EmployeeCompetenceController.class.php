<?php

/**
 * Description of EmployeeCompetenceController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAnswerService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentEvaluationService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentService.class.php');
require_once('modules/model/service/employee/competence/EmployeeJobProfileService.class.php');
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/print/service/employee/EmployeePrintService.class.php');

class EmployeeCompetenceController
{
    static function processEditAnswers( $employeeId,
                                        /* array of EmployeeAnswerValueObject */ $answerValueObjects)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        // de antwoorden valideren
        foreach ($answerValueObjects as $employeeAnswerValueObject) {
            list($answerHasError, $answerMessages) = EmployeeAnswerService::validateAnswer($employeeAnswerValueObject);
            $hasError = $hasError || $answerHasError;
            $messages = array_merge($messages, $answerMessages);
        }
        if (!$hasError) {
            foreach ($answerValueObjects as $employeeAnswerValueObject) {
                EmployeeAnswerService::updateValidated($employeeId, $employeeAnswerValueObject);
            }

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processEditAssessmentEvaluation($employeeId,
                                                    EmployeeAssessmentEvaluationValueObject $valueObject,
                                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();
        list($hasError, $messages) = EmployeeAssessmentEvaluationService::validate($valueObject);
        if (!$hasError) {
            EmployeeAssessmentEvaluationService::updateValidated($employeeId, $valueObject);

            if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
                $employeeAssessmentProcess = EmployeeAssessmentProcessService::getValueObject(  $employeeId,
                                                                                                AssessmentProcessStatusValue::GET_ALL_PROCESS_STATES,
                                                                                                $assessmentCycle);
//            $assessmentProcessStatus = $employeeAssessmentProcess->getAssessmentProcessStatus();
//            if ($assessmentProcessStatus == AssessmentProcessStatusValue::EVALUATION_SELECTED) {
//                $employeeAssessmentProcess->setAssessmentDate(          $valueObject->getAssessmentDate());
//                //$employeeAssessmentProcess->setInvitationHashId(        $closedInvitation->getHashId());
//                $employeeAssessmentProcess->setAssessmentProcessStatus( AssessmentProcessStatusValue::EVALUATION_SELECTED);
//                EmployeeAssessmentProcessService::updateValidated($employeeId, $employeeAssessmentProcess);
//
            }
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processRemoveAssessmentEvaluation(  $employeeId,
                                                        $assessmentEvaluationId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        EmployeeAssessmentEvaluationService::remove($employeeId,
                                                    $assessmentEvaluationId);
        // klaar met delete

        BaseQueries::finishTransaction();

        return array($hasError, $messages);
    }

    static function processEditAssessment(  $employeeId,
                                            EmployeeAssessmentValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeAssessmentService::validate($valueObject);

        if (!$hasError) {
            if ($valueObject->getScoreStatus() == ScoreStatusValue::FINALIZED) {
                $currentAssessmentCycle = AssessmentCycleService::getCurrentValueObject();
                $hasCompleteScores = EmployeeCompetenceService::hasCompleteScores(  $employeeId,
                                                                                    $currentAssessmentCycle);
                if (!$hasCompleteScores) {
                    $hasError = true;
                    $messages[] = TXT_UCF('THE_ASSESSMENT_CANNOT_BE_FINALIZED_BECAUSE_NOT_ALL_REQUIRED_SCORES_ARE_COMPLETED');
                }
            }
        }

        if (!$hasError) {
            EmployeeAssessmentService::updateValidated( $employeeId,
                                                        $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processEditJobProfile(  $employeeId,
                                            EmployeeJobProfileValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();
        list($hasError, $messages) = EmployeeJobProfileService::validate($valueObject);
        if (!$hasError) {
            EmployeeJobProfileService::updateValidated( $employeeId,
                                                        $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processEditScores($employeeId,
                                      Array /* of EmployeeScoreValueObject */  $scoreValueObjects)
    {
        $hasError = false;
        $messages = array();
        $scoresMessages = array();

        BaseQueries::startTransaction();

        // de antwoorden valideren
        foreach ($scoreValueObjects as $employeeScoreValueObject) {
            $competenceValueObject = $employeeScoreValueObject->getCompetenceValueObject();
            list($scoreHasError, $scoreMessages) = EmployeeScoreService::validateScore( $employeeScoreValueObject,
                                                                                        $competenceValueObject->getCompetenceName(),
                                                                                        $competenceValueObject->getCompetenceScaleType(),
                                                                                        $competenceValueObject->getCompetenceIsOptional());
            $hasError       = $hasError || $scoreHasError;
            $scoresMessages = array_merge($scoresMessages, $scoreMessages);
        }

        if (count($scoresMessages) > 0) {
            $scoresMessage = TXT_UCF('PLEASE_ENTER_A_VALUE_FOR_THE_SCORES') . ' : <br />' . implode('<br />', $scoresMessages);
            $messages[] = $scoresMessage;
        }

        if (!$hasError) {
            foreach ($scoreValueObjects as $employeeScoreValueObject) {
                EmployeeScoreService::updateValidated($employeeId, $employeeScoreValueObject);
            }

            BaseQueries::finishTransaction();
        }

        return array($hasError, $messages);
    }

    static function processPrintOptions( Array $employeeIds,
                                         $showRemarks,
                                         $showThreesixty,
                                         $showPdpAction )
    {
        list($hasError, $messages) = EmployeeCompetenceService::validatePrintOptions( $showRemarks,
                                                                                      $showThreesixty,
                                                                                      $showPdpAction );

        if (!$hasError) {
            $printOptions = array(EmployeeModulePrintOption::OPTION_COMPETENCE);
            $printOptionsValueObject = EmployeePrintOptionValueObject::create($employeeIds, $printOptions);
            EmployeePrintService::storePrintOptionValueObject($printOptionsValueObject);
//            EmployeePrintService::storeOptionShowEmployeeCompetenceRemarks(    $showRemarks);
//            EmployeePrintService::storeOptionShowEmployeeCompetenceThreesixty( $showThreesixty);
//            EmployeePrintService::storeOptionShowEmployeeCompetenceAction(     $showPdpAction);
        }
        return array($hasError, $messages);
    }
}

?>
