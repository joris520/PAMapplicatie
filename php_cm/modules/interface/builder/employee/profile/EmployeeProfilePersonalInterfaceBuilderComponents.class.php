<?php

/**
 * Description of EmployeeProfilePersonalInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeProfilePersonalInterfaceBuilderComponents
{
    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_profilepersonal_' . $employeeId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_employeeProfile__editPersonal(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getEditPhotoLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
            $html .= InterfaceBuilder::iconLink('upload_employee_photo_' . $employeeId,
                                                TXT_UCF('UPLOAD_PHOTO_THUMBNAIL'),
                                                'xajax_public_employeeProfile__uploadPhoto(' . $employeeId . ');',
                                                ICON_PHOTO);
        }
        return $html;
    }

    static function getAddPhotoUrl($employeeId)
    {
        $url = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
            $url .= 'xajax_public_employeeProfile__uploadPhoto(' . $employeeId . ');';
        }
        return $url;
    }

    static function getDeletePhotoLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
            $html .= InterfaceBuilder::iconLink('delete_employee_photo_' . $employeeId,
                                                TXT_UCF('REMOVE_PHOTO_THUMBNAIL'),
                                                'xajax_public_employeeProfile__removePhoto(' . $employeeId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

}

?>
