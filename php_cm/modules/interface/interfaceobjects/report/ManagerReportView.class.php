<?php

/**
 * Description of ManagerReportView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class ManagerReportView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/managerReportView.tpl';

    private $employeeDetailLink;
    private $departmentDetailLink;

    static function createWithValueObject(  ManagerReportValueObject $valueObject,
                                            $displayWidth)
    {
        return new ManagerReportView(   $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
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
    function setDepartmentDetailLink($departmentDetailLink)
    {
        $this->departmentDetailLink = $departmentDetailLink;
    }

    function getDepartmentDetailLink()
    {
        return $this->departmentDetailLink;
    }


}

?>
