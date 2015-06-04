<?php

/**
 * Description of AssessmentProcessBossActionValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseValue.class.php');

class AssessmentProcessBossActionValue extends BaseValue
{
    const NONE                                      = 0;
    const MARK_SELFASSESSMENT_DONE                  = 1;
    const UNDO_SELFASSESSMENT_DONE                  = 2;
    const MARK_SELECT_ASSESSMENT_EVALUATION_DONE    = 3;
    const UNDO_SELECT_ASSESSMENT_EVALUATION_DONE    = 4;

    static function values()
    {
        return array(
                    AssessmentProcessBossActionValue::MARK_SELFASSESSMENT_DONE,
                    AssessmentProcessBossActionValue::UNDO_SELFASSESSMENT_DONE,
                    AssessmentProcessBossActionValue::MARK_SELECT_ASSESSMENT_EVALUATION_DONE,
                    AssessmentProcessBossActionValue::UNDO_SELECT_ASSESSMENT_EVALUATION_DONE
                    );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_OPTIONAL);
    }

}

?>
