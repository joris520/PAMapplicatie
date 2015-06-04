<?php

/**
 * Description of AssessmentProcessQueries
 *
 * @author ben.dokter
 */
class AssessmentProcessQueries
{

    // alleen van de Finalized scores
    static function getSumScoresInPeriod(   $s_selectedEmployeeIds,
                                            $dt_periodStart,
                                            $dt_periodEnd)
    {
        $minDateFilter      = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;
        $minDateFilterEa    = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(ea_maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    ID_E,
                    SUM(s.score_spread) as normalized_manager_score
                FROM
                    employee_competence_score main
                    INNER JOIN scale s
                        ON s.scale_name = main.score
                            AND main.customer_id = s.customer_id
                WHERE
                    main.customer_id = ' . CUSTOMER_ID . '
                    AND main.ID_ECS =   (   SELECT
                                                MAX(maxid.ID_ECS)
                                            FROM
                                                employee_competence_score maxid
                                            WHERE
                                                maxid.customer_id = main.customer_id
                                                AND maxid.ID_E = main.ID_E
                                                AND maxid.ID_KSP = main.ID_KSP
                                                AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                ' . $minDateFilter . '
                                        )
                    AND main.ID_E IN    (' . $s_selectedEmployeeIds . ')
                    AND main.ID_KSP IN  (   SELECT
                                                DISTINCT(ID_KSP)
                                            FROM
                                                function_points
                                            WHERE
                                                ID_F IN (       SELECT
                                                                    ID_FID AS function_id
                                                                FROM
                                                                    employees e
                                                                WHERE
                                                                    e.ID_E = main.ID_E
                                                            UNION
                                                                SELECT
                                                                    ID_F AS function_id
                                                                FROM
                                                                    employees_additional_functions eaf
                                                                WHERE
                                                                    eaf.ID_E = main.ID_E
                                                        )
                                        )
                    AND ' . ScoreStatusValue::FINALIZED . ' =   (   SELECT
                                                                        score_status
                                                                    FROM
                                                                        employee_assessment ea_main
                                                                    WHERE
                                                                        ea_main.ID_EA = (  SELECT
                                                                                                MAX(ea_maxid.ID_EA)
                                                                                            FROM
                                                                                                employee_assessment ea_maxid
                                                                                            WHERE
                                                                                                ea_maxid.customer_id = ea_main.customer_id
                                                                                                AND ea_maxid.ID_E = main.ID_E
                                                                                                AND DATEDIFF(ea_maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                                                                ' . $minDateFilterEa . '
                                                                                        )
                                                                )
                GROUP BY
                    main.ID_E';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getSelfAssessmentSumScoresInPeriod( $s_selectedEmployeeIds,
                                                        $dt_periodStart,
                                                        $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    SUM(score_spread) as normalized_score
                FROM
                    threesixty_evaluation te_sum
                    INNER JOIN scale s
                        ON te_sum.threesixty_score = s.scale_name
                        AND te_sum.customer_id = s.customer_id
                WHERE
                    te_sum.customer_id = ' . CUSTOMER_ID . '
                    AND te_sum.ID_E = in (' . $s_selectedEmployeeIds . ')
                    AND te_sum.hash_id = (  SELECT
                                                hash_id
                                            FROM
                                                threesixty_invitations ti_main
                                            WHERE
                                                ti_main.customer_id = te_sum.customer_id
                                                AND ti_main.ID_E = te_sum.ID_E
                                                AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                                                AND ti_main.threesixty_scores_status = ' . AssessmentInvitationStatusValue::CLOSED . '
                                                AND ti_main.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
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

    static function fillSelfAssessmentDiffScoresByHashIdInPeriod(   $s_selectedEmployeeIds,
                                                                    $s_selectedInvitationHashIds,
                                                                    $dt_periodStart,
                                                                    $dt_periodEnd,
                                                                    $i_invitationProcessStatus)
    {
        $sqlMinDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(ecs_maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'UPDATE
                    threesixty_evaluation te
                    INNER JOIN threesixty_invitations ti
                        ON ti.hash_id = te.hash_id
                            AND ti.id_e = te.ID_E
                    INNER JOIN scale te_s
                        ON te_s.scale_name = te.threesixty_score
                            AND te_s.customer_id = te.customer_id
                SET
                    te.threesixty_score_diff = ABS(     (   te_s.score_spread  )
                                                        -
                                                        (   SELECT
                                                                ecs_s.score_spread as normalized_manager_score
                                                            FROM
                                                                employee_competence_score ecs_main
                                                                INNER JOIN scale ecs_s
                                                                    ON ecs_s.scale_name = ecs_main.score
                                                                        AND ecs_s.customer_id = ecs_main.customer_id
                                                            WHERE
                                                                ecs_main.customer_id = te.customer_id
                                                                AND ecs_main.ID_ECS = ( SELECT
                                                                                            MAX(ecs_maxid.ID_ECS)
                                                                                        FROM
                                                                                            employee_competence_score ecs_maxid
                                                                                        WHERE
                                                                                            ecs_maxid.customer_id = ecs_main.customer_id
                                                                                            AND ecs_maxid.ID_E = ecs_main.ID_E
                                                                                            AND ecs_maxid.ID_KSP = ecs_main.ID_KSP
                                                                                            AND DATEDIFF(ecs_maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                                                            ' . $sqlMinDateFilter . '
                                                                                    )

                                                                AND ecs_main.ID_E = te.ID_E
                                                                AND ecs_main.ID_KSP = te.ID_KSP

                                                        )
                                                  ),
                    te.threesixty_score_diff_database_datetime = NOW()
                WHERE
                    te.customer_id = ' . CUSTOMER_ID . '
                    AND te.ID_E     IN (' . $s_selectedEmployeeIds . ')
                    AND ti.hash_id  IN ("' . $s_selectedInvitationHashIds . '")
                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                    AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND ti.threesixty_scores_status = ' . $i_invitationProcessStatus;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function fillSelfAssessmentDiffScoresInPeriod(   $s_selectedEmployeeIds,
                                                            $dt_periodStart,
                                                            $dt_periodEnd,
                                                            $i_invitationProcessStatus)
    {
        $minDateFilterEcs = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(ecs_maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;
        $minDateFilterTi  = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(ti_maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'UPDATE
                    threesixty_evaluation te
                    INNER JOIN scale te_s
                        ON te_s.scale_name = te.threesixty_score
                            AND te_s.customer_id = te.customer_id
                SET
                    te.threesixty_score_diff = ABS(     (   te_s.score_spread  )
                                                        -
                                                        (   SELECT
                                                                ecs_s.score_spread as normalized_manager_score
                                                            FROM
                                                                employee_competence_score ecs_main
                                                                INNER JOIN scale ecs_s
                                                                    ON ecs_s.scale_name = ecs_main.score
                                                                        AND ecs_s.customer_id = ecs_main.customer_id
                                                            WHERE
                                                                ecs_main.customer_id = te.customer_id
                                                                AND ecs_main.ID_ECS = ( SELECT
                                                                                            MAX(ecs_maxid.ID_ECS)
                                                                                        FROM
                                                                                            employee_competence_score ecs_maxid
                                                                                        WHERE
                                                                                            ecs_maxid.customer_id = ecs_main.customer_id
                                                                                            AND ecs_maxid.ID_E = ecs_main.ID_E
                                                                                            AND ecs_maxid.ID_KSP = ecs_main.ID_KSP
                                                                                            AND DATEDIFF(ecs_maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                                                            ' . $minDateFilterEcs . '
                                                                                    )

                                                                AND ecs_main.ID_E = te.ID_E
                                                                AND ecs_main.ID_KSP = te.ID_KSP

                                                        )
                                                  )
                    -- ,
                    -- te.modified_by_user = "' . $modified_by_user . '",
                    -- te.modified_datetime = "' . $modified_datetime . '"
                WHERE
                    te.customer_id = ' . CUSTOMER_ID . '
                    AND te.ID_E in (' . $s_selectedEmployeeIds . ')
                    AND te.hash_id = (  SELECT
                                            hash_id
                                        FROM
                                            threesixty_invitations ti_main
                                        WHERE
                                            ti_main.customer_id = te.customer_id
                                            AND ti_main.ID_E = te.ID_E
                                            AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                                            AND ti_main.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                                            AND ti_main.threesixty_scores_status = ' . $i_invitationProcessStatus . '
                                            AND ti_main.invitation_date =   (   SELECT
                                                                                    MAX(ti_maxid.invitation_date)
                                                                                FROM
                                                                                    threesixty_invitations ti_maxid
                                                                                WHERE
                                                                                    ti_maxid.customer_id = ti_main.customer_id
                                                                                    AND ti_maxid.ID_E = ti_main.ID_E
                                                                                    AND ti_maxid.is_self_evaluation = ti_main.is_self_evaluation
                                                                                    AND DATEDIFF(ti_maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                                                    ' . $minDateFilterTi . '
                                                                            )
                                    )';
//die($sql);
        return BaseQueries::performUpdateQuery($sql);
    }

//    // Dit zou de "logische" functie zijn om de diffscores op te tellen en weer op te slaan in de threesixty_invitations
//    // helaas vind de update het niet goed als de update tabel ook in de subselect (ti_main.invitation_date) staat...
//    // oplossing: de somscore ophalen bij het invitationValueObject en opslaan in de employee_process tabel
//    static function fillSelfAssessmentSumDiffScores($s_selectedEmployeeIds, $dt_periodStart, $dt_periodEnd, $i_invitationProcessStatus)
//    {
//        $minDateFilterTi  = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(ti_maxid.invitation_date, "' . $dt_periodStart . '") > 0' ;
//
//        $sql = 'UPDATE
//                    threesixty_invitations ti_main
//                SET
//                    ti_main.threesixty_score_diff_sum = (   SELECT
//                                                        SUM(te.threesixty_score)
//                                                    FROM
//                                                        threesixty_evaluation te
//                                                    WHERE
//                                                        te.customer_id = ti_main.customer_id
//                                                        AND te.hash_id = ti_main.hash_id
//                                                )
//                WHERE
//                    ti_main.customer_id =  ' . CUSTOMER_ID . '
//                    AND ti_main.ID_E in (' . $s_selectedEmployeeIds . ')
//                    AND ti_main.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
//                    AND ti_main.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
//                    AND ti_main.threesixty_scores_status = ' . $i_invitationProcessStatus . '
//                    AND ti_main.invitation_date =   (   SELECT
//                                                            MAX(ti_maxid.invitation_date)
//                                                        FROM
//                                                            threesixty_invitations ti_maxid
//                                                        WHERE
//                                                            ti_maxid.customer_id = ' . CUSTOMER_ID . '
//                                                            AND ti_maxid.ID_E = ti_main.ID_E
//                                                            AND ti_maxid.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
//                                                            AND DATEDIFF(ti_maxid.invitation_date, "' . $dt_periodEnd . '") <= 0
//                                                            ' . $minDateFilterTi . '
//                                                    )';
//
//        die($sql);
//        return BaseQueries::performUpdateQuery($sql);
//    }
}

?>
