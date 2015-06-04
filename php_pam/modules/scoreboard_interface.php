<?php

require_once('modules/model/queries/to_refactor/DepartmentQueriesDeprecated.class.php');
require_once('modules/model/queries/to_refactor/FunctionQueriesDeprecated.class.php');
require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');
require_once('modules/common/moduleUtils.class.php');
require_once('modules/scoreboard_common.class.php');

define('EMP_SINGLE_SELECT', 1);
define('EMP_MULTI_SELECT', 2);

define('SELECTMODE_NEW', 0);
define('SELECTMODE_ADD', 1);

function moduleScoreboard_menu() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        $objResponse->call('xajax_moduleScoreboard_calc', 0);
    }
    return $objResponse;
}

function getTopNav()
{
    $html = '<input type="button" class="btn btn_width_80" value="' . TXT_BTN('RESET') . '" onclick="xajax_moduleScoreboard_calc(0);return false;">
             &nbsp;
             <input type="submit" class="btn btn_width_80" value="' . TXT_BTN('CALCULATE') . '" id="subCalcBtn">';

    return $html;
}

function checkSelected($value, $selected_value) {
    return $value == $selected_value ? ' checked' : '';
}

function getModeSelector($mode_selected = SELECTMODE_NEW)
{
    $disabled_class = $mode_selected == SELECTMODE_ADD ? '' : ' class="text_disabled" ';
    $disabled_add_rad = ' disabled ';

    $html = '<br /><br />
             <table style="border: 1px solid #ccc;" width="100%">
                <tr>
                    <td colspan="2">' . TXT_UCF('MODE') . ':</td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="select_mode" value="' . SELECTMODE_NEW . '"' . checkSelected(SELECTMODE_NEW, $mode_selected) . ' onclick="xajax_moduleScoreboard_calc(0)"/>
                    </td>
                    <td>' . TXT_UCF('NEW_SELECTION') . '</td>
                </tr>
                <tr>
                    <td>
                        <input type="radio" name="select_mode" value="' . SELECTMODE_ADD . '"  ' . checkSelected(SELECTMODE_ADD, $mode_selected) .  $disabled_add_rad . ' onclick=""/>
                    </td>
                    <td' . $disabled_class . '>' . TXT_UCF('ADD_TO_PREVIOUS_SELECTION') . '</td>
                </tr>
             </table>';
    return $html;
}


function getFilterOptions($select_mode, $selected_filter = 0)
{
    $disabled_class = $select_mode == SELECTMODE_ADD ? ' class="text-disabled" ' : '';
    $disabled_radio = $select_mode == SELECTMODE_ADD ? ' disabled ' : '';
    $html = '<br />
             <table style="border: 1px solid #ccc;" width="100%">
                <tr>
                    <td colspan="2">' . TXT_UCF('OPTIONS') . ':</td>
                </tr>
                <tr>
                    <td>
                        <input' . $disabled_radio . ' type="radio" name="filter_options" value="' . FILTER_OWN_PROFILE . '"' . checkSelected(FILTER_OWN_PROFILE, $selected_filter) . ' onclick="xajax_moduleScoreboard_filter_currentFunction()"/>
                    </td>
                    <td>' . TXT_UCF('SCORE_EMPLOYEE_IN_OWN_JOB_PROFILE') . '</td>
                </tr>
                <tr>
                    <td>
                        <input' . $disabled_radio . ' type="radio" name="filter_options" value="1"' . checkSelected(1, $selected_filter) . ' onclick="xajax_moduleScoreboard_filter_otherFunction()"/>
                    </td>
                    <td' . $disabled_class . '>' . TXT_UCF('SCORE_EMPLOYEES_IN_ANY_OTHER_JOB_PROFILE_OR_CROSS_SELECTION') . '</td>
                </tr>
                <tr>
                    <td>
                        <input' . $disabled_radio . ' type="radio" name="filter_options" value="2"' . checkSelected(2, $selected_filter) . ' onclick="xajax_moduleScoreboard_filter_functionGroup()"/>
                    </td>
                    <td' . $disabled_class . '>' . TXT_UCF('SCORE_JOB_PROFILE') . '</td>
                </tr>
                <tr>
                    <td>
                        <input' . $disabled_radio . ' type="radio" name="filter_options" value="3"' . checkSelected(3, $selected_filter) . ' onclick="xajax_moduleScoreboard_filter_functionGroupDep()"/>
                    </td>
                    <td' . $disabled_class . '>' . TXT_UCF('SCORE_JOB_PROFILE_IN_DEPARTMENT') . '</td>
                </tr>
             </table>';
    return $html;
}

