<?php


/**
 * Description of ManagerReportQueries
 *
 * @author ben.dokter
 */
class ManagerReportQueries
{
    const ID_FIELD = 'manager_id';

    static function getManagerReport($s_allowedEmployeeIds = NULL)
    {
        $sql_filter = !empty($s_allowedEmployeeIds) ? 'AND e.ID_E in (' . $s_allowedEmployeeIds . ')' : '';
        $sql = 'SELECT
                    b.ID_E as manager_id,
                    b.*,
                    count(e.ID_E) as subordinate_count
                FROM
                    employees b
                    LEFT JOIN employees e
                        ON e.boss_fid = b.ID_E
                            AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                            ' . $sql_filter . '
                WHERE
                    b.customer_id = ' . CUSTOMER_ID . '
                    AND b.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND b.is_boss = ' . EMPLOYEE_IS_MANAGER . '
                GROUP BY
                    b.ID_E
                ORDER BY
                    b.lastname,
                    b.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

    // TODO: naar user
    static function getUserReport($i_employeeId)
    {
        $userFields = '';
        if (PermissionsService::isViewAllowed(PERMISSION_USERS)) {
            $userFields .= 'u.username,
                            u.name,
                            u.user_level,
                            u.last_login,
                            u.is_inactive,';
        }

        $sql = 'SELECT
                    u.user_id,
                  ' . $userFields . '
                    u.allow_access_all_departments,
                    count(ud.ID_UDIV) as accessDepartmentCount
                FROM
                    users u
                    LEFT JOIN users_department ud
                        ON ud.ID_UID = u.user_id
                WHERE
                    u.customer_id = ' . CUSTOMER_ID . '
                    AND u.ID_E = ' . $i_employeeId . '
                GROUP BY
                    u.user_id
                ORDER BY
                    u.name';

        return BaseQueries::performSelectQuery($sql);
    }

}
?>
