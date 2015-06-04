<?php

require_once('application/process/ApplicationNavigationProcessor.class.php');
require_once('application/interface/builder/ApplicationNavigationInterfaceBuilder.class.php');

function public_navigation_startApplication()
{
    $currentApplicationMenu = ApplicationNavigationService::getCurrentApplicationMenu();

    switch ($currentApplicationMenu) {
        case APPLICATION_MENU_EMPLOYEES:
            return public_navigation_applicationMenu_employees();
            break;
        case APPLICATION_MENU_DASHBOARD:
            return public_navigation_applicationMenu_dashboard();
            break;
        case APPLICATION_MENU_SELFASSESSMENT:
            return public_navigation_applicationMenu_selfAssessment();
            break;
        case APPLICATION_MENU_ORGANISATION:
            return public_navigation_applicationMenu_organisation();
            break;
        case APPLICATION_MENU_LIBRARIES:
            return public_navigation_applicationMenu_library();
            break;
        case APPLICATION_MENU_REPORTS:
            return public_navigation_applicationMenu_reports();
            break;
        case APPLICATION_MENU_PRINTS:
            return moduleNavigation_menuPrint();
            break;
        case APPLICATION_MENU_SETTINGS:
             return public_navigation_applicationMenu_settings();
            break;
        case APPLICATION_MENU_HELP:
            return public_navigation_applicationMenu_help();
            break;
    }
}


function public_navigation_applicationMenu_employees()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_EMPLOYEES);
    }
    return $objResponse;

}

function public_navigation_applicationMenu_organisation()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_ORGANISATION);
    }

    return $objResponse;
}

function public_navigation_applicationMenu_dashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_DASHBOARD);
    }

    return $objResponse;
}

function public_navigation_applicationMenu_selfAssessment()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_SELFASSESSMENT);
    }

    return $objResponse;
}

function public_navigation_applicationMenu_reports() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_REPORTS);
    }

    return $objResponse;
}

function public_navigation_applicationMenu_library()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_LIBRARIES);
    }

    return $objResponse;
}

function public_navigation_applicationMenu_settings() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_SETTINGS);
    }

    return $objResponse;
}

function public_navigation_applicationMenu_help() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        ApplicationNavigationProcessor::activateApplicationMenu($objResponse, APPLICATION_MENU_HELP);
    }

    return $objResponse;
}


function public_modifyCurrentDate($form)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PamApplication::setReferenceDate(DateUtils::convertToDatabaseDate($form['reference_date']));
        if (PamApplication::hasModifiedReferenceDate()) {
            InterfaceXajax::addClass($objResponse, 'reference_date', 'warning');
        } else {
            InterfaceXajax::removeClass($objResponse, 'reference_date', 'warning');
        }
    } else {
        InterfaceXajax::addClass($objResponse, 'reference_date', 'error');

    }
    return $objResponse;
}

?>
