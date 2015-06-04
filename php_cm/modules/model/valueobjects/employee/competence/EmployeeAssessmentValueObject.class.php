<?php

/**
 * Description of EmployeeAssessmentValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeAssessmentValueObject extends BaseEmployeeValueObject
{
    private $assessmentDate;
    private $scoreStatus;
    private $assessmentNote;


    // factory method
    static function createWithData( $employeeId,
                                    $assessmentData)
    {
        return new EmployeeAssessmentValueObject($employeeId, $assessmentData[EmployeeAssessmentQueries::ID_FIELD], $assessmentData);
    }

    static function createWithValues(   $employeeId,
                                        $assessmentDate,
                                        $scoreStatus,
                                        $assessmentNote)
    {
        $assessmentData = array();
        $assessmentData['assessment_date']  = $assessmentDate;
        $assessmentData['score_status']     = $scoreStatus;
        $assessmentData['assessment_note']  = $assessmentNote;

        return new EmployeeAssessmentValueObject($employeeId, NULL, $assessmentData);
    }

    function __construct($employeeId, $employeeAssessmentId, $assessmentData)
    {
        parent::__construct($employeeId,
                            $employeeAssessmentId,
                            $assessmentData['saved_by_user_id'],
                            $assessmentData['saved_by_user'],
                            $assessmentData['saved_datetime']);

        $this->assessmentDate   = $assessmentData['assessment_date'];
        $this->scoreStatus      = $assessmentData['score_status'];
        $this->assessmentNote   = $assessmentData['assessment_note'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function hasAssessment()
    {
        return !empty($this->assessmentDate) && !empty($this->scoreStatus);
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
    // $scoreStatus
    function setScoreStatus($scoreStatus)
    {
        $this->scoreStatus = $scoreStatus;
    }

    function getScoreStatus()
    {
        return $this->scoreStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentNote
    function setAssessmentNote($assessmentNote)
    {
        $this->assessmentNote = $assessmentNote;
    }

    function getAssessmentNote()
    {
        return $this->assessmentNote;
    }

}

?>
