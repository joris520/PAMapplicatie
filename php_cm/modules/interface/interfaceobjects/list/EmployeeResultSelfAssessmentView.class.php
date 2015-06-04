<?php

/**
 * Description of EmployeeResultSelfAssessmentView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/list/EmployeeResultView.class.php');

class EmployeeResultSelfAssessmentView extends EmployeeResultView
{

    const TEMPLATE_FILE = 'list/resultViewDetail/employeeResultSelfAssessmentView.tpl';

    private $managerIconView;
    private $employeeIconView;

    private $state;

    static function create( $employeeId,
                            $employeeName,
                            $employeeNameHtmlId,
                            $displayWidth)
    {
        return new EmployeeResultSelfAssessmentView($employeeId,
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
    // (for debugging)
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