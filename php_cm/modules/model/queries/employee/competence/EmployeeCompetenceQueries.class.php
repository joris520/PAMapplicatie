<?php

/**
 * Description of EmployeeCompetenceQueries
 *
 * @author ben.dokter
 */

class EmployeeCompetenceQueries
{

    const ID_FIELD = 'ID_F';

    static function getFunctionModeCompetences($i_employeeId, $i_mainFunctionId, $i_competenceClusterId = NULL) // nog geen periode voor functies, $dt_periodStart, $dt_reference);
    {
        //$minDateFilter = $dt_periodStart == NULL ? '' : 'AND saved_datetime > ' . $dt_periodStart ;
        $sql_clusterFilter = empty($i_competenceClusterId) ? '' : ' WHERE ksc.ID_C = ' . $i_competenceClusterId . ' ';

        $sql = 'SELECT
                    *
                FROM
                    (
                        (   SELECT
                                ks.knowledge_skill as category,
                                ksc.cluster,
                                1 as main_function,
                                ksp_main.ID_KS as category_id,
                                ksp_main.ID_C as cluster_id,
                                ksp_main.ID_KSP as competence_id,
                                ksp_main.knowledge_skill_point as competence,
                                ksp_main.is_key,
                                ksp_main.scale,
                                ksp_main.is_na_allowed,
                                ksp_main.is_cluster_main,
                                fp_main.scale as max_norm,
                                fp_main.weight_factor
                            FROM
                                knowledge_skills_points ksp_main
                                    INNER JOIN function_points fp_main
                                        ON ksp_main.ID_KSP = fp_main.ID_KSP
                                            AND ksp_main.customer_id = ' . CUSTOMER_ID . '
                                            AND fp_main.ID_F = ' . $i_mainFunctionId . '
                                    INNER JOIN knowledge_skill ks
                                        ON ksp_main.ID_KS = ks.ID_KS
                                    LEFT JOIN knowledge_skill_cluster ksc
                                        ON ksp_main.ID_C = ksc.ID_C
                            ' . $sql_clusterFilter . '
                            GROUP BY
                                ksp_main.ID_KSP
                        ) UNION (
                            SELECT
                                ks.knowledge_skill as category,
                                ksc.cluster,
                                0 as main_function,
                                ksp_additional.ID_KS as category_id,
                                ksp_additional.ID_C as cluster_id,
                                ksp_additional.ID_KSP as competence_id,
                                ksp_additional.knowledge_skill_point as competence,
                                ksp_additional.is_key,
                                ksp_additional.scale,
                                ksp_additional.is_na_allowed,
                                ksp_additional.is_cluster_main,
                                max(fp_additional.scale) as max_norm,
                                fp_additional.weight_factor
                            FROM
                                knowledge_skills_points ksp_additional
                                    INNER JOIN function_points fp_additional
                                        ON ksp_additional.ID_KSP = fp_additional.ID_KSP
                                            AND ksp_additional.customer_id = ' . CUSTOMER_ID . '
                                            AND ksp_additional.ID_KSP NOT IN
                                                (   SELECT
                                                        ksp_main.ID_KSP
                                                    FROM
                                                        knowledge_skills_points ksp_main
                                                        INNER JOIN function_points fp_main
                                                            ON ksp_main.ID_KSP = fp_main.ID_KSP
                                                                AND fp_main.ID_F = ' . $i_mainFunctionId . '
                                                                AND fp_main.customer_id = ' . CUSTOMER_ID . '
                                                )
                                    INNER JOIN employees_additional_functions eaf
                                        ON eaf.ID_F = fp_additional.ID_F
                                            AND eaf.ID_E = ' . $i_employeeId . '
                                    INNER JOIN knowledge_skill ks
                                        ON ksp_additional.ID_KS = ks.ID_KS
                                    LEFT JOIN knowledge_skill_cluster ksc
                                        ON ksp_additional.ID_C = ksc.ID_C
                            ' . $sql_clusterFilter . '
                            GROUP BY
                                ksp_additional.ID_KSP
                        )
                    )  as all_ksp
                GROUP BY
                    all_ksp.competence_id
                ORDER BY
                    all_ksp.category_id,
                    CASE
                        WHEN all_ksp.cluster is null
                        THEN "zzzz"
                        ELSE all_ksp.cluster
                    END,
                    all_ksp.is_cluster_main DESC,
                    all_ksp.competence';

        return BaseQueries::performQuery($sql);
    }
}

?>
