<?php

/**
 * Description of SelfAssessmentReportInvitationValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class SelfAssessmentReportInvitationValueObject extends BaseReportValueObject
{

    private $invitationHash;
    private $employeeName;
    private $invitationDate;

    private $sentDateTime;

    private $completedStatus;
    private $completedDateTime;

    private $reminder1DateTime;
    private $reminder2DateTime;

    static function createWithData($reportData)
    {
        return new SelfAssessmentReportInvitationValueObject($reportData);
    }

    protected function __construct($reportData)
    {
        parent::__construct($reportData[SelfAssessmentReportQueries::ID_FIELD]);

        $this->invitationHash       = $reportData['hash_id'];
        $this->employeeName         = EmployeeNameConverter::displaySortable($reportData['firstname'], $reportData['lastname']);
        $this->invitationDate       = $reportData['invitation_date'];
        $this->sentDateTime         = $reportData['senddate'];
        $this->completedStatus      = $reportData['completed'];
        $this->completedDateTime    = $reportData['date_sentback'];
        $this->reminder1DateTime    = $reportData['senddate_reminder1'];
        $this->reminder2DateTime    = $reportData['senddate_reminder2'];
    }


    function getInvitationHash()
    {
        return $this->invitationHash;
    }

    function getEmployeeName()
    {
        return $this->employeeName;
    }

    function getDateInvited()
    {
        return $this->invitationDate;
    }

    function getDateTimeSent()
    {
        return $this->sentDateTime;
    }

    function isSent()
    {
        return !empty($this->sentDateTime);
    }

    function getCompletedStatus()
    {
        return $this->completedStatus;
    }

    function getDateTimeCompleted()
    {
        return $this->completedDateTime;
    }

    function getDateTimeReminder1()
    {
        return $this->reminder1DateTime;
    }

    function hasReminder1()
    {
        return !empty($this->reminder1DateTime);
    }

    function getDateTimeReminder2()
    {
        return $this->reminder2DateTime;
    }

    function hasReminder2()
    {
        return !empty($this->reminder2DateTime);
    }


}

?>
