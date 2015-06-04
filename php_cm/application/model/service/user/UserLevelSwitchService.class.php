<?php

/**
 * Description of UserLevelSwitchService
 *
 * @author ben.dokter
 */

class UserLevelSwitchService
{
    const SESSION_STORE_USER_LEVEL_MODE = 'user_level_mode';

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function storeUserLevelMode($userLevelMode)
    {
        $_SESSION[self::SESSION_STORE_USER_LEVEL_MODE] = $userLevelMode;
    }

    static function retrieveUserLevelMode()
    {
        return $_SESSION[self::SESSION_STORE_USER_LEVEL_MODE];
    }

    static function clearUserLevelMode()
    {
        unset($_SESSION[self::SESSION_STORE_USER_LEVEL_MODE]);
    }

    static function switchedToEmployeeMode()
    {
        return  PamApplication::isAllowedSwitchUserLevel() &&
                self::retrieveUserLevelMode() == SWITCHED_TO_USER_LEVEL_EMPLOYEE;
    }

}

?>
