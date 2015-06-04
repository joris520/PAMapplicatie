<?php

/**
 * Description of DepartmentQueries
 *
 * @author ben.dokter
 */
class DepartmentQueries
{
    const ID_FIELD = 'ID_DEPT';

    static function getDepartments()
    {

        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN ||
            USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = 'SELECT
                        d.*
                    FROM
                        department d
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        d.department';
        } elseif (  USER_LEVEL == UserLevelValue::MANAGER ||
                    USER_LEVEL == UserLevelValue::HR) {
            $sql = 'SELECT
                        d.*
                    FROM
                        department d
                        INNER JOIN users_department ud
                            ON d.ID_DEPT = ud.ID_DEPT
                                AND ud.ID_UID = ' . USER_ID . '
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        department';
        } else /*UserLevelValue::EMPLOYEE_*/ {
            $sql = 'SELECT
                        d.*
                    FROM
                        users u
                        INNER JOIN employees e
                            ON u.ID_E = e.ID_E
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                        AND u.user_id = ' . USER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . EMPLOYEE_ID . '
                    ORDER BY
                        department';
        }

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectDepartment($i_departmentId)
    {
        $sql = 'SELECT
                    *
                FROM
                    department
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ' . self::ID_FIELD . ' = ' . $i_departmentId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findDepartmentByName($s_departmentName)
    {
        $sql = 'SELECT
                    *
                FROM
                    department
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND LOWER(department) = LOWER("' . mysql_real_escape_string($s_departmentName) . '")
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findDepartmentsForUserId($i_userId)
    {
            $sql = 'SELECT
                        d.*
                    FROM
                        department d
                        INNER JOIN users_department ud
                            ON d.ID_DEPT = ud.ID_DEPT
                                AND ud.ID_UID = ' . $i_userId . '
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        department';

        return BaseQueries::performSelectQuery($sql);
    }


    static function insertDepartment($s_departmentName)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    department
                    (   customer_id,
                        department,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                       "' . mysql_real_escape_string($s_departmentName) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateDepartment(   $i_departmentId,
                                        $s_departmentName)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    department
                SET
                    department          = "' .  mysql_real_escape_string($s_departmentName) . '",
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ' . self::ID_FIELD . ' = ' . $i_departmentId;

        return BaseQueries::performUpdateQuery($sql);
    }

    // TODO: naar employeesQueries
    static function countEmployees($i_departmentId)
    {
        $sql = 'SELECT
                    SUM(IF(e.is_inactive=' . EMPLOYEE_IS_ACTIVE   . ',1,0)) as counted,
                    SUM(IF(e.is_inactive=' . EMPLOYEE_IS_DISABLED . ',1,0)) as counted_inactive
                FROM
                    employees e
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_DEPTID = ' . $i_departmentId;

        return BaseQueries::performSelectQuery($sql);
    }

    // TODO: naar employeesQueries
    static function findEmployees(  $i_departmentId,
                                    $a_allowedEmployeeIds)
    {
        $filter = (!empty($a_allowedEmployeeIds)) ? 'AND e.ID_E ' . (is_array($a_allowedEmployeeIds) ? 'in (' . implode(',',$a_allowedEmployeeIds) . ')' : '= '.$a_allowedEmployeeIds) : '';
        $sql = 'SELECT
                    e.*
                FROM
                    employees e
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                   ' . $filter . '
                    AND e.ID_DEPTID = ' . $i_departmentId . '
                    -- AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                ORDER BY
                    e.lastname,
                    e.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

    static function countUsers($i_departmentId)
    {
        $sql = 'SELECT
                    SUM(IF(u.is_inactive=' . USER_IS_ACTIVE   . ',1,0)) as counted,
                    SUM(IF(u.is_inactive=' . USER_IS_DISABLED . ',1,0)) as counted_inactive
                FROM
                    users u
                    LEFT JOIN users_department ud
                        ON ud.ID_UID = u.user_id
                WHERE
                    u.customer_id = ' . CUSTOMER_ID . '
                    AND u.user_level > ' . UserLevelValue::CUSTOMER_ADMIN . '
                    AND (   u.allow_access_all_departments = ' . ALWAYS_ACCESS_ALL_DEPARTMENTS . '
                            OR ud.ID_DEPT = ' . $i_departmentId . '
                        )';
        return BaseQueries::performSelectQuery($sql);
    }

    static function findUsers($i_departmentId)
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
                    u.allow_access_all_departments
                FROM
                    users u
                    LEFT JOIN users_department ud
                        ON ud.ID_UID = u.user_id
                WHERE
                    u.customer_id = ' . CUSTOMER_ID . '
                    AND u.is_inactive = ' . USER_IS_ACTIVE . '
                    AND u.user_level > ' . UserLevelValue::CUSTOMER_ADMIN . '
                    AND (   u.allow_access_all_departments = ' . ALWAYS_ACCESS_ALL_DEPARTMENTS . '
                            OR ud.ID_DEPT = ' . $i_departmentId . '
                        )';
        return BaseQueries::performSelectQuery($sql);
    }

    static function deleteDepartment($i_departmentId)
    {
        $sql = 'DELETE
                FROM
                    department
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ' . self::ID_FIELD . ' = ' . $i_departmentId . '
                LIMIT 1';

        return BaseQueries::performDeleteQuery($sql);
    }

}

?>
