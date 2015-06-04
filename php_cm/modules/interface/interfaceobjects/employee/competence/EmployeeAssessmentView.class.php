<?php

/**
 * Description of EmployeeAssessmentView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeAssessmentView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeAssessmentView.tpl';

    private $invitationValueObject;

    private $isViewAllowedScoreStatus;

    // eventuele zelfevaluatie
    private $showSelfAssessment;
    private $selfAssessmentState;
    private $resendInvitationLink;
    private $showCompletedStatus;
    private $completedStatus;
    private $showAssessmentNote;

    static function createWithValueObject(  EmployeeAssessmentValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeAssessmentView(  $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInvitationValueObject($invitationValueObject)
    {
        $this->invitationValueObject = $invitationValueObject;
    }

    function getInvitationValueObject()
    {
        return $this->invitationValueObject;
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

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSelfAssessmentState($selfAssessmentState)
    {
        $this->selfAssessmentState = $selfAssessmentState;
    }

    function getSelfAssessmentState()
    {
        return $this->selfAssessmentState;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowSelfAssessment($showSelfAssessment)
    {
        $this->showSelfAssessment = $showSelfAssessment;
    }

    function showSelfAssessment()
    {
        return $this->showSelfAssessment;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowCompletedStatus($showCompletedStatus)
    {
        $this->showCompletedStatus = $showCompletedStatus;
    }

    function showCompletedStatus()
    {
        return $this->showCompletedStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCompletedStatus($completedStatus)
    {
        $this->completedStatus = $completedStatus;
    }

    function getCompletedStatus()
    {
        return $this->completedStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setResendInvitationLink($resendInvitationLink)
    {
        $this->resendInvitationLink = $resendInvitationLink;
        $this->addActionLink($resendInvitationLink);
    }

    function getResendInvitationLink()
    {
        return $this->resendInvitationLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowAssessmentNote($showAssessmentNote)
    {
        $this->showAssessmentNote = $showAssessmentNote;
    }

    function showAssessmentNote()
    {
        return $this->showAssessmentNote;
    }

}

?>
