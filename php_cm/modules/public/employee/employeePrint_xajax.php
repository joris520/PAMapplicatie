<?php

require_once('modules/process/employee/print/EmployeePrintInterfaceProcessor.class.php');

function public_employeePrint__displayPrintOptions($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {

        EmployeePrintInterfaceProcessor::displayPrintOptions($objResponse, array($employeeId));
    }
    return $objResponse;
}
?>
