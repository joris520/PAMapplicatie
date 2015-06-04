<?php

require_once('modules/process/assessmentProcess/AssessmentActionInterfaceProcessor.class.php');

function public_assessmentProcess__toggleEvaluationInvited($employeeId, $checkedNewValue)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        AssessmentActionInterfaceProcessor::toggleEvaluationInvited($objResponse, $employeeId, $checkedNewValue /*, $currentValue, $scoreRank*/);
    }
    return $objResponse;
}

?>
