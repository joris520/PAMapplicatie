<?php

/**
 * Description of DepartmentInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class DepartmentInterfaceBuilderComponents
{
    static function getAddLink($permission)
    {
        $html = '';
        if (PermissionsService::isAddAllowed($permission)) {
            $html .= InterfaceBuilder::iconLink('add_department',
                                                TXT_UCF('ADD'),
                                                'xajax_public_organisation__addDepartment();',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($departmentId,
                                $permission)
    {
        $html = '';
        if (PermissionsService::isEditAllowed($permission)) {
            $html .= InterfaceBuilder::iconLink('edit_department_' . $departmentId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_organisation__editDepartment(' . $departmentId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink(  $departmentId,
                                    $permission)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed($permission)) {
            $html .= InterfaceBuilder::iconLink('delete_department_' . $departmentId,
                                                TXT_UCF('DELETE'),
                                                'xajax_public_organisation__removeDepartment(' . $departmentId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }



    static function getEmployeeInfoLink($departmentId, $employeeCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
            if ($employeeCount > 0) {
                $html .= InterfaceBuilder::iconLink('detail_department_employees_' . $departmentId,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_organisation__detailDepartmentEmployees(' . $departmentId . ');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }

    static function getDepartmentInfoLink($departmentId, $userCount)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_USERS)) {
            if ($userCount > 0) {
                $html .= InterfaceBuilder::iconLink('detail_department_userss_' . $departmentId,
                                                    TXT_UCF('ADDITIONAL_INFO'),
                                                    'xajax_public_organisation__detailDepartmentUsers(' . $departmentId . ');',
                                                    ICON_INFO);
            } else {
                $html .= ApplicationInterfaceBuilder::NO_ICON_LINK_SPACES; // hack ivm uitlijning
            }
        }
        return $html;
    }


}

?>
