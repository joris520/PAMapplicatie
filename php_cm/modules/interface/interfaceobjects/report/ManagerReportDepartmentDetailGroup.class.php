<?php

/**
 * Description of ManagerReportDepartmentDetailGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class ManagerReportDepartmentDetailGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/managerReportDepartmentDetailGroup.tpl';

    static function create($displayWidth)
    {
        return new ManagerReportDepartmentDetailGroup(  $displayWidth,
                                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(ManagerReportDepartmentDetailView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }
}

?>
