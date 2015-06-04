<?php

/**
 * Description of EmployeeCompetenceScoreHistory
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeCompetenceScoreHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceScoreHistory.tpl';

    private $showRemarks;

    static function create($displayWidth)
    {
        return new EmployeeCompetenceScoreHistory(  $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function scoreDisplay($score)
    {
        return CompetenceConversion::scoreDisplay($score);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addValueObject(EmployeeScoreValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowRemarks($showRemarks)
    {
        $this->showRemarks = $showRemarks;
    }

    function showRemarks()
    {
        return $this->showRemarks;
    }

}

?>
