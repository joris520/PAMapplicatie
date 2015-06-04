<?php

require_once('modules/process/organisation/DepartmentInterfaceProcessor.class.php');

function public_organisation__displayDepartments()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayModuleView($objResponse, MODULE_ORGANISATION_MENU_DEPARTMENTS);
    }
    return $objResponse;
}

function public_library__displayDepartments()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayModuleView($objResponse, MODULE_LIBRARY_DEPARTMENTS);
    }
    return $objResponse;
}

function public_dashboard__displayDepartments()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayModuleView($objResponse, MODULE_DASHBOARD_MENU_DEPARTMENTS);
    }
    return $objResponse;
}

function public_organisation__addDepartment()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayAdd($objResponse);
    }
    return $objResponse;
}

function public_organisation__editDepartment($departmentId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) ) {
        DepartmentInterfaceProcessor::displayEdit($objResponse, $departmentId);
    }
    return $objResponse;
}


function public_organisation__removeDepartment($departmentId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayRemove($objResponse, $departmentId);
    }
    return $objResponse;
}

function public_organisation__detailDepartmentEmployees($departmentId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayDetailEmployees($objResponse, $departmentId);
    }
    return $objResponse;
}

function public_organisation__detailDepartmentUsers($departmentId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DepartmentInterfaceProcessor::displayDetailUsers($objResponse, $departmentId);
    }
    return $objResponse;
}

?>
