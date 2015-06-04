<?php

/**
 * Description of BaseValueObjectPrintOptionsInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BasePrintOptionsInterfaceObject.class.php');

class BaseValueObjectPrintOptionsInterfaceObject extends BasePrintOptionsInterfaceObject
{
    private $valueObject;

    protected function __construct( BasePrintOptionValueObject $valueObject,
                                    $displayWidth,
                                    $detailIndentation,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $detailIndentation,
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
