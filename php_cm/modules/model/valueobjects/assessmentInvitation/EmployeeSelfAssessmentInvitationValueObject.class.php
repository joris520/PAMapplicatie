<?php

/**
 * Description of EmployeeSelfAssessmentInvitationValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeSelfAssessmentInvitationValueObject extends BaseEmployeeValueObject
{
    private $hashId;
    private $completed;

    // invitation
    private $invitationDateTime; // database format
    private $sendDateTime; // database format

    private $processStatus;
    private $somDiffScore;

    // factory method
    static function createWithData($employeeId, $invitationData)
    {
        return new EmployeeSelfAssessmentInvitationValueObject( $employeeId,
                                                                $invitationData[EmployeeSelfAssessmentInvitationQueries::ID_FIELD],
                                                                $invitationData);
    }

    static function createWithEmployeeData($invitationData)
    {
        return new EmployeeSelfAssessmentInvitationValueObject( $invitationData[EmployeeSelfAssessmentInvitationQueries::ID_EMPLOYEE_FIELD],
                                                                $invitationData[EmployeeSelfAssessmentInvitationQueries::ID_FIELD],
                                                                $invitationData);
    }


    function __construct($employeeId, $hashId, $invitationData)
    {
        parent::__construct($employeeId,
                            $hashId,
                            $invitationData['saved_by_user_id'],
                            $invitationData['modified_by_user'],
                            $invitationData['modified_datetime']);

        // threesixty_invitations
        $this->hashId               = $invitationData['hash_id'];
        $this->invitationDateTime   = $invitationData['invitation_date'];
        $this->sendDateTime         = $invitationData['senddate'];
        $this->completed            = $invitationData['completed'];
        $this->processStatus        = $invitationData['threesixty_scores_status'];
        $this->somDiffScore         = $invitationData['threesixty_score_diff_sum'];
    }

    function isInvited()
    {
        return !empty($this->hashId);
    }

    function getHashId()
    {
        return $this->hashId;
    }

    function getCompleted()
    {
        return $this->completed;
    }

    function getProcessStatus()
    {
        return $this->processStatus;
    }

    function getSomDiffScore()
    {
        return $this->somDiffScore;
    }

    function getInvitationDateTime()
    {
        return $this->invitationDateTime;
    }

    function getSendDateTime()
    {
        return $this->sendDateTime;
    }

    function isSent()
    {
        return !empty($this->sendDateTime);
    }



}

?>
