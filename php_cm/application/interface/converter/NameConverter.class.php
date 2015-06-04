<?php

/**
 * Description of NameConverter
 *
 * @author ben.dokter
 */

class NameConverter
{
    static function display($value, $empty = '-')
    {
        return empty($value) ? $empty : '' . $value . '';
    }

    static function input($value, $empty = '0')
    {
        return self::display($value, $empty);
    }
}

?>
