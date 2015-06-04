<?php

/*
 * Description of AssessmentCycleSafeFormProcessor
 *
 * @author hans.prins
 */

require_once('modules/model/service/library/AssessmentCycleController.class.php');

class AssessmentCycleSafeFormProcessor
{

    static function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_ASSESSMENT_CYCLE)) {

            $cycleName = $safeFormHandler->retrieveInputValue('cycle_name');
            $startDate = $safeFormHandler->retrieveDateValue('start_date');

            $valueObject = AssessmentCycleValueObject::createWithValues(NULL,
                                                                        $cycleName,
                                                                        $startDate);

            list($hasError, $messages, $assessmentCycleId) = AssessmentCycleController::processAdd($valueObject);
            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                AssessmentCycleInterfaceProcessor::finishAdd($objResponse, $assessmentCycleId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_CYCLE)) {

            $assessmentCycleId = $safeFormHandler->retrieveSafeValue('assessmentCycleId');

            $cycleName = $safeFormHandler->retrieveInputValue('cycle_name');
            $startDate = $safeFormHandler->retrieveDateValue('start_date');

            $valueObject = AssessmentCycleValueObject::createWithValues($assessmentCycleId,
                                                                        $cycleName,
                                                                        $startDate);

            list($hasError, $messages) = AssessmentCycleController::processEdit($assessmentCycleId,
                                                                                $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                AssessmentCycleInterfaceProcessor::finishEdit($objResponse, $assessmentCycleId);
            }
        }
        return array($hasError, $messages);
    }

    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        
        if (PermissionsService::isDeleteAllowed(PERMISSION_ASSESSMENT_CYCLE)) {

            $assessmentCycleId = $safeFormHandler->retrieveSafeValue('assessmentCycleId');

            list($hasError, $messages) = AssessmentCycleController::processRemove($assessmentCycleId);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                AssessmentCycleInterfaceProcessor::finishRemove($objResponse, $assessmentCycleId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
