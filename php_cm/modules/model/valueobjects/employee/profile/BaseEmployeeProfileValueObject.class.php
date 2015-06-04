<?php

/**
 * Description of BaseEmployeeProfileValueObject
 *
 * @author ben.dokter
 */
require_once('application/model/valueobjects/BaseValueObject.class.php');

class BaseEmployeeProfileValueObject extends BaseValueObject
{
    protected $firstName;
    protected $lastName;
    protected $employeeName;
    protected $isActive;

    protected function __construct($employeeId, $employeeProfileData)
    {
        parent::__construct($employeeId,
                            $employeeProfileData['saved_by_user_id'], // DEZE VELDEN ZIJN ER NIET
                            $employeeProfileData['saved_by_user'],    // DEZE VELDEN ZIJN ER NIET
                            $employeeProfileData['saved_datetime']);  // DEZE VELDEN ZIJN ER NIET

        $this->isActive         = $employeeProfileData['is_inactive'] == EMPLOYEE_IS_ACTIVE;
        $this->firstName        = $employeeProfileData['firstname'];
        $this->lastName         = $employeeProfileData['lastname'];
        $this->employeeName     = $employeeProfileData['employee'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $firstName
    function getFirstName()
    {
        return $this->firstName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $lastName
    function getLastName()
    {
        return $this->lastName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeName
    function setEmployeeName($employeeName)
    {
        $this->employeeName = $employeeName;
    }

    function getEmployeeName()
    {
        return $this->employeeName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isActive
    function getIsActive()
    {
        return $this->isActive;
    }

    function isActive()
    {
        return $this->isActive;
    }

    function isInactive()
    {
        return !$this->isActive;
    }


}

?>
