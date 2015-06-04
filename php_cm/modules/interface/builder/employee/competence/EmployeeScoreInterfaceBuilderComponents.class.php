<?php


/**
 * Description of EmployeeScoreInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeScoreInterfaceBuilderComponents
{

    static function getEditBulkLink($employeeId, $isAllowedEditCurrentScore)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES) && $isAllowedEditCurrentScore) {
            $html .= InterfaceBuilder::iconLink('edit_bulk_scores_' . $employeeId,
                                                TXT_UCF('EDIT_BULK_SCORES'),
                                                'xajax_public_employeeCompetence__editBulkScores(' . $employeeId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getEditClusterLink($employeeId, $clusterId, $isAllowedEditCurrentScore)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES_CLUSTER_EDIT) && $isAllowedEditCurrentScore) {
            $html .= InterfaceBuilder::iconLink('edit_cluster_scores_' . $employeeId . '_' . $clusterId,
                                                TXT_UCF('EDIT_CLUSTER_SCORES'),
                                                'xajax_public_employeeCompetence__editClusterScores(' . $employeeId . ' , ' . $clusterId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getKeepAliveCallback()
    {
        $callback = '';
        if (APPLICATION_EDIT_SCORE_KEEP_ALIVE && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $callback .= 'xajax_public_employeeCompetence__editScoreCallback();';
        }
        return $callback;
    }


    static function getToggleNotesVisibilityLink($masterHtmlId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $html .= InterfaceBuilder::iconLink('toggle_notes_' . $masterHtmlId,
                                                TXT_UCF('TOGGLE_ALL_REMARKS'),
                                                'toggleAllCommentRows(\'' . $masterHtmlId . '\');',
                                                ICON_COMMENTS);
        }
        return $html;
    }

    static function getToggleViewNoteVisibilityLink($masterHtmlId, $prefix, $competenceId)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $html .= InterfaceBuilder::iconLink('toggle_comment_' . $masterHtmlId . '_' . $competenceId,
                                                TXT_UCF('THERE_ARE_REMARKS'),
                                                'toggleCommentRow(\'' . $masterHtmlId . '\', \'' . $prefix . $competenceId . '\');', //empPrint' . $employeeId . ' , ' . $competenceId . ');',
                                                ICON_COMMENT);
        }
        return $html;
    }

    static function getToggleEditNoteVisibilityLink($masterHtmlId, $prefix, $competenceId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES)) {
            $html .= InterfaceBuilder::iconLink('toggle_comment_' . $masterHtmlId . '_' . $competenceId,
                                                TXT_UCF('TOGGLE_EDIT_REMARKS'),
                                                'toggleCommentRow(\'' . $masterHtmlId . '\', \'' . $prefix . $competenceId . '\');', //empPrint' . $employeeId . ' , ' . $competenceId . ');',
                                                ICON_COMMENT_EDIT);
        }
        return $html;
    }

    static function getHistoryLink($employeeId, $competenceId, $isAllowedViewCurrentScore)
    {
        $html = '';
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_INLINE_HISTORY) && $isAllowedViewCurrentScore) {
            $html .= InterfaceBuilder::iconLink('view_competence_score_history_' . $employeeId . '_' . $competenceId,
                                                TXT_UCF('HISTORY'),
                                                'xajax_public_employeeCompetence__displayHistoryScore(' . $employeeId . ' , ' . $competenceId . ');',
                                                ICON_HISTORY);
        }
        return $html;
    }


    static function diffIndicator(EmployeeScoreValueObject $bossScoreValueObject = NULL,
                                  EmployeeSelfAssessmentScoreValueObject $employeeScoreValueObject = NULL)
    {
        $diffIndicator = '';
        if (CUSTOMER_OPTION_SHOW_360_DIFFERENCE && !empty($employeeScoreValueObject) && !empty($bossScoreValueObject)) {
            $employeeScore  = $employeeScoreValueObject->getScore();
            $bossScore      = $bossScoreValueObject->getScore();
            if (!(empty($employeeScore) && empty($bossScore))) {
                if ($employeeScoreValueObject->isCompleted() &&
                    $employeeScore != $bossScore) {
                    $diffIndicator = ' score-diff" title="' . TXT_UCF('SCORE_DIFFERENCE');
                }
            }
        }
        return $diffIndicator;
    }

    static function getEditScorePrefix($scale)
    {
        return InterfaceBuilderComponents::getEditPrefix($scale, 'boss_score_edit_');
    }


    static function getEditNotePrefix($scale)
    {
        return InterfaceBuilderComponents::getEditPrefix($scale, 'boss_note_edit_');
    }


}

?>
