<?php

/**
 * Description of EmployeeTargetInterfaceBuilderComponents
 *
 * @author hans.prins
 */

require_once('application/interface/InterfaceBuilder.class.php');

class EmployeeTargetInterfaceBuilderComponents
{
    static function getAddLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
            $html .= InterfaceBuilder::iconLink('add_employee_target',
                                                TXT_LC('ADD') . ' ' . TXT_UCF('TARGET'),
                                                'xajax_public_employeeTarget__addEmployeeTarget(' . $employeeId . ');',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($employeeId, $employeeTargetId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS) || PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_target_' . $employeeTargetId,
                                                TXT_LC('EDIT') . ' ' . TXT_UCF('TARGET'),
                                                'xajax_public_employeeTarget__editEmployeeTarget(' . $employeeId . ',' . $employeeTargetId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getDeleteLink($employeeId, $employeeTargetId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
            $html .= InterfaceBuilder::iconLink('delete_employee_target_' . $employeeTargetId,
                                                TXT_LC('DELETE') . ' ' . TXT_UCF('TARGET'),
                                                'xajax_public_employeeTarget__removeEmployeeTarget(' . $employeeId . ',' . $employeeTargetId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

    static function getHistoryLink($employeeId, $employeeTargetId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGETS) &&
            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
            $html .= InterfaceBuilder::iconLink('history_employee_target_' . $employeeTargetId,
                                                TXT_UCF('HISTORY'),
                                                'xajax_public_employeeTarget__historyEmployeeTarget(' . $employeeId . ',' . $employeeTargetId . ');',
                                                ICON_HISTORY);
        }
        return $html;
    }

//    static function getPrintLink($employeeId)
//    {
//        $html = '';
//        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
//
//            $html .= InterfaceBuilder::iconLink('print_employee',
//                                                TXT_UCF('PRINT'),
////                                                'xajax_public_employeeTarget__displayPrintOptions(' . $employeeId . ');',
//                                                'xajax_public_employeePrint__displayPrintOptions(' . $employeeId . ');',
//                                                ICON_PRINT);
//
//        }
//        return $html;
//    }
}

?>
