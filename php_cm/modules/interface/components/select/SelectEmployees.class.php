<?php
/**
 * Het SelectEmployees object.
 *
 * @author sjoerd.de.jong
 *
 */

require_once('SelectComponent.class.php');
require_once('gino/MysqlUtils.class.php');
require_once('modules/model/queries/to_refactor/DepartmentQueriesDeprecated.class.php');
require_once('modules/model/queries/to_refactor/FunctionQueriesDeprecated.class.php');
require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');

require_once('modules/model/service/to_refactor/DepartmentsService.class.php');

require_once('modules/model/service/employee/EmployeeSelectService.class.php');

// TODO: magic numbers wegwerken!!!
// TODO: losse functies horen hier niet!!
// TODO: hoe kan ik de gekozen afdeling en functieprofiel ophalen?

class SelectEmployees extends SelectComponent {

    protected $mysqlQuery = '';
    protected $validQuery = false;

    public $selectionBasedOnString = '';

    public $showAdditionalProfiles = true;

    public $show_functions = true;
    public $show_bosses = false;
    public $show_employees_with_emailaddress = false;
    public $show_employees_without_self_assessment_invitation = false;
    public $show_employees_with_both_completed_assessment = false;
    public $useSelfAssessmentFilter = false;
    public $assessmentCycle = null;
    public $selfassessment_active = false;

    private $employees_query_result = NULL;
    public $selectedDepartmentId = NULL;
    public $selectedFunctionId = NULL;

    function __construct() { }

    function  __destruct() { }


    function setUseSelfAssessment(  $useSelfAssessmentFilter,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $this->assessmentCycle = $assessmentCycle;
        $this->useSelfAssessmentFilter = $useSelfAssessmentFilter;
    }

    public function fillComponent(&$tpl) {
        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN ||
            USER_LEVEL == UserLevelValue::HR ||
            USER_LEVEL == UserLevelValue::MANAGER) {
            // do something ?
        }

        $tpl->assign('employee_edit_or_view', USER_LEVEL == UserLevelValue::EMPLOYEE_EDIT  ||
                                              USER_LEVEL == UserLevelValue::EMPLOYEE_VIEW);

        if ($this->show_functions) {
            // get departments
            $departmentQueries = new DepartmentQueriesDeprecated();
            $departmentResults = $departmentQueries->getDepartmentsBasedOnUserLevel();

            // get departments
            $departments = array();
            if (@mysql_num_rows($departmentResults) > 0) {
                while ($department = @mysql_fetch_assoc($departmentResults)) {
                    $departments[] = $department;
                }
            }
            $tpl->assign('depts', $departments);

            // get job profiles
            $functionQueries = new FunctionQueriesDeprecated();
            $functionResults = $functionQueries->getFunctionsBasedOnUserLevel(null,null,null,null,null,null, $this->showAdditionalProfiles);

            $functions = array();
            if (@mysql_num_rows($functionResults) > 0) {
                while ($function = @mysql_fetch_assoc($functionResults)) {
                    $functions[] = $function;
                }
            }
            $tpl->assign('funcs', $functions);
        }


        if ($this->show_bosses) { // (ee = employees, eb = employee's boss)
            // get bosses...

            $employeesQueries = new EmployeesQueries();
            $bossResults = $employeesQueries->getEmployeesBasedOnUserLevel(null, null, null, null, true, null, false);

            $bosses = array();
            if (@mysql_num_rows($bossResults) > 0) {
                while ($boss = @mysql_fetch_assoc($bossResults)) {
                    $bosses[] = $boss;
                }
            }
            $tpl->assign('bosses', $bosses);
        }

