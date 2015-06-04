<?php

/**
 * Description of AssessmentEvaluationStatusConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class AssessmentEvaluationStatusConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
//            case AssessmentEvaluationStatusValue::EVALUATION_NO:
//                $display = TXT_UCF('NO_ASSESSMENT_EVALUATION');
//                break;
            case AssessmentEvaluationStatusValue::EVALUATION_CANCELLED:
                $display = TXT_UCF('ASSESSMENT_EVALUATION_CANCELLED');
                break;
            case AssessmentEvaluationStatusValue::EVALUATION_DONE:
                $display = TXT_UCF('ASSESSMENT_EVALUATION_DONE');
                break;
        }
        return $display;
    }

    static function displayReport($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
//            case AssessmentEvaluationStatusValue::EVALUATION_NO:
//                $display = TXT_UCF('NO_ASSESSMENT_EVALUATION');
//                break;
            case AssessmentEvaluationStatusValue::EVALUATION_CANCELLED:
                $display = TXT_UCF('REPORT_ASSESSMENT_EVALUATION_CANCELLED');
                break;
            case AssessmentEvaluationStatusValue::EVALUATION_DONE:
                $display = TXT_UCF('REPORT_ASSESSMENT_EVALUATION_DONE');
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
