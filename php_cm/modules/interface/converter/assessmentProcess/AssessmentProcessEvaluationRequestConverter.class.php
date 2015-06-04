<?php

/**
 * Description of AssessmentProcessEvaluationRequestConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

require_once('modules/model/value/assessmentProcess/AssessmentProcessEvaluationRequestValue.class.php');

class AssessmentProcessEvaluationRequestConverter extends AbstractBaseConverter
{
    const MODE_SHOW_ALL         = 1;
    const MODE_HIDE_NO_RANKING  = 2;

    static function display($value, $displayMode = self::MODE_HIDE_NO_RANKING, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessEvaluationRequestValue::NOT_REQUESTED:
                $display = $displayMode == self::MODE_SHOW_ALL ? TXT_UCF('ASSESSMENT_EVALUATION_NOT_REQUESTED') : $empty;
                break;
            case AssessmentProcessEvaluationRequestValue::REQUESTED:
                $display = TXT_UCF('ASSESSMENT_EVALUATION_REQUESTED');
                break;
        }
        return $display;
    }

    static function displayReport($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessEvaluationRequestValue::NOT_REQUESTED:
                $display = TXT_UCF('REPORT_ASSESSMENT_EVALUATION_NOT_REQUESTED');
                break;
            case AssessmentProcessEvaluationRequestValue::REQUESTED:
                $display = TXT_UCF('REPORT_ASSESSMENT_EVALUATION_REQUESTED');
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
