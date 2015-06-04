<?php

/**
 * Description of SelfAssessmentReportInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/report/BaseReportInterfaceProcessor.class.php');

require_once('modules/process/tab/SelfAssessmentTabInterfaceProcessor.class.php');
require_once('modules/interface/builder/reports/SelfAssessmentReportPageBuilder.class.php');

class SelfAssessmentReportInterfaceProcessor extends BaseReportInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::DASHBOARD_WIDTH;
    const DETAIL_CONTENT_HEIGHT = 300;
    const DETAIL_DIALOG_WIDTH = 700;
    const DASHBOARD_INVITATION_DETAIL_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const DASHBOARD_DETAIL_WIDTH = self::DETAIL_DIALOG_WIDTH;

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Invitation
    static function displayView(xajaxResponse $objResponse,
                                $moduleMenu,
                                $doHilite = false)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuOverview($currentModule);
        if (PermissionsService::isViewAllowed($permission)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            // allen, inclusief zonder leidinggevende
            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);

            $pageHtml = SelfAssessmentReportPageBuilder::getPageHtml(   self::DISPLAY_WIDTH,
                                                                        self::INLINE_SELECTOR_WIDTH,
                                                                        $doHilite,
                                                                        $bossIdValues,
                                                                        $assessmentCycle);

            SelfAssessmentTabInterfaceProcessor::displayContent($objResponse,
                                                                self::DISPLAY_WIDTH,
                                                                $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse,
                                                                $moduleMenu);
        }
    }

    static function displayDetailEmployee(  xajaxResponse $objResponse,
                                            $employeeId,
                                            $invitationHash)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuOverview($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedEmployeeId($employeeId)) {
            $popupHtml = SelfAssessmentReportPageBuilder::getInvitationPopupHtml(   self::DETAIL_DIALOG_WIDTH,
                                                                                    self::DETAIL_CONTENT_HEIGHT,
                                                                                    $employeeId,
                                                                                    $invitationHash);

            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DETAIL_DIALOG_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // Dashboard
    static function displayDashboardView(   xajaxResponse $objResponse,
                                            $moduleMenu,
                                            $doHilite = false)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            $dashboardCollection = SelfAssessmentReportService::getDashboardCollection( $bossIdValues,
                                                                                        $assessmentCycle);

            $pageHtml = SelfAssessmentReportPageBuilder::getDashboardPageHtml(  self::DISPLAY_WIDTH,
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
    static function displayDashboardDetailInvitations(  xajaxResponse $objResponse,
                                                        $bossId)
    {

        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {
            if (!empty($bossId)) {
                $assessmentCycle = self::getSelectedAssessmentCycle();

                $popupHtml = SelfAssessmentReportPageBuilder::getDashboardDetailInvitationsPopupHtml(   self::DASHBOARD_INVITATION_DETAIL_WIDTH,
                                                                                                        self::DETAIL_CONTENT_HEIGHT,
                                                                                                        $bossId,
                                                                                                        $assessmentCycle);
                InterfaceXajax::showInfoDialog( $objResponse,
                                                $popupHtml,
                                                self::DASHBOARD_INVITATION_DETAIL_WIDTH,
                                                self::DETAIL_CONTENT_HEIGHT);
            }
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailEmployeeNotCompleted( xajaxResponse $objResponse,
                                                                $bossId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $popupHtml = SelfAssessmentReportPageBuilder::getDashboardDetailEmployeeStatusPopupHtml(self::DASHBOARD_DETAIL_WIDTH,
                                                                                                    self::DETAIL_CONTENT_HEIGHT,
                                                                                                    $bossId,
                                                                                                    AssessmentInvitationCompletedValue::NOT_COMPLETED,
                                                                                                    $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }


    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailEmployeeCompleted(xajaxResponse $objResponse,
                                                            $bossId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $popupHtml = SelfAssessmentReportPageBuilder::getDashboardDetailEmployeeStatusPopupHtml(  self::DASHBOARD_DETAIL_WIDTH,
                                                                                                      self::DETAIL_CONTENT_HEIGHT,
                                                                                                      $bossId,
                                                                                                      AssessmentInvitationCompletedValue::COMPLETED,
                                                                                                      $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailBossNotCompleted( xajaxResponse $objResponse,
                                                            $bossId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $popupHtml = SelfAssessmentReportPageBuilder::getDashboardDetailBossStatusPopupHtml(self::DASHBOARD_DETAIL_WIDTH,
                                                                                                self::DETAIL_CONTENT_HEIGHT,
                                                                                                $bossId,
                                                                                                ScoreStatusValue::PRELIMINARY,
                                                                                                $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailBossCompleted(xajaxResponse $objResponse,
                                                        $bossId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $popupHtml = SelfAssessmentReportPageBuilder::getDashboardDetailBossStatusPopupHtml(self::DASHBOARD_DETAIL_WIDTH,
                                                                                                self::DETAIL_CONTENT_HEIGHT,
                                                                                                $bossId,
                                                                                                ScoreStatusValue::FINALIZED,
                                                                                                $assessmentCycle);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::DASHBOARD_DETAIL_WIDTH,
                                            self::DETAIL_CONTENT_HEIGHT);
        }
    }

    // hier geen safeform, zelf bossId controleren
    static function displayDashboardDetailFullCompleted(xajaxResponse $objResponse,
                                                        $bossId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForModuleMenuDashboard($currentModule);
        if (PermissionsService::isViewAllowed($permission) &&
            EmployeeSelectService::isAllowedBossId($bossId)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $popupHtml = SelfAssessmentReportPageBuilder::getDashboardDetailFullCompletedPopupHtml( self::DASHBOARD_DETAIL_WIDTH,
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
