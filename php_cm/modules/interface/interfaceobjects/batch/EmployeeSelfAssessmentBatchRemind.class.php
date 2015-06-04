<?php

/**
 * Description of EmployeeSelfAssessmentBatchRemind
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeSelfAssessmentBatchRemind extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'batch/employeeSelfAssessmentBatchRemind.tpl';

    private $cycleDetailHtml;
    private $subject;
    private $message;
    private $invitedCount       = 0; // bij gebrek aan constructor
    private $sentCount          = 0;
    private $notCompletedCount  = 0;
    private $needsReminder      = false;

    private $invitedDetailLink;
    private $notCompletedDetailLink;

    static function create( AssessmentCycleValueObject $assessmentCycle,
                            $displayWidth)
    {
        return new EmployeeSelfAssessmentBatchRemind(   $assessmentCycle,
                                                        $displayWidth,
                                                        self::TEMPLATE_FILE);
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCycleDetailHtml($cycleDetailHtml)
    {
        $this->cycleDetailHtml = $cycleDetailHtml;
    }

    function getCycleDetailHtml()
    {
        return $this->cycleDetailHtml;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSubject($subject)
    {
        $this->subject = $subject;
    }

    function getSubject()
    {
        return $this->subject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setMessage($message)
    {
        $this->message = $message;
    }

    function getMessage()
    {
        return $this->message;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInvitedCount($invitedCount)
    {
        $this->invitedCount = $invitedCount;
    }

    function getInvitedCount()
    {
        return $this->invitedCount;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSentCount($sentCount)
    {
        $this->sentCount = $sentCount;
    }

    function getSentCount()
    {
        return $this->sentCount;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setNotCompletedCount($notCompletedCount)
    {
        $this->notCompletedCount = $notCompletedCount;
    }

    function getNotCompletedCount()
    {
        return $this->notCompletedCount;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setNeedsReminder($needsReminder)
    {
        $this->needsReminder = $needsReminder;
    }

    function needsReminder()
    {
        return $this->needsReminder;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInvitedDetailLink($invitedDetailLink)
    {
        $this->invitedDetailLink = $invitedDetailLink;
    }

    function getInvitedDetailLink()
    {
        return $this->invitedDetailLink;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setNotCompletedDetailLink($notCompletedDetailLink)
    {
        $this->notCompletedDetailLink = $notCompletedDetailLink;
    }

    function getNotCompletedDetailLink()
    {
        return $this->notCompletedDetailLink;
    }

}

?>
