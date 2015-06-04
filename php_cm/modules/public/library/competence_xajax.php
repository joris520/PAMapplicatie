<?php

require_once('modules/process/library/CompetenceInterfaceProcessor.class.php');

function public_library__showCompetenceDetail($competenceId, $mode)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        CompetenceInterfaceProcessor::showDetail($objResponse, $competenceId, $mode);
    }
    return $objResponse;
}

function public_library__hideCompetenceDetail($competenceId, $mode)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        CompetenceInterfaceProcessor::hideDetail($objResponse, $competenceId, $mode);
    }
    return $objResponse;
}


?>
