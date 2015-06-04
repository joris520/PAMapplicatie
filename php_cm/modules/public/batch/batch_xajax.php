<?php

require_once('modules/process/batch/EmployeeTargetBatchInterfaceProcessor.class.php');
require_once('modules/process/batch/EmployeeSelfAssessmentBatchInterfaceProcessor.class.php');

function public_batch_addTarget()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeTargetBatchInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

function public_batch_inviteSelfAssessment()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeSelfAssessmentBatchInterfaceProcessor::displayInviteView($objResponse);
    }
    return $objResponse;
}

function public_batch_remindSelfAssessment()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeSelfAssessmentBatchInterfaceProcessor::displayRemindView($objResponse);
    }
    return $objResponse;
}

?>
