<?php

/**
 * Description of EmployeeAnswerGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeAnswerGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAnswerGroup.tpl';

    static function create($displayWidth)
    {
        return new EmployeeAnswerGroup( $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeAnswerView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
