<?php

/**
 * Description of EmployeeGenderValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseValue.class.php');


class EmployeeGenderValue extends BaseValue
{
    const MALE      = 'Male';
    const FEMALE    = 'Female';

    static function values()
    {
        return array(
            EmployeeGenderValue::MALE,
            EmployeeGenderValue::FEMALE
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

    function isMale($value)
    {
        return $value == self::MALE;
    }

    function isFemale($value)
    {
        return $value == self::FEMALE;
    }
}

?>
