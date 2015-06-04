<?php

/**
 * Description of EmployeeCompetenceDetailPrintOptionValueObject
 *
 * @author hans.prins
 */

require_once('modules/print/valueobjects/BaseDetailPrintOptionValueObject.class.php');

class EmployeeCompetenceDetailPrintOptionValueObject extends BaseDetailPrintOptionValueObject
{
    private $showRemarks;
    private $show360;
    private $showPdpAction;

    static function create()
    {
        return new EmployeeCompetenceDetailPrintOptionValueObject();
    }

    protected function __construct()
    {
        parent::__construct();
        $this->showRemarks      = BooleanValue::FALSE;
        $this->show360          = BooleanValue::FALSE;
        $this->showPdpAction    = BooleanValue::FALSE;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowRemarks($showRemarks)
    {
        $this->showRemarks = $showRemarks;
    }

    function getShowRemarks()
    {
        return $this->showRemarks;
    }

    function showRemarks()
    {
        return $this->showRemarks == BooleanValue::TRUE;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShow360($show360)
    {
        $this->show360 = $show360;
    }

    function getShow360()
    {
        return $this->show360;
    }

    function show360()
    {
        return $this->show360 == BooleanValue::TRUE;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowPdpAction($showPdpAction)
    {
        $this->showPdpAction = $showPdpAction;
    }

    function getShowPdpAction()
    {
        return $this->showPdpAction;
    }

    function showPdpAction()
    {
        return $this->showPdpAction == BooleanValue::TRUE;
    }
}

?>
