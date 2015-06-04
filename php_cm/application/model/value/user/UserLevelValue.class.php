<?php

/**
 * Description of UserLevelValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseDatabaseValue.class.php');

class UserLevelValue extends BaseDatabaseValue
{

    // mode
    const MODE_EMPLOYEE_EDIT    = 1;
    const MODE_USER_EDIT        = 2;

    // users.user_level
    const SYS_ADMIN         = -7; // intern, mag alleen in de customers.php. Geen 0, maar veiligere waarde (-7!)
    const CUSTOMER_ADMIN    = 1;
    const HR                = 2;
    const MANAGER           = 3;
    const EMPLOYEE_EDIT     = 4;
    const EMPLOYEE_VIEW     = 5;


    static function values($mode = MODE_USER_EDIT)
    {
        $values = array();
        switch($mode) {
            case self::MODE_EMPLOYEE_EDIT:
                $values = array(
                            UserLevelValue::HR,
                            UserLevelValue::MANAGER,
                            UserLevelValue::EMPLOYEE_EDIT,
                            UserLevelValue::EMPLOYEE_VIEW
                            );
                break;
            case self::MODE_USER_EDIT:
                $values = array(
                            UserLevelValue::CUSTOMER_ADMIN,
                            UserLevelValue::HR,
                            UserLevelValue::MANAGER,
                            UserLevelValue::EMPLOYEE_EDIT,
                            UserLevelValue::EMPLOYEE_VIEW
                            );
                break;
        }
        return $values;
    }

    static function isValidValue($value, $mode = MODE_USER_EDIT)
    {
        return self::isAllowedValue($value, self::values($mode), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
