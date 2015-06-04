<?php

/**
 * Description of AssessmentProcessScoreRankingValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentProcessScoreRankingValue extends BaseDatabaseValue
{
    const NO_RANKING    = 0;
    const RANKING_HIGH  = 1;
    const RANKING_DIFF  = 2;
    const RANKING_LOW   = 3;

    static function values()
    {
        return array(
            AssessmentProcessScoreRankingValue::RANKING_HIGH,
            AssessmentProcessScoreRankingValue::RANKING_DIFF,
            AssessmentProcessScoreRankingValue::RANKING_LOW
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_OPTIONAL);
    }

}

?>
