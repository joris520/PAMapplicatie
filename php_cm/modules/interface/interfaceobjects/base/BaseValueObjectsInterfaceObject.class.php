<?php

/**
 * Description of BaseValueObjectsInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class BaseValueObjectsInterfaceObject extends BaseValueObjectInterfaceObject
{
    protected $previousValueObject;

    function __construct(   BaseValueObject $valueObject,
                            BaseValueObject $previousValueObject,
                            $displayWidth,
                            $templateFile)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            $templateFile);

        $this->previousValueObject  = $previousValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPreviousValueObject()
    {
        return $this->previousValueObject;
    }

}
?>
