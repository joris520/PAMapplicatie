<?php

/**
 * Description of UserService
 *
 * @author ben.dokter
 */

require_once('application/model/queries/UserQueries.class.php');

class UserService
{
    static function getUserValueObjectForUserId($userId)
    {
        $query = UserQueries::findUserDataByUserId($userId);
        $userData = mysql_fetch_assoc($query);

        mysql_free_result($query);

        return UserValueObject::createWithData($userData);
    }

    static function getUserValueObjectForEmployee($employeeId)
    {
        $query = UserQueries::findUserDataByEmployeeId($employeeId);
        $userData = mysql_fetch_assoc($query);

        mysql_free_result($query);

        return UserValueObject::createWithData($userData);
    }

    static function getUserIdByLogin($login)
    {
        $query = UserQueries::findUserIdByUsername($login);
        $userData = mysql_fetch_assoc($query);

        mysql_free_result($query);

        return $userData[UserQueries::ID_FIELD];
    }

    static function validateUserForEmployee(UserValueObject $valueObject, $password, $userLevelMode)
    {

        $hasError = false;
        $messages = array();

        $login              = $valueObject->getLogin();
        $emailAddress       = $valueObject->getEmailaddress();
        $userLevel          = $valueObject->getUserLevel();

        list($hasError, $messages) = EmailService::validateEmailAddress($emailAddress, true);
        if (empty($login)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_USERNAME');
        } else {
            $existingUserId = self::getUserIdByLogin($login);
            if (!empty($existingUserId)) {
                $hasError = true;
                $messages[] = TXT_UCF('USERNAME_ALREADY_EXIST_PLEASE_TRY_AGAIN');
            }
        }

        if (empty($password)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_PASSWORD');
        } else {
            if ($login == $password) { // betere equals?
                $hasError = true;
                $messages[] = TXT_UCF('PASSWORD_MUST_NOT_BE_THE_SAME_AS_THE_USERNAME');
            } elseif (!UserLoginService::isPasswordValidFormat($password)) {
                $hasError = true;
                $messages[] = TXT_UCF('VALID_PASSWORD_FORMAT');
            }
        }
        if (!UserLevelValue::isValidValue($userLevel, $userLevelMode)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_A_USER_LEVEL');
        }

        return array($hasError, $messages);
    }

    static function insertUserForEmployee($employeeId, $valueObject)
    {
        $newUserId = UserQueries::insertNewUserForEmployee( $employeeId,
                                                            $valueObject->getName(),
                                                            $valueObject->getEmailaddress(),
                                                            $valueObject->getLogin(),
                                                            $valueObject->getUserLevel());
        return $newUserId;
    }

    static function updateUserForEmployee($employeeId, $employeeName, $emailAddress)
    {
        return UserQueries::updateUserForEmployee($employeeId, $employeeName, $emailAddress);
    }

    static function updateUserEmailForEmployee($employeeId, $emailAddress)
    {
        return UserQueries::updateUserEmailForEmployee($employeeId, $emailAddress);
    }

    static function disableUserForEmployeeId($employeeId)
    {
        UserQueries::disableUserByEmployeeId($employeeId);

    }

}

?>
