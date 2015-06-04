<?php

/**
 * Description of AssessmentInvitationStatusValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentInvitationStatusValue extends BaseDatabaseValue
{

    // threesixty_invitations.threesixty_scores_status
    const CURRENT       =  0;
    const CLOSED        =  1; // close: +1; unclose: -1
    const HISTORICAL    = 10; // er is altijd maar 1 "current"


    static function values()
    {
        return array(
            AssessmentInvitationStatusValue::CURRENT,
            AssessmentInvitationStatusValue::CLOSED,
            AssessmentInvitationStatusValue::HISTORICAL
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
