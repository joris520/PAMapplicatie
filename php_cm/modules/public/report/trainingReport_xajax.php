<?php


require_once('modules/process/report/TrainingReportInterfaceProcessor.class.php');

function public_dashboard__displayTrainingDashboard()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        TrainingReportInterfaceProcessor::displayDashboardView($objResponse);
    }
    return $objResponse;
}
?>
