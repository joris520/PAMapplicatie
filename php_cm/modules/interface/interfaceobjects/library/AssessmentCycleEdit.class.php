<?php


/**
 * Description of AssessmentCycleEdit
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class AssessmentCycleEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleEdit.tpl';

    private $startDatePicker;

    static function createWithValueObject(  AssessmentCycleValueObject $valueObject,
                                            $displayWidth)
    {
        return new AssessmentCycleEdit( $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setStartDatePicker($startDatePicker)
    {
        $this->startDatePicker = $startDatePicker;
    }

    function getStartDatePicker()
    {
        return $this->startDatePicker;
    }
}

?>
