<?php

/**
 * Description of AssessmentProcessInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/report/BaseReportInterfaceProcessor.class.php');

require_once('modules/process/tab/SelfAssessmentTabInterfaceProcessor.class.php');
require_once('modules/interface/builder/reports/AssessmentProcessReportPageBuilder.class.php');

require_once('modules/model/service/library/AssessmentCycleService.class.php');

class AssessmentProcessReportInterfaceProcessor extends BaseReportInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::DASHBOARD_WIDTH;
    const DETAIL_CONTENT_HEIGHT = 300;
    const DETAIL_DIALOG_WIDTH = 700;
    const DASHBOARD_INVITATION_DETAIL_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const DASHBOARD_DETAIL_WIDTH = self::DETAIL_DIALOG_WIDTH;


    // Dashboard
    static function displayDashboardView(   xajaxResponse $objResponse,
                                            $moduleMenu,
                                            $doHilite = false)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            $dashboardCollection = AssessmentProcessReportService::getDashboardCollection(  $bossIdValues,
                                                                                            $assessmentCycle);

            $pageHtml = AssessmentProcessReportPageBuilder::getDashboardPageHtml(   self::DISPLAY_WIDTH,
                                                                                    self::INLINE_SELECTOR_WIDTH,
                                                                                    $doHilite,
                                                                                    $assessmentCycle,
                                                                                    $dashboardCollection);

            SelfAssessmentTabInterfaceProcessor::displayContent($objResponse,
                                                                self::DISPLAY_WIDTH,
                                                                $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse,
                                                                $moduleMenu);
        }
    }


    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailProcessPhase1(xajaxResponse $objResponse,
                                                        $bossId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();
            //$assessmentCycle = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentProcessReportPageBuilder::getDashboardDetailPhasePopupHtml(  self::DASHBOARD_DETAIL_WIDTH,
                                                                                                self::DETAIL_CONTENT_HEIGHT,
                                                                                                $bossId,
                                                                                                AssessmentProcessStatusValue::INVITED,
                                                                                                $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailProcessPhase2($objResponse, $bossId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();
            //$assessmentCycle = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentProcessReportPageBuilder::getDashboardDetailPhasePopupHtml(  self::DASHBOARD_DETAIL_WIDTH,
                                                                                                self::DETAIL_CONTENT_HEIGHT,
                                                                                                $bossId,
                                                                                                AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                                                                                                $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailProcessPhase3($objResponse, $bossId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();
            //$assessmentCycle = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentProcessReportPageBuilder::getDashboardDetailPhasePopupHtml(  self::DASHBOARD_DETAIL_WIDTH,
                                                                                                self::DETAIL_CONTENT_HEIGHT,
                                                                                                $bossId,
                                                                                                AssessmentProcessStatusValue::EVALUATION_SELECTED,
                                                                                                $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailProcessEvaluationNone($objResponse, $bossId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();
            //$assessmentCycle = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentProcessReportPageBuilder::getDashboardDetailEvaluationNonePopupHtml( self::DASHBOARD_DETAIL_WIDTH,
                                                                                                        self::DETAIL_CONTENT_HEIGHT,
                                                                                                        $bossId,
                                                                                                        $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailProcessEvaluationPlanned($objResponse, $bossId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();
            //$assessmentCycle = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentProcessReportPageBuilder::getDashboardDetailEvaluationPlannedPopupHtml(  self::DASHBOARD_DETAIL_WIDTH,
                                                                                                            self::DETAIL_CONTENT_HEIGHT,
                                                                                                            $bossId,
                                                                                                            $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailProcessEvaluationReady($objResponse, $bossId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();
            //$assessmentCycle = AssessmentCycleService::getCurrentValueObject();

            $popupHtml = AssessmentProcessReportPageBuilder::getDashboardDetailEvaluationReadyPopupHtml(self::DASHBOARD_DETAIL_WIDTH,
                                                                                                        self::DETAIL_CONTENT_HEIGHT,
                                                                                                        $bossId,
                                                                                                        $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

}
?>
