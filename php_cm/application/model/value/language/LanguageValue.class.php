<?php

/**
 * Description of LanguageValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class LanguageValue extends BaseDatabaseValue
{
    // languages.lang_id
    const LANG_ID_EN = 1;
    const LANG_ID_NL = 2;
    const LANG_ID_EVC =3;

    static function values()
    {
        return array(
            LanguageValue::LANG_ID_EN,
            LanguageValue::LANG_ID_NL,
            LanguageValue::LANG_ID_EVC
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
