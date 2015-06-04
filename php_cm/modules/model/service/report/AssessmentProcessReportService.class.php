<?php

/**
 * Description of AssessmentProcessReportService
 *
 * @author ben.dokter
 */
require_once('modules/model/valueobjects/library/AssessmentCycleValueObject.class.php');
require_once('modules/model/service/employee/EmployeeSelectService.class.php');
require_once('modules/model/service/employee/assessmentAction/EmployeeAssessmentProcessService.class.php');

require_once('modules/model/queries/report/AssessmentProcessReportQueries.class.php');

require_once('modules/model/valueobjects/report/AssessmentProcessDashboardValueObject.class.php');
require_once('modules/model/valueobjects/report/AssessmentProcessDashboardDetailValueObject.class.php');
require_once('modules/model/valueobjects/report/AssessmentProcessDashboardCollection.class.php');


class AssessmentProcessReportService
{

    static function getValueObjects($allowedEmployeeIds,
                                    /* AssessmentProcessStatusValue */ $assessmentProcessStatus,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObjects = array();

        $query = AssessmentProcessReportQueries::getProcessReportInPeriod(  $allowedEmployeeIds,
                                                                            $assessmentProcessStatus,
                                                                            $assessmentCycle->getStartDate(),
                                                                            $assessmentCycle->getEndDate());
        while ($reportData = mysql_fetch_assoc($query)) {
            $valueObject = AssessmentProcessDashboardDetailValueObject::createWithData($reportData);
            $valueObjects[] = $valueObject;
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    static function getDashboardCollection( Array $bossIdValues,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $dashboardCollection = AssessmentProcessDashboardCollection::create();

        // per leidinggevenden de medewerkers ophalen
        foreach($bossIdValues as $bossIdValue) {
            $bossId = $bossIdValue->getDatabaseId();
            $bossName = $bossIdValue->getValue();
            $valueObject = self::getDashboardAssessmentProcessCountForBoss( $bossId,
                                                                            $bossName,
                                                                            $assessmentCycle);
            $dashboardCollection->addValueObject($valueObject);
        }
        return $dashboardCollection;
    }

    private static function getDashboardAssessmentProcessCountForBoss(  $bossId,
                                                                        $bossName,
                                                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = AssessmentProcessDashboardValueObject::create($bossId, $bossName);

        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_STRING);
        if (!empty($allowedEmployeeIds)) {
            $query = AssessmentProcessReportQueries::getProcessCountReportInPeriod( $allowedEmployeeIds,
                                                                                    $assessmentCycle->getStartDate(),
                                                                                    $assessmentCycle->getEndDate());
            $reportCountData = mysql_fetch_assoc($query);
            mysql_free_result($query);

            $valueObject->addCountData(empty($reportCountData) ? array() : $reportCountData);
        }

        return $valueObject;
    }

//    private static function getAssessmentProcessDashboardForBoss(   $bossId,
//                                                                    $bossName,
//                                                                    AssessmentCycleValueObject $assessmentCycle)
//    {
//        $valueObject = AssessmentProcessDashboardValueObject::create($bossId, $bossName);
//
//        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, EmployeeSelectService::RETURN_AS_STRING);
//        if (!empty($allowedEmployeeIds)) {
//            $processReportValueObjects = AssessmentProcessReportService::getValueObjects(   $allowedEmployeeIds,
//                                                                                            AssessmentProcessStatusValue::GET_ALL_PROCESS_STATES,
//                                                                                            $assessmentCycle);
//
//            foreach ($processReportValueObjects as $processReportValueObject) {
//                $valueObject->addValues($processReportValueObject);
//            }
//        }
//        return $valueObject;
//    }

    static function getAssessmentProcessDashboardPhaseDetail(   $bossId,
                                                                /* AssessmentProcessStatusValue */ $assessmentProcessStatus,
                                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, true);

        if (!empty($allowedEmployeeIds)) {
            $valueObjects = AssessmentProcessReportService::getValueObjects($allowedEmployeeIds,
                                                                            $assessmentProcessStatus,
                                                                            $assessmentCycle);
        } else {
            $valueObjects = array();
        }

        return $valueObjects;
    }


}

?>
