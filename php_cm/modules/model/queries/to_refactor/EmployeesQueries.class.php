<?php

/**
 * Description of EmployeesQueries
 *
 * @author wouter.storteboom
 */

require_once('modules/model/queries/to_refactor/DataQueries.class.php');

class EmployeesQueries extends DataQueries {

    public function getEmployeesBasedOnUserLevel($s_employee = null,
                                                 $ia_employee_id = null,
                                                 $ia_function_id = null,
                                                 $ia_department_id = null,
                                                 $b_is_boss = null,
                                                 $ia_boss_id = null,
                                                 $use_limit = true,
                                                 $only_with_email = false)
    {
        $field_list = 'e.firstname,
                       e.lastname,
                       e.employee,
                       e.ID_E,
                       f.ID_F,
                       f.function,
                       de.ID_DEPT,
                       de.department';

        return parent::getDataBasedOnUserLevel($s_employee,
                                               $ia_employee_id,
                                               $ia_function_id,
                                               $ia_department_id,
                                               $b_is_boss,
                                               $ia_boss_id,
                                               $use_limit,
                                               $only_with_email,
                                               $field_list);
    }

    static function archiveEmployee($i_employee_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees
                SET
                    is_inactive = ' . EMPLOYEE_IS_DISABLED . ',
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date= "' . $modified_date . '"
                WHERE
                    ID_E = ' . $i_employee_id . '
                    AND customer_id = ' . CUSTOMER_ID . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function getBossInfo($i_employee_id)
    {
        $sql = 'SELECT
                    b.ID_E,
                    b.is_boss,
                    COUNT(*) subordinate_count
                FROM
                    employees b
                    INNER JOIN employees subordinates
                        ON (b.id_e = subordinates.boss_fid)
                WHERE
                    b.ID_E = ' . $i_employee_id . '
                    AND b.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND subordinates.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND b.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    b.ID_E,
                    b.is_boss';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEmployeeInfo($i_employee_id)
    {
        $sql = 'SELECT
                    e.*
                FROM
                    employees e
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E = ' . $i_employee_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEmployeesCountInfo()
    {
        $sql = 'SELECT
                    COUNT(ID_E) as employees_count,
                    c.num_employees as max_allowed_employees
                FROM
                    customers c
                    LEFT JOIN employees e
                        ON e.customer_id = c.customer_id
                WHERE
                    c.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    c.customer_id';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }



}

?>
