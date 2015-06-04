<?php

/**
 * Description of ScoreStatusConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class ScoreStatusConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case ScoreStatusValue::PRELIMINARY:
                $display = TXT_UCF('SCORE_STATUS_PRELIMINARY');
                break;
            case ScoreStatusValue::FINALIZED:
                $display = TXT_UCF('SCORE_STATUS_FINAL');
                break;
        }
        return $display;
    }


    // default de display
    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }

    static function imageSrc($value)
    {
        $imageSrc   = ICON_EMPLOYEE_ASSESSMENT_NOT_INVITED_THIS_PERIOD;

        switch($value) {
            case ScoreStatusValue::PRELIMINARY:
                $imageSrc = ICON_EMPLOYEE_ASSESSMENT_NOT_COMPLETED;
                break;
            case ScoreStatusValue::FINALIZED:
                $imageSrc = ICON_EMPLOYEE_ASSESSMENT_COMPLETED;
                break;
        }

        return $imageSrc;
    }

    static function image($value)
    {
        $imageTitle = self::display($value);
        $imageSrc   = self::imageSrc($value);

        $iconView = AssessmentIconView::create($imageSrc, $imageTitle);
        return $iconView->fetchHtml();
    }

    static function displayImage($value)
    {
        $imageTitle = self::display($value);
        $imageSrc   = self::imageSrc($value);

        $iconView = AssessmentIconView::create($imageSrc, $imageTitle);
        return $iconView->fetchHtml() . '&nbsp;' . $imageTitle;
    }

}

?>
