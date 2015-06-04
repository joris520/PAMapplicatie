<?php

/**
 * Description of EmployeeFinalResultValueObject
 * tabel: employee_assessment_final_result
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeFinalResultValueObject extends BaseEmployeeValueObject
{
    private $assessmentDate; // database format

    private $totalScore;
    private $totalScoreComment;
    private $behaviourScore;
    private $behaviourScoreComment;
    private $resultsScore;
    private $resultsScoreComment;


    /**
     * Deze functie neemt een array met data (formaat van de database tabel)
     * @param type $employeeId
     * @param type $finalResultData
     * @return \EmployeeFinalResultValueObject
     */
    static function createWithData($employeeId, $finalResultData)
    {
        return new EmployeeFinalResultValueObject($employeeId, $finalResultData[EmployeeFinalResultQueries::ID_FIELD], $finalResultData);
    }

    /**
     * Deze functie maakt van de losse values een valueObject
     */
    static function createWithValues($employeeId,
                                     $finalResultId,
                                     $totalScore,
                                     $totalScoreComment,
                                     $behaviourScore,
                                     $behaviourScoreComment,
                                     $resultsScore,
                                     $resultsScoreComment,
                                     $assessmentDate)
    {
        $finalResultData = array();

        $finalResultData[EmployeeFinalResultQueries::ID_FIELD] = $finalResultId;
        $finalResultData['assessment_date']          = $assessmentDate;

        $finalResultData['total_score']              = $totalScore;
        $finalResultData['total_score_comment']     = $totalScoreComment;
        $finalResultData['behaviour_score']          = $behaviourScore;
        $finalResultData['behaviour_score_comment']  = $behaviourScoreComment;
        $finalResultData['results_score']            = $resultsScore;
        $finalResultData['results_score_comment']    = $resultsScoreComment;

        return new EmployeeFinalResultValueObject(  $employeeId,
                                                    $finalResultId,
                                                    $finalResultData);
    }

    /**
     * constructor
     * $finalResultData is een array zoals met mysql_fetch_assoc() uit de database komt
     * de array indexen zijn de database velden
     * @param type $employeeId
     * @param type $finalResultId
     * @param type $finalResultData
     */
    protected function __construct( $employeeId,
                                    $finalResultId,
                                    $finalResultData)
    {
        parent::__construct($employeeId,
                            $finalResultId,
                            $finalResultData['saved_by_user_id'],
                            $finalResultData['saved_by_user'],
                            $finalResultData['saved_datetime']);

        $this->assessmentDate        = $finalResultData['assessment_date'];

        $this->totalScore            = $finalResultData['total_score'];
        $this->totalScoreComment     = $finalResultData['total_score_comment'];
        $this->behaviourScore        = $finalResultData['behaviour_score'];
        $this->behaviourScoreComment = $finalResultData['behaviour_score_comment'];
        $this->resultsScore          = $finalResultData['results_score'];
        $this->resultsScoreComment   = $finalResultData['results_score_comment'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setAssessmentDate($assessmentDate)
    {
        $this->assessmentDate = $assessmentDate;
    }

    function getAssessmentDate()
    {
        return $this->assessmentDate;
    }

    function hasAssessmentDate()
    {
        return !empty($this->assessmentDate);
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalScore($totalScore)
    {
        $this->totalScore = $totalScore;
    }

    function getTotalScore()
    {
        return $this->totalScore;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalScoreComment($totalScoreComment)
    {
        $this->totalScoreComment = $totalScoreComment;
    }

    function getTotalScoreComment()
    {
        return $this->totalScoreComment;
    }

    function hasTotalScoreComment()
    {
        return !empty($this->totalScoreComment);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBehaviourScore($behaviourScore)
    {
        $this->behaviourScore = $behaviourScore;
    }

    function getBehaviourScore()
    {
        return $this->behaviourScore;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setBehaviourScoreComment($behaviourScoreComment)
    {
        $this->behaviourScoreComment = $behaviourScoreComment;
    }

    function getBehaviourScoreComment()
    {
        return $this->behaviourScoreComment;
    }

    function hasBehaviourScoreComment()
    {
        return !empty($this->behaviourScoreComment);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setResultsScore($resultsScore)
    {
        $this->resultsScore = $resultsScore;
    }

    function getResultsScore()
    {
        return $this->resultsScore;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setResultsScoreComment($resultsScoreComment)
    {
        $this->resultsScoreComment = $resultsScoreComment;
    }

    function getResultsScoreComment()
    {
        return $this->resultsScoreComment;
    }

    function hasResultsScoreComment()
    {
        return !empty($this->resultsScoreComment);
    }

}

?>
