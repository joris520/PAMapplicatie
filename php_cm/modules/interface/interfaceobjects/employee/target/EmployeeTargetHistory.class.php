<?php

/**
 * Description of EmployeeTargetHistory
 *
 * @author hans.prins
 */
require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeTargetHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/target/employeeTargetHistory.tpl';

    private $isViewAllowedEvaluation;

    static function create($displayWidth)
    {
        return new EmployeeTargetHistory(   $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    function addValueObject(EmployeeTargetValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
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
