<?php

/**
 * Description of CompetenceQueriesDeprecated
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');

class CompetenceQueriesDeprecated {

    // applicatie specifiek, dus (nog) niet customer specifiek
    static function getCategories($i_category_id = null)
    {
        $filter = empty($i_category_id) ? '' : ' WHERE ks.ID_KS = ' . $i_category_id;
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill ks ' .
                $filter . '
                ORDER BY
                    ID_KS';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getClustersByCategory($i_category_id)
    {
        $sql = 'SELECT
                    ksc.*,
                    count(ksp.ID_KSP) as competence_count
                FROM
                    knowledge_skill_cluster ksc
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksc.ID_KS
                            AND ks.ID_KS = ' . $i_category_id . '
                    LEFT JOIN knowledge_skills_points ksp
                        ON ksp.id_c = ksc.ID_C
                WHERE
                    ksc.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    ksc.ID_C
                ORDER BY
                    ksc.cluster';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getCompetencesByCluster($i_category_id, $i_cluster_id)
    {
        $which_cluster .= ($i_cluster_id === null) ? ' AND ksp.ID_C is null' : ' AND ksp.ID_C = ' . $i_cluster_id;
        $sql = 'SELECT
                    ksp.ID_KSP,
                    ksp.ID_KS,
                    ksp.ID_C,
                    ksp.scale,
                    ksp.is_key,
                    ksp.is_cluster_main,
                    ksp.modified_by_user,
                    ksp.modified_date,
                    ksp.modified_time,
                    ksp.knowledge_skill_point,
                    ksc.cluster
                FROM
                    knowledge_skills_points ksp
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksp.ID_C = ksc.ID_C
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KS = ' . $i_category_id .
                    $which_cluster . '
                ORDER BY
                    ksp.is_cluster_main DESC,
                    ksp.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getCompetencesByCategory($i_category_id)
    {
        $sql = 'SELECT
                    ksp.ID_KSP,
                    ksp.knowledge_skill_point
                FROM
                    knowledge_skills_points ksp
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KS = ' . $i_category_id . '
                ORDER BY
                    ksp.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getCompetencesByIds($as_competence_ids)
    {
        if (is_array($as_competence_ids)) {
            $filter_competences = implode(',', $as_competence_ids);
        } else {
            $filter_competences = $as_competence_ids;
        }
        $sql = 'SELECT
                    ksp.ID_KSP,
                    ksp.knowledge_skill_point
                FROM
                    knowledge_skills_points ksp
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KSP in (' . $filter_competences . ')
                ORDER BY
                    ksp.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getClusterDetails($i_cluster_id)
    {
        $sql = 'SELECT
                    ksc.*
                FROM
                    knowledge_skill_cluster ksc
                WHERE
                    ksc.customer_id = ' . CUSTOMER_ID . '
                    AND ksc.ID_C = ' . $i_cluster_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;

    }
//    static function getAllCompetencesNames($i_category_id)
//    {
//        $sql = 'SELECT
//                    ksp.ID_KSP,
//                    ksp.knowledge_skill_point
//                FROM
//                    knowledge_skills_points ksp
//                WHERE
//                    ksp.customer_id = ' . CUSTOMER_ID . '
//                ORDER BY
//                    ksp.knowledge_skill_point';
//        $sql_result = BaseQueries::performQuery($sql);
//        return $sql_result;
//    }


    static function addClusterToCategory($i_category_id, $s_cluster_name)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    knowledge_skill_cluster
                    (   customer_id,
                        ID_KS,
                        cluster,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_category_id . ',
                        "' . mysql_real_escape_string($s_cluster_name) . '",
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '")';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();
    }

    static function updateClusterInCategory($i_category_id, $i_cluster_id, $s_cluster_name)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    knowledge_skill_cluster
                SET
                    ID_KS = ' . $i_category_id . ',
                    cluster = "' . mysql_real_escape_string($s_cluster_name) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C  = ' . $i_cluster_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function updateCategoryInClusteredCompetence($i_category_id, $i_cluster_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    knowledge_skills_points
                SET
                    ID_KS = ' . $i_category_id . ',
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $i_cluster_id . '
                    AND ID_KS <> ' . $i_category_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function resetClusterMainCompetence($i_cluster_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    knowledge_skills_points
                SET
                    is_cluster_main = 0,
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $i_cluster_id . '
                    AND is_cluster_main = ' . COMPETENCE_CLUSTER_IS_MAIN . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function setClusterMainCompetence($i_cluster_id, $i_competence_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    knowledge_skills_points
                SET
                    is_cluster_main = ' . COMPETENCE_CLUSTER_IS_MAIN . ',
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $i_cluster_id . '
                    AND ID_KSP = ' . $i_competence_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function addCompetenceToCluster($i_category_id,
                                           $i_cluster_id,
                                           $s_competence_name,
                                           $s_description,
                                           $i_scale,
                                           $s_norm1,
                                           $s_norm2,
                                           $s_norm3,
                                           $s_norm4,
                                           $s_norm5,
                                           $i_is_na_allowed,
                                           $i_is_key)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql ='INSERT INTO
                    knowledge_skills_points
                    (
                        customer_id,
                        ID_KS,
                        ID_C,
                        knowledge_skill_point,
                        description,
                        is_key,
                        1none,
                        2basic,
                        3average,
                        4good,
                        5specialist,
                        scale,
                        is_na_allowed,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                        "' . $i_category_id . '",
                        "' . $i_cluster_id . '",
                        "' . mysql_real_escape_string($s_competence_name) . '",
                        "' . mysql_real_escape_string($s_description) . '",
                        "' . $i_is_key . '",
                        "' . mysql_real_escape_string($s_norm1) . '",
                        "' . mysql_real_escape_string($s_norm2) . '",
                        "' . mysql_real_escape_string($s_norm3) . '",
                        "' . mysql_real_escape_string($s_norm4) . '",
                        "' . mysql_real_escape_string($s_norm5) . '",
                        "' . $i_scale . '",
                        "' . $i_is_na_allowed . '",
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '"
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();
    }

    static function updateCompetenceInCluster($i_category_id,
                                              $i_cluster_id,
                                              $i_competence_id,
                                              $s_competence_name,
                                              $s_description,
                                              $i_scale,
                                              $s_norm1,
                                              $s_norm2,
                                              $s_norm3,
                                              $s_norm4,
                                              $s_norm5,
                                              $i_is_na_allowed,
                                              $i_is_key)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        //update query
        $sql = 'UPDATE
                    knowledge_skills_points
                SET
                    ID_KS = ' . $i_category_id . ',
                    ID_C = ' . $i_cluster_id . ',
                    knowledge_skill_point = "' . mysql_real_escape_string($s_competence_name) . '",
                    description = "' . mysql_real_escape_string($s_description) . '",
                    is_key = ' . $i_is_key . ',
                    1none = "' . mysql_real_escape_string($s_norm1) . '",
                    2basic = "' . mysql_real_escape_string($s_norm2) . '",
                    3average = "' . mysql_real_escape_string($s_norm3) . '",
                    4good = "' . mysql_real_escape_string($s_norm4) . '",
                    5specialist = "' . mysql_real_escape_string($s_norm5) . '",
                    scale = "' . mysql_real_escape_string($i_scale) . '",
                    is_na_allowed = ' . $i_is_na_allowed. ',
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function findClusterByName($s_cluster_name, $i_exclude_cluster_id)
    {
        $filter_id = empty($i_exclude_cluster_id) ? ' ' : ' AND ID_C <> ' . $i_exclude_cluster_id;
        $sql = 'SELECT
                    cluster
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID .
                    $filter_id . '
                    AND LOWER(cluster) like LOWER("' . mysql_real_escape_string($s_cluster_name) . '")';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function findCompetenceByName($s_competence_name, $i_exclude_competence_id)
    {
        // controleer bestaande competentienaam
        $filter_ksp = (!empty($i_exclude_competence_id)) ? ' AND ID_KSP <> ' . $i_exclude_competence_id :  '';

        $sql = 'SELECT
                    knowledge_skill_point
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND LOWER(knowledge_skill_point) like LOWER("' . $s_competence_name . '")' .
                    $filter_ksp;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function deleteCompetenceEmployeeScores($i_competence_id)
    {
        $sql = 'DELETE
                FROM
                    employees_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function deleteCompetenceFunctions($i_competence_id)
    {
        $sql = 'DELETE
                FROM
                    function_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP =' . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function deleteCompetence($i_competence_id)
    {
        $sql = 'DELETE
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = '  . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function deleteUnusedCluster($i_cluster_id)
    {
        $sql = 'DELETE
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $i_cluster_id;
        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }


    static function getCompetenceDetails($i_competence_id)
    {
        $sql = 'SELECT
                    ks.knowledge_skill,
                    ksc.cluster,
                    ksp.*
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KSP = ' . $i_competence_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getLastModifiedCompetenceInClusterInfo($i_category_id, $i_cluster_id)
    {
        $filter_id = empty($i_cluster_id) ? ' ' : ' AND ksp.ID_C <> ' . $i_cluster_id;

        $sql = 'SELECT
                    modified_by_user,
                    modified_date,
                    modified_time
                FROM
                    knowledge_skills_points ksp
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID .
                    $filter_id . '
                    AND ksp.ID_KS = ' . $i_category_id . '
                ORDER BY
                    modified_date DESC
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getCompetenceUsage($i_competence_id)
    {
        $sql = 'SELECT
                    COUNT(fp.ID_FP) as used_in_functions_count
                FROM
                    function_points fp
                WHERE
                    fp.customer_id = ' . CUSTOMER_ID . '
                    AND fp.ID_KSP = ' . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getClusterUsageCount($i_category_id, $i_cluster_id)
    {
        $sql = 'SELECT
                    COUNT(ksp.ID_KSP) as used_in_competences_count
                FROM
                    knowledge_skills_points ksp
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KS = ' . $i_category_id . '
                    AND ksp.ID_C = ' . $i_cluster_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }
}

?>
