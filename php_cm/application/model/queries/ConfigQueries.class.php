<?php
/**
 * Description of ConfigQueries
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');
require_once('application/model/service/UserLoginService.class.php');

class ConfigQueries
{

    static function GetXajaxDebugInfo($i_user_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    xajax_debug
                WHERE
                    debug_on = ' . XAJAX_DEBUG_ON_VALUE_ENABLED . '
                    AND (customer_id = ' . CUSTOMER_ID . '
                         OR ID_USER = ' . $i_user_id . ')';

        return BaseQueries::performSelectQuery($sql);
    }

    static function GetAccessPriviliges($i_user_level, $i_customer_id)
    {
        $sql = 'SELECT
                    ulma.id_ma,
                    ulma.permission
                FROM
                    user_level ul
                    INNER JOIN user_level_module_access ulma
                        ON ul.id = ulma.id_ul
                WHERE
                    ul.customer_id  = ' . $i_customer_id . '
                    AND ul.level_id = ' . $i_user_level;

        return BaseQueries::performSelectQuery($sql);
    }


    static function GetApplicationModuleAccess()
    {
        $sql = 'SELECT
                    id,
                    tab_name
                FROM
                    module_access
                ORDER BY
                    tab_name';

        return BaseQueries::performSelectQuery($sql);
    }


    static function deleteUserLevelPrivileges($i_user_level, $i_customer_id, $s_allowed_permissions)
    {

        $keep_permisions_filter = empty($s_allowed_permissions) ? '' : ' AND id_ma NOT IN (' . $s_allowed_permissions . ')';
        $sql = 'DELETE
                FROM
                    user_level_module_access
                WHERE
                    customer_id = ' . $i_customer_id . '
                    AND id_ul = (   SELECT
                                        id
                                    FROM
                                        user_level
                                    WHERE
                                        customer_id = ' . $i_customer_id . '
                                        AND level_id = ' . $i_user_level . '
                                )
                    ' . $keep_permisions_filter;
        return BaseQueries::performDeleteQuery($sql);
    }

    static function addUserLevelPrivileges($i_user_level, $i_customer_id, $i_id_ma, $i_permission)
    {
        $sql = 'INSERT INTO
                    user_level_module_access
                    (   customer_id,
                        id_ul,
                        id_ma,
                        permission
                    ) VALUES (
                        ' . $i_customer_id . ',
                        (  SELECT
                                id
                            FROM
                                user_level
                            WHERE
                                customer_id = ' . $i_customer_id . '
                                AND level_id = ' . $i_user_level . '
                        ),
                        ' . $i_id_ma . ',
                        ' . $i_permission . '
                    )';
        $query = BaseQueries::performQuery($sql);
        return $query;
    }

    static function updateUserLevelPrivileges($i_user_level, $i_customer_id, $i_id_ma, $i_permission)
    {
        $sql = 'UPDATE
                    user_level_module_access ulma
                SET
                    ulma.permission = ' . $i_permission . '
                WHERE
                    ulma.customer_id = ' . $i_customer_id . '
                    AND ulma.id_ul = (  SELECT
                                            id
                                        FROM
                                            user_level
                                        WHERE
                                            customer_id = ' . $i_customer_id . '
                                            AND level_id = ' . $i_user_level . '
                                    )
                    AND ulma.id_ma = ' . $i_id_ma;
        $query = BaseQueries::performQuery($sql);
        return $query;
    }

}
?>
