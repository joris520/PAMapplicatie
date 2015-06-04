<?php

/**
 * Description of BaseBlockInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseBlockInterfaceObject extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'base/baseBlock.tpl';

    protected   $dataInterfaceObject;
    private     $additionalHeaderRows;
    private     $headerTitle;
    private     $hasFooter;
    private     $isSubHeader;

    static function create( BaseInterfaceObject $dataInterfaceObject,
                            $headerTitle,
                            $displayWidth)
    {
        return new BaseBlockInterfaceObject($dataInterfaceObject,
                                            $headerTitle,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);

    }

    protected function __construct( BaseInterfaceObject $dataInterfaceObject,
                                    $headerTitle,
                                    $displayWidth,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);

        $this->dataInterfaceObject  = $dataInterfaceObject;
        $this->headerTitle          = $headerTitle;
        $this->hasFooter            = false;
        $this->isSubHeader          = false;

        $this->additionalHeaderRows = array();
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

    function getHeaderTitleStyled()
    {
        return '<h2>' . self::getHeaderTitle() . '</h2>';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setHasFooter($hasFooter = true)
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
