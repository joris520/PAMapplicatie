<?php
/**
 * Description of ScaleConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class ScaleConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case ScaleValue::SCALE_Y_N:
                $display = TXT('Y_N');
                break;
            case ScaleValue::SCALE_1_5:
                $display = '1-5';
                break;
        }
        return $display;
    }

    static function input($value, $empty = '-')
    {
        return self::display($value, $empty);
    }


}

?>
