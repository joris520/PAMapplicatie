<?php

/**
 * Description of EmployeeProfileInformationEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfileInformationEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfileInformationEdit.tpl';

    private $isEditAllowedManagerInfo;

    static function createWithValueObject(  EmployeeProfileInformationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfileInformationEdit(  $valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isEditAllowedManagerInfo
    function setIsEditAllowedManagerInfo($isEditAllowedManagerInfo)
    {
        $this->isEditAllowedManagerInfo = $isEditAllowedManagerInfo;
    }

    function isEditAllowedManagerInfo()
    {
        return $this->isEditAllowedManagerInfo;
    }

}

?>
