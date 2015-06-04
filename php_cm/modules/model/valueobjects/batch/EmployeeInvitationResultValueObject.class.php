<?php

/**
 * Description of EmployeeInvitationResultValueObject
 *
 * @author ben.dokter
 */
require_once('modules/model/value/batch/InvitationStatusValue.class.php');
require_once('modules/model/valueobjects/batch//BaseBatchValueObject.class.php');

class EmployeeInvitationResultValueObject extends BaseBatchValueObject
{
    private $employeeId;
    private $employeeName;
    private $employeeEmail;
    private $mainFunctionName;

    private $invitationHashId;
    private $invitationStatus;
    private $fromEmail;
    private $fromName;

    static function create( $employeeId,
                            $employeeName,
                            $employeeEmail,
                            $mainFunctionName)
    {
        return new EmployeeInvitationResultValueObject( $employeeId,
                                                        $employeeName,
                                                        $employeeEmail,
                                                        $mainFunctionName);
    }

    protected function __construct( $employeeId,
                                    $employeeName,
                                    $employeeEmail,
                                    $mainFunctionName)
    {
        parent::__construct();

        $this->employeeId           = $employeeId;
        $this->employeeName         = $employeeName;
        $this->employeeEmail        = $employeeEmail;
        $this->mainFunctionName     = $mainFunctionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitationStatus check
    function isInvited()
    {
        return $this->invitationStatus == InvitationStatusValue::INVITED ||
               $this->invitationStatus == InvitationStatusValue::REINVITED;
    }

    function isReinvited()
    {
        return $this->invitationStatus == InvitationStatusValue::REINVITED;
    }

    function isReminded()
    {
        return $this->invitationStatus == InvitationStatusValue::REMINDED_1 ||
               $this->invitationStatus == InvitationStatusValue::REMINDED_2;
    }

    function isReminded1()
    {
        return $this->invitationStatus == InvitationStatusValue::REMINDED_1;
    }

    function isReminded2()
    {
        return $this->invitationStatus == InvitationStatusValue::REMINDED_2;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeId
    function getEmployeeId()
    {
        return $this->employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeName
    function getEmployeeName()
    {
        return $this->employeeName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeEmail
    function getEmployeeEmail()
    {
        return $this->employeeEmail;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $mainFunctionName
    function getMainFunctionName()
    {
        return $this->mainFunctionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitationStatus InvitationStatusValue
    function setInvitationStatus($invitationStatus)
    {
        $this->invitationStatus = $invitationStatus;
    }

    function getInvitationStatus()
    {
        return $this->invitationStatus;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $invitationHashId
    function setInvitationHashId($invitationHashId)
    {
        $this->invitationHashId = $invitationHashId;
    }

    function getInvitationHashId()
    {
        return $this->invitationHashId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $fromName, $fromEmail
    function setEmailFrom($fromName, $fromEmail)
    {
        $this->fromName     = $fromName;
        $this->fromEmail    = $fromEmail;
    }

    function getFromName()
    {
        return $this->invitationStatus;
    }

    function getFromEmail()
    {
        return $this->fromEmail;
    }

}

?>
