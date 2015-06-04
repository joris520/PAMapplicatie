<?php

/**
 * Description of EmployeeTargetDelete
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeTargetDelete extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/target/employeeTargetDelete.tpl';

    private $confirmQuestion;

    static function createWithValueObject(  EmployeeTargetValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeTargetDelete($valueObject,
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
