<?php

/**
 * Description of UserQueries
 *
 * @author ben.dokter
 */

// TODO: nog beetje refactoren (camelCase etc)

class UserQueries
{
    const ID_FIELD = 'user_id';

    // todo: check customer?
    static function findUserIdByUsername($s_username)
    {
        $sql = 'SELECT
                    user_id
                FROM
                    users
                WHERE
                    username = "' . mysql_real_escape_string($s_username) . '"
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }


    static function findUserIdByEmployeeId($i_employeeId)
    {
        $sql = 'SELECT
                    user_id
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findUserDataByUserId($i_userId)
    {
        $sql = 'SELECT
                    user_id,
                    ID_E,
                    username,
                    is_inactive,
                    name,
                    email,
                    user_level,
                    last_login,
                    created_date,
                    isprimary,
                    allow_access_all_departments
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND user_id = ' . $i_userId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findUserDataByEmployeeId($i_employeeId)
    {
        $sql = 'SELECT
                    user_id,
                    ID_E,
                    username,
                    is_inactive,
                    name,
                    email,
                    user_level,
                    last_login,
                    created_date,
                    isprimary,
                    allow_access_all_departments
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertNewUserForEmployee($i_employeeId,
                                             $s_employee,
                                             $s_emailAddress,
                                             $s_username,
                                             $i_userLevel)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    users
                    (   customer_id,
                        username,
                        is_inactive,
                        name,
                        user_level,
                        ID_E,
                        email,
                        modified_by_user,
                        modified_time,
                        modified_date,
                        created_date,
                        isprimary,
                        allow_access_all_departments
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                        "' . mysql_real_escape_string($s_username) . '",
                         ' . USER_IS_ACTIVE . ',
                        "' . mysql_real_escape_string($s_employee) . '",
                         ' . $i_userLevel . ',
                         ' . $i_employeeId . ',
                        "' . mysql_real_escape_string($s_emailAddress) . '",
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '",
                        "' . $modified_date . '",
                         ' . USER_NORMAL . ',
                         ' . ONLY_FROM_USER_DEPARTMENTS . '
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateUserForEmployee($i_employeeId,
                                          $s_employee,
                                          $s_emailAddress)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    users
                SET
                    email = "' . mysql_real_escape_string($s_emailAddress) . '",
                    name = "'  . mysql_real_escape_string($s_employee) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateUserEmailForEmployee($i_employeeId, $s_emailAddress)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    users
                SET
                    email = "' . mysql_real_escape_string($s_emailAddress) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function getUsernameByUserId ($i_userId)
    {
        $sql = 'SELECT
                    username
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND user_id = ' . $i_userId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findUsernameByEmployeeId ($i_employeeId)
    {
        $sql = 'SELECT
                    username
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getUserInfo($i_userId)
    {
        $sql = 'SELECT
                    name,
                    email
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND user_id = ' . $i_userId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    // TODO: customerid via CUSTOMER_ID ?
    static function updateAdminAccount($i_customerId,
                                       $i_userId,
                                       $s_username)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    users
                SET
                    username = "' . mysql_real_escape_string($s_username) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time    = "' . $modified_time . '",
                    modified_date    = "' . $modified_date . '"
                WHERE
                    customer_id = ' . $i_customerId . '
                    AND user_id = ' . $i_userId . '
                    AND isprimary =  ' . USER_PRIMARY_ADMIN;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function disableUserByEmployeeId($i_employeeId, $i_disableMode = USER_IS_DISABLED)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    users u
                    INNER JOIN employees e
                        ON u.ID_E = e.ID_E
                SET
                    u.is_inactive = ' . $i_disableMode . ',
                    u.modified_by_user = "' . $modified_by_user . '",
                    u.modified_time    = "' . $modified_time . '",
                    u.modified_date    = "' . $modified_date . '"
                WHERE
                    u.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deleteDepartmentAccess($i_departmentId)
    {
        $sql = 'DELETE
                FROM
                    users_department
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_DEPT = ' . $i_departmentId;

        BaseQueries::performDeleteQuery($sql);
    }
}

?>
