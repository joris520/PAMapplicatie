<?php

/**
 * Description of EmployeeContractStateConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

require_once('modules/model/value/employee/profile/EmployeeContractStateValue.class.php');

class EmployeeContractStateConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case EmployeeContractStateValue::PERMANENT:
                $display = TXT_UCF('CS_PERMANENT');
                break;
            case EmployeeContractStateValue::FIXED:
                $display = TXT_UCF('CS_FIXED');
                break;
            case EmployeeContractStateValue::STAFFING:
                $display = TXT_UCF('CS_STAFFING');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }}

?>
