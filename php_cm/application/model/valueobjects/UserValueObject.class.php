<?php

/**
 * Description of UserValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class UserValueObject extends BaseValueObject
{
    // system
    var $isActive;
    var $login;
    var $lastLogin;
    var $createdDate; // database date
    var $isCustomerPrimary;

    // personal
    var $name;
    var $emailAddress;
    var $employeeId;

    // access
    var $userLevel;
    var $accessAllDepartments;
    var $departmentCount;

    static function createWithData($userData)
    {
        return new UserValueObject($userData[UserQueries::ID_FIELD], $userData);
    }

    static function createWithValues(   $userId,
                                        $employeeId,
                                        $name,
                                        $emailAddress,
                                        $login,
                                        $userLevel,
                                        $activeMode)
    {
        $userData = array();

        $userData[UserQueries::ID_FIELD]    = $userId;
        $userData['ID_E']                   = $employeeId;
        $userData['name']                   = $name;
        $userData['email']                  = $emailAddress;
        $userData['username']               = $login;
        $userData['user_level']             = $userLevel;
        $userData['is_inactive']            = $activeMode;

        // defaults
        $userData['isprimary']                      = USER_NORMAL;
        $userData['allow_access_all_departments']   = ONLY_FROM_USER_DEPARTMENTS;
        $userData['accessDepartmentCount']          = 0;

        return new UserValueObject($userId, $userData);
    }

    protected function __construct($userId, $userData)
    {
        parent::__construct($userId,
                            $userData['saved_by_user_id'], // DEZE VELDEN ZIJN ER NIET
                            $userData['saved_by_user'],    // DEZE VELDEN ZIJN ER NIET
                            $userData['saved_datetime']);  // DEZE VELDEN ZIJN ER NIET

        // system
        $this->isActive             = $userData['is_inactive'] == USER_IS_ACTIVE;
        $this->login                = $userData['username'];
        $this->lastLogin            = $userData['last_login'];
        $this->createdDate          = $userData['created_date'];
        $this->isCustomerPrimary    = $userData['isprimary'];

        // personal
        $this->name                 = $userData['name'];
        $this->emailAddress         = $userData['email'];
        $this->employeeId           = $userData['ID_E'];

        // access
        $this->userLevel            = $userData['user_level'];
        $this->accessAllDepartments = $userData['allow_access_all_departments'] == ALWAYS_ACCESS_ALL_DEPARTMENTS;
        $this->departmentCount      = $userData['accessDepartmentCount'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isActive
    function isActive()
    {
        return $this->isActive;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $login
    function getLogin()
    {
        return $this->login;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $lastLogin
    function getLastLogin()
    {
        return $this->lastLogin;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $createdDate
    function getCreatedDate()
    {
        return $this->createdDate;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $isCustomerPrimary
    function getIsCustomerPrimary()
    {
        return $this->isCustomerPrimary;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $name
    function getName()
    {
        return $this->name;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // emailAddress
    function getEmailAddress()
    {
        return $this->emailAddress;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeId
    function getEmployeeId()
    {
        return $this->employeeId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $userLevel
    function getUserLevel()
    {
        return $this->userLevel;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $accessAllDepartments
    function getAccessAllDepartments()
    {
        return $this->accessAllDepartments;
    }

    function hasAllDepartmentsAccess()
    {
        return $this->accessAllDepartments;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $departmentCount
    function getDepartmentCount()
    {
        return $this->departmentCount;
    }

}

?>
