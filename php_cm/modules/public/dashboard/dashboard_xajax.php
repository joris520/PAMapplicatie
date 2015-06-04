<?php

require_once('modules/process/tab/DashboardTabInterfaceProcessor.class.php');

function public_dashboard__displayTab()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DashboardTabInterfaceProcessor::displayViewPage($objResponse);
    }
    return $objResponse;
}


?>
