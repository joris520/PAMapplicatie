<?php

/**
 * Description of EmployeeAnswerGroupEdit
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeAnswerGroupEdit extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAnswerGroupEdit.tpl';

    static function create($displayWidth)
    {
        return new EmployeeAnswerGroupEdit( $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(EmployeeAnswerEdit $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
