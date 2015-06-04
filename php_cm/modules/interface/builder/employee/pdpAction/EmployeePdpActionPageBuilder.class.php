<?php

/**
 * Description of EmployeePdpActionPageBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/pdpAction/EmployeePdpActionInterfaceBuilder.class.php');

class EmployeePdpActionPageBuilder
{
    static function getPageHtml($displayWidth,
                                $employeeId,
                                EmployeeInfoValueObject $employeeInfoValueObject)
    {

        return  EmployeePdpActionInterfaceBuilder::getEmployeeInfoHeaderHtml(   $displayWidth,
                                                                                $employeeId,
                                                                                $employeeInfoValueObject) .
                EmployeePdpActionInterfaceBuilder::getActionsHtml(              $displayWidth,
                                                                                $employeeId ) .

                EmployeePdpActionInterfaceBuilder::getViewHtml(                 $displayWidth,
                                                                                $employeeId);
    }

    static function getAddPopupHtml($displayWidth,
                                    $contentHeight,
                                    $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeePdpActionInterfaceBuilder::getAddHtml(   $displayWidth,
                                                                                                $employeeId);

        // popup
        $title = TXT_UCF('ADD_PDP_ACTION');
        $formId = 'add_employee_pdpaction_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getAddPopupHtml($formId,
                                                            $safeFormHandler,
                                                            $title,
                                                            $contentHtml,
                                                            $displayWidth,
                                                            $contentHeight);
    }

    static function getEditPopupHtml(   $displayWidth,
                                        $contentHeight,
                                        $employeeId,
                                        $employeePdpActionId)
    {
        list($safeFormHandler, $contentHtml) = EmployeePdpActionInterfaceBuilder::getEditHtml(  $displayWidth,
                                                                                                $employeeId,
                                                                                                $employeePdpActionId);

        // popup
        $title = TXT_UCF('EDIT_PDP_ACTION');
        $formId = 'edit_employee_pdpaction_form_' . $employeeId . '_' . $employeePdpActionId;
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight);
    }


    static function getRemovePopupHtml( $displayWidth,
                                        $contentHeight,
                                        $employeeId,
                                        $employeePdpActionId)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE_PDP_ACTION');

        list($safeFormHandler, $contentHtml) = EmployeePdpActionInterfaceBuilder::getRemoveHtml($displayWidth,
                                                                                                $employeeId,
                                                                                                $employeePdpActionId);

        // popup
        $formId = 'remove_employee_pdpaction_form_' . $employeeId . '_' . $employeeDocumentId;
        $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml(   $formId,
                                                                        $safeFormHandler,
                                                                        $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        $contentHeight);
        return $popupHtml;
    }

    static function getPdpActionLibraryHtml($displayWidth,
                                            $contentHeight,
                                            $employeePdpActionId = NULL)
    {
        return EmployeePdpActionInterfaceBuilder::getPdpActionLibraryHtml(  $displayWidth,
                                                                            $contentHeight,
                                                                            $employeePdpActionId);
    }

    static function getEditUserDefinedPopupHtml($displayWidth,
                                                $contentHeight,
                                                EmployeePdpActionUserDefinedValueObject $valueObject)
    {
        // tijdelijke hack om toch iets te kunnen editen...
        list($safeFormHandler, $contentHtml) = EmployeePdpActionInterfaceBuilder::getEditUserDefinedHtml(   $displayWidth,
                                                                                                            $valueObject);

        // popup
        $title = TXT_UCF('EDIT_USER_DEFINED_PDP_ACTION');
        $formId = 'edit_user_defined_pdpaction_form_' . $employeeId . '_' . $employeePdpActionId;
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight);
    }



}

?>
