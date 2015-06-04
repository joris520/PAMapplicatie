<?php

/**
 * Description of EmployeeAssessmentService
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/employee/competence/EmployeeAssessmentEvaluationService.class.php');
require_once('modules/model/service/assessmentInvitation/EmployeeSelfAssessmentInvitationService.class.php');
require_once('modules/model/queries/employee/competence/EmployeeAssessmentQueries.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentCollection.class.php');


class EmployeeAssessmentService
{

    static function getCollection(  $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        // de assessment ophalen
        $assessmentValueObject                  = self::getValueObject($employeeId, $assessmentCycle);
        // het functioneringsgesprek ophalen
        $assessmentEvaluationValueObject        = EmployeeAssessmentEvaluationService::getValueObject($employeeId, $assessmentCycle);
        // de selfassessment ophalen
        $selfAssessmentInvitationValueObject    = EmployeeSelfAssessmentInvitationService::getValueObject($employeeId, $assessmentCycle);

        return EmployeeAssessmentCollection::create(    $assessmentValueObject,
                                                        $assessmentEvaluationValueObject,
                                                        $selfAssessmentInvitationValueObject);
    }

    static function getValueObject( $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = EmployeeAssessmentQueries::getAssessmentInPeriod(  $employeeId,
                                                                    $assessmentCycle->getStartDate(),
                                                                    $assessmentCycle->getEndDate());
        $assessmentData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return EmployeeAssessmentValueObject::createWithData($employeeId, $assessmentData);
    }

    static function getValueObjectById($employeeId, $assessmentId)
    {
        $query = EmployeeAssessmentQueries::selectAssessment($employeeId, $assessmentId);
        $assessmentData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return EmployeeAssessmentValueObject::createWithData($employeeId, $assessmentData);

    }

    static function getValueObjects($employeeId)
    {
        $valueObjects = array();

        $query = EmployeeAssessmentQueries::getAssessments($employeeId);
        while ($assessmentData = mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeAssessmentValueObject::createWithData($employeeId, $assessmentData);
        }

        mysql_free_result($query);

        return $valueObjects;
    }

    static function validate(EmployeeAssessmentValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        if (!ScoreStatusValue::isValidValue($valueObject->getScoreStatus())) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_SCORE_STATUS');
        }
        $assessmentDate = $valueObject->getAssessmentDate();
        if (empty($assessmentDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_CONVERSATION_DATE');
        } else {
            // standaard controle op assessmentDate
            list($dateHasError, $dateMessages) = AssessmentCycleService::validateInCurrentAssessmentCycle($assessmentDate);
            $hasError = $hasError || $dateHasError;
            $messages = array_merge($messages, $dateMessages);
        }
        return array($hasError, $messages);
    }


    static function updateValidated($employeeId,
                                    EmployeeAssessmentValueObject $valueObject)
    {
        return EmployeeAssessmentQueries::insertAssessment( $employeeId,
                                                            $valueObject->getAssessmentDate(),
                                                            $valueObject->getScoreStatus(),
                                                            $valueObject->getAssessmentNote());
    }

    static function indicateNewSelfassessmentInvitation($employeeId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $employeeAssessment = self::getValueObject($employeeId, $assessmentCycle);
        $employeeAssessment->setAssessmentDate( DateUtils::getCurrentDatabaseDate());
        $employeeAssessment->setScoreStatus(    ScoreStatusValue::PRELIMINARY);
        $employeeAssessment->setAssessmentNote( TXT_UCF('SCORE_STATUS_TO_PRELIMINARY_DUE_TO_INVITATION_FOR_SELF_ASSESSMENT'));
        self::updateValidated($employeeId, $employeeAssessment);
    }


}

?>
