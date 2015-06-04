<?php

/**
 * Description of EmployeeProfileUserEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfileUserEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfileUserEdit.tpl';

    private $userLevelMode;

    static function createWithValueObject(  EmployeeProfilePersonalValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfileUserEdit( $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $userLevelMode
    function setUserLevelMode($userLevelMode)
    {
        $this->userLevelMode = $userLevelMode;
    }

    function getUserLevelMode()
    {
        return $this->userLevelMode;
    }

}

?>
