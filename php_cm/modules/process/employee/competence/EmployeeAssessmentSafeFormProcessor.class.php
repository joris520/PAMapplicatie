<?php

/**
 * Description of EmployeeAssessmentSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/competence/EmployeeCompetenceController.class.php');
require_once('modules/model/service/assessmentInvitation/EmployeeSelfAssessmentInvitationController.class.php');

class EmployeeAssessmentSafeFormProcessor
{
    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {

            $employeeId     = $safeFormHandler->retrieveSafeValue('employeeId');
            $isEditAllowedScoreStatus = $safeFormHandler->retrieveSafeValue('isEditAllowedScoreStatus');


            // TODO: oplossen zoals bij targets

            // de score_status moet wel bewaard blijven als er geen rechten op staan.
            if (!$isEditAllowedScoreStatus) { // nu nog eigenlijk hetzelfde...
                $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();
                $valueObject = EmployeeAssessmentService::getValueObject($employeeId, $currentAssessmentCycle);
                $scoreStatus = $valueObject->getScoreStatus();
                $assessmentNote = NULL;
            } else {
                $scoreStatus = $safeFormHandler->retrieveInputValue('score_status');
                $assessmentNote = $safeFormHandler->retrieveInputValue('assessment_note');
            }
            $assessmentDate = $safeFormHandler->retrieveDateValue('assessment_date');



            if (empty($scoreStatus)) {
                $scoreStatus = ScoreStatusValue::PRELIMINARY;
            }

            $valueObject = EmployeeAssessmentValueObject::createWithValues( $employeeId,
                                                                            $assessmentDate,
                                                                            $scoreStatus,
                                                                            $assessmentNote);

            list($hasError, $messages) = EmployeeCompetenceController::processEditAssessment(   $employeeId,
                                                                                                $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishEditAssessment( $objResponse,
                                                                            $employeeId);
            }
        }
        return array($hasError, $messages);
    }

    static function processResend($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isExecuteAllowed(PERMISSION_EMPLOYEE_RESEND_SELF_ASSESSMENT_INVITATION)) {

            $employeeId     = $safeFormHandler->retrieveSafeValue('employeeId');
            $resendHashId   = $safeFormHandler->retrieveSafeValue('requestedHashId');
            $currentHashId  = $safeFormHandler->retrieveSafeValue('currentHashId');

            list($hasError, $messages) = EmployeeSelfAssessmentInvitationController::processResendInvitation($employeeId, $resendHashId, $currentHashId);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishResendSelfAssessmentInvitation($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
