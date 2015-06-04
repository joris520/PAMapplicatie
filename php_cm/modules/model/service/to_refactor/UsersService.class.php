<?php

/**
 * Description of Users
 *
 * @author ben.dokter
 */

require_once('application/model/queries/UserQueries.class.php');

class UsersService {

    static function checkValidEmployeeUser($username, $password, $email_address, $user_level)
    {
        $hasError = false;
        $message = '';
        $user_id = self::findUserByUsername($username);
        $usernameExists = !empty($user_id);
        if ($usernameExists) { // TODO: dubbele controles op !empty username eruit!
            $message = TXT_UCF('USERNAME_ALREADY_EXIST_PLEASE_TRY_AGAIN');
            $hasError = true;
        } elseif (empty($password)) {
            $message = TXT_UCF('PLEASE_ENTER_A_PASSWORD');
            $hasError = true;
        } elseif ($username == $password) {
            $message = TXT_UCF('PASSWORD_MUST_NOT_BE_THE_SAME_AS_THE_USERNAME');
            $hasError = true;
        } elseif (empty($email_address)) {
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL_REQUIRED_FOR_USER');
            $hasError = true;
        } elseif (!UserLoginService::isPasswordValidFormat($password)) {
            $message = TXT_UCF('VALID_PASSWORD_FORMAT');
            $hasError = true;
        } elseif (empty($user_level)) {
            $message = TXT_UCF('PLEASE_SELECT_A_USER_LEVEL');
            $hasError = true;
        }

        return array($hasError, $message);

    }

    static function findUserByUsername($username)
    {
        $user = @mysql_fetch_assoc(UserQueries::findUserIdByUsername($username));
        return $user['user_id'];
    }

    static function findUserByEmployeeId($employee_id)
    {
        $user = @mysql_fetch_assoc(UserQueries::findUserIdByEmployeeId($employee_id));
        return $user['user_id'];
    }


    static function insertUserForEmployee($employee_id,
                                          $employee, $email_address,
                                          $username, $password, $user_level)
    {
        if (!empty($username)) {
            $user_id = self::findUserByUsername($username);
            if (empty($user_id)) {
                $user_id = UserQueries::insertNewUserForEmployee($employee_id,
                                                                 $employee,
                                                                 $email_address,
                                                                 $username,
                                                                 $user_level);
                UserLoginService::changePassword($user_id, $password, USER);
            }
        }
        return $user_id;
    }

    static function updateUserForEmployee($employee_id,
                                          $employee,
                                          $email_address)
    {
        // deze kan altijd aangeroepen, mits tevoren gecontroleerd gelding op $email_address
        return UserQueries::updateUserForEmployee($employee_id,
                                                   $employee,
                                                   $email_address);
    }

    static function deactivateUserByEmployeeId($employee_id, $username)
    {
        try {
            UserQueries::disableUserByEmployeeId($employee_id);
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleCronException($timecodeException, 'fail deactivateUserByEmployeeId: id_e: [' . $employee_id . '], "' . $username . '"');
        }
    }

}

?>
