<?php

/**
 * Description of EmployeeAssessmentEvaluationValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeAssessmentEvaluationValueObject extends BaseEmployeeValueObject
{
    // pas op, deze worden private. gebruik accessors
    private $isActive;
    private $assessmentEvaluationDate;
    private $assessmentEvaluationStatus;
    private $attachmentId;


    // hulpje voor history scherm
    private $attachmentLink;


    // factory method
    static function createWithData( $employeeId,
                                    $assessmentEvaluationData)
    {
        return new EmployeeAssessmentEvaluationValueObject( $employeeId,
                                                            $assessmentEvaluationData[EmployeeAssessmentEvaluationQueries::ID_FIELD],
                                                            $assessmentEvaluationData);
    }

    static function createWithValues(   $employeeId,
                                        $assessmentEvaluationDate,
                                        $assessmentEvaluationStatus,
                                        $attachmentId)
    {
        $assessmentEvaluationData = array();
        $assessmentEvaluationData['assessment_evaluation_date']             = $assessmentEvaluationDate;
        $assessmentEvaluationData['assessment_evaluation_status']           = $assessmentEvaluationStatus;
        $assessmentEvaluationData['ID_EDOC']    = $attachmentId;

        return new EmployeeAssessmentEvaluationValueObject($employeeId, NULL, $assessmentEvaluationData);
    }

    function __construct(   $employeeId,
                            $employeeAssessmentEvaluationId,
                            $assessmentEvaluationData)
    {
        parent::__construct($employeeId,
                            $employeeAssessmentEvaluationId,
                            $assessmentEvaluationData['saved_by_user_id'],
                            $assessmentEvaluationData['saved_by_user'],
                            $assessmentEvaluationData['saved_datetime']);

        $this->isActive                     = $assessmentEvaluationData['active'] == BaseDatabaseValue::IS_ACTIVE;
        $this->assessmentEvaluationDate     = $assessmentEvaluationData['assessment_evaluation_date'];
        $this->assessmentEvaluationStatus   = $assessmentEvaluationData['assessment_evaluation_status'];
        $this->attachmentId                 = $assessmentEvaluationData['ID_EDOC'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsActive($isActive)
    {
        $this->isActive = $isActive;
    }

    function getIsActive()
    {
        return $this->isActive;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentEvaluationDate($assessmentEvaluationDate)
    {
        $this->assessmentEvaluationDate = $assessmentEvaluationDate;
    }

    function getAssessmentEvaluationDate()
    {
        return $this->assessmentEvaluationDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentEvaluationStatus($assessmentEvaluationStatus)
    {
        $this->assessmentEvaluationStatus = $assessmentEvaluationStatus;
    }

    function getAssessmentEvaluationStatus()
    {
        return $this->assessmentEvaluationStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAttachmentId($attachmentId)
    {
        $this->attachmentId = $attachmentId;
    }

    function getAttachmentId()
    {
        return $this->attachmentId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAttachmentLink($attachmentLink)
    {
        $this->attachmentLink = $attachmentLink;
    }

    function getAttachmentLink()
    {
        return $this->attachmentLink;
    }


}
?>
