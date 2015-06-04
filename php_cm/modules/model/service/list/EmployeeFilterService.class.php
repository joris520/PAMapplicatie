<?php

/**
 * Description of EmployeeFilterService
 *
 * @author ben.dokter
 */

// queries
require_once('modules/model/queries/list/EmployeeFilterQueries.class.php');
require_once('modules/model/queries/employee/EmployeeInfoQueries.class.php');

// value
require_once('modules/model/value/list/EmployeeAssessmentFilterValue.class.php');
require_once('modules/model/value/list/EmployeeSortFilterValue.class.php');
require_once('modules/model/value/list/BossFilterValue.class.php');

// conversie
require_once('modules/interface/converter/list/BossFilterConverter.class.php');

require_once('modules/interface/state/AssessmentProcessEvaluationState.class.php');

// letop: gegevens worden bijgehouden in de sessie!
class EmployeeFilterService
{

    /* private */ const SESSION_STORE_SEARCH_EMPLOYEE    = 's_employee';
    /* private */ const SESSION_STORE_FILTER_ASSESSMENT  = 'i_assessment_filter';
    /* private */ const SESSION_STORE_FILTER_BOSS        = 'i_boss_filters';
    /* private */ const SESSION_STORE_FILTER_DEPARTMENT  = 'i_department_filters';
    /* private */ const SESSION_STORE_FILTER_FUNCTION    = 'i_function_filters';
    /* private */ const SESSION_STORE_FILTER_SORT        = 'i_sort_filters';
    /* private */ const SESSION_STORE_FILTERS_VISIBLE    = 'b_visibility_filters';

    const CLEAR_FILTER = 1;
    const KEEP_FILTER = 2;
    const NO_EMPLOYEEID_FILTER   = NULL;

    static function initializeSession($doClear = self::KEEP_FILTER)
    {
        // search
        self::initializeEmployeeSearch($doClear);

        if (USER_LEVEL > UserLevelValue::MANAGER) { // medewerker
            ApplicationNavigationService::storeSelectedEmployeeId(EMPLOYEE_ID);
        }

        // filter
        // default op evaluatie status
        self::initializeAssessmentFilter($doClear);
        self::initializeSortFilter($doClear);
        self::initializeBossFilter($doClear);
        self::initializeDepartmentFilter($doClear);
        self::initializeFunctionFilter($doClear);

    }

    static function hasActiveFilters()
    {
        return  self::hasActiveAssessmentFilter() ||
                self::hasActiveBossFilter() ||
                self::hasActiveDepartmentFilter() ||
                self::hasActiveFunctionFilter();
    }

    ////////////////////////////////////////////////////////////////
    // employee search
    ////////////////////////////////////////////////////////////////

    static function initializeEmployeeSearch($doClear = self::CLEAR_FILTER)
    {
        if ($doClear == self::CLEAR_FILTER) {
            unset($_SESSION[self::SESSION_STORE_SEARCH_EMPLOYEE]);
        }
    }

    static function storeEmployeeSearch($employeeSearchString)
    {
        $_SESSION[self::SESSION_STORE_SEARCH_EMPLOYEE] = $employeeSearchString;
    }

    static function retrieveEmployeeSearch()
    {
        return @$_SESSION[self::SESSION_STORE_SEARCH_EMPLOYEE];
    }

    static function hasEmployeeSearch()
    {
        return !empty($_SESSION[self::SESSION_STORE_SEARCH_EMPLOYEE]);
    }

    ////////////////////////////////////////////////////////////////
    // filter permission
    ////////////////////////////////////////////////////////////////

