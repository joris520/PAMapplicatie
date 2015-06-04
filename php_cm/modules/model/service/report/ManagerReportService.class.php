<?php

/**
 * Description of ManagerReportService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/report/ManagerReportQueries.class.php');
require_once('modules/model/queries/employee/EmployeeInfoQueries.class.php');

require_once('modules/model/valueobjects/report/ManagerReportCollection.class.php');
require_once('modules/model/valueobjects/report/ManagerReportValueObject.class.php');
require_once('modules/model/valueobjects/report/ManagerReportEmployeeValueObject.class.php');
require_once('application/model/valueobjects/UserValueObject.class.php');

require_once('modules/model/service/to_refactor/EmployeesService.class.php');

class ManagerReportService
{
    /**
     *
     * @param type $allowedEmployeeIds
     * @return ManagerReportCollection
     */
    static function getDashboardCollection($allowedEmployeeIds)
    {
        $dashboardCollection = ManagerReportCollection::create();

        if (!empty($allowedEmployeeIds)) {
            // per leidinggevenden de medewerkers ophalen
            $managerQuery = ManagerReportQueries::getManagerReport($allowedEmployeeIds);
            while ($managerReportData = mysql_fetch_assoc($managerQuery)) {
                $valueObject = ManagerReportValueObject::createWithData($managerReportData);

                $userQuery = ManagerReportQueries::getUserReport($valueObject->getId());
                $userReportData = mysql_fetch_assoc($userQuery);
                mysql_free_result($userQuery);

                $valueObject->setManagerUserValueObject(UserValueObject::createWithData($userReportData));

                $dashboardCollection->addValueObject($valueObject);
            }
            mysql_free_result($managerQuery);
        }
        return $dashboardCollection;
    }

    static function getEmployeeValueObjectsForBoss($bossId)
    {
        $valueObjects = array();
        $employeeIds = EmployeeSelectService::getBossEmployeeIds($bossId, true);
        if (!empty($employeeIds)) {
            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
                $valueObjects[] = ManagerReportEmployeeValueObject::createWithData($employeeFilterData);
            }
            mysql_free_result($query);
        }
        return $valueObjects;
    }

//    static function getEmployeeValueObjects($employeeIds)
//    {
//        $valueObjects = array();
//        if (!empty($employeeIds)) {
//            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
//            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
//                $valueObjects[] = ManagerReportEmployeeValueObject::createWithData($employeeFilterData);
//            }
//            mysql_free_result($query);
//        }
//        return $valueObjects;
//    }
//


}

?>
