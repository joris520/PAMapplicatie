<?php


/**
 * Description of DocumentClusterQueries
 *
 * @author ben.dokter
 */

class DocumentClusterQueries
{
    const ID_FIELD = 'ID_DC';

    static function getDocumentClusters()
    {

        $sql = 'SELECT
                    *
                FROM
                    document_clusters
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                ORDER BY
                    document_cluster';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectDocumentCluster($i_documentClusterId)
    {

        $sql = 'SELECT
                    *
                FROM
                    document_clusters
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_DC = ' . $i_documentClusterId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function findDocumentClusterWithName($s_clusterName)
    {
        $sql = 'SELECT
                    *
                FROM
                    document_clusters
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND UPPER(document_cluster) = UPPER("' . mysql_real_escape_string($s_clusterName) . '")
                LIMIT 1' ;

        return BaseQueries::performSelectQuery($sql);
    }


    static function insertDocumentCluster($s_clusterName)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    document_clusters
                    (   customer_id,
                        document_cluster,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                       "' . mysql_real_escape_string($s_clusterName) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateDocumentCluster($i_documentClusterId,
                                          $s_clusterName)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    document_clusters
                SET
                    document_cluster    = "' .  mysql_real_escape_string($s_clusterName) . '",
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_DC = ' . $i_documentClusterId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function countUsage($i_documentClusterId)
    {
        $sql = 'SELECT
                    count(*) as counted
                FROM
                    employees_documents ed
                WHERE
                    ed.customer_id = ' . CUSTOMER_ID . '
                    AND ed.ID_DC = ' . $i_documentClusterId;

        return BaseQueries::performSelectQuery($sql);
    }

    static function deleteDocumentCluster($i_documentClusterId)
    {
        $sql = 'DELETE
                FROM
                    document_clusters
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_DC = ' . $i_documentClusterId . '
                LIMIT 1';

        return BaseQueries::performDeleteQuery($sql);
    }

    static function getClusterByName($s_clusterName)
    {
        $sql = 'SELECT
                    *
                FROM
                    document_clusters
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND LOWER(document_cluster) = LOWER("' . mysql_real_escape_string($s_clusterName) . '")
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

}
?>
