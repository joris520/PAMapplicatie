<?php

/**
 * Description of AssessmentProcessEvaluationState
 *
 * @author ben.dokter
 */

class AssessmentProcessEvaluationState
{

    const EVALUATION_NO_PROCESS = 100;
    const EVALUATION_NONE       = 101;
    const EVALUATION_TODO       = 102;
    const EVALUATION_DONE       = 103;
    const EVALUATION_CANCELLED  = 104;

    static function determineRankColor($rankingValue, $isEvaluationRequested)
    {
        $color = NULL;
        switch ($rankingValue) {
            case AssessmentProcessScoreRankingValue::RANKING_LOW:
                $color = COLOUR_RED;
                break;
            case AssessmentProcessScoreRankingValue::RANKING_HIGH:
                $color = COLOUR_GREEN;
                break;
            case AssessmentProcessScoreRankingValue::RANKING_DIFF:
                $color = COLOUR_ORANGE;
                break;
            default:
                if ($isEvaluationRequested) {
                    $color = COLOUR_DARK_BLUE;
                }
        }
        return $color;
    }

    static function determineProcessEvaluationState($assessmentEvaluationStatus,
                                                    $isEvaluationRequested,
                                                    $assessmentProcessStatus = AssessmentProcessStatusValue::EVALUATION_SELECTED)
    {
        switch($assessmentEvaluationStatus) {
            case AssessmentEvaluationStatusValue::EVALUATION_DONE:
                $state = self::EVALUATION_DONE;
                break;
            case AssessmentEvaluationStatusValue::EVALUATION_CANCELLED:
                $state = self::EVALUATION_CANCELLED;
                break;
            case AssessmentEvaluationStatusValue::EVALUATION_NO:
            default:
                if ($assessmentProcessStatus == AssessmentProcessStatusValue::EVALUATION_SELECTED) {
                    $state = $isEvaluationRequested ? self::EVALUATION_TODO : self::EVALUATION_NONE;
                } else {
                    $state = self::EVALUATION_NO_PROCESS;
                }
                break;
        }
        return $state;
    }

    static function determineEvaluationStatusIcon($processEvaluationState)
    {
        switch($processEvaluationState) {
            case self::EVALUATION_TODO:
                $statusIcon = ICON_EMPLOYEE_CONVERSATION_PLANNED_10;
                break;
            case self::EVALUATION_DONE:
                $statusIcon = ICON_EMPLOYEE_CONVERSATION_COMPLETED_10;
                break;
            case self::EVALUATION_CANCELLED:
                $statusIcon = ICON_EMPLOYEE_CONVERSATION_CANCELLED_10;
                break;
            case self::EVALUATION_NONE:
                $statusIcon = ICON_EMPLOYEE_CONVERSATION_NOT_INVITED_10;
            default:
                $statusIcon = NULL;
        }
        return $statusIcon;
    }
}

?>
