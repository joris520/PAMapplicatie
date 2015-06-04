<?php

require_once('modules/common/moduleUtils.class.php');
require_once('application/interface/ApplicationNavigationConsts.inc.php');


class ApplicationNavigationInterfaceBuilder
{

    static function getReferenceDateEditorHtml($inputName, $editorFormName)
    {

        $referenceClass = PamApplication::hasModifiedReferenceDate() ? ' warning' : '';
        $referenceDatePicker = InterfaceBuilderComponents::getCalendarInputHtml($inputName, REFERENCE_DATE, $referenceClass);

        global $smarty;
        $template_referenceDateEditor = $smarty->createTemplate('referenceDateEditor.tpl');
        $template_referenceDateEditor->assign('editorDatePicker', $referenceDatePicker);
        $template_referenceDateEditor->assign('editorFormName', $editorFormName);
        return $smarty->fetch($template_referenceDateEditor);
    }

    static function buildMenuForModule($module)
    {
        $applicationMenuHtml = '';
        $applicationMenu = ApplicationNavigationService::getApplicationMenuForModule($module);

        switch ($applicationMenu) {
            case APPLICATION_MENU_REPORTS:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildReportsMenu($module);
                break;
            case APPLICATION_MENU_SETTINGS:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildSettingsMenu($module);
                break;
            case APPLICATION_MENU_LIBRARIES:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildLibraryMenu($module);
                break;
            case APPLICATION_MENU_HELP:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildHelpMenu($module);
                break;
            case APPLICATION_MENU_DASHBOARD:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildDashboardMenu($module);
                break;
            case APPLICATION_MENU_ORGANISATION:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildOrganisationMenu($module);
                break;
            case APPLICATION_MENU_SELFASSESSMENT:
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildSelfAssessmentMenu($module);
                break;
            case APPLICATION_MENU_EMPLOYEES:
                $employeeId = ApplicationNavigationService::retrieveSelectedEmployeeId();
                $applicationMenuHtml = ApplicationNavigationInterfaceBuilder::buildEmployeesMenu($employeeId, $module);
                break;
            default:
                break;
        }
        return $applicationMenuHtml;
    }


    static function buildApplicationMenu($activeLink)
    {
        $user_level_name = UserLevelConverter::display(USER_LEVEL);

        global $smarty;

        $tpl = $smarty->createTemplate('navigation/applicationMenu.tpl');
        $tpl->assign('USER',            stripslashes(USER));
        $tpl->assign('USER_LEVEL_NAME', $user_level_name);
        $tpl->assign('COMPANY_NAME',    COMPANY_NAME);
        $tpl->assign('active',          $activeLink);
        // user_level afhankelijke menu's

        // conditioneel tonen referenceDate Editor
        $editorFormInputName    = 'reference_date';
        $editorFormName         =  $editorFormInputName . '_form';
        $referenceDateEditor    = self::getReferenceDateEditorHtml($editorFormInputName, $editorFormName);
        $tpl->assign('editorFormName',          $editorFormName);
        $tpl->assign('referenceDateEditor',     $referenceDateEditor);
        $tpl->assign('showReferenceDateEditor', APPLICATION_REFERENCE_DATE_EDITOR_ALLOWED && (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN));

        // Permissie afhankelijke menu's
        $tpl->assign('showCustomers',       USER_LEVEL == UserLevelValue::SYS_ADMIN);
        $tpl->assign('showOrganisation',    USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::hasApplicationMenuAllowedModules(APPLICATION_MENU_ORGANISATION));
        $tpl->assign('showDashboard',       USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::isAllowedModule(MODULE_MENU_DASHBOARD));
        $tpl->assign('showSelfAssessment',  USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::isAllowedModule(MODULE_MENU_SELFASSESSMENT));
        $tpl->assign('showEmployees',       USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEES));
        $tpl->assign('showChangePassword',  USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::isAllowedModule(MODULE_CHANGE_PASSWORD));
        $tpl->assign('showReports',         USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::hasApplicationMenuAllowedModules(APPLICATION_MENU_REPORTS));
        $tpl->assign('showLibraries',       USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::hasApplicationMenuAllowedModules(APPLICATION_MENU_LIBRARIES));
        $tpl->assign('showSettings',        USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::hasApplicationMenuAllowedModules(APPLICATION_MENU_SETTINGS));
        $tpl->assign('showHelp',            USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::hasApplicationMenuAllowedModules(APPLICATION_MENU_HELP));
        // altijd uitloggen
        $tpl->assign('showLogOut',          true);

