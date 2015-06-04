<?php


/**
 * Description of QuestionDelete
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class QuestionDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/questionDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  QuestionValueObject $valueObject,
                                            $displayWidth)
    {
        return new QuestionDelete(  $valueObject,
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
