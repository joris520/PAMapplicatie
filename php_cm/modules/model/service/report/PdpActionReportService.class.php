<?php

/**
 * Description of PdpActionReportService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/PdpActionDashboardCollection.class.php');
require_once('modules/model/valueobjects/report/PdpActionDashboardValueObject.class.php');

require_once('modules/model/queries/report/PdpActionReportQueries.class.php');

require_once('modules/model/value/employee/pdpAction/PdpActionCompletedStatusValue.class.php');

class PdpActionReportService
{
    static function getDashboardCollection( Array $bossIdValues,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $keyIdValues = self::getCompletedStatusIdValues();
        $dashboardCollection = PdpActionDashboardCollection::create($keyIdValues);

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
        $valueObject = PdpActionDashboardValueObject::create(   $bossId,
                                                                $bossName);

        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId);

        $employeeCount = count($allowedEmployeeIds);
        $valueObject->addEmployeesTotal($employeeCount);

        if ($employeeCount > 0) {
            $query = PdpActionReportQueries::getPdpActionCount( implode(',', $allowedEmployeeIds),
                                                                $assessmentCycle->getStartDate(),
                                                                $assessmentCycle->getEndDate());
            while($reportCountData = mysql_fetch_assoc($query)) {
                $statusCount = $reportCountData['status_count'];
                $employeeCount = $reportCountData['unique_employees'];
                $completedStatus = $reportCountData['completed_status'];

                if ($completedStatus == PdpActionCompletedStatusValue::NO_PDP_ACTION) { // het aantal medewerkers zonder POP actie
                    $valueObject->addEmployeesWithout($employeeCount);
                } else {
                    $valueObject->addEmployeeCountForKey($completedStatus, $statusCount);
                }
            }
            mysql_free_result($query);
        }

        return $valueObject;
    }

    static function getCompletedStatusIdValues()
    {
        $statusIdValues = array();
        $values = PdpActionCompletedStatusValue::values(PdpActionCompletedStatusValue::REPORT_MODE);
        foreach($values as $value) {
            $statusIdValues[] = IdValue::create($value, PdpActionCompletedConverter::display($value));
        }
        return $statusIdValues;
    }

    static function getEmployeeIdValuesWithCompletedStatus( $bossId,
                                                            $completedStatus,
                                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId,
                                                                        EmployeeSelectService::RETURN_AS_STRING);
        if (!empty($allowedEmployeeIds)) {
            $query = PdpActionReportQueries::getEmployeesWithCompletedStatus(   $completedStatus,
                                                                                $allowedEmployeeIds,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate());

            $employeeIdValues = array();
            while($reportEmployeeIdData = mysql_fetch_assoc($query)) {
                $employeeIdValues[$reportEmployeeIdData['ID_E']] = IdValue::create( $reportEmployeeIdData['ID_E'],
                                                                                    $reportEmployeeIdData['pdp_action_count']);
            }
            mysql_free_result($query);
        }

        return $employeeIdValues;
    }


}

?>
