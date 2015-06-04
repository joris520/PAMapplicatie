<?php

/**
 * Description of AssessmentProcessActionState
 *
 * @author ben.dokter
 */
require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');

class AssessmentProcessActionState
{
    const NONE                                      = 0;

    const INVITE_SELFASSESSMENT                     = 10;
    const CANCEL_SELFASSESSMENT                     = 11;

    const MARK_SELFASSESSMENT_DONE                  = 20;
    const UNDO_SELFASSESSMENT_DONE                  = 21;

    const MARK_SELECT_ASSESSMENT_EVALUATION_DONE    = 30;
    const UNDO_SELECT_ASSESSMENT_EVALUATION_DONE    = 31;

    const MARK_FINISH_ASSESSMENT_PROCESS            = 100;
    const UNDO_FINISH_ASSESSMENT_PROCESS            = 101;

    const MARK_ABORT_ASSESSMENT_PROCESS             = 110;
    const UNDO_ABORT_ASSESSMENT_PROCESS             = 111;


    static function determineNextAction($currentAssessmentState)
    {
        $nextAction = self::NONE;

        switch($currentAssessmentState) {
            case AssessmentProcessStatusValue::UNUSED:
                $nextAction = self::INVITE_SELFASSESSMENT;
                break;
            case AssessmentProcessStatusValue::INVITED:
                $nextAction = self::MARK_SELFASSESSMENT_DONE;
                break;
            case AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED:
                $nextAction = self::MARK_SELECT_ASSESSMENT_EVALUATION_DONE;
                break;
            case AssessmentProcessStatusValue::EVALUATION_SELECTED:
                $nextAction = self::MARK_FINISH_ASSESSMENT_PROCESS;
                break;
            case AssessmentProcessStatusValue::EVALUATION_READY:
                $nextAction = self::NONE;
                break;
        }
        return $nextAction;
    }

    static function determineUndoAction($currentAssessmentState)
    {
        $undoAction = self::NONE;

        switch($currentAssessmentState) {
            case AssessmentProcessStatusValue::UNUSED:
                $undoAction = self::NONE;
                break;
            case AssessmentProcessStatusValue::INVITED:
                $undoAction = self::CANCEL_SELFASSESSMENT;
                break;
            case AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED:
                $undoAction = self::UNDO_SELFASSESSMENT_DONE;
                break;
            case AssessmentProcessStatusValue::EVALUATION_SELECTED:
                $undoAction = self::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE;
                break;
            case AssessmentProcessStatusValue::EVALUATION_READY:
                $undoAction = self::UNDO_FINISH_ASSESSMENT_PROCESS;
                break;
        }
        return $undoAction;
    }

}

?>
