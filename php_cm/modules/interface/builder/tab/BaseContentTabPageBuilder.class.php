<?php

/**
 * Description of BaseContentTabPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/tab/BaseContentTabInterfaceBuilder.class.php');

class BaseContentTabPageBuilder
{
    static function getContentPageHtml( $contentWidth,
                                        $contentPanelHtmlId,
                                        $contentHtml)
    {
        return BaseContentTabInterfaceBuilder::getContentViewHtml( $contentWidth,
                                                                    $contentPanelHtmlId,
                                                                    $contentHtml);
    }
}

?>
