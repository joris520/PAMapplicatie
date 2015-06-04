<?php

/*
 * Description of EmployeeTargetSafeFormProcessor
 *
 * @author hans.prins
 */

require_once('modules/model/valueobjects/employee/target/EmployeeTargetValueObject.class.php');

class EmployeeTargetSafeFormProcessor {

    static function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            $employeeId           = $safeFormHandler->retrieveSafeValue ('employeeId');
            $targetName           = $safeFormHandler->retrieveInputValue('target_name');
            $performanceIndicator = $safeFormHandler->retrieveInputValue('performance_indicator');
            $endDate              = $safeFormHandler->retrieveDateValue ('end_date');
            $status               = $safeFormHandler->retrieveInputValue('status');
            $evaluation           = NULL;
            $evaluationDate       = NULL;

            $targetValueObject    = EmployeeTargetValueObject::createWithValues($employeeId,
                                                                                NULL,
                                                                                $targetName,
                                                                                $performanceIndicator,
                                                                                $endDate,
                                                                                $status,
                                                                                $evaluation,
                                                                                $evaluationDate);

            list($hasError, $messages, $employeeTargetId) = EmployeeTargetController::processAddTarget($employeeId, $targetValueObject);
            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeTargetInterfaceProcessor::finishAdd($objResponse, $employeeId, $employeeTargetId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS) ||
            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {

            $employeeId           = $safeFormHandler->retrieveSafeValue ('employeeId');
            $employeeTargetId     = $safeFormHandler->retrieveSafeValue ('employeeTargetId');

            if(PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
                $targetName           = $safeFormHandler->retrieveInputValue('target_name');
                $performanceIndicator = $safeFormHandler->retrieveInputValue('performance_indicator');
                $endDate              = $safeFormHandler->retrieveDateValue ('end_date');
            }

            if(PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
                $status           = $safeFormHandler->retrieveInputValue('status');
                $evaluation       = $safeFormHandler->retrieveInputValue('evaluation');
                $evaluationDate   = $safeFormHandler->retrieveDateValue ('evaluation_date');
            }

            // alleen de uitgevraagde waarden meegeven
            $targetValueObject    = EmployeeTargetValueObject::createWithValues($employeeId,
                                                                                NULL,
                                                                                $targetName,
                                                                                $performanceIndicator,
                                                                                $endDate,
                                                                                $status,
                                                                                $evaluation,
                                                                                $evaluationDate);

            list($hasError, $messages) = EmployeeTargetController::processEditTarget($employeeId, $employeeTargetId, $targetValueObject);

            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeTargetInterfaceProcessor::finishEdit($objResponse, $employeeId, $employeeTargetId);
            }

        }
        return array($hasError, $messages);
    }

    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            $employeeId       = $safeFormHandler->retrieveSafeValue('employeeId');
            $employeeTargetId = $safeFormHandler->retrieveSafeValue('employeeTargetId');

            list($hasError, $messages) = EmployeeTargetController::processRemoveTarget($employeeId, $employeeTargetId);

            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeTargetInterfaceProcessor::finishRemove($objResponse, $employeeId, $employeeTargetId);
            }
        }
        return array($hasError, $messages);
    }

    function processPrintOptions($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_TARGETS)) {

            $employeeId = $safeFormHandler->retrieveSafeValue ('employeeId');
            $assessmentCycleOption  = $safeFormHandler->retrieveInputValue('show_cycle');

            list($hasError, $messages) = EmployeeTargetController::processPrintOptionsTarget(   $employeeId,
                                                                                                $assessmentCycleOption);

            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeTargetInterfaceProcessor::finishPrintOptions($objResponse);
            }
        }
        return array($hasError, $messages);
    }
}

?>
