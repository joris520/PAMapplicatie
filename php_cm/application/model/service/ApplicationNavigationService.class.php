<?php

require_once('modules/common/moduleUtils.class.php');
require_once('application/interface/ApplicationNavigationConsts.inc.php');


class ApplicationNavigationService
{

    const CLEAR_SELECTED = true;
    const KEEP_SELECTED  = false;

    static function setCurrentApplicationMenu($applicationMenu)
    {
        $_SESSION[SESSION_CURRENT_APPLICATION_MENU] = $applicationMenu;
    }

    static function getCurrentApplicationMenu()
    {
        $currentApplicationMenu =   empty($_SESSION[SESSION_CURRENT_APPLICATION_MENU]) ?
                                                            APPLICATION_MENU_EMPLOYEES :
                                            $_SESSION[SESSION_CURRENT_APPLICATION_MENU];
        return $currentApplicationMenu;
    }


    static function clearLastModule()
    {
        self::initializeLastModuleFunction(self::CLEAR_SELECTED);
        self::initializeSelectedEmployeeId(self::CLEAR_SELECTED);

        //setcookie('selectedEmpId', '');
        setcookie('scrollpos', '', 0, NULL);
    }

    // bijhouden gekozen employeeId
    static function initializeSelectedEmployeeId($doClear = self::CLEAR_SELECTED)
    {
        if ($doClear == self::CLEAR_SELECTED) {
            unset($_SESSION['selectedEmpId']);
        }
        if (USER_LEVEL > UserLevelValue::MANAGER) {
            self::storeSelectedEmployeeId(EMPLOYEE_ID);
        }
    }

    static function storeSelectedEmployeeId($employeeId)
    {
        $_SESSION['selectedEmpId'] = $employeeId;
    }

    static function retrieveSelectedEmployeeId()
    {
        return @$_SESSION['selectedEmpId'];
    }

    static function hasSelectedEmployeeId()
    {
        return !empty($_SESSION['selectedEmpId']);
    }

    static function isSelectedEmployeeId($employeeId)
    {
        return $employeeId == self::retrieveSelectedEmployeeId();
    }

    // bijhouden laatst geselecteerde functie in een module
    static function initializeLastModuleFunction($doClear = self::CLEAR_SELECTED)
    {
        if ($doClear == self::CLEAR_SELECTED) {
            unset($_SESSION['lastModuleFunction']);
        }
    }

    static function storeLastModuleFunction($lastModuleFunction)
    {
        $_SESSION['lastModuleFunction'] = $lastModuleFunction;
    }

    static function retrieveLastModuleFunction()
    {
        return @$_SESSION['lastModuleFunction'];
    }

    static function hasLastModuleFunction()
    {
        return !empty($_SESSION['lastModuleFunction']);
    }

    static function setCurrentApplicationModule($module)
    {
        $currentApplicationMenu = self::getApplicationMenuForModule($module);
        if (!empty($currentApplicationMenu)) {
            switch ($currentApplicationMenu) {
                case APPLICATION_MENU_EMPLOYEES:
                    $_SESSION[SESSION_CURRENT_EMPLOYEES_MODULE] = $module;
                    break;
                case APPLICATION_MENU_DASHBOARD:
                    $_SESSION[SESSION_CURRENT_DASHBOARD_MODULE] = $module;
                    break;
                case APPLICATION_MENU_SELFASSESSMENT:
                    $_SESSION[SESSION_CURRENT_SELFASSESSMENT_MODULE] = $module;
                    break;
                case APPLICATION_MENU_ORGANISATION:
                    $_SESSION[SESSION_CURRENT_ORGANISATION_MODULE] = $module;
                    break;
                case APPLICATION_MENU_REPORTS:
                    $_SESSION[SESSION_CURRENT_REPORTS_MODULE] = $module;
                    break;
                case APPLICATION_MENU_SETTINGS:
                    $_SESSION[SESSION_CURRENT_LIBRARIES_MODULE] = $module;
                    break;
                case APPLICATION_MENU_LIBRARIES:
                    $_SESSION[SESSION_CURRENT_SETTINGS_MODULE] = $module;
                    break;
                case APPLICATION_MENU_HELP:
                    $_SESSION[SESSION_CURRENT_HELP_MODULE] = $module;
                    break;
            }
        }
    }

