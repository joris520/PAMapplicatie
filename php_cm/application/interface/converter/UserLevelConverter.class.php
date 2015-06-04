<?php

/**
 * Description of UserLevelConverter
 *
 * @author ben.dokter
 */
//require_once('application/interface/converter/AbstractBaseConverter.class.php');

class UserLevelConverter //extends AbstractBaseConverter
{
    static function display($userLevel, $employeeSpecific = true)
    {
        $display = '';
        switch ($userLevel) {
            case UserLevelValue::SYS_ADMIN:
                $display = 'SysAdmin';
                break;
            case UserLevelValue::CUSTOMER_ADMIN:
                $display = (CUSTOMER_ID == 0) ? 'SysAdmin' : TXT_UCF('USER_LEVEL_NAME_ADMIN');
                break;
            case UserLevelValue::HR:
                $display = TXT_UCF('USER_LEVEL_NAME_HR');
                break;
            case UserLevelValue::MANAGER:
                $display = TXT_UCF('USER_LEVEL_NAME_MANAGER');
                break;
            case UserLevelValue::EMPLOYEE_EDIT:
                if ($employeeSpecific) {
                    $display = TXT_UCF('USER_LEVEL_NAME_EMPLOYEE_EDIT');
                } else {
                    $display = TXT_UCF('USER_LEVEL_NAME_EMPLOYEE');
                }
                break;
            case UserLevelValue::EMPLOYEE_VIEW:
                if ($employeeSpecific) {
                    $display = TXT_UCF('USER_LEVEL_NAME_EMPLOYEE_VIEW');
                } else {
                    $display = TXT_UCF('USER_LEVEL_NAME_EMPLOYEE');
                }
                break;
        }
        return $display;
    }

    static function input($scoreStatus, $empty = '-')
    {
        return self::display($scoreStatus, $empty);
    }

    // default nooit iets terug geven
    static function description($value)
    {
       return $value ? NULL : NULL;
    }
}

?>
