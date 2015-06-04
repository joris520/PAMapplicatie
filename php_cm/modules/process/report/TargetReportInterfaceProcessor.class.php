<?php

/**
 * Description of TargetReportInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/process/report/BaseReportEmployeeInterfaceProcessor.class.php');
require_once('modules/interface/builder/reports/TargetReportPageBuilder.class.php');
require_once('modules/model/service/report/TargetReportService.class.php');

class TargetReportInterfaceProcessor extends BaseReportEmployeeInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::DASHBOARD_WIDTH;

    static function displayDashboardView(   xajaxResponse $objResponse,
                                            $doHilite = false)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TARGET)) {
            $assessmentCycle = self::getSelectedAssessmentCycle();

            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            $dashboardCollection = TargetReportService::getDashboardCollection( $bossIdValues,
                                                                                $assessmentCycle);

            $pageHtml = TargetReportPageBuilder::getDashboardPageHtml(  self::DISPLAY_WIDTH,
                                                                        self::INLINE_SELECTOR_WIDTH,
                                                                        $doHilite,
                                                                        $assessmentCycle,
                                                                        $dashboardCollection);

            DashboardTabInterfaceProcessor::displayContent(  $objResponse, self::DISPLAY_WIDTH, $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_DASHBOARD_MENU_DASHBOARD_TARGETS);
        }
    }

    static function displayDashboardTargetStatusDetail( xajaxResponse $objResponse,
                                                        $bossId,
                                                        $targetStatus)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_TARGET) &&
            EmployeeSelectService::isAllowedBossId( $bossId,
                                                    BossFilterValue::MODE_REPORT)) {

            // alle employees met betreffende score opzoeken
            $assessmentCycle = self::getSelectedAssessmentCycle();
            $groupCollection = BaseReportEmployeeGroupCollection::create();

            if ($bossId == BossFilterValue::ALL) {
                $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            } else {
                $bossIdValues = array(EmployeeSelectService::getBossIdValue($bossId));
            }

            foreach ($bossIdValues as $bossIdValue) {
                $bossId             = $bossIdValue->getDatabaseId();
                $employeeIdValues   = TargetReportService::getEmployeeIdValuesWithStatus(   $bossId,
                                                                                            $targetStatus,
                                                                                            $assessmentCycle);
                if (count($employeeIdValues) > 0) {
                    $collection = BaseReportEmployeeService::getCollectionWithIdValues( $bossIdValue,
                                                                                        $employeeIdValues);
                    $groupCollection->setCollection($bossId,
                                                    $collection);
                }
            }
            if ($targetStatus == EmployeeTargetStatusValue::NO_TARGET) {
                $dialogWidth = self::INFO_DIALOG_WIDTH;
                $countTitle  = NULL;
            } else {
                $dialogWidth = self::INFO_DIALOG_WIDTH + self::COUNT_COL_WIDTH;
                $countTitle  = TXT_UCF('TARGETS');

            }

            $popupHtml  = BaseReportEmployeePageBuilder::getEmployeesPopupHtml( $dialogWidth,
                                                                                self::INFO_CONTENT_HEIGHT,
                                                                                $groupCollection,
                                                                                $countTitle);

            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            $dialogWidth,
                                            self::INFO_CONTENT_HEIGHT);
        }
    }

}

?>
