<?php


/**
 * Description of AssessmentProcessEvaluationStateConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/interface/state/AssessmentProcessEvaluationState.class.php');
require_once('modules/interface/converter/employee/competence/AssessmentEvaluationStatusConverter.class.php');

class AssessmentProcessEvaluationStateConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessEvaluationState::EVALUATION_NONE:
                $display = TXT_UCF('NO_ASSESSMENT_EVALUATION');
                break;
            case AssessmentProcessEvaluationState::EVALUATION_TODO:
                $display = TXT_UCF('ASSESSMENT_EVALUATION_PLANNED');
                break;
            case AssessmentProcessEvaluationState::EVALUATION_DONE:
                $display = AssessmentEvaluationStatusConverter::display(AssessmentEvaluationStatusValue::EVALUATION_DONE);
                break;
            case AssessmentProcessEvaluationState::EVALUATION_CANCELLED:
                $display = AssessmentEvaluationStatusConverter::display(AssessmentEvaluationStatusValue::EVALUATION_CANCELLED);
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
