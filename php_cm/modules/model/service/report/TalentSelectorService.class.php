<?php

/**
 * Description of TalentSelectorService
 *
 * @author hans.prins
 */

require_once('modules/model/queries/employee/competence/EmployeeScoreQueries.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorValueObject.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorCompetenceValueObject.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorRequestedValueObject.class.php');

class TalentSelectorService
{

    static function validate($valueObjects)
    {
        $hasError = false;
        $messages = array();

        if (count($valueObjects) < 1) {
            $hasError = true;
            $messages[] = TXT_UCF('NO_CRITERIA_DEFINED');
        }

        foreach($valueObjects as $valueObject) {

            $operator = $valueObject->getOperator();
            $score    = $valueObject->getScore();

            if (!OperatorValue::isValidValue($operator)) {
                $hasError = true;
                $messages[] = $valueObject->getCompetenceName() . ': ' . TXT_LC('INVALID_OPERATOR');
            }

            if (!scoreValue::isValidValue($score, ScaleValue::SCALE_Y_N) &&
                !scoreValue::isValidValue($score, ScaleValue::SCALE_1_5)) {
                $hasError = true;
                $messages[] = $valueObject->getCompetenceName() . ': ' . TXT_LC('INVALID_SCORE');
            }

        }

        return array($hasError, $messages);
    }

    static function matchEmployeeWithScore($employeeId,
                                           TalentSelectorRequestedValueObject $requestedValueObject,
                                           AssessmentCycleValueObject $assessmentCycle)
    {
        $hasMatch    = false;
        $valueObject = NULL;

        $competenceId   = $requestedValueObject->getCompetenceId();
        $operator       = $requestedValueObject->getOperator();
        $requestedScore = $requestedValueObject->getScore();

        $query     = EmployeeScoreQueries::getScoreInPeriodFiltered($employeeId,
                                                                    $competenceId,
                                                                    $operator,
                                                                    $requestedScore,
                                                                    $assessmentCycle->getStartDate(),
                                                                    $assessmentCycle->getEndDate());
        $scoreData = @mysql_fetch_assoc($query);

        if (!empty($scoreData)){
            $hasMatch = true;
            $valueObject =  TalentSelectorValueObject::createWithValues($employeeId, $scoreData['employee'], $scoreData['score']);
        }

        mysql_free_result($query);

        return $valueObject;
    }

    static function getCompetenceObject($requestedCompetence)
    {
        $valueObject = TalentSelectorCompetenceValueObject::createWithData($requestedCompetence);
        return $valueObject;
    }

    static function hasEmployeesMatchingAllCompetences($employeesCompetencesMatches, $competenceCount)
    {
        return self::countEmployeesMatchingWithAllCompetences($competenceCount, $employeesCompetencesMatches) > 0;
    }

    static function countEmployeesMatchingWithAllCompetences($competenceCount, $employeesCompetencesMatches)
    {
        $employeeCount = 0;
        foreach ($employeesCompetencesMatches as $employeesCompetencesMatch) {
            if ($employeesCompetencesMatch == $competenceCount) {
                $employeeCount++;
            }
        }
        return $employeeCount;
    }
}

?>
