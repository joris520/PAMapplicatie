<?php

require_once('modules/process/employee/assessmentInvitation/EmployeeAssessmentInvitationReportInterfaceProcessor.class.php');

function public_employeeAssessmentInvitation__displayPage($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeAssessmentInvitationReportInterfaceProcessor::displayView($objResponse, $employeeId);
    }
    return $objResponse;
}

?>
