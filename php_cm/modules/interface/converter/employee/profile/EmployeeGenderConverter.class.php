<?php

/**
 * Description of EmployeeGenderConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/model/value/employee/profile/EmployeeGenderValue.class.php');

class EmployeeGenderConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeGenderValue::MALE:
                $display = TXT_UCF('MALE');
                break;
            case EmployeeGenderValue::FEMALE:
                $display = TXT_UCF('FEMALE');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

}

?>
