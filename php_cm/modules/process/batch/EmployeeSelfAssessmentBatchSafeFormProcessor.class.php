<?php

/**
 * Description of EmployeeSelfAssessmentBatchSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/assessmentInvitation/InvitationMessageValueObject.class.php');
require_once('modules/model/service/batch/EmployeeSelfAssessmentBatchController.class.php');

class EmployeeSelfAssessmentBatchSafeFormProcessor
{
    static function processInviteBatch($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT)) {
            // gegevens uit form halen, employees valideren
            $subject   = $safeFormHandler->retrieveInputValue('message_subject');
            $message   = $safeFormHandler->retrieveInputValue('invitation_message');

            $valueObject = InvitationMessageValueObject::createWithValues(NULL, InvitationMessageTypeValue::INVITATION, $subject, $message);
            // uitnodigen gaat altijd over huidige cycle
            $currentCycle = AssessmentCycleService::getCurrentValueObject();

            $hasError = false;
            // de geselecteerde employees ophalen
            // Dit is eigenlijk een helemaal fout gebruik van de selectemployees...
            // select employees moet de gekozen afdeling/functie/medewerkers teruggeven
            // hier moet dan de uiteindelijke uit te nodigen medewerkers bepaalt worden..
            $selectEmps = new SelectEmployees();
            $selectEmps->setUseSelfassessment(true, $currentCycle);
            if (!$selectEmps->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
                $hasError = true;
                $messages[] = $selectEmps->getErrorTxt();
            } else {
                // ophalen geseleerde employees
                $employeeIds = $selectEmps->processResults($safeFormHandler->retrieveCleanedValues());

                list($hasError, $messages, $invitedResult) = EmployeeSelfAssessmentBatchController::processInvite(  $employeeIds,
                                                                                                                    $valueObject,
                                                                                                                    $currentCycle);

                if (!$hasError) {
                    $safeFormHandler->finalizeSafeFormProcess();
                    EmployeeSelfAssessmentBatchInterfaceProcessor::finishInviteBatch($objResponse, $invitedResult);
                }
            }
        }
        return array($hasError, $messages);
    }

    static function processRemindBatch($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_REMINDERS)) {
            // gegevens uit form halen, employees valideren
            $subject   = $safeFormHandler->retrieveInputValue('message_subject');
            $message   = $safeFormHandler->retrieveInputValue('reminder_message');

            $valueObject = InvitationMessageValueObject::createWithValues(NULL, InvitationMessageTypeValue::REMINDER, $subject, $message);
            // uitnodigen/herinneren gaat altijd over huidige cycle
            $currentCycle = AssessmentCycleService::getCurrentValueObject();

            list($hasError, $messages, $invitedResult) = EmployeeSelfAssessmentBatchController::processRemind($valueObject, $currentCycle);

            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeSelfAssessmentBatchInterfaceProcessor::finishRemindBatch($objResponse, $invitedResult);
            }
        }
        return array($hasError, $messages);
    }

}

?>
