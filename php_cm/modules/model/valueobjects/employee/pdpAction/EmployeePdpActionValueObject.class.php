<?php
/**
 * Description of EmployeePdpActionValueObject
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/BaseEmployeeValueObject.class.php');

class EmployeePdpActionValueObject extends BaseEmployeeValueObject
{
    private $useEmployeeId;
    private $ownerUserId;
    private $ownerEmployeeId;
    private $ownerName;

    private $pdpActionId;
    private $isUserDefined;

    private $actionName;
    private $provider;
    private $duration;
    private $cost;

    private $todoBeforeDate;
    private $emailAlertDate;
    private $completedStatus;
    private $note;

    static function createWithData( $employeeId,
                                    $employeePdpActionData)
    {
        return new EmployeePdpActionValueObject($employeeId,
                                                $employeePdpActionData[EmployeePdpActionQueries::ID_FIELD],
                                                $employeePdpActionData);
    }

    protected function __construct( $employeeId,
                                    $employeePdpActionId,
                                    $employeePdpActionData)
    {
        parent::__construct($employeeId,
                            $employeePdpActionId,
                            $employeePdpActionData['saved_by_user_id'], // hebben we nog niet
                            $employeePdpActionData['saved_by_user'],    // hebben we nog niet
                            $employeePdpActionData['saved_datetime']);  // hebben we nog niet

        $this->useEmployeeId    = $employeePdpActionData['use_action_owner'] == 1;
        $this->ownerUserId      = $employeePdpActionData['ID_PDPTOID'];
        $this->ownerEmployeeId  = $employeePdpActionData['action_owner'];
        $this->ownerName        = $employeePdpActionData['action_owner_name'];

        $this->pdpActionId      = $employeePdpActionData['ID_PDPAID'];
        $this->isUserDefined    = $employeePdpActionData['is_user_defined'] == 1;

        $this->actionName       = $employeePdpActionData['action'];
        $this->provider         = $employeePdpActionData['provider'];
        $this->duration         = $employeePdpActionData['duration'];
        $this->cost             = $employeePdpActionData['costs'];

        $this->todoBeforeDate   = $employeePdpActionData['pdp_end_date'];
        $this->emailAlertDate   = $employeePdpActionData['pdp_email_date'];
        $this->completedStatus  = $employeePdpActionData['is_completed'];
        $this->note             = $employeePdpActionData['notes'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function useEmployeeId()
    {
        return $this->useEmployeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getOwnerUserId()
    {
        return $this->ownerUserId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getOwnerEmployeeId()
    {
        return $this->ownerEmployeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPdpActionId()
    {
        return $this->pdpActionId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isUserDefined()
    {
        return $this->isUserDefined;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getOwnerName()
    {
        return $this->ownerName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getActionName()
    {
        return $this->actionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getProvider()
    {
        return $this->provider;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDuration()
    {
        return $this->duration;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCost()
    {
        return $this->cost;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getTodoBeforeDate()
    {
        return $this->todoBeforeDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmailAlertDate()
    {
        return $this->emailAlertDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getIsCompletedStatus()
    {
        return $this->completedStatus;
    }

    function isNotCompleted()
    {
        return $this->completedStatus == PdpActionCompletedStatusValue::NOT_COMPLETED;
    }

    function isCompleted()
    {
        return $this->completedStatus == PdpActionCompletedStatusValue::COMPLETED;
    }

    function isCancelled()
    {
        return $this->completedStatus == PdpActionCompletedStatusValue::CANCELLED;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getNote()
    {
        return $this->note;
    }

    function hasNote()
    {
        return !empty($this->note);
    }
}

?>
