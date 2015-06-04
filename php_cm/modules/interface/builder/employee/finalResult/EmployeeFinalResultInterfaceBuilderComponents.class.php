<?php


/**
 * Description of EmployeeFinalResultInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeFinalResultInterfaceBuilderComponents
{

    static function getAddLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
            $html .= InterfaceBuilder::iconLink('edit_final_result_' . $employeeId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_employeeFinalResult__addFinalResult(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getEditLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
            $html .= InterfaceBuilder::iconLink('edit_final_result_' . $employeeId,
                                                TXT_UCF('EDIT'),
                                                'xajax_public_employeeFinalResult__editFinalResult(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getHistoryLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT) &&
            PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY)) {
        $html .= InterfaceBuilder::iconLink('view_final_result_history_' . $employeeId,
                                            TXT_UCF('HISTORY'),
                                            'xajax_public_employeeFinalResult__historyFinalResult(' . $employeeId . ');',
                                            ICON_HISTORY);
        }
        return $html;
    }

    static function getToggleNotesVisibilityLink($masterHtmlId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
            $html .= InterfaceBuilder::iconLink('toggle_notes_' . $masterHtmlId,
                                                TXT_UCF('TOGGLE_ALL_REMARKS'),
                                                'toggleAllCommentRows(\'' . $masterHtmlId . '\');',
                                                ICON_COMMENTS);
        }
        return $html;
    }

    static function getToggleViewNoteVisibilityLink($masterHtmlId, $prefix, $scoreName)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
            $html .= InterfaceBuilder::iconLink('toggle_comment_' . $masterHtmlId . '_' . $scoreName,
                                                TXT_UCF('THERE_ARE_REMARKS'),
                                                'toggleCommentRow(\'' . $masterHtmlId . '\', \'' . $prefix . $scoreName . '\');',
                                                ICON_COMMENT);
        }
        return $html;
    }

}

?>
