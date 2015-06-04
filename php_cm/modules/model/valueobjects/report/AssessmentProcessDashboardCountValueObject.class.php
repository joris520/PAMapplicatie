<?php

/**
 * Description of AssessmentProcessDashboardCountValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class AssessmentProcessDashboardCountValueObject extends BaseReportValueObject
{
    protected $invitedTotal;

    protected $phaseInvited;
    protected $phaseSelectEvaluation;
    protected $phaseEvaluation;

    protected $evaluationNotRequested;
    protected $evaluationPlanned;
    protected $evaluationCancelled;
    protected $evaluationDone;

    protected $evaluationDoneNotRequested;

    // de create kan zonder id, aangeroepen vanuit de collection
    static function create()
    {
        return new AssessmentProcessDashboardCountValueObject(NULL);
    }

    // letop: de construct MET id
    protected function __construct($bossId)
    {
        parent::__construct($bossId);
        $this->invitedTotal                 = 0;

        $this->phaseInvited                 = 0;
        $this->phaseSelectEvaluation        = 0;
        $this->phaseEvaluation              = 0;

        $this->evaluationNotRequested       = 0;
        $this->evaluationPlanned            = 0;
        $this->evaluationCancelled          = 0;
        $this->evaluationDone               = 0;

        $this->evaluationDoneNotRequested   = 0;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInvitedTotal($invitedTotal)
    {
        $this->invitedTotal += $invitedTotal;
    }

    function getInvitedTotal()
    {
        return $this->invitedTotal;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addPhaseInvited($phaseInvited)
    {
        $this->phaseInvited += $phaseInvited;
    }

    function getPhaseInvited()
    {
        return $this->phaseInvited;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addPhaseSelectEvaluation($phaseSelectEvaluation)
    {
        $this->phaseSelectEvaluation += $phaseSelectEvaluation;
    }

    function getPhaseSelectEvaluation()
    {
        return $this->phaseSelectEvaluation;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addPhaseEvaluation($phaseEvaluation)
    {
        $this->phaseEvaluation += $phaseEvaluation;
    }

    function getPhaseEvaluation()
    {
        return $this->phaseEvaluation;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEvaluationNotRequested($evaluationNotRequested)
    {
        $this->evaluationNotRequested += $evaluationNotRequested;
    }

    function getEvaluationNotRequested()
    {
        return $this->evaluationNotRequested;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEvaluationPlanned($evaluationPlanned)
    {
        $this->evaluationPlanned += $evaluationPlanned;
    }

    function getEvaluationPlanned()
    {
        return $this->evaluationPlanned;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEvaluationCancelled($evaluationCancelled)
    {
        $this->evaluationCancelled += $evaluationCancelled;
    }

    function getEvaluationCancelled()
    {
        return $this->evaluationCancelled;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEvaluationDone($evaluationDone)
    {
        $this->evaluationDone += $evaluationDone;
    }

    function getEvaluationDone()
    {
        return $this->evaluationDone;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEvaluationDoneNotRequested($evaluationDoneNotRequested)
    {
        $this->evaluationDoneNotRequested += $evaluationDoneNotRequested;
    }

    function getEvaluationDoneNotRequested()
    {
        return $this->evaluationDoneNotRequested;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEvaluationReady()
    {
        return  $this->evaluationDone +
                $this->evaluationCancelled +
                $this->evaluationDoneNotRequested;
    }

}

?>