        // get employees
//        $employeesQueries = new EmployeesQueries();
//        $employeesResults = $employeesQueries->getEmployeesBasedOnUserLevel();
        // TODO: queries terug in object als hierboven?
        $filter_employees_assessment_invitations = $this->show_employees_without_self_assessment_invitation ? FILTER_EMPLOYEES_EMPLOYEE_NOT_INVITED : FILTER_EMPLOYEES_ALPHABETICAL;
        $filter_employees_assessment_invitations = $this->show_employees_with_both_completed_assessment ? FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN_NO_LOS : ($this->selfassessment_active ? FILTER_EMPLOYEES_EMPLOYEE_INVITED_NO_LOS :$filter_employees_assessment_invitations);
        $employees = array();
        if ($this->useSelfAssessmentFilter) {
            // hack om "alle employees" bij zelfassessment uit te zetten, want dit geeft onduidelijkheid in de interface.
            $tpl->assign('hide_all_employees_option', true);

            $employeeIds = EmployeeSelectService::getEmployeeIdsForSelectComponent( EmployeeSelectService::ALL_BOSSES,
                                                                                    EmployeeSelectService::ALL_NAMES,
                                                                                    EmployeeSelectService::ALL_DEPARTMENTS,
                                                                                    EmployeeSelectService::ALL_FUNCTIONS,
                                                                                    $this->show_employees_with_emailaddress,
                                                                                    $this->show_employees_without_self_assessment_invitation,
                                                                                    $this->assessmentCycle);
            $employees = EmployeeSelectService::getEmployeeInfos($employeeIds);
//            $employeesResults = EmployeesQueries::getSelfAssessmentFilteredEmployees(null,
//                                                                                     $this->show_employees_with_emailaddress,
//                                                                                     null,
//                                                                                     null,
//                                                                                     null,
//                                                                                     null,
//                                                                                     null,
//                                                                                     true,
//                                                                                     $filter_employees_assessment_invitations);
        } else {
            $employeesResults = EmployeesQueries::getEmployeesBasedOnUserLevelCustomFilters(null,
                                                                                            $this->show_employees_with_emailaddress,
                                                                                            null,
                                                                                            null,
                                                                                            null,
                                                                                            null,
                                                                                            null,
                                                                                            true);

            if (@mysql_num_rows($employeesResults) > 0) {
                while ($employee = @mysql_fetch_assoc($employeesResults)) {
                    $employees[] = $employee;
                }
            }
        }
        $tpl->assign('emps', $employees);
    }

    static function getFunctionsSelectHtml ($filter_department_id, $showAdditionalProfiles) {

        $empPrintData = '<select name="SBfunction" id="SBfunction" size="20">';
        $getFunc = selectEmployeesGetFunctionsListFromDb($filter_department_id, $showAdditionalProfiles);

        if (@mysql_num_rows($getFunc) > 0) {
            while ($func_row = @mysql_fetch_assoc($getFunc)) {
                $empPrintData .='<option value="' . $func_row[ID_F] . '">' . $func_row['function'] . '</option>';
            }
        }

        $empPrintData .='</select>';

        return $empPrintData;

    }

    public function fillSafeFormValues(&$safeFormHandler) {
        $safeFormHandler->addIntegerInputFormatType('option');
        if($this->show_employees_with_emailaddress) {
            $safeFormHandler->addIntegerInputFormatType('SBemail');
        }
        if($this->show_employees_without_self_assessment_invitation) {
            $safeFormHandler->addIntegerInputFormatType('SBself_assessment_not_invited');
        }
        if($this->show_employees_with_both_completed_assessment) {
            $safeFormHandler->addIntegerInputFormatType('SBself_assessment_both_completed');
        }
        $safeFormHandler->addIntegerInputFormatType('SBdepartment');
        if($this->show_functions) {
            $safeFormHandler->addIntegerInputFormatType('SBfunction');
        }
        if($this->show_bosses) {
            $safeFormHandler->addIntegerInputFormatType('SBbosses');
        }
        $safeFormHandler->addIntegerArrayInputFormatType('SBcross');
    }

    public function validateFormInput($FORM_array)
    {
        // Deze functie valideert de formwaarden die worden doorgegeven, checkt met name
        // of alle verplichte/noodzakelijke (combinaties van) invulvelden zijn ingevuld.
        //
        // geeft false terug als er iets mist en dan is $this->errorTxt gevuld.

        $radio     = empty($FORM_array['option']) ? 0 : $FORM_array['option'];
        $id_func   = $FORM_array['SBfunction'];
        $id_dept   = $FORM_array['SBdepartment'];
        $id_bosses = $FORM_array['SBbosses'];
        //$id_empl   = $FORM_array['SBemployee'];
        $cross_sel = $FORM_array['SBcross'];

        // Filters overnemen uit formulier
        $this->show_employees_with_emailaddress = !empty($FORM_array['SBemail']) ? true : false;
        $this->show_employees_without_self_assessment_invitation = !empty($FORM_array['SBself_assessment_not_invited']) ? true : false;
        $this->show_employees_with_both_completed_assessment = !empty($FORM_array['SBself_assessment_both_completed']) ? true : false;


        $this->errorTxt = '';
        $hasError = false;

        // check voor option-keuze de bijbehorende invulvelden ...

        switch ($radio) {
            case EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION:
                // EMPLOYEE / CROSS SELECTION
                if (empty($cross_sel)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_AN_EMPLOYEE_ON_CROSS_SELECTION') . "\n";
                    $hasError = true;
                }
                break;

            case EMPLOYEE_SELECT_DEPARTMENT:
                // (SELECT EMPLOYEES IN A) DEPARTMENT
                if (empty($id_dept)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_DEPARTMENT') . "\n";
                    $hasError = true;
                }
                break;

            case EMPLOYEE_SELECT_JOB_PROFILE:
                // SELECT FUNCTION GROUP
                if (empty($id_func)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE') . "\n";
                    $hasError = true;
                }
                break;

            case EMPLOYEE_SELECT_JOB_PROFILE_WITHIN_DEPARTMENT:
                // SELECT FUNCTION GROUP IN A DEPARTMENT
                if (empty($id_func)  ||  empty($id_dept)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE_AND_A_DEPARTMENT') . "\n";
                    $hasError = true;
                }
                break;

            case EMPLOYEE_SELECT_ALL_EMPLOYEES:
                // SELECT ALL EMPLOYEES
                // hier hoeft geen tweede invulveld te zijn ingevuld.
                break;

            case EMPLOYEE_SELECT_EMPLOYEES_AGAINST_JOB_PROFILE:
                // EMPLOYEES AGAINST JOB_PROFILE
                // sdj: nog niet uitgewerkt ...
                break;

            case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER:
                // BOSSES
                if (empty($id_bosses)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_BOSS') . "\n";
                    $hasError = true;
                }
                break;

            case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER_NEW:
                // BOSSES (new version)
                if (empty($cross_sel)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_AN_EMPLOYEE_ON_CROSS_SELECTION_AFTER_BOSS') . "\n";
                    return false;
                }
                break;

            case EMPLOYEE_SELECT_DEPARTMENT_NEW:
                // (SELECT EMPLOYEES IN A) DEPARTMENT (new version)
                if (empty($cross_sel)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_AN_EMPLOYEE_ON_CROSS_SELECTION_AFTER_DEPARTMENT') . "\n";
                    return false;
                }
                break;

            default:
                // radio option value is niet [1, ... ,9]
                $this->errorTxt .= TXT_UCF('PLEASE_GIVE_VALUE_FOR_OPTION') . "\n";
                $hasError = true;
                break;

        } // END SWITCH

        return !$hasError;

    } // END OF validateFormInput


    private function createMysqlQuery($FORM_array)
    {
        // Deze functie genereert aan de hand van de formulier data ($FORM_array)
        // wat voor query moet worden samengesteld om op basis van enkele medewerker,
        // functieprofiel groep, fuctieprofiel binnen afdeling, willekeurige selectie
        // of alle mederwerkers mode een lijst/SQL kolom met medewerkers te krijgen.
        //
        // NB
        // Voorheen checkte deze functie ook de formulierinhoud (of velden die noodzakelijk zijn
        // ook zijn ingevuld). Deze functionaliteit zit er nog in, functie stopt op het moment dat
        // het formulierinhoud mist en returned false en set validQuery op FALSE. De variabele
        // errorTxt wordt ook aangevuld met een foutmelding.
        //

        $radio     = empty($FORM_array['option']) ? 0 : $FORM_array['option'];
        $id_func   = $FORM_array['SBfunction'];
        $id_dept   = $FORM_array['SBdepartment'];
        $bosses_sel  = $FORM_array['SBbosses'];
        //$id_empl   = $FORM_array['SBemployee'];
        $cross_sel = $FORM_array['SBcross'];

        $this->mysqlQuery = '';
        $this->employees_query_result = null;
        $this->validQuery = true;
        $this->errorTxt = '';
        $hasError = false;

        $employeesQueries = new EmployeesQueries();
        $employeesResult = null;

        switch ($radio) {
            case EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION:
                // EMPLOYEE / CROSS SELECTION
                // ID_E IN (lijst met ID_Es van cross_selectie)
                //if (empty($FORM_array["cross"])) {
                if (empty($cross_sel)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_AN_EMPLOYEE_ON_CROSS_SELECTION') . "\n";
                    $this->validQuery = false;
                    $hasError = true;
                } else {

                    // waarden in cross_sel Array naar integers veranderen (voor het geval ze dat nog niet waren)
                    for ($index = 0; $index < count($cross_sel); $index++) {
                        $cross_sel[$index] = intval($cross_sel[$index]);
                    }

                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, $cross_sel, null, null, null, null, true);

                    $this->selectionBasedOnString = TXT_UCF('CROSS_SELECTION');
                }
                break;

            case EMPLOYEE_SELECT_DEPARTMENT:
                // (SELECT EMPLOYEES IN A) DEPARTMENT
                // ID_DEPT == $id_dept

                if (empty($id_dept)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_DEPARTMENT') . "\n";
                    $this->validQuery = false;
                    $hasError = true;
                } else {
                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, null, null, $id_dept, null, null, true);

                    $this->selectionBasedOnString = TXT_UCF('DEPARTMENT') . ': ' . DepartmentsService::getDepartmentName($id_dept);
                }
                break;

            case EMPLOYEE_SELECT_JOB_PROFILE:
                // SELECT FUNCTION GROUP
                // ID_FID == $id_func
                //if (empty($FORM_array["function"])) {
                if (empty($id_func)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE') . "\n";
                    $this->validQuery = false;
                    $hasError = true;
                } else {

                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, null, $id_func, null, null, null, true);

                    $functionResult = FunctionQueriesDeprecated::getFunction($id_func);
                    $function_info = @mysql_fetch_assoc($functionResult);
                    $function = $function_info['function'];

                    $this->selectionBasedOnString = TXT_UCF('JOB_PROFILE_GROUP') . ": " . $function;
                }
                break;

            case EMPLOYEE_SELECT_JOB_PROFILE_WITHIN_DEPARTMENT:
                // SELECT FUNCTION GROUP IN A DEPARTMENT
                // ID_DEPT == $id_dept  &&  ID_FID == $id_func
                //$id_func   = $FORM_array['function'];
                //$id_dept   = $FORM_array['department'];

                //if (empty($FORM_array["function"])  ||  empty($FORM_array["department"])) {
                if (empty($id_func)  ||  empty($id_dept)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE_AND_A_DEPARTMENT') . "\n";
                    $this->validQuery = false;
                    $hasError = true;
                } else {

                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, null, $id_func, $id_dept, null, null, true);

                    $departmentResult = DepartmentQueriesDeprecated::getAllowedDepartments($id_dept);
                    $department_info = @mysql_fetch_assoc($departmentResult);
                    $department = $department_info['department'];

                    $functionResult = FunctionQueriesDeprecated::getFunction($id_func);
                    $function_info = @mysql_fetch_assoc($functionResult);
                    $function = $function_info['function'];

                    $this->selectionBasedOnString = TXT_UCF('JOB_PROFILE_GROUP_IN_DEPARTMENT') . ": " . $function . " / " . $department ;
                }
                break;

            case EMPLOYEE_SELECT_ALL_EMPLOYEES:
                // SELECT ALL EMPLOYEES
                // select * , geen where ...

                // geen 'where'-deel, omdat ALLE medewerkers moeten worden getoond.

                $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, null, null, null, null, null, true);
                $this->selectionBasedOnString = TXT_UCF('ALL_EMPLOYEES');
                break;

            case EMPLOYEE_SELECT_EMPLOYEES_AGAINST_JOB_PROFILE:
                // EMPLOYEES AGAINST JOB_PROFILE
                // sdj: nog niet uitgewerkt ...
                $this->selectionBasedOnString = TXT_UCF('EMPLOYEES_AGAINST_JOB_PROFILE');
                break;

            case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER:
                // EMPLOYEES WITH BOSS
                // iets met $bosses_sel
                if (empty($bosses_sel)) {
                    $this->errorTxt .= TXT_UCF('PLEASE_SELECT_A_BOSS_ON_CROSS_SELECTION') . "\n";
                    $this->validQuery = false;
                    $hasError = true;
                } else {
                    // waarden in cross_sel Array naar integers veranderen (voor het geval ze dat nog niet waren)
                    for ($index = 0; $index < count($bosses_sel); $index++) {
                        $bosses_sel[$index] = intval($bosses_sel[$index]);
                    }
                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, null, null, null, null, $bosses_sel, true);

                    $this->selectionBasedOnString = TXT_UCF('EMPLOYEES_BOSSES');
                }
                break;

                // TODO: hbd: dit heb ik overgenomen uit de sprint 10 branch maar werkt niet meer zo!
                case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER_NEW:
                    // EMPLOYEES WITH BOSS (new version)
                    // Er wordt nu naar Cross selection gekeken

                    if (empty($cross_sel)) {
                        $this->errorTxt .= TXT_UCF('PLEASE_SELECT_AN_EMPLOYEE_ON_CROSS_SELECTION_AFTER_BOSS') . "\n";
                        $this->validQuery = false;
                        return false;
                    }

                    // waarden in cross_sel Array naar integers veranderen (voor het geval ze dat nog niet waren)
                    for ($index = 0; $index < count($cross_sel); $index++) {
                        $cross_sel[$index] = intval($cross_sel[$index]);
                    }

                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, $cross_sell, null, null, null, $bosses_sel, true);

                    $this->selectionBasedOnString = TXT_UCF('CROSS_SELECTION');

                    break;

                // TODO: hbd: dit heb ik overgenomen uit de sprint 10 branch maar werkt niet meer zo!
                case EMPLOYEE_SELECT_DEPARTMENT_NEW:
                    // (SELECT EMPLOYEES IN A) DEPARTMENT (new version)
                    // Er wordt nu naar Cross selection gekeken

                    if (empty($cross_sel)) {
                        $this->errorTxt .= TXT_UCF('PLEASE_SELECT_AN_EMPLOYEE_ON_CROSS_SELECTION_AFTER_DEPARTMENT') . "\n";
                        $this->validQuery = false;
                        return false;
                    }

                    // waarden in cross_sel Array naar integers veranderen (voor het geval ze dat nog niet waren)
                    for ($index = 0; $index < count($cross_sel); $index++) {
                        $cross_sel[$index] = intval($cross_sel[$index]);
                    }

                    $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel(null, $cross_sel, null, $id_dept, null, null, true);

                    $this->selectionBasedOnString = TXT_UCF('DEPARTMENT') . ': ' . DepartmentsService::getDepartmentName($id_dept);

                    break;

            default:
                // radio option value is niet [1, ... ,5]
                $this->errorTxt .= TXT_UCF('PLEASE_GIVE_VALUE_FOR_OPTION') . "\n";
                $this->validQuery = false;
                $hasError = true;
                break;
        } // END SWITCH

        if ($this->validQuery) {
            $this->employees_query_result = $employeesResult;
            $this->selectedDepartmentId = $id_dept;
            $this->selectedFunctionId = $id_func;
        }
        return !$hasError;

    } // END OF createMysqlQuery

    // hbd: TODO: waarom hier weer dezelfde queries als bij fillComponent? levert slecht onderhoudbare code op door alles dubbel te doen
    private function filterResults ($FORM_array) {
        // Deze variant ondersteunt NIET neven-functieprofielen

        $filter_department_id = !empty($FORM_array['SBdepartment']) && is_numeric($FORM_array['SBdepartment']) ? intval($FORM_array['SBdepartment']) : null;
        $filter_job_profile_id = !empty($FORM_array['SBfunction']) && is_numeric($FORM_array['SBfunction']) ? intval($FORM_array['SBfunction']) : null;
        $filter_boss_id = !empty($FORM_array['SBbosses']) && is_array($FORM_array['SBbosses']) && is_numeric($FORM_array['SBbosses'][0]) ? intval($FORM_array['SBbosses'][0]) : null;
        $selected_employees = !empty($FORM_array['SBcross']) ? $FORM_array['SBcross'] : null;

        $filter_employees_assessment_invitations = $this->show_employees_without_self_assessment_invitation ? FILTER_EMPLOYEES_EMPLOYEE_NOT_INVITED : FILTER_EMPLOYEES_ALPHABETICAL;
        $filter_employees_assessment_invitations = $this->show_employees_with_both_completed_assessment ? FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN_NO_LOS : ($this->selfassessment_active ? FILTER_EMPLOYEES_EMPLOYEE_INVITED_NO_LOS :$filter_employees_assessment_invitations);

        $employees_array = array();
        if ($this->useSelfAssessmentFilter) {
            if (empty($selected_employees)) {
                $employeeIds = EmployeeSelectService::getEmployeeIdsForSelectComponent( $filter_boss_id,
                                                                                        EmployeeSelectService::ALL_NAMES,
                                                                                        $filter_department_id,
                                                                                        $filter_job_profile_id,
                                                                                        $this->show_employees_with_emailaddress,
                                                                                        $this->show_employees_without_self_assessment_invitation,
                                                                                        $this->assessmentCycle);
                $employees_array = explode($employeeIds, ',');
            } else {
                // dit zou dan toch voldoende moeten zijn? Er zijn kennelijk al medewerkers gekozen,
                // en die lijst is al bepaald door de filtering...
                $employees_array = $selected_employees;
            }
            if (!empty($selected_employees)) {

            }
//            $getEmp = EmployeesQueries::getSelfAssessmentFilteredEmployees(null,
//                                                                           $this->show_employees_with_emailaddress,
//                                                                           $selected_employees,
//                                                                           $filter_job_profile_id,
//                                                                           $filter_department_id,
//                                                                           null,
//                                                                           $filter_boss_id,
//                                                                           false,
//                                                                           $filter_employees_assessment_invitations);

        } else {
            $getEmp = EmployeesQueries::getEmployeesBasedOnUserLevelCustomFilters(null,
                                                                                  $this->show_employees_with_emailaddress,
                                                                                  $selected_employees,
                                                                                  $filter_job_profile_id,
                                                                                  $filter_department_id,
                                                                                  null,
                                                                                  $filter_boss_id,
                                                                                  true);

            while ($getEmp_row = @mysql_fetch_assoc($getEmp)) {
                $employees_array[] = $getEmp_row['ID_E'];
            }
        }

        return $employees_array;
    }

    public function processResults($FORM_array)
    {
        $this->selectedDepartmentId = NULL;
        $this->selectedFunctionId = NULL;
        $selected_employees = array();
        $this->createMysqlQuery($FORM_array);
        if ($this->validQuery) {
            // Extra filters toepassen
            if ($this->show_employees_with_emailaddress ||
                $this->show_employees_without_self_assessment_invitation ||
                $this->show_employees_with_both_completed_assessment) {
                $selected_employees = $this->filterResults($FORM_array);
            } else {
                $selected_employees = $this->filterResults($FORM_array);
//                $sql = $this->mysqlQuery;
//                $res = BaseQueries::performQuery($sql);
//                $selected_employees = MysqlUtils::result2Array($res);
            }
//            while ($employee = @mysql_fetch_assoc($this->employees_query_result)) {
//                $selected_employees[] = $employee['ID_E'];
//            }
        }

        return $selected_employees;
    }

    public function getSelectedDetails()
    {
        return array(   $this->selectedDepartmentId,
                        $this->selectedFunctionId);
    }

    public function getResults()
    {
        die('programmer: invalid for employees, use processResults instead.');
    }
} // end class SelectEmployees


