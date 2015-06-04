<?php

/**
 * Description of QuestionController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/QuestionService.class.php');

class QuestionController
{
    static function processAdd(QuestionValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = QuestionService::validate($valueObject);
        if (!$hasError) {
            $newQuestionId = QuestionService::addValidated($valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $newQuestionId);
    }

    static function processEdit($questionId,
                                QuestionValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = QuestionService::validate($valueObject);
        if (!$hasError) {
            QuestionService::updateValidated($questionId, $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processRemove($questionId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        QuestionService::remove($questionId);

        BaseQueries::finishTransaction();

        return array($hasError, $messages);
    }
}

?>
