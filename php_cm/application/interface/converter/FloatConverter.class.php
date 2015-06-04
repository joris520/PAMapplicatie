<?php

/**
 * Description of FloatConverter
 *
 * @author ben.dokter
 */
require_once('application/interface/converter/AbstractBaseConverter.class.php');

class FloatConverter extends AbstractBaseConverter
{
    const KEEP_TRAILING_ZEROS = TRUE;
    const TRIM_TRAILING_ZEROS = FALSE;

    const TRAILING_DIGITS = 2;
    const FLOAT_DECIMAL_SEPERATOR = '.';
    const ENGLISH_DECIMAL_SEPERATOR = '.';
    const DUTCH_DECIMAL_SEPERATOR = ',';
    const DEFAULT_THOUSANDS_SEPERATOR = '';

    static function display($value, $empty = '-', $handleTrailingZeros = self::TRIM_TRAILING_ZEROS)
    {
        $display = $empty;
        if (!empty($value)) {
            $number = floatval($value);
            $decimal_seperator = self::getDecimalSeperator();
            $number = number_format ($number, self::TRAILING_DIGITS, $decimal_seperator, self::DEFAULT_THOUSANDS_SEPERATOR);

            if ($handleTrailingZeros == self::TRIM_TRAILING_ZEROS) {
                $display = rtrim($number, '.,0');
            } else {
                $display = $number;
            }
            // de display kan leeg geworden zijn door de rtrim
            if (empty($display)) {
                $display = $empty;
            }
        }
        return $display;
    }

    private static function getDecimalSeperator()
    {
        switch(LANG_ID) {
            // "nederlandse varianten met ,
            case LanguageValue::LANG_ID_NL:
            case LanguageValue::LANG_ID_EVC:
                $decimal_seperator = self::DUTCH_DECIMAL_SEPERATOR;
                break;
            default:
                $decimal_seperator = self::ENGLISH_DECIMAL_SEPERATOR;
                break;
        }
        return $decimal_seperator;
    }

    private static function processSeperators($input)
    {
        if (strstr($input, self::DUTCH_DECIMAL_SEPERATOR)) {
            $input = str_replace('.', '', $input);   // zonder duizend .
        }
        $input = str_replace(',', '.', $input);  // numerieke notatie is met decimale punt
        return $input;
    }

    static function isValidNumber($value)
    {
        $number = self::processSeperators($value);
        return is_numeric($number);
    }

    static function input($value, $empty = '0')
    {
        return self::display($value, $empty, self::KEEP_TRAILING_ZEROS);
    }

    // hier gaan we er van uit dat er al een isValidNumber is gedaan
    static function value($input)
    {
        $input = self::processSeperators($input);
        $number = number_format($input, self::TRAILING_DIGITS, self::FLOAT_DECIMAL_SEPERATOR, self::DEFAULT_THOUSANDS_SEPERATOR);
        return floatval($number);
    }

}

?>
