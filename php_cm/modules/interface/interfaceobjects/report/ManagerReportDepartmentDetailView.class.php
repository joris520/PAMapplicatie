<?php

/**
 * Description of ManagerReportDepartmentDetailView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class ManagerReportDepartmentDetailView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/managerReportDepartmentDetailView.tpl';

    static function createWithValueObject(  DepartmentValueObject $valueObject,
                                            $displayWidth)
    {
        return new ManagerReportDepartmentDetailView(   $valueObject,
                                                        $displayWidth,
                                                        self::TEMPLATE_FILE);
    }
}

?>
