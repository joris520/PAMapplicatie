<?php

/**
 * Description of AssessmentInvitationCompletedValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentInvitationCompletedValue extends BaseDatabaseValue
{
    // threesixty_invitations.completed
    // TODO: 0 voor niet uitgenodigd ivm lege queries; dus waarden hieronder +1
    const NOT_COMPLETED  = 0;
    const COMPLETED      = 1;
    const RESULT_DELETED = 2;

    static function values()
    {
        return array(
            AssessmentInvitationCompletedValue::NOT_COMPLETED,
            AssessmentInvitationCompletedValue::COMPLETED,
            AssessmentInvitationCompletedValue::RESULT_DELETED
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }

    static function isInvitationCompleted($value)
    {
        return $value > AssessmentInvitationCompletedValue::NOT_COMPLETED;
    }
}

?>
