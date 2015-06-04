<?php
require_once('applicationConsts.inc.php');
require_once('gino/PhpApplication.class.php');
require_once('application/model/service/user/UserLevelSwitchService.class.php');

class PamApplication extends PhpApplication
{
    const SESSION_STORE_USER                = 'user';
    const SESSION_STORE_LOGIN_USER_LEVEL    = 'login_user_level';
    const SESSION_STORE_REFERENCE_DATE      = 'peildatum';

    const COOKIE_PAM_BROWSER                = 'pam-browser';

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function storeCurrentUser($user)
    {
        $_SESSION[self::SESSION_STORE_USER] = $user;
    }

    static function retrieveCurrentUser()
    {
        return $_SESSION[self::SESSION_STORE_USER];
    }

    static function hasCurrentUser()
    {
        return isset($_SESSION[self::SESSION_STORE_USER]);
    }

    static function clearCurrentUser()
    {
        unset($_SESSION[self::SESSION_STORE_USER]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function storeLoginUserLevel($loginUserLevel)
    {
        $_SESSION[self::SESSION_STORE_LOGIN_USER_LEVEL] = $loginUserLevel;
    }

    static function retrieveLoginUserLevel()
    {
        return $_SESSION[self::SESSION_STORE_LOGIN_USER_LEVEL];
    }

    static function clearLoginUserLevel()
    {
        unset($_SESSION[self::SESSION_STORE_LOGIN_USER_LEVEL]);
    }


    static function restartUserSession()
    {
        $currentUser    = self::retrieveCurrentUser();
        $loginUserLevel = self::retrieveLoginUserLevel();

        ModuleUtils::ForceLogout();

        self::storeCurrentUser($currentUser);
        self::storeLoginUserLevel($loginUserLevel);

    }

    static function isAllowedSwitchUserLevel()
    {
        $isAllowed  = false;
        $userLevel  = self::retrieveLoginUserLevel();
        $employeeId = EMPLOYEE_ID;
        switch ($userLevel) {
            case UserLevelValue::MANAGER:
            case UserLevelValue::HR:
                $isAllowed = !empty($employeeId);
                break;
        }
        return CUSTOMER_OPTION_ALLOW_USER_LEVEL_SWITCH && $isAllowed;
    }

    static function getActualUserLevel()
    {
        return UserLevelSwitchService::switchedToEmployeeMode() ? self::getUserLevelEmployee() : self::retrieveLoginUserLevel();
    }

    static function getUserLevelEmployee()
    {
        return UserLevelValue::EMPLOYEE_EDIT;
    }

    static function isSingleUserLevel()
    {
        $isSingleUserLevel = false;
        $currentUserLevel = self::getActualUserLevel();
        switch ($currentUserLevel) {
            case UserLevelValue::EMPLOYEE_EDIT:
            case UserLevelValue::EMPLOYEE_VIEW:
                $isSingleUserLevel = true;
                break;
        }
        return $isSingleUserLevel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function setReferenceDate($referenceDate)
    {
        $_SESSION['peildatum'] = $referenceDate;
    }

    static function getReferenceDate()
    {
        if (empty($_SESSION[self::SESSION_STORE_REFERENCE_DATE])) {
            self::setReferenceDate(DateUtils::getCurrentDatabaseDate());
        }
        return $_SESSION[self::SESSION_STORE_REFERENCE_DATE];
    }

    static function hasModifiedReferenceDate()
    {
        return (self::getReferenceDate() != DateUtils::getCurrentDatabaseDate());
    }

    static function getCustomerLogoUrl($customer_id)
    {
        return APPLICATION_LOGO_BASE_URL . 'c' . $customer_id . '/';
    }

    static function hasValidSession($objResponse)
    {
        $hasValidSession = false;
        if (self::hasCurrentUser()) {
            $cookieName = ini_get('session.name');
            if (isset($_COOKIE[$cookieName]) &&
                isset($_COOKIE[self::COOKIE_PAM_BROWSER])) {
                $data = $_COOKIE[$cookieName];
                $timeout = time() + ini_get('session.cookie_lifetime');
                setcookie($cookieName, $data, $timeout, ini_get('session.cookie_path'));
                $hasValidSession = true;
            }
        } else {
            ModuleUtils::ForceLogout();
            if ($objResponse != NULL) {
                if (isset($_COOKIE[self::COOKIE_PAM_BROWSER])) {
                    // dan was de sessie gewoon verlopen;
                    // anders was de browser gesloten en hoeft de melding niet
                    $objResponse->alert('Uw sessie is verlopen. Log alsublieft opnieuw in.');
                }

                InterfaceXajax::reloadApplication($objResponse);
            }
        }
        return $hasValidSession;
    }

    static function isSysAdminLevel()
    {
        return USER_LEVEL == UserLevelValue::SYS_ADMIN;
    }

    static function isSysAdminUser()
    {
        return USER_ID == 1 && CUSTOMER_ID == 0 && self::isSysAdminLevel();
    }

}
?>
