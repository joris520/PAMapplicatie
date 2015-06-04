<?php

/**
 * Description of EmployeeJobProfileInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeJobProfileInterfaceBuilderComponents
{
    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_job_profile_' . $employeeId ,
                                                TXT_UCF('EDIT') . ' ' . TXT_LC('JOB_PROFILE'),
                                                'xajax_public_employeeCompetence__editJobProfile(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getHistoryLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE) &&
            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $html .= InterfaceBuilder::iconLink('view_employee_job_profile_history_' . $employeeId ,
                                                TXT_UCF('HISTORY'),
                                                'xajax_public_employeeCompetence__displayHistoryJobProfile(' . $employeeId . ');',
                                                ICON_HISTORY);
        }
        return $html;
    }

}

?>
