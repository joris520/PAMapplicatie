<?php
/**
 * Description of DepartmentDetailEmployeeGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/organisation/DepartmentDetailEmployeeView.class.php');

class DepartmentDetailEmployeeGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentDetailEmployeeGroup.tpl';

    static function create($displayWidth)
    {
        return new DepartmentDetailEmployeeGroup(   $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(DepartmentDetailEmployeeView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
