<?php

/**
 * Description of AssessmentProcessActionButton
 *
 * @author ben.dokter
 */
require_once('modules/model/state/assessmentProcess/AssessmentProcessActionState.class.php');

class AssessmentProcessActionButton
{
    const BUTTON_ID_NONE                                    = 'none';
    const BUTTON_ID_MARK_SELF_ASSESSMENT_DONE               = 'mark_selfassessment_done';
    const BUTTON_ID_UNDO_SELFASSESSMENT_DONE                = 'undo_selfassessment_done';
    const BUTTON_ID_MARK_SELECT_ASSESSMENT_EVALUATION_DONE  = 'mark_evaluation_selected';
    const BUTTON_ID_UNDO_SELECT_ASSESSMENT_EVALUATION_DONE  = 'undo_evaluation_selected';
    const BUTTON_ID_MARK_FINISH_ASSESSMENT_PROCESS          = 'mark_assessment_done';
    const BUTTON_ID_UNDO_FINISH_ASSESSMENT_PROCESS          = 'undo_assessment_done';
    const BUTTON_ID_MARK_ABORT_ASSESSMENT_PROCESS           = 'mark_selfassessment_aborted';
    const BUTTON_ID_UNDO_ABORT_ASSESSMENT_PROCESS           = 'undo_selfassessment_aborted';

    static function getButtonIdForAction($processAction)
    {
        $buttonId = self::BUTTON_ID_NONE;
        switch($processAction) {
            case AssessmentProcessActionState::NONE:
            case AssessmentProcessActionState::INVITE_SELFASSESSMENT:
            case AssessmentProcessActionState::CANCEL_SELFASSESSMENT:
                $buttonId = self::BUTTON_ID_NONE;
                break;
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                $buttonId = self::BUTTON_ID_MARK_SELF_ASSESSMENT_DONE;
                break;
            case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                $buttonId = self::BUTTON_ID_UNDO_SELFASSESSMENT_DONE;
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $buttonId = self::BUTTON_ID_MARK_SELECT_ASSESSMENT_EVALUATION_DONE;
                break;
            case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $buttonId = self::BUTTON_ID_UNDO_SELECT_ASSESSMENT_EVALUATION_DONE;
                break;
            case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
                $buttonId = self::BUTTON_ID_MARK_FINISH_ASSESSMENT_PROCESS;
                break;
            case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
                $buttonId = self::BUTTON_ID_UNDO_FINISH_ASSESSMENT_PROCESS;
                break;
            case AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS:
                $buttonId = self::BUTTON_ID_MARK_ABORT_ASSESSMENT_PROCESS;
                break;
            case AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS:
                $buttonId = self::BUTTON_ID_UNDO_ABORT_ASSESSMENT_PROCESS;
                break;
        }
        return $buttonId;
    }

    static function getPermissionForAction($processAction)
    {
        $permission = PermissionValue::NO_ACCESS;
        switch($processAction) {
            case AssessmentProcessActionState::INVITE_SELFASSESSMENT:
                $permission = PERMISSION_BATCH_INVITE_SELF_ASSESSMENT;
                break;
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                $permission = PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE;
                break;
            case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                $permission = PERMISSION_ASSESSMENT_PROCESS_UNDO_MARK_ASSESSMENT_DONE;
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $permission = PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATIONS_SELECTED;
                break;
            case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $permission = PERMISSION_ASSESSMENT_PROCESS_UNDO_MARK_EVALUATIONS_SELECTED;
                break;
            case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
                $permission = PermissionValue::NO_ACCESS;
                break;
            case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
                $permission = PermissionValue::NO_ACCESS;
                break;
            case AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS:
                $permission = PermissionValue::NO_ACCESS;
                break;
            case AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS:
                $permission = PermissionValue::NO_ACCESS;
                break;
        }
        return $permission;
    }

    static function getLabelForButtonId($buttonId)
    {
        $label = '';
        switch ($buttonId) {
            case self::BUTTON_ID_MARK_SELF_ASSESSMENT_DONE:
                $label = TXT_BTN('PROCESS_BUTTON_LABEL_MARK_ASSESSMENT_DONE');
                break;
            case self::BUTTON_ID_MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $label = TXT_BTN('PROCESS_BUTTON_LABEL_MARK_EVALUATION_SELECTION_DONE');
                break;
            case self::MARK_FINISH_ASSESSMENT_PROCESS:
                $label = TXT_BTN('PROCESS_BUTTON_LABEL_MARK_FINISH_ASSESSMENT_PROCESS');
                break;
        }
        return $label;
    }

    // en weer terug van button naar actie
    // TODO: hoort dit hier?
    static function getActionForButton($buttonId)
    {
        $action = AssessmentProcessActionState::NONE;
        switch ($buttonId) {
            case self::BUTTON_ID_MARK_SELF_ASSESSMENT_DONE:
                $action = AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE;
                break;
            case self::BUTTON_ID_UNDO_SELFASSESSMENT_DONE:
                $action = AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE;
                break;
            case self::BUTTON_ID_MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $action = AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE;
                break;
            case self::BUTTON_ID_UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $action = AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE;
                break;
            case self::BUTTON_ID_MARK_FINISH_ASSESSMENT_PROCESS:
                $action = AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS;
                break;
            case self::BUTTON_ID_UNDO_FINISH_ASSESSMENT_PROCESS:
                $action = AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS;
                break;
            case self::BUTTON_ID_MARK_ABORT_ASSESSMENT_PROCESS:
                $action = AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS;
                break;
            case self::BUTTON_ID_UNDO_ABORT_ASSESSMENT_PROCESS:
                $action = AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS;
                break;
        }

        return $action;
    }
}

?>
