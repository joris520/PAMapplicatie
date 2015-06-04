<?php

/**
 * Description of StandardDateEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class StandardDateEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'settings/standardDateEdit.tpl';

    private $defaultEndDatePicker;

    static function createWithValueObject(  StandardDateValueObject $valueObject,
                                            $displayWidth)
    {
        return new StandardDateEdit($valueObject,
                                    $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDefaultEndDatePicker($defaultEndDatePicker)
    {
        $this->defaultEndDatePicker = $defaultEndDatePicker;
    }

    function getDefaultEndDatePicker()
    {
        return $this->defaultEndDatePicker;
    }

}

?>
