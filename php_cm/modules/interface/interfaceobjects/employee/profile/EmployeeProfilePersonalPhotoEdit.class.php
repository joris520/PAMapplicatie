<?php

/**
 * Description of EmployeeProfilePersonalPhotoEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfilePersonalPhotoEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfilePersonalPhotoEdit.tpl';

    static function createWithValueObject(  EmployeeProfilePersonalValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfilePersonalPhotoEdit($valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

}

?>
