<?php

/**
 * Description of EmployeePdpActionInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/pdpAction/EmployeePdpActionPageBuilder.class.php');

class EmployeePdpActionInterfaceProcessor
{
    const DISPLAY_WIDTH         = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const EDIT_WIDTH            = 800; //ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const EDIT_CONTENT_HEIGHT   = 550;
    const REMOVE_DIALOG_WIDTH   = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const REMOVE_CONTENT_HEIGHT = 200;

    const PDP_ACTION_LIBRARY_WIDTH  = 650;
    const PDP_ACTION_LABEL_WIDTH    = 100;
    const PDP_ACTION_LIBRARY_HEIGHT = 200;

    static function displayView( xajaxResponse $objResponse,
                                 $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {

                $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);

                // omdat de verdere refactoring van de EmployeePdpActions nog niet is gedaan,
                // eerst gewoon gebruik maken van de code in employees_pdpactions_deprecated...

                //
                // of collectie...
//                $valueObjects = EmployeeDocumentService::getValueObjects(    $employeeId);

                $viewHtml = EmployeePdpActionPageBuilder::getPageHtml(  self::DISPLAY_WIDTH,
                                                                        $employeeId,
                                                                        $employeeInfoValueObject);
            }
            EmployeesTabInterfaceProcessor::displayContent( $objResponse,
                                                            $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu(    $objResponse,
                                                            $employeeId,
                                                            MODULE_EMPLOYEE_PDP_ACTIONS);
        }

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function displayAdd( xajaxResponse $objResponse,
                                $employeeId)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $popupHtml = EmployeePdpActionPageBuilder::getAddPopupHtml( self::EDIT_WIDTH,
                                                                        self::EDIT_CONTENT_HEIGHT,
                                                                        $employeeId);
            InterfaceXajax::showAddDialog(  $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::EDIT_CONTENT_HEIGHT);
        }
    }

    static function finishAdd(  xajaxResponse $objResponse,
                                $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function displayEdit(xajaxResponse $objResponse,
                                $employeeId,
                                $employeePdpActionId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $popupHtml = EmployeePdpActionPageBuilder::getEditPopupHtml(self::EDIT_WIDTH,
                                                                        self::EDIT_CONTENT_HEIGHT,
                                                                        $employeeId,
                                                                        $employeePdpActionId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::EDIT_CONTENT_HEIGHT);
        }
    }

    static function finishEdit( xajaxResponse $objResponse,
                                $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function displayRemove(  xajaxResponse $objResponse,
                                    $employeeId,
                                    $employeePdpActionId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            if (empty($employeeId)) {
                $popupHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {
                $popupHtml = EmployeePdpActionPageBuilder::getRemovePopupHtml(  self::REMOVE_DIALOG_WIDTH,
                                                                                self::REMOVE_CONTENT_HEIGHT,
                                                                                $employeeId,
                                                                                $employeePdpActionId);
            }
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::REMOVE_DIALOG_WIDTH,
                                                self::REMOVE_CONTENT_HEIGHT);

        }

    }

    static function finishRemove(   xajaxResponse $objResponse,
                                    $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }


    static function togglePdpActionLibraryVisibility(   xajaxResponse $objResponse,
                                                        $toggleMode)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $newToggleMode = $toggleMode == EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_SHOW ?
                                            EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_HIDE :
                                            EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_SHOW;
            $toggleLink = EmployeePdpActionInterfaceBuilderComponents::getTogglePdpActionLibraryLink(   $newToggleMode);
            // de link aanpassen
            InterfaceXajax::setHtml($objResponse,
                                    EmployeePdpActionInterfaceBuilder::EDIT_HTML_PDP_LIBRARY_TOGGLE_HTML_ID,
                                    $toggleLink);
            // en de content togglen
            InterfaceXajax::toggleVisibility(   $objResponse,
                                                EmployeePdpActionInterfaceBuilder::EDIT_HTML_PDP_LIBRARY_CONTENT_HTML_ID);

        }
    }

    static function toggleCompetencesVisibility(   xajaxResponse $objResponse,
                                                   $toggleMode)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $newToggleMode = $toggleMode == EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_SHOW ?
                                            EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_HIDE :
                                            EmployeePdpActionInterfaceBuilderComponents::TOGGLE_MODE_SHOW;
            $toggleLink = EmployeePdpActionInterfaceBuilderComponents::getToggleCompetencesLink($newToggleMode);
            // de link aanpassen
            InterfaceXajax::setHtml($objResponse,
                                    EmployeePdpActionInterfaceBuilder::EDIT_HTML_COMPETENCES_TOGGLE_HTML_ID,
                                    $toggleLink);
            // en de content togglen
            InterfaceXajax::toggleVisibility(   $objResponse,
                                                EmployeePdpActionInterfaceBuilder::EDIT_HTML_COMPETENCES_CONTENT_HTML_ID);

        }
    }

    static function displayPdpActionLibrary(xajaxResponse $objResponse,
                                            $employeePdpActionId = NULL)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $pdpActionLibraryHtml = EmployeePdpActionPageBuilder::getPdpActionLibraryHtml(  self::PDP_ACTION_LIBRARY_WIDTH,
                                                                                            self::PDP_ACTION_LIBRARY_HEIGHT,
                                                                                            $employeePdpActionId);
            InterfaceXajax::setHtml($objResponse,
                                    'pdpaddto',
                                    $pdpActionLibraryHtml);

        }

    }


}

?>
