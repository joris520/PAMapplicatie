<?php

/**
 * Description of EmployeeCompetenceSafeFormProcessor
 *
 * @author hans.prins
 */

class EmployeeCompetenceSafeFormProcessor
{
    static function processPrint($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_SCORES)) {

            $employeeIds = $safeFormHandler->retrieveSafeValue('employeeIds');

            $isAllowedRemarks   = EmployeePrintService::isPrintAllowedRemarks();
            $isAllowed360       = EmployeePrintService::isPrintAllowed360();
            $isAllowedPdpAction = EmployeePrintService::isPrintAllowedPdpAction();

            $showRemarksValue   = $safeFormHandler->retrieveInputValue('show_remarks')      ? BooleanValue::TRUE : BooleanValue::FALSE;
            $show360Value       = $safeFormHandler->retrieveInputValue('show_threesixty')   ? BooleanValue::TRUE : BooleanValue::FALSE;
            $showPdpActionValue = $safeFormHandler->retrieveInputValue('show_action')       ? BooleanValue::TRUE : BooleanValue::FALSE;;

            $showRemarks    = $isAllowedRemarks     ? $showRemarksValue     : BooleanValue::FALSE;
            $show360        = $isAllowed360         ? $show360Value         : BooleanValue::FALSE;
            $showPdpAction  = $isAllowedPdpAction   ? $showPdpActionValue   : BooleanValue::FALSE;

            list($hasError, $messages) = EmployeeCompetenceController::processPrintOptions( $employeeIds,
                                                                                            $showRemarks,
                                                                                            $show360,
                                                                                            $showPdpAction);

            if (!$hasError) {
                EmployeeCompetenceInterfaceProcessor::finishPrintOptions($objResponse);
            }
        }
        return array($hasError, $messages);
    }
}

?>
