<?php

/**
 * Description of EmployeeSelfAssessmentInvitationQueries
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/assessmentInvitation/EmployeeAssessmentInvitationQueries.class.php');

class EmployeeSelfAssessmentInvitationQueries extends EmployeeAssessmentInvitationQueries
{
    const ID_FIELD = 'hash_id';
    const ID_EMPLOYEE_FIELD = 'ID_E';


    // $si_employeeId kan 1 id of een comma seperated string van id's zijn
    static function getInvitationInPeriod(  $si_employeeIds,
                                            $dt_periodStart,
                                            $dt_periodEnd,
                                            $filterStatus = NULL,
                                            $calculateSumDiff = false)
    {
        $sqlMinDateFilter = $dt_periodStart == NULL ? ''                        : ' AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;
        $sqlStatusFilter  = empty($filterStatus)    ? ''                        : ' AND ti_main.threesixty_scores_status = ' . $filterStatus;
        $sqlSumDiffSelect = !$calculateSumDiff      ? 'NULL as sum_score_diff'  : ' (   SELECT
                                                                                            SUM(te_sum.threesixty_score_diff)
                                                                                        FROM
                                                                                            threesixty_evaluation te_sum
                                                                                        WHERE
                                                                                            te_sum.customer_id  = ti_main.customer_id
                                                                                            AND te_sum.hash_id  = ti_main.hash_id
                                                                                            AND te_sum.ID_E     = ti_main.ID_E
                                                                                    ) as sum_score_diff';

        $sql = 'SELECT
                    ti_main.*,
                    e.ID_E,
                    ' . $sqlSumDiffSelect . '
                FROM
                    threesixty_invitations ti_main
                    INNER JOIN employees e
                        ON e.ID_E = ti_main.id_e
                WHERE
                    ti_main.customer_id = ' . CUSTOMER_ID . '
                    AND ti_main.id_e IN (' . $si_employeeIds . ')
                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.id_e = ti_main.id_e
                                                            AND maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $sqlMinDateFilter . '
                                                    )
                    ' . $sqlStatusFilter . '
                ORDER BY
                    e.employee';

        return BaseQueries::performSelectQuery($sql);
    }

    static function countInvitationsInPeriod(   $si_employeeIds,
                                                $dt_periodStart,
                                                $dt_periodEnd,
                                                $filterStatus = NULL)
    {
        $sqlMinDateFilter = $dt_periodStart == NULL ? ''    : ' AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;
        $sqlStatusFilter  = empty($filterStatus)    ? ''    : ' AND ti_main.threesixty_scores_status = ' . $filterStatus;

        $sql = 'SELECT
                    count(*) as counted
                FROM
                    threesixty_invitations ti_main
                WHERE
                    ti_main.customer_id = ' . CUSTOMER_ID . '
                    AND ti_main.id_e IN (' . $si_employeeIds . ')
                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.id_e = ti_main.id_e
                                                            AND maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $sqlMinDateFilter . '
                                                    )
                    ' . $sqlStatusFilter;

        return BaseQueries::performSelectQuery($sql);
    }

    // alle vorige, ook over periodegrenzen heen
    // de history niet de datum aan laten passen, dit zou toch gelijk zijn aan de nieuwe uitnodigingsdatum van het volgende record
    static function deprecateInvitations($i_employeeId)
    {
        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    threesixty_scores_status = threesixty_scores_status + ' . AssessmentInvitationStatusValue::HISTORICAL . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_e = ' . $i_employeeId . '
                    AND is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL;

        return BaseQueries::performUpdateQuery($sql);
    }

    // todo: ombouwen naar hash
    static function updateStatusInvitationsInPeriod(    $s_selectedEmployeeIds,
                                                        $i_currentInvitationStatus,
                                                        $i_newInvitationStatus,
                                                        $dt_periodStart,
                                                        $dt_periodEnd)
    {
        $sqlMinDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(invitation_date, "' . $dt_periodStart . '") >= 0' ;

        // TODO: status_modified_date toevoegen
        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    threesixty_scores_status = ' . $i_newInvitationStatus . ',
                    threesixty_scores_status_database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_e IN (' . $s_selectedEmployeeIds . ')
                    AND is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND threesixty_scores_status = ' . $i_currentInvitationStatus . '
                    AND DATEDIFF(invitation_date, "' . $dt_periodEnd . '") < 0
                    ' . $sqlMinDateFilter;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateStatusInvitationForHashIds(   $s_selectedInvitationHashIds,
                                                        $i_currentInvitationStatus,
                                                        $i_newInvitationStatus)
    {

        // TODO: status_modified_date toevoegen
        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    threesixty_scores_status = ' . $i_newInvitationStatus . ',
                    threesixty_scores_status_database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND hash_id IN ("' . $s_selectedInvitationHashIds . '")
                    AND is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                    AND threesixty_scores_status = ' . $i_currentInvitationStatus;

        return BaseQueries::performUpdateQuery($sql);
    }

    // TODO: wanneer en wie ook vastleggen ?
    static function markResendInvitation($i_employeeId, $s_invitationHash)
    {
        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    senddate = NULL
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_e    = ' . $i_employeeId . '
                    AND hash_id = "' . $s_invitationHash . '"
                    AND is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function insertInvitation(   $s_invitationHashId,
                                        $i_employeeId,
                                        $i_personDataId,
                                        $i_functionId,
                                        $i_invitationMessageId,
                                        $s_fromEmail,
                                        $s_fromName,
                                        $s_competenceIds,
                                        $i_completedStatus,
                                        $i_invitationStatus)
    {
            $sql = 'INSERT INTO
                        threesixty_invitations
                        (   hash_id,
                            invitation_date,
                            senddate,
                            id_pd,
                            customer_id,
                            id_e,
                            id_f,
                            is_self_evaluation,
                            ID_TSIM,
                            email_from,
                            email_name,
                            competences,
                            completed,
                            threesixty_scores_status,
                            threesixty_scores_status_database_datetime,
                            modified_by_user,
                            modified_datetime
                        ) VALUES (
                            "' . $s_invitationHashId . '",
                            NOW(),
                            NOW(),
                            ' . $i_personDataId . ',
                            ' . CUSTOMER_ID . ',
                            ' . $i_employeeId . ',
                            ' . $i_functionId . ',
                            ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . ',
                            ' . $i_invitationMessageId . ',
                            "' . mysql_real_escape_string($s_fromEmail) . '",
                            "' . mysql_real_escape_string($s_fromName) . '",
                            "' . $s_competenceIds . '",
                             ' . $i_completedStatus . ',
                             ' . $i_invitationStatus . ',
                            NOW(),
                            "' . USER. '",
                            NOW()
                        )';
        return BaseQueries::performInsertQuery($sql);
    }


    // TODO: samenvoegen in 1 functie
    static function insertReminder1($s_invitationHashId,
                                    $i_employeeId,
                                    $i_invitationMessageId)
    {

        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    ID_TSIM1 = ' . $i_invitationMessageId . ',
                    senddate_reminder1 = NULL,
                    modified_by_user = "' . USER. '",
                    modified_datetime = NOW()
                WHERE
                    customer_id =  ' . CUSTOMER_ID . '
                    and hash_id = "' . $s_invitationHashId . '"
                    AND id_e    =  ' . $i_employeeId . '
                    AND senddate IS NOT NULL
                    AND completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function insertReminder2($s_invitationHash,
                                    $i_employeeId,
                                    $i_invitationMessageId)
    {

        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    ID_TSIM2 = ' . $i_invitationMessageId . ',
                    senddate_reminder2 = NULL,
                    modified_by_user = "' . USER. '",
                    modified_datetime = NOW()
                WHERE
                    customer_id =  ' . CUSTOMER_ID . '
                    and hash_id = "' . $s_invitationHash . '"
                    AND id_e    =  ' . $i_employeeId . '
                    AND senddate IS NOT NULL
                    AND completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }
}

?>
