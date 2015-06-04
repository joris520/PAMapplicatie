<?php

/**
 * Description of GenericContentTabView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class GenericContentTabView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'tab/genericContentTabView.tpl';

    private $contentPanelHtmlId;
    private $contentHtml;

    static function create( $displayWidth,
                            $contentPanelHtmlId)
    {
        return new GenericContentTabView(   $displayWidth,
                                            $contentPanelHtmlId);
    }

    protected function __construct( $displayWidth,
                                    $contentPanelHtmlId)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->contentPanelHtmlId = $contentPanelHtmlId;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setContentHtml($contentHtml)
    {
        $this->contentHtml = $contentHtml;
    }

    function getContentHtml()
    {
        return $this->contentHtml;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getContentPanelHtmlId()
    {
        return $this->contentPanelHtmlId;

    }
}

?>
