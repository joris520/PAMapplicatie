<?php

/**
 * Description of CompetenceQueries
 *
 * @author ben.dokter
 */
class CompetenceQueries
{
    const ID_FIELD = 'ID_KSP';

    static function selectCompetence($i_competenceId)
    {
        $sql = 'SELECT
                    ksp.*,
                    ks.knowledge_skill,
                    ksc.cluster
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KSP = ' . $i_competenceId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectCompetences($i_functionId)
    {
        $sql = 'SELECT
                    ksp.*,
                    ks.knowledge_skill,
                    ksc.cluster,
                    fp.scale as norm
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
                    AND fp.ID_F = ' . $i_functionId . '
                GROUP BY
                    ksp.ID_KSP
                ORDER BY
                    ks.ID_KS,
                    CASE
                        WHEN ksc.cluster is null
                        THEN "zzz"
                        ELSE ksc.cluster
                    END,
                    ksp.is_cluster_main DESC,
                    ksp.knowledge_skill_point';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectCompetencesByArray($a_competences)
    {
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points 
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP IN (' . implode(',',$a_competences) . ')
                ORDER BY
                    knowledge_skill_point ASC';

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
