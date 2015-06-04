<?php

require_once('modules/process/employee/document/EmployeeDocumentInterfaceProcessor.class.php');

function public_employeeDocument__displayPage($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeDocumentInterfaceProcessor::displayView($objResponse,
                                                        $employeeId);
    }
    return $objResponse;
}

function public_employeeDocument__editDocumentInfo( $employeeId,
                                                    $employeeDocumentId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeDocumentInterfaceProcessor::displayEdit($objResponse,
                                                        $employeeId,
                                                        $employeeDocumentId);
    }
    return $objResponse;
}


function public_employeeDocument__removeDocument(   $employeeId,
                                                    $employeeDocumentId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeDocumentInterfaceProcessor::displayRemove(  $objResponse,
                                                            $employeeId,
                                                            $employeeDocumentId);
    }
    return $objResponse;
}

function public_employeeDocument__uploadDocument($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeDocumentInterfaceProcessor::displayUploadDocument(  $objResponse,
                                                                    $employeeId);
    }
    return $objResponse;
}

function public_employeeDocument__cancelUploadDocument($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeDocumentInterfaceProcessor::cancelUploadDocument(   $objResponse,
                                                                    $employeeId);
    }
    return $objResponse;
}



?>