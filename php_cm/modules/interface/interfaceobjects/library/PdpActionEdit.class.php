<?php

/**
 * Description of PdpActionEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionEdit.tpl';

    private $clusterIdValues;

    static function createWithValueObject(  PdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionEdit(   $valueObject,
                                    $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClusterIdValues($clusterIdValues)
    {
        $this->clusterIdValues = $clusterIdValues;
    }

    function getClusterIdValues()
    {
        return $this->clusterIdValues;
    }
}

?>
