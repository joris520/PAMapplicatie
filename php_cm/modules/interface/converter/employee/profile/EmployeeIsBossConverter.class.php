<?php

/**
 * Description of EmployeeIsBossConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/BooleanConverter.class.php');
require_once('application/model/value/BooleanValue.class.php');

class EmployeeIsBossConverter extends BooleanConverter
{

    static function description($value, $employeeCount)
    {
        if ($value == BooleanValue::TRUE) {
            $employeeCountLabel = $employeeCount > 0 ? $employeeCount : TXT_LC('NONE');
            $description .= '(' . TXT_UCF('EMPLOYEES') . ': ' . $employeeCountLabel . ')';
        }

        return $description;
    }

}

?>
