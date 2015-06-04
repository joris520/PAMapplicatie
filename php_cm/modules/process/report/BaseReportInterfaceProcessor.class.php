<?php

/**
 * Description of BaseReportInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/reports/BaseReportInterfaceBuilderComponents.class.php');

class BaseReportInterfaceProcessor
{
    const INLINE_SELECTOR_WIDTH = 400;

    const INFO_DIALOG_WIDTH = 300;
    const INFO_CONTENT_HEIGHT = 200;

    const EDIT_DIALOG_WIDTH = 300;
    const EDIT_CONTENT_HEIGHT = 80;

    const SHOW_HILITE = true;


    static function displayInlineAssessmentCycleSelector(   xajaxResponse $objResponse,
                                                            $reportMode)
    {
        $assessmentCycleIdValues    = AssessmentCycleService::getIdValues(AssessmentCycleService::MODE_REPORT);
        $selectedAssessmentCycleId  = BaseReportService::retrieveAssessmentCycleId($reportMode);

        $selectedAssessmentCycleId = $selectedAssessmentCycleId == AssessmentCycleService::REPORT_USER_PERIOD_ID ? NULL : $selectedAssessmentCycleId;
        $inlineHtml = BaseReportPageBuilder::getAssessmentCycleSelectorLinkHtml(self::INLINE_SELECTOR_WIDTH,
                                                                                $reportMode,
                                                                                $assessmentCycleIdValues,
                                                                                $selectedAssessmentCycleId);
        InterfaceXajax::setHtml($objResponse,
                                BaseReportEmployeeInterfaceBuilder::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE,
                                $inlineHtml);
    }

    static function cancelInlineAssessmentCycleSelector(xajaxResponse $objResponse)
    {
        self::finishCancel($objResponse);
    }

    static function displayReportPeriodSelector(xajaxResponse $objResponse,
                                                $reportMode)
    {
        $displayWidth = self::EDIT_DIALOG_WIDTH;
        $contentHeight = self::EDIT_CONTENT_HEIGHT;

        $selectedAssessmentCycleStartDate   = BaseReportService::retrieveAssessmentCycleStartDate($reportMode);
        $selectedAssessmentCycleEndDate     = BaseReportService::retrieveAssessmentCycleEndDate($reportMode);

        $popupHtml = BaseReportPageBuilder::getEditReportDatesPopupHtml($displayWidth,
                                                                        $contentHeight,
                                                                        $reportMode,
                                                                        $selectedAssessmentCycleStartDate,
                                                                        $selectedAssessmentCycleEndDate);

        InterfaceXajax::showEditDialog( $objResponse,
                                        $popupHtml,
                                        $displayWidth,
                                        $contentHeight);

    }

    static function finishEditPeriodDates(  xajaxResponse $objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::finishSelector($objResponse);
    }

    /**
     *
     * @return AssessmentCycleValueObject
     */
    static function getSelectedAssessmentCycle()
    {
        $currentModule = ApplicationNavigationService::getCurrentModule();
        return BaseReportEmployeeService::getSelectedAssessmentCycleForModule($currentModule);
    }

    static function finishEditSelector( xajaxResponse $objResponse,
                                        $reportMode,
                                        $assessmentCycleId)
    {
        if ($assessmentCycleId == AssessmentCycleService::REPORT_USER_PERIOD_ID) {
            // opruimen inline selector
            self::finishCancel($objResponse);
            self::displayReportPeriodSelector(  $objResponse,
                                                $reportMode);
        } else {
            self::finishSelector($objResponse);
        }
    }

    static function finishSelector(xajaxResponse $objResponse)
    {
        // status tonen
        $currentModule = ApplicationNavigationService::getCurrentModule();

        switch ($currentModule) {
            // dashboard menu
            case MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS:
                PdpActionReportInterfaceProcessor::displayDashboardView($objResponse,
                                                                        self::SHOW_HILITE);
                break;
            case MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS:
                TargetReportInterfaceProcessor::displayDashboardView(   $objResponse,
                                                                        self::SHOW_HILITE);
                break;
            case MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT:
                FinalResultReportInterfaceProcessor::displayDashboardView(  $objResponse,
                                                                            self::SHOW_HILITE);
                break;
            case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
                SelfAssessmentReportInterfaceProcessor::displayDashboardView(   $objResponse,
                                                                                MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS,
                                                                                self::SHOW_HILITE);
                break;
            case MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
                SelfAssessmentReportInterfaceProcessor::displayView($objResponse,
                                                                    MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS,
                                                                    self::SHOW_HILITE);
                break;
            // selfassessment menu
            case MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
                SelfAssessmentReportInterfaceProcessor::displayView($objResponse,
                                                                    MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS,
                                                                    self::SHOW_HILITE);
                break;
            case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
                SelfAssessmentReportInterfaceProcessor::displayDashboardView(   $objResponse,
                                                                                MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS,
                                                                                self::SHOW_HILITE);
                break;
            case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                AssessmentProcessReportInterfaceProcessor::displayDashboardView($objResponse,
                                                                                MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS,
                                                                                self::SHOW_HILITE);
                break;

            default:
//                die('reportMode:'.$reportMode);

        }
        
        InterfaceXajax::hiliteNewElement($objResponse);
    }

    static function finishCancel(xajaxResponse $objResponse)
    {
        // status tonen
        $currentModule = ApplicationNavigationService::getCurrentModule();

        switch ($currentModule) {
            case MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS:
                $linkHtml = PdpActionReportInterfaceBuilderComponents::getEditAssessmentCycleLink();
                break;
            case MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS:
                $linkHtml = TargetReportInterfaceBuilderComponents::getEditAssessmentCycleLink();
                break;
            case MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT:
                $linkHtml = FinalResultReportInterfaceBuilderComponents::getEditAssessmentCycleLink();
                break;
            case MODULE_DASHBOARD_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
            case MODULE_DASHBOARD_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
            case MODULE_SELFASSESSMENT_MENU_OVERVIEW_SELFASSESSEMENT_INVITATIONS:
            case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_INVITATIONS:
            case MODULE_SELFASSESSMENT_MENU_DASHBOARD_SELFASSESSEMENT_PROCESS:
                $linkHtml = SelfAssessmentReportInterfaceBuilderComponents::getEditAssessmentCycleLink();
                break;
            default:
        }

        InterfaceXajax::setHtml($objResponse,
                                BaseReportEmployeeInterfaceBuilder::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE,
                                $linkHtml);
    }

}

?>
