<?php

/**
 * Description of PdpCostConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/FloatConverter.class.php');

class PdpCostConverter extends FloatConverter
{

    static function display($value, $empty = '0.00')
    {
        return parent::display($value, $empty, self::KEEP_TRAILING_ZEROS);
    }

    static function input($value, $empty = '0.00')
    {
        return self::display($value, $empty, self::KEEP_TRAILING_ZEROS);
    }
}

?>
