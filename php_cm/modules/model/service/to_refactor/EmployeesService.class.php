<?php

/**
 * Description of Employees
 *
 * @author ben.dokter
 */

require_once('modules/model/service/to_refactor/UsersService.class.php');
require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');
require_once('modules/model/queries/to_refactor/AlertQueries.class.php');


class EmployeesService {

    static function hasSubordinates($employee_id)
    {
        $bossInfo = @mysql_fetch_assoc(EmployeesQueries::getBossInfo($employee_id));
        return ($bossInfo['subordinate_count'] > 0);
    }


    static function hasRelatedUser($employee_id)
    {
        $userId = UsersService::findUserByEmployeeId($employee_id);
        return !empty($userId);
    }

    static function relatedUsername ($i_employee_id) {
        $username_res = UserQueries::findUsernameByEmployeeId($i_employee_id);
        $username = '';
        if (@mysql_num_rows($username_res) > 0) {
            $username_row = @mysql_fetch_assoc($username_res);
            $username = $username_row['username'];
        }

        return $username;
    }

    static function archiveEmployee($employee_id)
    {
        $isArchived = false;
        if (!EmployeesService::hasSubordinates($employee_id)) {
            EmployeesQueries::archiveEmployee($employee_id);

            UsersService::deactivateUserByEmployeeId($employee_id, EmployeesService::relatedUsername($employee_id));

            $isArchived = true;
        }
        return $isArchived;
    }

    static function isAddEmployeePossible()
    {
        $employeesCountInfo = @mysql_fetch_assoc(EmployeesQueries::getEmployeesCountInfo());
        $maxAllowedEmployees = $employeesCountInfo['max_allowed_employees'];
        $usedEmployees = $employeesCountInfo['employees_count'];
        return $usedEmployees < $maxAllowedEmployees;
    }

    static function getEmployeesBasedOnUserLevel($search_employee_name)
    {
        $employees = array();

        $emps = new EmployeesQueries();
        $getemp = $emps->getEmployeesBasedOnUserLevel($search_employee_name);

        while ($getemp_row = @mysql_fetch_assoc($getemp)) {
            $employees[] = $getemp_row;
        }

        return $employees;
    }

    static function getEmployeesForBossBasedOnUserLevel($bossId)
    {
        $employees = array();

        $emps = new EmployeesQueries();
        $getemp = $emps->getEmployeesBasedOnUserLevel(  null,
                                                        null,
                                                        null,
                                                        null,
                                                        null,
                                                        $bossId);
        while ($getemp_row = @mysql_fetch_assoc($getemp)) {
            $employees[] = $getemp_row;
        }
        mysql_free_result($getemp);
        return $employees;
    }

//    static function getMaxAllowedEmployees()
//    {
//        $maxAllowedEmployees = @mysql_fetch_assoc(EmployeesQueries::getMaxAllowedEmployees());
//        return ($maxAllowedEmployees['num_employees']);
//    }

//    static function getUsedEmployees()
//    {
//        // zowel actieve als niet actieve!
//        $usedEmployees = @mysql_fetch_assoc(EmployeesQueries::getEmployeesCountInfo());
//        return ($usedEmployees['employees_count']);
//    }


}

?>
