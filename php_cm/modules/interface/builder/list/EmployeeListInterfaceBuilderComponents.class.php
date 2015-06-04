<?php

/**
 * Description of EmployeeListInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
require_once('application/model/service/CustomerService.class.php');

class EmployeeListInterfaceBuilderComponents
{

    static function getAddLink()
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
            list($isAddPossible, $employeeHeadroom) = CustomerService::isAddEmployeePossible();

            $html .= InterfaceBuilder::iconLink('add_employee',
                                                $isAddPossible ? TXT_UCF_VALUE('ADD_NEW_EMPLOYEE_WITH_NUMBER_POSSIBLE', array($employeeHeadroom)) : TXT_UCF('MAXIMUM_NUMBER_OF_EMPLOYEE_ALLOWED_EXCEEDED'),
                                                'xajax_public_employeeList__addEmployee();',
                                                $isAddPossible ? ICON_ADD : ICON_NOADD);
        }
        return $html;
    }

    // TODO: andere functie!
    static function getSelectOnClick($employeeId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_MODULE_EMPLOYEES)) {
            $html .= 'xajax_moduleEmployees_checkTab_deprecated(' . $employeeId . ');';
        }
        return $html;
    }

    // TODO: andere functie!
    static function getEvaluationSelectOnClick($employeeId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_MODULE_EMPLOYEES)) {
            $html .= 'xajax_public_assessmentProcess__toggleEvaluationInvited(' . $employeeId . ', this.checked);';
        }
        return $html;
    }

    static function getDeleteLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PROFILE) &&
            $employeeId != EMPLOYEE_ID) { // maar niet jezelf weggooien!
            $html .= InterfaceBuilder::iconLink('archive_employee_' . $employeeId,
                                                TXT_UCF('DELETE') . ' ' . TXT_LC('EMPLOYEE'),
                                                'xajax_public_employeeList__archiveEmployee(' . $employeeId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

}

?>
