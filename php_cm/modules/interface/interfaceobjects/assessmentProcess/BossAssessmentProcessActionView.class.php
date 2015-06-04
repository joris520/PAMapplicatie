<?php

/**
 * Description of BossAssessmentProcessActionView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BossAssessmentProcessActionView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'assessmentProcess/bossAssessmentProcessActionView.tpl';

    private $isActionAllowed;

    private $actionMessage;

    // buttons
    private $actionButton;
    private $undoButton;

    //private $markSelfAssessmentDoneAction;

    static function create($displayWidth)
    {
        return new BossAssessmentProcessActionView( $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsActionAllowed($isActionAllowed)
    {
        $this->isActionAllowed = $isActionAllowed;
    }

    function isActionAllowed()
    {
        return $this->isActionAllowed;
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setActionMessage($actionMessage)
    {
        $this->actionMessage = $actionMessage;
    }

    function getActionMessage()
    {
        return $this->actionMessage;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAction($actionButton)
    {
        $this->actionButton = $actionButton;
    }

    function getAction()
    {
        return $this->actionButton;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setUndo($undoButton)
    {
        $this->undoButton = $undoButton;
    }

    function getUndo()
    {
        return $this->undoButton;
    }

}

?>
