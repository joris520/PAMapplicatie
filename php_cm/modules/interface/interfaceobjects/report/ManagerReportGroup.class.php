<?php

/**
 * Description of ManagerReportGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class ManagerReportGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/managerReportGroup.tpl';

    static function create($displayWidth)
    {
        return new ManagerReportGroup(  $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(ManagerReportView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }
}

?>
