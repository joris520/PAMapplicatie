<?php

/**
 * Description of EmployeeProfileOrganisationInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeProfileOrganisationInterfaceBuilderComponents
{
    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_ORGANISATION)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_profileorganisation_' . $employeeId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_employeeProfile__editOrganisation(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

}

?>
