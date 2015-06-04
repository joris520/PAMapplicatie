<?php

/**
 * Description of BatchQueries
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');
require_once('modules/common/moduleConsts.inc.php');


class BatchQueries {

    static function insertAssessmentInvitationMessage($i_message_type,
                                                      $s_message_subject,
                                                      $s_message_from,
                                                      $s_message_template,
                                                      $s_message_lang_txt)
    {
        $sql = 'INSERT INTO
                    threesixty_invitations_messages
                    (
                        customer_id,
                        message_type,
                        message_date,
                        message_subject,
                        message_from,
                        message_template,
                        message_lang_txt,
                        modified_by_user,
                        modified_datetime
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_message_type . ',
                        NOW(),
                        "' . mysql_real_escape_string($s_message_subject) . '",
                        "' . mysql_real_escape_string($s_message_from) . '",
                        "' . mysql_real_escape_string($s_message_template) . '",
                        "' . mysql_real_escape_string($s_message_lang_txt) . '",
                        "' . USER . '",
                        NOW()
                    )';

            return BaseQueries::performInsertQuery($sql);
    }

    static function getLastInvitationMessages($filter_message_type = null)
    {
        $sql_filter_message_type = '';
        if (!empty($filter_message_type)) {
            if (is_array($filter_message_type)) {
                $filter_message_type = implode(',', $filter_message_type);
            }
            $sql_filter_message_type = ' AND message_type in (' . $filter_message_type . ')';
        }
        $sql = 'SELECT
                    message_template,
                    message_subject,
                    message_type
                FROM
                    threesixty_invitations_messages
                WHERE
                    customer_id = ' . CUSTOMER_ID .
                    $sql_filter_message_type . '
                ORDER BY
                    message_type desc,
                    ID_TSIM desc';

        return BaseQueries::performQuery($sql);
    }

    static function getSelfAssessementInvitationsInfo()
    {
        $sql = '(   SELECT
                        ti.completed,
                        tim.message_type,
                        count(*) as invitation_count,
                        ' . InvitationMessageTypeValue::INVITATION . ' as count_type,
                        count(*) as sent_count
                    FROM
                        threesixty_invitations ti
                        INNER JOIN threesixty_invitations_messages tim
                            ON ti.ID_TSIM = tim.ID_TSIM
                                AND ti.senddate IS NOT NULL
                        INNER JOIN employees e
                            ON e.id_e = ti.id_e
                                AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    WHERE
                        ti.customer_id = ' . CUSTOMER_ID . '
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION .'
                        AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                        AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                    GROUP BY
                        ti.completed,
                        tim.message_type
                ) UNION (
                    SELECT
                        ti.completed,
                        tim.message_type,
                        count(*) as invitation_count,
                        ' . THREESIXTY_MESSAGE_TYPE_REMINDER1 . ' as count_type,
                        SUM(IF(ti.senddate_reminder1 IS NOT NULL, 1, 0)) as sent_count
                    FROM
                        threesixty_invitations ti
                        INNER JOIN threesixty_invitations_messages tim
                            ON ti.ID_TSIM1 = tim.ID_TSIM
                                AND ti.senddate IS NOT NULL
                        INNER JOIN employees e
                            ON e.id_e = ti.id_e
                                AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    WHERE
                        ti.customer_id = ' . CUSTOMER_ID . '
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION .'
                        AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                        AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                    GROUP BY
                        ti.completed,
                        tim.message_type
                ) UNION (
                    SELECT
                        ti.completed,
                        tim.message_type,
                        count(*) as invitation_count,
                        ' . THREESIXTY_MESSAGE_TYPE_REMINDER2 . ' as count_type,
                        SUM(IF(ti.senddate_reminder2 IS NOT NULL, 1, 0)) as sent_count
                    FROM
                        threesixty_invitations ti
                        INNER JOIN threesixty_invitations_messages tim
                            ON ti.ID_TSIM2 = tim.ID_TSIM
                                AND ti.senddate IS NOT NULL
                                AND ti.senddate_reminder1 IS NOT NULL
                        INNER JOIN employees e
                            ON e.id_e = ti.id_e
                                AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    WHERE
                        ti.customer_id = ' . CUSTOMER_ID . '
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION .'
                        AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                        AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                    GROUP BY
                        ti.completed,
                        tim.message_type
                )';
        return BaseQueries::performQuery($sql);
    }

    static function updateAssessmentReminder($i_invitation_message_id)//, $i_message_type)
    {
        // TODO: uitbreiden naar 3 :-)
        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        // 1 wordt alleen overschreven als deze nog niet verzonden is,
        // 2 (laatste) mag altijd aangepast worden en wordt opnieuw verstuurt
        $sql = 'UPDATE
                    threesixty_invitations ti
                    INNER JOIN employees e
                        ON e.id_e = ti.id_e
                 SET
                    ti.ID_TSIM1 =   CASE WHEN ti.senddate_reminder1 IS NULL
                                         THEN ' . $i_invitation_message_id . '
                                         ELSE ti.ID_TSIM1
                                    END,
                    ti.ID_TSIM2 =   CASE WHEN ti.senddate_reminder1 IS NULL
                                         THEN ti.ID_TSIM2
                                         ELSE ' . $i_invitation_message_id . '
                                    END,
                    ti.senddate_reminder2 = CASE WHEN ti.senddate_reminder1 IS NULL
                                                 THEN ti.senddate_reminder2
                                                 ELSE NULL
                                            END,
                    ti.modified_by_user = "' . $modified_by_user . '",
                    ti.modified_datetime = "' . $modified_datetime . '"
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION .'
                    AND ti.completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CURRENT . '
                    AND ti.senddate IS NOT NULL
                    AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateAssessmentLetterOfSatisfaction($i_employee_id, $s_hash_id, $i_invitation_message_id)
    {
        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    ID_TSIM_LOS = ' . $i_invitation_message_id . ',
                    senddate_LOS = null,
                    modified_by_user = "' . $modified_by_user . '",
                    modified_datetime = "' . $modified_datetime . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id . '
                    AND hash_id = "' . $s_hash_id . '"';

        return BaseQueries::performUpdateQuery($sql);
    }


    static function getRemindedEmployeesByMessageId($i_invitation_message_id)
    {
        $sql = 'SELECT
                    e.lastname,
                    e.firstname,
                    CASE WHEN ti.ID_TSIM1 = ' . $i_invitation_message_id . '
                         THEN ' . THREESIXTY_MESSAGE_TYPE_REMINDER1 . '
                         ELSE ' . THREESIXTY_MESSAGE_TYPE_REMINDER2 . '
                    END AS reminder_type
                FROM
                    employees e
                    INNER JOIN threesixty_invitations ti
                        ON ti.id_e = e.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND (ti.ID_TSIM1 = ' . $i_invitation_message_id . ' OR
                         ti.ID_TSIM2 = ' . $i_invitation_message_id . ')
                ORDER BY
                    reminder_type,
                    e.lastname,
                    e.firstname';

        return BaseQueries::performTransactionalSelectQuery($sql);
    }


    // stap 1
    static function completeActiveAssessments($i_boss_id,
                                              $i_assessment_status = AssessmentProcessStatusValue::INVITED,
                                              $i_complete_assessment_status = AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                                              $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        // TODO: join met invitation
        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                    INNER JOIN threesixty_invitations ti
                        ON (ti.id_e = et.ID_E)
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                        AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CURRENT . '
                        AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period . '
                SET
                    ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . ',
                    et.assessment_status = ' . $i_complete_assessment_status . ',
                    et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::NOT_REQUESTED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.assessment_status = ' . $i_assessment_status;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function resetCompleteActiveAssessments($i_boss_id,
                                                   $i_assessment_status = AssessmentProcessStatusValue::INVITED,
                                                   $i_complete_assessment_status = AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED,
                                                   $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                    INNER JOIN threesixty_invitations ti
                        ON (ti.id_e = et.ID_E)
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                        -- AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period . '
                SET
                    et.assessment_status = ' . $i_assessment_status . ',
                    et.score_sum = NULL,
                    et.score_rank = ' . AssessmentProcessScoreRankingValue::NO_RANKING . ',
                    et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::NOT_REQUESTED . ',
                    et.assessment_evaluation_date = NULL,
                    ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CURRENT . ',
                    ti.threesixty_scores_sum = NULL,
                    ti.threesixty_score_diff_sum = NULL,
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND et.assessment_status = ' . $i_complete_assessment_status . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }


        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function calculateEmployees360Sum($i_boss_id,
                                             $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    threesixty_invitations ti
                    INNER JOIN employees e
                        ON ti.id_e = e.id_e
                SET
                    ti.modified_by_user = "' . $modified_by_user . '",
                    ti.modified_datetime = "' . $modified_datetime . '",
                    ti.threesixty_scores_sum = (SELECT
                                                    SUM(score_spread) as normalized_score
                                                FROM
                                                    threesixty_evaluation te_sum
                                                    INNER JOIN scale s
                                                        ON te_sum.threesixty_score = s.scale_name
                                                        AND te_sum.customer_id = s.customer_id
                                                WHERE
                                                    te_sum.customer_id = ' . CUSTOMER_ID . '
                                                    AND te_sum.hash_id = ti.hash_id
                                                    AND te_sum.ID_E = ti.ID_E
                                                )

                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . '
                    AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    // stap 2
    static function calculateManagerAssessmentScores($i_boss_id,
                                                     $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        // TODO: join met invitation
        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                    INNER JOIN threesixty_invitations ti
                        ON (ti.id_e = et.ID_E)
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                        AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period . '
                SET
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '",
                    et.score_sum = (SELECT
                                        SUM(score_spread) as normalized_manager_score
                                    FROM
                                        employees_points ep_sum
                                        INNER JOIN scale s
                                            ON ep_sum.scale = s.scale_name
                                            AND ep_sum.customer_id = s.customer_id
                                    WHERE
                                        ep_sum.customer_id = ' . CUSTOMER_ID . '
                                        AND ep_sum.ID_E = ti.ID_E
                                   )
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . '
                    AND et.score_status = ' . ScoreStatusValue::FINALIZED;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }


        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    // stap 3
    static function clearRankingMarks($i_boss_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                SET
                    et.score_rank = null,
                    et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::NOT_REQUESTED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    // stap 4
    static function calculateAssessmentDiff($i_boss_id,
                                            $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        // bereken per score het gespreide verschil tussen employee en boss
        $sql = 'UPDATE
                    threesixty_evaluation te
                    INNER JOIN threesixty_invitations ti
                        ON ti.hash_id = te.hash_id
                            AND ti.id_e = te.id_e
                            AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                            AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                            AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period . '
                    INNER JOIN employees e
                        ON ti.id_e = e.id_e
                    INNER JOIN employees_topics et
                        ON et.id_e = e.id_e
                    INNER JOIN employees_points ep
                        ON ep.ID_KSP = te.ID_KSP
                        AND ep.id_e = ti.id_e
                    INNER JOIN scale te_s
                        ON te_s.scale_name = te.threesixty_score
                        AND te_s.customer_id = te.customer_id
                SET
                    te.threesixty_score_diff = ABS(
                                                        (   te_s.score_spread   )
                                                        -
                                                        (   SELECT
                                                                ep_s.score_spread
                                                            FROM
                                                                employees_points ep_sum
                                                                INNER JOIN scale ep_s
                                                                    ON ep_s.scale_name = ep_sum.scale
                                                                    AND ep_s.customer_id = ep_sum.customer_id
                                                            WHERE
                                                                ep_sum.customer_id = ep.customer_id
                                                                AND ep_sum.ID_EP = ep.ID_EP
                                                                AND ep_sum.ID_E = ep.ID_E
                                                        )
                                                  ),
                    te.modified_by_user = "' . $modified_by_user . '",
                    te.modified_datetime = "' . $modified_datetime . '"
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.score_status = ' . ScoreStatusValue::FINALIZED . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function calculateAssessmentDiffSum($i_boss_id,
                                                $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    threesixty_invitations ti
                    INNER JOIN employees e
                        ON ti.id_e = e.id_e
                    INNER JOIN employees_topics et
                        ON et.id_e = e.id_e
                SET
                    ti.modified_by_user = "' . $modified_by_user . '",
                    ti.modified_datetime = "' . $modified_datetime . '",
                    ti.threesixty_score_diff_sum =  (   SELECT
                                                            SUM(threesixty_score_diff)
                                                        FROM
                                                            threesixty_evaluation te_sum
                                                        WHERE
                                                            te_sum.customer_id = ' . CUSTOMER_ID . '
                                                            AND te_sum.hash_id = ti.hash_id
                                                            AND te_sum.ID_E = ti.ID_E
                                                    )
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.score_status = ' . ScoreStatusValue::FINALIZED . '
                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . '
                    AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function markAssessmentDiff($i_boss_id,
                                       $i_diff_treshold = APPLICATION_ASSESSMENT_SCORE_DIFF_TRESHOLD,
                                       $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                    INNER JOIN threesixty_invitations ti
                        ON (ti.id_e = et.id_e)
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                        AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period . '
                SET
                    et.score_rank = ' . AssessmentProcessScoreRankingValue::RANKING_DIFF . ',
                    -- et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_NOT_DONE_DEPRECATED . '
                    AND et.assessment_status = ' . AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED . '
                    AND et.score_sum is not NULL
                    AND ti.threesixty_scores_sum is not NULL
                    AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . '
                    AND ti.threesixty_score_diff_sum >= ' . $i_diff_treshold;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function getAssessmentRankScoreWhereClause($i_boss_id, $employee_table_available = true)
    {
        if (!empty($i_boss_id)) {
            $sql_boss_filter .= ' AND et.ID_E IN (SELECT e2.ID_E FROM employees e2 WHERE e2.boss_fid = ' . $i_boss_id . ')';
        }
        if ($employee_table_available) {
            $sql_employee_filter = ' AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE ;
        }
        return ' et.customer_id = ' . CUSTOMER_ID . '
                 ' . $sql_employee_filter . '
                 AND et.assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_NOT_DONE_DEPRECATED . '
                 AND et.assessment_status = ' . AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED . '
                 AND et.score_sum IS NOT NULL '.
                 $sql_boss_filter;
    }

    static function findAssessmentRankScore($i_boss_id, $ranking_type)
    {
        if ($ranking_type == AssessmentProcessScoreRankingValue::RANKING_HIGH) {
            $sql_sum_select_clause = ' MAX(et.score_sum) as top_score_sum ';
        } else {
            $sql_sum_select_clause = ' MIN(et.score_sum) as top_score_sum ';
        }
        $sql_where_clause = BatchQueries::getAssessmentRankScoreWhereClause($i_boss_id);

        $sql = 'SELECT ' .
                    $sql_sum_select_clause .
               'FROM
                    employees_topics et
                    INNER JOIN employees e
                        ON e.ID_E = et.ID_E
                WHERE
               ' . $sql_where_clause;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    // stap 5 en 6
    // $ranking_type: AssessmentProcessScoreRankingValue::RANKING_HIGH of AssessmentProcessScoreRankingValue::RANKING_LOW
    static function markAssessmentRank($i_boss_id,
                                       $ranking_type,
                                       $ranking_score,
                                       $i_max_number_in_rank = APPLICATION_ASSESSMENT_RANK_COUNT,
                                       $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql_where_clause = BatchQueries::getAssessmentRankScoreWhereClause($i_boss_id, false);

        $sql = 'UPDATE
                    employees_topics et
                    -- INNER JOIN WIL NIET SAMEN MET EEN UPDATE MET ORDER BY...
                    -- INNER JOIN threesixty_invitations ti
                    --     ON (ti.id_e = et.id_e)
                    --         AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    --         AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . $i_invitation_active_period . '
                SET
                    et.score_rank = ' . $ranking_type . ',
                    et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
               ' .  $sql_where_clause . '
                    AND et.score_sum = ' . $ranking_score;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }


    // AssessmentProcessEvaluationRequestValue::REQUESTED en AssessmentProcessEvaluationRequestValue::NOT_REQUESTED apart ivm telling in terugkoppeling naar gebruiker
    static function inviteAssessmentEvaluationsRequested($i_boss_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                SET
                    et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.assessment_status = ' . AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED . '
                    AND et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED ;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function completeAssessmentEvaluationsNotInvited($i_boss_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                SET
                    et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.assessment_status = ' . AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED . '
                    AND et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::NOT_REQUESTED ;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }


        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function resetAssessmentEvaluationsSelected($i_boss_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                SET
                    et.assessment_status = ' . AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }



    // vinkje op scherm aan/uit
    static function setAssessmentEvaluationRequest($i_employee_id, $i_request_value)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                SET
                    et.assessment_evaluation_request_status = ' . $i_request_value . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND et.ID_E = ' . $i_employee_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function setAssessmentEvaluationDate($i_employee_id, $d_evaluationDate, $i_evaluation_status, $i_assessment_evaluation_attachment_id, $b_clear_attachment = false)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $i_assessment_evaluation_attachment_id = empty($i_assessment_evaluation_attachment_id) ? ($b_clear_attachment ? 'null' : 'assessment_evaluation_attachment_id') : $i_assessment_evaluation_attachment_id;

        $sql = 'UPDATE
                    employees_topics et
                SET
                    et.assessment_evaluation_date = "' . $d_evaluationDate . '",
                    et.assessment_evaluation_status = ' . $i_evaluation_status . ',
                    et.assessment_evaluation_attachment_id = ' . $i_assessment_evaluation_attachment_id . ',
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date = "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND et.ID_E = ' . $i_employee_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

//    static function deleteAssessmentEvaluationAttachment()
//    {
//
//    }
//
    // als een attachment verwijderd wordt ook de referentie assessment_evaluation_attachment_id opruimen.
    // TODO: verplaatsen naar employees_topics class oid...
    static function clearAssessmentEvaluationAttachment($i_employee_id, $i_document_id)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                SET
                    et.assessment_evaluation_attachment_id = NULL,
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date = "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND et.assessment_evaluation_attachment_id = ' . $i_document_id . '
                    AND et.ID_E = ' . $i_employee_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    // DEMO KNOPJE
    static function resetAssessments($i_boss_id,
                                     $i_invitation_active_period = CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_topics et
                    INNER JOIN employees e
                        ON et.id_e = e.id_e
                    INNER JOIN threesixty_invitations ti
                        ON (ti.id_e = et.ID_E)
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                SET
                    et.assessment_status = ' . AssessmentProcessStatusValue::INVITED . ',
                    et.score_sum = NULL,
                    et.score_status = ' . ScoreStatusValue::PRELIMINARY . ',
                    et.score_rank = ' . AssessmentProcessScoreRankingValue::NO_RANKING . ',
                    et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::NOT_REQUESTED . ',
                    et.assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_NOT_DONE_DEPRECATED . ',
                    et.assessment_evaluation_date = NULL,
                    ti.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CURRENT . ',
                    ti.threesixty_scores_sum = NULL,
                    et.modified_by_user = "' . $modified_by_user . '",
                    et.modified_time = "' . $modified_time . '",
                    et.modified_date= "' . $modified_date . '"
                WHERE
                    et.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL;

        if (!empty($i_boss_id)) {
            $sql .= ' AND e.boss_fid = ' . $i_boss_id;
        }

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function resetSelfAssessementReminders()
    {
        $sql = 'UPDATE
                    threesixty_invitations ti
                SET
                    ID_TSIM1 = NULL,
                    senddate_reminder1 = NULL,
                    ID_TSIM2 = NULL,
                    senddate_reminder2 = NULL,
                    ID_TSIM_LOS = NULL,
                    senddate_LOS = NULL
                WHERE
                    customer_id = ' . CUSTOMER_ID;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }

    static function deleteUnusedInvitationMessages()
    {
        // todo
    }

    static function findRemindersBySelfAssessementInvitations()
    {
        $non_admin_join  = ' ';
        $non_admin_where = ' ';
        if (USER_LEVEL != UserLevelValue::CUSTOMER_ADMIN) {
            $non_admin_join = '
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        INNER JOIN users_department ud
                            ON ud.ID_DEPT = d.ID_DEPT
                        INNER JOIN users u
                            ON u.user_id = ud.ID_UID
                        ';
            $non_admin_where = ' AND u.user_id = ' . USER_ID ;
        }

        $sql = 'SELECT
                    tim.*,
                    SUM(CASE WHEN tim.ID_TSIM = ti.ID_TSIM1
                             THEN 1
                             ELSE 0
                             END) as reminder1_count,
                    SUM(CASE WHEN tim.ID_TSIM = ti.ID_TSIM1
                             THEN CASE WHEN ti.senddate_reminder1 is not null
                                       THEN 1
                                       ELSE 0
                                       END
                             ELSE 0
                             END) as reminder1_send_count,
                    SUM(CASE WHEN tim.ID_TSIM = ti.ID_TSIM2
                             THEN 1
                             ELSE 0
                             END) as reminder2_count,
                    SUM(CASE WHEN tim.ID_TSIM = ti.ID_TSIM2
                             THEN CASE WHEN ti.senddate_reminder2 is not null
                                       THEN 1
                                       ELSE 0
                                       END
                             ELSE 0
                             END) as reminder2_send_count,
                    SUM(CASE WHEN tim.ID_TSIM = ti.ID_TSIM_LOS
                             THEN 1
                             ELSE 0
                             END) as los_count,
                    SUM(CASE WHEN tim.ID_TSIM = ti.ID_TSIM_LOS
                             THEN CASE WHEN ti.senddate_LOS is not null
                                       THEN 1
                                       ELSE 0
                                       END
                             ELSE 0
                             END) as los_send_count
                FROM
                    threesixty_invitations ti
                    INNER JOIN employees e
                        ON ti.ID_E = e.ID_E ' .
                    $non_admin_join . '
                    INNER JOIN threesixty_invitations_messages tim
                        ON ti.ID_TSIM1 = tim.ID_TSIM
                           OR ti.ID_TSIM2 = tim.ID_TSIM
                           OR ti.ID_TSIM_LOS = tim.ID_TSIM
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID .
                    $non_admin_where . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                GROUP BY
                    tim.ID_TSIM
                ORDER BY
                    tim.message_date desc,
                    tim.ID_TSIM desc';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function findSelfAssessmentInvitationsByBoss()
    {
        $non_admin_join  = ' ';
        $non_admin_where = ' ';
        if (USER_LEVEL != UserLevelValue::CUSTOMER_ADMIN) {
            $non_admin_join = '
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        INNER JOIN users_department ud
                            ON ud.ID_DEPT = d.ID_DEPT
                        INNER JOIN users u
                            ON u.user_id = ud.ID_UID
                        ';
            $non_admin_where = ' AND u.user_id = ' . USER_ID ;
        }

        $sql = 'SELECT
                    e.*,
                    b.firstname as boss_firstname,
                    b.lastname  as boss_lastname,
                    ti.*,
                    CASE WHEN DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                         THEN "actueel"
                         ELSE CASE WHEN ti.senddate is NULL
                                   THEN "niet verzonden"
                                   ELSE "verlopen"
                              END
                    END
                    as deprecated,
                    CASE WHEN threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                         THEN CASE WHEN threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . '
                                   THEN ", afgerond"
                                   ELSE ""
                              END
                         ELSE CASE WHEN threesixty_scores_status = ' . AssessmentInvitationStatusValue::HISTORICAL . '+' . AssessmentInvitationStatusValue::CLOSED . '
                                   THEN ", oud afgerond"
                                   ELSE ", oud"
                              END
                    END as completed_deprecated,
                    CASE WHEN completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                         THEN "ja"
                         ELSE CASE WHEN completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                                   THEN "nee"
                                   ELSE CASE WHEN completed = ' . AssessmentInvitationCompletedValue::RESULT_DELETED . '
                                             THEN "verwijderd"
                                             ELSE "anders"
                                         END
                              END
                         END
                    as completed_status,
                    count(te.ID_TSE) as evaluations_scores,
                    CASE WHEN ti.date_sentback
                         THEN ""
                         ELSE ti.date_sentback
                    END as evaluations_date,
                    tm_i.message_type as invitation_message_type,
                    tm_i.message_template as invitation_message,
                    tm_r1.message_type as reminder1_message_type,
                    tm_r1.message_template as reminder1_message,
                    tm_r2.message_type as reminder2_message_type,
                    tm_r2.message_template as reminder2_message,
                    tm_los.message_type as los_message_type,
                    tm_los.message_template as los_message
                FROM
                    employees e ' .
                    $non_admin_join . '
                    LEFT JOIN employees b
                        ON b.id_e = e.boss_fid
                    INNER JOIN threesixty_invitations ti
                        ON ti.id_e = e.id_e
                    LEFT JOIN threesixty_evaluation te
                        ON ti.hash_id = te.hash_id
                        AND te.id_e = ti.id_e
                    LEFT JOIN threesixty_invitations_messages tm_i
                        ON ti.ID_TSIM = tm_i.ID_TSIM
                    LEFT JOIN threesixty_invitations_messages tm_r1
                        ON ti.ID_TSIM1 = tm_r1.ID_TSIM
                    LEFT JOIN threesixty_invitations_messages tm_r2
                        ON ti.ID_TSIM2 = tm_r2.ID_TSIM
                    LEFT JOIN threesixty_invitations_messages tm_los
                        ON ti.ID_TSIM_LOS = tm_los.ID_TSIM
                WHERE
                    e.customer_id = ' . CUSTOMER_ID .
                    $non_admin_where . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                GROUP BY
                    ti.hash_id
                ORDER BY
                    boss_lastname,
                    boss_firstname,
                    e.lastname,
                    e.firstname,
                    CASE WHEN invitation_date = 0
                         THEN senddate
                         ELSE invitation_date
                    END DESC,
                    ID_TSIM DESC';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

} // class

?>
