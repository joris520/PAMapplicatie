<?php

/**
 * Description of QuestionInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/library/QuestionPageBuilder.class.php');

class QuestionInterfaceProcessor
{
    const PANEL_WIDTH       = ApplicationInterfaceBuilder::MAIN_PANEL_SIMPLE_CONTENT;
    const DIALOG_WIDTH      = 600;

    const VIEW_WIDTH        = 750;
    const CONTENT_HEIGHT    = 120;

    static function displayView($objResponse, $hiliteId = NULL, $activeQuestionsOnly = true)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_QUESTIONS_LIBRARY)) {
            ApplicationNavigationService::setCurrentApplicationModule(MODULE_QUESTIONS);

            $contentHtml   = QuestionPageBuilder::getPageHtml(  self::VIEW_WIDTH,
                                                                $hiliteId,
                                                                $activeQuestionsOnly);

            $mainPanelHtml = ApplicationInterfaceBuilder::getMainPanelNewHtml(  $contentHtml,
                                                                                self::VIEW_WIDTH);

            InterfaceXajax::setHtml($objResponse, 'modules_menu_panel', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_QUESTIONS));
            InterfaceXajax::setHtml($objResponse, 'module_main_panel', $mainPanelHtml);

            // hilite animeren
            if (!empty($hiliteId)) {
                InterfaceXajax::hiliteNewElement($objResponse);
            }
        }
    }

    static function displayAdd($objResponse)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_QUESTIONS_LIBRARY)) {

            $popupHtml = QuestionPageBuilder::getAddPopupHtml(  self::DIALOG_WIDTH,
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
                                $questionId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_QUESTIONS_LIBRARY)) {

            $popupHtml = QuestionPageBuilder::getEditPopupHtml( self::DIALOG_WIDTH,
                                                                self::CONTENT_HEIGHT,
                                                                $questionId,
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
                                    $questionId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_QUESTIONS_LIBRARY)) {

            $popupHtml = QuestionPageBuilder::getRemovePopupHtml(   self::DIALOG_WIDTH,
                                                                    self::CONTENT_HEIGHT,
                                                                    $questionId);

            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::DIALOG_WIDTH,
                                                self::CONTENT_HEIGHT);
        }
    }

    static function finishRemove(   $objResponse,
                                    $questionId)
    {
        InterfaceXajax::closeFormDialog($objResponse);

        // het verwijderde element weghalen
        $removeRowId = 'detail_row_' . $questionId;
        InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
                                                        $removeRowId,
                                                        $removeRowId);
    }
}

?>
