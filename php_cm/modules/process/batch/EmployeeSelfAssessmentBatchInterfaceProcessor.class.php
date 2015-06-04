<?php

/**
 * Description of EmployeeSelfAssessmentBatchInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/batch/EmployeeSelfAssessmentBatchPageBuilder.class.php');
require_once('modules/process/tab/SelfAssessmentTabInterfaceProcessor.class.php');
require_once('modules/model/valueobjects/batch/EmployeeSelfAssessmentBatchValueObject.class.php');

class EmployeeSelfAssessmentBatchInterfaceProcessor
{
    const INVITE_WIDTH = 1200;
    const REMIND_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const RESULT_WIDTH = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;

    static function displayInviteView($objResponse)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT)) {
            unset($_SESSION['ID_E']);
            $currentCycle = AssessmentCycleService::getCurrentValueObject();

            $pageHtml = EmployeeSelfAssessmentBatchPageBuilder::getInvitePageHtml(self::INVITE_WIDTH, $currentCycle);

            SelfAssessmentTabInterfaceProcessor::displayContent($objResponse, self::INVITE_WIDTH, $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_SELFASSESSMENT_MENU_SELFASSESSEMENT_BATCH);
        }
    }

    static function finishInviteBatch(  $objResponse,
                                        EmployeeSelfAssessmentBatchValueObject $invitedResult)
    {
        $contentHtml = EmployeeSelfAssessmentBatchPageBuilder::getInviteConfirmationHtml(self::RESULT_WIDTH, $invitedResult);
        SelfAssessmentTabInterfaceProcessor::displayContent($objResponse, self::RESULT_WIDTH, $contentHtml);
    }

    static function displayRemindView($objResponse)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_REMINDERS)) {
            unset($_SESSION['ID_E']);
            $currentCycle = AssessmentCycleService::getCurrentValueObject();

            $pageHtml = EmployeeSelfAssessmentBatchPageBuilder::getRemindPageHtml(self::REMIND_WIDTH, $currentCycle);

            SelfAssessmentTabInterfaceProcessor::displayContent($objResponse, self::REMIND_WIDTH, $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_SELFASSESSMENT_MENU_REMINDER_SELFASSESSEMENT_BATCH);
        }
    }

    static function finishRemindBatch($objResponse, EmployeeSelfAssessmentBatchValueObject $invitedResult)
    {
        $contentHtml = EmployeeSelfAssessmentBatchPageBuilder::getRemindConfirmationHtml(self::RESULT_WIDTH, $invitedResult);
        SelfAssessmentTabInterfaceProcessor::displayContent($objResponse, self::RESULT_WIDTH, $contentHtml);
    }
}
?>
