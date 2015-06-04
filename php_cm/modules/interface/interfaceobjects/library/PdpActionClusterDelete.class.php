<?php

/**
 * Description of PdpActionClusterDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionClusterDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionClusterDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  PdpActionClusterValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionClusterDelete(  $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setConfirmQuestion($confirmQuestion)
    {
        $this->confirmQuestion = $confirmQuestion;
    }

    function getConfirmQuestion()
    {
        return $this->confirmQuestion;
    }
}

?>
