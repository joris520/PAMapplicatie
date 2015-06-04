<?php

/**
 * Description of TotalScoreConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class TotalScoreConverter extends AbstractBaseConverter
{

    const NOT_ALLOWED_DISPLAY_SCORE = '!';

    static function display($score, $length = NULL, $empty = '-')
    {
        $display = $empty;
        if (!empty($score)) {
//            if (CUSTOMER_OPTION_SHOW_SCORE_AS_NORM_TEXT) {
                $display = self::scoreDescription($score, $empty);
//            } else {
//                $display = self::scoreText($score, $empty);
//            }
        }
        return empty($length) ? $display : substr($display, 0, $length);
    }

    static function input($score, $empty = NULL)
    {
        return self::scoreText($score, empty($empty) ? TXT('NA') : $empty);
    }

    static function description($score, $empty = NULL)
    {
        return self::scoreDescription($score, empty($empty) ? TXT('NA') : $empty);
    }

//    static function tooltipTitle($score, $empty = NULL)
//    {
//        $empty = is_null($empty) ? (is_null($score) ? TXT_UCF('COMPENTENCE_SELF_ASSESSMENT_SCORE_NOT_REQUESTED') : TXT_UCF('COMPENTENCE_SELF_ASSESSMENT_SCORE_NOT_COMPLETED')) : '$empty';
//        return self::display($score, NULL, $empty);
//    }
//

    static function scoreInScale($score, $scale)
    {
        $scoreInScale = NULL;
        switch ($scale) {
            case ScaleValue::SCALE_Y_N:
                if ($score >= 1 && $score <= 5) {
                    $scoreInScale = ($score > 3) ? ScoreValue::SCORE_Y : ScoreValue::SCORE_N;
                }
                break;
            case ScaleValue::SCALE_1_5:
                if ($score >= 1 && $score <= 5) {
                    $scoreInScale = $score;
                }
        }
        return $scoreInScale;
    }

    static function numeric($score)
    {
        $numeric = NULL;
        if (!empty($score)) {
            if ($score == 'Y') {
                $numeric = 5;
            } elseif ($score == 'N') {
                $numeric = 1;
            } else {
                if ($score >= 1 && $score <= 5) {
                    $numeric = $score;
                }
            }
        }
        return $numeric;
    }

    // "protected" functies
    static function scoreText($score, $empty = '-')
    {
        $scoreText = $empty;
        if (!empty($score)) {
            if ($score == 'Y') {
                $scoreText = TXT_UCF('YES');
            } elseif ($score == 'N') {
                $scoreText = TXT_UCF('NO');
            } else {
                if ($score >= 1 && $score <= 5) {
                    $scoreText = $score;
                } else {
//                    if ($score_point == 0) {
//                        $score_point_text = TXT('NA');
//                    }
                }
            }
        }
        return $scoreText;
    }

    //
    static function employeeScoreText($score, $isAllowed = TRUE, $empty = '-')
    {
        $scoreText = $isAllowed ? $empty : (is_null($score) ? $empty : self::NOT_ALLOWED_DISPLAY_SCORE);
        if ($isAllowed && !empty($score)) {
            if ($score == 'Y') {
                $scoreText = TXT_UCF('YES');
            } elseif ($score == 'N') {
                $scoreText = TXT_UCF('NO');
            } else {
                if ($score >= 1 && $score <= 5) {
                    $scoreText = $score;
                } else {
//                    if ($score_point == 0) {
//                        $score_point_text = TXT('NA');
//                    }
                }
            }
        }
        return $scoreText;
    }

    protected static function scoreDescription($score)
    {
        $description = '';

        switch ($score) {
            case '1':
                $description = FINAL_SCALE_NONE;
                break;
            case '2':
                $description = FINAL_SCALE_BASIC;
                break;
            case '3':
                $description = FINAL_SCALE_AVERAGE;
                break;
            case '4':
                $description = FINAL_SCALE_GOOD;
                break;
            case '5':
                $description = FINAL_SCALE_SPECIALIST;
                break;
            case 'N':
                $description = FINAL_SCALE_NO;
                break;
            case 'Y':
                $description = FINAL_SCALE_YES;
                break;
        }

        return $description;
    }



}

?>
