<?php

/**
 * Description of PdpActionDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  PdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionDelete( $valueObject,
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
