<?php

/**
 * Description of BooleanConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class BooleanConverter extends AbstractBaseConverter
{
    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case BooleanValue::FALSE:
                $display = TXT_UCF('NO');
                break;
            case BooleanValue::TRUE:
                $display = TXT_UCF('YES');
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
