<?php

/**
 * Description of EmployeeTargetStatusValue
 *
 * @author hans.prins
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class EmployeeTargetStatusValue extends BaseDatabaseValue
{
    // mode
    const DATABASE_MODE = 1;
    const REPORT_MODE   = 2;


    const NO_TARGET         = -2;

    const NO_STATUS_EXPIRED = -1;
    const NO_STATUS         =  0;
    const BELOW_TARGET      =  1;
    const ON_TARGET         =  2;
    const ABOVE_TARGET      =  3;

    static function values($mode = self::DATABASE_MODE)
    {
        switch ($mode) {
            case self::REPORT_MODE:
                return array(
                    EmployeeTargetStatusValue::NO_STATUS_EXPIRED,
                    EmployeeTargetStatusValue::NO_STATUS,
                    EmployeeTargetStatusValue::BELOW_TARGET,
                    EmployeeTargetStatusValue::ON_TARGET,
                    EmployeeTargetStatusValue::ABOVE_TARGET
                    );
                break;
            case self::DATABASE_MODE:
            default:
                return array(
                    EmployeeTargetStatusValue::BELOW_TARGET,
                    EmployeeTargetStatusValue::ON_TARGET,
                    EmployeeTargetStatusValue::ABOVE_TARGET
                    );
                break;
        }
        return $values;
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_OPTIONAL);
    }
}

?>
