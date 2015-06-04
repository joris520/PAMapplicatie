<?php

/**
 * Description of OperatorValue
 *
 * @author hans.prins
 */

require_once('application/model/value/BaseValue.class.php');
require_once('modules/model/value/library/competence/ScaleValue.class.php');

class OperatorValue extends BaseValue
{
    //
    const OPERATOR_GREATER_THAN_OR_EQUALS = 1;
    const OPERATOR_EQUALS                 = 2;
    const OPERATOR_LESS_THAN_OR_EQUALS    = 3;


    static function values($scaleValue = ScaleValue::SCALE_1_5)
    {
        $values = array();
        switch($scaleValue) {
            case ScaleValue::SCALE_Y_N:
                $values = array(
                    OperatorValue::OPERATOR_EQUALS
                );
                break;
            case ScaleValue::SCALE_1_5:
                $values = array(
                    OperatorValue::OPERATOR_GREATER_THAN_OR_EQUALS,
                    OperatorValue::OPERATOR_EQUALS,
                    OperatorValue::OPERATOR_LESS_THAN_OR_EQUALS
                );
                break;
        }
        return $values;
    }


    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
