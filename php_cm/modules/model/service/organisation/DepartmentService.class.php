<?php

/**
 * Description of DepartmentService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/profile/EmployeeProfilePersonalValueObject.class.php');
require_once('modules/model/valueobjects/organisation/DepartmentValueObject.class.php');
require_once('modules/model/queries/organisation/DepartmentQueries.class.php');

require_once('application/model/queries/UserQueries.class.php');

class DepartmentService
{
    const INCLUDE_USAGE_INFORMATION = true;
    const ONLY_DEPARTMENT_INFORMATION = false;

    static function getValueObjects($showUsage = self::INCLUDE_USAGE_INFORMATION)
    {
        $valueObjects = array();

        $query = DepartmentQueries::getDepartments();
        while ($departmentData = mysql_fetch_assoc($query)) {
            $departmentId = $departmentData[DepartmentQueries::ID_FIELD];
            if ($showUsage) {
                list($countedUsersData, $countedEmployeeData) = self::getUsageData($departmentId);
            }
            $valueObjects[] = DepartmentValueObject::createWithData($departmentData, $countedUsersData, $countedEmployeeData);
        }

        mysql_free_result($query);
        return $valueObjects;
    }

    static function getValueObjectById($departmentId, $showUsage = true)
    {
        $valueObject = NULL;

        $query = DepartmentQueries::selectDepartment($departmentId);
        $departmentData = mysql_fetch_assoc($query);
        if ($showUsage) {
            list($countedUsersData, $countedEmployeeData) = self::getUsageData($departmentId);
        }
        $valueObject = DepartmentValueObject::createWithData($departmentData, $countedUsersData, $countedEmployeeData);

        mysql_free_result($query);
        return $valueObject;
    }

    static function getDepartmentIdValues()
    {
        $departments = array();

        $query = DepartmentQueries::getDepartments();
        while ($departmentData = mysql_fetch_assoc($query)) {
            $departments[] = IdValue::create($departmentData[DepartmentQueries::ID_FIELD], $departmentData['department']);
        }
        mysql_free_result($query);
        return $departments;
    }

    /**
     *
     * @param type $userId
     * @return DepartmentCollection
     */
    static function getCollectionForUserId($userId)
    {
        $collection = DepartmentCollection::create($userId);
        $query = DepartmentQueries::findDepartmentsForUserId($userId);
        while ($departmentData = mysql_fetch_assoc($query)) {
            $valueObject = DepartmentValueObject::createWithData($departmentData, NULL, NULL);
            $collection->addValueObject($valueObject);
        }
        mysql_free_result($query);

        return $collection;
    }

//    static function getValueObjectsForUserId($userId)
//    {
//        $valueObjects = array();
//        $query = DepartmentQueries::findDepartmentsForUserId($userId);
//        while ($departmentData = mysql_fetch_assoc($query)) {
//            $valueObjects[] = DepartmentValueObject::createWithData($departmentData, NULL, NULL);
//        }
//
//        mysql_free_result($query);
//        return $valueObjects;
//    }

    // TODO: naar andere service?
    static function getEmployeeValueObjectsForDepartment($departmentId)
    {
        $valueObjects = array();
        $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds();
        $query = DepartmentQueries::findEmployees(  $departmentId,
                                                    $allowedEmployeeIds);
        while ($employeeProfileData = mysql_fetch_assoc($query)) {

            $valueObjects[] = EmployeeProfileOrganisationValueObject::createWithData(   $employeeProfileData[EmployeeProfileQueries::ID_FIELD],
                                                                                        $employeeProfileData);
        }

        mysql_free_result($query);
        return $valueObjects;
    }

    static function getEmployeeIdsForDepartment($departmentId)
    {
        $employeeIds = array();
        $allowedEmployeeIds = EmployeeSelectService::getAllAllowedEmployeeIds();
        $query = DepartmentQueries::findEmployees(  $departmentId,
                                                    $allowedEmployeeIds);
        while ($employeeProfileData = mysql_fetch_assoc($query)) {
            $employeeIds[] = $employeeProfileData[EmployeeProfileQueries::ID_FIELD];
        }

        mysql_free_result($query);
        return implode(',',$employeeIds);
    }


    // TODO: naar andere service?
    static function getUserValueObjectsForDepartment($departmentId)
    {
        $valueObjects = array();
        $query = DepartmentQueries::findUsers($departmentId);
        while ($userData = mysql_fetch_assoc($query)) {
            $valueObjects[] = UserValueObject::createWithData($userData, NULL, NULL);
        }

        mysql_free_result($query);
        return $valueObjects;
    }

    private static function getUsageData($departmentId)
    {
        // TODO: valueObject
        $query = DepartmentQueries::countUsers($departmentId);
        $countedUsersData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        $query = DepartmentQueries::countEmployees($departmentId);
        $countedEmployeeData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return array($countedUsersData, $countedEmployeeData);
    }

    static function findDepartmentIdWithName($departmentName)
    {
        $query = DepartmentQueries::findDepartmentByName($departmentName);
        $departmentData = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $departmentData[DepartmentQueries::ID_FIELD];
    }

    static function validate(DepartmentValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $departmentId   = $valueObject->getId();
        $departmentName = $valueObject->departmentName;

        if (empty($departmentName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_DEPARTMENT_NAME');
        } else {
            $foundId = self::findDepartmentIdWithName($departmentName);
            if (!empty($foundId) && (empty($departmentId) || $departmentId != $foundId)) {
                $hasError = true;
                $messages[] = TXT_UCF('NAME_ALREADY_EXISTS_FOR_ANOTHER_DEPARTMENT');
            }
        }
        return array($hasError, $messages);
    }

    static function addValidated(DepartmentValueObject $valueObject)
    {
        $departmentName = $valueObject->departmentName;
        return DepartmentQueries::insertDepartment($departmentName);
    }

    static function updateValidated($departmentId,
                                    DepartmentValueObject $valueObject)
    {
        $departmentId   = $valueObject->getId();
        $departmentName = $valueObject->departmentName;

        return DepartmentQueries::updateDepartment($departmentId, $departmentName);
    }

    static function isRemovable($departmentId)
    {
        $query = DepartmentQueries::countEmployees($departmentId);
        $countedEmployeeData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $countedEmployeeData['counted'] == 0 &&
               $countedEmployeeData['counted_inactive'] == 0;
    }


    static function validateRemove($departmentId)
    {
        $hasError = false;
        $messages = array();

        if (!self::isRemovable($departmentId)) {
            $hasError = true;
            $messages[] = TXT_UCF('YOU_CANNOT_DELETE_THIS_DEPARTMENT_WHILE_THERE_ARE_EMPLOYEES_CONNECTED_IN_IT');
        }

        return array($hasError, $messages);
    }

    static function remove($departmentId)
    {
        if (self::isRemovable($departmentId)) {
            // eerst de rechten op de afdeling van de gebruikers weghalen
            // TODO: via service in application
            UserQueries::deleteDepartmentAccess($departmentId);

            DepartmentQueries::deleteDepartment($departmentId);
        }
    }

    static function moveEmployeesToDepartment($currentDepartmentId, $toDeartmentId)
    {

    }

}

?>
