<?php

/**
 * Description of CategoryConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');

class CategoryConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        // De tekst van de knowledge skill staat standaard in Engels in de database
        switch($value) {
            case CategoryValue::JOB_SPECIFIC:
                $display = TXT_UCF('JOB_SPECIFIC');
                break;
            case CategoryValue::PERSONAL:
                $display= TXT_UCF('PERSONAL');
                break;
            case CategoryValue::MANAGERIAL:
                $display = TXT_UCF('MANAGERIAL');
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
