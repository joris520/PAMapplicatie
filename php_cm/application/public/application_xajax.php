<?php

require_once('application/process/ApplicationInterfaceProcessor.class.php');

function public_application_changePassword()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) ) {
        PasswordInterfaceProcessor::displayEdit($objResponse);
    }
    return $objResponse;
}

function public_application_toggleUserLevel()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) ) {
        UserLevelSwitchInterfaceProcessor::displayEdit($objResponse);
    }
    return $objResponse;
}


?>
