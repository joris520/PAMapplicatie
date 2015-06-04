<?php

/**
 * Description of FinalResultReportService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/report/FinalScoreReportQueries.class.php');
require_once('modules/model/valueobjects/report/FinalResultDashboardCollection.class.php');
require_once('modules/model/valueobjects/report/FinalResultDashboardValueObject.class.php');

class FinalResultReportService
{
    static function getDashboardCollection( Array $bossIdValues,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $keyIdValues = EmployeeFinalResultService::getTotalScoreIdValues();
        $dashboardCollection = FinalResultDashboardCollection::create($keyIdValues);

        // per leidinggevenden de medewerkers ophalen
        foreach($bossIdValues as $bossIdValue) {
            $bossId = $bossIdValue->getDatabaseId();
            $bossName = $bossIdValue->getValue();
            $valueObject = self::getDashboardCountForBoss(  $bossId,
                                                            $bossName,
                                                            $assessmentCycle);
            if ($valueObject->getEmployeesTotal() > 0) {
                $dashboardCollection->addValueObject($valueObject);
            }
        }
        return $dashboardCollection;
    }

    private static function getDashboardCountForBoss(   $bossId,
                                                        $bossName,
                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = FinalResultDashboardValueObject::create($bossId, $bossName);

        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_STRING);
        if (!empty($allowedEmployeeIds)) {
            $query = FinalScoreReportQueries::getFinalScoreCount(   $allowedEmployeeIds,
                                                                    $assessmentCycle->getStartDate(),
                                                                    $assessmentCycle->getEndDate());
            while($reportCountData = mysql_fetch_assoc($query)) {
                $employeeCount = $reportCountData['employee_count'];
                $score = $reportCountData['total_score'];
                $valueObject->addEmployeesTotal($employeeCount);
                $score = empty($score) ? ScoreValue::INPUT_SCORE_NA : $score;
                $valueObject->addEmployeeCountForKey($score, $employeeCount);
            }
            mysql_free_result($query);
        }

        return $valueObject;
    }

    static function getEmployeeIdsWithScore(    $bossId,
                                                $scoreId,
                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId,
                                                                        EmployeeSelectService::RETURN_AS_STRING);
        if (!empty($allowedEmployeeIds)) {
            $queryScoreId = FinalResultDashboardCountValueObject::isNotAssessedScoreId($scoreId) ? NULL : $scoreId;
            $query = FinalScoreReportQueries::getFinalScoreEmployeesWithScore(  $queryScoreId,
                                                                                $allowedEmployeeIds,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate());

            $employeeIds = array();
            while($reportEmployeeIdData = mysql_fetch_assoc($query)) {
                $employeeId = $reportEmployeeIdData['ID_E'];
                if (!empty($employeeId)) {
                    $employeeIds[] = $employeeId;
                }
            }
            mysql_free_result($query);
        }

        return implode(',',$employeeIds);
    }

}

?>
