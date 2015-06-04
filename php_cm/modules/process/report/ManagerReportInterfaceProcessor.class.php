<?php

/**
 * Description of ManagerReportInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/reports/ManagerReportPageBuilder.class.php');
require_once('modules/model/service/report/ManagerReportService.class.php');

class ManagerReportInterfaceProcessor
{
    const VIEW_WIDTH = 800;
    const INFO_CONTENT_HEIGHT = 300;
    const INFO_DIALOG_WIDTH = 650;
    const PANEL_WIDTH = ApplicationInterfaceBuilder::REPORT_PANEL_SIMPLE_CONTENT;

    static function displayModuleView(  $objResponse,
                                        $moduleMenu)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForManagerReportModuleMenu($currentModule);
        if (PermissionsService::isViewAllowed($permission)) {

            $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds(true);

            $collection = ManagerReportService::getDashboardCollection($allowedEmployeeIds);
            $contentHtml   = ManagerReportPageBuilder::getPageHtml( self::VIEW_WIDTH,
                                                                    $collection);

            OrganisationTabInterfaceProcessor::displayContent(  $objResponse,
                                                                self::VIEW_WIDTH,
                                                                $contentHtml);

            ApplicationNavigationProcessor::activateModuleMenu( $objResponse,
                                                                $moduleMenu);

            // hilite animeren
//            if (!empty($hiliteId)) {
//                InterfaceXajax::hiliteNewElement($objResponse);
//            }
        }
    }

//    static function displayDetailEmployees( $objResponse,
//                                            $managerReportId)
//    {
//        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
//        $permission = PermissionsService::getPermissionForManagerReportModuleMenu($currentModule);
//        if (PermissionsService::isViewAllowed($permission)) {
//
//            $employeeIds = EmployeeSelectService::getBossEmployeeIds($managerReportId, EmployeeSelectService::RETURN_AS_STRING);
//
//            $popupHtml = ManagerReportPageBuilder::getEmployeesPopupHtml(   self::INFO_DIALOG_WIDTH,
//                                                                            self::INFO_CONTENT_HEIGHT,
//                                                                            $employeeIds);
//            InterfaceXajax::showInfoDialog( $objResponse,
//                                            $popupHtml,
//                                            self::INFO_DIALOG_WIDTH,
//                                            self::INFO_CONTENT_HEIGHT);
//        }
//    }

    static function displayDetailDepartments(   xajaxResponse $objResponse,
                                                $managerUserId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForManagerReportModuleMenu($currentModule);
        if (PermissionsService::isViewAllowed($permission)) {

            $collection = DepartmentService::getCollectionForUserId($managerUserId);

            $popupHtml = ManagerReportPageBuilder::geDepartmentsPopupHtml(  self::INFO_DIALOG_WIDTH,
                                                                            self::INFO_CONTENT_HEIGHT,
                                                                            $collection);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::INFO_DIALOG_WIDTH,
                                            self::INFO_CONTENT_HEIGHT);
        }
    }

}

?>
