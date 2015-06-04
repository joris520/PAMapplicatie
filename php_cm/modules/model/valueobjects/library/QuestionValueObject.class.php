<?php

/**
 * Description of QuestionValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class QuestionValueObject extends BaseValueObject
{
    private $question;
    private $sortOrder;
    private $isActive;

    /**
     * Deze functie neemt een array met data (formaat van de database tabel)
     * @param type $assessmentQuestionData
     * @return \QuestionValueObject
     */
    static function createWithData($questionData)
    {
        return new QuestionValueObject($questionData[QuestionQueries::ID_FIELD], $questionData);
    }

    /**
     * Deze functie maakt van de losse values een valueObject
     * @param type $questionId
     * @param type $question
     * @param type $sortOrder
     * @return \QuestionValueObject
     */
    static function createWithValues(   $questionId,
                                        $question,
                                        $sortOrder)
    {
        $questionData = array();

        $questionData[QuestionQueries::ID_FIELD]      = $questionId;
        $questionData['question']   = $question;
        $questionData['sort_order'] = $sortOrder;
        $questionData['is_active']  = ASSESSMENT_QUESTION_IS_ACTIVE;

        return new QuestionValueObject($questionId, $questionData);
    }

    protected function __construct($questionId, $questionData)
    {
        parent::__construct($questionId,
                            $questionData['saved_by_user_id'],
                            $questionData['saved_by_user'],
                            $questionData['saved_datetime']);

        $this->question     = $questionData['question'];
        $this->sortOrder    = $questionData['sort_order'];
        $this->isActive     = ($questionData['is_active'] == ASSESSMENT_QUESTION_IS_ACTIVE);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getQuestion()
    {
        return $this->question;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSortOrder($sortOrder)
    {
        $this->sortOrder = $sortOrder;
    }

    function getSortOrder()
    {
        return $this->sortOrder;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getIsActive()
    {
        return $this->isActive;
    }

}

?>
