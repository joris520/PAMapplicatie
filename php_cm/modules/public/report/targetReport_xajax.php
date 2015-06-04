<?php

require_once('modules/process/report/TargetReportInterfaceProcessor.class.php');


function public_dashboard__displayTargetDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        TargetReportInterfaceProcessor::displayDashboardView($objResponse);
    }
    return $objResponse;
}

function public_dashboard__displayTargetStatusDetail(   $bossId,
                                                        $targetStatus)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        TargetReportInterfaceProcessor::displayDashboardTargetStatusDetail( $objResponse,
                                                                            $bossId,
                                                                            $targetStatus);
    }
    return $objResponse;
}

?>
