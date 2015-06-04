<?php

/**
 * Description of OrganisationInfoInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/organisation/OrganisationInfoPageBuilder.class.php');
require_once('modules/process/tab/OrganisationTabInterfaceProcessor.class.php');

class OrganisationInfoInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;
    const CONTENT_HEIGHT = 200;
    const DIALOG_WIDTH = 800;

    static function displayView($objResponse)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_MENU_ORGANISATION)) {
            $viewHtml = OrganisationInfoPageBuilder::getPageHtml(self::DISPLAY_WIDTH);

            OrganisationTabInterfaceProcessor::displayContent(  $objResponse, self::DISPLAY_WIDTH, $viewHtml);
            ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_ORGANISATION_MENU_COMPANY_INFO);
        }
    }

    static function displayEdit($objResponse)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_MENU_ORGANISATION)) {

            $popupHtml = OrganisationInfoPageBuilder::getEditPopupHtml( self::DIALOG_WIDTH,
                                                                        self::CONTENT_HEIGHT,
                                                                        ApplicationInterfaceBuilder::HIDE_WARNING);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::CONTENT_HEIGHT);
        }
    }

    static function finishEdit($objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // opnieuw tonen
        self::displayView($objResponse);
    }

//    static function finishAddBatch($objResponse, $targetName, $employeeIdCount)
//    {
//        if (PermissionsService::isAddAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_TARGET)) {
//            $viewHtml = OrganisationInfoPageBuilder::getConfirmationAddHtml($targetName, $employeeIdCount);
//
//            InterfaceXajax::setHtml($objResponse, 'organisation-content', $viewHtml);
//        }
//    }
}

?>
