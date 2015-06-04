<?php

/**
 * Description of EmployeeAssessmentEvaluationService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/competence/EmployeeAssessmentEvaluationValueObject.class.php');
require_once('modules/model/queries/employee/competence/EmployeeAssessmentEvaluationQueries.class.php');

class EmployeeAssessmentEvaluationService
{
    const SESSION_EMPLOYEE_EVALUATION_DOCUMENT_ID = 'EMPLOYEE_EVALUATION_DOCUMENT_ID';

    static function getValueObject( $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = EmployeeAssessmentEvaluationQueries::getAssessmentEvaluationInPeriod(  $employeeId,
                                                                                        $assessmentCycle->getStartDate(),
                                                                                        $assessmentCycle->getEndDate());
        $assessmentEvaluationData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return EmployeeAssessmentEvaluationValueObject::createWithData($employeeId, $assessmentEvaluationData);
    }

    static function getValueObjectById($employeeId, $assessmentEvaluationId)
    {
        $query = EmployeeAssessmentEvaluationQueries::selectAssessmentEvaluation($employeeId, $assessmentEvaluationId);
        $assessmentEvaluationData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return EmployeeAssessmentEvaluationValueObject::createWithData($employeeId, $assessmentEvaluationData);
    }

    static function getValueObjects($employeeId)
    {
        $valueObjects = array();

        $query = EmployeeAssessmentEvaluationQueries::getAssessmentEvaluations($employeeId);
        while ($assessmentEvaluationData = mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeAssessmentEvaluationValueObject::createWithData($employeeId, $assessmentEvaluationData);
        }

        mysql_free_result($query);

        return $valueObjects;
    }

    static function validate(EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $assessmentEvaluationStatus = $valueObject->getAssessmentEvaluationStatus();

        $attachmentId = $valueObject->getAttachmentId();
        if (empty($attachmentId) && $assessmentEvaluationStatus == AssessmentEvaluationStatusValue::EVALUATION_DONE) {
            $hasError = true;
            $messages[] = TXT_UCF('NO_EVALUATION_ATTACHMENT_SELECTED');
        }

        $assessmentEvaluationDate = $valueObject->getAssessmentEvaluationDate();
        if (empty($assessmentEvaluationDate)) {
            if ($assessmentEvaluationStatus == AssessmentEvaluationStatusValue::EVALUATION_DONE) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_ENTER_AN_EVALUATION_DATE');
            }
        } else {
            // standaard controle op assessmentEvaluationDate
            list($dateHasError, $dateMessages) = AssessmentCycleService::validateInCurrentAssessmentCycle($assessmentEvaluationDate);
            $hasError = $hasError || $dateHasError;
            $messages = array_merge($messages, $dateMessages);
        }
        return array($hasError, $messages);
    }


    static function updateValidated($employeeId,
                                    EmployeeAssessmentEvaluationValueObject $valueObject)
    {
        return EmployeeAssessmentEvaluationQueries::insertAssessmentEvaluation( $employeeId,
                                                                                $valueObject->getAssessmentEvaluationDate(),
                                                                                $valueObject->getAssessmentEvaluationStatus(),
                                                                                $valueObject->getAttachmentId());
    }

    static function remove( $employeeId,
                            $assessmentEvaluationId)
    {
        return EmployeeAssessmentEvaluationQueries::deactivateAssessmentEvaluation( $employeeId,
                                                                                    $assessmentEvaluationId);
    }

    static function storeUploadedEvaluationDocumentId($attachmentId)
    {
        $_SESSION[self::SESSION_EMPLOYEE_EVALUATION_DOCUMENT_ID] = $attachmentId;
    }

    static function retrieveUploadedEvaluationDocumentId()
    {
        return @$_SESSION[self::SESSION_EMPLOYEE_EVALUATION_DOCUMENT_ID];
    }

    static function clearUploadedEvaluationDocumentId()
    {
        unset($_SESSION[self::SESSION_EMPLOYEE_EVALUATION_DOCUMENT_ID]);
    }
}

?>
