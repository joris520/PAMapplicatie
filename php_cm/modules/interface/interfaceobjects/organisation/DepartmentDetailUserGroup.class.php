<?php
/**
 * Description of DepartmentDetailUserGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class DepartmentDetailUserGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentDetailUserGroup.tpl';

    static function create($displayWidth)
    {
        return new DepartmentDetailUserGroup(   $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(DepartmentDetailUserView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
