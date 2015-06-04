<?php

/**
 * Description of AssessmentProcessStatusConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

require_once('modules/model/value/assessmentProcess/AssessmentProcessScoreRankingValue.class.php');

class AssessmentProcessStatusConverter extends AbstractBaseConverter
{
    
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessStatusValue::UNUSED:
                $display = TXT_UCF('PROCESS_STATE_MESSAGE_EMPLOYEES_NOT_INVITED');
                break;
            case AssessmentProcessStatusValue::INVITED:
                $display = TXT_UCF('PROCESS_STATE_MESSAGE_EMPLOYEES_ARE_INVITED');
                break;
            case AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED:
                $display = TXT_UCF('PROCESS_STATE_MESSAGE_SELFASSESSMENT_COMPLETED');
                break;
            case AssessmentProcessStatusValue::EVALUATION_SELECTED:
                $display = TXT_UCF('PROCESS_STATE_MESSAGE_EVALUATIONS_SELECTED');
                break;
            case AssessmentProcessStatusValue::EVALUATION_READY:
                $display = TXT_UCF('PROCESS_STATE_MESSAGE_EVALUATIONS_READY');
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