    static function getShowFilterPermission()
    {
        $showAssessmentFilter = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER);
        $showBossFilter       = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_BOSS_FILTER);
        $showDepartmentFilter = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_DEPARTMENT_FILTER);
        $showFunctionFilter   = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_FUNCTION_FILTER);
        $showSortFilter       = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER) ||
                                PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE);

        return $showAssessmentFilter || $showBossFilter || $showDepartmentFilter || $showFunctionFilter || $showSortFilter;
    }

    ////////////////////////////////////////////////////////////////
    // employee sort
    ////////////////////////////////////////////////////////////////

    static function initializeSortFilter($doClear = self::CLEAR_FILTER)
    {
        if ($doClear == self::CLEAR_FILTER) {
            unset($_SESSION[self::SESSION_STORE_FILTER_SORT]);
        }
        if (!self::hasSortFilter()) {
            if (PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER)) {
                self::storeSortFilter(  EmployeeSortFilterValue::SORT_ASSESSMENT_STATE);
            } else {
                self::storeSortFilter(  EmployeeSortFilterValue::SORT_ALPHABETICAL);
            }
        }

    }

    static function storeSortFilter($employeeSortValue)
    {
        $_SESSION[self::SESSION_STORE_FILTER_SORT] = $employeeSortValue;
    }

    static function retrieveSortFilter($emptyValue = EmployeeSortFilterValue::SORT_ALPHABETICAL)
    {
        return self::hasSortFilter() ? $_SESSION[self::SESSION_STORE_FILTER_SORT] : $emptyValue;
    }

    static function hasSortFilter()
    {
        return !empty($_SESSION[self::SESSION_STORE_FILTER_SORT]);
    }

    ////////////////////////////////////////////////////////////////
    // employee sort
    ////////////////////////////////////////////////////////////////

    static function initializeIsFiltersVisible($doClear = self::CLEAR_FILTER)
    {
        if ($doClear == self::CLEAR_FILTER) {
            unset($_SESSION[self::SESSION_STORE_FILTERS_VISIBLE]);
        }
    }

    static function toggleIsFiltersVisible()
    {
        self::storeIsFiltersVisible(   !self::retrieveIsFiltersVisible());
    }

    static function storeIsFiltersVisible($employeeSortValue)
    {
        $_SESSION[self::SESSION_STORE_FILTERS_VISIBLE] = $employeeSortValue;
    }

    static function retrieveIsFiltersVisible()
    {
        return self::hasIsFiltersVisible() ? @$_SESSION[self::SESSION_STORE_FILTERS_VISIBLE] :  false;
    }

    static function hasIsFiltersVisible()
    {
        return !empty($_SESSION[self::SESSION_STORE_FILTERS_VISIBLE]);
    }


    ////////////////////////////////////////////////////////////////
    // employee filter
    ////////////////////////////////////////////////////////////////

    static function initializeAssessmentFilter($doClear = self::CLEAR_FILTER)
    {

        if ($doClear == self::CLEAR_FILTER ||
            PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER)) {
            unset($_SESSION[self::SESSION_STORE_FILTER_ASSESSMENT]);
        }
    }

    static function storeAssessmentFilter($employeeFilterValue)
    {
        $_SESSION[self::SESSION_STORE_FILTER_ASSESSMENT] = $employeeFilterValue;
    }

    static function retrieveAssessmentFilter($emptyValue = EmployeeAssessmentFilterValue::ANY)
    {
        return self::hasActiveAssessmentFilter() ? $_SESSION[self::SESSION_STORE_FILTER_ASSESSMENT] : $emptyValue;
    }


    static function hasActiveAssessmentFilter()
    {
        return !empty($_SESSION[self::SESSION_STORE_FILTER_ASSESSMENT]);
    }

    ////////////////////////////////////////////////////////////////
    // boss filter
    ////////////////////////////////////////////////////////////////

    static function initializeBossFilter($doClear = self::CLEAR_FILTER)
    {
        if ($doClear == self::CLEAR_FILTER ||
            PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_BOSS_FILTER)) {
            unset($_SESSION[self::SESSION_STORE_FILTER_BOSS]);
        }
    }

    static function storeBossFilter($bossFilterValue)
    {
        $_SESSION[self::SESSION_STORE_FILTER_BOSS] = $bossFilterValue;
    }

    static function retrieveBossFilter()
    {
        if (PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_BOSS_FILTER) &&
            USER_LEVEL == UserLevelValue::MANAGER) {
            self::storeBossFilter(EMPLOYEE_ID);
        }
        return @$_SESSION[self::SESSION_STORE_FILTER_BOSS];
    }

    static function hasActiveBossFilter()
    {
        if (PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_BOSS_FILTER) &&
            USER_LEVEL == UserLevelValue::MANAGER) {
            $hasActiveBossFilter = false;
        } else {
            $hasActiveBossFilter = !empty($_SESSION[self::SESSION_STORE_FILTER_BOSS]);
        }
        return $hasActiveBossFilter;
    }

    static function getBossFilterIdValues($showExtraBossOptions = true)
    {
        $bosses = array();
        if ($showExtraBossOptions) {
            $bosses =   array(
                            IdValue::create(BossFilterValue::HAS_NO_BOSS,
                                            '- ' . BossFilterConverter::input(BossFilterValue::HAS_NO_BOSS) . '-')
                        );
        }

        $bossIdValues = EmployeeSelectService::getBossIdValues();
        if (count($bossIdValues) > 0) {
            // als er leidinggevenden gevonden zijn heeft de optie 'IS_BOSS' ook zin...
            $bosses[] = IdValue::create(BossFilterValue::IS_BOSS,
                                        '- ' . BossFilterConverter::input(BossFilterValue::IS_BOSS) . '-');

            $bosses = array_merge($bosses, $bossIdValues);
        }
        return $bosses;
    }

    ////////////////////////////////////////////////////////////////
    // department filter
    ////////////////////////////////////////////////////////////////

    static function initializeDepartmentFilter($doClear = self::CLEAR_FILTER)
    {
        if ($doClear == self::CLEAR_FILTER ||
            PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_DEPARTMENT_FILTER)) {
            unset($_SESSION[self::SESSION_STORE_FILTER_DEPARTMENT]);
        }
    }

    static function storeDepartmentFilter($departmentFilterValue)
    {
        $_SESSION[self::SESSION_STORE_FILTER_DEPARTMENT] = $departmentFilterValue;
    }

    static function retrieveDepartmentFilter()
    {
        return @$_SESSION[self::SESSION_STORE_FILTER_DEPARTMENT];
    }

    static function hasActiveDepartmentFilter()
    {
        return !empty($_SESSION[self::SESSION_STORE_FILTER_DEPARTMENT]);
    }


    ////////////////////////////////////////////////////////////////
    // function filter
    ////////////////////////////////////////////////////////////////

    static function initializeFunctionFilter($doClear = self::CLEAR_FILTER)
    {
        if ($doClear == self::CLEAR_FILTER ||
            PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_FUNCTION_FILTER)) {
            unset($_SESSION[self::SESSION_STORE_FILTER_FUNCTION]);
        }
    }

    static function storeFunctionFilter($bossFilterValue)
    {
        $_SESSION[self::SESSION_STORE_FILTER_FUNCTION] = $bossFilterValue;
    }

    static function retrieveFunctionFilter()
    {
        return @$_SESSION[self::SESSION_STORE_FILTER_FUNCTION];
    }

    static function hasActiveFunctionFilter()
    {
        return !empty($_SESSION[self::SESSION_STORE_FILTER_FUNCTION]);
    }

    ////////////////////////////////////////////////////////////////
    // acties: filter de employees
    ////////////////////////////////////////////////////////////////

    // haal alle toegestane employeeIds op.
    // ** voor externe functies de EmployeeSelectService varianten gebruiken!!
    static function getAllowedEmployeeIds(  $bossFilterValue,
                                            $filteredEmployeeIds = self::NO_EMPLOYEEID_FILTER,
                                            $searchFilter = null,
                                            $departmentFilterValue = null,
                                            $mainFunctionFilterValue = null,
                                            $onlyWithEmail = false,
                                            $returnAsString = true)
    {
        list($selectIsBoss, $selectHasNoBoss, $selectBossId) = BossFilterValue::explainValue($bossFilterValue);
        $query = EmployeeFilterQueries::selectAllowedEmployeeIds(   $searchFilter,
                                                                    $filteredEmployeeIds,
                                                                    $selectBossId,
                                                                    $selectHasNoBoss,
                                                                    $selectIsBoss,
                                                                    $departmentFilterValue,
                                                                    $mainFunctionFilterValue,
                                                                    $onlyWithEmail);
        $allowedEmployeeIds = array();
        while ($employeeIdData = @mysql_fetch_assoc($query)) {
            $allowedEmployeeIds[] = $employeeIdData[EmployeeFilterQueries::ID_FIELD];
        }
        mysql_free_result($query);

        return $returnAsString ? implode(',',$allowedEmployeeIds) : $allowedEmployeeIds;
    }

    // haal van de gevonden employeeIds de info op
    static function getEmployeeIdValues($filteredEmployeeIds)
    {
        $employees = array();

        if (!empty($filteredEmployeeIds)) {
            $query = EmployeeInfoQueries::getEmployeesInfo($filteredEmployeeIds);
            while ($employeeData = @mysql_fetch_assoc($query)) {
                // TODO: zonder moduleUtils
                $employees[] = IdValue::create($employeeData['ID_E'], EmployeeNameConverter::displaySortable($employeeData['firstname'], $employeeData['lastname']));
            }
            mysql_free_result($query);
        }
        return $employees;

    }

    static function getFilteredEmployeeIdValues()
    {
        // wie willen we zien
        $employeeSearch     = self::retrieveEmployeeSearch();
        $bossFilter         = self::retrieveBossFilter();
        $departmentFilter   = self::retrieveDepartmentFilter();
        $mainFunctionFilter = self::retrieveFunctionFilter();

        // wie mogen we zien...
        $allowedEmployeeIds = self::getAllowedEmployeeIds(  $bossFilter,
                                                            self::NO_EMPLOYEEID_FILTER,
                                                            $employeeSearch,
                                                            $departmentFilter,
                                                            $mainFunctionFilter);

        // dan daar de doorsnede van
        $filteredEmployeeIdValues = self::getEmployeeIdValues($allowedEmployeeIds);//, self::);

        return $filteredEmployeeIdValues;
    }

    static function matchAssessmentFilter($assessmentFilterValue, $scoreSelfAssessmentState, $assessmentProcessEvaluationState)
    {

        $hasMatch = ($assessmentFilterValue == EmployeeAssessmentFilterValue::ANY);
        switch ($assessmentFilterValue) {
            case EmployeeAssessmentFilterValue::INVITED:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_COMPLETED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED:
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_COMPLETED:
                        $hasMatch = true;
                        break;
                }
                //if ($foundMatch) die('INVITED:'.$scoreSelfAssessmentState);
                break;

            case EmployeeAssessmentFilterValue::NOT_INVITED:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_NOT_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED:
                        $hasMatch = true;
                        break;
                }
                break;

            case EmployeeAssessmentFilterValue::INVITED_EMPLOYEE_NOT_FILLED_IN:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_INVITED:
                        $hasMatch = true;
                        break;
                }
                break;

            case EmployeeAssessmentFilterValue::INVITED_MANAGER_NOT_FILLED_IN:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_COMPLETED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED:
                        $hasMatch = true;
                        break;
                }
                break;

            case EmployeeAssessmentFilterValue::INVITED_BOTH_FILLED_IN:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_COMPLETED:
                        $hasMatch = true;
                        break;
                }
                break;

            case EmployeeAssessmentFilterValue::TODO_EVALUATION:
                $hasMatch = ScoreSelfAssessmentState::isInvited($scoreSelfAssessmentState) &&
                            $assessmentProcessEvaluationState == AssessmentProcessEvaluationState::EVALUATION_TODO;
                break;

            case EmployeeAssessmentFilterValue::DONE_EVALUATION:
                $hasMatch = ScoreSelfAssessmentState::isInvited($scoreSelfAssessmentState) &&
                            ($assessmentProcessEvaluationState == AssessmentProcessEvaluationState::EVALUATION_DONE ||
                             $assessmentProcessEvaluationState == AssessmentProcessEvaluationState::EVALUATION_CANCELLED);
                break;

            case EmployeeAssessmentFilterValue::NO_EVALUATION:
                $hasMatch = ScoreSelfAssessmentState::isInvited($scoreSelfAssessmentState) &&
                            $assessmentProcessEvaluationState == AssessmentProcessEvaluationState::EVALUATION_NONE;
                break;

            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_NONE:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_NOT_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_NONE_EMPLOYEE_COMPLETED:
                        $hasMatch = true;
                        break;
                }
                break;

            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_PRELIMINARY:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_NOT_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_PRELIMINARY_EMPLOYEE_COMPLETED:
                        $hasMatch = true;
                        break;
                }
                break;

            case EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_FINAL:
                switch($scoreSelfAssessmentState) {
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_NOT_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_INVITED:
                    case ScoreSelfAssessmentState::MANAGER_FINALIZED_EMPLOYEE_COMPLETED:
                        $hasMatch = true;
                        break;
                }
                break;

        }
        return $hasMatch;
    }


