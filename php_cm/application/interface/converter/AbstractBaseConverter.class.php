<?php

/**
 * Description of AbstractBaseConverter
 *
 * @author ben.dokter
 */

abstract class AbstractBaseConverter
{

    const EMPTY_LABEL = '-';

    abstract static function display($value, $empty = self::EMPTY_LABEL);
    abstract static function input($value, $empty = self::EMPTY_LABEL);

    // default nooit iets terug geven
    static function description($value)
    {
       return $value ? NULL : NULL;
    }
}

?>
