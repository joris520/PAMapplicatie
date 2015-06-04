<?php

/**
 * Description of AssessmentReportService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/report/AssessmentReportQueries.class.php');

class AssessmentReportService
{

    static function getAssessmentNotCompletedCount( $allowedEmployeeIds,
                                                    AssessmentCycleValueObject $assessmentCycle)
    {
        $query = AssessmentReportQueries::getAssessmentNotCompletedCountInPeriod(  $allowedEmployeeIds,
                                                                                   $assessmentCycle->getStartDate(),
                                                                                   $assessmentCycle->getEndDate());
        $reportData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $reportData['not_completed_count'];
    }

//    static function getAssessmentsNotCompleted( $allowedEmployeeIds,
//                                                AssessmentCycleValueObject $assessmentCycle)
//    {
//        $valueObjects = array();
//
//        $reportQuery = SelfAssessmentReportQueries::getInvitationsNotCompletedInPeriod( $allowedEmployeeIds,
//                                                                                        $assessmentCycle->getStartDate(),
//                                                                                        $assessmentCycle->getEndDate());
//        while ($reportData = mysql_fetch_assoc($reportQuery)) {
//            $valueObject = SelfAssessmentReportInvitationValueObject::createWithData($reportData);
//            $valueObjects[] = $valueObject;
//        }
//        mysql_free_result($reportQuery);
//
//        return $valueObjects;
//    }

}

?>
