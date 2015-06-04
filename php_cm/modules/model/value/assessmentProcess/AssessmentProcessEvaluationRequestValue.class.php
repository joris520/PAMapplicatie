<?php

/**
 * Description of AssessmentProcessEvaluationRequestValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentProcessEvaluationRequestValue extends BaseDatabaseValue
{
    const NOT_REQUESTED = 0;  // niet geselecteed voor gesprek
    const REQUESTED     = 1;  // gesprek geselecteerd

    static function values()
    {
        return array(
            AssessmentProcessEvaluationRequestValue::NOT_REQUESTED,
            AssessmentProcessEvaluationRequestValue::REQUESTED
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
