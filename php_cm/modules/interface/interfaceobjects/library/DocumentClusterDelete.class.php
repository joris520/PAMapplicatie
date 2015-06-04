<?php


/**
 * Description of DocumentClusterDelete
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class DocumentClusterDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/documentClusterDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  DocumentClusterValueObject $valueObject,
                                            $displayWidth)
    {
        return new DocumentClusterDelete(   $valueObject,
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
