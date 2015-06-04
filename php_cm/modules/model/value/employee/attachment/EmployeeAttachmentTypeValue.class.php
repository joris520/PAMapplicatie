<?php

/**
 * Description of EmployeeAttachmentTypeValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseDatabaseValue.class.php');

class EmployeeAttachmentTypeValue extends BaseDatabaseValue
{
    const NORMAL                = 1;
    const ASSESSMENT_EVALUATION = 2;

    static function values()
    {
        return array(
            EmployeeAttachmentTypeValue::NORMAL,
            EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}
?>
