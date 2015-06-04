<?php

/**
 * Description of EmployeeAnswerValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeeAnswerValueObject extends BaseEmployeeValueObject
{
    private $questionId;
    private $answeredQuestion;
    private $answer;

    // hulpje, de question uit AssessmentQuestion
    private $assessmentQuestion;

    // factory method
    static function createWithData( $employeeId,
                                    $questionId,
                                    $employeeAnswerData)
    {
        return new EmployeeAnswerValueObject($employeeId, $questionId, $employeeAnswerData[EmployeeAnswerQueries::ID_FIELD], $employeeAnswerData);
    }

    static function createWithValues(   $employeeId,
                                        $questionId,
                                        $question,
                                        $employeeQuestionAnswer)
    {
        $employeeAnswerData = array();
        $employeeAnswerData['question']         = $question;
        $employeeAnswerData['answer']           = $employeeQuestionAnswer;

        return new EmployeeAnswerValueObject($employeeId, $questionId, NULL, $employeeAnswerData);
    }

    function __construct($employeeId, $questionId, $employeeAnswerId, $employeeAnswerData)
    {
        parent::__construct($employeeId,
                            $employeeAnswerId,
                            $employeeAnswerData['saved_by_user_id'],
                            $employeeAnswerData['saved_by_user'],
                            $employeeAnswerData['saved_datetime']);

        $this->questionId       = $questionId;
        $this->answeredQuestion = $employeeAnswerData['question'];
        $this->answer           = $employeeAnswerData['answer'];
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $questionId
    function setQuestionId($questionId)
    {
        $this->questionId = $questionId;
    }

    function getQuestionId()
    {
        return $this->questionId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $answeredQuestion
    function setAnsweredQuestion($answeredQuestion)
    {
        $this->answeredQuestion = $answeredQuestion;
    }

    function getAnsweredQuestion()
    {
        return $this->answeredQuestion;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $answer
    function setAnswer($answer)
    {
        $this->answer = $answer;
    }

    function getAnswer()
    {
        return $this->answer;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $assessmentQuestion
    function setAssessmentQuestion($assessmentQuestion)
    {
        $this->assessmentQuestion = $assessmentQuestion;
    }

    function getAssessmentQuestion()
    {
        return $this->assessmentQuestion;
    }

}

?>
