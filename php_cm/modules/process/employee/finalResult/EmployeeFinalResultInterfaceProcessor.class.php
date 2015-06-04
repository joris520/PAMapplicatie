<?php

/**
 * Description of EmployeeFinalResultInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/finalResult/EmployeeFinalResultPageBuilder.class.php');

class EmployeeFinalResultInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;
//    const DISPLAY_WIDTH = 750;
    const EDIT_HEIGHT = 350;
    const DIALOG_WIDTH = 800;
    const HISTORY_CONTENT_HEIGHT = 400;
    const HISTORY_WIDTH = ApplicationInterfaceBuilder::HISTORY_WIDTH;

    static function displayView(xajaxResponse $objResponse,
                                $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {
                $currentPeriod  = AssessmentCycleService::getCurrentValueObject();
                $previousPeriod = AssessmentCycleService::getPreviousValueObject($currentPeriod->getStartDate());

                $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);

                $valueObject = EmployeeFinalResultService::getValueObject(  $employeeId,
                                                                            $currentPeriod);

                $previousValueObject = EmployeeFinalResultService::getValueObject(  $employeeId,
                                                                                    $previousPeriod);

                $viewHtml = EmployeeFinalResultPageBuilder::getPageHtml(self::DISPLAY_WIDTH,
                                                                        $employeeId,
                                                                        $employeeInfoValueObject,
                                                                        $valueObject,
                                                                        $previousValueObject);
            }
            EmployeesTabInterfaceProcessor::displayContent( $objResponse,
                                                            $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu(    $objResponse,
                                                            $employeeId,
                                                            MODULE_EMPLOYEE_FINAL_RESULTS);
        }
    }

    static function displayAdd( xajaxResponse $objResponse,
                                $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {

            $popupHtml = EmployeeFinalResultPageBuilder::getAddPopupHtml(   self::DIALOG_WIDTH,
                                                                            self::EDIT_HEIGHT,
                                                                            $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::EDIT_HEIGHT);
        }
    }

    static function displayEdit(xajaxResponse $objResponse,
                                $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
            $currentPeriod = AssessmentCycleService::getCurrentValueObject();
            $valueObject = EmployeeFinalResultService::getValueObject(  $employeeId,
                                                                        $currentPeriod);

            $popupHtml = EmployeeFinalResultPageBuilder::getEditPopupHtml(  self::DIALOG_WIDTH,
                                                                            self::EDIT_HEIGHT,
                                                                            $employeeId,
                                                                            $valueObject);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::EDIT_HEIGHT);
        }
    }

    static function finishEdit(xajaxResponse $objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }

    static function displayHistory( xajaxResponse $objResponse,
                                    $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
            $valueObjects = EmployeeFinalResultService::getValueObjects($employeeId);
            $popupHtml = EmployeeFinalResultPageBuilder::getHistoryPopupHtml(   self::HISTORY_WIDTH,
                                                                                self::HISTORY_CONTENT_HEIGHT,
                                                                                $employeeId,
                                                                                $valueObjects);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::HISTORY_WIDTH,
                                            self::HISTORY_CONTENT_HEIGHT);
        }
    }

}

?>
