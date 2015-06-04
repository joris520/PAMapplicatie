<?php
/**
 * Description of NumberUtils.
 *
 * @author mendel.van.t.riet
 */
class NumberUtils {

    static function convertFloat($number, $language_id) {
        $number = floatval($number);
        if ($language_id == 2 || $language_id == 3) { //dutch
            $number = number_format ($number, 2, ',' , '.');
        } else { //english
            $number = number_format ($number, 2);
        }
//        return floatval($number);
        return rtrim($number, '.,0');
    }


}

?>
