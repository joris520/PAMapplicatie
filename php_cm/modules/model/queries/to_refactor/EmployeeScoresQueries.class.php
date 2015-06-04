<?php

require_once('gino/BaseQueries.class.php');

/**
 * Description of EmployeeScoresQueries
 *
 * @author ben.dokter
 */
class EmployeeScoresQueries {

    // hierheen verplaatst
    static function getTotalScore($i_employee_id)
    {
        $sql = 'SELECT
                    ets.*
                FROM
                    employees_total_scores ets
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_e = ' . $i_employee_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function saveTotalScore($i_employee_id,
                                   $i_totalScore,
                                   $i_behaviourScore,
                                   $i_resultsScore,
                                   $s_totalScoreComment,
                                   $s_behaviourScoreComment,
                                   $s_resultsScoreComment)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'REPLACE INTO
                   employees_total_scores
                   (
                        customer_id,
                        id_e,
                        total_score,
                        behaviour_score,
                        results_score,
                        total_score_comment,
                        behaviour_score_comment,
                        results_score_comment,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                          ' . CUSTOMER_ID . ',
                          ' . $i_employee_id . ',
                          ' . $i_totalScore . ',
                          ' . $i_behaviourScore. ',
                          ' . $i_resultsScore. ',
                         "' . mysql_real_escape_string($s_totalScoreComment) . '",
                         "' . mysql_real_escape_string($s_behaviourScoreComment) . '",
                         "' . mysql_real_escape_string($s_resultsScoreComment) . '",
                         "' . $modified_by_user . '",
                         "' . $modified_time . '",
                         "' . $modified_date . '"
                    )';

