<?php

/**
 * Description of EmployeeEducationLevelConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

require_once('modules/model/value/employee/profile/EmployeeEducationLevelValue.class.php');

class EmployeeEducationLevelConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeEducationLevelValue::LBO:
                $display = TXT_UCF('EDL_LBO');
                break;
            case EmployeeEducationLevelValue::MBO:
                $display = TXT_UCF('EDL_MBO');
                break;
            case EmployeeEducationLevelValue::HBO:
                $display = TXT_UCF('EDL_HBO');
                break;
            case EmployeeEducationLevelValue::WO:
                $display = TXT_UCF('EDL_WO');
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