    static function getCurrentApplicationModule($applicationMenu)
    {
        $module = NULL;
        if (!empty($applicationMenu)) {
            switch ($applicationMenu) {
                case APPLICATION_MENU_EMPLOYEES:
                    $module = $_SESSION[SESSION_CURRENT_EMPLOYEES_MODULE];
                    break;
                case APPLICATION_MENU_DASHBOARD:
                    $module = $_SESSION[SESSION_CURRENT_DASHBOARD_MODULE];
                    break;
                case APPLICATION_MENU_SELFASSESSMENT:
                    $module = $_SESSION[SESSION_CURRENT_SELFASSESSMENT_MODULE];
                    break;
                case APPLICATION_MENU_ORGANISATION:
                    $module = $_SESSION[SESSION_CURRENT_ORGANISATION_MODULE];
                    break;
                case APPLICATION_MENU_REPORTS:
                    $module = $_SESSION[SESSION_CURRENT_REPORTS_MODULE];
                    break;
                case APPLICATION_MENU_SETTINGS:
                    $module = $_SESSION[SESSION_CURRENT_LIBRARIES_MODULE];
                    break;
                case APPLICATION_MENU_LIBRARIES:
                    $module = $_SESSION[SESSION_CURRENT_SETTINGS_MODULE];
                    break;
                case APPLICATION_MENU_HELP:
                    $module = $_SESSION[SESSION_CURRENT_HELP_MODULE];
                    break;
            }
        }
        return $module;
    }

    static function getCurrentModule()
    {
        $applicationMenu = ApplicationNavigationService::getCurrentApplicationMenu();
        $currentModule = ApplicationNavigationService::getCurrentApplicationModule($applicationMenu);
        return $currentModule;
    }

    static function getApplicationMenuForModule($module)
    {
        $application_menu = NULL;
        switch ($module) {
            case MODULE_EMPLOYEES:
                $application_menu = APPLICATION_MENU_EMPLOYEES;
                break;
            case MODULE_MENU_SELFASSESSMENT:
            case MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH:
            case MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH:
            case MODULE_SELFASSESSMENT_MENU_SATISFACTIONLETTER_SELFASSESSEMENT_BATCH:
            case MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
            case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
            case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                $application_menu = APPLICATION_MENU_SELFASSESSMENT;
                break;
            case MODULE_MENU_DASHBOARD:
            case MODULE_DASHBOARD_MENU_DEPARTMENTS:
            case MODULE_DASHBOARD_MENU_MANAGERS:
            case MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS:
            case MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS:
            case MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT:
            case MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING:
            case MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
            case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
            case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                $application_menu = APPLICATION_MENU_DASHBOARD;
                break;
            case MODULE_COMPETENCES:
                $application_menu = APPLICATION_MENU_LIBRARIES;
                break;
            case MODULE_JOB_PROFILES:
                $application_menu = APPLICATION_MENU_LIBRARIES;
                break;
            case MODULE_SELFASSESSMENT_REPORTS:
            case MODULE_360:
            case MODULE_EMAIL_PDP_NOTIFICATION_ALERTS:
            case MODULE_SCOREBOARD:
            case MODULE_TALENT_SELECTOR:
            case MODULE_PERFORMANCE_GRID:
            case MODULE_HISTORY:
            case MODULE_PDP_TODO_LIST:
            case MODULE_EMPLOYEE_PORTFOLIO:
            case MODULE_REPORTS_MANAGER:
            case MODULE_REPORTS_MENU_DASHBOARD_FINAL_RESULT:
            case MODULE_REPORTS_MENU_DASHBOARD_TRAINING:
                $application_menu = APPLICATION_MENU_REPORTS;
                break;
            case MODULE_LEVEL_AUTHORIZATION:
            case MODULE_USERS:
            case MODULE_THEMES:
            case MODULE_DEFAULT_DATE:
            case MODULE_EMPLOYEES_ARCHIVED:
                $application_menu = APPLICATION_MENU_SETTINGS;
                break;
            case MODULE_LIBRARY_DEPARTMENTS:
            case MODULE_ASSESSMENT_CYCLE:
            case MODULE_SCALES:
            case MODULE_QUESTIONS:
            case MODULE_DOCUMENT_CLUSTERS:
            case MODULE_PDP_ACTION_LIB:
            case MODULE_PDP_TASK_LIB:
            case MODULE_PDP_TASK_OWNER:
            case MODULE_EMAILS:
                $application_menu = APPLICATION_MENU_LIBRARIES;
                break;
            case MODULE_INFO:
            case MODULE_TECH_MANUAL:
            case MODULE_USER_MANUAL:
                $application_menu = APPLICATION_MENU_HELP;
                break;
            case MODULE_EMPLOYEE_PROFILE:
            case MODULE_EMPLOYEE_ATTACHMENTS:
            case MODULE_EMPLOYEE_SCORE:
            case MODULE_EMPLOYEE_PDP_ACTIONS:
            case MODULE_EMPLOYEE_TARGETS:
            case MODULE_EMPLOYEE_FINAL_RESULTS:
            case MODULE_EMPLOYEE_TRAINING:
            case MODULE_EMPLOYEE_INVITATIONS:
            case MODULE_EMPLOYEE_360:
            case MODULE_EMPLOYEE_HISTORY:
            case MODULE_EMPLOYEE_NO_ACCESS:
                $application_menu = MODULE_EMPLOYEES;
                break;
            case MODULE_ORGANISATION:
            case MODULE_ORGANISATION_MENU_COMPANY_INFO:
            case MODULE_ORGANISATION_MENU_DEPARTMENTS:
            case MODULE_ORGANISATION_MENU_MANAGERS:
            case MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH:
            case MODULE_ORGANISATION_MENU_TARGETS_BATCH:
            case MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH:
                $application_menu = APPLICATION_MENU_ORGANISATION;
                break;

        }

        return $application_menu;
    }

