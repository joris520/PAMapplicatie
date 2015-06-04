<?php

/**
 * Description of PdpActionSelectClusterView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionSelectClusterView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionSelectClusterView.tpl';

    private $selectLink;
    private $isSelected;

    static function createWithValueObject(  PdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionSelectClusterView(  $valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSelectLink($selectLink)
    {
        $this->selectLink = $selectLink;
    }

    function getSelectLink()
    {
        return $this->selectLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;
    }

    function isSelected()
    {
        return $this->isSelected;
    }


}

?>
