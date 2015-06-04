<?php

/**
 * Description of PermissionValue
 *
 * @author ben.dokter
 */
require_once('application/model/value/BaseValue.class.php');

class PermissionValue extends BaseValue
{
    // module_access.permission
    const NO_ACCESS         = 0;
    const VIEW_ACCESS       = 1;
    const EDIT_ACCESS       = 2;
    const ADD_DELETE_ACCESS = 3;

    static function values()
    {
        return array(
            PermissionValue::NO_ACCESS,
            PermissionValue::VIEW_ACCESS,
            PermissionValue::EDIT_ACCESS,
            PermissionValue::ADD_DELETE_ACCESS
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
