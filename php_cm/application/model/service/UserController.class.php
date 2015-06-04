<?php

/**
 * Description of UserController
 *
 * @author ben.dokter
 */

require_once('application/model/service/UserService.class.php');
require_once('application/model/service/UserLoginService.class.php');
require_once('application/model/service/UserLoginService.class.php');

class UserController
{
    static function processAddUserForEmployee(  $employeeId,
                                                UserValueObject $valueObject,
                                                $password,
                                                $editMode)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = UserService::validateUserForEmployee($valueObject, $password, $editMode);
        if (!$hasError) {
            $newUserId = UserService::insertUserForEmployee($employeeId, $valueObject);
            UserLoginService::changePassword($newUserId, $password, USER);

            // email ook terug naar employee personal/persondata
            EmployeeProfilePersonalService::updateEmailAddressRelated($employeeId, $valueObject->getEmailAddress());

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

}

?>
