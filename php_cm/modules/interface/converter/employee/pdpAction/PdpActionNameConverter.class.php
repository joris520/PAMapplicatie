<?php

/**
 * Description of PdpActionNameConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class PdpActionNameConverter extends AbstractBaseConverter
{
    const INDICATOR_FROM_LIBRARY = '';
    const INDICATOR_USER_DEFINED = '*';

    static function display($value, $empty = '-', $isUserDefined = FALSE)
    {
        $display = $value . ($isUserDefined ? self::INDICATOR_USER_DEFINED : self::INDICATOR_FROM_LIBRARY);
        return $display;
    }

    static function title($isUserDefined)
    {
        return $isUserDefined ? TXT_UCF('USER_DEFINED_PDP_ACTION') : TXT_UCF('LIBRARY_PDP_ACTION');
    }

    static function input($value, $empty = '-')
    {
        return $value;
    }
}

?>
