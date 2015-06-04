<?php

require_once('modules/process/report/PdpActionReportInterfaceProcessor.class.php');


function public_dashboard__displayPdpActionDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionReportInterfaceProcessor::displayDashboardView($objResponse);
    }
    return $objResponse;
}

function public_dashboard__displayPdpActionCompletedStatusDetail(   $bossId,
                                                                    $completedStatus)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionReportInterfaceProcessor::displayDashboardCompletedStatusDetail(   $objResponse,
                                                                                    $bossId,
                                                                                    $completedStatus);
    }
    return $objResponse;
}

?>
