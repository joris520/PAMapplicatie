<?php

/**
 * Description of ManagerReportEmployeeValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class ManagerReportEmployeeValueObject extends BaseValueObject
{
    private $employeeName;
    private $departmentName;

    static function createWithData($managerReportEmployeeData)
    {
        return new ManagerReportEmployeeValueObject($managerReportEmployeeData[EmployeeFilterQueries::ID_FIELD], $managerReportEmployeeData);
    }

    protected function __construct($managerReportEmployeeId, $managerReportEmployeeData)
    {
        parent::__construct($managerReportEmployeeId,
                            $managerReportEmployeeData['saved_by_user_id'],
                            $managerReportEmployeeData['saved_by_user'],
                            $managerReportEmployeeData['saved_datetime']);

        $this->employeeName     = EmployeeNameConverter::displaySortable($managerReportEmployeeData['firstname'], $managerReportEmployeeData['lastname']);
        $this->departmentName   = $managerReportEmployeeData['department'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function getEmployeeName()
    {
        return $this->employeeName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    //
    function getDepartmentName()
    {
        return $this->departmentName;
    }
}

?>
