<?php

/**
 * Description of EmployeeInfoQueries
 *
 * @author ben.dokter
 */

class EmployeeInfoQueries
{
    // altijd EmployeeSortFilterValue::SORT_ALPHABETICAL
    static function getEmployeesInfo($s_allowedEmployeeIds)
    {
        $sql = 'SELECT
                    e.ID_E,
                    e.ID_PD,
                    e.email_address,
                    e.firstname,
                    e.lastname,
                    e.employee,
                    e.foto_thumbnail,
                    e.boss_fid,
                    e.sex,
                    e.is_inactive,
                    b.email_address as boss_email_address,
                    b.firstname as boss_firstname,
                    b.lastname as boss_lastname,
                    b.employee as boss_name,
                    f.ID_F,
                    f.function,
                    d.ID_DEPT,
                    d.department
                FROM
                    employees e
                    INNER JOIN department d
                        ON d.ID_DEPT = e.ID_DEPTID
                    INNER JOIN functions f
                        ON f.ID_F = e.ID_FID
                    LEFT JOIN employees b
                        ON b.ID_E = e.boss_fid
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    -- AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND e.ID_E in (' . $s_allowedEmployeeIds . ')
                ORDER BY
                    e.lastname,
                    e.firstname';
        return BaseQueries::performSelectQuery($sql);
    }
}

?>