    static function getModulesForApplicationMenu($applicationMenu)
    {
        $availableModules = array();
        switch ($applicationMenu) {
            case APPLICATION_MENU_EMPLOYEES:
                $availableModules = array(  MODULE_EMPLOYEES);
                break;
            case APPLICATION_MENU_DASHBOARD:
                $availableModules = array(  MODULE_DASHBOARD_MENU_DEPARTMENTS,
                                            MODULE_DASHBOARD_MENU_MANAGERS,
                                            MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS,
                                            MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS,
                                            MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT,
                                            MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING,
                                            MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS,
                                            MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS,
                                            MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS);
                break;
            case APPLICATION_MENU_SELFASSESSMENT:
                $availableModules = array(  MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH,
                                            MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH,
                                            MODULE_SELFASSESSMENT_MENU_SATISFACTIONLETTER_SELFASSESSEMENT_BATCH,
                                            MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS,
                                            MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS,
                                            MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS);
                break;
            case APPLICATION_MENU_REPORTS:
                $availableModules = array(  MODULE_SELFASSESSMENT_REPORTS,
                                            MODULE_SCOREBOARD,
                                            MODULE_TALENT_SELECTOR,
                                            MODULE_PERFORMANCE_GRID,
                                            MODULE_EMPLOYEE_PORTFOLIO,
                                            MODULE_REPORTS_MANAGER,
                                            MODULE_HISTORY,
                                            MODULE_360,
                                            MODULE_PDP_TODO_LIST,
                                            MODULE_EMAIL_PDP_NOTIFICATION_ALERTS);
                break;
            case APPLICATION_MENU_SETTINGS:
                $availableModules = array(  MODULE_LEVEL_AUTHORIZATION,
                                            MODULE_USERS,
                                            MODULE_THEMES,
                                            MODULE_DEFAULT_DATE,
                                            MODULE_EMPLOYEES_ARCHIVED);
                break;
            case APPLICATION_MENU_LIBRARIES:
                $availableModules = array(  MODULE_COMPETENCES,
                                            MODULE_JOB_PROFILES,
                                            MODULE_SCALES,
                                            MODULE_QUESTIONS,
                                            MODULE_ASSESSMENT_CYCLE,
                                            MODULE_LIBRARY_DEPARTMENTS,
                                            MODULE_DOCUMENT_CLUSTERS,
                                            MODULE_PDP_ACTION_LIB,
                                            MODULE_PDP_TASK_LIB,
                                            MODULE_PDP_TASK_OWNER,
                                            MODULE_EMAILS);
                break;
            case APPLICATION_MENU_HELP:
                $availableModules = array(  MODULE_INFO,
                                            MODULE_TECH_MANUAL,
                                            MODULE_USER_MANUAL);

                break;
            case MODULE_EMPLOYEES:
                $availableModules = array(  MODULE_EMPLOYEE_PROFILE,
                                            MODULE_EMPLOYEE_NO_ACCESS,
                                            MODULE_EMPLOYEE_ATTACHMENTS,
                                            MODULE_EMPLOYEE_SCORE,
                                            MODULE_EMPLOYEE_PDP_ACTIONS,
                                            MODULE_EMPLOYEE_TARGETS,
                                            MODULE_EMPLOYEE_FINAL_RESULTS,
                                            MODULE_EMPLOYEE_TRAINING,
                                            MODULE_EMPLOYEE_360,
                                            MODULE_EMPLOYEE_HISTORY,
                                            MODULE_EMPLOYEE_INVITATIONS);
                break;
            case APPLICATION_MENU_ORGANISATION:
                $availableModules = array(  MODULE_ORGANISATION_MENU_COMPANY_INFO,
                                            MODULE_ORGANISATION_MENU_DEPARTMENTS,
                                            MODULE_ORGANISATION_MENU_MANAGERS,
                                            MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH,
                                            MODULE_ORGANISATION_MENU_TARGETS_BATCH,
                                            MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH);
                break;
        }

        return $availableModules;
    }

