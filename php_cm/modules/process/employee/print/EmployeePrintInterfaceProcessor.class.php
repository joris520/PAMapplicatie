<?php

/**
 * Description of EmployeePrintInterfaceProcessor
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/employee/print/EmployeePrintPageBuilder.class.php');

class EmployeePrintInterfaceProcessor
{
    const PRINT_DIALOG_CONTENT_WIDTH  = ApplicationInterfaceBuilder::PRINT_OPTIONS_DIALOG_WIDTH;
    const PRINT_DIALOG_CONTENT_HEIGHT = ApplicationInterfaceBuilder::PRINT_OPTIONS_DIALOG_HEIGHT;

    static function displayPrintOptions(xajaxResponse $objResponse,
                                        Array $employeeIds,
                                        AssessmentCycleValueObject $assessmentCycleValueObject = NULL,
                                        Array $modulePrintOptions = NULL,
                                        Array $selectedPrintOptions = NULL)
    {
        if (EmployeePrintService::isPrintAllowed()) {
            // de onderdelen van de pagina opbouwen
            if (is_null($modulePrintOptions)) {
                $allowedModules = ApplicationNavigationService::getAllowedModulesForApplicationMenu(MODULE_EMPLOYEES);

                $modulePrintOptions = EmployeeModulePrintOption::options($allowedModules, EmployeeModulePrintOption::INCLUDE_OPTION_SIGNATURE);

                if (ApplicationNavigationService::getCurrentApplicationMenu() == APPLICATION_MENU_EMPLOYEES) {
                    $currentModule  = ApplicationNavigationService::retrieveLastModuleFunction(APPLICATION_MENU_EMPLOYEES);
                } else {
                    $currentModule  = NULL;
                }
                $selectedPrintOptions = EmployeeModulePrintOption::options(array($currentModule));
            }
            if (is_null($assessmentCycleValueObject)) {
                $assessmentCycleValueObject = AssessmentCycleService::getCurrentValueObject();
            }
            $popupHtml = EmployeePrintPageBuilder::getPrintOptionsPopupHtml(    self::PRINT_DIALOG_CONTENT_WIDTH,
                                                                                self::PRINT_DIALOG_CONTENT_HEIGHT,
                                                                                $employeeIds,
                                                                                $assessmentCycleValueObject,
                                                                                $modulePrintOptions,
                                                                                $selectedPrintOptions);

            InterfaceXajax::showPrintDialog(    $objResponse,
                                                $popupHtml,
                                                self::PRINT_DIALOG_CONTENT_WIDTH,
                                                self::PRINT_DIALOG_CONTENT_HEIGHT);
        }
    }

    static function finishPrintOptions(xajaxResponse $objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        if (EmployeePrintService::isPrintAllowed()) {
           InterfaceXajax::openInWindow($objResponse,
                                        'print/print_employee.php',
                                        ApplicationInterfaceBuilder::PDF_PRINT_WINDOW_WIDTH,
                                        ApplicationInterfaceBuilder::PDF_PRINT_WINDOW_HEIGHT);
        }
    }
}

?>