        return $smarty->fetch($tpl);
    }

    static function buildReportsMenu($activeModule)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/reportsMenuPam4.tpl');
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_REPORTS);
        $tpl->assign('lastModule', $lastModule);

        $tpl->assign('active', $activeModule);
        $tpl->assign('showSelfAssessmentReports',   ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_REPORTS));
        $tpl->assign('show360',                     ApplicationNavigationService::isAllowedModule(MODULE_360));
        $tpl->assign('showNotificationAlerts',      ApplicationNavigationService::isAllowedModule(MODULE_EMAIL_PDP_NOTIFICATION_ALERTS));
        $tpl->assign('showScoreboard',              ApplicationNavigationService::isAllowedModule(MODULE_SCOREBOARD));
        $tpl->assign('showTalentSelector',          ApplicationNavigationService::isAllowedModule(MODULE_TALENT_SELECTOR));
        $tpl->assign('showPerformanceGrid',         ApplicationNavigationService::isAllowedModule(MODULE_PERFORMANCE_GRID));
        $tpl->assign('showHistory',                 ApplicationNavigationService::isAllowedModule(MODULE_HISTORY));
        $tpl->assign('showPdpTodoList',             ApplicationNavigationService::isAllowedModule(MODULE_PDP_TODO_LIST));
        $tpl->assign('showPrintPortfolio',          ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_PORTFOLIO));
        $tpl->assign('showManagers',                ApplicationNavigationService::isAllowedModule(MODULE_REPORTS_MANAGER));
        $tpl->assign('showDashboardFinalResult',    ApplicationNavigationService::isAllowedModule(MODULE_REPORTS_MENU_DASHBOARD_FINAL_RESULT));
        $tpl->assign('showDashboardTraining',       ApplicationNavigationService::isAllowedModule(MODULE_REPORTS_MENU_DASHBOARD_TRAINING));
        return $smarty->fetch($tpl);
    }

    static function buildHelpMenu($activeModule) {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/helpMenuPam4.tpl');
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_HELP);
        $tpl->assign('lastModule', $lastModule);

        $tpl->assign('active', $activeModule);
        $tpl->assign('showInfo',        ApplicationNavigationService::isAllowedModule(MODULE_INFO));
        $tpl->assign('showTechManual',  ApplicationNavigationService::isAllowedModule(MODULE_TECH_MANUAL));
        $tpl->assign('showUserManual',  ApplicationNavigationService::isAllowedModule(MODULE_USER_MANUAL));
        return $smarty->fetch($tpl);
    }

    static function buildLibraryMenu($activeModule)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/libraryMenuPam4.tpl');
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_LIBRARIES);
        $tpl->assign('lastModule', $lastModule);

        $tpl->assign('active', $activeModule);
        $tpl->assign('showCompetences',         ApplicationNavigationService::isAllowedModule(MODULE_COMPETENCES));
        $tpl->assign('showJobProfiles',         ApplicationNavigationService::isAllowedModule(MODULE_JOB_PROFILES));
        $tpl->assign('showDepartments',         ApplicationNavigationService::isAllowedModule(MODULE_LIBRARY_DEPARTMENTS));
        $tpl->assign('showAssessmentCycle',     ApplicationNavigationService::isAllowedModule(MODULE_ASSESSMENT_CYCLE));
        $tpl->assign('showScales',              ApplicationNavigationService::isAllowedModule(MODULE_SCALES));
        $tpl->assign('showQuestions',           ApplicationNavigationService::isAllowedModule(MODULE_QUESTIONS));
        $tpl->assign('showDocumentClusters',    ApplicationNavigationService::isAllowedModule(MODULE_DOCUMENT_CLUSTERS));
        $tpl->assign('showPdpActionLib',        ApplicationNavigationService::isAllowedModule(MODULE_PDP_ACTION_LIB));
        $tpl->assign('showPdpTaskLib',          ApplicationNavigationService::isAllowedModule(MODULE_PDP_TASK_LIB));
        $tpl->assign('showPdpTaskOwner',        ApplicationNavigationService::isAllowedModule(MODULE_PDP_TASK_OWNER));
        $tpl->assign('showEmails',              ApplicationNavigationService::isAllowedModule(MODULE_EMAILS));
        return $smarty->fetch($tpl);
    }

    static function buildEmployeesMenu($employeeId, $active)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/employeesMenuPam4.tpl');
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(MODULE_EMPLOYEES);
        $tpl->assign('lastModule', $lastModule);
        $tpl->assign('active', $active);
        $tpl->assign('employeeId', $employeeId);
        $tpl->assign('noEmployee', empty($employeeId));
        $tpl->assign('showEmployeeProfile',     ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_PROFILE));
        $tpl->assign('showEmployeeAttachments', ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_ATTACHMENTS));
        $tpl->assign('showEmployeeScore',       ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_SCORE));
        $tpl->assign('showEmployeePdpActions',  ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_PDP_ACTIONS));
        $tpl->assign('showEmployeeTargets',     ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_TARGETS));
        $tpl->assign('showEmployeeFinalResult', ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_FINAL_RESULTS));
        $tpl->assign('showEmployeeTraining',    ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_TRAINING));
        $tpl->assign('showEmployeeInvitations', ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_INVITATIONS));
        $tpl->assign('showEmployee360',         ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_360));
        $tpl->assign('showEmployeeHistory',     ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEE_HISTORY));
        return $smarty->fetch($tpl);
    }

    static function buildEmailMenu($active)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/emailsSubMenuPam4.tpl');
        $tpl->assign('lastModule', MODULE_EMAIL_PDP_NOTIFICATION_MESSAGE);
        $tpl->assign('active', $active);
        return $smarty->fetch($tpl);
    }


    static function buildThemeMenu($active)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/themesSubMenuPam4.tpl');
        $tpl->assign('lastModule', MODULE_THEMES_LANGUAGE);
        $tpl->assign('showColour', FALSE);
        $tpl->assign('active', $active);
        return $smarty->fetch($tpl);
    }

    static function buildSettingsMenu($activeModule)
    {
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_SETTINGS);

        global $smarty;
        $tpl = $smarty->createTemplate('navigation/settingsMenuPam4.tpl');
        $tpl->assign('lastModule', $lastModule);
        $tpl->assign('active', $activeModule);
        $tpl->assign('showLevelAuthorization',  ApplicationNavigationService::isAllowedModule(MODULE_LEVEL_AUTHORIZATION));
        $tpl->assign('showUsers',               ApplicationNavigationService::isAllowedModule(MODULE_USERS));
        $tpl->assign('showThemes',              ApplicationNavigationService::isAllowedModule(MODULE_THEMES));
        $tpl->assign('showDefaultDate',         ApplicationNavigationService::isAllowedModule(MODULE_DEFAULT_DATE));
        $tpl->assign('showEmpArchives',         ApplicationNavigationService::isAllowedModule(MODULE_EMPLOYEES_ARCHIVED));
        return $smarty->fetch($tpl);
    }

    static function buildOrganisationMenu($active)
    {
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_ORGANISATION);

        global $smarty;
        $tpl = $smarty->createTemplate('navigation/organisationMenuPam4.tpl');
        $tpl->assign('active', $active);
        $tpl->assign('lastModule', $lastModule);
        $tpl->assign('showCompanyInformation',      ApplicationNavigationService::isAllowedModule(MODULE_ORGANISATION_MENU_COMPANY_INFO));
        $tpl->assign('showDepartments',             ApplicationNavigationService::isAllowedModule(MODULE_ORGANISATION_MENU_DEPARTMENTS));
        $tpl->assign('showManagers',                ApplicationNavigationService::isAllowedModule(MODULE_ORGANISATION_MENU_MANAGERS));
        $tpl->assign('showBatchAddPDP',             ApplicationNavigationService::isAllowedModule(MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH));
        $tpl->assign('showBatchAddTarget',          ApplicationNavigationService::isAllowedModule(MODULE_ORGANISATION_MENU_TARGETS_BATCH));
        $tpl->assign('showBatchAddFiles',           ApplicationNavigationService::isAllowedModule(MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH));
        return $smarty->fetch($tpl);
    }

    static function buildDashboardMenu($active)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/dashboardMenuPam4.tpl');
        $tpl->assign('active', $active);
