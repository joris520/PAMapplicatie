<?php

/**
 * Description of BossFilterConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/model/value/list/BossFilterValue.class.php');


class BossFilterConverter extends AbstractBaseConverter
{
    const MODE_DISPLAY  = 1;
    const MODE_REPORT   = 2;

    static function display($value, $empty = '-', $mode = self::MODE_DISPLAY)
    {
        $display = $empty;
        switch($value) {
            case BossFilterValue::HAS_NO_BOSS:
                $display = TXT_LC('FILTER_WITHOUT_BOSS');
                break;
            case BossFilterValue::IS_BOSS:
                switch($mode) {
                    case self::MODE_REPORT:
                        $display = TXT_LC('ALL_EMPLOYEES');
                        break;
                    case self::MODE_DISPLAY:
                    default:
                        $display = TXT_LC('FILTER_BOSSES');
                        break;
                }
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
