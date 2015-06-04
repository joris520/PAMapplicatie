<?php

/**
 * Description of PamExceptionCodeValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseValue.class.php');

class PamExceptionCodeValue extends BaseValue
{
    const UNDEFINED                 = 0;
    const SQL_ERROR                 = 1;
    const SAFEFORM_FINALIZE_ERROR   = 2;
    const SAFEFORM_ERROR            = 3;
    const SAFEFORM_FORM_REQUEST     = 4;
    const WARNING_HANDLER           = 5;
    const ERROR_HANDLER             = 6;
    const LANGUAGE_INCOMPLETE       = 7;

    static function values()
    {
        return array(
            PamExceptionCodeValue::UNDEFINED,
            PamExceptionCodeValue::SQL_ERROR,
            PamExceptionCodeValue::SAFEFORM_FINALIZE_ERROR,
            PamExceptionCodeValue::SAFEFORM_ERROR,
            PamExceptionCodeValue::SAFEFORM_FORM_REQUEST,
            PamExceptionCodeValue::WARNING_HANDLER,
            PamExceptionCodeValue::ERROR_HANDLER,
            PamExceptionCodeValue::LANGUAGE_INCOMPLETE
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
