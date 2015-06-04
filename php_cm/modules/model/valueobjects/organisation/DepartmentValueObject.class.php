<?php

/**
 * Description of DepartmentValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class DepartmentValueObject extends BaseValueObject
{
    var $departmentName;
    var $countedUsers;
    var $countedInactiveUsers;
    var $countedEmployees;
    var $countedInactiveEmployees;

    /**
     * Deze functie neemt een array met data (formaat van de database tabel)
     * @param type $departmentData
     * @return DepartmentValueObject
     */
    static function createWithData( $departmentData, $usageUsersData, $usageEmployeesData)
    {
        return new DepartmentValueObject($departmentData[DepartmentQueries::ID_FIELD], $departmentData, $usageUsersData, $usageEmployeesData);
    }

    /**
     * Deze functie maakt van de losse values een valueObject
     * @param type $departmentId
     * @param type $departmentName
     * @return DepartmentValueObject
     */
    static function createWithValues(   $departmentId,
                                        $departmentName)
    {
        $departmentData = array();

        $departmentData[DepartmentQueries::ID_FIELD] = $departmentId;
        $departmentData['department'] = $departmentName;

        return new DepartmentValueObject($departmentId, $departmentData, NULL, NULL);
    }

    protected function __construct($departmentId, $departmentData, $usageUsersData, $usageEmployeesData)
    {
        parent::__construct($departmentId,
                            $departmentData['saved_by_user_id'],
                            $departmentData['saved_by_user'],
                            $departmentData['saved_datetime']);

        $this->departmentName   = $departmentData['department'];
        $this->countedUsers         = $usageUsersData['counted'];
        $this->countedInactiveUsers = $usageUsersData['counted_inactive'];
        $this->countedEmployees         = $usageEmployeesData['counted'];
        $this->countedInactiveEmployees = $usageEmployeesData['counted_inactive'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $departmentName
    function getDepartmentName()
    {
        return $this->departmentName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $countedEmployees
    function getCountedEmployees()
    {
        return $this->countedEmployees;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $countedEmployees
    function getCountedInactiveEmployees()
    {
        return $this->countedInactiveEmployees;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $countedEmployees
    function getTotalCountedEmployees()
    {
        return $this->countedEmployees + $this->countedInactiveEmployees;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $countedUsers
    function getCountedUsers()
    {
        return $this->countedUsers;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $countedUsers
    function getCountedInactiveUsers()
    {
        return $this->countedInactiveUsers;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $countedUsers
    function getTotalCountedUsers()
    {
        return $this->countedUsers + $this->countedInactiveUsers;
    }


}

?>
