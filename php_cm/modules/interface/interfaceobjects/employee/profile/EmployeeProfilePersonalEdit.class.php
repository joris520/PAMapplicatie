<?php

/**
 * Description of EmployeeProfilePersonalEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfilePersonalEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfilePersonalEdit.tpl';

    private $birthDatePicker;
    private $isEmailRequired;

    static function createWithValueObject(  EmployeeProfilePersonalValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfilePersonalEdit( $valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $birthDatePicker
    function setBirthDatePicker($birthDatePicker)
    {
        $this->birthDatePicker = $birthDatePicker;
    }

    function getBirthDatePicker()
    {
        return $this->birthDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isEmailRequired
    function setIsEmailRequired($isEmailRequired)
    {
        $this->isEmailRequired = $isEmailRequired;
    }

    function isEmailRequired()
    {
        return $this->isEmailRequired;
    }
}

?>
