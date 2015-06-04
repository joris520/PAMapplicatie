<?php

/**
 * Description of AssessmentProcessResultValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/assessmentProcess/BaseProcessResultValueObject.class.php');

class AssessmentProcessResultValueObject extends BaseProcessResultValueObject
{
    private $action;

    private $status;
    private $employeeCount;
    private $closedCount;
    private $updatedCount;
    private $invitationCount;

    static function create($bossId, $action)
    {
        return new AssessmentProcessResultValueObject($bossId, $action);
    }

    protected function __construct($bossId, $action)
    {
        parent::__construct($bossId);
        $this->action = $action;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getAction()
    {
        return $this->action;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setStatus($status)
    {
        $this->status = $status;
    }

    function getStatus()
    {
        return $this->status;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setEmployeeCount($employeeCount)
    {
        $this->employeeCount = $employeeCount;
    }

    function getEmployeeCount()
    {
        return $this->employeeCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClosedCount($closedCount)
    {
        $this->closedCount = $closedCount;
    }

    function getClosedCount()
    {
        return $this->closedCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setUpdatedCount($updatedCount)
    {
        $this->updatedCount = $updatedCount;
    }

    function getUpdatedCount()
    {
        return $this->updatedCount;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setInvitationCount($invitationCount)
    {
        $this->invitationCount = $invitationCount;
    }

    function getInvitationCount()
    {
        return $this->invitationCount;
    }

}

?>
