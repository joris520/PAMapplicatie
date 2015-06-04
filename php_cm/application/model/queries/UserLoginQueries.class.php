<?php

/**
 * Description of UserLoginQueries
 *
 * @author ben.dokter
 */

class UserLoginQueries {

    static function findPassWordInfoByUserName($s_username)
    {
        $sql = 'SELECT
                    u.password
                FROM
                    users u
                    LEFT JOIN employees e
                        ON u.ID_E = e.ID_E
                WHERE
                    (e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                     OR e.is_inactive is NULL)
                    AND u.is_inactive = ' . USER_IS_ACTIVE . '
                    AND LOWER(username) = "' . mysql_real_escape_string(trim($s_username)) . '"
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updatePasswordForUser($i_user_id,
                                          $s_new_password,
                                          $modified_by_user)
    {
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    users
                SET
                    password = "' . mysql_real_escape_string($s_new_password) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    user_id = ' . $i_user_id . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function getUserInfo($s_username)
    {
        $sql = 'SELECT
                    user_id,
                    customer_id
                FROM
                    users
                WHERE
                    username = "' . mysql_real_escape_string($s_username) . '"
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }


    static function getUserLoginByUserId($i_userId, $userIsLoggedIn)
    {
        $sql_filterCustomer = $userIsLoggedIn ? ' customer_id = ' . CUSTOMER_ID . ' AND ' : '';

        $sql = 'SELECT
                    password as dbpassword
                FROM
                    users
                WHERE
                    ' . $sql_filterCustomer . '
                    user_id = ' . $i_userId . '
                    AND is_inactive = ' . USER_IS_ACTIVE . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateLastLogin($i_user_id)
    {
        $sql = 'UPDATE
                    users
                SET
                    last_login = "' . MODIFIED_DATE . ' | ' . MODIFIED_TIME . '"
                WHERE
                    user_id = ' . $i_user_id . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

}

?>
