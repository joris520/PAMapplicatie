<?php

/**
 * Description of BaseContentTabInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/tab/BaseContentTabPageBuilder.class.php');

class BaseContentTabInterfaceProcessor
{
    const CONTENT_PANEL = 'base-content';

    static function displayContent($objResponse, $displayWidth, $contentHtml)
    {
        $viewHtml = BaseContentTabPageBuilder::getContentPageHtml($displayWidth, self::CONTENT_PANEL, $contentHtml);
        InterfaceXajax::setHtml($objResponse, 'module_main_panel', $viewHtml);
    }
}

?>
