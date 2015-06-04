<?php


/**
 * Description of AssessmentCycleDelete
 *
 * @author hans.prins
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class AssessmentCycleDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  AssessmentCycleValueObject $valueObject,
                                            $displayWidth)
    {
        return new AssessmentCycleDelete(   $valueObject,
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
