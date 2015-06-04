<?php

/**
 * Description of EmployeeAssessmentProcessService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/employee/assessmentAction/EmployeeAssessmentProcessQueries.class.php');
require_once('modules/model/valueobjects/employee/assessmentAction/EmployeeAssessmentProcessValueObject.class.php');

require_once('modules/model/value/assessmentProcess/AssessmentProcessScoreRankingValue.class.php');
require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');
require_once('modules/model/value/assessmentProcess/AssessmentProcessEvaluationRequestValue.class.php');

class EmployeeAssessmentProcessService
{
    const USE_QUERY_SORTING         = 'query';
    const USE_EMPLOYEE_ID_AS_KEY    = 'employee';
    const USE_HASH_ID_AS_KEY        = 'hashid';

    static function getValueObject( $employeeId,
                                    /* AssessmentProcessStatusValue */ $assessmentProcessStatus,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = EmployeeAssessmentProcessQueries::getAssessmentProcessInPeriod($employeeId,
                                                                                $assessmentProcessStatus,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate());
        $assessmentProcessData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return EmployeeAssessmentProcessValueObject::createWithData($employeeId, $assessmentProcessData);
    }

    static function getValueObjects($selectedEmployeeIds,
                                    /* AssessmentProcessStatusValue */ $assessmentProcessStatus,
                                    AssessmentCycleValueObject $assessmentCycle,
                                    $useEmployeeAsKey = self::USE_QUERY_SORTING)
    {
        $valueObjects = array();
        if (!empty($selectedEmployeeIds)) {
            $query = EmployeeAssessmentProcessQueries::getAssessmentProcessInPeriod($selectedEmployeeIds,
                                                                                    $assessmentProcessStatus,
                                                                                    $assessmentCycle->getStartDate(),
                                                                                    $assessmentCycle->getEndDate());
            while ($assessmentProcessData = mysql_fetch_assoc($query)) {

                $valueObject = EmployeeAssessmentProcessValueObject::createWithEmployeeData($assessmentProcessData);

                if ($valueObject->hasInvitationHashId()) {
                    if ($useEmployeeAsKey == self::USE_EMPLOYEE_ID_AS_KEY) {
                        $valueObjects[$valueObject->getEmployeeId()] = $valueObject;
                    } elseif ($useEmployeeAsKey == self::USE_HASH_ID_AS_KEY) {
                        $valueObjects[$valueObject->getInvitationHashId()] = $valueObject;
                    } else {
                        $valueObjects[] = $valueObject;
                    }
                }
            }
            mysql_free_result($query);
        }
        return $valueObjects;
    }

    static function updateValidated($employeeId,
                                    EmployeeAssessmentProcessValueObject $valueObject)
    {
        return EmployeeAssessmentProcessQueries::insertAssessmentProcess(   $employeeId,
                                                                            $valueObject->getInvitationHashId(),
                                                                            $valueObject->getAssessmentDate(),
                                                                            $valueObject->getAssessmentProcessStatus(),
                                                                            $valueObject->getScoreSum(),
                                                                            $valueObject->getScoreRank(),
                                                                            $valueObject->getEvaluationRequestStatus());
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // processstappen: zie BossAssessmentProcessService
    //////////////////////////////////////////////////////////////////////////////////////////////////////////


    // bij het aanmaken van een uitnodiging voor zelfevaluatie moet dit ook in het assessment process geregistreerd worden.
    static function indicateNewSelfassessmentInvitation($employeeId,
                                                        $invitationHashId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $employeeAssessmentProcess = self::getValueObject(  $employeeId,
                                                            AssessmentProcessStatusValue::GET_ALL_PROCESS_STATES,
                                                            $assessmentCycle);
        $employeeAssessmentProcess->setInvitationHashId(        $invitationHashId);
        $employeeAssessmentProcess->setAssessmentDate(          DateUtils::getCurrentDatabaseDate());
        $employeeAssessmentProcess->setAssessmentProcessStatus( AssessmentProcessStatusValue::INVITED);
        $employeeAssessmentProcess->setScoreSum(                0);
        $employeeAssessmentProcess->setScoreRank(               AssessmentProcessScoreRankingValue::NO_RANKING);
        $employeeAssessmentProcess->setEvaluationRequestStatus( AssessmentProcessEvaluationRequestValue::NOT_REQUESTED);
        self::updateValidated($employeeId, $employeeAssessmentProcess);
    }

    static function updateEvaluationRequestStatus($employeeId, $employeeAssessmentProcessId, $evaluationRequestStatus)
    {
        return EmployeeAssessmentProcessQueries::updateEvaluationRequestStatus($employeeId, $employeeAssessmentProcessId, $evaluationRequestStatus);
    }
}

?>
