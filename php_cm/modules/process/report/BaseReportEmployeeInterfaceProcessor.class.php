<?php

/**
 * Description of BaseReportEmployeeInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/process/report/BaseReportInterfaceProcessor.class.php');
require_once('modules/interface/builder/reports/BaseReportEmployeePageBuilder.class.php');

require_once('modules/model/service/report/BaseReportEmployeeService.class.php');
require_once('modules/model/valueobjects/report/BaseReportEmployeeGroupCollection.class.php');

class BaseReportEmployeeInterfaceProcessor extends BaseReportInterfaceProcessor
{
    const INFO_DIALOG_WIDTH = 650;
    const INFO_CONTENT_HEIGHT = 300;
    const COUNT_COL_WIDTH = 100;

    // hier geen safeform, zelf bossId controleren
    static function displayDetailEmployeesForBoss(  xajaxResponse $objResponse,
                                                    $bossId)
    {
        $applicationMenu = ApplicationNavigationService::getCurrentApplicationMenu();
        $currentModule = ApplicationNavigationService::getCurrentApplicationModule($applicationMenu);
        if (ApplicationNavigationService::isAllowedModule($currentModule)) {

            $groupCollection = BaseReportEmployeeGroupCollection::create();

            if ($bossId == BossFilterValue::ALL) {
                $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
            } else {
                $bossIdValues = array(EmployeeSelectService::getBossIdValue($bossId));
            }

            foreach ($bossIdValues as $bossIdValue) {
                $bossId = $bossIdValue->getDatabaseId();
                $collection = BaseReportEmployeeService::getCollection($bossId);
                $groupCollection->setCollection($bossId,
                                                $collection);
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




//    static function displayDetailEmployees( xajaxResponse $objResponse,
//                                            $employeeIds)
//    {
//
//    }
//
//    static function displayAssessmentCycleLink($objResponse, $employeeId, $employeeTargetId)
//    {
////        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
//
//            $linkHtml = BaseReportEmployeePageBuilder::getAssessmentCycleLink(self::INLINE_STATUS_WIDTH, $employeeId, $employeeTargetId);
//
//            InterfaceXajax::setHtml($objResponse, BaseReportEmployeeInterfaceBuilder::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE, $linkHtml);
////        }
//    }
//
//    static function displayAssessmentCycleSelector($objResponse, $employeeId, $employeeTargetId)
//    {
//        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
//
//            $contentHtml = EmployeeTargetPageBuilder::getEditStatus(self::INLINE_STATUS_WIDTH, $employeeId, $employeeTargetId);
//
//            InterfaceXajax::setHtml($objResponse, BaseReportEmployeeInterfaceBuilder::REPORT_ASSESSMENT_CYCLE_SELECTOR_INLINE, $contentHtml);
//        }
//    }

}

?>
