<?php


/**
 * Description of EmployeeAssessmentInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeAssessmentInterfaceBuilderComponents
{
    static function getAddLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $html .= InterfaceBuilder::iconLink('add_employee_assessment_' . $employeeId ,
                                                TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT'),
                                                'xajax_public_employeeCompetence__addAssessment(' . $employeeId . ');',
                                                ICON_EDIT); // dit hoort zo
        }
        return $html;
    }

    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_assessment_' . $employeeId,
                                                TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT'),
                                                'xajax_public_employeeCompetence__editAssessment(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getHistoryLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES) &&
            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $html .= InterfaceBuilder::iconLink('view_employee_assessment_history_' . $employeeId ,
                                                TXT_UCF('HISTORY'),
                                                'xajax_public_employeeCompetence__displayHistoryAssessment(' . $employeeId . ');',
                                                ICON_HISTORY);
        }
        return $html;
    }

    static function getResendInvitationLink($employeeId, $hashId, $resendPossible)
    {
        $html = '';
        if (PermissionsService::isExecuteAllowed(PERMISSION_EMPLOYEE_RESEND_SELF_ASSESSMENT_INVITATION) && $resendPossible) {
            $html .= InterfaceBuilder::iconLink('resent_employee_invitation_self_assessment_' . $employeeId ,
                                                TXT_UCF('RESEND_SELF_ASSESSMENT_INVITATION'),
                                                'xajax_public_employeeCompetence__resendSelfAssessmentInvitation(' . $employeeId . ', \'' . $hashId . '\');',
                                                ICON_INVITE);
        }
        return $html;
    }
}

?>