//function selectEmployees_getFunctionList($id_dept, $showAdditionalProfiles) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
//        $employeeFunctionSelect = '<select name="SBfunction" id="SBfunction" size="20">';
//
//        $functionResult = selectEmployeesGetFunctionsListFromDb($id_dept, $showAdditionalProfiles);
//
//        if (@mysql_num_rows($functionResult) > 0) {
//            while ($function = @mysql_fetch_assoc($functionResult)) {
//                $employeeFunctionSelect .='<option value="' . $function['ID_F'] . '">' . $function['function'] . '</option>';
//            }
//        }
//        $employeeFunctionSelect .='</select>';
//        $objResponse->assign('functionID', 'innerHTML', $employeeFunctionSelect);
//    }
//
//    return $objResponse;
//}


/**
 * Xajax function.
 * @param string $option needed to determine enabled/disabled
 * 0/1 $showAdditionalProfiles
 * @return xajaxResponse
 */
//function selectEmployees_getAllFunctionsList($option, $showAdditionalProfiles) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
//
//        if ($option == 4) {
//            // "functieprofiel binnen afdeling", dan moeten na op een afdeling te hebben geklikt alleen
//            // functieprofielen worden getoond die in die afdeling voorkomen
//            $objResponse->addEvent('SBdepartment', 'onchange', 'xajax_selectEmployees_getFunctionList(this.options[this.selectedIndex].value, ' . $showAdditionalProfiles . ');return false;');
//        } else {
//            // bovengenoemde functionaliteit is niet nodig
//            $objResponse->clear('SBdepartment', 'onchange');
//        }
//
//        if ($option == 7) {
//            $objResponse->clear('SBbosses', 'className');
//        } else {
//            $objResponse->assign('SBbosses', 'className', 'disabled');
//        }
//
//
//        if ($option == 1  ||  $option == 6) {
//            $objResponse->clear('SBcross', 'className');
//        } else {
//            $objResponse->assign('SBcross', 'className', 'disabled');
//        }
//
//        if ($option == 2  ||  $option == 4) {
//            $objResponse->clear('SBdepartment', 'className');
//        } else {
//            $objResponse->assign('SBdepartment', 'className', 'disabled');
//        }
//
//        // dit zou niet nodig hoeven zijn, wordt ook gedaan door javascript, maar deze xajax call wordt blijkbaar na javascript
//        // uitgevoerd, waardoor de hieronder getoonde disabled instelling van xajax de uiteindelijke toestand veroorzaakt.
//        if ($option != 3 && $option != 4 && $option != 6 ) {
//            $disabled = ' disabled="disabled" class="disabled"';
//        }
//
//        //$getFunc = selectEmployeesGetFunctionsListFromDb(USER_LEVEL, PERMISSION_USER_DEPARTMENTS, USER_ID, "all", ($showAdditionalProfiles == 1));
//        $functionQueries = new FunctionQueriesDeprecated();
//        $functionResult = $functionQueries->getFunctionsBasedOnUserLevel(null,null,null,null,null,null,$showAdditionalProfiles);
//
//
//        $functionSelect = '<select name="SBfunction" id="SBfunction" size="20"' . $disabled . '>';
//        if (@mysql_num_rows($functionResult) > 0) {
//            while ($function = @mysql_fetch_assoc($functionResult)) {
//                $functionSelect .='<option value="' . $function['ID_F'] . '">' . $function['function'] . '</option>';
//            }
//        }
//        $functionSelect .='</select>';
//        $objResponse->assign('functionID', 'innerHTML', $functionSelect);
//    }
//
//    return $objResponse;
//}

