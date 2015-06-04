<?php

/**
 * Description of QuestionPageBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/library/QuestionInterfaceBuilder.class.php');

class QuestionPageBuilder
{

    static function getPageHtml($displayWidth, $hiliteId = NULL, $activeQuestionsOnly = true)
    {
        return QuestionInterfaceBuilder::getViewHtml($displayWidth, $hiliteId, $activeQuestionsOnly);
    }

    static function getAddPopupHtml($displayWidth, $contentHeight, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = QuestionInterfaceBuilder::getAddHtml($displayWidth);

        // popup
        $title = TXT_UCF('ADD') . ' ' . TXT_LC('ASSESSMENT_QUESTION');
        $formId = 'add_assessmentquestion_form_' . $questionId;
        return ApplicationInterfaceBuilder::getAddPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }

    static function getEditPopupHtml($displayWidth, $contentHeight, $questionId, $showWarning)
    {
        list($safeFormHandler, $contentHtml) = QuestionInterfaceBuilder::getEditHtml($displayWidth, $questionId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('ASSESSMENT_QUESTION');
        $formId = 'edit_assessmentquestion_form_' . $questionId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight, $showWarning);
    }

    static function getRemovePopupHtml($displayWidth, $contentHeight, $questionId)
    {
        list($safeFormHandler, $contentHtml) = QuestionInterfaceBuilder::getRemoveHtml($displayWidth, $questionId);

        // popup
        $title = TXT_UCF('DELETE') . ' ' . TXT_LC('ASSESSMENT_QUESTION');
        $formId = 'delete_assessmentquestion_form_' . $questionId;
        return ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);
    }

}

?>
