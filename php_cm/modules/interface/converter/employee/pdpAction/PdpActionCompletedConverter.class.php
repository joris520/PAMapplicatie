<?php

/**
 * Description of PdpActionCompletedConverter
 *
 * @author ben.dokter
 */

require_once('application/interface/converter/AbstractBaseConverter.class.php');
require_once('modules/model/value/employee/pdpAction/PdpActionCompletedStatusValue.class.php');

class PdpActionCompletedConverter extends AbstractBaseConverter
{

    static function display($value, $empty = '-')
    {
        $display = $empty;
        switch($value) {
            case PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED:
                $display = TXT_UCF('NOT_COMPLETED_EXPIRED');
                break;
            case PdpActionCompletedStatusValue::NOT_COMPLETED:
                $display = TXT_UCF('NOT_COMPLETED');
                break;
            case PdpActionCompletedStatusValue::COMPLETED:
                $display = TXT_UCF('COMPLETED');
                break;
            case PdpActionCompletedStatusValue::CANCELLED:
                $display = TXT_UCF('CANCELLED');
                break;
        }
        return $display;
    }

    // default de display
    static function input($value, $empty = '-')
    {
        $input = $empty;
        switch($value) {
            case PdpActionCompletedStatusValue::NOT_COMPLETED:
                $input = TXT_UCF('NO');
                break;
            case PdpActionCompletedStatusValue::COMPLETED:
                $input = TXT_UCF('YES');
                break;
            case PdpActionCompletedStatusValue::CANCELLED:
                $input = TXT_UCF('CANCELLED');
                break;
        }
        return $input;
    }

    static function image($value)
    {
        $imageTitle = self::display($value);

        if ($value == PdpActionCompletedStatusValue::COMPLETED) {
            $image = '<img src="images/green.jpg"  width="11" height="10" title="' . $imageTitle . '">&nbsp;' . $imageTitle;
        } else {
            $image = $imageTitle;
        }

        return $image;
    }


}

?>
