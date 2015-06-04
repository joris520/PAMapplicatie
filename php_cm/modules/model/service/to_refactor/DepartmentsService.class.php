<?php

/**
 * Description of Departments
 *
 * @author ben.dokter
 */
class DepartmentsService {

    static function getAllowedDepartments()
    {
        $departmentqueries = new DepartmentQueriesDeprecated();
        $departments_result = $departmentqueries->getDepartmentsBasedOnUserLevel();

        $departments = array();
        while ($department = @mysql_fetch_assoc($departments_result)) {
            $departments[] = $department;
        }
        return $departments;
    }

    static function getDepartmentName($department_id)
    {
        $department = @mysql_fetch_assoc(DepartmentQueriesDeprecated::getDepartment($department_id));
        return $department['department'];
    }
}

?>
