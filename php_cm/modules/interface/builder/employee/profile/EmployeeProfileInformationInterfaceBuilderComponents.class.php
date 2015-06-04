<?php

/**
 * Description of EmployeeProfileInformationInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeProfileInformationInterfaceBuilderComponents
{
    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_INFORMATION)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_profileinformation_' . $employeeId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_employeeProfile__editInformation(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

}

?>
