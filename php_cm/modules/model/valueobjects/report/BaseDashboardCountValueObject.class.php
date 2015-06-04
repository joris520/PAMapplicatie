<?php

/**
 * Description of BaseDashboardCountValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class BaseDashboardCountValueObject extends BaseReportValueObject
{
    protected $employeesTotal;
    protected $employeesWithout;

    protected $employeeCounts;

    protected function __construct($bossId)
    {
        parent::__construct($bossId);

        $this->employeesTotal   = 0;
        $this->employeesWithout = 0;
        $this->employeeCounts   = array();

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeesTotal($employeesTotal)
    {
        $this->employeesTotal += $employeesTotal;
    }

    function getEmployeesTotal()
    {
        return $this->employeesTotal;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeesWithout($employeesWithout)
    {
        $this->employeesWithout += $employeesWithout;
    }

    function getEmployeesWithout()
    {
        return $this->employeesWithout;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeeCountForKey($key, $employeeCount)
    {
        $this->employeeCounts[$key] += $employeeCount;
    }

    function getEmployeeCountForKey($key)
    {
        return $this->employeeCounts[$key];
    }

    function getEmployeeCountKeys()
    {
        return array_keys($this->employeeCounts);
    }

}

?>
