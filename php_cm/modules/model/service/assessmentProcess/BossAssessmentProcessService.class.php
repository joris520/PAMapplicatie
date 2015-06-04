<?php

/**
 * Description of BossAssessmentProcessService
 *
 * @author ben.dokter
 *
 *
 *  processstappen:
 *  - 1) medewerkers uitnodigen voor zelfevaluatie
 *  - 2) afronden zelfevaluatie invullen.
 *  - 3) afronden selecteren functioneringsgesprekken of ongedaan maken 2)
 *  - 4) ongedaan maken 3)
 *
 */

require_once('modules/model/queries/assessmentProcess/BossAssessmentProcessQueries.class.php');
require_once('modules/model/valueobjects/assessmentProcess/BossAssessmentProcessValueObject.class.php');
require_once('modules/model/value/assessmentProcess/AssessmentProcessStatusValue.class.php');

// TODO: customer specific?
class BossAssessmentProcessService
{

    static function getValueObject( $bossId,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = BossAssessmentProcessQueries::getAssessmentProcessInPeriod($bossId,
                                                                            $assessmentCycle->getStartDate(),
                                                                            $assessmentCycle->getEndDate());
        $assessmentProcessData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return BossAssessmentProcessValueObject::createWithData($bossId, $assessmentProcessData);
    }

    static function updateValidated($bossId, $valueObject)
    {
        return BossAssessmentProcessQueries::insertAssessmentProcess(   $bossId,
                                                                        $valueObject->getAssessmentDate(),
                                                                        $valueObject->getAssessmentProcessStatus());
    }

    static function indicateNewSelfassessmentInvitation($bossId,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = self::getValueObject($bossId, $assessmentCycle);
        $processStatus = $valueObject->getAssessmentProcessStatus();
        if ($processStatus < AssessmentProcessStatusValue::INVITED ||
            $processStatus > AssessmentProcessStatusValue::EVALUATION_SELECTED) {

            $valueObject->setAssessmentDate( DateUtils::getCurrentDatabaseDate());
            $valueObject->setAssessmentProcessStatus( AssessmentProcessStatusValue::INVITED);
            self::updateValidated($bossId, $valueObject);
        }

        // TODO:
        // controlere employeeid?
        //
        //        $processStatus = $valueObject->getAssessmentProcessStatus();
    }


    // TODO: de eigenlijke acties...
    static function updateProcessStatus($bossId,
                                        $newProcessStatus,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = self::getValueObject($bossId, $assessmentCycle);

        $valueObject->setAssessmentDate( DateUtils::getCurrentDatabaseDate());
        $valueObject->setAssessmentProcessStatus( $newProcessStatus);
        self::updateValidated($bossId, $valueObject);
    }
}

?>
