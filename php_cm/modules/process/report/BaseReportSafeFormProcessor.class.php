<?php

/**
 * Description of BaseReportSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/report/BaseReportController.class.php');

class BaseReportSafeFormProcessor
{
    // afhandelen assessmentcycle report popup selector
    static function processSelector(xajaxResponse $objResponse,
                                    SafeFormHandler $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

//        if (PermissionsService::isEditAllowed(PERMISSION_DEPARTMENTS) ||
//            PermissionsService::isEditAllowed(PERMISSION_MENU_ORGANISATION_DEPARTMENTS) ||
//            PermissionsService::isEditAllowed(PERMISSION_MENU_DASHBOARD_DEPARTMENTS)) {

        $reportMode         = $safeFormHandler->retrieveSafeValue('report_mode');
        $assessmentCycleId  = $safeFormHandler->retrieveInputValue('assessment_cycle');

        list($hasError, $messages) = BaseReportController::processSelector( $reportMode,
                                                                            $assessmentCycleId);
        if (!$hasError) {
            // klaar met edit
            $safeFormHandler->finalizeSafeFormProcess();
            BaseReportInterfaceProcessor::finishEditSelector(   $objResponse,
                                                                $reportMode,
                                                                $assessmentCycleId);
        }
        return array($hasError, $messages);
    }

    static function processPeriodDatesEdit( xajaxResponse $objResponse,
                                            SafeFormHandler $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        $reportMode = $safeFormHandler->retrieveSafeValue('report_mode');

        $reportStartDate  = $safeFormHandler->retrieveInputValue('start_date');
        $reportEndDate    = $safeFormHandler->retrieveInputValue('end_date');

        list($hasError, $messages) = BaseReportController::processPeriodDates(  $reportMode,
                                                                                $reportStartDate,
                                                                                $reportEndDate);
        if (!$hasError) {
            // klaar met edit
            $safeFormHandler->finalizeSafeFormProcess();
            BaseReportInterfaceProcessor::finishEditPeriodDates($objResponse);
        }
        return array($hasError, $messages);
    }

}

?>
