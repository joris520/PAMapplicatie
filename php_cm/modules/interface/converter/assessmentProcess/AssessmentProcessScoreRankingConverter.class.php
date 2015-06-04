<?php


/**
 * Description of AssessmentProcessScoreRankingConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');

class AssessmentProcessScoreRankingConverter extends AbstractBaseConverter
{
    const MODE_SHOW_ALL         = 1;
    const MODE_HIDE_NO_RANKING  = 2;

    static function display($value, $displayMode = self::MODE_HIDE_NO_RANKING, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case AssessmentProcessScoreRankingValue::NO_RANKING:
                $display = $displayMode == self::MODE_SHOW_ALL ? TXT_UCF('PROCESS_SCORE_RANKING_NO') : $empty;
                break;
            case AssessmentProcessScoreRankingValue::RANKING_HIGH:
                $display = TXT_UCF('PROCESS_SCORE_RANKING_TOP');
                break;
            case AssessmentProcessScoreRankingValue::RANKING_DIFF:
                $display = TXT_UCF_VALUE(   'PROCESS_SCORE_RANKING_DIFF',
                                            array(APPLICATION_ASSESSMENT_SCORE_DIFF_TRESHOLD),
                                            array('%THRESHOLD%'));
                break;
            case AssessmentProcessScoreRankingValue::RANKING_LOW:
                $display = TXT_UCF('PROCESS_SCORE_RANKING_BOTTOM');
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
