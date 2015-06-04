<?php

require_once('gino/MysqlUtils.class.php');
require_once('modules/model/queries/to_refactor/ScoreQuestionsQueries.class.php');


class ScoreQuestionsService {

    static function getMiscQuestions($active_only = false)
    {

        $questions_result = ScoreQuestionsQueries::getScoreQuestions($active_only);
        $questions_array = MysqlUtils::result2Array2D($questions_result);

        return $questions_array;
    }


//    static function getMiscAnswers($employee_id)
//    {
//        $answers_result = ScoreQuestionsQueries::getScoreAnswers($employee_id);
//        $answers_array = MysqlUtils::result2IndexedArray2D($answers_result, 'ID_MQ');
//
//        return $answers_array;
//    }

    static function getQuestionsAndAnswers($employee_id)
    {
        $questions = array();

        $questions_result = ScoreQuestionsQueries::getQuestionsAndAnswers($employee_id);
        while ($question = @mysql_fetch_assoc($questions_result)) {
            $questions[] = $question;
        }

        return $questions;
    }

    static function getQuestionAnswer($employee_id, $question_id)
    {
        //TODO: controle answer_id?
        return @mysql_fetch_assoc(ScoreQuestionsQueries::getQuestionAnswer($employee_id, $question_id));
    }

    static function validateAndUpdateQuestionAnswer($employee_id, $question_id, $answer_id, $answer_value)
    {
        $hasError = false;
        $message = '';

        // TODO: controle op bestaande question_id?
//        if (empty($score)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_ENTER_AN_EVALUATION');
//        }
        if (!$hasError) {
            if (empty($answer_id)) {
                $answer_id = ScoreQuestionsQueries::insertQuestionAnswer($employee_id, $question_id, $answer_value);
            } else {
                ScoreQuestionsQueries::updateQuestionAnswer($employee_id, $question_id, $answer_id, $answer_value);
            }
        }
        return array($hasError, $message, $answer_id);

    }
}
?>
