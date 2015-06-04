<?php

/**
 * Description of EmployeeSelfAssessmentInvitationController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/assessmentInvitation/EmployeeSelfAssessmentInvitationService.class.php');

class EmployeeSelfAssessmentInvitationController
{
    static function processResendInvitation($employeeId, $resendHashId, $currentHashId)
    {
        $hasError = true;
        $messages = array();

        BaseQueries::startTransaction();

        $hasError = $resendHashId != $currentHashId;
        if (!$hasError) {

            $resendCount = EmployeeSelfAssessmentInvitationService::resendInvitation($employeeId, $resendHashId);
            $hasError = $resendCount != 1;

            if (!$hasError) {
                BaseQueries::finishTransaction();
            }
        }
        if ($hasError) {
            $messages[] = TXT_UCF('THIS_INVITATION_CANNOT_BE_RESEND');
        }
        return array($hasError, $messages);
    }
}

?>
