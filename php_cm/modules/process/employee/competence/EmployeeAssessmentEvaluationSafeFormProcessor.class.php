<?php


/**
 * Description of EmployeeAssessmentEvaluationSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/competence/EmployeeCompetenceController.class.php');
require_once('modules/model/service/library/AssessmentCycleService.class.php');

class EmployeeAssessmentEvaluationSafeFormProcessor
{

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {

            $employeeId = $safeFormHandler->retrieveSafeValue('employeeId');

            $assessmentEvaluationDate   = $safeFormHandler->retrieveDateValue('assessment_evaluation_date');
            $assessmentEvaluationStatus = $safeFormHandler->retrieveInputValue('assessment_evaluation_status');
            // de bijlageid wordt via de sessie doorgegeven omdat het upload form in een frame moet zitten
            $attachmentId  = EmployeeAssessmentEvaluationService::retrieveUploadedEvaluationDocumentId();

            $valueObject = EmployeeAssessmentEvaluationValueObject::createWithValues(   $employeeId,
                                                                                        $assessmentEvaluationDate,
                                                                                        $assessmentEvaluationStatus,
                                                                                        $attachmentId);

            $currentAssessmentCycle = AssessmentCycleService::getCurrentValueObject();
            list($hasError, $messages) = EmployeeCompetenceController::processEditAssessmentEvaluation( $employeeId,
                                                                                                        $valueObject,
                                                                                                        $currentAssessmentCycle);
            if (!$hasError) {
                // de bijlageid wissen
                EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishEditAssessmentEvaluation(   $objResponse,
                                                                                        $employeeId);
            }
        }

        return array($hasError, $messages);
    }

    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE)) {
            $employeeId = $safeFormHandler->retrieveSafeValue('employeeId');
            $assessmentEvaluationId = $safeFormHandler->retrieveSafeValue('assessmentEvaluationId');

            list($hasError, $messages) = EmployeeCompetenceController::processRemoveAssessmentEvaluation($employeeId, $assessmentEvaluationId);
            if (!$hasError) {
                // de bijlageid wissen
                EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishRemove($objResponse, $employeeId);
            }
        }

        return array($hasError, $messages);
    }


}

?>
