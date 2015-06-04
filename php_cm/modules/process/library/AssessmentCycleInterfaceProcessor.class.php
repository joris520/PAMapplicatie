<?php

/**
 * Description of AssessmentCycleInterfaceProcessor
 *
 * @author hans.prins
 */

require_once('modules/interface/builder/library/AssessmentCyclePageBuilder.class.php');

class AssessmentCycleInterfaceProcessor
{
    const PANEL_WIDTH = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;
    const DISPLAY_WIDTH = 750;
    const DIALOG_WIDTH  = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const CONTENT_HEIGHT = 120;


    static function displayView($objResponse,
                                $hiliteId = NULL)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_ASSESSMENT_CYCLE)) {
            ApplicationNavigationService::setCurrentApplicationModule(MODULE_ASSESSMENT_CYCLE);

            $contentHtml    = AssessmentCyclePageBuilder::getPageHtml(  self::DISPLAY_WIDTH,
                                                                        $hiliteId);
            $mainPanelHtml  = ApplicationInterfaceBuilder::getMainPanelNewHtml( $contentHtml,
                                                                                self::DISPLAY_WIDTH);

            InterfaceXajax::setHtml($objResponse, 'modules_menu_panel', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_ASSESSMENT_CYCLE));
            InterfaceXajax::setHtml($objResponse, 'module_main_panel', $mainPanelHtml);

            // hilite animeren
            if (!empty($hiliteId)) {
                InterfaceXajax::hiliteNewElement($objResponse);
            }
        }
    }

    static function displayAdd($objResponse)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_ASSESSMENT_CYCLE)) {

            $popupHtml = AssessmentCyclePageBuilder::getAddPopupHtml(   self::DIALOG_WIDTH,
                                                                        self::CONTENT_HEIGHT);
            InterfaceXajax::showAddDialog(  $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::CONTENT_HEIGHT);
        }
    }

    static function finishAdd($objResponse, $hiliteId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele lijst opnieuw tonen
        self::displayView($objResponse, $hiliteId);
    }

    static function displayEdit($objResponse, $assessmentCycleId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_ASSESSMENT_CYCLE)) {

            $popupHtml = AssessmentCyclePageBuilder::getEditPopupHtml(  self::DIALOG_WIDTH,
                                                                        self::CONTENT_HEIGHT,
                                                                        $assessmentCycleId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::DIALOG_WIDTH,
                                            self::CONTENT_HEIGHT);
        }
    }

    static function finishEdit($objResponse, $hiliteId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        // de hele lijst opnieuw tonen
        self::displayView($objResponse, $hiliteId);
    }

    static function displayRemove($objResponse, $assessmentCycleId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_ASSESSMENT_CYCLE)) {

            $popupHtml = AssessmentCyclePageBuilder::getRemovePopupHtml(    self::DIALOG_WIDTH,
                                                                            self::CONTENT_HEIGHT,
                                                                            $assessmentCycleId);
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::CONTENT_HEIGHT);
        }
    }

    static function finishRemove($objResponse, $assessmentCycleId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // het verwijderde element weghalen
        $removeRowId = 'detail_row_' . $assessmentCycleId;
        InterfaceXajax::fadeOutDetailAndClearContent($objResponse, $removeRowId, $removeRowId);
    }

}

?>
