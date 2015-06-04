<?php

/**
 * Description of EmployeeTargetAdd
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/employee/target/EmployeeTargetEdit.class.php');

class EmployeeTargetAdd extends EmployeeTargetEdit
{
    const TEMPLATE_FILE = 'employee/target/employeeTargetAdd.tpl';


    static function createWithValueObject(  EmployeeTargetValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeTargetAdd(   $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

}
?>
