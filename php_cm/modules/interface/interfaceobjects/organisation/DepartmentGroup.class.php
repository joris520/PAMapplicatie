<?php

/**
 * Description of DepartmentGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class DepartmentGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentGroup.tpl';

    static function create($displayWidth)
    {
        return new DepartmentGroup( $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(DepartmentView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
