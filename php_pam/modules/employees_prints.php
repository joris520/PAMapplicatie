<?php

require_once('modules/interface/components/select/SelectEmployees.class.php');

// TODO: safeform en in de nieuwe structuur
function moduleEmployeesPrints_printEmployeesFullPortfolio_deprecated()
{
    return local_printEmployeesFullPortfolio_deprecated(MODULE_EMPLOYEE_PORTFOLIO);
}

function public_dashboard_printEmployeesFullPortfolio_deprecated()
{
    return local_printEmployeesFullPortfolio_deprecated(MODULE_DASHBOARD_MENU_EMPLOYEE_PORTFOLIO);
}


function local_printEmployeesFullPortfolio_deprecated($moduleMenu)
{
    global $smarty;
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && EmployeePrintService::isPrintAllowed()) {
        ApplicationNavigationService::setCurrentApplicationModule($moduleMenu);

        $tpl = $smarty->createTemplate('to_refactor/module_prints/printEmployeesFullPortfolioPage.tpl');
        $tpl->assign('title', TXT_UCF('PRINT_EMPLOYEE_FULL_PORTFOLIO'));

        $tpl->assign('formID',         'empPrintForm');
        $tpl->assign('onSubmitAction', 'empPrintFullProfileExecute();return false;');

        $tpl_form = $smarty->createTemplate('components/select/selectEmployees.tpl');

        $selectEmps = new SelectEmployees();
        $selectEmps->fillComponent($tpl_form);

        $tpl->assign('formdata', $smarty->fetch($tpl_form));

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule($moduleMenu));

        $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($tpl));
    }

    return $objResponse;
}

function moduleEmployeesPrints_executePrintEmployeesFullPortfolio_deprecated($printScoreForm)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && EmployeePrintService::isPrintAllowed()) {

        $alert_txt = "";
        $hasError = false;

        $selectEmps = new SelectEmployees();

        if (!$selectEmps->validateFormInput($printScoreForm)) {
            $alert_txt .= $selectEmps->getErrorTxt();
            $hasError = true;
        }

        if ($hasError) {
            $objResponse->alert($alert_txt);
        } else {
            $employeeIds = $selectEmps->processResults($printScoreForm);

            $allowedModules = ApplicationNavigationService::getAllowedModulesForApplicationMenu(MODULE_EMPLOYEES);
            $printOptions = EmployeeModulePrintOption::options($allowedModules, EmployeeModulePrintOption::INCLUDE_OPTION_SIGNATURE);

            $assessmentCycleValueObject = AssessmentCycleService::getCurrentValueObject();
            EmployeePrintInterfaceProcessor::displayPrintOptions(   $objResponse,
                                                                    $employeeIds,
                                                                    $assessmentCycleValueObject,
                                                                    $printOptions,
                                                                    $printOptions);
        }
    }

    return $objResponse;
}


?>
