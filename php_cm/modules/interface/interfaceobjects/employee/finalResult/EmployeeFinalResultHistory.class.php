<?php

/**
 * Description of EmployeeFinalResultHistory
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseHistoryInterfaceObject.class.php');

class EmployeeFinalResultHistory extends BaseHistoryInterfaceObject
{
    const TEMPLATE_FILE = 'employee/finalResult/employeeFinalResultHistory.tpl';

    private $showRemarks;
    private $showDetailScores;

    static function create($displayWidth)
    {
        return new EmployeeFinalResultHistory(  $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    function addValueObject(EmployeeFinalResultValueObject $valueObject)
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowDetailScores($showDetailScores)
    {
        $this->showDetailScores = $showDetailScores;
    }

    function showDetailScores()
    {
        return $this->showDetailScores;
    }

}

?>
