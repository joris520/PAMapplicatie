<?php

/**
 * Description of QuestionInterfaceBuilderComponents
 *
 * @author ben.dokter
 */
class QuestionInterfaceBuilderComponents
{

    static function getAddLink()
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_QUESTIONS_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('add_question',
                                                TXT_UCF('ADD'),
                                                'xajax_public_library__addQuestion();',
                                                ICON_ADD);
        }
        return $html;
    }

    static function getEditLink($questionId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_QUESTIONS_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('edit_question_' . $questionId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_library__editQuestion(' . $questionId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink($questionId)
    {
        $html = '';
        if (PermissionsService::isDeleteAllowed(PERMISSION_QUESTIONS_LIBRARY)) {
            $html .= InterfaceBuilder::iconLink('delete_question_' . $questionId,
                                                TXT_UCF('DELETE'),
                                                'xajax_public_library__removeQuestion(' . $questionId . ');',
                                                ICON_DELETE);
        }
        return $html;
    }

}

?>
