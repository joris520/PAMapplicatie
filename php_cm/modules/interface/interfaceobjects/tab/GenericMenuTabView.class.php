<?php

/**
 * Description of GenericMenuTabView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class GenericMenuTabView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'tab/genericMenuTabView.tpl';

    private $menuHtml;
    private $contentHtml;

    private $menuPanelHtmlId;
    private $contentPanelHtmlId;

    static function create( $displayWidth,
                            $menuPanelHtmlId,
                            $contentPanelHtmlId)
    {
        return new GenericMenuTabView(  $displayWidth,
                                        $menuPanelHtmlId,
                                        $contentPanelHtmlId);
    }

    protected function __construct( $displayWidth,
                                    $menuPanelHtmlId,
                                    $contentPanelHtmlId)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);
        
        $this->menuPanelHtmlId = $menuPanelHtmlId;
        $this->contentPanelHtmlId = $contentPanelHtmlId;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setMenuHtml($menuHtml)
    {
        $this->menuHtml = $menuHtml;
    }

    function getMenuHtml()
    {
        return $this->menuHtml;
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
    function getMenuPanelHtmlId()
    {
        return $this->menuPanelHtmlId;
    }

    function getContentPanelHtmlId()
    {
        return $this->contentPanelHtmlId;

    }
}

?>
