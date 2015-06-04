<?php

/**
 * Description of NormValue
 *
 * @author ben.dokter
 */
require_once('modules/model/value/library/competence/ScoreValue.class.php');

class NormValue
{
    const NORM_Y  =  ScoreValue::SCORE_Y;
    const NORM_N  =  ScoreValue::SCORE_N;

    const MIN_NUM_NORM =  ScoreValue::MIN_NUM_SCORE;
    const MAX_NUM_NORM =  ScoreValue::MAX_NUM_SCORE;

    const NORM_1 =  ScoreValue::SCORE_1;
    const NORM_2 =  ScoreValue::SCORE_2;
    const NORM_3 =  ScoreValue::SCORE_3;
    const NORM_4 =  ScoreValue::SCORE_4;
    const NORM_5 =  ScoreValue::SCORE_5;

    static function values($scaleValue = ScaleValue::SCALE_1_5)
    {
        $values = array();
        switch($scaleValue) {
            case ScaleValue::SCALE_Y_N:
                $values = array(
                    ScoreValue::NORM_Y,
                    ScoreValue::NORM_N
                );
                break;
            case ScaleValue::SCALE_1_5:
                $values = array(
                    ScoreValue::NORM_1,
                    ScoreValue::NORM_2,
                    ScoreValue::NORM_3,
                    ScoreValue::NORM_4,
                    ScoreValue::NORM_5
                );
                break;
        }
        return $values;
    }

}

?>
