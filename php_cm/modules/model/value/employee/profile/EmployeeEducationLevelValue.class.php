<?php

/**
 * Description of EmployeeEducationLevelValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseValue.class.php');


class EmployeeEducationLevelValue extends BaseValue
{
    const NONE      = 0;
    const LBO       = 1;
    const MBO       = 2;
    const HBO       = 3;
    const WO        = 4;

    static function values()
    {
        return array(
            EmployeeEducationLevelValue::LBO,
            EmployeeEducationLevelValue::MBO,
            EmployeeEducationLevelValue::HBO,
            EmployeeEducationLevelValue::WO
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_OPTIONAL);
    }

}

?>
