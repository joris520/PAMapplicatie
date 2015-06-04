<?php

/**
 * Description of EmployeeProfileInformationView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeeProfileInformationView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/profile/employeeProfileInformationView.tpl';

    private $editLink;
    private $isAllowedShowManagerInfo;

    static function createWithValueObject(  EmployeeProfileInformationValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeeProfileInformationView(  $valueObject,
                                                    $displayWidth,
                                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $editLink
    function setEditLink($editLink)
    {
        $this->editLink = $editLink;
        $this->addActionLink($editLink);
    }

    function getEditLink()
    {
        return $this->editLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isAllowedShowManagerInfo
    function setIsAllowedShowManagerInfo($isAllowedShowManagerInfo)
    {
        $this->isAllowedShowManagerInfo = $isAllowedShowManagerInfo;
    }

    function isAllowedShowManagerInfo()
    {
        return $this->isAllowedShowManagerInfo;
    }

}

?>
