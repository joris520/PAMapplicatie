<?php

require_once('modules/process/organisation/OrganisationInfoInterfaceProcessor.class.php');

function public_organisationInfo__displayInfo()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        OrganisationInfoInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

function public_organisationInfo__editInfo()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        OrganisationInfoInterfaceProcessor::displayEdit($objResponse);
    }
    return $objResponse;
}

?>
