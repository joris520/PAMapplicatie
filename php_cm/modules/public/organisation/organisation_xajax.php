<?php

require_once('modules/process/tab/OrganisationTabInterfaceProcessor.class.php');

function public_organisation__displayTab()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        OrganisationTabInterfaceProcessor::displayViewPage($objResponse);
    }
    return $objResponse;
}

?>
