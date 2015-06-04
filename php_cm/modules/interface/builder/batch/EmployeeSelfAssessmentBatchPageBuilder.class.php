<?php

/**
 * Description of EmployeeSelfAssessmentBatchPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/batch/EmployeeSelfAssessmentBatchInterfaceBuilder.class.php');

class EmployeeSelfAssessmentBatchPageBuilder
{

    static function getInvitePageHtml(  $displayWidth,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        list($safeFormHandler, $contentHtml) = EmployeeSelfAssessmentBatchInterfaceBuilder::getInviteHtml($displayWidth, $assessmentCycle);

        // popup
        $title = '';//TXT_UCW('COLLECTIVE_INVITATION_SELF_ASSESSMENT');
        $formId = 'batch_invite_selfassessment';
        $cancelFunction = 'xajax_public_selfAssessment__displayTab()';
        $buttonName = TXT_BTN('PERFORM');
        $pageHtml = ApplicationInterfaceBuilder::getBatchAddHtml(   $formId,
                                                                    $safeFormHandler,
                                                                    $title,
                                                                    $contentHtml,
                                                                    $displayWidth,
                                                                    NULL,
                                                                    ApplicationInterfaceBuilder::SHOW_WARNING,
                                                                    $buttonName,
                                                                    NULL,
                                                                    $cancelFunction);

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockHtmlInterfaceObject::create(   TXT_UCF('COLLECTIVE_INVITATION_SELF_ASSESSMENT'),
                                                                        $displayWidth);

        // een extra regel voor de assessment cycle
        $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getDetailInfo(   $displayWidth,
                                                                                 $assessmentCycle);
        $additionalRow = BaseBlockHeaderRowInterfaceObject::create( $assessmentCycleInfo,
                                                                    $displayWidth);

        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        $blockInterfaceObject->setContentHtml($pageHtml);

        return $blockInterfaceObject->fetchHtml();

    }

    static function getInviteConfirmationHtml(  $displayWidth,
                                                EmployeeSelfAssessmentBatchValueObject $invitedResult)
    {
        $pageHtml = EmployeeSelfAssessmentBatchInterfaceBuilder::getInviteConfirmationHtml($displayWidth, $invitedResult);
        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockHtmlInterfaceObject::create(   TXT_UCF('COLLECTIVE_INVITATION_SELF_ASSESSMENT'),
                                                                        $displayWidth);

        $blockInterfaceObject->setContentHtml($pageHtml);

        return $blockInterfaceObject->fetchHtml();

    }


    static function getRemindPageHtml(  $displayWidth,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        list($safeFormHandler, $contentHtml, $needsReminder) = EmployeeSelfAssessmentBatchInterfaceBuilder::getRemindHtml($displayWidth, $assessmentCycle);

        if ($needsReminder) {
            // popup
            $title = '';
            $formId = 'batch_remind_selfassessment';
            $cancelFunction = 'xajax_public_selfAssessment__displayTab()';
            $buttonName = TXT_BTN('PERFORM');
            $pageHtml = ApplicationInterfaceBuilder::getBatchAddHtml(   $formId,
                                                                        $safeFormHandler,
                                                                        $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        NULL,
                                                                        ApplicationInterfaceBuilder::SHOW_WARNING,
                                                                        $buttonName,
                                                                        $cancelFunction);
        } else {
            $pageHtml = $contentHtml;
        }
        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockHtmlInterfaceObject::create(   TXT_UCF('COLLECTIVE_REMINDER_SELF_ASSESSMENT'),
                                                                        $displayWidth);

        // een extra regel voor de assessment cycle
        $assessmentCycleInfo = AssessmentCycleInterfaceBuilder::getDetailInfo(   $displayWidth,
                                                                                 $assessmentCycle);
        $additionalRow = BaseBlockHeaderRowInterfaceObject::create( $assessmentCycleInfo,
                                                                    $displayWidth);

        $blockInterfaceObject->addAdditionalHeaderRow($additionalRow);

        $blockInterfaceObject->setContentHtml($pageHtml);

        return $blockInterfaceObject->fetchHtml();

    }

    static function getRemindConfirmationHtml(  $displayWidth,
                                                EmployeeSelfAssessmentBatchValueObject $invitedResult)
    {
        $pageHtml = EmployeeSelfAssessmentBatchInterfaceBuilder::getRemindConfirmationHtml($displayWidth, $invitedResult);

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockHtmlInterfaceObject::create(   TXT_UCF('COLLECTIVE_REMINDER_SELF_ASSESSMENT'),
                                                                        $displayWidth);

        $blockInterfaceObject->setContentHtml($pageHtml);

        return $blockInterfaceObject->fetchHtml();

    }

}

?>
