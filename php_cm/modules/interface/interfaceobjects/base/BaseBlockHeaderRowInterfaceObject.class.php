<?php

/**
 * Description of BaseBlockHeaderRowInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseBlockHeaderRowInterfaceObject extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'base/baseBlockHeaderRow.tpl';

    private $contentInterfaceObject;

    static function create( BaseInterfaceObject $contentInterfaceObject,
                            $displayWidth)
    {
        return new BaseBlockHeaderRowInterfaceObject(   $contentInterfaceObject,
                                                        $displayWidth);

    }

    protected function __construct( BaseInterfaceObject $contentInterfaceObject,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->contentInterfaceObject  = $contentInterfaceObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getContentInterfaceObject()
    {
        return $this->contentInterfaceObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setRowClass($rowClass)
    {
        $this->rowClass = $rowClass;
    }

    function getRowClass()
    {
        return $this->rowClass;
    }


}

?>
