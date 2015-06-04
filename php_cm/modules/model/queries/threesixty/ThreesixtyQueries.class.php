<?php

/**
 * Description of ThreesixtyQueries
 *
 * @author wouter.sorteboom
 */

require_once('gino/BaseQueries.class.php');

class ThreesixtyQueries {

    static function deletePreviousEvaluationScores($s_hash_id)
    {
        $sql = 'DELETE
                FROM
                    threesixty_evaluation
                WHERE
                    customer_id =  ' . CUSTOMER_ID . '
                    AND hash_id = "' . mysql_real_escape_string($s_hash_id) . '"';

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function addNewEvaluationScore($i_employee_id,
                                          $i_competence_id,
                                          $s_hash_id,
                                          $s_evaluator,
                                          $s_evaluator_email,
                                          $s_score,
                                          $s_remarks)
    {
        $s_add_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    threesixty_evaluation
                    (   customer_id,
                        ID_KSP,
                        ID_E,
                        hash_id,
                        evaluator,
                        evaluator_email,
                        threesixty_score,
                        notes,
                        date_sentback
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_competence_id . ',
                         ' . $i_employee_id . ',
                        "' . mysql_real_escape_string($s_hash_id) . '" ,
                        "' . mysql_real_escape_string($s_evaluator) . '",
                        "' . mysql_real_escape_string($s_evaluator_email) . '",
                        "' . mysql_real_escape_string($s_score) . '",
                        "' . mysql_real_escape_string($s_remarks) . '",
                        "' . mysql_real_escape_string($s_add_date) . '"
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();
    }

    static function setEvaluationComplete($s_hash_id)
    {
        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    `completed` = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                WHERE
                    hash_id = "' . mysql_real_escape_string($s_hash_id) . '"
                LIMIT 1';

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function getEmployeeInformation($i_employee_id)
    {
        $sql = 'SELECT
                    e.firstname,
                    e.lastname,
                    e.ID_FID,
                    d.department,
                    c.logo,
                    c.company_name,
                    c.customer_id,
                    c.email_address AS customer_email,
                    co.show_360_eval_category_header,
                    co.show_360_eval_job_profile,
                    co.show_360_eval_department,
                    co.use_cluster_main_competence,
                    co.use_skill_notes,
                    co.show_360_competence_details
                FROM
                    employees e
                    INNER JOIN department d
                        ON d.ID_DEPT = e.ID_DEPTID
                    INNER JOIN customers c
                        ON c.customer_id = e.customer_id
                    INNER JOIN customers_options co
                        ON co.customer_id = c.customer_id
                WHERE
                    e.ID_E = ' . $i_employee_id . '
                    AND e.customer_id = ' . CUSTOMER_ID;

        $sql_result = BaseQueries::performQuery($sql);

        return $sql_result;
    }

    static function get360Competences ($i_function_id, $s_competences)
    {
        $sql = 'SELECT
                    fp.ID_FP,
                    fp.scale as "fp_scale",
                    fp.ID_F,
                    ksp.is_key,
                    ksp.ID_KSP,
                    ksp.ID_KS,
                    ksp.knowledge_skill_point,
                    ksp.scale as "ksp_scale",
                    ksp.is_na_allowed,
                    ksp.is_cluster_main,
                    ksc.cluster,
                    ks.knowledge_skill as category
                FROM
                    function_points fp
                    INNER JOIN knowledge_skills_points ksp
                        ON ksp.ID_KSP = fp.ID_KSP
                    LEFT JOIN knowledge_skill ks
                        ON ksp.ID_KS = ks.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksp.ID_C  = ksc.ID_C
                WHERE
                    fp.ID_F = ' . $i_function_id . '
                    AND ksp.ID_KSP IN (' . mysql_real_escape_string($s_competences) . ')
                GROUP BY
                    ksp.ID_KSP
                ORDER BY
                    ks.knowledge_skill,
                    CASE
                        WHEN ksc.cluster is null
                        THEN "zzz"
                        ELSE ksc.cluster
                    END,
                    ksp.is_cluster_main DESC,
                    ksp.knowledge_skill_point';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getHashInformation($s_hash_id)
    {
        $sql = 'SELECT
                    ti.*,
                    pd.ID_EC,
                    c.lang_id
                FROM
                    threesixty_invitations ti
                    INNER JOIN person_data pd
                            ON ti.id_pd = pd.ID_PD
                    INNER JOIN customers c
                            ON ti.customer_id = c.customer_id
                WHERE
                    ti.hash_id = "' . mysql_real_escape_string($s_hash_id) . '"
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getThreesixtyIsCompleted ($s_hash_id)
    {
        $sql = 'SELECT
                    completed
                FROM
                    threesixty_invitations
                WHERE
                    hash_id = "' . mysql_real_escape_string($s_hash_id) . '"';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getHashFromInvitations($s_hash_id)
    {
        $sql = 'SELECT
                    hash_id
                FROM
                    threesixty_invitations
                WHERE
                    hash_id = "' . mysql_real_escape_string($s_hash_id) . '"';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function getCompetence360Score($i_employee_id, $i_competence_id, $use_self_evaluation, $show_only_if_final)
    {
        $score_filter = $use_self_evaluation ? ' AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL : '';
        $score_filter .= $show_only_if_final ? ' AND et.score_status = ' . ScoreStatusValue::FINALIZED  : '';
        $is_self_evaluation = $use_self_evaluation ? AssessmentInvitationTypeValue::IS_SELF_EVALUATION : AssessmentInvitationTypeValue::IS_360;
        //FROM 360 EVALUATION FORM
        $sql = 'SELECT
                    te.ID_E,
                    te.ID_KSP,
                    te.threesixty_score,
                    te.notes
                FROM
                    threesixty_evaluation te
                    INNER JOIN threesixty_invitations ti
                        ON te.hash_id = ti.hash_id
                        and te.id_e = ti.id_e
                    INNER JOIN employees_topics et
                        ON et.id_e = ti.id_e
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND ti.is_self_evaluation = ' . $is_self_evaluation . '
                    AND te.ID_E = ' . $i_employee_id .
                    $score_filter . '
                    AND te.ID_KSP = ' . $i_competence_id;
        
        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }
}

?>
