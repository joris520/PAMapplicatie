<?php

/**
 * Description of AssessmentProcessDashboardGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');
require_once('modules/interface/interfaceobjects/report/AssessmentProcessDashboardView.class.php');

class AssessmentProcessDashboardGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/assessmentProcessDashboardGroup.tpl';

    private $totalCountValueObject;
    private $showTotals;

    private $invitedDetailLink;
    private $phaseInvitedDetailLink;
    private $phaseSelectEvaluationLink;
    private $phaseEvaluationLink;

    private $evaluationNotRequestedDetailLink;
    private $evaluationPlannedDetailLink;
    private $evaluationReadyDetailLink;

    static function create( AssessmentProcessDashboardCountValueObject $valueObject,
                            $showTotals,
                            $displayWidth)
    {
        return new AssessmentProcessDashboardGroup( $valueObject,
                                                    $showTotals,
                                                    $displayWidth);
    }

    protected function __construct( AssessmentProcessDashboardCountValueObject $valueObject,
                                    $showTotals,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->totalCountValueObject = $valueObject;
        $this->showTotals = $showTotals;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(AssessmentProcessDashboardView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function showTotals()
    {
        return $this->showTotals;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getInvitedTotal()
    {
        return $this->totalCountValueObject->getInvitedTotal();
    }

    function getPhaseInvitedTotal()
    {
        return $this->totalCountValueObject->getPhaseInvited();
    }

    function getPhaseSelectEvaluationTotal()
    {
        return $this->totalCountValueObject->getPhaseSelectEvaluation();
    }

    function getPhaseEvaluationTotal()
    {
        return $this->totalCountValueObject->getPhaseEvaluation();
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEvaluationNotRequestedTotal()
    {
        return $this->totalCountValueObject->getEvaluationNotRequested();
    }

    function getEvaluationPlannedTotal()
    {
        return $this->totalCountValueObject->getEvaluationPlanned();
    }

    function getEvaluationCancelledTotal()
    {
        return $this->totalCountValueObject->getEvaluationCancelled();
    }

    function getEvaluationDoneTotal()
    {
        return $this->totalCountValueObject->getEvaluationDone();
    }

    function getEvaluationDoneNotRequestedTotal()
    {
        return $this->totalCountValueObject->getEvaluationDoneNotRequested();
    }

    // ff niet zo mooi, maar hier ook de links van de view opnemen
    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitedDetailLink
    function setInvitedDetailLink($invitedDetailLink)
    {
        $this->invitedDetailLink = $invitedDetailLink;
    }

    function getInvitedDetailLink()
    {
        return $this->invitedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $phaseInvitedDetailLink
    function setPhaseInvitedDetailLink($phaseInvitedDetailLink)
    {
        $this->phaseInvitedDetailLink = $phaseInvitedDetailLink;
    }

    function getPhaseInvitedDetailLink()
    {
        return $this->phaseInvitedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //$phaseSelectEvaluationLink;
    function setPhaseSelectEvaluationLink($phaseSelectEvaluationLink)
    {
        $this->phaseSelectEvaluationLink = $phaseSelectEvaluationLink;
    }

    function getPhaseSelectEvaluationLink()
    {
        return $this->phaseSelectEvaluationLink;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $phaseEvaluationLink;
    function setPhaseEvaluationLink($phaseEvaluationLink)
    {
        $this->phaseEvaluationLink = $phaseEvaluationLink;
    }

    function getPhaseEvaluationLink()
    {
        return $this->phaseEvaluationLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationNotRequestedDetailLink;
    function setEvaluationNotRequestedDetailLink($evaluationNotRequestedDetailLink)
    {
        $this->evaluationNotRequestedDetailLink = $evaluationNotRequestedDetailLink;
    }

    function getEvaluationNotRequestedDetailLink()
    {
        return $this->evaluationNotRequestedDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationPlannedDetailLink;
    function setEvaluationPlannedDetailLink($evaluationPlannedDetailLink)
    {
        $this->evaluationPlannedDetailLink = $evaluationPlannedDetailLink;
    }

    function getEvaluationPlannedDetailLink()
    {
        return $this->evaluationPlannedDetailLink;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationReadyDetailLink;
    function setEvaluationReadyDetailLink($evaluationReadyDetailLink)
    {
        $this->evaluationReadyDetailLink = $evaluationReadyDetailLink;
    }

    function getEvaluationReadyDetailLink()
    {
        return $this->evaluationReadyDetailLink;
    }

}

?>
