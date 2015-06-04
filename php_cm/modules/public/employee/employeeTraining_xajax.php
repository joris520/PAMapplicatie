<?php

require_once('modules/process/employee/training/EmployeeTrainingInterfaceProcessor.class.php');

function public_employeeTraining__displayTraining($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTrainingInterfaceProcessor::displayView($objResponse, $employeeId);
    }
    return $objResponse;
}


?>
