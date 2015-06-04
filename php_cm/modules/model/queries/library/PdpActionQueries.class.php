<?php

/**
 * Description of PdpActionQueries
 *
 * @author ben.dokter
 */

class PdpActionQueries
{
    const ID_FIELD = 'ID_PDPA';
    const CLUSTER_ID_FIELD = 'ID_PDPAC';

    static function getPdpActions($i_pdpActionId = NULL)
    {
        $sql_filterPdpActionId = empty($i_pdpActionId) ? '' : ' AND pa.ID_PDPA = ' . $i_pdpActionId;

        $sql = 'SELECT
                    pa.*,
                    pac.cluster
                FROM
                    pdp_actions pa
                    INNER JOIN pdp_action_cluster pac
                        ON pac.ID_PDPAC = pa.ID_PDPAC
                WHERE
                    pa.customer_id = ' . CUSTOMER_ID . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    ' . $sql_filterPdpActionId . '
                ORDER BY
                    pac.cluster,
                    pa.action';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getPdpAction($i_pdpActionId)
    {
        $sql = 'SELECT
                    pa.*,
                    count(eap.ID_PDPEA) as pdp_action_usage
                FROM
                    pdp_actions pa
                    LEFT JOIN employees_pdp_actions eap
                        ON eap.ID_PDPAID = pa.ID_PDPA
                WHERE
                    pa.customer_id = ' . CUSTOMER_ID . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND pa.ID_PDPA = ' . $i_pdpActionId . '
                GROUP BY
                   pa.ID_PDPA';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getUserDefinedCluster()
    {
        $sql = 'SELECT
                    pac.*
                FROM
                   pdp_action_cluster pac
                WHERE
                    pac.customer_id = ' . CUSTOMER_ID . '
                    AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_SYSTEM;

        return BaseQueries::performSelectQuery($sql);
    }

    static function findPdpActionWithName($s_pdpActionName)
    {
        $sql = 'SELECT
                    pa.ID_PDPA
                FROM
                    pdp_actions pa
                WHERE
                    pa.customer_id = ' . CUSTOMER_ID . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND pa.action  = "' . mysql_real_escape_string($s_pdpActionName) . '"';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertPdpAction($i_clusterId,
                                    $s_actionName,
                                    $s_provider,
                                    $s_duration,
                                    $s_cost)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    pdp_actions
                    (   customer_id,
                        action,
                        ID_PDPAC,
                        is_customer_library,
                        provider,
                        duration,
                        costs,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                        "' . mysql_real_escape_string($s_actionName) . '",
                         ' . $i_clusterId . ',
                         ' . PDP_ACTION_LIBRARY_CUSTOMER. ',
                        "' . mysql_real_escape_string($s_provider) . '",
                        "' . mysql_real_escape_string($s_duration) . '",
                        "' . mysql_real_escape_string($s_cost) . '",
                        "' . mysql_real_escape_string($modified_by_user) . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updatePdpAction($i_pdpActionId,
                                    $i_clusterId,
                                    $s_actionName,
                                    $s_provider,
                                    $s_duration,
                                    $s_cost)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    pdp_actions
                SET
                    action   = "' . mysql_real_escape_string($s_actionName) . '",
                    ID_PDPAC =  ' . $i_clusterId . ',
                    provider = "' . mysql_real_escape_string($s_provider) . '",
                    duration = "' . mysql_real_escape_string($s_duration) . '",
                    costs    = "' . mysql_real_escape_string($s_cost) . '",
                    modified_by_user = "' . mysql_real_escape_string($modified_by_user)  . '",
                    modified_time    = "' . $modified_time . '",
                    modified_date    = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND id_pdpa = ' . $i_pdpActionId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deletePdpAction($i_pdpActionId)
    {
        $sql = 'DELETE
                FROM
                    pdp_actions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND ID_PDPA = ' . $i_pdpActionId ;

        return BaseQueries::performDeleteQuery($sql);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function getClusteredPdpActions()
    {
        $sql = 'SELECT
                    pac.*,
                    pa.ID_PDPA,
                    pa.action,
                    pa.provider,
                    pa.duration,
                    pa.costs,
                    count(eap.ID_PDPEA) as pdp_action_usage
                FROM
                    pdp_action_cluster pac
                    LEFT JOIN pdp_actions pa
                        ON pa.ID_PDPAC = pac.ID_PDPAC
                    LEFT JOIN employees_pdp_actions eap
                        ON eap.ID_PDPAID = pa.ID_PDPA
                WHERE
                    pac.customer_id = ' . CUSTOMER_ID . '
                    AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                GROUP BY
                   pac.ID_PDPAC,
                   pa.ID_PDPA
                ORDER BY
                    pac.cluster,
                    pa.action';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getCluster($i_clusterId)
    {
        $sql = 'SELECT
                    pac.*,
                    count(pa.ID_PDPA) as cluster_usage
                FROM
                    pdp_action_cluster pac
                    LEFT JOIN pdp_actions pa
                        ON pa.ID_PDPAC = pac.ID_PDPAC
                WHERE
                    pac.customer_id = ' . CUSTOMER_ID . '
                    AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND pac.ID_PDPAC = ' . $i_clusterId . '
                GROUP BY
                   pac.ID_PDPAC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getClusters()
    {
        $sql = 'SELECT
                    pac.*
                FROM
                    pdp_action_cluster pac
                WHERE
                    pac.customer_id = ' . CUSTOMER_ID . '
                    AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                GROUP BY
                   pac.cluster';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findPdpActionClusterWithName($s_clusterName)
    {
        $sql = 'SELECT
                    pac.*
                FROM
                    pdp_action_cluster pac
                WHERE
                    pac.customer_id = ' . CUSTOMER_ID . '
                    AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND pac.cluster  = "' . mysql_real_escape_string($s_clusterName) . '"';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertCluster($s_clusterName)
    {
        $sql = 'INSERT INTO
                    pdp_action_cluster
                    (   customer_id,
                        cluster,
                        is_customer_library
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                       "' . mysql_real_escape_string($s_clusterName) . '",
                        ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateCluster(  $i_clusterId,
                                    $s_clusterName)
    {
        $sql = 'UPDATE
                    pdp_action_cluster
                SET
                    cluster = "' .  mysql_real_escape_string($s_clusterName) . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND ID_PDPAC = ' . $i_clusterId ;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deleteCluster($i_clusterId)
    {
        $sql = 'DELETE
                FROM
                    pdp_action_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND ID_PDPAC = ' . $i_clusterId ;

        return BaseQueries::performDeleteQuery($sql);
    }
}

?>
