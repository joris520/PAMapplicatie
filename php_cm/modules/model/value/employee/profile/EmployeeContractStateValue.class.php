<?php

/**
 * Description of EmployeeContractStateValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseValue.class.php');

class EmployeeContractStateValue extends BaseValue
{
    const NONE      = 0;
    const PERMANENT = 1;
    const FIXED     = 2;
    const STAFFING  = 3;

    static function values()
    {
        return array(
            EmployeeContractStateValue::PERMANENT,
            EmployeeContractStateValue::FIXED,
            EmployeeContractStateValue::STAFFING
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_OPTIONAL);
    }
}

?>
