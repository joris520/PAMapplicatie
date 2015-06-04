<?php

/**
 * Description of EmployeeSelfAssessmentBatchValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/batch//BaseBatchValueObject.class.php');

class EmployeeSelfAssessmentBatchValueObject extends BaseBatchValueObject
{

    private $invitationMessageId;

    private $invitedList;
    private $remindedList;
    private $notRemindedList;
    private $noEmailList;
    private $noCompetenceList;

    static function create($invitationMessageId)
    {
        return new EmployeeSelfAssessmentBatchValueObject($invitationMessageId);
    }

    protected function __construct($invitationMessageId)
    {
        parent::__construct();
        $this->invitationMessageId  = $invitationMessageId;

        $this->invitedList          = array();
        $this->remindedList         = array();
        $this->notRemindedList      = array();
        $this->noEmailList          = array();
        $this->noCompetenceList     = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitationMessageId
    function getInvitationMessageId()
    {
        return $this->invitationMessageId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInvitationResult(EmployeeInvitationResultValueObject $invitationResult)
    {
        switch ($invitationResult->getInvitationStatus()) {
            case InvitationStatusValue::INVITED:
            case InvitationStatusValue::REINVITED:
                $this->invitedList[] = $invitationResult;
                break;

            case InvitationStatusValue::REMINDED_1:
            case InvitationStatusValue::REMINDED_2:
                $this->remindedList[] = $invitationResult;
                break;

            case InvitationStatusValue::NOT_REMINDED:
                $this->notRemindedList[] = $invitationResult;
                break;

            case InvitationStatusValue::INVALID_EMAIL_ADDRESS:
                $this->noEmailList[] = $invitationResult;
                break;

            case InvitationStatusValue::NO_COMPETENCES:
                $this->noCompetenceList[] = $invitationResult;
                break;
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $sendCount
    function getSendCount()
    {
        return count($this->invitedList);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $remindedList Count
    function getRemindedCount()
    {
        return count($this->remindedList);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $notRemindedList Count
    function getNotRemindedCount()
    {
        return count($this->notRemindedList);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $notSendCount
    function getNotSendCount()
    {
        return count($this->noEmailList) + count($this->noCompetenceList);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitedList
    function getInvitedList()
    {
        return $this->invitedList;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $notRemindedList
    function getNotRemindedList()
    {
        return $this->notRemindedList;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $remindedList
    function getRemindedList()
    {
        return $this->remindedList;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $noEmailList
    function getNoEmailList()
    {
        return $this->noEmailList;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $noCompetenceList
    function getNoCompetenceList()
    {
        return $this->noCompetenceList;
    }

}

?>
