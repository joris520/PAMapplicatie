<?php

require_once('modules/process/report/BaseReportEmployeeInterfaceProcessor.class.php');

function public_report__selectAssessmentCycle($reportMode)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        BaseReportEmployeeInterfaceProcessor::displayInlineAssessmentCycleSelector( $objResponse,
                                                                                    $reportMode);
    }
    return $objResponse;
}

function public_report__cancelSelectAssessmentCycle()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        BaseReportEmployeeInterfaceProcessor::cancelInlineAssessmentCycleSelector(  $objResponse);
    }
    return $objResponse;
}

function public_report__dashboardEmployeesTotalDetail($bossId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        BaseReportEmployeeInterfaceProcessor::displayDetailEmployeesForBoss($objResponse,
                                                                            $bossId);
    }
    return $objResponse;
}


?>