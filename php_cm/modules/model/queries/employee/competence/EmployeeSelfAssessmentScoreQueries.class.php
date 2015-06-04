<?php

/**
 * Description of EmployeeSelfAssessmentScoreQueries
 *
 * @author ben.dokter
 */

class EmployeeSelfAssessmentScoreQueries
{
    const ID_FIELD = 'ID_TSE';

    static function getScoreInPeriod($i_employeeId, $i_competenceId, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(ti.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        // letop, geen controle meer op:  -- AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '

        $sql = 'SELECT
                    te_main.*,
                    ti_main.invitation_date,
                    ti_main.senddate,
                    ti_main.completed
                FROM
                    threesixty_evaluation te_main
                    INNER JOIN threesixty_invitations ti_main
                        ON ti_main.hash_id = te_main.hash_id
                WHERE
                    te_main.ID_TSE = ( SELECT
                                            MAX(maxid.ID_TSE)
                                        FROM
                                            threesixty_evaluation maxid
                                            INNER JOIN threesixty_invitations ti
                                                ON ti.hash_id = maxid.hash_id
                                        WHERE
                                            maxid.customer_id = ' . CUSTOMER_ID . '
                                            AND maxid.ID_E = ' . $i_employeeId . '
                                            AND maxid.ID_KSP = '. $i_competenceId . '
                                            AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                                            AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                                            AND DATEDIFF(ti.invitation_date, "' . $dt_periodEnd . '") < 0
                                            ' . $minDateFilter . '
                                    )';


        return BaseQueries::performSelectQuery($sql);
    }

}

?>
