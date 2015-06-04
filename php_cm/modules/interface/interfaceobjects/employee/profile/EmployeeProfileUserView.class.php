<?php

/**
 * Description of EmployeeProfileUserView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfileUserView extends BaseValueObjectInterfaceObject
{

    const TEMPLATE_FILE = 'employee/profile/employeeProfileUserView.tpl';

    private $addLink;
    private $hasUser;

    static function createWithValueObject(  UserValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfileUserView( $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $addLink
    function setAddLink($addLink)
    {
        $this->addLink = $addLink;
        $this->addActionLink($addLink);
    }

    function getAddLink()
    {
        return $this->addLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $editLink
    function setHasUser($hasUser)
    {
        $this->hasUser = $hasUser;
    }

    function hasUser()
    {
        return $this->hasUser;
    }
}

?>
