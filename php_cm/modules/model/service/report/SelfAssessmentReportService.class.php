<?php

/**
 * Description of SelfAssessmentReportService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/report/SelfAssessmentReportQueries.class.php');
require_once('modules/model/valueobjects/report/SelfAssessmentReportInvitationValueObject.class.php');
require_once('modules/model/valueobjects/report/SelfAssessmentReportInvitationDetailValueObject.class.php');

require_once('modules/model/valueobjects/report/SelfAssessmentDashboardCollection.class.php');

class SelfAssessmentReportService
{

    static function getValueObjects($allowedEmployeeIds,
                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObjects = array();

        $reportQuery = SelfAssessmentReportQueries::getInvitationReportInPeriod($allowedEmployeeIds,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate());
        while ($reportData = mysql_fetch_assoc($reportQuery)) {
            $valueObject = SelfAssessmentReportInvitationValueObject::createWithData($reportData);
            $valueObjects[] = $valueObject;
        }
        mysql_free_result($reportQuery);

        return $valueObjects;
    }

    static function getEmployeesInvitationCount($allowedEmployeeIds,
                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $query = SelfAssessmentReportQueries::getInvitationCountInPeriod(   $allowedEmployeeIds,
                                                                            $assessmentCycle->getStartDate(),
                                                                            $assessmentCycle->getEndDate());
        $reportData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        if (empty($reportData['sent_count'])) { // omdat sent_count 'null' is als er geen uitnodigen zijn dit corrigeren naar '0
            $reportData['sent_count'] = 0;
        }
        return array($reportData['invitation_count'], $reportData['sent_count']);
    }

    static function getInvitationsNotCompletedCount($allowedEmployeeIds,
                                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = SelfAssessmentReportQueries::getInvitationsNotCompletedCountInPeriod(  $allowedEmployeeIds,
                                                                                        $assessmentCycle->getStartDate(),
                                                                                        $assessmentCycle->getEndDate());
        $reportData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $reportData['not_completed_count'];
    }

    static function getInvitationsNotCompleted( $allowedEmployeeIds,
                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObjects = array();

        $reportQuery = SelfAssessmentReportQueries::getInvitationsNotCompletedInPeriod( $allowedEmployeeIds,
                                                                                        $assessmentCycle->getStartDate(),
                                                                                        $assessmentCycle->getEndDate());
        while ($reportData = mysql_fetch_assoc($reportQuery)) {
            $valueObject = SelfAssessmentReportInvitationValueObject::createWithData($reportData);
            $valueObjects[] = $valueObject;
        }
        mysql_free_result($reportQuery);

        return $valueObjects;
    }

    static function getEmployeeInvitationValueObjects($employeeId)
    {
        $valueObjects = array();

        $reportQuery = SelfAssessmentReportQueries::getEmployeeInvitations($employeeId);
        while ($reportData = mysql_fetch_assoc($reportQuery)) {
            $valueObject = SelfAssessmentReportInvitationValueObject::createWithData($reportData);
            $valueObjects[] = $valueObject;
        }
        mysql_free_result($reportQuery);

        return $valueObjects;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function getEmployeeInvitationDetailValueObject($employeeId, $invitationHash)
    {
        $query = SelfAssessmentReportQueries::getEmployeeInvitation($employeeId, $invitationHash);
        $employeeInvitationData = @mysql_fetch_assoc($query);
        mysql_free_result($query);

        return SelfAssessmentReportInvitationDetailValueObject::createWithData($employeeInvitationData);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function getDashboardCollection( Array $bossIdValues,
                                            AssessmentCycleValueObject $assessmentCycle)
    {
        $dashboardCollection = SelfAssessmentDashboardCollection::create();

        // per leidinggevenden de medewerkers ophalen
        foreach($bossIdValues as $bossIdValue) {
            $bossId = $bossIdValue->getDatabaseId();
            $bossName = $bossIdValue->getValue();
            $valueObject = self::getSelfAssessmentDashboardForBoss( $bossId,
                                                                    $bossName,
                                                                    $assessmentCycle);
            $dashboardCollection->addValueObject($valueObject);
        }
        return $dashboardCollection;
    }

    private static function getSelfAssessmentDashboardForBoss(  $bossId,
                                                                $bossName,
                                                                AssessmentCycleValueObject $assessmentCycle)
    {
        $valueObject = SelfAssessmentDashboardValueObject::create($bossId, $bossName);

        $allowedEmployeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, true);
        if (!empty($allowedEmployeeIds)) {
            $invitationValueObjects = SelfAssessmentReportService::getValueObjects($allowedEmployeeIds, $assessmentCycle);
            if (count($invitationValueObjects) > 0) {

                foreach ($invitationValueObjects as $invitationValueObject) {
                    $employeeId = $invitationValueObject->getId();
                    // todo: optimalisatie queries
                    $assessmentValueObject = EmployeeAssessmentService::getValueObject($employeeId, $assessmentCycle);
                    $valueObject->addValues(    $invitationValueObject,
                                                $assessmentValueObject);
                }
            }
        }
        return $valueObject;
    }

}

?>
