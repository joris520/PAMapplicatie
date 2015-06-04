<?php


require_once('modules/process/report/AssessmentProcessReportInterfaceProcessor.class.php');

function public_report__displayProcessDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardView($objResponse,
                                                                        MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS);
    }
    return $objResponse;
}

function public_dashboard__displayProcessDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardView($objResponse,
                                                                        MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS);
    }
    return $objResponse;
}

function public_report__dashboardProcessPhase1Detail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardDetailProcessPhase1( $objResponse,
                                                                                        $bossId);
    }
    return $objResponse;
}

function public_report__dashboardProcessPhase2Detail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardDetailProcessPhase2( $objResponse,
                                                                                        $bossId);
    }
    return $objResponse;
}

function public_report__dashboardProcessPhase3Detail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardDetailProcessPhase3( $objResponse,
                                                                                        $bossId);
    }
    return $objResponse;
}

function public_report__dashboardProcessEvaluationNoneDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardDetailProcessEvaluationNone( $objResponse,
                                                                                                $bossId);
    }
    return $objResponse;
}

function public_report__dashboardProcessEvaluationPlannedDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardDetailProcessEvaluationPlanned(  $objResponse,
                                                                                                    $bossId);
    }
    return $objResponse;
}

function public_report__dashboardProcessEvaluationReadyDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentProcessReportInterfaceProcessor::displayDashboardDetailProcessEvaluationReady($objResponse,
                                                                                                $bossId);
    }
    return $objResponse;
}

?>
