<?php

/**
 * Description of EmployeeAssessmentHistory
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeAssessmentHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentHistory.tpl';

    private $isViewAllowedScoreStatus;

    static function create($displayWidth)
    {
        return new EmployeeAssessmentHistory(   $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    function addValueObject(EmployeeAssessmentValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsViewAllowedScoreStatus($isViewAllowedScoreStatus)
    {
        $this->isViewAllowedScoreStatus = $isViewAllowedScoreStatus;
    }

    function isViewAllowedScoreStatus()
    {
        return $this->isViewAllowedScoreStatus;
    }


}

?>
