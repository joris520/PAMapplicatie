<?php

/**
 * Description of AssessmentProcessStatusValue
 *
 * @author ben.dokter
 */

require_once('application/model/value/BaseDatabaseValue.class.php');

class AssessmentProcessStatusValue extends BaseDatabaseValue
{

    const UNUSED                    =  0;
    const INVITED                   = 10;  // uitgenodigd voor invullen zelfevaluatie
    const SELFASSESSMENT_COMPLETED  = 20;  // zelfevaluatie niet meer in te vullen, scores berekend en gesprek uitnodinging aangevinkbaar
    const EVALUATION_SELECTED       = 30;  // gesprekken geselecteerd of tevredenheidsbrief.
    const EVALUATION_READY          = 40;  // evaluatieproces afgerond (tevredenheidsbrief kan nu gestuurd worden?)

    // voor de filtering die op een aantal plaatsen is toegepast:
    const GET_ALL_PROCESS_STATES    = NULL;

    static function values()
    {
        return array(
                    AssessmentProcessStatusValue::INVITED,
                    AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                    AssessmentProcessStatusValue::EVALUATION_SELECTED,
                    AssessmentProcessStatusValue::EVALUATION_READY
                    );
    }

    static function isValidValue($value)
    {
        return self::isAllowedValue($value, self::values(), BaseDatabaseValue::VALUE_OPTIONAL);
    }


}

?>