//        $tpl->assign('lastModule', MODULE_ORGANISATION_MENU_COMPANY_INFO);
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_DASHBOARD);
        $tpl->assign('lastModule', $lastModule);
        // de menu options vallen onder de edit...
        $tpl->assign('showDepartments',                         ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DEPARTMENTS));
        $tpl->assign('showManagers',                            ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_MANAGERS));
        $tpl->assign('showPrintPortfolio',                      ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_EMPLOYEE_PORTFOLIO));
        $tpl->assign('showDashboardPdpActions',                 ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS));
        $tpl->assign('showDashboardTargets',                    ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS));
        $tpl->assign('showDashboardFinalResult',                ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT));
        $tpl->assign('showDashboardTraining',                   ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DASHBOARD_TRAINING));
        $tpl->assign('showOverviewSelfAssessmentInvitations',   ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS));
        $tpl->assign('showDashboardSelfAssessments',            ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS));
        $tpl->assign('showDashboardAssessmentProcess',          ApplicationNavigationService::isAllowedModule(MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS));
        return $smarty->fetch($tpl);
    }

    static function buildSelfAssessmentMenu($active)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('navigation/selfAssessmentMenuPam4.tpl');
        $tpl->assign('active', $active);
        $lastModule = ApplicationNavigationService::getLastAllowedModuleInApplicationMenu(APPLICATION_MENU_SELFASSESSMENT);
        $tpl->assign('lastModule', $lastModule);
        // de menu options vallen onder de edit...
        $tpl->assign('showBatchSelfAssessment',                     ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH));
        $tpl->assign('showBatchSelfAssessmentReminders',            ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH));
        $tpl->assign('showBatchSelfAssessmentSatisfactionLetter',   ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_MENU_SATISFACTIONLETTER_SELFASSESSEMENT_BATCH));
        $tpl->assign('showOverviewSelfAssessmentInvitations',       ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS));
        $tpl->assign('showDashboardSelfAssessments',                ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS));
        $tpl->assign('showDashboardAssessmentProcess',              ApplicationNavigationService::isAllowedModule(MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS));
        return $smarty->fetch($tpl);
    }


}

// hbd: logs zijn hetzelfde, alleen toevoegen aan ander element...
function moduleUtils_showLastModifiedInfo($by, $date, $time) {
    return create_logs($by, $date, $time, 'logs');
}

function moduleUtils_showLastModifiedInfo2($element_id, $by, $date, $time) {
    return create_logs($by, $date, $time, $element_id);
}

function create_logs($by, $date, $time, $assign_element)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        $html = InterfaceBuilder::LogHtml($by, $date, $time);
        $objResponse->assign($assign_element, 'innerHTML', $html);
    }

    return $objResponse;

}

?>