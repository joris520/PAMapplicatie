<?php

/**
 * Description of DepartmentDetailUserView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class DepartmentDetailUserView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentDetailUserView.tpl';

    static function createWithValueObject(  UserValueObject $valueObject,
                                            $displayWidth)
    {
        return new DepartmentDetailUserView($valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }
}

?>
