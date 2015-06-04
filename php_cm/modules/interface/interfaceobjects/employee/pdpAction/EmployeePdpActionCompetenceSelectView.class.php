<?php

/**
 * Description of EmployeePdpActionCompetenceSelectView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeePdpActionCompetenceSelectView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionCompetenceSelectView.tpl';

    private $isSelected;
    private $checkboxPrefix;

    static function createWithValueObject(  EmployeeCompetenceValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeePdpActionCompetenceSelectView(   $valueObject,
                                                            $displayWidth,
                                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsSelected($isSelected)
    {
        $this->isSelected = $isSelected;
    }

    function isSelected()
    {
        return $this->isSelected;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCheckboxPrefix($checkboxPrefix)
    {
        $this->checkboxPrefix = $checkboxPrefix;
    }

    function getCheckboxPrefix()
    {
        return $this->checkboxPrefix;
    }

}

?>
