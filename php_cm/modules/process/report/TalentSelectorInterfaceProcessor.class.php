<?php

/**
 * Description of TalentSelectorInterfaceProcessor
 *
 * @au
 * thor hans.prins
 */
require_once('modules/interface/builder/reports/TalentSelectorPageBuilder.class.php');

class TalentSelectorInterfaceProcessor
{
    const GRID_WIDTH    = 450;
    const RESULT_WIDTH  = ApplicationInterfaceBuilder::DETAIL_WIDTH;

    static function displayView($objResponse)
    {
        if (PermissionsService::isAccessAllowed(PERMISSION_TALENT_SELECTOR)) {
            ApplicationNavigationService::setCurrentApplicationModule(MODULE_TALENT_SELECTOR);

            $contentHtml = TalentSelectorPageBuilder::getPageHtml(self::GRID_WIDTH);

            InterfaceXajax::setHtml($objResponse, MODULE_MENU_PANEL, ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_TALENT_SELECTOR));
            InterfaceXajax::setHtml($objResponse, TalentSelectorInterfaceBuilder::LEFT_PANEL_HTML_ID, $contentHtml);
        }
    }

    static function finishExecute($objResponse, $hasError, TalentSelectorResultCollection $resultCollection)
    {
        if (PermissionsService::isAccessAllowed(PERMISSION_TALENT_SELECTOR)) {

            $safeFormHtml = TalentSelectorPageBuilder::getResultPageHtml(self::RESULT_WIDTH, $resultCollection);

            if (!$hasError) {
                InterfaceXajax::setHtml($objResponse, TalentSelectorInterfaceBuilder::RIGHT_PANEL_HTML_ID, $safeFormHtml);
            } else {
                InterfaceXajax::setHtml($objResponse, TalentSelectorInterfaceBuilder::RIGHT_PANEL_HTML_ID, '');
            }
            InterfaceXajax::enableButton($objResponse, PROCESS_BUTTON);
        }
    }
}

?>
