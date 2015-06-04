<?php

require_once('modules/process/tab/EmployeesTabInterfaceProcessor.class.php');

function public_employee__displayTab()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        // hier het filter resetten, of alleen via het start menu ?
        EmployeeFilterService::initializeSession(EmployeeFilterService::CLEAR_FILTER);

        EmployeesTabInterfaceProcessor::displayViewPage($objResponse);
    }
    return $objResponse;
}

?>
