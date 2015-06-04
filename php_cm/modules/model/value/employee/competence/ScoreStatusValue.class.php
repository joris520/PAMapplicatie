<?php

/**
 * Description of ScoreStatusValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseDatabaseValue.class.php');

class ScoreStatusValue extends BaseDatabaseValue
{
	// was: employees_topics.score_status (0 en 1)
    // nu employee_assessment.score_status

    const NONE        = 0;

    const PRELIMINARY = 1;
    const FINALIZED   = 2;

    static function values()
    {
        return array(
            ScoreStatusValue::PRELIMINARY,
            ScoreStatusValue::FINALIZED
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
