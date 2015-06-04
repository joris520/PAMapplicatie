<?php

require_once('modules/process/tab/SelfAssessmentTabInterfaceProcessor.class.php');


function public_selfAssessment__displayTab()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        SelfAssessmentTabInterfaceProcessor::displayViewPage($objResponse);
    }
    return $objResponse;
}


?>
