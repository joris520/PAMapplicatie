<?php

/**
 * Description of EmployeeTargetBatchAdd
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeTargetBatchAdd extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'batch/employeeTargetBatchAdd.tpl';

    private $endDatePicker;
    private $employeesSelectorHtml;

    static function create($displayWidth)
    {
        return new EmployeeTargetBatchAdd(  $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEndDatePicker($endDatePicker)
    {
        $this->endDatePicker = $endDatePicker;
    }

    function getEndDatePicker()
    {
        return $this->endDatePicker;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeesSelectorHtml($employeesSelectorHtml)
    {
        $this->employeesSelectorHtml = $employeesSelectorHtml;
    }

    function getEmployeesSelectorHtml()
    {
        return $this->employeesSelectorHtml;
    }


}


?>
