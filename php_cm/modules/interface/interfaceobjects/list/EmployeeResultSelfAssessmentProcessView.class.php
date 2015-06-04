<?php

/**
 * Description of EmployeeResultSelfAssessmentProcessView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/list/EmployeeResultView.class.php');

class EmployeeResultSelfAssessmentProcessView extends EmployeeResultView
{

    const TEMPLATE_FILE = 'list/resultViewDetail/assessmentProcess/employeeResultSelfAssessmentProcessView.tpl';

    private $managerIconView;
    private $employeeIconView;
    private $title;

    private $state;

    static function create( $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth)
    {
        return new EmployeeResultSelfAssessmentProcessView( $employeeId,
                                                            $employeeName,
                                                            $employeeNameHtmlId,
                                                            $displayWidth,
                                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setManagerIconView(AssessmentIconView $managerIconView)
    {
        $this->managerIconView = $managerIconView;
    }

    function getManagerIconView()
    {
        return $this->managerIconView;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeIconView(AssessmentIconView $employeeIconView)
    {
        $this->employeeIconView = $employeeIconView;
    }

    function getEmployeeIconView()
    {
        return $this->employeeIconView;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTitle($title)
    {
        $this->title = $title;
    }

    function getTitle()
    {
        return $this->title;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // for debugging
    function setStates($scoreStatus, $isInvited, $completedStatus, $selfAssessmentState)
    {
        $this->scoreStatus          = $scoreStatus;
        $this->isInvited            = $isInvited;
        $this->completedStatus      = $completedStatus;
        $this->state  = $selfAssessmentState;
    }

    function getStatesInfo()
    {
        return $this->state . ':'. ScoreSelfAssessmentState::debugInfo($this->state) . '- ' .
               $this->scoreStatus . ':' . ScoreStatusConverter::display($this->scoreStatus) . '- ' .
               ($this->isInvited ? 'invited': 'not_invited'). '- ' .
               $this->completedStatus . ' >';
    }

}


?>