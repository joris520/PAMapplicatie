<?php

class NumberConverter
{
    static function display($value, $empty = '-')
    {
        return empty($value) ? $empty : '' . $value . '';
    }


    static function input($value, $empty = '0')
    {
        return self::display($value, $empty);
    }

    static function conditional($value, $additionalText, $tooltip)
    {
        return empty($value) ? '' : '<span title="' . $tooltip . '">  /' . $value . $additionalText . '</span>';

    }
}

?>
