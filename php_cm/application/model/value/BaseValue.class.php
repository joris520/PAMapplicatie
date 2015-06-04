<?php

/**
 * Description of BaseValue
 *
 * @author ben.dokter
 */

abstract class BaseValue
{
    // requiredState
    const VALUE_REQUIRED = 1;
    const VALUE_OPTIONAL = 2;

    // om er zeker van te zijn dat deze functies aanwezig zijn
    // TODO: eigenlijk is dit een php::interface
    abstract static function isValidValue($value);
    abstract static function values();


    protected static function isAllowedValue($value, $values, $requiredState = BaseDatabaseValue::VALUE_OPTIONAL)
    {
       $isAllowedValue = false;
       if ($requiredState == BaseDatabaseValue::VALUE_REQUIRED) {
           $isAllowedValue = in_array($value, $values);
       } elseif ($requiredState == BaseDatabaseValue::VALUE_OPTIONAL) {
           $isAllowedValue = empty($value) || in_array($value, $values);
       }
       return $isAllowedValue;
    }
}

?>
