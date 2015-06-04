<?php

/**
 * Description of AssessmentProcessService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/assessmentProcess/AssessmentProcessQueries.class.php');

class AssessmentProcessService
{
    static function getSumScoreIdValues($selectedEmployeeIds,
                                        AssessmentCycleValueObject $assessmentCycle)
    {
        $sumScoreIdValues = array();

        $query = AssessmentProcessQueries::getSumScoresInPeriod($selectedEmployeeIds,
                                                                $assessmentCycle->getStartDate(),
                                                                $assessmentCycle->getEndDate());
        while ($sumScoreData = mysql_fetch_assoc($query)) {
            $sumScoreIdValues[$sumScoreData['ID_E']] = IdValue::create($sumScoreData['ID_E'], $sumScoreData['normalized_manager_score']);
        }
        mysql_free_result($query);

        return $sumScoreIdValues;

    }

    static function getSumScoreIdValue( $employeeId,
                                        AssessmentCycleValueObject $assessmentCycle)
    {

        $query = AssessmentProcessQueries::getSumScoresInPeriod(    $employeeId,
                                                                    $assessmentCycle->getStartDate(),
                                                                    $assessmentCycle->getEndDate());
        $sumScoreData = mysql_fetch_assoc($query);
        $sumScoreIdValue = IdValue::create($sumScoreData['ID_E'], $sumScoreData['normalized_manager_score']);
        mysql_free_result($query);

        return $sumScoreIdValue;

    }

    static function fillSelfAssessmentDiffScoresByHashId(   $employeeId,
                                                            $selectedHashIds,
                                                            AssessmentCycleValueObject $assessmentCycle,
                                                            $invitationProcessStatus)
    {
        return AssessmentProcessQueries::fillSelfAssessmentDiffScoresByHashIdInPeriod(  $employeeId,
                                                                                        $selectedHashIds,
                                                                                        $assessmentCycle->getStartDate(),
                                                                                        $assessmentCycle->getEndDate(),
                                                                                        $invitationProcessStatus);
    }
    static function fillSelfAssessmentDiffScores(   $employeeId,
                                                    AssessmentCycleValueObject $assessmentCycle,
                                                    $invitationProcessStatus)
    {
        return AssessmentProcessQueries::fillSelfAssessmentDiffScoresInPeriod(  $employeeId,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate(),
                                                                                $invitationProcessStatus);
    }

//    static function fillSelfAssessmentSumDiffScores($employeeId,
//                                                    AssessmentCycleValueObject $assessmentCycle,
//                                                    $invitationProcessStatus)
//    {
//
//        return AssessmentProcessQueries::fillSelfAssessmentSumDiffScores(   $employeeId,
//                                                                            $assessmentCycle->getStartDate(),
//                                                                            $assessmentCycle->getEndDate(),
//                                                                            $invitationProcessStatus);
//    }

    static function getSelfAssessmentScoreIdValue($employeeId, AssessmentCycleValueObject $assessmentCycle)
    {

        $query = AssessmentProcessQueries::getSelfAssessmentSumScoresInPeriod(  $employeeId,
                                                                                $assessmentCycle->getStartDate(),
                                                                                $assessmentCycle->getEndDate());
        $sumScoreData = mysql_fetch_assoc($query);
        $sumScoreIdValue = IdValue::create($sumScoreData['ID_E'], $sumScoreData['normalized_manager_score']);
        mysql_free_result($query);

        return $sumScoreIdValue;

    }
}

?>