function getAllowedDepartments($filter_id_dept = null)
{
    $departments = null;
    if (USER_LEVEL >= UserLevelValue::CUSTOMER_ADMIN &&
        USER_LEVEL <= UserLevelValue::MANAGER) {
        $departments = array();
        $d = new DepartmentQueriesDeprecated();
        $queryResult = $d->getDepartmentsBasedOnUserLevel(null, null, null, $filter_id_dept, null, null);
        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            $departments['' . $queryResult_row['ID_DEPT']. ''] = array('ID_DEPT'    => $queryResult_row['ID_DEPT'],
                                                                       'department' => $queryResult_row['department']);
        }
    }
    return $departments;
}

function getDepartmentSelect($departments, $message = null)
{
    if (empty($departments)) {
        $html = empty($message) ? TXT_UCF('NOT_APPLICABLE_FOR_SELECTION') : $message;
    } else {
        $html = '<select class="sb_select" name="sel_dept" id="sel_dept" size="15" onclick="xajax_moduleScoreboard_fillFunctionlistForDepartment(this.options[this.selectedIndex].value)">';
                foreach ($departments as $department) {
                    $html .= '
                    <option value="' . $department['ID_DEPT'] . '">' .
                        $department['department'] . '
                    </option>';
                }
                $html .= '
                </select>';
    }
    return $html;
}
function getEmployeeFunction($id_e)
{
    $employee_fid = null;
    $emps = new EmployeesQueries();
    $queryResult = $emps->getEmployeesBasedOnUserLevel(null, $id_e, null, null, null, null, false);
    if (@mysql_numrows($queryResult) == 1) {
        $queryResult_row = @mysql_fetch_assoc($queryResult);
        $employee_fid = $queryResult_row['ID_F'];
    }
    return $employee_fid;
}

function getAllowedFunctions($id_dept = null, $filter_id_f = null)
{
    $functions = array();
    if (USER_LEVEL >= UserLevelValue::CUSTOMER_ADMIN &&
        USER_LEVEL <= UserLevelValue::MANAGER) {
        switch(USER_LEVEL) {
            case UserLevelValue::CUSTOMER_ADMIN:
            case UserLevelValue::HR:
                $departments = empty($id_dept) ? null : getAllowedDepartments($id_dept);
                break;
            case UserLevelValue::MANAGER:
                $departments = getAllowedDepartments($id_dept);
                break;
        }

        $departments_list = null;
        if (!empty($departments)) {
            $departments_list = array_keys($departments);
        }

        $f = new FunctionQueriesDeprecated();
        $queryResult = $f->getFunctionsBasedOnUserLevel(null, null, $filter_id_f, $departments_list, null, null, false);

        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            $functions[] = array('ID_F'     => $queryResult_row['ID_F'],
                                 'function' => $queryResult_row['function']);
        }
    }

    return $functions;
}

function getDepartmentFunctionSelect()
{
    $d = new DepartmentQueriesDeprecated();
    $department_qry = $d->getDepartmentsBasedOnUserLevel(null, null, null, null, null, null, null);
    $html = '<select class="sb_select" name="sel_funct" id="sel_funct" size="15">';
    $f = new FunctionQueriesDeprecated();
    while($department = @mysql_fetch_assoc($department_qry)) {
        $html .= '<optgroup label="' . $department['department'] . '">';
        $department_functions_qry = $f->getFunctionsBasedOnUserLevel(null, null, null,$department['ID_DEPT'], null, null,false);
        while($department_function = @mysql_fetch_assoc($department_functions_qry)) {
            $html .='<option value="' . $department['ID_DEPT'] . ',' . $department_function['ID_F'] . '">' . $department_function['function'] . '</option>';
        }
        $html .= '</optgroup>';
    }
    $html .= '</select>';
    return $html;
}

