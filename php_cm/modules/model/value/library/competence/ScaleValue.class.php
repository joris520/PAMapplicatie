<?php

/**
 * Description of ScaleValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseDatabaseValue.class.php');

class ScaleValue extends BaseDatabaseValue
{
    // knowledge_skills_points.scale
    const SCALE_Y_N = 'Y/N';
    const SCALE_1_5 = '1-5'; // als je soms een controle op -4 in de code ziet dan is deze scale niet als string behandeld :-)


    static function values()
    {
        return array(
            ScaleValue::SCALE_Y_N,
            ScaleValue::SCALE_1_5
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
