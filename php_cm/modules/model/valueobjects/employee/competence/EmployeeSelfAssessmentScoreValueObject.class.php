<?php

/**
 * Description of EmployeeSelfAssessmentScoreValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeSelfAssessmentScoreValueObject  extends BaseEmployeeValueObject
{
    // pas op, deze worden private. gebruik accessors
    var $competenceId;
    var $score; // 360 score
    var $scoreDiff;
    var $note;
    var $completedDateTime; // database format
    var $evaluatorName;
    var $evaluatorEmail;
    var $hashId;
    // invitation
    var $invitationDateTime; // database format
    var $sendDateTime; // database format
    var $completed;

    // factory method
    static function createWithData($employeeId, $competenceId, $employeeSelfScoreData)
    {
        return new EmployeeSelfAssessmentScoreValueObject(  $employeeId,
                                                            $competenceId,
                                                            $employeeSelfScoreData[EmployeeSelfAssessmentScoreQueries::ID_FIELD],
                                                            $employeeSelfScoreData);
    }


    function __construct($employeeId, $competenceId, $employeeScoreId, $employeeSelfScoreData)
    {
        parent::__construct($employeeId,
                            $employeeScoreId,
                            $employeeSelfScoreData['saved_by_user_id'],
                            $employeeSelfScoreData['modified_by_user'],
                            $employeeSelfScoreData['modified_datetime']);

        $this->competenceId             = $competenceId;

        $this->hashId               = $employeeSelfScoreData['hash_id'];
        $this->evaluatorName        = $employeeSelfScoreData['evaluator'];
        $this->evaluatorEmail       = $employeeSelfScoreData['evaluator_email'];
        $this->score                = $employeeSelfScoreData['threesixty_score'];
        $this->scoreDiff            = $employeeSelfScoreData['threesixty_score_diff'];
        $this->note                 = $employeeSelfScoreData['notes'];
        $this->completedDateTime    = $employeeSelfScoreData['date_sentback'];
        // threesixty_invitations
        $this->invitationDateTime   = $employeeSelfScoreData['invitation_date'];
        $this->sendDateTime         = $employeeSelfScoreData['senddate'];
        $this->completed            = $employeeSelfScoreData['completed'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $competenceId
    function getCompetenceId()
    {
        return $this->competenceId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $score
    function getScore()
    {
        return $this->score;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $scoreDiff
    function getScoreDiff()
    {
        return $this->scoreDiff;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $note
    function getNote()
    {
        return $this->note;
    }

    function hasNote()
    {
        return !empty($this->note);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $completedDateTime
    function getCompletedDateTime()
    {
        return $this->completedDateTime;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluatorName
    function getEvaluatorName()
    {
        return $this->evaluatorName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluatorEmail
    function getEvaluatorEmail()
    {
        return $this->evaluatorEmail;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $hashId
    function getHashId()
    {
        return $this->hashId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitationDateTime
    function getInvitationDateTime()
    {
        return $this->invitationDateTime;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $sendDateTime
    function getSendDateTime()
    {
        return $this->sendDateTime;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isCompleted
    function getCompleted()
    {
        return $this->completed;
    }

    function isCompleted()
    {
        return $this->completed == AssessmentInvitationCompletedValue::COMPLETED;
    }

}

?>
