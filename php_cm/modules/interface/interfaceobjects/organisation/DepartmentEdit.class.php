<?php

/**
 * Description of DepartmentEdit
 *
 * @author ben.dokter
 */
class DepartmentEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentEdit.tpl';

    static function createWithValueObject(  DepartmentValueObject $valueObject,
                                            $displayWidth)
    {
        return new DepartmentEdit(  $valueObject,
                                    $displayWidth,
                                    self::TEMPLATE_FILE);
    }
}

?>
