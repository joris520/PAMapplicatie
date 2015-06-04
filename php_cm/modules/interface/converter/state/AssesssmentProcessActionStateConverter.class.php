<?php

/**
 * Description of AssesssmentProcessActionStateConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/model/state/assessmentProcess/AssessmentProcessActionState.class.php');

class AssesssmentProcessActionStateConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessActionState::NONE:
                $display = TXT_UCF('PROCESS_ACTION_NO_ACTION_POSSIBLE');
                break;
            case AssessmentProcessActionState::INVITE_SELFASSESSMENT:
                $display = TXT_UCF('PROCESS_ACTION_INVITE_EMPLOYEES');
                break;
            case AssessmentProcessActionState::CANCEL_SELFASSESSMENT:
                $display = TXT_UCF('PROCESS_ACTION_CANCEL_INVITE_EMPLOYEES');
                break;
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                $display = TXT_UCF('PROCESS_ACTION_MARK_SELFASSESSMENT_DONE');
                break;
            case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                $display = TXT_UCF('PROCESS_ACTION_UNDO_SELFASSESSMENT_DONE');
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $display = TXT_UCF('PROCESS_ACTION_MARK_SELECT_ASSESSMENT_EVALUATION_DONE');
                break;
            case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $display = TXT_UCF('PROCESS_ACTION_UNDO_SELECT_ASSESSMENT_EVALUATION_DONE');
                break;
            case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
                $display = TXT_UCF('PROCESS_ACTION_MARK_FINISH_ASSESSMENT_PROCESS');
                break;
            case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
                $display = TXT_UCF('PROCESS_ACTION_UNDO_FINISH_ASSESSMENT_PROCESS');
                break;
//            case AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS:
//                $display = TXT_UCF('PROCESS_ACTION_NO_ACTION_POSSIBLE');
//                break;
//            case AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS:
//                $display = TXT_UCF('PROCESS_ACTION_NO_ACTION_POSSIBLE');
//                break;
        }
        return $display;
    }

    static function messageConfirm($value, $empty = '')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessActionState::NONE:
            case AssessmentProcessActionState::INVITE_SELFASSESSMENT:
            case AssessmentProcessActionState::CANCEL_SELFASSESSMENT:
            case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
            case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
//            case AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS:
//            case AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS:
                $display = TXT_UCF('PROCESS_ACTION_CONFIRM_NO_ACTION_POSSIBLE');
                break;
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                // deze heeft een eigen scherm
                break;
            case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                $display = TXT_UCF('PROCESS_ACTION_CONFIRM_UNDO_SELFASSESSMENT_DONE');
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                $display = TXT_UCF('PROCESS_ACTION_CONFIRM_SELECT_ASSESSMENT_EVALUATION_DONE');
                break;
            case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $display = TXT_UCF('PROCESS_ACTION_CONFIRM_UNDO_SELECT_ASSESSMENT_EVALUATION_DONE');
                break;
        }
        return $display;
    }

    static function messageResult($value, $empty = '')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessActionState::NONE:
            case AssessmentProcessActionState::INVITE_SELFASSESSMENT:
            case AssessmentProcessActionState::CANCEL_SELFASSESSMENT:
            case AssessmentProcessActionState::MARK_FINISH_ASSESSMENT_PROCESS:
            case AssessmentProcessActionState::UNDO_FINISH_ASSESSMENT_PROCESS:
//            case AssessmentProcessActionState::MARK_ABORT_ASSESSMENT_PROCESS:
//            case AssessmentProcessActionState::UNDO_ABORT_ASSESSMENT_PROCESS:
                $display = TXT_UCF('PROCESS_ACTION_RESULT_NO_ACTION_POSSIBLE');
                break;
            case AssessmentProcessActionState::MARK_SELFASSESSMENT_DONE:
                // deze heeft een eigen scherm
                break;
            case AssessmentProcessActionState::UNDO_SELFASSESSMENT_DONE:
                $display = TXT_UCF('PROCESS_ACTION_RESULT_UNDO_SELFASSESSMENT_DONE');
                break;
            case AssessmentProcessActionState::MARK_SELECT_ASSESSMENT_EVALUATION_DONE:
                // deze heeft een eigen scherm
                break;
            case AssessmentProcessActionState::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE:
                $display = TXT_UCF('PROCESS_ACTION_RESULT_UNDO_SELECT_ASSESSMENT_EVALUATION_DONE');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

}

?>
