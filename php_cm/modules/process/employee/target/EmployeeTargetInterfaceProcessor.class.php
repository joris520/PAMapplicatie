<?php

/**
 * Description of TargetInterfaceProcessor
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/employee/target/EmployeeTargetPageBuilder.class.php');

class EmployeeTargetInterfaceProcessor
{
    const DISPLAY_WIDTH       = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const DIALOG_WIDTH        = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const HISTORY_WIDTH       = ApplicationInterfaceBuilder::HISTORY_WIDTH;

    const CONTENT_HEIGHT_ADD_TARGET      = 120;
    const CONTENT_HEIGHT_ADD_EVALUATION  = 50;
    const CONTENT_HEIGHT_EDIT_TARGET     = 120;
    const CONTENT_HEIGHT_EDIT_EVALUATION = 190;

    const CONTENT_HEIGHT_REMOVE  = 200;
    const HISTORY_CONTENT_HEIGHT = 320;

    const PRINT_DIALOG_CONTENT_HEIGHT = ApplicationInterfaceBuilder::PRINT_OPTIONS_DIALOG_HEIGHT;
    const PRINT_DIALOG_CONTENT_WIDTH =  ApplicationInterfaceBuilder::PRINT_OPTIONS_DIALOG_WIDTH;


    static function displayView($objResponse, $employeeId, $hiliteTargetId = NULL)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {
                $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);
                // de data verzamelen
                $employeeTargetCollections = EmployeeTargetService::getCollections($employeeId);

                $viewHtml = EmployeeTargetPageBuilder::getPageHtml( self::DISPLAY_WIDTH,
                                                                    $employeeId,
                                                                    $employeeInfoValueObject,
                                                                    $employeeTargetCollections,
                                                                    $hiliteTargetId);
            }
            EmployeesTabInterfaceProcessor::displayContent($objResponse, $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu($objResponse, $employeeId, MODULE_EMPLOYEE_TARGETS);

            if (!empty($hiliteTargetId)) {
                InterfaceXajax::hiliteNewElement($objResponse);
            }
        }
    }

    static function displayAdd($objResponse, $employeeId)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            $addHeight = (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS)           ? self::CONTENT_HEIGHT_ADD_TARGET      : 0) +
                         (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION) ? self::CONTENT_HEIGHT_ADD_EVALUATION  : 0);

            $popupHtml = EmployeeTargetPageBuilder::getAddPopupHtml(    self::DIALOG_WIDTH,
                                                                        $addHeight,
                                                                        $employeeId);
            InterfaceXajax::showAddDialog(  $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            $addHeight);
        }
    }

    static function finishAdd($objResponse, $employeeId, $hiliteTargetId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele lijst opnieuw tonen
        self::displayView($objResponse, $employeeId, $hiliteTargetId);
    }

    static function displayEdit($objResponse, $employeeId, $employeeTargetId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS) ||
            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {

            $editHeight = self::CONTENT_HEIGHT_EDIT_TARGET  +
                          (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION) ? self::CONTENT_HEIGHT_EDIT_EVALUATION : 0);

            $popupHtml = EmployeeTargetPageBuilder::getEditPopupHtml(   self::DIALOG_WIDTH,
                                                                        $editHeight,
                                                                        $employeeId,
                                                                        $employeeTargetId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            $editHeight);
        }
    }

    static function finishEdit($objResponse, $employeeId, $hiliteTargetId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele lijst opnieuw tonen
        self::displayView($objResponse, $employeeId, $hiliteTargetId);
    }

    static function displayRemove($objResponse, $employeeId, $employeeTargetId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            $popupHtml = EmployeeTargetPageBuilder::getRemovePopupHtml( self::DIALOG_WIDTH,
                                                                        self::CONTENT_HEIGHT_REMOVE,
                                                                        $employeeId,
                                                                        $employeeTargetId);
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::CONTENT_HEIGHT_REMOVE);
        }
    }

    static function finishRemove($objResponse, $employeeId, $employeeTargetId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId, $employeeTargetId);
    }

    static function displayHistory($objResponse, $employeeId, $employeeTargetId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGETS) &&
            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {

            $popupHtml = EmployeeTargetPageBuilder::getHistoryPopupHtml(self::HISTORY_WIDTH,
                                                                        self::HISTORY_CONTENT_HEIGHT,
                                                                        $employeeId,
                                                                        $employeeTargetId);

            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::HISTORY_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

    static function displayPrintOptions($objResponse, $employeeId)
    {
        if (PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            $popupHtml = EmployeeTargetPageBuilder::getPrintOptionsPopupHtml(self::PRINT_DIALOG_CONTENT_WIDTH,
                                                                             self::PRINT_DIALOG_CONTENT_HEIGHT,
                                                                             $employeeId);

            InterfaceXajax::showPrintDialog($objResponse,
                                            $popupHtml,
                                            self::PRINT_DIALOG_CONTENT_WIDTH,
                                            self::PRINT_DIALOG_CONTENT_HEIGHT);
        }
    }

    static function finishPrintOptions($objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        if (PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
           InterfaceXajax::openInWindow($objResponse, 'print/print_employeesTarget.php', 900, 800);
        }
    }
}

?>
