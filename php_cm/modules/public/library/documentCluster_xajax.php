<?php

require_once('modules/process/library/DocumentClusterInterfaceProcessor.class.php');

function public_library__displayDocumentClusters()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DocumentClusterInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

function public_library__addDocumentCluster()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DocumentClusterInterfaceProcessor::displayAdd($objResponse);
    }
    return $objResponse;
}

function public_library__editDocumentCluster($documentClusterId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) ) {
        DocumentClusterInterfaceProcessor::displayEdit($objResponse, $documentClusterId);
    }
    return $objResponse;
}


function public_library__removeDocumentCluster($documentClusterId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        DocumentClusterInterfaceProcessor::displayRemove($objResponse, $documentClusterId);
    }
    return $objResponse;
}

?>