    static function getAllowedModulesForApplicationMenu($applicationMenu)
    {
        $allowedModules = array();

        $menuModules = self::getModulesForApplicationMenu($applicationMenu);
        foreach ($menuModules as $menuModule) {
            if (self::isAllowedModule($menuModule)) {
                $allowedModules[] = $menuModule;
            }
        }

        return $allowedModules;
    }


    static function hasApplicationMenuAllowedModules($applicationMenu)
    {
        $availableModules = self::getModulesForApplicationMenu($applicationMenu);
        return self::getFirstAllowedInAvailable(NULL, $availableModules);

    }
    static function getFirstAllowedModuleInApplicationMenu()//$applicationMenu, $selectedModule)
    {
        $applicationMenu = self::getCurrentApplicationMenu();
        $selectedModule = self::getCurrentApplicationModule($applicationMenu);
        $availableModules = self::getModulesForApplicationMenu($applicationMenu);
        return self::getFirstAllowedInAvailable($selectedModule, $availableModules);
    }

    protected static function getFirstAllowedInAvailable($selectedModule, $availableModules)
    {
        $activateModule = NULL;
        if (in_array($selectedModule, $availableModules) && self::isAllowedModule($selectedModule)) {
            $activateModule = $selectedModule;
        } else {
            foreach($availableModules as $module) {
                if (self::isAllowedModule($module)) {
                    $activateModule = $module;
                    break;
                }
            }
        }
        return $activateModule;
    }
    static function getLastAllowedModuleInApplicationMenu($applicationMenu)//$applicationMenu, $selectedModule)
    {
        $availableModules = self::getModulesForApplicationMenu($applicationMenu);
        return self::getLastAllowedInAvailable($availableModules);
    }

    protected static function getLastAllowedInAvailable($availableModules)
    {
        $lastModule = NULL;
        foreach($availableModules as $module) {
            if (self::isAllowedModule($module)) {
                $lastModule = $module;
            }
        }
        return $lastModule;
    }

    static function getFirstAllowedModuleFunction($selectedModule)
    {
        switch ($selectedModule) {
            case MODULE_EMPLOYEES:
                $availableModules = self::getModulesForApplicationMenu(MODULE_EMPLOYEES);
                break;
        }
        return self::getFirstAllowedInAvailable($selectedModule, $availableModules);
    }

