<?php

/**
 * Description of SelfAssessmentDashboardCountValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseReportValueObject.class.php');

class SelfAssessmentDashboardCountValueObject extends BaseReportValueObject
{
    protected $invitedTotal;
    protected $employeeNotCompleted;
    protected $employeeCompleted;
    protected $employeeDeleted;
    protected $bossNotCompleted;
    protected $bossCompleted;
    protected $bothCompleted;

    // de create kan zonder id
    static function create()
    {
        return new SelfAssessmentDashboardCountValueObject(NULL);
    }

    // letop: de construct MET id
    protected function __construct($bossId)
    {
        parent::__construct($bossId);
        $this->invitedTotal         = 0;
        $this->employeeNotCompleted = 0;
        $this->employeeCompleted    = 0;
        $this->employeeDeleted      = 0;
        $this->bossNotCompleted     = 0;
        $this->bossCompleted        = 0;
        $this->bothCompleted        = 0;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInvitedTotal($invitedTotal)
    {
        $this->invitedTotal += $invitedTotal;
    }

    function getInvitedTotal()
    {
        return $this->invitedTotal;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeeNotCompleted($employeeNotCompleted)
    {
        $this->employeeNotCompleted += $employeeNotCompleted;
    }

    function getEmployeeNotCompleted()
    {
        return $this->employeeNotCompleted;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeeCompleted($employeeCompleted)
    {
        $this->employeeCompleted += $employeeCompleted;
    }

    function getEmployeeCompleted()
    {
        return $this->employeeCompleted;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addEmployeeDeleted($employeeDeleted)
    {
        $this->employeeDeleted += $employeeDeleted;
    }

    function getEmployeeDeleted()
    {
        return $this->employeeDeleted;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addBossNotCompleted($bossNotCompleted)
    {
        $this->bossNotCompleted += $bossNotCompleted;
    }

    function getBossNotCompleted()
    {
        return $this->bossNotCompleted;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addBossCompleted($bossCompleted)
    {
        $this->bossCompleted += $bossCompleted;
    }

    function getBossCompleted()
    {
        return $this->bossCompleted;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addBothCompleted($bothCompleted)
    {
        $this->bothCompleted += $bothCompleted;
    }

    function getBothCompleted()
    {
        return $this->bothCompleted;
    }

}

?>
