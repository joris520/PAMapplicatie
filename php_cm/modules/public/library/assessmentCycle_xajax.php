<?php

require_once('modules/process/library/AssessmentCycleInterfaceProcessor.class.php');

function public_library__displayAssessmentCycles()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentCycleInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}


function public_library__addAssessmentCycle()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentCycleInterfaceProcessor::displayAdd($objResponse);
    }
    return $objResponse;
}

function public_library__editAssessmentCycle($assessmentCycleId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentCycleInterfaceProcessor::displayEdit($objResponse, $assessmentCycleId);
    }
    return $objResponse;
}

function public_library__removeAssessmentCycle($assessmentCycleId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentCycleInterfaceProcessor::displayRemove($objResponse, $assessmentCycleId);
    }
    return $objResponse;
}

?>
