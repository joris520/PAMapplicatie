<?php
/**
 * Description of BaseReportEmployeeService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/employee/EmployeeInfoQueries.class.php');

require_once('modules/model/valueobjects/report/BaseReportEmployeeValueObject.class.php');

require_once('modules/model/service/report/BaseReportService.class.php');

class BaseReportEmployeeService extends BaseReportService
{

//    static function getCollectionWithEmployeeIds(   $collectionId,
//                                                    $collectionName,
//                                                    Array $employeeIds)
//    {
//        $collection = BaseReportEmployeeCollection::create( $collectionId,
//                                                            $collectionName);
//        if (!empty($employeeIds)) {
//            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
//            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
//                $valueObject = BaseReportEmployeeValueObject::createWithData($employeeFilterData);
//                $collection->addValueObject($valueObject);
//            }
//            mysql_free_result($query);
//        }
//
//        return $collection;
//
//    }

    static function getCollectionWithIdValues(  IdValue $collectionIdValue,
                                                Array $employeeIdValues)
    {
        $collection     = BaseReportEmployeeCollection::create( $collectionIdValue->getDatabaseId(),
                                                                $collectionIdValue->getValue());

        $keys = array_keys($employeeIdValues);
        $employeeIds = implode(',', $keys);
        if (!empty($employeeIds)) {
            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
                $valueObject = BaseReportEmployeeValueObject::createWithData($employeeFilterData);
                $employeeId = $valueObject->getId();
                $valueObject->setReportCount($employeeIdValues[$employeeId]->getValue());
                $collection->addValueObject($valueObject);
            }
            mysql_free_result($query);
        }

        return $collection;

    }

    static function getCollection(  $bossId,
                                    $employeeIds = NULL)
    {
        $bossIdValue    = EmployeeSelectService::getBossIdValue($bossId);
        if (is_null($employeeIds)) {
            $employeeIds    = EmployeeSelectService::getBossEmployeeIds($bossId,
                                                                        EmployeeSelectService::RETURN_AS_STRING);
        }
        $collection     = BaseReportEmployeeCollection::create( $bossId,
                                                                $bossIdValue->getValue());

        if (!empty($employeeIds)) {
            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
                $valueObject = BaseReportEmployeeValueObject::createWithData($employeeFilterData);
                $collection->addValueObject($valueObject);
            }
            mysql_free_result($query);
        }

        return $collection;
    }

    static function getCollectionForDepartment( $departmentId,
                                                $employeeIds)
    {
        $departmentValueObject  = DepartmentService::getValueObjectById($departmentId);
        $collection             = BaseReportEmployeeCollection::create( $departmentId,
                                                                        $departmentValueObject->getDepartmentName());

        if (!empty($employeeIds)) {
            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
                $valueObject = BaseReportEmployeeValueObject::createWithData($employeeFilterData);
                $collection->addValueObject($valueObject);
            }
            mysql_free_result($query);
        }

        return $collection;
    }




//    static function getEmployeeValueObjects($employeeIds)
//    {
//        $valueObjects = array();
//        if (!empty($employeeIds)) {
//            $query = EmployeeInfoQueries::getEmployeesInfo($employeeIds);
//            while ($employeeFilterData = @mysql_fetch_assoc($query)) {
//                $valueObjects[] = BaseReportEmployeeValueObject::createWithData($employeeFilterData);
//            }
//            mysql_free_result($query);
//        }
//        return $valueObjects;
//    }


}

?>
