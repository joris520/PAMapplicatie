<?php

require_once('modules/process/employee/target/EmployeeTargetInterfaceProcessor.class.php');

function public_employeeTarget__displayEmployeeTargets($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetInterfaceProcessor::displayView($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeTarget__addEmployeeTarget($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetInterfaceProcessor::displayAdd($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeTarget__editEmployeeTarget($employeeId, $employeeTargetId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetInterfaceProcessor::displayEdit($objResponse, $employeeId, $employeeTargetId);
    }
    return $objResponse;
}

function public_employeeTarget__removeEmployeeTarget($employeeId, $employeeTargetId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetInterfaceProcessor::displayRemove($objResponse, $employeeId, $employeeTargetId);
    }
    return $objResponse;
}

function public_employeeTarget__historyEmployeeTarget($employeeId, $employeeTargetId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetInterfaceProcessor::displayHistory($objResponse, $employeeId, $employeeTargetId);
    }
    return $objResponse;
}

function public_employeeTarget__displayPrintOptions($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetInterfaceProcessor::displayPrintOptions($objResponse, $employeeId);
    }
    return $objResponse;
}
?>
