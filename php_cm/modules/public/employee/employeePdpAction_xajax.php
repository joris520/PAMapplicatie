<?php

require_once('modules//process/employee/pdpAction/EmployeePdpActionInterfaceProcessor.class.php');

function public_employeePdpAction__displayPage($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::displayView(   $objResponse,
                                                            $employeeId);
    }
    return $objResponse;
}

function public_employeePdpAction__addPdpAction($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::displayAdd($objResponse,
                                                        $employeeId);
    }
    return $objResponse;
}

function public_employeePdpAction__editPdpAction(   $employeeId,
                                                    $employeePdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::displayEdit(   $objResponse,
                                                            $employeeId,
                                                            $employeePdpActionId);
    }
    return $objResponse;
}

function public_employeePdpAction__removePdpAction( $employeeId,
                                                    $employeePdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::displayRemove( $objResponse,
                                                            $employeeId,
                                                            $employeePdpActionId);
    }
    return $objResponse;
}

function public_employeePdpAction__togglePdpActionLibraryVisibility($toggleMode)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::togglePdpActionLibraryVisibility(  $objResponse,
                                                                                $toggleMode);
    }
    return $objResponse;
}

function public_employeePdpAction__toggleCompetencesVisibility($toggleMode)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::toggleCompetencesVisibility(   $objResponse,
                                                                            $toggleMode);
    }
    return $objResponse;
}

function public_employeePdpAction__showPdpActionLibrary(    $employeePdpActionId = NULL)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeePdpActionInterfaceProcessor::displayPdpActionLibrary(   $objResponse,
                                                                        $employeePdpActionId);
    }
    return $objResponse;
}

?>
