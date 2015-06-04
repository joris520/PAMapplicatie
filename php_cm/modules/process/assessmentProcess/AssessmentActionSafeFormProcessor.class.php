<?php

/**
 * Description of AssessmentActionSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/state/AssessmentProcessActionButton.class.php');

require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/assessmentProcess/AssessmentProcessController.class.php');
require_once('modules/model/service/assessmentProcess/BossAssessmentProcessService.class.php');
require_once('modules/model/service/employee/assessmentAction/EmployeeAssessmentProcessService.class.php');

require_once('modules/process/assessmentProcess/AssessmentActionInterfaceProcessor.class.php');

class AssessmentActionSafeFormProcessor
{

    function processActionRequest($objResponse, $safeActionHandler, $buttonId)
    {
        $hasError = true;
        $messages = array();

        if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
            $hasError = false;
            $action = AssessmentProcessActionButton::getActionForButton($buttonId);
            $bossId   = $safeActionHandler->retrieveSafeValue('bossId');

            AssessmentActionInterfaceProcessor::displayVerifyAction($objResponse, $bossId, $action);
        }
        return array($hasError, $messages);
    }

    function processAction($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {

            $bossId   = $safeFormHandler->retrieveSafeValue('bossId');
            $action   = $safeFormHandler->retrieveSafeValue('action');
            $assessmentCycle = AssessmentCycleService::getCurrentValueObject();
            $hasError = false;
            BaseQueries::startTransaction();

            list($hasError, $messages, $resultValueObject) = AssessmentProcessController::processAction($bossId, $action, $assessmentCycle);
//            switch($action) {
//                case AssessmentProcessBossActionValue::MARK_SELFASSESSMENT_DONE:
//                    if (PermissionsService::isExecuteAllowed(PERMISSION_ASSESSMENT_PROCESS_MARK_ASSESSMENT_DONE)){
//                        BossAssessmentProcessService::markSelfassessmentDone($bossId);
//                    }
//                    break;
//                default:
//                    $hasError = true;
//                    $messages[] = TXT_UCF('INVALID_ACTION').$buttonId;
//            }
            if (!$hasError) {
                BaseQueries::finishTransaction();

                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                AssessmentActionInterfaceProcessor::finishAction($objResponse, $resultValueObject);
            }
        }
        return array($hasError, $messages);
    }

}

?>
