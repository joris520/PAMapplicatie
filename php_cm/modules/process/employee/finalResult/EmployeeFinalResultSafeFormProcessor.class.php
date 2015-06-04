<?php

/**
 * Description of EmployeeFinalResultSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/finalResult/EmployeeFinalResultController.class.php');

class EmployeeFinalResultSafeFormProcessor {

    function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {

            $employeeId   = $safeFormHandler->retrieveSafeValue('employeeId');
            $assessmentDate        = $safeFormHandler->retrieveDateValue('assessment_date'); // een al geconverteerde databasedate
            $totalScore            = $safeFormHandler->retrieveInputValue('total_score');
            $totalScoreComment     = $safeFormHandler->retrieveInputValue('total_score_comment');

            if (EmployeeFinalResultService::isAllowedDetailScores()) {
                $behaviourScore        = $safeFormHandler->retrieveInputValue('behaviour_score');
                $behaviourScoreComment = $safeFormHandler->retrieveInputValue('behaviour_score_comment');
                $resultsScore          = $safeFormHandler->retrieveInputValue('results_score');
                $resultsScoreComment   = $safeFormHandler->retrieveInputValue('results_score_comment');
            }

            $valueObject = EmployeeFinalResultValueObject::createWithValues( $employeeId,
                                                                            NULL,
                                                                            $totalScore,
                                                                            $totalScoreComment,
                                                                            $behaviourScore,
                                                                            $behaviourScoreComment,
                                                                            $resultsScore,
                                                                            $resultsScoreComment,
                                                                            $assessmentDate);

            list($hasError, $messages) = EmployeeFinalResultController::processEdit($employeeId,
                                                                                    $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeFinalResultInterfaceProcessor::finishEdit(  $objResponse,
                                                                    $employeeId);
            }
        }
        return array($hasError, $messages);
    }

}

?>