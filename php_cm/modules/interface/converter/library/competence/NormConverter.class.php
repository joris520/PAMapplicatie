<?php

/**
 * Description of NormConverter
 *
 * @author ben.dokter
 */

require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');

class NormConverter extends ScoreConverter
{

    static function display($value, $length = NULL, $empty = '-')
    {
        return ScoreConverter::display($value, $length, $empty);
    }

    static function input($value, $empty = NULL)
    {
        return ScoreConverter::input($value, $empty);
    }


    static function description($value)
    {
        return ScoreConverter::scoreDescription($value);
    }
}

?>
