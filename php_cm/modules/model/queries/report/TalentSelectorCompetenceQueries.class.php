<?php


/**
 * Description of CompetenceQueries
 *
 * @author hans.prins
 */
class TalentSelectorCompetenceQueries
{
    const ID_FIELD = 'ID_KSP';

    static function getCompetences()
    {
        $sql = 'SELECT
                    ks.knowledge_skill as category,
                    ksc.cluster,
                    ksp.ID_KS as categoryId,
                    ksp.ID_C as clusterId,
                    ksp.ID_KSP as competenceId,
                    ksp.knowledge_skill_point as competenceName,
                    ksp.is_key,
                    ksp.scale,
                    ksp.is_na_allowed,
                    ksp.is_cluster_main,
                    fp.scale as max_norm,
                    fp.weight_factor
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN function_points fp
                        ON fp.ID_KSP = ksp.ID_KSP
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    ksp.ID_KSP
                ORDER BY
                    ksp.knowledge_skill_point,
                    CASE
                        WHEN ksc.cluster is null
                        THEN "zzz"
                        ELSE ksc.cluster
                    END,
                    ksp.is_cluster_main DESC';

        return BaseQueries::performQuery($sql);
    }
}

?>
