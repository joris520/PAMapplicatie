<?php

/**
 * Description of employeeProfile_xajax
 *
 * @author ben.dokter
 */

require_once('modules/process/employee/profile/EmployeeProfileInterfaceProcessor.class.php');

function public_employeeProfile__displayPage($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayView($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeProfile__editPersonal($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayEditPersonal($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeProfile__removePhoto($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayRemovePhoto($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeProfile__uploadPhoto($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayUploadPhoto($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeProfile__editOrganisation($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayEditOrganisation($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeProfile__editInformation($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayEditInformation($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeProfile__addUser($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeProfileInterfaceProcessor::displayAddUser($objResponse, $employeeId);
    }
    return $objResponse;
}

?>
