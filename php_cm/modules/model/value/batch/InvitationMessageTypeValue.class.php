<?php

/**
 * Description of InvitationMessageTypeValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class InvitationMessageTypeValue extends BaseDatabaseValue
{
    // threesixty_invitations_messages.message type
    const INVITATION   = 0;
    const REMINDER     = 1;
    const LOS          = 10;

    static function values()
    {
        return array(
            InvitationMessageTypeValue::INVITATION,
            InvitationMessageTypeValue::REMINDER,
            InvitationMessageTypeValue::LOS
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

}

?>
