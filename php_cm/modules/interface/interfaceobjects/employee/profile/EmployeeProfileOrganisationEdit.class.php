<?php

/**
 * Description of EmployeeProfileOrganisationEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfileOrganisationEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfileOrganisationEdit.tpl';

    private $employmentDatePicker;
    private $departmentIdValues;
    private $bossIdValues;
    private $isBossChecked;

    static function createWithValueObject(  EmployeeProfileOrganisationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfileOrganisationEdit( $valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employmentDatePicker
    function setEmploymentDatePicker($employmentDatePicker)
    {
        $this->employmentDatePicker = $employmentDatePicker;
    }

    function getEmploymentDatePicker()
    {
        return $this->employmentDatePicker;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $departmentIdValues
    function setDepartmentIdValues($departmentIdValues)
    {
        $this->departmentIdValues = $departmentIdValues;
    }

    function getDepartmentIdValues()
    {
        return $this->departmentIdValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $bossIdValues
    function setBossIdValues($bossIdValues)
    {
        $this->bossIdValues = $bossIdValues;
    }

    function getBossIdValues()
    {
        return $this->bossIdValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isBossChecked
    function setIsBossChecked($isBossChecked)
    {
        $this->isBossChecked = $isBossChecked;
    }

    function isBossChecked()
    {
        return $this->isBossChecked;
    }

}

?>