function getFunctionSelect($functions, $message = null)
{
    if (empty($functions)) {
        $html = empty($message) ? TXT_UCF('NOT_APPLICABLE_FOR_SELECTION') : $message;
    } else {
        $html = '<select class="sb_select" name="sel_funct" id="sel_funct" size="15">';
                foreach((array)$functions as $function) {
                    $html .= '
                    <option value="' . $function['ID_F'] . '">' .
                        $function['function'] . '
                    </option>';
                }
                $html .= '
                </select>';
    }
    return $html;
}

function getAllowedEmployees($id_f = null, $id_dept = null, $full_array = true)
{
    $employees = array();
    $emps = new EmployeesQueries();
    $queryResult = $emps->getEmployeesBasedOnUserLevel(null, null, $id_f, $id_dept, null, null, false);
    while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
        if ($full_array) {
            $employees[] = array('ID_E'     => $queryResult_row['ID_E'],
                                'firstname' => $queryResult_row['firstname'],
                                'lastname' => $queryResult_row['lastname']);
        } else {
            $employees[] = $queryResult_row['ID_E'];
        }
    }
    return $employees;
}


function getEmployeesSelect($employees, $message = null, $is_multi = false)
{
        function getOptions($employees)
        {
            $options_html = '';
            $already_selected_html = '';
            if (!empty($employees)) {
                foreach($employees as $employee) {
                    if (in_array($employee['ID_E'], (array)$_SESSION['scoreboard_selected_employee_ids'])) {
                        $already_selected_html .= ModuleUtils::EmployeeName($employee['firstname'], $employee['lastname']) . '<br/>';
                    } else {
                        $options_html .= '
                        <option value="' . $employee['ID_E'] . '">' .
                                ModuleUtils::EmployeeName($employee['firstname'], $employee['lastname']) . '
                        </option>';
                    }
                }
            }
            return array($options_html, $already_selected_html);
        }

    list($options_html, $already_selected_html) = getOptions($employees);
    $html = $already_selected_html;
    if (empty($options_html)) {
        if (empty($already_selected_html)) {
            $html .=  empty($message) ? TXT_UCF('NOT_APPLICABLE_FOR_SELECTION') : $message;
        }
    } else {
        $multi_select = $is_multi ? 'multiple="multiple"' : '';
        $html .= '<select class="sb_select" name="sel_emp"  id="sel_emp" size="15"' . $multi_select . '>' .
                     $options_html . '
                  </select>';
    }

    return $html;
}

