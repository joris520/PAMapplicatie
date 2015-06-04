<?php

/**
 * Description of EmployeeFteConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('application/interface/converter/FloatConverter.class.php');

class EmployeeFteConverter extends FloatConverter
{

    static function display($value, $empty = '-')
    {
        return parent::display($value, $empty, FloatConverter::TRIM_TRAILING_ZEROS);
    }

    static function input($value, $empty = '')
    {
        return self::display($value, $empty, self::TRIM_TRAILING_ZEROS);
    }

}

?>
