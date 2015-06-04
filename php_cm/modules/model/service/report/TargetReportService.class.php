<?php

/**
 * Description of TargetReportService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/TargetDashboardCollection.class.php');
require_once('modules/model/valueobjects/report/TargetDashboardValueObject.class.php');

require_once('modules/model/queries/report/TargetReportQueries.class.php');

require_once('modules/model/value/employee/target/EmployeeTargetStatusValue.class.php');

class TargetReportService
{
    static function getDashboardCollection( Array $bossIdValues,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $keyIdValues = self::getStatusIdValues();
        $dashboardCollection = TargetDashboardCollection::create($keyIdValues);

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
        $valueObject = TargetDashboardValueObject::create(  $bossId,
                                                            $bossName);

        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId);

        $employeeCount = count($allowedEmployeeIds);
        $valueObject->addEmployeesTotal($employeeCount);

        if ($employeeCount > 0) {
            $query = TargetReportQueries::getTargetCount(   implode(',', $allowedEmployeeIds),
                                                            $assessmentCycle->getStartDate(),
                                                            $assessmentCycle->getEndDate());
            while($reportCountData = mysql_fetch_assoc($query)) {
                $statusCount = $reportCountData['status_count'];
                $employeeCount = $reportCountData['unique_employees'];
                $hasTarget = $reportCountData['has_target'];
                $targetStatus = $reportCountData['target_status'];

                if ($hasTarget) { // het aantal medewerkers zonder POP actie
                    $valueObject->addEmployeeCountForKey($targetStatus, $statusCount);
                } else {
                    $valueObject->addEmployeesWithout($employeeCount);
                }
            }
            mysql_free_result($query);
        }

        return $valueObject;
    }

    static function getStatusIdValues()
    {
        $values = EmployeeTargetStatusValue::values(EmployeeTargetStatusValue::REPORT_MODE);

        $statusIdValues = array();
        foreach($values as $value) {
            $statusIdValues[] = IdValue::create($value, EmployeeTargetStatusConverter::display($value));
        }
        return $statusIdValues;
    }


    static function getEmployeeIdValuesWithStatus(  $bossId,
                                                    $targetStatus,
                                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId,
                                                                        EmployeeSelectService::RETURN_AS_STRING);
        if (!empty($allowedEmployeeIds)) {
            $query = TargetReportQueries::getEmployeesWithTargetStatus(  $targetStatus,
                                                                         $allowedEmployeeIds,
                                                                         $assessmentCycle->getStartDate(),
                                                                         $assessmentCycle->getEndDate());

            $employeeIdValues = array();
            while($reportEmployeeIdData = mysql_fetch_assoc($query)) {
                $employeeIdValues[$reportEmployeeIdData['ID_E']] = IdValue::create( $reportEmployeeIdData['ID_E'],
                                                                                    $reportEmployeeIdData['target_count']);
            }
            mysql_free_result($query);
        }

        return $employeeIdValues;
    }
}

?>