function moduleScoreboard_calc($keep_values = 0) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_SCOREBOARD);

        $keep_values = ($keep_values == 1 && $_SESSION['scoreboard_filter_option'] == FILTER_OWN_PROFILE) ? 1 : 0;
        if ($keep_values == 1) { //
            $_SESSION['scoreboard_mode_option'] = SELECTMODE_ADD;
            $_SESSION['scoreboard_filter_option'] = FILTER_OWN_PROFILE;
            $id_f = $_SESSION['scoreboard_selected_function_id'];
            $functions = getAllowedFunctions(null, $id_f); // de geselecteerde functie ophalen en in de message stoppen.
            $function_message = empty($functions[0]['function']) ? TXT_UCF('NO_VALUES_RETURNED') : $functions[0]['function'];
            $functions = array(); // maar geen functieselector tonen, want de functie staat nu in de message
            $departments = array();
            $employees = getAllowedEmployees($id_f);
            // als we alle employees al hadden kunnen we geen keep_values meer doen
            if (count($_SESSION['scoreboard_selected_employee_ids']) == count($employees)) {
                $keep_values = 0;
            }
        }

        if ($keep_values == 0) {
            $_SESSION['scoreboard_mode_option'] = SELECTMODE_NEW;
            $_SESSION['scoreboard_filter_option'] = FILTER_OWN_PROFILE;
        }

        $mode_selected = $_SESSION['scoreboard_mode_option'];
        $allow_employee_multiselect = ($mode_selected == SELECTMODE_ADD);

        if ($mode_selected == SELECTMODE_NEW) {
            $functions = array();
            $function_message = null;
            $departments = array();
            $employees = getAllowedEmployees();
            unset($_SESSION['scoreboard_selected_function_id']);
            unset($_SESSION['scoreboard_selected_employee_ids']);
        }

        $html = '
        <div id="sb_window1" class="sb_window1" align="center">
            <form action="javascript:void(null);" id="scoreboardForm" onsubmit="calculateEmpScore();">
                <input type="hidden" name="hid_id_e" value="' . $id_es . '"/>
                <table width="100%" cellspacing="0" cellpadding="5" border="0" align="center">
                    <tr>
                        <td>
                            <div id="top_nav" class="top_nav bottom_border1px">' . getTopNav() . '</div>
                        </td>
                    </tr>
                    <tr>
                        <td align="left" width="100%">
                            <table width="100%">
                                <tr>
                                    <td>' .
                                        getModeSelector($mode_selected) . '
                                        <div id="div_rad_opts">' .
                                            getFilterOptions($mode_selected) .  '
                                        </div><!-- div_rad_opts -->
                                    </td>
                                    <td width="5%">&nbsp;</td>

                                    <!--td width="25%">
                                        <table width="100%">
                                            <tr>
                                                <td><strong>' . TXT_UCF('DEPARTMENT') . ':</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sb_depts" id="sb_depts">' .
                                                    getDepartmentSelect($departments) . '
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td-->

                                    <td width="25%">
                                        <table width="100%">
                                            <tr>
                                                <td><strong>' . TXT_UCF('JOB_PROFILE') . ':</strong></td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sb_functs" id="sb_functs"> ' .
                                                        getFunctionSelect($functions, $function_message) . '
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td width="25%">
                                        <table width="100%">
                                            <tr>
                                                <td>
                                                    <div id="emps_header">' . getEmployeeHeader(EMP_SINGLE_SELECT) . '</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <div class="sb_emps" id="sb_emps">' .
                                                        getEmployeesSelect($employees, null, $allow_employee_multiselect) . '
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>

                                    <td width="20%">&nbsp;</td>

                                </tr>
                            </table>
                        </td>
                    </tr>
                <table>
            </form>';

        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        if ($allow_employee_multiselect) {
            $objResponse->assign('emps_header', 'innerHTML', getEmployeeHeader(EMP_MULTI_SELECT));
        }

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_SCOREBOARD));

        ModuleUtils::emptyTempDir();
    }

    return $objResponse;
}

function getEmployeeHeader($select_mode)
{
    $header = '<strong>' . TXT_UCF('EMPLOYEE') . ':</strong>';
    if ($select_mode == EMP_MULTI_SELECT) {
        $header .= '(<font size="1">' . TXT_UCF('CTRL_CLICK_TO_SELECT_MULTIPLE_EMPLOYEES') . '</font>)';
    }
    return $header;
}


function moduleScoreboard_filter_currentFunction() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) { // reset selected department
        $_SESSION['scoreboard_filter_option'] = FILTER_OWN_PROFILE;

        $employees = getAllowedEmployees();
        $objResponse->assign('sb_emps', 'innerHTML', getEmployeesSelect($employees));
        $objResponse->assign('sb_functs', 'innerHTML', getFunctionSelect(null));
        $objResponse->assign('sb_depts', 'innerHTML', getDepartmentSelect(null));
        $objResponse->assign('emps_header', 'innerHTML', getEmployeeHeader(EMP_SINGLE_SELECT));
    }
    return $objResponse;
}

function moduleScoreboard_filter_otherFunction() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        $_SESSION['scoreboard_filter_option'] = FILTER_EMPLOYEE_ANY_JOB_PROFILE;

        $functions = getAllowedFunctions();
        $employees = getAllowedEmployees();
        $objResponse->assign('sb_emps', 'innerHTML', getEmployeesSelect($employees, null, true));
        $objResponse->assign('sb_functs', 'innerHTML', getFunctionSelect($functions));
        $objResponse->assign('sb_depts', 'innerHTML', getDepartmentSelect(null));
        $objResponse->assign('emps_header', 'innerHTML', getEmployeeHeader(EMP_MULTI_SELECT));
    }

    return $objResponse;
}

