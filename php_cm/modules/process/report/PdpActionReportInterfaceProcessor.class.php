<?php

/**
 * Description of PdpActionReportInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/report/BaseReportEmployeeInterfaceProcessor.class.php');
require_once('modules/interface/builder/reports/PdpActionReportPageBuilder.class.php');
require_once('modules/model/service/report/PdpActionReportService.class.php');

class PdpActionReportInterfaceProcessor extends BaseReportEmployeeInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::DASHBOARD_WIDTH;

    static function displayDashboardView(   xajaxResponse $objResponse,
                                            $doHilite = false)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_PDP_ACTION)) {

            $assessmentCycle = self::getSelectedAssessmentCycle();

            $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            $dashboardCollection = PdpActionReportService::getDashboardCollection(  $bossIdValues,
                                                                                    $assessmentCycle);

            $pageHtml = PdpActionReportPageBuilder::getDashboardPageHtml(   self::DISPLAY_WIDTH,
                                                                            self::INLINE_SELECTOR_WIDTH,
                                                                            $doHilite,
                                                                            $assessmentCycle,
                                                                            $dashboardCollection);

            DashboardTabInterfaceProcessor::displayContent(     $objResponse, self::DISPLAY_WIDTH, $pageHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_DASHBOARD_MENU_DASHBOARD_PDP_ACTIONS);
        }
    }

    static function displayDashboardCompletedStatusDetail(  xajaxResponse $objResponse,
                                                            $bossId,
                                                            $completedStatus)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DASHBOARD_PDP_ACTION) &&
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
                $bossId = $bossIdValue->getDatabaseId();
                $employeeIdValues = PdpActionReportService::getEmployeeIdValuesWithCompletedStatus( $bossId,
                                                                                                    $completedStatus,
                                                                                                    $assessmentCycle);
                if (count($employeeIdValues) > 0) {
                    $collection = BaseReportEmployeeService::getCollectionWithIdValues( $bossIdValue,
                                                                                        $employeeIdValues);
                    $groupCollection->setCollection($bossId,
                                                    $collection);
                }
            }

            if ($completedStatus == PdpActionCompletedStatusValue::NO_PDP_ACTION) {
                $dialogWidth = self::INFO_DIALOG_WIDTH;
                $countTitle  = NULL;
            } else {
                $dialogWidth = self::INFO_DIALOG_WIDTH + self::COUNT_COL_WIDTH;
                $countTitle  = TXT_UCF('PDP_ACTIONS');

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
