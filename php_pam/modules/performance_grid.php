<?php

require_once('modules/interface/components/select/SelectEmployees.class.php');

//PERFORMANCE GRID
function modulePerformanceGrid_menu() {
    return modulePerformanceGrid_displayPerformanceGrid();
}

function modulePerformanceGrid_displayPerformanceGrid()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PERFORMANCE_GRID)) {
        displayPerformanceGrid($objResponse);
    }
    return $objResponse;
}

function displayPerformanceGrid($objResponse)
{
   global $smarty;
    ApplicationNavigationService::setCurrentApplicationModule(MODULE_PERFORMANCE_GRID);

    $tpl = $smarty->createTemplate('components/select/selectEmployees.tpl');
    //$tpl->assign('DEFAULT_DATE', DEFAULT_DATE);
    //$tpl->assign('employees_against_job_profile', true); // sdj: TODO: in de toekomst weer aanzetten.
    $tpl->assign('hide_department_option', false);
    $tpl->assign('hide_all_employees_option', true);
    $tpl->assign('additional_functions', false);

    $selectEmps = new SelectEmployees();
    $selectEmps->showAdditionalProfiles = false;
    $selectEmps->fillComponent($tpl);

//                onclick="xajax_modulePerformanceGrid_printPerformanceGrid(xajax.getFormValues(\'empPrintForm\')); return false;"> &nbsp;</div>';

    $empPrintData = '
    <form id="empPrintForm" name="empPrintForm" onsubmit="performanceGridPrint(this.name);return false;">
        <div align="right">
            <input type="submit" id="buttonSubmit" value="' . TXT_BTN('PRINT') . '" class="btn btn_width_80">&nbsp;
        </div>
        <p>&nbsp;' . TXT_UCF('NB_ONLY_RESULTS_FOR_MAIN_PROFILES_ARE_SHOWN_IN_PERFORMANCE_GRID') . '.</p>
        ' . $smarty->fetch($tpl) . '
    </form>';

    $objResponse->assign('module_main_panel', 'innerHTML', $empPrintData);
    $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_PERFORMANCE_GRID));
}


//function functionID($control, $option) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse)) {
//        if ($control == 1) {
//            $html = '<select name="function" id="function" size="20" >';
//            $getFunc = @mysql_query("select * from functions where customer_id=" . CUSTOMER_ID . " order by function") or die(mysql_error());
//            if (@mysql_num_rows($getFunc) > 0) {
//                while ($func_row = @mysql_fetch_assoc($getFunc)) {
//                    $html .='<option value="' . $func_row[ID_F] . '">' . $func_row['function'] . '</option>';
//                }
//            }
//            $html .='</select>';
//        } else {
//            if ($option == 'o1' || $option == 'o5' || $option == 'o4') {
//                $disabled = 'disabled';
//            } else {
//                $disabled = '';
//            }
//            $html = '<select name="function" id="function" size="20" ' . $disabled . '>';
//            $getFunc = @mysql_query("select * from functions where customer_id=" . CUSTOMER_ID . " order by function") or die(mysql_error());
//            if (@mysql_num_rows($getFunc) > 0) {
//                while ($func_row = @mysql_fetch_assoc($getFunc)) {
//                    $html .='<option value="' . $func_row[ID_F] . '">' . $func_row['function'] . '</option>';
//                }
//            }
//            $html .='</select>';
//        }
//        $objResponse->assign($option, 'checked', true);
//        $objResponse->assign('functionID', 'innerHTML', $html);
//    }
//
//    return $objResponse;
//}

function modulePerformanceGrid_printPerformanceGrid($selectEmployeesForm)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_PERFORMANCE_GRID)) {

        $message = '';
        $hasError = false;

        // controleer opties en daarbij ingevulde waarden
        $selectEmployees = new SelectEmployees();

        if (!$selectEmployees->validateFormInput($selectEmployeesForm)) {
            $message =  $selectEmployees->getErrorTxt();
            $hasError = true;
        } else {
            $employees = $selectEmployees->processResults($selectEmployeesForm);
            list($departmentId, $functionId) = $selectEmployees->getSelectedDetails();
        }

        if ($hasError) {
            InterfaceXajax::alertMessage($objResponse, $message);
        } else {
            // start verwerken ...
            if (!empty($departmentId)) {
                $departmentName = DepartmentsService::getDepartmentName($departmentId);
            }
            if (!empty($functionId)) {
                $functionName = FunctionsServiceDeprecated::getFunctionName($functionId);
            }
            //die('modulePerformanceGrid_printPerformanceGrid:'. print_r($employees, true) . ' di:' . $departmentId . ' dn:' . $departmentName . ' fi:' . $functionId . ' fn:' . $functionName);
            // TODO: via selectEmployeesObject!!
//            if ($selectEmployeesForm['option'] == EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION ||
//                $selectEmployeesForm['option'] == EMPLOYEE_SELECT_EMPLOYEES_AGAINST_JOB_PROFILE) {
//                $total_text = '';
//                foreach ($printProfile['SBcross'] as $value => $text) {
//                    $total_text = $total_text . $text . '/';
//                }
//                $_SESSION['cross_pg'] = $total_text;
//            }

            // TODO: choice uit $selectEmployees halen
            $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['choice'] = EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION;

            $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['functionId'] = $functionId;
            $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['functionName'] = $functionName;
            $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['departmentId'] = $departmentId;
            $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['departmentName'] = $departmentName;
            $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['employees'] = implode(',', $employees);

            InterfaceXajax::openInWindow($objResponse, 'print/perfomance_grid.php' , 860, 800);
        }

    }

    return $objResponse;
}

?>