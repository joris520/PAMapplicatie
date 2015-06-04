<?php

/**
 * Description of EmployeeAssessmentProcessValueObject
 *
 * @author ben.dokter
 */

class EmployeeAssessmentProcessValueObject extends BaseEmployeeValueObject
{
    private $assessmentDate;
    private $assessmentProcessStatus;
    private $scoreSum;
    private $scoreRank;
    private $evaluationRequestStatus;
    private $invitationHashId;

    // factory method
    static function createWithData($employeeId, $assessmentProcessData)
    {
        return new EmployeeAssessmentProcessValueObject($employeeId,
                                                        $assessmentProcessData[EmployeeAssessmentProcessQueries::ID_FIELD],
                                                        $assessmentProcessData);
    }

    static function createWithEmployeeData($assessmentProcessData)
    {
        return new EmployeeAssessmentProcessValueObject($assessmentProcessData[EmployeeAssessmentProcessQueries::ID_EMPLOYEE_FIELD],
                                                        $assessmentProcessData[EmployeeAssessmentProcessQueries::ID_FIELD],
                                                        $assessmentProcessData);
    }

    static function createWithValues(   $employeeId,
                                        $assessmentDate,
                                        $assessmentProcessStatus,
                                        $scoreSum,
                                        $scoreRank,
                                        $evaluationRequestStatus,
                                        $invitationHashId)
    {
        $assessmentProcessData = array();
        $assessmentProcessData['assessment_date']           = $assessmentDate;
        $assessmentProcessData['assessment_process_status'] = $assessmentProcessStatus;
        $assessmentProcessData['score_sum']                 = $scoreSum;
        $assessmentProcessData['score_rank']                = $scoreRank;
        $assessmentProcessData['evaluation_request_status'] = $evaluationRequestStatus;
        $assessmentProcessData['invitation_hash_id']        = $invitationHashId;

        return new EmployeeAssessmentValueObject($employeeId, NULL, $assessmentProcessData);
    }


    function __construct($employeeId, $assessmentProcessId, $assessmentProcessData)
    {
        parent::__construct($employeeId,
                            $assessmentProcessId,
                            $assessmentProcessData['saved_by_user_id'],
                            $assessmentProcessData['saved_by_user'],
                            $assessmentProcessData['saved_datetime']);


        $this->assessmentDate           = $assessmentProcessData['assessment_date'];
        $this->assessmentProcessStatus  = $assessmentProcessData['assessment_process_status'];
        $this->scoreSum                 = $assessmentProcessData['score_sum'];
        $this->scoreRank                = $assessmentProcessData['score_rank'];
        $this->evaluationRequestStatus  = $assessmentProcessData['evaluation_request_status'];
        $this->invitationHashId         = $assessmentProcessData['invitation_hash_id'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentDate
    function setAssessmentDate($assessmentDate)
    {
        $this->assessmentDate = $assessmentDate;
    }

    function getAssessmentDate()
    {
        return $this->assessmentDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentProcessStatus
    function setAssessmentProcessStatus($assessmentProcessStatus)
    {
        $this->assessmentProcessStatus = $assessmentProcessStatus;
    }

    function getAssessmentProcessStatus()
    {
        return $this->assessmentProcessStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $scoreSum
    function setScoreSum($scoreSum)
    {
        $this->scoreSum = $scoreSum;
    }

    function getScoreSum()
    {
        return $this->scoreSum;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $scoreRank
    function setScoreRank($scoreRank)
    {
        $this->scoreRank = $scoreRank;
    }

    function getScoreRank()
    {
        return $this->scoreRank;
    }

    function hasScoreRank()
    {
        return in_array($this->scoreRank, AssessmentProcessScoreRankingValue::values());
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationRequestStatus
    function setEvaluationRequestStatus($evaluationRequestStatus)
    {
        $this->evaluationRequestStatus = $evaluationRequestStatus;
    }

    function getEvaluationRequestStatus()
    {
        return $this->evaluationRequestStatus;
    }

    function isEvaluationRequested()
    {
        return $this->evaluationRequestStatus == AssessmentProcessEvaluationRequestValue::REQUESTED;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitationHashId
    function setInvitationHashId($invitationHashId)
    {
        $this->invitationHashId = $invitationHashId;
    }

    function getInvitationHashId()
    {
        return $this->invitationHashId;
    }

    function hasInvitationHashId()
    {
        return !empty($this->invitationHashId);
    }


}

?>
