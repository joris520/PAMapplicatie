<?php

/**
 * Description of UserLoginService
 *
 * @author ben.dokter
 */

require_once('application/model/queries/UserLoginQueries.class.php');
require_once('application/library/PamApplication.class.php');
require_once('application/library/PamValidators.class.php');

// todo: interface dingen hier wegwerken
require_once('application/interface/converter/TimeConverter.class.php');

class UserLoginService
{

    const IS_LOGGED_IN      = true;
    const IS_NOT_LOGGED_IN  = false;

    static function isPasswordValidFormat($password) {
        return PamValidators::isPasswordValidFormat($password);
    }

    static function findPassWordInfoByUserName($s_username)
    {
        $sql_result = UserLoginQueries::findPassWordInfoByUserName($s_username);
        return @mysql_fetch_assoc($sql_result);
    }

    static function isUsernamePasswordValid($s_username, $s_password)
    {
        $is_valid = false;

        $passwordInfo = UserLoginService::findPassWordInfoByUserName($s_username);
        if (!empty($passwordInfo)) {
            $is_valid = UserLoginService::isEqualPassword($passwordInfo['password'], $s_password);
        }
        return $is_valid;
    }

    static function generatePassword()
    {
        $password = chr(64 + rand(1,26)) . dechex(rand(1, 999999999)) . rand(1,10);

        while(strlen($password) < 8) {
            $password .= chr(64 + rand(1,26));
        }

        return $password;
    }

    static function isEqualPassword($s_password, $s_check_password)
    {
        return $s_check_password == $s_password;
    }

    static function changePassword($i_user_id, $s_new_password, $modified_by_user)
    {
        $updatedRows = UserLoginQueries::updatePasswordForUser( $i_user_id,
                                                                $s_new_password,
                                                                $modified_by_user);

        return $updatedRows == 1;
    }

    static function handleChangePasswordUserRequest($old_password, $new_password, $confirm_password)
    {
        return UserLoginService::handleChangePassword($old_password, $new_password, $confirm_password, USER_ID, true, USER, self::IS_LOGGED_IN);
    }

    static function handleChangePasswordForced($new_password, $confirm_password, $user_id, $modified_by_user)
    {
        return UserLoginService::handleChangePassword('', $new_password, $confirm_password, $user_id, false, $modified_by_user, self::IS_NOT_LOGGED_IN);
    }


    // TODO: structureel verbeteren!
    static function handleChangePassword($old_password, $new_password, $confirm_password, $user_id, $check_old, $modified_by_user, $userIsLoggedIn)
    {
        $hasError = false;
        $message = TXT_UCF('PLEASE_ENTER_ALL_PASSWORDS');

        if (empty($new_password) || empty($confirm_password)) {
            $hasError = true;
        }
        if ($check_old) {
            if (empty($old_password)) {
                $hasError = true;
            }
        }

        if (!$hasError) {
            $hasError = true; // bewijs maar dat het goed is...
            $message = TXT_UCF('YOU_HAVE_ENTERED_AN_INVALID_OLD_PASSWORD');
            $query = UserLoginQueries::getUserLoginByUserId($user_id, $userIsLoggedIn);

            if (@mysql_numrows($query) == 1) {
                $checkpass_row = @mysql_fetch_assoc($query);
                $dbpassword = $checkpass_row['dbpassword'];
                if ($check_old && !UserLoginService::isEqualPassword($dbpassword, $old_password)) {
                    $message = TXT_UCF('YOU_HAVE_ENTERED_AN_INVALID_OLD_PASSWORD');
                } elseif (UserLoginService::isEqualPassword($dbpassword, $new_password)) {
                    $message = TXT_UCF('YOU_CANNOT_USE_YOUR_OLD_PASSWORD');
                } elseif ($new_password != $confirm_password) {
                    $message = TXT_UCF('NEW_PASSWORD_AND_CONFIRM_PASSWORD_DOES_NOT_MATCH');
                } elseif (!UserLoginService::isPasswordValidFormat($new_password)) {
                    $message = TXT_UCF('VALID_PASSWORD_FORMAT');
                } else {
                    if (UserLoginService::changePassword($user_id, $new_password, $modified_by_user)) {
                        $hasError = false;
                        $message = TXT_UCF('PASSWORD_HAS_BEEN_CHANGED');
                    }
                }
            }
        }

        return array($hasError, $message);
    }

    static function getUserLoginInfo($s_username) {
        $userinfo_result = UserLoginQueries::getUserInfo($s_username);

        $user_found = false;
        $user_id = null;
        $customer_id = null;

        if (@mysql_num_rows($userinfo_result) == 1) {
            $user_found = true;
            $userinfo_row = @mysql_fetch_assoc($userinfo_result);
            $user_id = $userinfo_row['user_id'];
            $customer_id = $userinfo_row['customer_id'];
        }

        return array(
            $user_found,
            $user_id,
            $customer_id);
    }


    static function updateLastLogin($i_user_id) {
        UserLoginQueries::updateLastLogin($i_user_id);
    }

}

?>
