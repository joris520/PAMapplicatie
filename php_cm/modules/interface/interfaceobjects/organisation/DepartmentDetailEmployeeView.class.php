<?php

/**
 * Description of DepartmentDetailEmployeeView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class DepartmentDetailEmployeeView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentDetailEmployeeView.tpl';

    static function createWithValueObject(  EmployeeProfileOrganisationValueObject $valueObject,
                                            $displayWidth)
    {
        return new DepartmentDetailEmployeeView($valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }
}

?>
