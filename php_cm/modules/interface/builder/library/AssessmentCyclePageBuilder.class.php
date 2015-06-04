<?php

/**
 * Description of AssessmentCyclePageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/library/AssessmentCycleInterfaceBuilder.class.php');

class AssessmentCyclePageBuilder
{
    static function getPageHtml($displayWidth, $hiliteId = NULL)
    {
        return AssessmentCycleInterfaceBuilder::getViewHtml($displayWidth, $hiliteId);
    }

    static function getAddPopupHtml($displayWidth, $contentHeight)
    {
        list($safeFormHandler, $contentHtml) = AssessmentCycleInterfaceBuilder::getAddHtml($displayWidth);

        // popup
        $title = TXT_UCF('ADD') . ' ' . TXT_LC('ASSESSMENT_CYCLE');
        $formId = 'add_assessment_cycle_form';
        return ApplicationInterfaceBuilder::getAddPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::HIDE_WARNING);
    }

    static function getEditPopupHtml($displayWidth, $contentHeight, $assessmentCycleId)
    {
        list($safeFormHandler, $contentHtml) = AssessmentCycleInterfaceBuilder::getEditHtml($displayWidth, $assessmentCycleId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_CYCLE');
        $formId = 'edit_assessment_cycle_form_' . $assessmentCycleId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::HIDE_WARNING);
    }

    static function getRemovePopupHtml($displayWidth, $contentHeight, $assessmentCycleId)
    {
        list($safeFormHandler, $contentHtml) = AssessmentCycleInterfaceBuilder::getRemoveHtml($displayWidth, $assessmentCycleId);

        // popup
        $title = TXT_UCF('DELETE') . ' ' . TXT_LC('ASSESSMENT_CYCLE');
        $formId = 'delete_assessment_cycle_form_' . $assessmentCycleId;
        return ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, ApplicationInterfaceBuilder::HIDE_WARNING);
    }

}

?>
