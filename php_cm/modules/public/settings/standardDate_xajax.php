<?php

require_once('modules/process/settings/StandardDateInterfaceProcessor.class.php');

function public_settings__displayStandardDate()
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_DEFAULT_DATE)) {
        StandardDateInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

function public_settings__editStandardDate()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_DEFAULT_DATE)) {
        StandardDateInterfaceProcessor::displayEdit($objResponse);
    }

    return $objResponse;

}

?>
