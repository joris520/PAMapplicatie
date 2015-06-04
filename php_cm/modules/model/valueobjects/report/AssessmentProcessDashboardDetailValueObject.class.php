<?php

/**
 * Description of AssessmentProcessDashboardDetailValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');
require_once('modules/model/queries/report/AssessmentProcessReportQueries.class.php');

class AssessmentProcessDashboardDetailValueObject extends BaseReportValueObject
{
    private $employeeName;

    //EmployeeAssessmentProcessValueObject;
    private $assessmentDate;
    private $assessmentProcessStatus;
    private $scoreSum;
    private $scoreRank;
    private $evaluationRequestStatus;
    // EmployeeAssessmentEvaluationValueObject;
    var $assessmentEvaluationDate;
    var $assessmentEvaluationStatus;

    static function createWithData($assesmentProcessReportData)
    {
        return new AssessmentProcessDashboardDetailValueObject( $assesmentProcessReportData[AssessmentProcessReportQueries::ID_FIELD],
                                                                $assesmentProcessReportData);
    }


    protected function __construct($employeeId, $assesmentProcessReportData)
    {
        parent::__construct($employeeId);
        $this->employeeName                 = EmployeeNameConverter::displaySortable($assesmentProcessReportData['firstname'], $assesmentProcessReportData['lastname']);

        // EmployeeAssessmentProcessValueObject
        $this->assessmentDate               = $assesmentProcessReportData['assessment_date'];
        $this->assessmentProcessStatus      = $assesmentProcessReportData['assessment_process_status'];
        $this->scoreSum                     = $assesmentProcessReportData['score_sum'];
        $this->scoreRank                    = $assesmentProcessReportData['score_rank'];
        $this->evaluationRequestStatus      =  $assesmentProcessReportData['evaluation_request_status'];
        // EmployeeAssessmentEvaluationValueObject
        $this->assessmentEvaluationDate     = $assesmentProcessReportData['assessment_evaluation_date'];
        $this->assessmentEvaluationStatus   = $assesmentProcessReportData['assessment_evaluation_status'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeName()
    {
        return $this->employeeName;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentDate
    function getAssessmentDate()
    {
        return $this->assessmentDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentProcessStatus
    function getAssessmentProcessStatus()
    {
        return $this->assessmentProcessStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $scoreSum
    function getScoreSum()
    {
        return $this->scoreSum;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $scoreRank
    function getScoreRank()
    {
        return $this->scoreRank;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $evaluationRequestStatus
    function getEvaluationRequestStatus()
    {
        return $this->evaluationRequestStatus;
    }

    function isEvaluationRequested()
    {
        return $this->evaluationRequestStatus == AssessmentProcessEvaluationRequestValue::REQUESTED;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentEvaluationDate
    function getAssessmentEvaluationDate()
    {
        return $this->assessmentEvaluationDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentEvaluationStatus
    function getAssessmentEvaluationStatus()
    {
        return $this->assessmentEvaluationStatus;
    }

}

?>
