<?php

require_once('modules/process/tab/TalentSelectorTabInterfaceProcessor.class.php');

function public_report__displayTalentSelector()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        TalentSelectorTabInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

?>
