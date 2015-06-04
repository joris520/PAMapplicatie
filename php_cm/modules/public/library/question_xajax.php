<?php

require_once('modules/process/library/QuestionInterfaceProcessor.class.php');

function public_library__displayQuestions() {

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        QuestionInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

function public_library__addQuestion()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        QuestionInterfaceProcessor::displayAdd($objResponse);
    }
    return $objResponse;
}

function public_library__editQuestion($questionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        QuestionInterfaceProcessor::displayEdit($objResponse, $questionId);
    }
    return $objResponse;
}

function public_library__removeQuestion($questionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        QuestionInterfaceProcessor::displayRemove($objResponse, $questionId);
    }
    return $objResponse;
}

?>
