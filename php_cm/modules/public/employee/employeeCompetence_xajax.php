<?php

require_once('modules/process/employee/competence/EmployeeCompetenceInterfaceProcessor.class.php');

function public_employeeCompetence__displayPage($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayView($objResponse, $employeeId, NULL);
    }
    return $objResponse;
}

function public_employeeCompetence__displayHistoryScore($employeeId, $competenceId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayHistoryScore($objResponse, $employeeId, $competenceId);
    }
    return $objResponse;
}

function public_employeeCompetence__editBulkScores($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayEditBulkScore($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeCompetence__editClusterScores($employeeId, $clusterId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayEditClusterScore($objResponse, $employeeId, $clusterId);
    }
    return $objResponse;
}

function public_employeeCompetence__editScoreCallback()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        // verder niets, alleen bedoeld om de sessie alive te houden
    }
    return $objResponse;
}

function public_employeeCompetence__editAssessmentQuestionsAnswer($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayEditAnswer($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeCompetence__displayHistoryQuestionAnswer($employeeId, $questionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayHistoryAnswer($objResponse, $employeeId, $questionId);
    }
    return $objResponse;
}

function public_employeeCompetence__addAssessment($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayAddAssessment($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeCompetence__editAssessment($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayEditAssessment($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeCompetence__displayHistoryAssessment($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayHistoryAssessment($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeCompetence__resendSelfAssessmentInvitation($employeeId, $hashId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayResendSelfAssessmentInvitation($objResponse, $employeeId, $hashId);
    }
    return $objResponse;
}

function public_employeeCompetence__addAssessmentEvaluation($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayAddAssessmentEvaluation($objResponse, $employeeId);
    }
    return $objResponse;
}

function public_employeeCompetence__editAssessmentEvaluation($employeeId, $assessmentEvaluationId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayEditAssessmentEvaluation($objResponse, $employeeId, $assessmentEvaluationId);
    }
    return $objResponse;
}

function public_employeeCompetence__cancelEditAssessmentEvaluation($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::cancelEditAssessmentEvaluation($objResponse, $employeeId);
    }
    return $objResponse;
}



function public_employeeCompetence__removeAssessmentEvaluation($employeeId, $assessmentEvaluationId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayRemoveAssessmentEvaluation($objResponse, $employeeId, $assessmentEvaluationId);
    }
    return $objResponse;
}

function public_employeeCompetence__displayHistoryAssessmentEvaluation($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayHistoryAssessmentEvaluation($objResponse, $employeeId);
    }
    return $objResponse;
}


function public_employeeCompetence__editJobProfile($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayEditJobProfile($objResponse, $employeeId);
    }
    return $objResponse;
}


function public_employeeCompetence__displayHistoryJobProfile($employeeId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeeCompetenceInterfaceProcessor::displayHistoryJobProfile($objResponse, $employeeId);
    }
    return $objResponse;
}

?>
