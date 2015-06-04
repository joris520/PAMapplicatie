<?php

/**
 * Description of ScoreValue
 *
 * @author ben.dokter
 */
require_once('modules/model/value/library/competence/ScaleValue.class.php');
require_once('application/model/value/BaseDatabaseValue.class.php');

class ScoreValue extends BaseDatabaseValue
{
    // employees_points.scale (=score op competentie)
    const SCORE_NA = '';
    const SCORE_Y  = 'Y';
    const SCORE_N  = 'N';

    const MIN_NUM_SCORE = 1;
    const MAX_NUM_SCORE = 5;

    const SCORE_1 = '1';
    const SCORE_2 = '2';
    const SCORE_3 = '3';
    const SCORE_4 = '4';
    const SCORE_5 = '5';

    // rare eend in de bijt, en dit moet eigenlijk de database waarde zijn voor NA...
    const INPUT_SCORE_NA = 'NA';

    static function values($scaleValue = ScaleValue::SCALE_1_5, $requiredState = BaseDatabaseValue::VALUE_OPTIONAL)
    {
        $values = array();
        switch($scaleValue) {
            case ScaleValue::SCALE_Y_N:
                $values = array(
                    ScoreValue::SCORE_Y,
                    ScoreValue::SCORE_N
                );
                if ($requiredState == BaseDatabaseValue::VALUE_OPTIONAL) {
                    $values[] = ScoreValue::INPUT_SCORE_NA;
                }
                break;
            case ScaleValue::SCALE_1_5:
                $values = array(
                    ScoreValue::SCORE_1,
                    ScoreValue::SCORE_2,
                    ScoreValue::SCORE_3,
                    ScoreValue::SCORE_4,
                    ScoreValue::SCORE_5
                );
                if ($requiredState == BaseDatabaseValue::VALUE_OPTIONAL) {
                    $values[] = ScoreValue::INPUT_SCORE_NA;
                }
                break;
        }
        return $values;
    }

    static function isValidValue($value, $scaleValue = ScaleValue::SCALE_1_5) {
        return self::isValidScore($value, $scaleValue);
    }

    static function isValidScore($score, $scaleValue = ScaleValue::SCALE_1_5, $requiredState = BaseDatabaseValue::VALUE_REQUIRED)
    {
        return self::isAllowedValue($score, self::values($scaleValue, $requiredState), $requiredState);
    }

}

?>
