<?php

/**
 * Description of InvitationStatusValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class InvitationStatusValue extends BaseValue
{
    const INVITED               = 1;
    const REINVITED             = 2;
    const REMINDED_1            = 11;
    const REMINDED_2            = 12;
    const NOT_REMINDED          = 13;
    const INVALID_EMAIL_ADDRESS = 20;
    const NO_COMPETENCES        = 21;

    static function values()
    {
        return array(
            InvitationStatusValue::INVITED,
            InvitationStatusValue::REINVITED,
            InvitationStatusValue::REMINDED_1,
            InvitationStatusValue::REMINDED_2,
            InvitationStatusValue::NOT_REMINDED,
            InvitationStatusValue::INVALID_EMAIL_ADDRESS,
            InvitationStatusValue::NO_COMPETENCES
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseValue::VALUE_REQUIRED);
    }

}

?>
