<?php

require_once('modules/process/report/ManagerReportInterfaceProcessor.class.php');

function public_organisation__displayManagers()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ManagerReportInterfaceProcessor::displayModuleView($objResponse, MODULE_ORGANISATION_MENU_MANAGERS);
    }
    return $objResponse;
}

function public_report__displayManagers()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ManagerReportInterfaceProcessor::displayModuleView($objResponse, MODULE_REPORTS_MANAGER);
    }
    return $objResponse;
}

function public_dashboard__displayManagers()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ManagerReportInterfaceProcessor::displayModuleView($objResponse, MODULE_DASHBOARD_MENU_MANAGERS);
    }
    return $objResponse;
}

function public_report__detailManagerEmployees($managerReportId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ManagerReportInterfaceProcessor::displayDetailEmployees($objResponse, $managerReportId);
    }
    return $objResponse;
}

function public_report__detailManagerDepartments($managerReportId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        ManagerReportInterfaceProcessor::displayDetailDepartments($objResponse, $managerReportId);
    }
    return $objResponse;
}


?>
