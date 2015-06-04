<?php

/**
 * Description of BaseContentTabInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/tab/GenericContentTabView.class.php');

class BaseContentTabInterfaceBuilder
{
    static function getContentViewHtml( $contentWidth,
                                        $contentPanelHtmlId,
                                        $contentHtml)
    {
        // template interfaceObject
        $interfaceObject = GenericContentTabView::create(   $contentWidth,
                                                            $contentPanelHtmlId);
        $interfaceObject->setContentHtml(   $contentHtml);
        return $interfaceObject->fetchHtml();
    }
}

?>
