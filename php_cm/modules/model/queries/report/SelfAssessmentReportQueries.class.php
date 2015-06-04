<?php

/**
 * Description of SelfAssessmentReportQueries
 *
 * @author ben.dokter
 */

class SelfAssessmentReportQueries
{
    const ID_FIELD = 'ID_E';

    static function getInvitationReportInPeriod($s_allowedEmployeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    ti_main.*,
                    e.firstname,
                    e.lastname,
                    e.ID_E
                FROM
                    threesixty_invitations ti_main
                    INNER JOIN employees e
                        ON ti_main.ID_E = e.ID_E
                WHERE
                    ti_main.customer_id = ' . CUSTOMER_ID . '
                    AND ti_main.ID_E in (' . $s_allowedEmployeeIds . ')
                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND ti_main.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.ID_E = ti_main.ID_E
                                                            AND maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $minDateFilter . '
                                                    )
                ORDER BY
                    e.lastname,
                    e.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getInvitationCountInPeriod($s_allowedEmployeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    count(e.ID_E) as invitation_count,
                    SUM(CASE WHEN ti_main.senddate IS NOT NULL
                             THEN 1
                             ELSE 0
                        END) as sent_count
                FROM
                    threesixty_invitations ti_main
                    INNER JOIN employees e
                        ON ti_main.ID_E = e.ID_E
                WHERE
                    ti_main.customer_id = ' . CUSTOMER_ID . '
                    AND ti_main.ID_E in (' . $s_allowedEmployeeIds . ')
                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND ti_main.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.ID_E = ti_main.ID_E
                                                            AND maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $minDateFilter . '
                                                    )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getInvitationsNotCompletedCountInPeriod($s_allowedEmployeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    count(*) as not_completed_count
                FROM
                    threesixty_invitations ti_main
                    INNER JOIN employees e
                        ON ti_main.ID_E = e.ID_E
                WHERE
                    ti_main.customer_id = ' . CUSTOMER_ID . '
                    AND ti_main.ID_E in (' . $s_allowedEmployeeIds . ')
                    AND ti_main.completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND ti_main.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.ID_E = ti_main.ID_E
                                                            AND maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $minDateFilter . '
                                                    )
                ';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getInvitationsNotCompletedInPeriod($s_allowedEmployeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    ti_main.*,
                    e.firstname,
                    e.lastname,
                    e.ID_E
                FROM
                    threesixty_invitations ti_main
                    INNER JOIN employees e
                        ON ti_main.ID_E = e.ID_E
                WHERE
                    ti_main.customer_id = ' . CUSTOMER_ID . '
                    AND ti_main.ID_E in (' . $s_allowedEmployeeIds . ')
                    AND ti_main.completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND ti_main.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.ID_E = ti_main.ID_E
                                                            AND maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $minDateFilter . '
                                                    )
                ORDER BY
                    e.lastname,
                    e.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getEmployeeInvitations($i_employeeId)
    {
        $sql = 'SELECT
                    ti.*,
                    e.firstname,
                    e.lastname,
                    e.ID_E
                FROM
                    threesixty_invitations ti
                    INNER JOIN employees e
                        ON ti.ID_E = e.ID_E
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND ti.ID_E  = ' . $i_employeeId . '
                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                ORDER BY
                    ti.invitation_date DESC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getEmployeeInvitation($i_employeeId, $s_invitationHash)
    {

        $sql = 'SELECT
                    ti.*,
                    e.firstname,
                    e.lastname,
                    e.ID_E,
                    count(te.ID_TSE) as invitation_score_count,
                    tm_i.message_type as message_type_invitation,
                    tm_i.message_subject as message_subject,
                    tm_i.message_template as message_invitation,
                    tm_r1.message_type as message_type_reminder1,
                    tm_r1.message_subject as message_subject_reminder1,
                    tm_r1.message_template as message_reminder1,
                    tm_r2.message_subject as message_subject_reminder2,
                    tm_r2.message_type as message_type_reminder2,
                    tm_r2.message_template as message_reminder2
                FROM
                    threesixty_invitations ti
                    INNER JOIN employees e
                        ON ti.ID_E = e.ID_E
                    LEFT JOIN threesixty_evaluation te
                        ON ti.hash_id = te.hash_id
                        AND te.id_e = ti.id_e
                    LEFT JOIN threesixty_invitations_messages tm_i
                        ON ti.ID_TSIM = tm_i.ID_TSIM
                    LEFT JOIN threesixty_invitations_messages tm_r1
                        ON ti.ID_TSIM1 = tm_r1.ID_TSIM
                    LEFT JOIN threesixty_invitations_messages tm_r2
                        ON ti.ID_TSIM2 = tm_r2.ID_TSIM
                WHERE
                    ti.customer_id = ' . CUSTOMER_ID . '
                    AND ti.ID_E = ' . $i_employeeId . '
                    AND ti.hash_id = "' . mysql_real_escape_string($s_invitationHash) . '"
                GROUP BY
                    ti.hash_id
                ORDER BY
                    e.lastname,
                    e.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
