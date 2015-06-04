<?php

/**
 * Description of EmployeeProfileUserSafeFormProcessor
 *
 * @author ben.dokter
 */


require_once('application/model/service/UserController.class.php');
require_once('application/model/valueobjects/UserValueObject.class.php');

class EmployeeProfileUserSafeFormProcessor
{
    // TODO: naar users?
    static function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_USERS)) {

            $employeeId         = $safeFormHandler->retrieveSafeValue('employeeId');
            $employeeName       = $safeFormHandler->retrieveSafeValue('employeeName');

            $login              = $safeFormHandler->retrieveInputValue('username');
            $password           = $safeFormHandler->retrieveInputValue('password');
            $emailAddress       = $safeFormHandler->retrieveInputValue('email_address');
            $userLevel          = $safeFormHandler->retrieveInputValue('user_level');

            $valueObject = UserValueObject::createWithValues(   NULL,
                                                                $employeeId,
                                                                $employeeName,
                                                                $emailAddress,
                                                                $login,
                                                                $userLevel,
                                                                USER_IS_ACTIVE);

            list($hasError, $messages) = UserController::processAddUserForEmployee($employeeId, $valueObject, $password, UserLevelValue::MODE_EMPLOYEE_EDIT);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeProfileInterfaceProcessor::finishAddUser($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }
}

?>