<?php

/**
 * Description of FinalResultReportInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/report/BaseReportEmployeeInterfaceProcessor.class.php');
require_once('modules/interface/builder/reports/FinalResultReportPageBuilder.class.php');
require_once('modules/model/service/report/FinalResultReportService.class.php');

class FinalResultReportInterfaceProcessor extends BaseReportEmployeeInterfaceProcessor
{
    const DISPLAY_WIDTH = 960;

    // Dashboard
    static function displayDashboardView(   xajaxResponse $objResponse,
                                            $doHilite = false)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_FINAL_RESULT_DASHBOARD)) {
            $assessmentCycle = self::getSelectedAssessmentCycle();

            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            $dashboardCollection = FinalResultReportService::getDashboardCollection($bossIdValues, $assessmentCycle);

            $pageHtml = FinalResultReportPageBuilder::getDashboardPageHtml( self::DISPLAY_WIDTH,
                                                                            self::INLINE_SELECTOR_WIDTH,
                                                                            $doHilite,
                                                                            $assessmentCycle,
                                                                            $dashboardCollection);

            DashboardTabInterfaceProcessor::displayContent(     $objResponse, self::DISPLAY_WIDTH, $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_DASHBOARD_MENU_DASHBOARD_FINAL_RESULT);
        }
    }


    static function displayDashboardScoreDetail($objResponse,
                                                $bossId,
                                                $scoreId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_FINAL_RESULT_DASHBOARD) &&
            EmployeeSelectService::isAllowedBossId( $bossId,
                                                    BossFilterValue::MODE_REPORT)) {

            // alle employees met betreffende score opzoeken
            $assessmentCycle = AssessmentCycleService::getCurrentValueObject();
            $groupCollection = BaseReportEmployeeGroupCollection::create();

            if ($bossId == BossFilterValue::ALL) {
                $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            } else {
                $bossIdValues = array(EmployeeSelectService::getBossIdValue($bossId));
            }

            foreach ($bossIdValues as $bossIdValue) {
                $bossId = $bossIdValue->getDatabaseId();
                $employeeIds = FinalResultReportService::getEmployeeIdsWithScore(   $bossId,
                                                                                    $scoreId,
                                                                                    $assessmentCycle);
                if (!empty($employeeIds)) {
                    $collection = BaseReportEmployeeService::getCollection( $bossId,
                                                                            $employeeIds);
                    $groupCollection->setCollection($bossId,
                                                    $collection);
                }
            }

            $popupHtml  = BaseReportEmployeePageBuilder::getEmployeesPopupHtml( self::INFO_DIALOG_WIDTH,
                                                                                self::INFO_CONTENT_HEIGHT,
                                                                                $groupCollection);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::INFO_DIALOG_WIDTH,
                                            self::INFO_CONTENT_HEIGHT);
        }
    }

}

?>