    static function isAllowedModule($requestedModule)
    {
        $moduleAllowed = false;
        if (!empty($requestedModule)) {
            switch ($requestedModule) {
                case MODULE_LEVEL_AUTHORIZATION:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_LEVEL_AUTHORIZATION);
                    break;
                case MODULE_USERS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_USERS);
                    break;
                case MODULE_SCALES:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_SCALE_DESCRIPTION);
                    break;
                case MODULE_ASSESSMENT_CYCLE:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_ASSESSMENT_CYCLE);
                    break;
                case MODULE_CHANGE_PASSWORD:
                    $moduleAllowed = true; // mag altijd
                    break;
                case MODULE_THEMES:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_THEMES);
                    break;
                case MODULE_DEFAULT_DATE:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_DEFAULT_DATE);
                    break;
                case MODULE_EMPLOYEES_ARCHIVED:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEES_ARCHIVE);
                    break;
                case MODULE_LIBRARY_DEPARTMENTS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_DEPARTMENTS);
                    break;
                case MODULE_QUESTIONS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_QUESTIONS_LIBRARY);
                    break;
                case MODULE_DOCUMENT_CLUSTERS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY);
                    break;
                case MODULE_PDP_ACTION_LIB:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PDP_ACTION_LIBRARY);
                    break;
                case MODULE_PDP_TASK_LIB:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PDP_TASK_LIBRARY);
                    break;
                case MODULE_PDP_TASK_OWNER:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PDP_TASK_OWNERS);
                    break;
                case MODULE_360:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_REPORT_360);
                    break;
                case MODULE_EMAILS:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_EMAILS);
                    break;
                case MODULE_ORGANISATION:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_MENU_ORGANISATION);
                    break;
                case MODULE_MENU_DASHBOARD:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_MENU_DASHBOARD);
                    break;
                case MODULE_MENU_SELFASSESSMENT:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_MENU_SELF_ASSESSMENT);
                    break;
                case MODULE_COMPETENCES:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_COMPETENCES_LIBRARY);
                    break;
                case MODULE_JOB_PROFILES:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_JOB_PROFILES_LIBRARY);
                    break;
                case MODULE_EMPLOYEES:
                    $moduleAllowed = true; // mag altijd;
                    break;
                case MODULE_CUSTOMERS:
                    $moduleAllowed = (CUSTOMER_ID == 0);
                    break;
                case MODULE_INFO:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PAM_INFO);
                    break;
                case MODULE_TECH_MANUAL:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PAM_TECHNICAL_MANUAL);
                    break;
                case MODULE_USER_MANUAL:
                    $moduleAllowed = false; // niet in gebruik
                    break;
                case MODULE_SCOREBOARD:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_SCOREBOARD);
                    break;
                case MODULE_TALENT_SELECTOR:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_TALENT_SELECTOR);
                    break;
                case MODULE_PERFORMANCE_GRID:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PERFORMANCE_GRID);
                    break;
                case MODULE_HISTORY:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_HISTORY);
                    break;
                case MODULE_PDP_TODO_LIST:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_PDP_TODO_LIST);
                    break;
                case MODULE_EMPLOYEE_PORTFOLIO:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_PORTFOLIO_PRINT);
                    break;
                case MODULE_EMPLOYEE_PROFILE:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_PROFILE);
                    break;
                case MODULE_EMPLOYEE_ATTACHMENTS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS);
                    break;
                case MODULE_EMPLOYEE_SCORE:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_SCORES);
                    break;
                case MODULE_EMPLOYEE_PDP_ACTIONS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS);
                    break;
                case MODULE_EMPLOYEE_TARGETS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_TARGETS);
                    break;
                case MODULE_EMPLOYEE_FINAL_RESULTS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT);
                    break;
                case MODULE_EMPLOYEE_TRAINING:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_TRAINING);
                    break;
                case MODULE_EMPLOYEE_INVITATIONS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_SELF_ASSESSMENT_OVERVIEW);
                    break;
                case MODULE_EMPLOYEE_360:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_360);
                    break;
                case MODULE_EMPLOYEE_HISTORY:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_HISTORY);
                    break;
                case MODULE_EMPLOYEE_NO_ACCESS:
                    $moduleAllowed = true; // de fallback als er niet voldoende verdere rechten zijn
                    break;
                case MODULE_REPORTS_MANAGER:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_REPORT_MANAGER);
                    break;
                case MODULE_EMAIL_PDP_NOTIFICATION_ALERTS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_ALERTS_OVERVIEW);
                    break;
                case MODULE_SELFASSESSMENT_REPORTS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_SELF_ASSESSMENTS_REPORT);
                    break;
                case MODULE_ORGANISATION_MENU_COMPANY_INFO:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_MENU_ORGANISATION);
                    break;
                case MODULE_ORGANISATION_MENU_DEPARTMENTS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_MENU_ORGANISATION_DEPARTMENTS);
                    break;
                case MODULE_ORGANISATION_MENU_MANAGERS:
                    $moduleAllowed = PermissionsService::isAccessAllowed(PERMISSION_ORGANISATION_REPORT_MANAGER);
                    break;
                case MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_PDP_ACTIONS);
                    break;
                case MODULE_ORGANISATION_MENU_TARGETS_BATCH:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_TARGET);
                    break;
                case MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_ATTACHMENT);
                    break;
                case MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT);
                    break;
                case MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_REMINDERS);
                    break;
                case MODULE_SELFASSESSMENT_MENU_SATISFACTIONLETTER_SELFASSESSEMENT_BATCH:
                    $moduleAllowed = PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_SATISFACTION_LETTER);
                    break;
                case MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_OVERVIEW);
                    break;
                case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS);
                    break;
                case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS);
                    break;
                case MODULE_DASHBOARD_MENU_DEPARTMENTS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_MENU_DASHBOARD_DEPARTMENTS);
                    break;
                case MODULE_DASHBOARD_MENU_MANAGERS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_REPORT_MANAGER);
                    break;
                case MODULE_DASHBOARD_MENU_EMPLOYEE_PORTFOLIO:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PORTFOLIO_PRINT);
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_PDP_ACTION);
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TARGET);
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_FINAL_RESULT_DASHBOARD);
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TRAINING);
                    break;
                case MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_SELF_ASSESSMENT_OVERVIEW);
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_INVITATIONS);
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                    $moduleAllowed = PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_PROCESS);
                    break;

            }
        }
        return $moduleAllowed;
    }

    static function getModulePublicCall($requestedModule)
    {
        $module_call = '';

        if (!empty($requestedModule)) {

            switch ($requestedModule) {
                case MODULE_LEVEL_AUTHORIZATION:
                    $module_call = 'xajax_moduleLevelAuthorisation_displayLevelAuthorization';
                    break;
                case MODULE_USERS:
                    $module_call = 'xajax_moduleUsers';
                    break;
                case MODULE_SCALES:
                    $module_call = 'xajax_moduleOptions_scales';
                    break;
                case MODULE_ASSESSMENT_CYCLE:
                    $module_call = 'xajax_public_library__displayAssessmentCycles';
                    break;
                case MODULE_CHANGE_PASSWORD:
                    $module_call = 'xajax_moduleUsers_changePassword';
                    break;
                case MODULE_THEMES:
                    $module_call = 'xajax_moduleOptions_themeLogo';
                    break;
                case MODULE_DEFAULT_DATE:
                    $module_call = 'xajax_public_settings__displayStandardDate';
                    break;
                case MODULE_EMPLOYEES_ARCHIVED:
                    $module_call = 'xajax_moduleOptions_showEmployeesArchive';
                    break;
                case MODULE_LIBRARY_DEPARTMENTS:
                    $module_call = 'xajax_public_library__displayDepartments';
                    break;
                case MODULE_PDP_ACTION_LIB:
                    $module_call = 'xajax_public_library__displayPdpActions';
                    break;
                case MODULE_PDP_TASK_LIB:
                    $module_call = 'xajax_modulePDPTaskLibrary';
                    break;
                case MODULE_PDP_TASK_OWNER:
                    $module_call = 'xajax_modulePDPTaskOwnerLibrary';
                    break;
                case MODULE_360:
                    $module_call = 'xajax_module360_display360Employees';
                    break;
                case MODULE_EMAILS:
                    $module_call = 'xajax_moduleEmails_displayExternalEmailAddresses';
                    break;
                case MODULE_ORGANISATION:
                    $module_call = 'xajax_public_organisation__displayTab';
                    break;
                case MODULE_MENU_DASHBOARD:
                    die('MODULE_MENU_DASHBOARD');
                    $module_call = 'xajax_public_dashboard__displayTab';
                    break;
                case MODULE_MENU_SELFASSESSMENT:
                    $module_call = 'xajax_public_selfAssessment__displayTab';
                    break;
                case MODULE_COMPETENCES:
                    $module_call = 'xajax_moduleCompetence';
                    break;
                case MODULE_JOB_PROFILES:
                    $module_call = 'xajax_moduleFunctions';
                    break;
                case MODULE_EMPLOYEES:
                    $module_call = 'xajax_moduleEmployees_startup';
                    break;
                case MODULE_CUSTOMERS:
                    $module_call = 'xajax_moduleCustomers_displayCustomers';
                    break;
                case MODULE_INFO:
                    $module_call = 'xajax_modulePAMInfo';
                    break;
                case MODULE_TECH_MANUAL:
                    $module_call = 'xajax_moduleTechnicalManual';
                    break;
                case MODULE_USER_MANUAL:
                    $module_call = 'xajax_moduleUserManual';
                    break;
                case MODULE_SCOREBOARD:
                    $module_call = 'xajax_moduleScoreboard_menu';
                    break;
                case MODULE_TALENT_SELECTOR:
                    $module_call = 'xajax_public_report__displayTalentSelector';
                    break;
                case MODULE_PERFORMANCE_GRID:
                    $module_call = 'xajax_modulePerformanceGrid_menu';
                    break;
                case MODULE_HISTORY:
                    $module_call = 'xajax_moduleHistory';
                    break;
                case MODULE_PDP_TODO_LIST:
                    $module_call = 'xajax_modulePDPToDoList_menu';
                    break;
                case MODULE_EMPLOYEE_PORTFOLIO:
                    $module_call = 'xajax_moduleEmployeesPrints_printEmployeesFullPortfolio_deprecated';
                    break;
                case MODULE_EMAIL_PDP_NOTIFICATION_ALERTS:
                    $module_call = 'xajax_moduleEmails_showPDPActionsNotificationAlerts';
                    break;
                case MODULE_SELFASSESSMENT_REPORTS:
                    $module_call = 'xajax_moduleOrganisation_selfassessmentReportsForm';
                    break;

                // nieuwe stijl
                case MODULE_QUESTIONS:
                    $module_call = 'xajax_public_library__displayQuestions';
                    break;
                case MODULE_EMPLOYEE_FINAL_RESULTS:
                    $module_call = 'xajax_public_employeeFinalResult__displayFinalResult';
                    break;
                case MODULE_EMPLOYEE_TRAINING:
                    $module_call = 'xajax_public_employeeTraining__displayTraining';
                    break;
                case MODULE_DOCUMENT_CLUSTERS:
                    $module_call = 'xajax_public_library__displayDocumentClusters';
                    break;
                case MODULE_REPORTS_MANAGER:
                    $module_call = 'xajax_public_report__displayManagers';
                    break;
                // organisatiemenu
                case MODULE_ORGANISATION_MENU_COMPANY_INFO:
                    $module_call = 'xajax_public_organisationInfo__displayInfo';
                    break;
                case MODULE_ORGANISATION_MENU_DEPARTMENTS:
                    $module_call = 'xajax_public_organisation__displayDepartments';
                    break;
                case MODULE_ORGANISATION_MENU_MANAGERS:
                    $module_call = 'xajax_public_organisation__displayManagers';
                    break;
                case MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH:
                    $module_call = 'xajax_moduleOrganisation_pdpActionsBatchForm';
                    break;
                case MODULE_ORGANISATION_MENU_TARGETS_BATCH:
                    $module_call = 'xajax_public_batch_addTarget';
                    break;
                case MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH:
                    $module_call = 'xajax_moduleOrganisation_attachmentBatchForm';
                    break;
                case MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH:
                    $module_call = 'xajax_public_batch_inviteSelfAssessment';
                    break;
                case MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH:
                    $module_call = 'xajax_public_batch_remindSelfAssessment';
                    break;
                case MODULE_SELFASSESSMENT_MENU_SATISFACTIONLETTER_SELFASSESSEMENT_BATCH:
                    $module_call = '';
                    break;
                case MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
                    $module_call = 'xajax_public_report__displayInvitations';
                    break;
                case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
                    $module_call = 'xajax_public_report__displayInvitationDashboard';
                    break;
                case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                    $module_call = 'xajax_public_report__displayProcessDashboard';
                    break;
                case MODULE_DASHBOARD_MENU_DEPARTMENTS:
                    $module_call = 'xajax_public_dashboard__displayDepartments';
                    break;
                case MODULE_DASHBOARD_MENU_MANAGERS:
                    $module_call = 'xajax_public_dashboard__displayManagers';
                    break;
                case MODULE_DASHBOARD_MENU_EMPLOYEE_PORTFOLIO:
                    $module_call = 'xajax_public_dashboard_printEmployeesFullPortfolio_deprecated';
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS:
                    $module_call = 'xajax_public_dashboard__displayPdpActionDashboard';
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS:
                    $module_call = 'xajax_public_dashboard__displayTargetDashboard';
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT:
                    $module_call = 'xajax_public_dashboard__displayFinalResultDashboard';
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING:
                    $module_call = 'xajax_public_dashboard__displayTrainingDashboard';
                    break;
                case MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
                    $module_call = 'xajax_public_dashboard__displayInvitations';
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
                    $module_call = 'xajax_public_dashboard__displayInvitationDashboard';
                    break;
                case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                    $module_call = 'xajax_public_dashboard__displayProcessDashboard';
                    break;
                default:
                    $module_call = 'xajax_moduleEmployees_startup';
                    break;
            }
        }
        return $module_call;
    }

}

?>