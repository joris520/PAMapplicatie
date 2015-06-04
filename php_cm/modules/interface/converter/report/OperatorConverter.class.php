<?php

/**
 * Description of OperatorConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class OperatorConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case OperatorValue::OPERATOR_GREATER_THAN_OR_EQUALS:
                $display = '>=';
                break;
            case OperatorValue::OPERATOR_EQUALS:
                $display= '=';
                break;
            case OperatorValue::OPERATOR_LESS_THAN_OR_EQUALS:
                $display = '<=';
                break;
        }
        return $display;
    }

    static function sql($value, $empty = '')
    {
        return self::display($value, $empty);
    }

    // input voor html component is gewoon de waarde
    static function input($value, $empty = '-')
    {
        $input = $empty;

        switch($value) {
            case OperatorValue::OPERATOR_GREATER_THAN_OR_EQUALS:
            case OperatorValue::OPERATOR_EQUALS:
            case OperatorValue::OPERATOR_LESS_THAN_OR_EQUALS:
                $input = $value;
                break;
        }
        return $input;
    }

}

?>
