<?php

/**
 * Description of AssessmentInvitationTypeValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentInvitationTypeValue extends BaseDatabaseValue
{
    // threesixty_invitations.is_self_evaluation (de waarden die aangeven of een 360 een zelfevaluatie is)
    const IS_360                = 0;
    const IS_SELF_EVALUATION    = 1;


    static function values()
    {
        return array(
            AssessmentInvitationTypeValue::IS_360,
            AssessmentInvitationTypeValue::IS_SELF_EVALUATION
            );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_REQUIRED);
    }
}

?>
