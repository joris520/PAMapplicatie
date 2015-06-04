<?php

require_once('modules/process/report/FinalResultReportInterfaceProcessor.class.php');

//function public_report__displayFinalResultDashboard()
//{
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse)) {
//        FinalResultReportInterfaceProcessor::displayDashboardView($objResponse, MODULE_ORGANISATION_MENU_DASHBOARD_FINAL_RESULT);
//    }
//    return $objResponse;
//}

function public_dashboard__displayFinalResultDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        FinalResultReportInterfaceProcessor::displayDashboardView(  $objResponse);
    }
    return $objResponse;
}

function public_report__dashboardFinalResultScoreDetail($bossId,
                                                        $scoreId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        FinalResultReportInterfaceProcessor::displayDashboardScoreDetail(   $objResponse,
                                                                            $bossId,
                                                                            $scoreId);
    }
    return $objResponse;
}

?>
