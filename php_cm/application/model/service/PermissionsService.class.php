<?php

/**
 * Description of Permissions
 *
 * @author wouter.storteboom
 */

require_once('application/model/queries/ConfigQueries.class.php');
require_once('application/model/value/system/PermissionValue.class.php');

class PermissionsService {

    static function loadPermissions ()
    {
        $userLevelQuery = ConfigQueries::GetAccessPriviliges(USER_LEVEL, CUSTOMER_ID);

        $array_access_tabs = array();
        //if (@mysql_num_rows($userLevelQuery) > 0) {
            while ($userLevelRow = @mysql_fetch_assoc($userLevelQuery)) {
                $array_access_tabs[$userLevelRow['id_ma']] = $userLevelRow['permission'];
            }
        //}

        $moduleAccessQuery = ConfigQueries::GetApplicationModuleAccess();

        $module_employees_allowed = false;
        while ($moduleAccess = @mysql_fetch_assoc($moduleAccessQuery)) {

            $moduleAccessId = $moduleAccess['id'];
            $permission = PermissionValue::NO_ACCESS;
            if (array_key_exists($moduleAccessId, $array_access_tabs)) {
                $access = $array_access_tabs[$moduleAccessId];
                if (PermissionValue::isValidValue($access)) {
                    $permission = $access;
                }
            }

            switch ($moduleAccessId) {
                case 1:
                    define('PERMISSION_EMPLOYEE_PROFILE', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 2:
                    define('PERMISSION_EMPLOYEE_PROFILE_MANAGER_COMMENTS', $permission);
                    break;
                case 3:
                    define('PERMISSION_EMPLOYEE_ATTACHMENTS', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 4:
                    define('PERMISSION_EMPLOYEE_SCORES', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 5:
                    define('PERMISSION_EMPLOYEE_PDP_ACTIONS', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 6:
                    define('PERMISSION_EMPLOYEE_TARGETS', $permission);
                    define('PERMISSION_EMPLOYEE_TARGETS_EVALUATION_PERIOD_DEPRECATED', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 7:
                    define('PERMISSION_PDP_TODO_LIST', $permission);
                    break;
                case 8:
                    define('PERMISSION_HISTORY', $permission);
                    break;
                case 9:
                    define('PERMISSION_TALENT_SELECTOR', $permission);
                    break;
                case 10:
                    define('PERMISSION_SCOREBOARD', $permission);
                    break;
                case 11:
                    define('PERMISSION_PERFORMANCE_GRID', $permission);
                    break;
                case 12:
                    //define('PERMISSION_PROGRESS_SUMMARY_NOT_USED', $permission);
                    break;
                case 13:
                    define('PERMISSION_PDP_ACTION_LIBRARY', $permission);
                    break;
                case 14:
                    define('PERMISSION_PDP_TASK_LIBRARY', $permission);
                    break;
                case 15:
                    define('PERMISSION_PDP_TASK_OWNERS', $permission);
                    break;
                case 16:
                    define('PERMISSION_DEPARTMENTS', $permission);
                    break;
                case 17:
                    define('PERMISSION_EMAILS', $permission);
                    break;
                case 18:
                    define('PERMISSION_USERS', $permission);
                    break;
                case 19:
                    //define('PERMISSION_USER_DEPARTMENTS', $permission);
                    break;
                case 20:
                    // correctie voor customer admin om in ieder geval de rechten in te mogen stellen
                    $assignPermission = (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN && CUSTOMER_ID != 0)  ?
                                                                            PermissionValue::EDIT_ACCESS    :
                                                                            $permission;
                    define('PERMISSION_LEVEL_AUTHORIZATION', $assignPermission);
                    break;
                case 21:
                    define('PERMISSION_SCALE_DESCRIPTION', $permission);
                    break;
                case 22:
                    define('PERMISSION_THEMES', $permission);
                    break;
                case 23:
                    define('PERMISSION_DEFAULT_DATE', $permission);
                    break;
                case 24:
                    define('PERMISSION_EMPLOYEES_ARCHIVE', $permission);
                    break;
                case 25:
                    define('PERMISSION_PAM_INFO', $permission);
                    break;
                case 26:
                    define('PERMISSION_PAM_TECHNICAL_MANUAL', $permission);
                    break;
                case 27:
                    //define('PERMISSION_PAM_USER_MANUAL', $permission);
                    break;
                case 29:
                    define('PERMISSION_COMPETENCES_LIBRARY', $permission);
                    break;
                case 30:
                    define('PERMISSION_JOB_PROFILES_LIBRARY', $permission);
                    break;
                case 31:
                    //define('PERMISSION_PRINTS', $permission);
                    break;
                case 32:
                    define('PERMISSION_MENU_ORGANISATION', $permission);
                    break;
                case 33:
                    define('PERMISSION_QUESTIONS_LIBRARY', $permission);
                    break;
                case 34:
                    define('PERMISSION_BATCH_ADD_EMPLOYEE_PDP_ACTIONS', $permission);
                    break;
                case 35:
                    define('PERMISSION_BATCH_ADD_EMPLOYEE_TARGET_PERIOD', $permission);
                    break;
                case 36:
                    define('PERMISSION_BATCH_ADD_EMPLOYEE_TARGET', $permission);
                    break;
                case 37:
                    define('PERMISSION_BATCH_ADD_EMPLOYEE_ATTACHMENT', $permission);
                    break;
                case 38:
                    //define('PERMISSION_ORGANISATION_REPORTS', $permission);
                    break;
                case 39:
                    define('PERMISSION_DOCUMENT_CLUSTERS_LIBRARY', $permission);
                    break;
                case 40: // naast de instellingen per level moet de organisatie ook hiervoor de permissie hebben!
                    define('PERMISSION_BATCH_INVITE_SELF_ASSESSMENT', CUSTOMER_OPTION_USE_SELFASSESSMENT ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 41:
                    define('PERMISSION_REPORT_360', $permission);
                    break;
                case 42:
                    define('PERMISSION_EMPLOYEE_FINAL_RESULT', CUSTOMER_OPTION_USE_FINAL_RESULT ? $permission : PermissionValue::NO_ACCESS);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 43:
                    define('PERMISSION_EMPLOYEE_HISTORY', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
                case 44:
                    define('PERMISSION_EMPLOYEE_360', $permission);
                    if ($permission > PermissionValue::NO_ACCESS) {
                        $module_employees_allowed = true;
                    }
                    break;
//                case 45: (zit onder 6)
//                    define('PERMISSION_EMPLOYEE_TARGETS_EVALUATION_PERIOD_DEPRECATED', $permission);
//                    break;
                case 46:
                    define('PERMISSION_EMPLOYEE_TARGETS_EVALUATION_PERIOD_TARGET_DEPRECATED', $permission);// > PermissionValue::NO_ACCESS ? $permission : PermissionValue::VIEW_ACCESS);
                    break;
                case 47:
                    define('PERMISSION_EMPLOYEE_TARGETS_EVALUATION_PERIOD_TARGET_EVALUATION_DEPRECATED', $permission); // > PermissionValue::NO_ACCESS ? $permission : PermissionValue::VIEW_ACCESS);
                    define('PERMISSION_EMPLOYEE_TARGET_EVALUATION', $permission);
                    break;
                case 48:
                    define('PERMISSION_EMPLOYEE_TARGETS_EVALUATION_PERIOD_INLINE_STATUS_CHANGE', $permission); // deprecated
                    break;
                // sprint 10
                case 49:
                    define('PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_REMINDERS', CUSTOMER_OPTION_USE_SELFASSESSMENT_REMINDERS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 50:
                    define('PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_SATISFACTION_LETTER', CUSTOMER_OPTION_USE_SELFASSESSMENT_SATISFACTION_LETTER ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 51:
                    define('PERMISSION_EMPLOYEES_USE_BOSS_FILTER', CUSTOMER_OPTION_USE_FILTER_EMPLOYEES_BOSS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 52:
                    define('PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER', CUSTOMER_OPTION_SHOW_FILTERS_EMPLOYEES_ASSESSMENT_STATE ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 53:
                    define('PERMISSION_EMPLOYEES_SEARCH', $permission);
                    break;
                case 54:
                    define('PERMISSION_ASSESSMENT_PROCESS_MARK_ASSESSMENT_DONE', CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 55:
                    define('PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATIONS_SELECTED', CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 56:
                    define('PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE', CUSTOMER_OPTION_USE_SCORE_STATUS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 57:
                    define('PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE', $permission);
                    break;
                case 58:
                    define('PERMISSION_ASSESSMENT_PROCESS_UNDO_MARK_ASSESSMENT_DONE', CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 59:
                    define('PERMISSION_ASSESSMENT_PROCESS_UNDO_MARK_EVALUATIONS_SELECTED', CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 60:
                    define('PERMISSION_EMPLOYEE_SELF_ASSESSMENT_OVERVIEW', CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 61:
                    define('PERMISSION_BATCH_SELF_ASSESSMENT_OVERVIEW', CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 62:
                    define('PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS', CUSTOMER_OPTION_USE_SELFASSESSMENT ? $permission : PermissionValue::NO_ACCESS);
                    break;
                // end sprint 10
                case 63:
                    define('PERMISSION_EMPLOYEE_PORTFOLIO_PRINT', $permission);
                    break;
                case 65:
                    define('PERMISSION_ALERTS_OVERVIEW', $permission);
                    break;
                case 66:
                    define('PERMISSION_SELF_ASSESSMENTS_REPORT', CUSTOMER_OPTION_USE_SELFASSESSMENT ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 67:
                    define('PERMISSION_EXECUTE_SEND_360_INVITATIONS', $permission);
                    break;
                case 69:
                    define('PERMISSION_ASSESSMENT_CYCLE', $permission);
                    break;
                case 70:
                    define('PERMISSION_REPORT_MANAGER', $permission);
                    break;
                case 71:
                    define('PERMISSION_EMPLOYEE_JOB_PROFILE', $permission);
                    break;
                case 72:
                    define('PERMISSION_EMPLOYEE_RESEND_SELF_ASSESSMENT_INVITATION', CUSTOMER_OPTION_USE_SELFASSESSMENT ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 73:
                    define('PERMISSION_EMPLOYEES_USE_DEPARTMENT_FILTER', CUSTOMER_OPTION_USE_FILTER_EMPLOYEES_BOSS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 74:
                    define('PERMISSION_EMPLOYEES_USE_FUNCTION_FILTER', CUSTOMER_OPTION_USE_FILTER_EMPLOYEES_BOSS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 75:
                    define('PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS', CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 76:
                    define('PERMISSION_MENU_SELF_ASSESSMENT', CUSTOMER_OPTION_USE_SELFASSESSMENT ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 77:
                    define('PERMISSION_EMPLOYEE_INLINE_HISTORY',  $permission);
                    break;
                case 79:
                    define('PERMISSION_EMPLOYEE_PROFILE_PERSONAL', $permission);
                    break;
                case 80:
                    define('PERMISSION_EMPLOYEE_PROFILE_ORGANISATION', $permission);
                    break;
                case 81:
                    define('PERMISSION_EMPLOYEE_PROFILE_INFORMATION', $permission);
                    break;
                case 82:
                    define('PERMISSION_EMPLOYEE_PROFILE_USER', $permission);
                    break;
                case 83:
                    define('PERMISSION_FINAL_RESULT_DASHBOARD', CUSTOMER_OPTION_USE_FINAL_RESULT ? $permission : PermissionValue::NO_ACCESS);
                    break;
                case 84:
                    define('PERMISSION_MENU_DASHBOARD', $permission);
                    break;
                case 85:
                    define('PERMISSION_MENU_DASHBOARD_DEPARTMENTS', PERMISSION_MENU_DASHBOARD ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 86:
                    define('PERMISSION_DASHBOARD_REPORT_MANAGER', PERMISSION_MENU_DASHBOARD ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 87:
                    define('PERMISSION_ORGANISATION_REPORT_MANAGER', PERMISSION_MENU_ORGANISATION ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 88:
                    define('PERMISSION_DASHBOARD_SELF_ASSESSMENT_OVERVIEW', (PERMISSION_MENU_DASHBOARD && CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION) ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 89:
                    define('PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_INVITATIONS', (PERMISSION_MENU_DASHBOARD && CUSTOMER_OPTION_USE_SELFASSESSMENT) ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 90:
                    define('PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_PROCESS', (PERMISSION_MENU_DASHBOARD && CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 91:
                    define('PERMISSION_EMPLOYEE_SCORES_CLUSTER_EDIT', PERMISSION_EMPLOYEE_SCORES ?  $permission: PermissionValue::NO_ACCESS);
                    break;
                case 92:
                    define('PERMISSION_MENU_ORGANISATION_DEPARTMENTS', PERMISSION_MENU_ORGANISATION ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 93:
                    define('PERMISSION_DASHBOARD_PDP_ACTION', PERMISSION_MENU_DASHBOARD ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 94:
                    define('PERMISSION_DASHBOARD_TARGET', PERMISSION_MENU_DASHBOARD ? $permission: PermissionValue::NO_ACCESS);
                    break;
                case 95:
                    define('PERMISSION_EMPLOYEE_TRAINING', $permission);
                    break;
                case 96:
                    define('PERMISSION_DASHBOARD_TRAINING', $permission);
                    break;
            }
        }
        define('PERMISSION_MODULE_EMPLOYEES', $module_employees_allowed ? PermissionValue::VIEW_ACCESS : PermissionValue::NO_ACCESS);
    }


    static function isAddAllowed($permission)
    {
        return $permission == PermissionValue::ADD_DELETE_ACCESS;
    }

    static function isDeleteAllowed($permission)
    {
        return $permission == PermissionValue::ADD_DELETE_ACCESS;
    }

    static function isEditAllowed($permission)
    {
        return  $permission == PermissionValue::EDIT_ACCESS ||
                $permission == PermissionValue::ADD_DELETE_ACCESS;
    }

    static function isViewAllowed($permission)
    {
        // eigenlijk isAccessAllowed
        return self::isAccessAllowed($permission);
    }

//    static function isHistoryAllowed($permission)
//    {
//        return ($permission == PermissionValue::VIEW_ACCESS);
//    }
//
    static function isAccessAllowed($permission)
    {
        return  $permission != PermissionValue::NO_ACCESS;
    }

    static function isAccessDenied($permission)
    {
        return  $permission == PermissionValue::NO_ACCESS;
    }

    static function isPrintAllowed($permission)
    {
        return self::isViewAllowed($permission);
    }

    static function isExecuteAllowed($permission)
    {
        return  $permission == PermissionValue::EDIT_ACCESS ||
                $permission == PermissionValue::ADD_DELETE_ACCESS;
    }

    static function GetAccessPriviliges($user_level, $customer_id)
    {
        $query = ConfigQueries::GetAccessPriviliges($user_level, $customer_id);

        $accessPrivileges = array();
        while ($accessPrivilege = @mysql_fetch_assoc($query)) {
            $accessPrivileges[$accessPrivilege['id_ma']] = $accessPrivilege['permission'];
        }
        @mysql_free_result($query);

        return $accessPrivileges;
    }

    // $a_permissions array bevat id (key) en de bijbehorende permissie (value)
    static function SetAllowedPrivileges($permissions,
                                         $user_level,
                                         $customer_id)
    {
        $allowed_permissions = implode(',', array_keys($permissions));

        ConfigQueries::deleteUserLevelPrivileges($user_level, $customer_id, $allowed_permissions);

        $find_permissions = PermissionsService::GetAccessPriviliges($user_level, $customer_id);

        foreach ($permissions as $id_ma => $permission) {
            if (in_array($id_ma, array_keys($find_permissions))) {
                ConfigQueries::updateUserLevelPrivileges($user_level, $customer_id, $id_ma, $permission);
            } else {
                ConfigQueries::addUserLevelPrivileges($user_level, $customer_id, $id_ma, $permission);
            }
        }
    }

    static function GetDefaultAccessPrivileges($user_level)
    {
        $module_access = array();
        $privileges = array();
        switch ($user_level) {
            case UserLevelValue::CUSTOMER_ADMIN :
                $module_access = explode(',', '16,31,3,39,29,17,30,18,8,24,20,21,32,41,10,25,13,5,14,15,7,11,1,4,23,6,9,26,22,33,40,38,36,37,35,34,19,2,69,71,92,79,80,81,82');
                $privileges    = explode(',', ' 3, 1,3, 3, 3, 3, 3, 3,2, 3, 2, 2, 2, 3, 2, 1, 3,3, 2, 2,2, 2,3,2, 2,3,2, 1, 2, 3, 2, 2, 2, 2, 2, 2, 2,2, 3, 2, 3, 3, 2, 2, 1');
                break;
            case UserLevelValue::HR:
                $module_access = explode(',', '16,31,3,39,29,17,30,8,21,32,41,10,25,13,5,14,15,7,11,1,4,23,6,9,26,33,40,38,36,37,35,34,19,2,69,71,79,80,81');
                $privileges    = explode(',', ' 3, 1,3, 3, 3, 3, 3,2, 2, 2, 3, 2, 1, 3,3, 2, 2,2, 2,3,2, 2,3,2, 1, 3, 2, 2, 2, 2, 2, 2, 2,2, 3, 2, 2, 2, 2');
                break;
            case UserLevelValue::MANAGER:
                $module_access = explode(',', '31,3,39,29,30,8,32,41,10,25,13,5,14,15,7,11,1,4,6,9,26,33,40,38,36,37,35,34,19,2,69,71,79,80,81');
                $privileges    = explode(',', ' 1,3, 1, 1, 1,2, 1, 1, 2, 1, 1,3, 1, 1,1, 1,2,2,3,1, 1, 1, 2, 2, 2, 2, 2, 2, 1,2, 1, 2, 2, 2, 2');
                break;
            case UserLevelValue::EMPLOYEE_EDIT:
                $module_access = explode(',', '3,32,5,1,4,6,71,79,80,81');
                $privileges    = explode(',', '2, 1,1,2,1,1, 2, 2, 2, 2');
                break;
            case UserLevelValue::EMPLOYEE_VIEW:
                $module_access = explode(',', '3,32,5,1,6,71,79,80,81');
                $privileges    = explode(',', '1, 1,1,1,1, 1, 1, 1, 1');
                break;
        }

        $defaultPrivileges = array();
        // matchen de arrays?
        if (count($module_access) == count($privileges)) {
            for ($i = 0; $i < count($module_access); $i++) {
                $defaultPrivileges[$module_access[$i]] = $privileges[$i];
            }
        }
        return $defaultPrivileges;
    }

    static function getPermissionForDepartmentModuleMenu($moduleMenu)
    {
        switch ($moduleMenu) {
            case APPLICATION_MENU_ORGANISATION:
                $permission = PERMISSION_MENU_ORGANISATION_DEPARTMENTS;
                break;
            case APPLICATION_MENU_LIBRARIES:
                $permission = PERMISSION_DEPARTMENTS;
                break;
            case APPLICATION_MENU_DASHBOARD:
                $permission = PERMISSION_MENU_DASHBOARD_DEPARTMENTS;
                break;
            default:
                PermissionValue::NO_ACCESS;
        }
        return $permission;
    }

    static function getPermissionForManagerReportModuleMenu($moduleMenu)
    {
        switch ($moduleMenu) {
            case APPLICATION_MENU_ORGANISATION:
                $permission = PERMISSION_ORGANISATION_REPORT_MANAGER;
                break;
            case APPLICATION_MENU_REPORTS:
                $permission = PERMISSION_REPORT_MANAGER;
                break;
            case APPLICATION_MENU_DASHBOARD:
                $permission = PERMISSION_DASHBOARD_REPORT_MANAGER;
                break;
            default:
                PermissionValue::NO_ACCESS;
        }
        return $permission;
    }

    static function getPermissionForModuleMenuOverview($moduleMenu)
    {
        switch ($moduleMenu) {
            case APPLICATION_MENU_SELFASSESSMENT:
                $permission = PERMISSION_BATCH_SELF_ASSESSMENT_OVERVIEW;
                break;
            case APPLICATION_MENU_DASHBOARD:
                $permission = PERMISSION_DASHBOARD_SELF_ASSESSMENT_OVERVIEW;
                break;
            case APPLICATION_MENU_EMPLOYEES:
                $permission = PERMISSION_EMPLOYEE_SELF_ASSESSMENT_OVERVIEW;
                break;
            default:
                PermissionValue::NO_ACCESS;
        }
        return $permission;
    }

    static function getPermissionForModuleMenuDashboard($moduleMenu)
    {
        switch ($moduleMenu) {
            case APPLICATION_MENU_SELFASSESSMENT:
                $permission = PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS;
                break;
            case APPLICATION_MENU_DASHBOARD:
                $permission = PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_INVITATIONS;
                break;
            default:
                PermissionValue::NO_ACCESS;
        }
        return $permission;
    }

}

?>
