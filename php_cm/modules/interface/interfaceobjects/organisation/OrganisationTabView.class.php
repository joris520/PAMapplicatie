<?php

/**
 * Description of OrganisationTabView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class OrganisationTabView extends BaseInterfaceObject
{
    private $menuHtml;
    private $contentHtml;

    static function create($displayWidth)
    {
        return new OrganisationTabView($displayWidth);
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

}

?>
