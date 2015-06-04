<?php

require_once('modules/process/report/SelfAssessmentReportInterfaceProcessor.class.php');

function public_report__displayInvitations()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayView($objResponse, MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS);
    }
    return $objResponse;
}

function public_dashboard__displayInvitations()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayView($objResponse, MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS);
    }
    return $objResponse;
}


function public_report__displayInvitationDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardView($objResponse, MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS);
    }
    return $objResponse;
}

function public_dashboard__displayInvitationDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardView($objResponse, MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS);
    }
    return $objResponse;
}

function public_report__detailInvitation($employeeId, $invitationHash)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDetailEmployee($objResponse, $employeeId, $invitationHash);
    }
    return $objResponse;
}

function public_report__dashboardInvitationsDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardDetailInvitations($objResponse, $bossId);
    }
    return $objResponse;
}

function public_report__dashboardEmployeeNotCompletedDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardDetailEmployeeNotCompleted($objResponse, $bossId);
    }
    return $objResponse;
}

function public_report__dashboardEmployeeCompletedDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardDetailEmployeeCompleted($objResponse, $bossId);
    }
    return $objResponse;
}


function public_report__dashboardBossNotCompletedDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardDetailBossNotCompleted($objResponse, $bossId);
    }
    return $objResponse;
}

function public_report__dashboardBossCompletedDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardDetailBossCompleted($objResponse, $bossId);
    }
    return $objResponse;
}

function public_report__dashboardFullCompletedDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentReportInterfaceProcessor::displayDashboardDetailFullCompleted($objResponse, $bossId);
    }
    return $objResponse;
}


?>
