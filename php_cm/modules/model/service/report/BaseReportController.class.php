<?php

/**
 * Description of BaseReportController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/report/BaseReportService.class.php');

class BaseReportController
{
    static function processSelector($reportMode,
                                    $assessmentCycleId)
    {
        $hasError = false;
        $messages = array();

        $idValues = AssessmentCycleService::getIdValues();
        $assessmentCycleIds = array_keys($idValues);

        $hasError = !is_numeric($assessmentCycleId) && !in_array($assessmentCycleId, $assessmentCycleIds);

        if (!$hasError) {
            BaseReportService::storeAssessmentCycleId(  $reportMode,
                                                        $assessmentCycleId);
        }

        return array($hasError, $messages);
    }

    static function processPeriodDates( $reportMode,
                                        $reportStartDate,
                                        $reportEndDate)
    {
        $hasError = false;
        $messages = array();

        list($hasError, $messages) = BaseReportService::validatePeriodDates($reportStartDate,
                                                                            $reportEndDate);

        if (!$hasError) {
            BaseReportService::storeAssessmentCycleStartDate(   $reportMode,
                                                                $reportStartDate);
            BaseReportService::storeAssessmentCycleEndDate(     $reportMode,
                                                                $reportEndDate);
        }

        return array($hasError, $messages);
    }

}

?>
