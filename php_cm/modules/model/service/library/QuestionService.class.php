<?php

/**
 * Description of QuestionService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/library/QuestionValueObject.class.php');
require_once('modules/model/queries/library/QuestionQueries.class.php');

class QuestionService {

    const SHOW_ACTIVE = true;
    const SHOW_ALL = false;

    static function getValueObjects($active_only = self::SHOW_ACTIVE)
    {
        $valueObjects = array();

        //$assessmentQuestions = self::getAssessmentQuestions($active_only);
       $query = QuestionQueries::getQuestions($active_only);
       while ($questionData = mysql_fetch_assoc($query)) {;
            $valueObjects[] = QuestionValueObject::createWithData($questionData);
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    static function getValueObjectById($questionId)
    {
        $valueObject = NULL;

        $query = QuestionQueries::selectQuestion($questionId);
        $assessmentQuestionData = @mysql_fetch_assoc($query);
        $valueObject = QuestionValueObject::createWithData($assessmentQuestionData);

        return $valueObject;
    }


    static function validate(QuestionValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $sortOrder = $valueObject->getSortOrder();
        if (empty($sortOrder)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_SEQUENCE_NUMBER');
        }

        $question = $valueObject->getQuestion();
        if (empty($question)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_AN_ASSESSMENT_QUESTION');
        }

        return array($hasError, $messages);
    }

    static function addValidated(QuestionValueObject $valueObject)
    {
        return QuestionQueries::insertQuestion($valueObject->getQuestion(),
                                               $valueObject->getSortOrder());

    }

    static function updateValidated($questionId,
                                    QuestionValueObject $valueObject)
    {
        return QuestionQueries::updateQuestion( $questionId,
                                                $valueObject->getQuestion(),
                                                $valueObject->getSortOrder());
    }

    static function remove($questionId)
    {
        $usageCounterQuery = QuestionQueries::countQuestionUsage($questionId);
        $usageCounter = mysql_fetch_assoc($usageCounterQuery);
        mysql_free_result($usageCounterQuery);

        if ($usageCounter['counted'] > 0) {
            QuestionQueries::deactivateQuestion($questionId);
        } else {
            QuestionQueries::deleteQuestion($questionId);
        }
    }

}

?>