function moduleScoreboard_filter_functionGroup() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        $_SESSION['scoreboard_filter_option'] = FILTER_JOB_PROFILE;

        $functions = getAllowedFunctions();
        $objResponse->assign('sb_emps', 'innerHTML', getEmployeesSelect(null));
        $objResponse->assign('sb_functs', 'innerHTML', getFunctionSelect($functions));
        $objResponse->assign('sb_depts', 'innerHTML', getDepartmentSelect(null));
        $objResponse->assign('emps_header', 'innerHTML', getEmployeeHeader(EMP_SINGLE_SELECT));
    }
    return $objResponse;
}

function moduleScoreboard_filter_functionGroupDep() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        $_SESSION['scoreboard_filter_option'] = FILTER_DEPARTMENT_JOB_PROFILE;


        $objResponse->assign('sb_emps', 'innerHTML', getEmployeesSelect(null));
        // gecombineerde afdeling/functie selectie
        $objResponse->assign('sb_functs', 'innerHTML', getDepartmentFunctionSelect());
//        $objResponse->assign('sb_functs', 'innerHTML', getFunctionSelect($functions, TXT_UCF('PLEASE_SELECT_A_DEPARTMENT')));
//        $objResponse->assign('sb_depts', 'innerHTML', getDepartmentSelect($departments));
        $objResponse->assign('emps_header', 'innerHTML', getEmployeeHeader(EMP_SINGLE_SELECT));
    }

    return $objResponse;
}


function moduleScoreboard_fillFunctionlistForDepartment($department_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        $functions = getAllowedFunctions($department_id);
        $objResponse->assign('sb_functs', 'innerHTML', getFunctionSelect($functions, TXT_UCF('NO_VALUES_RETURNED')));
    }
    return $objResponse;
}


