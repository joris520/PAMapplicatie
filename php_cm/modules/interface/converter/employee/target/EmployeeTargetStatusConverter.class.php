<?php

/**
 * Description of EmployeeTargetStatusConverter
 *
 * @author hans.prins
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/model/value/employee/target/EmployeeTargetStatusValue.class.php');


class EmployeeTargetStatusConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeTargetStatusValue::NO_STATUS_EXPIRED:
                $display = TXT_UCF('STATUS_EMPTY_TARGET_EXPIRED');
                break;
            case EmployeeTargetStatusValue::NO_STATUS:
                $display = TXT_UCF('STATUS_EMPTY_TARGET');
                break;
            case EmployeeTargetStatusValue::BELOW_TARGET:
                $display = TXT_UCF('BELOW_TARGET');
                break;
            case EmployeeTargetStatusValue::ON_TARGET:
                $display = TXT_UCF('ON_TARGET');
                break;
            case EmployeeTargetStatusValue::ABOVE_TARGET:
                $display = TXT_UCF('ABOVE_TARGET');
                break;
        }
        return $display;
    }

    static function imageSrc($value)
    {
        $imageSrc   = 'dot_white.gif';

        switch($value) {
            case EmployeeTargetStatusValue::BELOW_TARGET:
                $imageSrc = 'dot_red.gif';
                break;
            case EmployeeTargetStatusValue::ON_TARGET:
                $imageSrc = 'dot_green.gif';
                break;
            case EmployeeTargetStatusValue::ABOVE_TARGET:
                $imageSrc = 'dot_yellow.gif';
                break;
        }

        return $imageSrc;
    }

    static function image($value)
    {
        $imageTitle = self::display($value, TXT_UCF('STATUS_EMPTY_TARGET'));
        $imageSrc   = self::imageSrc($value);

        return $image = '<img src="images/' . $imageSrc . '" title="' . $imageTitle . '">';
    }


    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

}

?>