/*
 * Deze functie geeft afhankelijk van rechten van gebruiker een lijst van functieprofielen terug
 * (als database query resultaat) van of alle (voor de gebruiker vrijgestelde) afdelingen of voor
 * een specifieke afdeling.
 *
 * nevenfunctieprofielen worden meegenomen
 */
function selectEmployeesGetFunctionsListFromDb($dept, $select_additional_functions) {

    $functionQueries = new FunctionQueriesDeprecated();
    $getFunc = $functionQueries->getFunctionsBasedOnUserLevel(  null,
                                                                null,
                                                                null,
                                                                $dept,
                                                                null,
                                                                null,
                                                                $select_additional_functions);

    return $getFunc;
}

//function selectEmployees_searchEmployee($s_employee_text) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
//        $employeesQueries = new EmployeesQueries();
//        $employeesResult = $employeesQueries->getEmployeesBasedOnUserLevel($s_employee_text);
//
//        $selectEmployees = '<select name="SBcross[]" id="SBcross" size="18" multiple="multiple">';
//
//        if (@mysql_num_rows($employeesResult) > 0) {
//            while($employee = @mysql_fetch_assoc($employeesResult)) {
//                $employee_name = ModuleUtils::EmployeeName($employee['firstname'], $employee['lastname']);
//                $selectEmployees .= '<option value="' . $employee['ID_E'] . '">' . $employee_name . '</option>';
//            }
//        }
//
//        $selectEmployees .= '</select>';
//
//        $objResponse->assign('employeesID', 'innerHTML', $selectEmployees);
//    }
//
//    return $objResponse;
//}

