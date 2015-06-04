<?php

/// alle xajax publieke functies voor de medewerkerslijst
// als add, archive, print....
//
//

require_once('modules/process/list/EmployeeListInterfaceProcessor.class.php');
require_once('modules/process/list/EmployeeFilterInterfaceProcessor.class.php');


function public_employeeList__addEmployee()
{
    // TODO...
    return moduleEmployees_addEmployee_deprecated();
}

function public_employeeList__archiveEmployee($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeListInterfaceProcessor::displayRemoveEmployee($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeList__toggleFilterVisibility()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeFilterInterfaceProcessor::toggleFilterVisibility($objResponse);
    }
    return $objResponse;
}

?>
