<?php

/**
 * Description of TalentSelectorTabInterfaceProcessor
 *
 * @author hans.prins
 */
require_once('modules/interface/builder/tab/TalentSelectorTabPageBuilder.class.php');
require_once('modules/process/report/TalentSelectorInterfaceProcessor.class.php');

class TalentSelectorTabInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::DETAIL_WIDTH;
    const GRID_WIDTH    = 200;
    const RESULT_WIDTH  = ApplicationInterfaceBuilder::DETAIL_WIDTH;

    static function displayView($objResponse)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_TALENT_SELECTOR)) {
            ApplicationNavigationService::setCurrentApplicationModule(MODULE_TALENT_SELECTOR);

            $contentHtml  = TalentSelectorTabPageBuilder::getPageHtml(self::DISPLAY_WIDTH, self::GRID_WIDTH, self::RESULT_WIDTH);

            InterfaceXajax::setHtml($objResponse, 'module_main_panel', $contentHtml);

            TalentSelectorInterfaceProcessor::displayView($objResponse);
        }
    }
}

?>