function moduleSelectEmployees_control($option, $trigger_source, $showAdditionalProfiles, $a_formValues)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && is_numeric($option) && is_numeric($trigger_source)) {
        $fill_employees = false;
        $fill_job_profiles = false;

        $filter_employee_name = !empty($a_formValues['selempsearchtext']) ? htmlspecialchars($a_formValues['selempsearchtext']) : null;
        $filter_department_id = !empty($a_formValues['SBdepartment']) && is_numeric($a_formValues['SBdepartment']) ? intval($a_formValues['SBdepartment']) : null;
        $filter_job_profile_id = !empty($a_formValues['SBfunction']) && is_numeric($a_formValues['SBfunction']) ? intval($a_formValues['SBfunction']) : null;
        $filter_boss_id = !empty($a_formValues['SBbosses']) && is_array($a_formValues['SBbosses']) && is_numeric($a_formValues['SBbosses'][0]) ? intval($a_formValues['SBbosses'][0]) : null;
        $filter_employee_email_filled_in = !empty($a_formValues['SBemail']) ? 1 : 0;
        $filter_employee_assesment_invited = !empty($a_formValues['SBself_assessment_not_invited']) ? FILTER_EMPLOYEES_EMPLOYEE_NOT_INVITED : FILTER_EMPLOYEES_ALPHABETICAL;
        $filter_employee_assesment_invited = !empty($a_formValues['SBself_assessment_both_completed']) ? FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN_NO_LOS : (!empty($a_formValues['selfassessment_active']) ? FILTER_EMPLOYEES_EMPLOYEE_INVITED_NO_LOS :$filter_employee_assesment_invited);

        // Option verandering.
        if ($trigger_source == EMPLOYEE_SELECT_TRIGGER_SOURCE_OPTION_CHANGE) {
            switch ($option) {
                case EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION:
                    $fill_employees = true;

                    $objResponse->clear('SBcross', 'className');
                    $objResponse->assign('SBcross','disabled', false);

                    if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT) {
                        $objResponse->clear('selempsearchtext', 'className');
                        $objResponse->assign('selempsearchtext','disabled', false);
                    }

                    break;
                case EMPLOYEE_SELECT_DEPARTMENT:
                    $objResponse->clear('SBdepartment', 'className');
                    $objResponse->assign('SBdepartment','disabled', false);

                    break;
                case EMPLOYEE_SELECT_JOB_PROFILE:
                    $objResponse->clear('SBfunction', 'className');
                    $objResponse->assign('SBfunction','disabled', false);

                    $empPrintData = SelectEmployees::getFunctionsSelectHtml(NULL, $showAdditionalProfiles);

                    $objResponse->assign('functionID', 'innerHTML', $empPrintData);

                    break;
                case EMPLOYEE_SELECT_JOB_PROFILE_WITHIN_DEPARTMENT:
                    $objResponse->clear('SBdepartment', 'className');
                    $objResponse->assign('SBdepartment','disabled', false);
                    $objResponse->addEvent('SBdepartment', 'onchange', 'xajax_moduleSelectEmployees_control(0, ' . EMPLOYEE_SELECT_TRIGGER_SOURCE_FILTER_CHANGE . ', ' . $showAdditionalProfiles .  ', xajax.getFormValues(this.form.id)); return false;');

                    $objResponse->clear('SBfunction', 'className');
                    $objResponse->assign('SBfunction','disabled', false);
                    $fill_job_profiles = true;

                    break;
                case EMPLOYEE_SELECT_ALL_EMPLOYEES:
                    break;
                case EMPLOYEE_SELECT_EMPLOYEES_AGAINST_JOB_PROFILE:
                    // WS 19-06-2012: Nooit uitgewerkt. Wordt ook nergens aangezet.
                    break;
                case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER:
                    $objResponse->clear('SBbosses', 'className');
                    $objResponse->assign('SBbosses','disabled', false);

                    break;
                case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER_NEW:
                    $objResponse->clear('SBbosses', 'className');
                    $objResponse->assign('SBbosses','disabled', false);

                    $objResponse->clear('SBbosses', 'className');
                    $objResponse->assign('SBbosses','disabled', false);

                    if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT) {
                        $objResponse->clear('selempsearchtext', 'className');
                        $objResponse->assign('selempsearchtext','disabled', false);
                    }

                    $objResponse->addEvent('SBbosses', 'onchange', 'xajax_moduleSelectEmployees_control(0, ' . EMPLOYEE_SELECT_TRIGGER_SOURCE_FILTER_CHANGE . ', ' . $showAdditionalProfiles .  ', xajax.getFormValues(this.form.id));return false;');

                    break;
                case EMPLOYEE_SELECT_DEPARTMENT_NEW:
                    $objResponse->clear('SBdepartment', 'className');
                    $objResponse->assign('SBdepartment','disabled', false);

                    if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT) {
                        $objResponse->clear('selempsearchtext', 'className');
                        $objResponse->assign('selempsearchtext','disabled', false);
                    }

                    $objResponse->addEvent('SBdepartment', 'onchange', 'xajax_moduleSelectEmployees_control(0, ' . EMPLOYEE_SELECT_TRIGGER_SOURCE_FILTER_CHANGE . ', ' . $showAdditionalProfiles .  ', xajax.getFormValues(this.form.id));return false;');

                    break;
                default:

            }
        }

        // Filters zijn aangepast.
        if ($trigger_source == EMPLOYEE_SELECT_TRIGGER_SOURCE_FILTER_CHANGE &&
            is_array($a_formValues) && is_numeric($a_formValues['option'])) {
            $option = intval($a_formValues['option']);

            //die(print_r($a_formValues,true));

            switch ($option) {
                case EMPLOYEE_SELECT_SINGLE_EMPLOYEE_RANDOM_SELECTION:
                    $fill_employees = true;

                    break;
                case EMPLOYEE_SELECT_JOB_PROFILE_WITHIN_DEPARTMENT:
                    if (!empty($filter_department_id)) {
                        $fill_job_profiles = true;
                    }

                    break;
                case EMPLOYEE_SELECT_EMPLOYEES_WITH_MANAGER_NEW:
                    if (!empty($filter_boss_id)) {
                        $fill_employees = true;
                    }

                    break;
                case EMPLOYEE_SELECT_DEPARTMENT_NEW:
                    if (!empty($filter_department_id)) {
                        $fill_employees = true;
                    }

                    break;
            }
        }

        if ($fill_employees) {
            $select_element_size = 20;
            $select_element_size = CUSTOMER_OPTION_SHOW_EMPLOYEES_COUNT ? $select_element_size - 2 : $select_element_size;
            $select_element_size = CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT ? $select_element_size - 2 : $select_element_size;
            $empPrintData = '<select name="SBcross[]" id="SBcross" size="' . $select_element_size . '" multiple="multiple">';
            // deze CUSTOMER_OPTION check lijkt me niet helemaal terecht.
            // in het originele SelectEmployees.class wordt een property gezet, hiernaar zou gekeken moeten worden...
            // ook de andere instellingen van de class zoals currentCycle zijn nu niet beschikbaar :-(
            if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
                $aantal_employees = 0;
                // helaas, instellingen ($assessmentCycle) in het object niet beschikbaar, dan maar even zo de huidige ophalen...
                $currentCycle = AssessmentCycleService::getCurrentValueObject();

                $employeeIds = EmployeeSelectService::getEmployeeIdsForSelectComponent( $filter_boss_id,
                                                                                        $filter_employee_name,
                                                                                        $filter_department_id,
                                                                                        $filter_job_profile_id,
                                                                                        $filter_employee_email_filled_in,
                                                                                        $filter_employee_assesment_invited,
                                                                                        $currentCycle);
                //die('$employeeIds:'."$employeeIds");
                if (!empty($employeeIds)) {
                    $employeeIdValues = EmployeeSelectService::getEmployeeIdValues($employeeIds);
                    $aantal_employees = count($employeeIdValues);
                    foreach($employeeIdValues as $employeeIdValue) {
                        $empPrintData .='<option value="' . $employeeIdValue->getDatabaseId() . '">' . $employeeIdValue->getValue() . '</option>';
                    }
                }

//                $getEmp = EmployeesQueries::getSelfAssessmentFilteredEmployees($filter_employee_name,
//                                                                               $filter_employee_email_filled_in,
//                                                                               null,
//                                                                               $filter_job_profile_id,
//                                                                               $filter_department_id,
//                                                                               null,
//                                                                               $filter_boss_id,
//                                                                               true,
//                                                                               $filter_employee_assesment_invited);
            } else {
                $getEmp = EmployeesQueries::getEmployeesBasedOnUserLevelCustomFilters($filter_employee_name,
                                                                                      $filter_employee_email_filled_in,
                                                                                      null,
                                                                                      $filter_job_profile_id,
                                                                                      $filter_department_id,
                                                                                      null,
                                                                                      $filter_boss_id,
                                                                                      true);
                $aantal_employees =@mysql_num_rows($getEmp);
                if ($aantal_employees > 0) {

                    while ($emp_row = @mysql_fetch_assoc($getEmp)) {
                        $employee_name = ModuleUtils::EmployeeName($emp_row['firstname'], $emp_row['lastname']);
                        $empPrintData .='<option value="' . $emp_row['ID_E'] . '">' . $employee_name . '</option>';
                    }
                }
            }
            $empPrintData .='</select>';

            $objResponse->assign('employeesID', 'innerHTML', $empPrintData);
            $objResponse->assign('employee_counter', 'innerHTML', $aantal_employees);
        }

        if ($fill_job_profiles) {

            $empPrintData = SelectEmployees::getFunctionsSelectHtml($filter_department_id, $showAdditionalProfiles);
            $objResponse->assign('functionID', 'innerHTML', $empPrintData);

        }
    }

    return $objResponse;
}
?>