// hier kom je binnen vanuit de javascript
function moduleScoreboard_calcProcess($scoreboardForm)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        $filter_option = $_SESSION['scoreboard_filter_option'];
        $selected_mode = $_SESSION['scoreboard_mode_option'];

        $hasError = false;
        $message = '';

        if ($selected_mode == SELECTMODE_NEW) {
            unset($_SESSION['scoreboard_selected_employee_ids']);
            unset($_SESSION['scoreboard_selected_department_id']);
            unset($_SESSION['scoreboard_selected_function_id']);
            $keep_values = 0;

            // De gegevens uit het scherm verzamelen en valideren
            // letop: niet allen <select>s zijn er nog in elke mode!
            switch($filter_option) {
                case FILTER_OWN_PROFILE:
                    // er moet een medewerker geselecteerd zijn
                    $selected_employees = $scoreboardForm['sel_emp'];
                    // er mag er maar 1 selected zijn
                    if (empty($selected_employees) || is_array($selected_employees)) {
                        $hasError = true;
                        $message = TXT_UCF('YOU_MUST_SELECT_AN_EMPLOYEE');
                    }

                    if (!$hasError) {
                        $_SESSION['scoreboard_selected_function_id'] = getEmployeeFunction($selected_employees);
                        // medewerker bijhouden voor toevoegen
                        $_SESSION['scoreboard_selected_employee_ids'][] = $selected_employees;
                    }
                    $keep_values = 1;
                    break;
                case FILTER_EMPLOYEE_ANY_JOB_PROFILE:
                    // er moet een functieprofiel en minimaal 1 medewerker geselecteerd zijn
                    $function = $scoreboardForm['sel_funct']; // uit select halen
                    if (empty($function)) {
                        $hasError = true;
                        $message = TXT_UCF('YOU_MUST_SELECT_A_FUNCTION');
                    }

                    $selected_employees = $scoreboardForm['sel_emp'];
                    if (empty($selected_employees)) {
                        $hasError = true;
                        $message .= ($hasError ? "\r\n" : '') . TXT_UCF('YOU_MUST_SELECT_AN_EMPLOYEE');
                    }

                    // lijst van employees in sessie bewaren
                    if (!$hasError) {
                        $_SESSION['scoreboard_selected_function_id'] = $function;
                        if (!is_array($selected_employees)) {
                            $_SESSION['scoreboard_selected_employee_ids'][] = $selected_employees;
                        } else {
                            $_SESSION['scoreboard_selected_employee_ids'] = $selected_employees;
                        }
                    }
                    break;
                case FILTER_JOB_PROFILE:
                    // er moet een functieprofiel geselecteerd zijn
                    $function = $scoreboardForm['sel_funct']; // uit select halen
                    if (empty($function)) {
                        $hasError = true;
                        $message = TXT_UCF('YOU_MUST_SELECT_A_FUNCTION');
                    }
                    if (!$hasError) {
                        $_SESSION['scoreboard_selected_function_id'] = $function;
                        $_SESSION['scoreboard_selected_employee_ids'] = getAllowedEmployees($function, null, false);
                    }
                    break;
                case FILTER_DEPARTMENT_JOB_PROFILE:
                    // er moet een afdeling en een functieprofiel geselecteerd zijn
                    $department = $scoreboardForm['sel_dept']; // uit select halen
//                    if (empty($department)) {
//                        $hasError = true;
//                        $message = TXT_UCF('YOU_MUST_SELECT_A_DEPARTMENT');
//                    } else {
                    $department_function = $scoreboardForm['sel_funct']; // uit select halen
                    if (empty($department_function)) {
                        $hasError = true;
                        $message = TXT_UCF('YOU_MUST_SELECT_A_FUNCTION');
                    } else {
                        list($department, $function) = explode(',',$department_function);
                    }
                    //die('$department, $function'.$department.'-'. $function);
                    if (!$hasError) {
                        $_SESSION['scoreboard_selected_department_id'] = $department;
                        $_SESSION['scoreboard_selected_function_id'] = $function;
                        $_SESSION['scoreboard_selected_employee_ids'] = getAllowedEmployees($function, $department, false);
                    }

                    break;
            }
        } else { // SELECTMODE_ADD
            // bij add kan het alleen maar om de toegevoegde medewerker en het functieprofiel gaan
            if ($filter_option ==  FILTER_OWN_PROFILE) {
                // selectie uit scherm halen
                $keep_values = 1;

                $selected_employees = $scoreboardForm['sel_emp'];
                if (empty($selected_employees)) {
                    $hasError = true;
                    $message = TXT_UCF('YOU_MUST_SELECT_AN_EMPLOYEE');
                }

                // toevoegen aan al bestaande lijst van employees
                if (!$hasError) {
                    if (!is_array($selected_employees)) {
                        $_SESSION['scoreboard_selected_employee_ids'][] = $selected_employees;
                    } else {
                        $_SESSION['scoreboard_selected_employee_ids'] = array_merge($_SESSION['scoreboard_selected_employee_ids'], $selected_employees);
                    }
                }
                //$objResponse->alert('$_SESSION[scoreboard_selected_employee_ids]:'.print_r($_SESSION['scoreboard_selected_employee_ids'], true));
            }
        }

        if (empty($_SESSION['scoreboard_selected_employee_ids'])) {
            $hasError = true;
            $message = TXT_UCF('NO_EMPLOYEES_RETURN');
        }

        if ($hasError) {
            $objResponse->alert($message);
            $objResponse->assign("subCalcBtn", "disabled", false);
        } else {
            //die('$selected_mode'.$selected_mode. ' - $filter_option'.$filter_option . ' - employees ' . print_r($employees, true) . ' - function ' . $function );
            // aanroepen

            if (count($_SESSION['scoreboard_selected_employee_ids']) > 1) {
                $objResponse->call('xajax_moduleScoreboard_calcProcess_team', 1, null); // page 1
            } else {
                $objResponse->call('xajax_moduleScoreboard_calcProcess_individual', 1); // page 1
            }
        }
    }
    return $objResponse;
}


//function emptyDir($dir) {
//
//    if (substr($dir, strlen($dir) - 1, 1) != '/') {
//        $dir .= '/';
//    }



?>
