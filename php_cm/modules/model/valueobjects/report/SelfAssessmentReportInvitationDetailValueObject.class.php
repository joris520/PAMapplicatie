<?php

/**
 * Description of SelfAssessmentReportInvitationDetailValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class SelfAssessmentReportInvitationDetailValueObject extends BaseReportValueObject
{

    private $invitationHash;
    private $employeeName;
    private $invitationDate;
    private $invitationMessageToName;
    private $invitationMessageToEmail;

    private $completedStatus;
    private $completedDateTime;
    private $scoreCount;

    private $sentDateTime;
    private $invitationMessageId;
    private $invitationMessageType;
    private $invitationMessageSubject;
    private $invitationMessageTemplate;
    private $invitationMessageFromName;
    private $invitationMessageFromEmail;

    private $reminder1DateTime;
    private $reminder1MessageToName;
    private $reminder1MessageToEmail;
    private $reminder1MessageId;
    private $reminder1MessageType;
    private $reminder1MessageSubject;
    private $reminder1MessageTemplate;
    private $reminder1MessageFromName;
    private $reminder1MessageFromEmail;

    private $reminder2DateTime;
    private $reminder2MessageToName;
    private $reminder2MessageToEmail;
    private $reminder2MessageId;
    private $reminder2MessageType;
    private $reminder2MessageSubject;
    private $reminder2MessageTemplate;
    private $reminder2MessageFromName;
    private $reminder2MessageFromEmail;

    static function createWithData($reportData)
    {
        return new SelfAssessmentReportInvitationDetailValueObject($reportData);
    }

    protected function __construct($reportData)
    {
        parent::__construct($reportData[SelfAssessmentReportQueries::ID_FIELD]);

        $this->invitationHash               = $reportData['hash_id'];
        $this->employeeName                 = EmployeeNameConverter::displaySortable($reportData['firstname'], $reportData['lastname']);
        $this->invitationDate               = $reportData['invitation_date'];

        $this->completedStatus              = $reportData['completed'];
        $this->completedDateTime            = $reportData['date_sentback'];
        $this->scoreCount                   = $reportData['invitation_score_count'];

        $this->sentDateTime                 = $reportData['senddate'];
        $this->invitationMessageToEmail     = $reportData['email_to'];
        $this->invitationMessageToName      = $reportData['email_to_name'];
        $this->invitationMessageId          = $reportData['ID_TSIM'];
        $this->invitationMessageType        = $reportData['message_type_invitation'];
        $this->invitationMessageSubject     = $reportData['message_subject'];
        $this->invitationMessageTemplate    = $reportData['message_invitation'];
        $this->invitationMessageFromName    = $reportData['email_from'];
        $this->invitationMessageFromEmail   = $reportData['email_name'];

        $this->reminder1DateTime            = $reportData['senddate_reminder1'];
        $this->reminder1MessageToEmail      = $reportData['email_to_reminder1'];
        $this->reminder1MessageToName       = $reportData['email_to_name_reminder1'];
        $this->reminder1MessageId           = $reportData['ID_TSIM1'];
        $this->reminder1MessageType         = $reportData['message_type_reminder1'];
        $this->reminder1MessageSubject      = $reportData['message_subject_reminder1'];
        $this->reminder1MessageTemplate     = $reportData['message_reminder1'];
        $this->reminder1MessageFromName     = $reportData['email_from_reminder1'];
        $this->reminder1MessageFromEmail    = $reportData['email_name_reminder1'];

        $this->reminder2DateTime            = $reportData['senddate_reminder2'];
        $this->reminder2MessageToEmail      = $reportData['email_to_reminder2'];
        $this->reminder2MessageToName       = $reportData['email_to_name_reminder2'];
        $this->reminder2MessageId           = $reportData['ID_TSIM2'];
        $this->reminder2MessageType         = $reportData['message_type_reminder2'];
        $this->reminder2MessageSubject      = $reportData['message_subject_reminder2'];
        $this->reminder2MessageTemplate     = $reportData['message_reminder2'];
        $this->reminder2MessageFromName     = $reportData['email_from_reminder2'];
        $this->reminder2MessageFromEmail    = $reportData['email_name_reminder2'];

    }

    function getInvitationHash()
    {
        return $this->invitationHash;
    }

    function getEmployeeName()
    {
        return $this->employeeName;
    }

    function getInvitationDate()
    {
        return $this->invitationDate;
    }

    function getInvitationMessageToName()
    {
        return $this->invitationMessageToName;
    }

    function getInvitationMessageToEmail()
    {
        return $this->invitationMessageToEmail;
    }

    function getCompletedStatus()
    {
        return $this->completedStatus;
    }

    function isCompleted()
    {
        return AssessmentInvitationCompletedValue::isInvitationCompleted($this->completedStatus);
    }

    function getCompletedDateTime()
    {
        return $this->completedDateTime;
    }

    function getScoreCount()
    {
        return $this->scoreCount;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getSentDateTime()
    {
        return $this->sentDateTime;
    }

    function isSent()
    {
        return !empty($this->sentDateTime);
    }

    function getInvitationMessageId()
    {
        return $this->invitationMessageId;
    }

    function getInvitationMessageType()
    {
        return $this->invitationMessageType;
    }

    function getInvitationMessageSubject()
    {
        return $this->invitationMessageSubject;
    }

    function getInvitationMessageTemplate()
    {
        return $this->invitationMessageTemplate;
    }

    function getInvitationMessageFromName()
    {
        return $this->invitationMessageFromName;
    }

    function getInvitationMessageFromEmail()
    {
        return $this->invitationMessageFromEmail;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function hasReminder1()
    {
        return !empty($this->reminder1MessageId);
    }

    function getReminder1DateTime()
    {
        return $this->reminder1DateTime;
    }

    function isSentReminder1()
    {
        return !empty($this->reminder1DateTime);
    }

    function getReminder1MessageToName()
    {
        return $this->reminder1MessageToName;
    }

    function getReminder1MessageToEmail()
    {
        return $this->reminder1MessageToEmail;
    }

    function getReminder1MessageId()
    {
        return $this->reminder1MessageId;
    }

    function getReminder1MessageType()
    {
        return $this->reminder1MessageType;
    }

    function getReminder1MessageSubject()
    {
        return $this->reminder1MessageSubject;
    }

    function getReminder1MessageTemplate()
    {
        return $this->reminder1MessageTemplate;
    }

    function getReminder1MessageFromName()
    {
        return $this->reminder1MessageFromName;
    }

    function getReminder1MessageFromEmail()
    {
        return $this->reminder1MessageFromEmail;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function hasReminder2()
    {
        return !empty($this->reminder2MessageId);
    }

    function getReminder2DateTime()
    {
        return $this->reminder2DateTime;
    }

    function isSentReminder2()
    {
        return !empty($this->reminder2DateTime);
    }

    function getReminder2MessageToName()
    {
        return $this->reminder2MessageToName;
    }

    function getReminder2MessageToEmail()
    {
        return $this->reminder2MessageToEmail;
    }


    function getReminder2MessageId()
    {
        return $this->reminder2MessageId;
    }

    function getReminder2MessageType()
    {
        return $this->reminder2MessageType;
    }

    function getReminder2MessageSubject()
    {
        return $this->reminder2MessageSubject;
    }

    function getReminder2MessageTemplate()
    {
        return $this->reminder2MessageTemplate;
    }

    function getReminder2MessageFromName()
    {
        return $this->reminder2MessageFromName;
    }

    function getReminder2MessageFromEmail()
    {
        return $this->reminder2MessageFromEmail;
    }
}

?>
