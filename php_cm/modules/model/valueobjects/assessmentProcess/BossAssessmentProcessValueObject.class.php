<?php

/**
 * Description of BossAssessmentProcessValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class BossAssessmentProcessValueObject extends BaseEmployeeValueObject
{
    private $assessmentDate;
    private $assessmentProcessStatus;

    // factory method
    static function createWithData($bossId, $assessmentProcessData)
    {
        return new BossAssessmentProcessValueObject(    $bossId,
                                                        $assessmentProcessData[BossAssessmentProcessQueries::ID_FIELD],
                                                        $assessmentProcessData);
    }

    static function createWithValues(   $bossId,
                                        $assessmentDate,
                                        $assessmentProcessStatus)
    {
        $assessmentProcessData = array();
        $assessmentProcessData['assessment_date']           = $assessmentDate;
        $assessmentProcessData['assessment_process_status'] = $assessmentProcessStatus;


        return new BossAssessmentProcessValueObject($bossId, NULL, $assessmentProcessData);
    }


    function __construct($bossId, $assessmentProcessId, $assessmentProcessData)
    {
        parent::__construct($bossId,
                            $assessmentProcessId,
                            $assessmentProcessData['saved_by_user_id'],
                            $assessmentProcessData['saved_by_user'],
                            $assessmentProcessData['saved_datetime']);


        $this->assessmentDate           = $assessmentProcessData['assessment_date'];
        $this->assessmentProcessStatus  = $assessmentProcessData['assessment_process_status'];
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

}

?>
