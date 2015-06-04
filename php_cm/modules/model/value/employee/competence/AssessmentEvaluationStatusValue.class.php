<?php

/**
 * Description of AssessmentEvaluationStatusValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentEvaluationStatusValue extends BaseDatabaseValue
{
    // employees_topics.assessment_evaluation_status (bij AssessmentProcessStatusValue::EVALUATION_SELECTED)

    const EVALUATION_NO                     = 0;
    const EVALUATION_NOT_DONE_DEPRECATED    = 1;    // geselecteerd voor gesprek, nog niet gedaan.
    const EVALUATION_CANCELLED              = 33;   // gesprek vervallen (bij requested=AssessmentProcessEvaluationRequestValue::REQUESTED
    const EVALUATION_DONE                   = 42;   // gesprek gedaan, kan altijd(?)

    static function values()
    {
        return array(
            self::EVALUATION_DONE,
            self::EVALUATION_CANCELLED
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