        return BaseQueries::performUpdateQuery($sql);
    }

    // TODO: refactor!!! zie getEmployeeScoresFunctions
    // pfff, deze query kan heel erg eenvoudiger; en wat moet die $i_main_function??
    // Volgens mij moet er : voor alle competenties een left join op ingevulde employee points
    static function getEmployeeScoresDictionary($i_employee_id, $i_main_function_id)
    {
        $sql = 'SELECT
                    ksp.ID_KSP,
                    ks.knowledge_skill,
                    CASE
                            WHEN ksc.cluster is null
                            THEN "zzz"
                            ELSE ksc.cluster
                    END as cluster,
                    ksp.knowledge_skill_point,
                    ksp.is_key,
                    ksp.is_na_allowed,
                    ksp.is_cluster_main,
                    emp_sub.scale,

                    fp.scale as norm,
                    fp.weight_factor,
                    emp_sub.note,
                    emp_sub.modified_by_user, emp_sub.modified_date, emp_sub.modified_time
                FROM
                    knowledge_skills_points ksp
                    JOIN knowledge_skill ks ON ks.ID_KS = ksp.ID_KS
                    LEFT OUTER JOIN (
                            SELECT
                            e.ID_E,
                            ep.ID_KSP,
                            e.ID_FID,
                            ep.scale as scale,
                            ep.note, ep.modified_by_user, ep.modified_date, ep.modified_time,
                            s.description as scale_description
                            FROM
                                employees_points ep
                                JOIN employees e ON e.ID_E = ep.ID_E
                            WHERE
                            ep.ID_E = ' . $i_employee_id . '

                    ) emp_sub ON emp_sub.ID_KSP = ksp.ID_KSP


                    LEFT OUTER JOIN knowledge_skill_cluster ksc ON ksc.ID_C = ksp.ID_C

                    LEFT OUTER JOIN (
                            SELECT fp.scale, fp.weight_factor, fp.ID_KSP, fp.ID_F
                            FROM function_points fp WHERE fp.ID_KSP IN (
                                SELECT
                                    ksp.ID_KSP
                                FROM
                                    function_points fp
                                    LEFT OUTER JOIN knowledge_skills_points ksp ON ksp.ID_KSP = fp.ID_KSP
                                WHERE
                                    fp.ID_F = ' . $i_main_function_id . '
                            )
                    ) fp ON fp.ID_KSP = ksp.ID_KSP AND fp.ID_F = emp_sub.ID_FID
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    ksp.knowledge_skill_point
                ORDER BY
                    ks.knowledge_skill,
                    cluster,
                    ksp.is_cluster_main DESC,
                    ksp.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    // TODO: normale query maken
    static function getEmployeeScoresFunctions_orig($i_employee_id, $i_main_function_id)
    {
        // NOTE VAN SJOERD:
        // NB de dubbele select hieronder is niet een vergissing, maar noodzakelijk, omdat er eerst gesorteerd
        // moet worden (op hoofd, neven functies en vervolgens binnen neven functies op norm)
        // om vervolgens een group by (voor unieke competentie lijst) uit te voeren
        $sql = 'SELECT
                    result.*
                FROM
                (
                    SELECT
                    e.ID_E,
                    e.ID_FID,
                    ef.ID_F,
                    ef.mainORadditional,
                    ef.sort,
                    ksp.ID_KSP,
                    ks.knowledge_skill,
                    CASE
                            WHEN ksc.cluster is null
                            THEN "zzz"
                            ELSE ksc.cluster
                    END as cluster,
                    ksp.knowledge_skill_point,
                    ksp.scale as ksp_scale,
                    ksp.is_key,
                    ksp.is_na_allowed,
                    ksp.is_cluster_main,
                    ep.scale,

                    fp.scale as norm,

                    fp.weight_factor,
                    fp.key_com,
                    ep.note, ep.modified_by_user, ep.modified_date, ep.modified_time
                    FROM
                    employees e
                    LEFT OUTER JOIN (
                        SELECT *
                        FROM
                        (
                        SELECT
                        e.ID_E,
                        e.ID_FID AS ID_F,
                        "main" AS mainORadditional,
                        "a" AS sort
                        FROM
                        employees e

                        UNION

                        SELECT
                        eaf.ID_E,
                        eaf.ID_F AS ID_F,
                        (SELECT function FROM functions WHERE ID_F = eaf.ID_F) AS mainORadditional,
                        "z" AS sort
                        FROM
                        employees_additional_functions eaf
                        ) union_result
                        WHERE union_result.ID_E = ' . $i_employee_id . '
                    ) ef ON ef.ID_E = e.ID_E
                    LEFT OUTER JOIN function_points fp ON fp.ID_F = ef.ID_F
                    LEFT OUTER JOIN functions f ON f.ID_F = ef.ID_F
                    LEFT OUTER JOIN knowledge_skills_points ksp ON ksp.ID_KSP = fp.ID_KSP
                    LEFT OUTER JOIN knowledge_skill ks ON ks.ID_KS = ksp.ID_KS
                    LEFT OUTER JOIN department d ON d.ID_DEPT = e.ID_DEPTID
                    LEFT OUTER JOIN knowledge_skill_cluster ksc ON ksc.ID_C = ksp.ID_C

                    LEFT OUTER JOIN (
                        SELECT
                            ep.ID_E, ep.ID_KSP, ep.scale, ep.note, ep.modified_by_user, ep.modified_date, ep.modified_time
                        FROM
                            employees_points ep
                        WHERE
                            ep.ID_E IN (' . $i_employee_id . ')
                            AND ID_KSP IN (
                                SELECT
                                    ksp.ID_KSP
                                FROM
                                    function_points fp
                                    LEFT OUTER JOIN knowledge_skills_points ksp ON ksp.ID_KSP = fp.ID_KSP
                                WHERE
                                    fp.ID_F = ' . $i_main_function_id . '
                                    OR fp.ID_F IN (SELECT ID_F FROM employees_additional_functions WHERE ID_E=' . $i_employee_id . ')
                            )
                    ) ep ON ep.ID_KSP = ksp.ID_KSP AND ep.ID_E = e.ID_E
                    WHERE
                    e.ID_E = ' . $i_employee_id . '
                    AND NOT (ksp.ID_KSP IS NULL)
                    AND e.is_inactive = 0
                    AND e.customer_id=" . CUSTOMER_ID . "
                    ORDER BY
                    ks.knowledge_skill,
                    cluster,
                    ksp.knowledge_skill_point,
                    ef.sort,
                    norm DESC

                ) result
            GROUP BY
                result.knowledge_skill_point
            ORDER BY
                result.knowledge_skill,
                result.cluster,
                result.is_cluster_main DESC,
                result.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    // alle competenties van de hoofd functie en neven functies ophalen met de ingevulde score,
    // gesorteerd op category, cluster en competentie. Bij de nevenfuncties moet ook de maximale norm opgehaald worden als er meerdere identieke competenties zijn.
    // verder worden gelijk het aantal acties en de 360 scores meegenomen
    static function getEmployeeScoresFunctions($i_employee_id, $i_main_function_id)
    {
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
                                ep.ID_EP as score_id,
                                ep.scale as boss_score,
                                ep.note as boss_note,
                                fp_main.scale as max_norm,
                                fp_main.weight_factor,
                                COUNT(DISTINCT(epasp.ID_PDPEA_FID)) as actions,
                                AVG(
                                    CASE
                                        WHEN te.threesixty_score = "Y"
                                        THEN 5
                                        WHEN te.threesixty_score = "N"
                                        THEN 0
                                        ELSE te.threesixty_score
                                    END
                                ) as employee_score,
                                MAX(te.notes) as employee_note
                            FROM
                                knowledge_skills_points ksp_main
                                    INNER JOIN function_points fp_main
                                        ON ksp_main.ID_KSP = fp_main.ID_KSP
                                            AND ksp_main.customer_id = ' . CUSTOMER_ID . '
                                            AND fp_main.ID_F = ' . $i_main_function_id . '
                                    INNER jOIN knowledge_skill ks
                                        ON ksp_main.ID_KS = ks.ID_KS
                                    LEFT JOIN knowledge_skill_cluster ksc
                                        ON ksp_main.ID_C = ksc.ID_C
                                    LEFT JOIN employees_points ep
                                        ON ep.ID_KSP = ksp_main.ID_KSP
                                            AND ep.ID_E = ' . $i_employee_id . '
                                    LEFT JOIN employees_pdp_actions_skill_points epasp
                                        ON epasp.ID_KSP_FID = ksp_main.ID_KSP
                                            AND epasp.ID_E_FID = ' . $i_employee_id . '
                                    LEFT JOIN threesixty_evaluation te
                                        on te.ID_KSP = ksp_main.ID_KSP
                                            AND te.ID_E = ' . $i_employee_id . '
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
                                ep.ID_EP as score_id,
                                ep.scale as boss_score,
                                ep.note as boss_note,
                                max(fp_additional.scale) as max_norm,
                                fp_additional.weight_factor,
                                COUNT(DISTINCT(epasp.ID_PDPEA_FID)) as actions,
                                AVG(
                                    CASE
                                        WHEN te.threesixty_score = "Y"
                                        THEN 5
                                        WHEN te.threesixty_score = "N"
                                        THEN 0
                                        ELSE te.threesixty_score
                                    END
                                ) as employee_score,
                                MAX(te.notes) as employee_note
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
                                                                AND fp_main.ID_F = ' . $i_main_function_id . '
                                                                AND fp_main.customer_id = ' . CUSTOMER_ID . '
                                                )
                                    INNER JOIN employees_additional_functions eaf
                                        ON eaf.ID_F = fp_additional.ID_F
                                            AND eaf.ID_E = ' . $i_employee_id . '
                                    INNER JOIN knowledge_skill ks
                                        ON ksp_additional.ID_KS = ks.ID_KS
                                    LEFT JOIN knowledge_skill_cluster ksc
                                        ON ksp_additional.ID_C = ksc.ID_C
                                    LEFT JOIN employees_points ep
                                        ON ep.ID_KSP = ksp_additional.ID_KSP
                                            AND ep.ID_E = ' . $i_employee_id . '
                                    LEFT JOIN employees_pdp_actions_skill_points epasp
                                        ON epasp.ID_KSP_FID = ksp_additional.ID_KSP
                                            AND epasp.ID_E_FID = ' . $i_employee_id . '
                                    LEFT JOIN threesixty_evaluation te
                                        on te.ID_KSP = ksp_additional.ID_KSP
                                            AND te.ID_E = ' . $i_employee_id . '
                            GROUP BY
                                ksp_additional.ID_KSP
                        )
                    )  as all_ksp
                GROUP BY
                    all_ksp.competence_id
                ORDER BY
                    all_ksp.category,
                    CASE
                        WHEN all_ksp.cluster is null
                        THEN "zzzz"
                        ELSE all_ksp.cluster
                    END,
                    all_ksp.is_cluster_main DESC,
                    all_ksp.competence';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function getEmployeeScoreInfo($i_employee_id)
    {
        $sql = 'SELECT
                    e.rating,
                    et.ID_ET,
                    et.conversation_date
                FROM
                    employees e
                    LEFT JOIN employees_topics et
                        ON e.ID_E = et.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND e.ID_E = ' . $i_employee_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function getBossScore($i_employee_id, $i_competence_id)
    {
        $sql = 'SELECT
                    ep.scale as score,
                    ksp.scale,
                    ksp.is_na_allowed
                FROM
                    employees_points ep
                    INNER JOIN knowledge_skills_points ksp
                        ON ep.ID_KSP = ksp.ID_KSP
                WHERE
                    ep.customer_id = ' . CUSTOMER_ID . '
                    AND ep.ID_E = ' . $i_employee_id . '
                    AND ep.ID_KSP = ' . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function insertBossScore($i_employee_id, $i_competence_id, $s_score)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    employees_points
                    (   customer_id,
                        ID_E,
                        ID_KSP,
                        scale,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                          ' . CUSTOMER_ID . ',
                          ' . $i_employee_id . ',
                          ' . $i_competence_id . ',
                         "' . mysql_real_escape_string($s_score) . '",
                         "' . $modified_by_user . '",
                         "' . $modified_time . '",
                         "' . $modified_date . '"
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();
    }

    static function updateBossScore($i_employee_id, $i_competence_id, $i_score_id, $s_score)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_points
                SET
                    scale = "' . mysql_real_escape_string($s_score) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E   = ' . $i_employee_id . '
                    AND ID_KSP  = ' . $i_competence_id . '
                    AND ID_EP  = ' . $i_score_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function getBossNote($i_employee_id, $i_competence_id)
    {
        $sql = 'SELECT
                    ep.note as boss_note,
                    ksp.scale
                FROM
                    employees_points ep
                    INNER JOIN knowledge_skills_points ksp
                        ON ep.ID_KSP = ksp.ID_KSP
                WHERE
                    ep.customer_id = ' . CUSTOMER_ID . '
                    AND ep.ID_E = ' . $i_employee_id . '
                    AND ep.ID_KSP = ' . $i_competence_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function updateBossNote($i_employee_id, $i_competence_id, $i_score_id, $s_boss_note)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_points
                SET
                    note = "' . mysql_real_escape_string($s_boss_note). '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E   = ' . $i_employee_id . '
                    AND ID_KSP  = ' . $i_competence_id . '
                    AND ID_EP  = ' . $i_score_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

//    static function insertEvaluationDate($i_employee_id, $s_evaluationDate)
//    {
//        $modified_by_user = USER;
//        $modified_time = MODIFIED_TIME;
//        $modified_date = MODIFIED_DATE;
//
//        $sql = 'INSERT INTO
//                    employees_topics
//                    (   customer_id,
//                        ID_E,
//                        conversation_date,
//                        modified_by_user,
//                        modified_time,
//                        modified_date
//                    ) VALUES (
//                          ' . CUSTOMER_ID . ',
//                          ' . $i_employee_id . ',
//                          ' . $i_competence_id . ',
//                         STR_TO_DATE("' . mysql_real_escape_string($s_evaluationDate) . '", "%d-%m-%Y"),
//                         "' . $modified_by_user . '",
//                         "' . $modified_time . '",
//                         "' . $modified_date . '")';
//
//        BaseQueries::performQuery($sql);
//        return @mysql_insert_id();
//    }

    static function updateEvaluationDate($i_employee_id, $s_evaluationDate)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics
                SET
                    conversation_date = STR_TO_DATE("' . mysql_real_escape_string($s_evaluationDate) . '", "%d-%m-%Y"),
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E   = ' . $i_employee_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }


} // class EmployeeScoresQueries
?>
