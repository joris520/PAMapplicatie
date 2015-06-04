<?php

/**
 * Description of BooleanValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class BooleanValue extends BaseDatabaseValue
{
    const FALSE = 1;
    const TRUE  = 2;

    static function values()
    {
        return array(
            BooleanValue::FALSE,
            BooleanValue::TRUE
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
