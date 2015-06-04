<?php

/**
 * Description of BaseReportEmployeeValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class BaseReportEmployeeValueObject extends BaseValueObject
{
    private $employeeName;
    private $departmentName;
    private $functionName;
    private $reportCount;
    private $isActive;

    static function createWithData($reportEmployeeData)
    {
        return new BaseReportEmployeeValueObject($reportEmployeeData[EmployeeFilterQueries::ID_FIELD], $reportEmployeeData);
    }

    protected function __construct( $reportEmployeeId,
                                    $reportEmployeeData)
    {
        parent::__construct($reportEmployeeId,
                            $reportEmployeeData['saved_by_user_id'],
                            $reportEmployeeData['saved_by_user'],
                            $reportEmployeeData['saved_datetime']);

        $this->isActive         = $reportEmployeeData['is_inactive'] == EMPLOYEE_IS_ACTIVE;
        $this->employeeName     = EmployeeNameConverter::displaySortable($reportEmployeeData['firstname'], $reportEmployeeData['lastname']);
        $this->departmentName   = $reportEmployeeData['department'];
        $this->functionName     = $reportEmployeeData['function'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isActive()
    {
        return $this->isActive;
    }

    function isInactive()
    {
        return !$this->isActive;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeeName()
    {
        return $this->employeeName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDepartmentName()
    {
        return $this->departmentName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getFunctionName()
    {
        return $this->functionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setReportCount($reportCount)
    {
        $this->reportCount = $reportCount;
    }

    function getReportCount()
    {
        return $this->reportCount;
    }


}

?>
