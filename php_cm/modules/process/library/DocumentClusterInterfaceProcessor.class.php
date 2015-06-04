<?php


/**
 * Description of DocumentClusterInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/library/DocumentClusterPageBuilder.class.php');

class DocumentClusterInterfaceProcessor
{

    const PANEL_WIDTH       = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;
    const DISPLAY_WIDTH     = ApplicationInterfaceBuilder::SIMPLE_VIEW_WIDTH;
    const DIALOG_WIDTH      = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const CONTENT_HEIGHT    = 80;

    static function displayView($objResponse,
                                $hiliteId = NULL)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {
            ApplicationNavigationService::setCurrentApplicationModule(MODULE_DOCUMENT_CLUSTERS);

            $contentHtml   = DocumentClusterPageBuilder::getPageHtml(   self::DISPLAY_WIDTH,
                                                                        $hiliteId);
            $mainPanelHtml = ApplicationInterfaceBuilder::getMainPanelNewHtml(  $contentHtml,
                                                                                self::DISPLAY_WIDTH);

            InterfaceXajax::setHtml($objResponse, 'modules_menu_panel', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_DOCUMENT_CLUSTERS));
            InterfaceXajax::setHtml($objResponse, 'module_main_panel', $mainPanelHtml);

            // hilite animeren
            if (!empty($hiliteId)) {
                InterfaceXajax::hiliteNewElement($objResponse);
            }
        }
    }

    static function displayAdd($objResponse)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {

            $popupHtml = DocumentClusterPageBuilder::getAddPopupHtml(   self::DIALOG_WIDTH,
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
                                $documentClusterId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {

            $popupHtml = DocumentClusterPageBuilder::getEditPopupHtml(  self::DIALOG_WIDTH,
                                                                        self::CONTENT_HEIGHT,
                                                                        $documentClusterId,
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
                                    $documentClusterId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {

            $popupHtml = DocumentClusterPageBuilder::getRemovePopupHtml(    self::DIALOG_WIDTH,
                                                                            self::CONTENT_HEIGHT,
                                                                            $documentClusterId);

            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::CONTENT_HEIGHT);
        }
    }

    static function finishRemove(   $objResponse,
                                    $documentClusterId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // het verwijderde element weghalen
        $removeRowId = 'detail_row_' . $documentClusterId;
        InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
                                                        $removeRowId,
                                                        $removeRowId);
    }

}

?>