/////////////////////////////////////////////////////////////////////////////////////////////////////////////
/// deprecated stuff


//    function getEmployeesQueryFilter($sortFilter, $assessmentFilter)
//{
//    $queryFilter = $sortFilter;
//    if ($assessmentFilter > EmployeeAssessmentFilterValue::ANY
//        && $assessmentFilter < EmployeeAssessmentFilterValue::CHECK_ASSESSMENT_LAST) {
//        $queryFilter = $assessmentFilter;
//    }
//    return $queryFilter;
//}
//function getEmployeesStatusQueryFilter($sortFilter, $assessmentFilter)
//{
//    $queryFilter = $sortFilter;
//    if ($assessmentFilter >= EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_PRELIMINARY
//        && $assessmentFilter <= EmployeeAssessmentFilterValue::SCORE_STATUS_MANAGER_FINAL) {
//        $queryFilter = $assessmentFilter;
//    }
//    return $queryFilter;
//}
//
//
//function filterEmployees($search_employee, $sortFilter, $assessmentFilter, $boss_id, $is_boss)
//{
//    $filteredEmployees = array();
//    if (PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_BOSS_FILTER)) {
//        $boss_id = null;
//        $is_boss=null;
//    }
//
//    if (CUSTOMER_OPTION_USE_SELFASSESSMENT) {
//        if (PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER)) {
//            $employees_query_filter = FILTER_EMPLOYEES_ALPHABETICAL;
//        } else {
//            $employees_query_filter = self::getEmployeesQueryFilter($sortFilter, $assessmentFilter);
//        }
//        $evaluation_filtered_emps = EmployeesQueries::getSelfAssessmentFilteredEmployees($search_employee,
//                                                                                         null,
//                                                                                         null,
//                                                                                         null,
//                                                                                         null,
//                                                                                         $is_boss,
//                                                                                         $boss_id,
//                                                                                         true,
//                                                                                         $employees_query_filter);
//        while ($getemp_row = @mysql_fetch_assoc($evaluation_filtered_emps)) {
//            if (!CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
////                PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER)) {
//                $getemp_row['assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//                // zonder filter wel de employee en manager status gebruiken...
//                //$getemp_row['employee_assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//
////                if ($getemp_row['score_status'] == 1) {
////                    $getemp_row['manager_assessment_status'] = MANAGER_FILLED_IN_ASSESSMENT;
////                } elseif ($getemp_row['score_status'] == 0) {
////                    $getemp_row['manager_assessment_status'] = MANAGER_NOT_FILLED_IN_ASSESSMENT;
////                }
//            }
//            if (PermissionsService::isAccessDenied(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE)) {
//                $getemp_row['manager_assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//            }
//            $filteredEmployees[] = $getemp_row;
//        }
//    } else {
//        if (CUSTOMER_OPTION_SHOW_SCORE_STATUS_ICONS &&
//            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE)) { // wel score icoontjes, geen zelfevaluatie
//            if (PermissionsService::isAccessDenied(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER)) {
//               $employees_query_filter = FILTER_EMPLOYEES_ALPHABETICAL;
//            } else {
//                $employees_query_filter = self::getEmployeesStatusQueryFilter($sortFilter, $assessmentFilter);
//            }
//            $getemp = EmployeesQueries::getScoreStatusFilteredEmployees($search_employee,
//                                                                        null,
//                                                                        null,
//                                                                        null,
//                                                                        null,
//                                                                        $is_boss,
//                                                                        $boss_id,
//                                                                        true,
//                                                                        $employees_query_filter);
//            while ($getemp_row = @mysql_fetch_assoc($getemp)) {
//                $getemp_row['assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//                if ($getemp_row['score_status'] == 1) {
//                    $getemp_row['manager_assessment_status'] = MANAGER_FILLED_IN_ASSESSMENT;
//                } elseif ($getemp_row['score_status'] == 0) {
//                    $getemp_row['manager_assessment_status'] = MANAGER_NOT_FILLED_IN_ASSESSMENT;
//                }
//                $getemp_row['employee_assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//                $filteredEmployees[] = $getemp_row;
//            }
//
//        } else {
//            $getemp = EmployeesQueries::getEmployeesBasedOnUserLevel($search_employee,
//                                                                    null,
//                                                                    null,
//                                                                    null,
//                                                                    $is_boss,
//                                                                    $boss_id,
//                                                                    true);
//            while ($getemp_row = @mysql_fetch_assoc($getemp)) {
//                $getemp_row['assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//                $getemp_row['manager_assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//                $getemp_row['employee_assessment_status'] = ASSESSMENT_STATUS_NOT_USED;
//                $filteredEmployees[] = $getemp_row;
//            }
//        }
//    }
//    return $filteredEmployees;
//}


}

?>