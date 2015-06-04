<?php

/**
 * Description of EmployeeTargetBatchSafeFormProcessor
 *
 * @author hans.prins
 */
require_once('modules/interface/components/select/SelectEmployees.class.php');

require_once('modules/model/valueobjects/employee/target/EmployeeTargetValueObject.class.php');

require_once('modules/model/service/batch/EmployeeTargetBatchController.class.php');

require_once('modules/process/batch/EmployeeTargetBatchInterfaceProcessor.class.php');

class EmployeeTargetBatchSafeFormProcessor
{
    static function processAddBatch($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
            $targetName           = $safeFormHandler->retrieveInputValue('target_name');
            $performanceIndicator = $safeFormHandler->retrieveInputValue('performance_indicator');
            $endDate              = $safeFormHandler->retrieveDateValue ('end_date');
            $status               = NULL;
            $evaluation           = NULL;
            $evaluationDate       = NULL;

            $targetValueObject    = EmployeeTargetValueObject::createWithValues(NULL, // employeeId
                                                                                NULL, // targetId
                                                                                $targetName,
                                                                                $performanceIndicator,
                                                                                $endDate,
                                                                                $status,
                                                                                $evaluation,
                                                                                $evaluationDate);

            $selectEmps = new SelectEmployees();
            if (!$selectEmps->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
                $hasError = true;
                $messages[] = $selectEmps->getErrorTxt();
            } else {
                $employeeIds = $selectEmps->processResults($safeFormHandler->retrieveCleanedValues());

                list($hasError, $messages) = EmployeeTargetBatchController::processAdd($employeeIds, $targetValueObject);
                if (!$hasError) {
                    $safeFormHandler->finalizeSafeFormProcess();

                    EmployeeTargetBatchInterfaceProcessor::finishAddBatch($objResponse, $targetName, count($employeeIds));
                }
            }
        }
        return array($hasError, $messages);
    }
}

?>
