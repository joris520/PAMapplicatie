<?php

/**
 * Description of TalentSelectorController
 *
 * @author hans.prins
 */

require_once('modules/model/service/report/TalentSelectorService.class.php');

require_once('modules/model/valueobjects/report/TalentSelectorResultCollection.class.php');

class TalentSelectorController
{
    static function processExecute( /* array of TalentSelectorRequestedValueObject*/ $valueObjects,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $hasError = false;
        $messages = array();

        $requestedCount = count($valueObjects);

        $resultCollection = TalentSelectorResultCollection::create($requestedCount);

        list($hasError, $messages) = TalentSelectorService::validate($valueObjects);

        if (!$hasError) {

            $allowedEmployees = EmployeeSelectService::getAllAllowedEmployeeIds(EmployeeSelectService::RETURN_AS_ARRAY);

            foreach($valueObjects as $valueObject) {

                $competenceId = $valueObject->getCompetenceId();
                $resultObject = TalentSelectorResultValueObject::createWithValueObject($competenceId, $valueObject);
                foreach ($allowedEmployees as $employeeId) {

                    $scoreObject = TalentSelectorService::matchEmployeeWithScore($employeeId, $valueObject, $assessmentCycle);

                    if (!is_null($scoreObject)) {
                        $resultObject->addScoreObject($scoreObject);
                        $resultCollection->addMatchForEmployee($employeeId);
                    }
                }
                $resultCollection->addResultObject($resultObject);
            }

            $hasResult = $resultCollection->hasMatches() &&
                         TalentSelectorService::hasEmployeesMatchingAllCompetences($resultCollection->getEmployeesMatchCount(), $requestedCount);

            if (!$hasResult) {
                $hasError = true;
                $messages[] = TXT_UCF('NO_EMPLOYEE_MATCH_THE_CRITERIA_DEFINED');
            }

        }

        return array($hasError, $messages, $resultCollection);
    }
}

?>
