<?php

/**
 * Description of BaseTitleInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseTitleInterfaceObject extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'base/baseTitle.tpl';

    private $additionalHeaderRows;
    private $headerTitle;
    private $hasFooter;
    private $isSubHeader;

    static function create( $headerTitle,
                            $displayWidth)
    {
        return new BaseTitleInterfaceObject($headerTitle,
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

//        $this->additionalHeaderRows = array();
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
    function getDataInterfaceObject()
    {
        return $this->dataInterfaceObject;
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
