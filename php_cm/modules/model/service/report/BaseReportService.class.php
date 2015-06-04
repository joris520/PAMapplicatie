<?php

/**
 * Description of BaseReportService
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/AssessmentCycleService.class.php');

class BaseReportService
{
    const SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_ID    = 'report_assessment_cyle';
    const SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_START = 'report_assessment_cyle_start_date';
    const SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_END   = 'report_assessment_cyle_end_date';
    const SESSION_STORE__STORE_NAME = 'all';

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // session stuff
    static function retrieveAssessmentCycleId($storeName)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        $assessmentCycleId = @$_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_ID][$storeName];
        if (empty($assessmentCycleId)) {
            $valueObject = AssessmentCycleService::getCurrentValueObject();
            $assessmentCycleId = $valueObject->getId();
        }
        return $assessmentCycleId;
    }

    static function storeAssessmentCycleId( $storeName,
                                            $assessmentCycleId)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        $_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_ID][$storeName] = $assessmentCycleId;
    }

    static function clearAssessmentCycleId( $storeName)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        unset($_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_ID][$storeName]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // START DATE
    static function retrieveAssessmentCycleStartDate($storeName)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        $assessmentCycleStartDate = @$_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_START][$storeName];
        return $assessmentCycleStartDate;
    }

    static function storeAssessmentCycleStartDate(  $storeName,
                                                    $assessmentCycleStartDate)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        $_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_START][$storeName] = $assessmentCycleStartDate;
    }

    static function clearAssessmentCycleStartDate(  $storeName)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        unset($_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_START][$storeName]);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // END DATE
    static function retrieveAssessmentCycleEndDate($storeName)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        $assessmentCycleEndDate = @$_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_END][$storeName];
        return $assessmentCycleEndDate;
    }

    static function storeAssessmentCycleEndDate($storeName,
                                                $assessmentCycleEndDate)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        $_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_END][$storeName] = $assessmentCycleEndDate;
    }

    static function clearAssessmentCycleEndDate($storeName)
    {
        $storeName = self::SESSION_STORE__STORE_NAME;
        unset($_SESSION[self::SESSION_STORE__SELECTED_REPORT_ASSESSMENT_CYCLE_END][$storeName]);
    }


    /**
     *
     * @return AssessmentCycleValueObject
     */
    static function getSelectedAssessmentCycleForModule($currentModule)
    {
        $selectedAssessmentCycleId = self::retrieveAssessmentCycleId($currentModule);
        $assessmentCycle = AssessmentCycleService::getValueObject($selectedAssessmentCycleId);

        return $assessmentCycle;
    }

    static function validatePeriodDates($reportStartDate,
                                        $reportEndDate)
    {
        $hasError = false;
        $messages = array();

        if (empty($reportStartDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_START_DATE') . "\n";
        }
        if (empty($reportEndDate)) {
            $hasError = true;
            $messages[] = TXT_UCF('SELECT_END_DATE') . "\n";
        }
        if (!empty($reportStartDate) && !empty($reportEndDate)) {
            if (DateUtils::isBeforeDate($reportStartDate, $reportEndDate)) {
                $hasError = true;
                $messages[] = TXT_UCF('START_DATE_CANNOT_BE_GREATER_THAN_END_DATE');
            }
        }

        return array($hasError, $messages);
    }
}

?>
