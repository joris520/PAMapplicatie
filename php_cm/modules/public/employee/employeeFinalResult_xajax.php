<?php

/**
 * Description of employeeFinalResult_xajax
 *
 * @author ben.dokter
 */

require_once('modules/process/employee/finalResult//EmployeeFinalResultInterfaceProcessor.class.php');

function public_employeeFinalResult__displayFinalResult($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeFinalResultInterfaceProcessor::displayView($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeFinalResult__editFinalResult($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeFinalResultInterfaceProcessor::displayEdit($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeFinalResult__historyFinalResult($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeFinalResultInterfaceProcessor::displayHistory($objResponse, $employeeId);
    }
    return $objResponse;
}

?>
