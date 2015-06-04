<?php

/**
 * Description of BaseValueObjectInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class BaseValueObjectInterfaceObject extends BaseInterfaceObject
{
    protected $valueObject;

    protected function __construct( BaseValueObject $valueObject,
                                    $displayWidth,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);

        $this->valueObject = $valueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getValueObject()
    {
        return $this->valueObject;
    }

}

?>
