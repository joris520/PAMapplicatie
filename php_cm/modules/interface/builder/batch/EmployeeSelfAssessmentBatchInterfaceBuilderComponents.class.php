<?php

/**
 * Description of EmployeeSelfAssessmentBatchInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
class EmployeeSelfAssessmentBatchInterfaceBuilderComponents
{

    static function getEmployeesSelectorHtml($selectEmployees)
    {
        global $smarty;
        $template = $smarty->createTemplate('components/select/selectEmployees.tpl');
        $template->assign('hide_functionprofile_option', true);
        $template->assign('hide_department_option', true);
        $template->assign('show_department_option_new', true);
        $template->assign('show_employees_bosses', false);
        $template->assign('show_employees_bosses_new', true);
        $template->assign('show_email_filled_in_filter', true);
        $template->assign('show_assessment_filled_in_filter', true);
        $template->assign('show_assessment_completed_filter', false);
        $template->assign('use_selfassessment_active', false);

        // vullen template
        $selectEmployees->fillComponent($template);
        return $smarty->fetch($template);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // letop, de BossFilterValue::IS_BOSS waarde "misbruiken", dus '' eromheen
    static function getinvitedDetailLink($invitationsCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT)) {
            if ($invitationsCount > 0) {
                $html .= InterfaceBuilder::iconLink('invited_detail',
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardInvitationsDetail(\'' . BossFilterValue::IS_BOSS . '\');',
                                                    ICON_INFO);
            }
        }
        return $html;
    }

    static function getNotCompletedDetailLink($detailCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT)) {
            if ($detailCount > 0) {
                $html .= InterfaceBuilder::iconLink('employee_not_completed_detail',
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_report__dashboardEmployeeNotCompletedDetail(\'' . BossFilterValue::IS_BOSS . '\');',
                                                    ICON_INFO);
            }
        }
        return $html;
    }

}

?>
