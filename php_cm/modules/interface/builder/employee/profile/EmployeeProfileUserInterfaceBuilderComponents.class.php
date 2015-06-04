<?php

/**
 * Description of EmployeeProfileUserInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeProfileUserInterfaceBuilderComponents
{
    static function getAddLink($employeeId, $hasUser)
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_USERS) && !$hasUser) {
            $html .= InterfaceBuilder::iconLink('add_employee_profile_user_' . $employeeId,
                                                TXT_UCF('ADD'),
                                                'xajax_public_employeeProfile__addUser(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }
}

?>
