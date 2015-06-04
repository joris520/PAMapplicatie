<?php

/**
 * Description of EmployeeListSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/profile/EmployeeProfileController.class.php');

class EmployeeListSafeFormProcessor
{

    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PROFILE)) {

            $employeeId = $safeFormHandler->retrieveSafeValue('employeeId');

            list($hasError, $messages) = EmployeeProfileController::processRemoveEmployee($employeeId);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeListInterfaceProcessor::finishRemoveEmployee($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }


}

?>