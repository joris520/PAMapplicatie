<?php

/**
 * Description of DepartmentView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class DepartmentView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/departmentView.tpl';

    private $editLink;
    private $removeLink;

    private $employeeDetailLink;
    private $userDetailLink;

    static function createWithValueObject(  DepartmentValueObject $valueObject,
                                            $displayWidth)
    {
        return new DepartmentView(  $valueObject,
                                    $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEditLink($editLink)
    {
        $this->editLink = $editLink;
    }

    function getEditLink()
    {
        return $this->editLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setRemoveLink($removeLink)
    {
        $this->removeLink = $removeLink;
    }

    function getRemoveLink()
    {
        return $this->removeLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeDetailLink($employeeDetailLink)
    {
        $this->employeeDetailLink = $employeeDetailLink;
    }

    function getEmployeeDetailLink()
    {
        return $this->employeeDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setUserDetailLink($userDetailLink)
    {
        $this->userDetailLink = $userDetailLink;
    }

    function getUserDetailLink()
    {
        return $this->userDetailLink;
    }


}

?>
