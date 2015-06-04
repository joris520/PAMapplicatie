<?php

/**
 * Description of StandardDateInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/settings/StandardDatePageBuilder.class.php');

class StandardDateInterfaceProcessor
{
    const DISPLAY_WIDTH     = ApplicationInterfaceBuilder::SIMPLE_VIEW_WIDTH;
    const PANEL_WIDTH       = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;
    const EDIT_WIDTH        = 400;
    const CONTENT_HEIGHT    = 60;

    static function displayView($objResponse)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_DEFAULT_DATE)) {
            ApplicationNavigationService::setCurrentApplicationModule(MODULE_DEFAULT_DATE);

            $contentHtml    = StandardDatePageBuilder::getPageHtml(self::DISPLAY_WIDTH);
            $mainPanelHtml  = ApplicationInterfaceBuilder::getMainPanelNewHtml( $contentHtml,
                                                                                self::DISPLAY_WIDTH);

            InterfaceXajax::setHtml($objResponse, 'modules_menu_panel', ApplicationNavigationInterfaceBuilder::buildSettingsMenu(MODULE_DEFAULT_DATE));
            InterfaceXajax::setHtml($objResponse, 'module_main_panel', $mainPanelHtml);
        }
    }

    static function displayEdit($objResponse)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_DEFAULT_DATE)) {

            $popupHtml = StandardDatePageBuilder::getEditPopupHtml( self::EDIT_WIDTH,
                                                                    self::CONTENT_HEIGHT,
                                                                    ApplicationInterfaceBuilder::HIDE_WARNING);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::CONTENT_HEIGHT);
        }
    }

    static function finishEdit($objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // opnieuw tonen
        self::displayView($objResponse);
    }

}

?>
