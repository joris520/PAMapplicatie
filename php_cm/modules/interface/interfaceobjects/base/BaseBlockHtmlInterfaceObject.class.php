<?php

/**
 * Description of BaseBlockHtmlInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');


// speciaal voor de oude code zonder interfaceobjecten, om daar toch een nieuw block omheen te kunnen zetten...
class BaseBlockHtmlInterfaceObject extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'base/baseBlockHtml.tpl';

    private $contentHtml;
    private $additionalHeaderRows;
    private $headerTitle;
    private $hasFooter;
    private $isSubHeader;

    static function create( $headerTitle,
                            $displayWidth)
    {
        return new BaseBlockHtmlInterfaceObject($headerTitle,
                                                $displayWidth);

    }

    protected function __construct( $headerTitle,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->headerTitle          = $headerTitle;
        $this->hasFooter            = false;
        $this->isSubHeader          = false;

        $this->additionalHeaderRows = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setContentHtml($contentHtml)
    {
        $this->contentHtml = $contentHtml;
    }

    function getContentHtml()
    {
        return $this->contentHtml;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addAdditionalHeaderRow(BaseBlockHeaderRowInterfaceObject $additionalRow)
    {
        $this->additionalHeaderRows[] = $additionalRow;
    }

    function getAdditionalHeaderRows()
    {
        return $this->additionalHeaderRows;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getHeaderTitle()
    {
        return $this->headerTitle;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHasFooter($hasFooter)
    {
        $this->hasFooter = $hasFooter;
    }

    function hasFooter()
    {
        return $this->hasFooter;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsSubHeader($isSubHeader = true)
    {
        $this->isSubHeader = $isSubHeader;
    }

    function isSubHeader()
    {
        return $this->isSubHeader;
    }

}

?>
