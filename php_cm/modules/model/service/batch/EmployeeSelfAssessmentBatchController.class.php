<?php

/**
 * Description of EmployeeSelfAssessmentBatchController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/assessmentInvitation/InvitationMessageService.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfileOrganisationService.class.php');
require_once('modules/model/valueobjects/batch/EmployeeSelfAssessmentBatchValueObject.class.php');


class EmployeeSelfAssessmentBatchController
{
    static function processInvite(  array $employeeIds,
                                    InvitationMessageValueObject $valueObject,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $hasError = true;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = InvitationMessageService::validate($valueObject);
        if (!$hasError) {
            // bericht vastleggen...
            $invitationMessageId = InvitationMessageService::insertInvitationMessage($valueObject);
            $batchResultValueObject = EmployeeSelfAssessmentBatchValueObject::create($invitationMessageId);
            // elke medewerker uitnodigen en in een cohort bij de leidinggevende stoppen
            $bossIds = array();
            foreach ($employeeIds as $employeeId) {

                $invitationResultValueObject = EmployeeSelfAssessmentInvitationService::addInvitation($employeeId, $invitationMessageId);
                $invitationHashId = $invitationResultValueObject->getInvitationHashId();

                $batchResultValueObject->addInvitationResult($invitationResultValueObject);
                if ($invitationResultValueObject->isInvited())
                {
                    // de score status aanpassen
                    EmployeeAssessmentService::indicateNewSelfassessmentInvitation($employeeId, $assessmentCycle);


                    // TODO: tsn process
                    if (CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS) {
                        // de medewerker proces status zetten...
                        EmployeeAssessmentProcessService::indicateNewSelfassessmentInvitation($employeeId, $invitationHashId, $assessmentCycle);

                        // de boss opzoeken
                        $employeeProfileOrganisationValueObject = EmployeeProfileOrganisationService::getValueObject($employeeId, false);
                        $bossId = $employeeProfileOrganisationValueObject->getBossId();
                        if (!empty($bossId)) {
                            $bossIds[$bossId] = $bossId;
                        }
                    }

                }
            }
            // voor nu: de leidinggevende markeren als processtap 1: uitgenodigde medewerkers
            foreach ($bossIds as $bossId) {
                // de boss status ook zetten
                BossAssessmentProcessService::indicateNewSelfassessmentInvitation($bossId, $assessmentCycle);
            }
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $batchResultValueObject);
    }

    static function processRemind(  InvitationMessageValueObject $valueObject,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $hasError = true;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = InvitationMessageService::validate($valueObject);

        $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds(EmployeeSelectService::RETURN_AS_STRING);
        $notCompletedInvitations  = SelfAssessmentReportService::getInvitationsNotCompleted($allowedEmployeeIds, $assessmentCycle);

        if (!$hasError) {
            // bericht vastleggen...
            $invitationMessageId = InvitationMessageService::insertInvitationMessage($valueObject);
            $batchResult = EmployeeSelfAssessmentBatchValueObject::create($invitationMessageId);
            // elke medewerker uitnodigen en in een cohort bij de leidinggevende stoppen
            foreach ($notCompletedInvitations as $notCompletedInvitation) {
                $invitationResult = EmployeeSelfAssessmentInvitationService::updateInvitationReminder($notCompletedInvitation, $invitationMessageId);
                $batchResult->addInvitationResult($invitationResult);
            }
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $batchResult);
    }

}

?>
