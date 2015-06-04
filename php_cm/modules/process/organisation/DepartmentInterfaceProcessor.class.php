<?php


/**
 * Description of DepartmentInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/organisation/DepartmentPageBuilder.class.php');
require_once('modules/process/tab/OrganisationTabInterfaceProcessor.class.php');

class DepartmentInterfaceProcessor
{
    const PANEL_WIDTH = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;
    const DIALOG_WIDTH = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const DISPLAY_WIDTH = 700;
    const CONTENT_HEIGHT = 80;
    const DETAIL_WIDTH = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const INFO_CONTENT_HEIGHT = 300;
    const INFO_DIALOG_WIDTH = 650;

    static function displayModuleView($objResponse, $moduleMenu, $hiliteId = NULL)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForDepartmentModuleMenu($currentModule);

        if (PermissionsService::isViewAllowed($permission)) {

            $contentHtml   = DepartmentPageBuilder::getPageHtml(self::DISPLAY_WIDTH,
                                                                $permission,
                                                                $hiliteId);

            OrganisationTabInterfaceProcessor::displayContent(  $objResponse,
                                                                self::DISPLAY_WIDTH,
                                                                $contentHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse,
                                                                $moduleMenu);

            // hilite animeren
            if (!empty($hiliteId)) {
                InterfaceXajax::hiliteNewElement($objResponse);
            }
        }
    }

    static function displayView($objResponse,
                                $hiliteId = NULL)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        switch ($currentModule) {
            case APPLICATION_MENU_ORGANISATION:
                self::displayModuleView($objResponse,
                                        MODULE_ORGANISATION_MENU_DEPARTMENTS,
                                        $hiliteId);
                break;
            case APPLICATION_MENU_LIBRARIES:
                self::displayModuleView($objResponse,
                                        MODULE_LIBRARY_DEPARTMENTS,
                                        $hiliteId);
                break;
            case APPLICATION_MENU_DASHBOARD:
                self::displayModuleView($objResponse,
                                        MODULE_DASHBOARD_MENU_DEPARTMENTS,
                                        $hiliteId);
                break;
        }
    }

    static function displayAdd($objResponse)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForDepartmentModuleMenu($currentModule);

        if (PermissionsService::isAddAllowed($permission)) {

            $popupHtml = DepartmentPageBuilder::getAddPopupHtml(    self::DIALOG_WIDTH,
                                                                    self::CONTENT_HEIGHT,
                                                                    ApplicationInterfaceBuilder::HIDE_WARNING);
            InterfaceXajax::showAddDialog(  $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::CONTENT_HEIGHT);
        }
    }


    static function finishAdd(  $objResponse,
                                $hiliteId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele lijst opnieuw tonen ivm sortering
        self::displayView(  $objResponse,
                            $hiliteId);
    }

    static function displayEdit($objResponse,
                                $departmentId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForDepartmentModuleMenu($currentModule);

        if (PermissionsService::isEditAllowed($permission)) {

            $popupHtml = DepartmentPageBuilder::getEditPopupHtml(   self::DIALOG_WIDTH,
                                                                    self::CONTENT_HEIGHT,
                                                                    $departmentId,
                                                                    ApplicationInterfaceBuilder::HIDE_WARNING);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::CONTENT_HEIGHT);
        }
    }

    static function finishEdit( $objResponse,
                                $hiliteId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele lijst opnieuw tonen ivm sortering
        self::displayView(  $objResponse,
                            $hiliteId);
    }

    static function displayRemove(  $objResponse,
                                    $departmentId)
    {
        $currentModule = ApplicationNavigationService::getCurrentApplicationMenu();
        $permission = PermissionsService::getPermissionForDepartmentModuleMenu($currentModule);

        if (PermissionsService::isDeleteAllowed($permission)) {

            $popupHtml = DepartmentPageBuilder::getRemovePopupHtml( self::DIALOG_WIDTH,
                                                                    self::CONTENT_HEIGHT,
                                                                    $departmentId);

            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::CONTENT_HEIGHT);
        }
    }

    static function finishRemove(   $objResponse,
                                    $departmentId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // het verwijderde element weghalen
        $removeRowId = 'detail_row_' . $departmentId;
        InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
                                                        $removeRowId,
                                                        $removeRowId);
    }

    static function displayDetailEmployees( xajaxResponse $objResponse,
                                            $departmentId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
            $employeeIds    = DepartmentService::getEmployeeIdsForDepartment($departmentId);
            $collection     = BaseReportEmployeeService::getCollectionForDepartment($departmentId,
                                                                                    $employeeIds);

            $groupCollection = BaseReportEmployeeGroupCollection::create();
            $groupCollection->setCollection($departmentId,
                                            $collection);

            $popupHtml  = BaseReportEmployeePageBuilder::getEmployeesPopupHtml( self::INFO_DIALOG_WIDTH,
                                                                                self::INFO_CONTENT_HEIGHT,
                                                                                $groupCollection);


//            $popupHtml = DepartmentPageBuilder::getEmployeesPopupHtml(  self::INFO_DIALOG_WIDTH,
//                                                                        self::INFO_CONTENT_HEIGHT,
//                                                                        $departmentId);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::INFO_DIALOG_WIDTH,
                                            self::INFO_CONTENT_HEIGHT);
        }
    }

//    // hier geen safeform, zelf bossId controleren
//    static function displayDetailEmployeesForBoss(  xajaxResponse $objResponse,
//                                                    $bossId)
//    {
//        $applicationMenu = ApplicationNavigationService::getCurrentApplicationMenu();
//        $currentModule = ApplicationNavigationService::getCurrentApplicationModule($applicationMenu);
//        if (ApplicationNavigationService::isAllowedModule($currentModule)) {
//
//            $groupCollection = BaseReportEmployeeGroupCollection::create();
//
//            if ($bossId == BossFilterValue::ALL) {
//                $bossIdValues = EmployeeSelectService::getBossIdValues(EmployeeSelectService::INCLUDE_HAS_NO_BOSS);
//            } else {
//                $bossIdValues = array(EmployeeSelectService::getBossIdValue($bossId));
//            }
//
//            foreach ($bossIdValues as $bossIdValue) {
//                $bossId = $bossIdValue->getDatabaseId();
//                $collection = BaseReportEmployeeService::getCollection($bossId);
//                $groupCollection->setCollection($bossId,
//                                                $collection);
//            }
//
//            $popupHtml  = BaseReportEmployeePageBuilder::getEmployeesPopupHtml( self::INFO_DIALOG_WIDTH,
//                                                                                self::INFO_CONTENT_HEIGHT,
//                                                                                $groupCollection);
//
//            InterfaceXajax::showInfoDialog( $objResponse,
//                                            $popupHtml,
//                                            self::INFO_DIALOG_WIDTH,
//                                            self::INFO_CONTENT_HEIGHT);
//        }
//    }
//
//
    static function displayDetailUsers( $objResponse,
                                        $departmentId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_USERS)) {
            $popupHtml = DepartmentPageBuilder::geUsersPopupHtml(   self::INFO_DIALOG_WIDTH,
                                                                    self::INFO_CONTENT_HEIGHT,
                                                                    $departmentId);
            InterfaceXajax::showInfoDialog( $objResponse,
                                            $popupHtml,
                                            self::INFO_DIALOG_WIDTH,
                                            self::INFO_CONTENT_HEIGHT);
        }
    }

}

?>
