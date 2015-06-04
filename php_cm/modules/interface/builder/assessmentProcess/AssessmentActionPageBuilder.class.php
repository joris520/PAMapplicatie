<?php

/**
 * Description of AssessmentActionPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/assessmentProcess/AssessmentActionInterfaceBuilder.class.php');

class AssessmentActionPageBuilder
{

    static function getActionHtml(  $displayWidth,
                                    AssessmentCycleValueObject $assessmentCycle)
    {

        $actionContentHtml = self::getActionContentHtml($displayWidth, $assessmentCycle);
        return AssessmentActionInterfaceBuilder::getActionHtml($displayWidth, $actionContentHtml);
    }

    static function getActionContentHtml(   $displayWidth,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $formId = 'assessment_actions_form';
        list($safeActionHandler, $contentHtml) = AssessmentActionInterfaceBuilder::getActionContentHtml($displayWidth, $formId, $assessmentCycle);

        // in een safeform samenvoegen
        $actionHtml = ApplicationInterfaceBuilder::getListActionSafeFormHtml($formId, $safeActionHandler, $contentHtml);

        return $actionHtml;
    }

    static function getConfirmActionPopupHtml(  $displayWidth,
                                                $contentHeight,
                                                $bossId,
                                                $processAction,
                                                AssessmentCycleValueObject $assessmentCycle)
    {

        list($safeFormHandler, $contentHtml, $title) = AssessmentActionConfirmInterfaceBuilder::getConfirmActionHtml(   $displayWidth,
                                                                                                                        $bossId,
                                                                                                                        $processAction,
                                                                                                                        $assessmentCycle);

        // popup
        $formId = 'verify_action_form';
        return ApplicationInterfaceBuilder::getActionPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::HIDE_WARNING);
    }


    static function getActionResultPopupHtml(   $displayWidth,
                                                $contentHeight,
                                                AssessmentProcessResultValueObject $resultValueObject)
    {
        list($contentHtml, $title) = AssessmentActionResultInterfaceBuilder::getActionResultHtml($displayWidth, $resultValueObject);

        // popup
        return ApplicationInterfaceBuilder::getInfoPopupHtml($title, $contentHtml, $displayWidth, $contentHeight);
    }

}

?>
