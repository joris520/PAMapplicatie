<?php

/**
 * Description of QuestionSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/QuestionController.class.php');

class QuestionSafeFormProcessor
{

    function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_QUESTIONS_LIBRARY)) {

            $newQuestionId = null;
            $question      = $safeFormHandler->retrieveInputValue('question');
            $sortOrder     = $safeFormHandler->retrieveInputValue('sort_order');

            $valueObject = QuestionValueObject::createWithValues(   $newQuestionId,
                                                                    $question,
                                                                    $sortOrder);

            list($hasError, $messages, $newQuestionId) = QuestionController::processAdd($valueObject);
            if (!$hasError) {
                // klaar met add
                $safeFormHandler->finalizeSafeFormProcess();
                QuestionInterfaceProcessor::finishAdd($objResponse, $newQuestionId);
            }
        }
        return array($hasError, $messages);
    }

    function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_QUESTIONS_LIBRARY)) {

            $questionId = $safeFormHandler->retrieveSafeValue('questionId');

            $question  = $safeFormHandler->retrieveInputValue('question');
            $sortOrder = $safeFormHandler->retrieveInputValue('sort_order');

            $valueObject = QuestionValueObject::createWithValues(   $questionId,
                                                                    $question,
                                                                    $sortOrder);

            list($hasError, $messages) = QuestionController::processEdit($questionId, $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                QuestionInterfaceProcessor::finishEdit($objResponse, $questionId);
            }
        }
        return array($hasError, $messages);
    }

    function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_QUESTIONS_LIBRARY)) {

            $questionId = $safeFormHandler->retrieveSafeValue('questionId');

            list($hasError, $messages) = QuestionController::processRemove($questionId);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                QuestionInterfaceProcessor::finishRemove($objResponse, $questionId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
