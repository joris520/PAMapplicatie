<?php

/**
 * Description of BaseHistoryInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');
require_once('application/model/valueobjects/BaseValueObject.class.php');

class BaseHistoryInterfaceObject extends BaseInterfaceObject
{
    private $valueObjects;

    function __construct(   $displayWidth,
                            $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);

        $this->valueObjects = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // protected want overervende classe moet met type hinting een addValueObject hebben
    protected function addValueObject(BaseValueObject $valueObject)
    {
        $this->valueObjects[] = $valueObject;
    }

    function getValueObjects()
    {
        return $this->valueObjects;
    }
}

?>
