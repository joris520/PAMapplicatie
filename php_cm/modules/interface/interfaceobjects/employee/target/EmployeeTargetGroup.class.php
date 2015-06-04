<?php

/**
 * Description of EmployeeTargetGroup
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeTargetGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/target/employeeTargetGroup.tpl';

    private $isViewAllowedEvaluation;

    static function create( $displayWidth)
    {
        return new EmployeeTargetGroup( $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(EmployeeTargetView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsViewAllowedEvaluation($isViewAllowedEvaluation)
    {
        $this->isViewAllowedEvaluation = $isViewAllowedEvaluation;
    }

    function isViewAllowedEvaluation()
    {
        return $this->isViewAllowedEvaluation;
    }
}

?>