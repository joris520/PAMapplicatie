<?php

/**
 * Description of EmployeeTargetBatchController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/target/EmployeeTargetController.class.php');

class EmployeeTargetBatchController
{

    static function processAdd($employeeIds, EmployeeTargetValueObject $targetValueObject)
    {
        $hasError = true;
        $messages = array();

        BaseQueries::startTransaction();

        // hier de validatie apart om niet voor elke employee dezelfde foutmelding te krijgen
        list($hasError, $messages) = EmployeeTargetService::validateAdd($targetValueObject, EmployeeTargetService::IGNORE_STATUS);

        if (!$hasError) {
            foreach ($employeeIds as $employeeId) {
                EmployeeTargetController::processAddTarget($employeeId, $targetValueObject, EmployeeTargetController::ALREADY_VALIDATED);
            }
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

}

?>
