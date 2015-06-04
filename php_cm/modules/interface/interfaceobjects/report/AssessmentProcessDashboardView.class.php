<?php

/**
 * Description of AssessmentProcessDashboardView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

require_once('modules/model/valueobjects/report/AssessmentProcessDashboardValueObject.class.php');

class AssessmentProcessDashboardView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/assessmentProcessDashboardView.tpl';

    private $invitedDetailLink;
    private $phaseInvitedDetailLink;
    private $phaseSelectEvaluationLink;
    private $phaseEvaluationLink;

    private $evaluationNotRequestedDetailLink;
    private $evaluationPlannedDetailLink;
    private $evaluationReadyDetailLink;


    static function createWithValueObject(  AssessmentProcessDashboardValueObject $valueObject,
                                            $displayWidth)
    {
        return new AssessmentProcessDashboardView(  $valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }


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
