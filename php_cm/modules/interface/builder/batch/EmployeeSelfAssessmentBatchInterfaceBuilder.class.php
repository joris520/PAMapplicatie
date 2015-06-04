<?php

/**
 * Description of EmployeeSelfAssessmentBatchInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/batch/EmployeeSelfAssessmentBatchInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/library/AssessmentCycleInterfaceBuilder.class.php');

require_once('modules/model/service/assessmentInvitation/InvitationMessageService.class.php');
require_once('modules/model/service/library/AssessmentEmailMessageTemplateService.class.php');
require_once('modules/model/service/report/SelfAssessmentReportService.class.php');
require_once('modules/model/service/employee/EmployeeSelectService.class.php');

require_once('modules/interface/interfaceobjects/batch/EmployeeSelfAssessmentBatchInvite.class.php');
require_once('modules/interface/interfaceobjects/batch/EmployeeSelfAssessmentBatchInviteResult.class.php');
require_once('modules/interface/interfaceobjects/batch/EmployeeSelfAssessmentBatchRemind.class.php');
require_once('modules/interface/interfaceobjects/batch/EmployeeSelfAssessmentBatchRemindResult.class.php');



class EmployeeSelfAssessmentBatchInterfaceBuilder
{

    static function getInviteHtml(  $displayWidth,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        // standaard bericht ophalen
        $emailMessageValueObject = AssessmentEmailMessageTemplateService::getValueObject();

        // employee selector
        $selectEmployeesComponent = new SelectEmployees();
        $selectEmployeesComponent->show_bosses = true;
        $selectEmployeesComponent->show_employees_with_emailaddress = true;
        $selectEmployeesComponent->show_employees_without_self_assessment_invitation = true;
        $selectEmployeesComponent->setUseSelfassessment(true, $assessmentCycle);

        // safe form
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_BATCH__ADD_INVITATION_SELF_ASSESSMENT);

        $safeFormHandler->addStringInputFormatType('message_subject');
        $safeFormHandler->addStringInputFormatType('invitation_message');

        $selectEmployeesComponent->fillSafeFormValues($safeFormHandler);

        $safeFormHandler->finalizeDataDefinition();

        // interfaceObject
        $interfaceObject = EmployeeSelfAssessmentBatchInvite::create($assessmentCycle, $displayWidth);
        $interfaceObject->setCycleDetailHtml(       AssessmentCycleInterfaceBuilder::getDetailHtml($displayWidth, $assessmentCycle));
        $interfaceObject->setSubject(               TXT_UCF('SELF_EVALUATION_MESSAGE_SUBJECT'));
        $interfaceObject->setMessage(               $emailMessageValueObject->getInternalMesssage());
        $interfaceObject->setEmployeesSelectorHtml( EmployeeSelfAssessmentBatchInterfaceBuilderComponents::getEmployeesSelectorHtml($selectEmployeesComponent));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getInviteConfirmationHtml(  $displayWidth,
                                                EmployeeSelfAssessmentBatchValueObject $invitedResult)
    {
        $interfaceObject = EmployeeSelfAssessmentBatchInviteResult::createWithValueObject(  $invitedResult,
                                                                                            $displayWidth);
        $interfaceObject->setShowDetails(   CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION);

        return $interfaceObject->fetchHtml();
    }

    static function getRemindHtml(  $displayWidth,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        // standaard bericht ophalen
        $lastMessageValueObject = InvitationMessageService::getReminderMessage();

        // statistieken ophalen
        $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds(EmployeeSelectService::RETURN_AS_STRING);
        list($invitedCount, $sentCount) = SelfAssessmentReportService::getEmployeesInvitationCount($allowedEmployeeIds, $assessmentCycle);
        $notCompletedCount  = SelfAssessmentReportService::getInvitationsNotCompletedCount($allowedEmployeeIds, $assessmentCycle);

        $needsReminder      = $notCompletedCount > 0;

        // safe form
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_BATCH__REMINDER_SELF_ASSESSMENT);

        $safeFormHandler->addStringInputFormatType('message_subject');
        $safeFormHandler->addStringInputFormatType('reminder_message');

        $safeFormHandler->finalizeDataDefinition();

        // interfaceObject
        $interfaceObject = EmployeeSelfAssessmentBatchRemind::create($assessmentCycle, $displayWidth);
        $interfaceObject->setCycleDetailHtml(   AssessmentCycleInterfaceBuilder::getDetailHtml($displayWidth, $assessmentCycle));
        $interfaceObject->setSubject(           $lastMessageValueObject->getSubject());
        $interfaceObject->setMessage(           $lastMessageValueObject->getMessage());
        $interfaceObject->setInvitedCount(      $invitedCount);
        $interfaceObject->setSentCount(         $sentCount);
        $interfaceObject->setNotCompletedCount( $notCompletedCount);
        $interfaceObject->setNeedsReminder(     $needsReminder);
        // info links
        $interfaceObject->setInvitedDetailLink(         EmployeeSelfAssessmentBatchInterfaceBuilderComponents::getinvitedDetailLink(        $notCompletedCount));
        $interfaceObject->setNotCompletedDetailLink(    EmployeeSelfAssessmentBatchInterfaceBuilderComponents::getNotCompletedDetailLink(   $invitedCount));


        $contentHtml =  $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml, $needsReminder);
    }

    static function getRemindConfirmationHtml(  $displayWidth,
                                                EmployeeSelfAssessmentBatchValueObject $invitedResult)
    {
        $interfaceObject = EmployeeSelfAssessmentBatchRemindResult::createWithValueObject($invitedResult, $displayWidth);
        $interfaceObject->setShowDetails(   CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION);

        return $interfaceObject->fetchHtml();
    }

}

?>
