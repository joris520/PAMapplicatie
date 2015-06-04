<?php

/**
 * Description of PdpActionInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/report/BaseReportEmployeeInterfaceProcessor.class.php');

require_once('modules/model/service/library/PdpActionService.class.php');
require_once('modules/interface/state/PdpActionClusterSelectorState.class.php');
require_once('modules/interface/builder/library/PdpActionPageBuilder.class.php');

class PdpActionInterfaceProcessor
{
    const DISPLAY_WIDTH         = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const DIALOG_WIDTH          = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const DIALOG_HEIGHT         = 300;
    const REMOVE_DIALOG_WIDTH   = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const REMOVE_DIALOG_HEIGHT  = 180;
    const CLUSTER_DIALOG_WIDTH  = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const CLUSTER_DIALOG_HEIGHT = 80;

    const EDIT_USER_DEFINED_WIDTH           = EmployeePdpActionInterfaceProcessor::EDIT_WIDTH;
    const EDIT_USER_DEFINED_CONTENT_HEIGHT  = 500;

    const INFO_CONTENT_HEIGHT   = BaseReportEmployeeInterfaceProcessor::INFO_CONTENT_HEIGHT;
    const INFO_DIALOG_WIDTH     = BaseReportEmployeeInterfaceProcessor::INFO_DIALOG_WIDTH;


    static function displayView(xajaxResponse $objResponse,
                                $hiliteId = NULL)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

            $clusterGroupCollection         = PdpActionClusterService::getClusterCollections();

            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds();
                $userDefinedClusterGroupCollection = EmployeePdpActionService::getUserDefinedClusterGroupCollection($allowedEmployeeIds);
            }
            $contentHtml = PdpActionPageBuilder::getPageHtml(   self::DISPLAY_WIDTH,
                                                                $clusterGroupCollection,
                                                                $userDefinedClusterGroupCollection,
                                                                $hiliteId);

            $mainPanelHtml = ApplicationInterfaceBuilder::getMainPanelNewHtml(  $contentHtml,
                                                                                self::DISPLAY_WIDTH);

            ApplicationNavigationService::setCurrentApplicationModule(MODULE_PDP_ACTION_LIB);
            InterfaceXajax::setHtml($objResponse, 'modules_menu_panel', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_PDP_ACTION_LIB));
            InterfaceXajax::setHtml($objResponse, 'module_main_panel', $mainPanelHtml);

            // hilite animeren
            if (!empty($hiliteId)) {

                InterfaceXajax::hiliteNewElement($objResponse);
            }
        }
    }

    static function displayAdd( xajaxResponse $objResponse)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $valueObject = PdpActionValueObject::createWithData(NULL);

            $popupHtml = PdpActionPageBuilder::getAddPopupHtml( self::DIALOG_WIDTH,
                                                                self::DIALOG_HEIGHT,
                                                                $valueObject);
            InterfaceXajax::showAddDialog(  $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::DIALOG_HEIGHT);
        }
    }

    static function finishAdd(  xajaxResponse $objResponse,
                                $newPdpActionId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView(  $objResponse,
                            $newPdpActionId);
    }

    static function displayEdit(xajaxResponse $objResponse,
                                $pdpActionId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

            $valueObject = PdpActionService::getValueObject($pdpActionId);

            $popupHtml = PdpActionPageBuilder::getEditPopupHtml(self::DIALOG_WIDTH,
                                                                self::DIALOG_HEIGHT,
                                                                $valueObject);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::DIALOG_HEIGHT);
        }

    }

    static function finishEdit( xajaxResponse $objResponse,
                                $pdpActionId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView(  $objResponse,
                            $pdpActionId);
    }

    static function displayEditUserDefined( xajaxResponse $objResponse,
                                            $employeeId,
                                            $employeePdpActionId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $valueObject = EmployeePdpActionService::getUserDefinedValueObject( $employeeId,
                                                                                $employeePdpActionId);

            $popupHtml = EmployeePdpActionPageBuilder::getEditUserDefinedPopupHtml( self::EDIT_USER_DEFINED_WIDTH,
                                                                                    self::EDIT_USER_DEFINED_CONTENT_HEIGHT,
                                                                                    $valueObject);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_USER_DEFINED_WIDTH,
                                            self::EDIT_USER_DEFINED_CONTENT_HEIGHT);
        }

    }

    static function finishEditUserDefined(  xajaxResponse $objResponse,
                                            $pdpActionId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView(  $objResponse,
                            $pdpActionId);
    }


    static function displayRemove(  xajaxResponse $objResponse,
                                    $pdpActionId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

            $valueObject = PdpActionService::getValueObject($pdpActionId);

            $popupHtml = PdpActionPageBuilder::getRemovePopupHtml(  self::REMOVE_DIALOG_WIDTH,
                                                                    self::REMOVE_DIALOG_HEIGHT,
                                                                    $valueObject);

            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::REMOVE_DIALOG_WIDTH,
                                                self::REMOVE_DIALOG_HEIGHT);
        }
    }

    static function finishRemove(xajaxResponse $objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView(  $objResponse);
    }


    static function displayEditCluster(     xajaxResponse $objResponse,
                                            $clusterId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

            $clusterValueObject = PdpActionClusterService::getCluster($clusterId);

            $popupHtml = PdpActionPageBuilder::getEditClusterPopupHtml( self::CLUSTER_DIALOG_WIDTH,
                                                                        self::CLUSTER_DIALOG_HEIGHT,
                                                                        $clusterValueObject);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::CLUSTER_DIALOG_WIDTH,
                                            self::CLUSTER_DIALOG_HEIGHT);
        }

    }

    static function finishEditCluster(  xajaxResponse $objResponse,
                                        $clusterId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView($objResponse);
//        // het verwijderde element weghalen
//        $removeRowId = 'detail_row_' . $clusterId;
//        InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
//                                                        $removeRowId,
//                                                        $removeRowId);
    }

    static function displayRemoveCluster(   xajaxResponse $objResponse,
                                            $clusterId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

            $clusterValueObject = PdpActionClusterService::getCluster($clusterId);

            $popupHtml = PdpActionPageBuilder::getRemoveClusterPopupHtml(   self::CLUSTER_DIALOG_WIDTH,
                                                                            self::CLUSTER_DIALOG_HEIGHT,
                                                                            $clusterValueObject);

            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::CLUSTER_DIALOG_WIDTH,
                                                self::CLUSTER_DIALOG_HEIGHT);
        }
    }

    static function finishRemoveCluster(xajaxResponse $objResponse,
                                        $clusterId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        self::displayView($objResponse);
//        // het verwijderde element weghalen
//        $removeRowId = 'detail_row_' . $clusterId;
//        InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
//                                                        $removeRowId,
//                                                        $removeRowId);
    }

    // snelle print hack...
    static function displayPrint(xajaxResponse $objResponse)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
           InterfaceXajax::openInWindow($objResponse,
                                        'print/print_pdpactionlib.php?c=1',
                                        ApplicationInterfaceBuilder::PDF_PRINT_WINDOW_WIDTH,
                                        ApplicationInterfaceBuilder::PDF_PRINT_WINDOW_HEIGHT);
        }
    }


    static function displayDetailEmployees( $objResponse,
                                            $pdpActionId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds();
            $employeeIdValues = EmployeePdpActionService::getEmployeeIdValuesForPdpAction(  $pdpActionId,
                                                                                            $allowedEmployeeIds);

            $pdpActionIdValue = IdValue::create($pdpActionId, TXT_UCF('PDP_ACTION_USAGE'));
            $collection = BaseReportEmployeeService::getCollectionWithIdValues( $pdpActionIdValue,
                                                                                $employeeIdValues);

            $popupHtml = PdpActionPageBuilder::getEmployeesPopupHtml(   self::INFO_DIALOG_WIDTH,
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