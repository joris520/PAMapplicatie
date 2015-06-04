<?php

/**
 * Description of FunctionLevelValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class FunctionLevelValue extends BaseDatabaseValue
{
    const IS_MAIN_FUNCTION = 1;
    const IS_ADDITIONAL_FUNCTION = 2;

    static function values()
    {
        return array(
            FunctionLevelValue::IS_MAIN_FUNCTION,
            FunctionLevelValue::IS_ADDITIONAL_FUNCTION
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
