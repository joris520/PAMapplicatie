<?php

/**
 * Description of EmployeeScoreService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/employee/competence/EmployeeCompetenceQueries.class.php');
require_once('modules/model/queries/employee/competence/EmployeeScoreQueries.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeScoreValueObject.class.php');


class EmployeeScoreService
{
    // todo: of medewerker/leidinggevende score mag zien oplossen met iets als $isAllowedViewScore,
    static function getValueObject( $employeeId,
                                    $competenceId,
                                    //$isAllowedViewScore,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = EmployeeScoreQueries::getScoreInPeriod($employeeId,
                                                        $competenceId,
                                                        $assessmentCycle->getStartDate(),
                                                        $assessmentCycle->getEndDate());

        $competenceScoreData = mysql_fetch_assoc($query);

        mysql_free_result($query);
        return EmployeeScoreValueObject::createWithData($employeeId,
                                                        $competenceId,
                                                        $competenceScoreData);
    }

    static function getValueObjects($employeeId, $competenceId)
    {
        $valueObjects = array();

        $query = EmployeeScoreQueries::getScores(   $employeeId,
                                                    $competenceId);
        while ($competenceScoreData = mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeScoreValueObject::createWithData( $employeeId,
                                                                        $competenceId,
                                                                        $competenceScoreData);
        }

        mysql_free_result($query);

        return $valueObjects;
    }

    static function validateScore(  EmployeeScoreValueObject $valueObject,
                                    $competenceName,
                                    $scale,
                                    $optional)
    {
        $hasError = false;
        $messages = array();

        $score = $valueObject->getScore();
        if (!ScoreValue::isValidScore($score, $scale, ($optional ? BaseDatabaseValue::VALUE_OPTIONAL: BaseDatabaseValue::VALUE_REQUIRED))) {
            $hasError = true;
            $messages[] =  '- ' . $competenceName;
        }
        return array($hasError, $messages);
    }


    static function updateValidated($employeeId,
                                    EmployeeScoreValueObject $valueObject)
    {
        $storeScore = $valueObject->score == ScoreValue::INPUT_SCORE_NA ? '' : $valueObject->getScore();
        return EmployeeScoreQueries::insertScore(   $employeeId,
                                                    $valueObject->getCompetenceId(),
                                                    $storeScore,
                                                    $valueObject->getNote());
    }


}

?>
