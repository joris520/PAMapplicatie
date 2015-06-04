<?php

/**
 * Description of SelfAssessmentInvitationFilterQueries
 *
 * @author ben.dokter
 */
class SelfAssessmentInvitationFilterQueries
{

    const ID_FIELD = 'ID_E';

    // haal alle medewerkers op die in de periode WEL meedoen aan de zelfevaluatie
    static function getEmployeesWithInvitationInPeriod($s_allowedEmployeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    e.ID_E,
                    e.firstname,
                    e.lastname,
                    e.employee
                FROM
                FROM
                    employees e
                    INNER JOIN threesixty_invitations ti_main
                        ON ti_main.id_e = e.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E in (' . $s_allowedEmployeeIds . ')
                    AND ti_main.invitation_date =   (   SELECT
                                                            MAX(maxid.invitation_date)
                                                        FROM
                                                            threesixty_invitations maxid
                                                        WHERE
                                                            maxid.customer_id = ti_main.customer_id
                                                            AND maxid.id_e = ti_main.id_e
                                                            AND maxid.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                                                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                                                            ' . $minDateFilter . '
                                                    )
                GROUP BY
                    ID_E
                ORDER BY
                    e.employee';

        return BaseQueries::performSelectQuery($sql);
    }

    // haal alle medewerkers op die in de periode NIET meedoen aan de zelfevaluatie
    static function getEmployeesWithoutInvitationInPeriod($s_allowedEmployeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.invitation_date, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    e.ID_E,
                    e.firstname,
                    e.lastname,
                    e.employee,
                    (   SELECT
                            COUNT(maxid.invitation_date)
                        FROM
                            threesixty_invitations maxid
                        WHERE
                            maxid.customer_id = e.customer_id
                            AND maxid.ID_E = e.ID_E
                            AND maxid.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION. '
                            AND DATEDIFF(maxid.invitation_date, "' . $dt_periodEnd . '") < 0
                            ' . $minDateFilter . '
                    ) as invitations_in_period_count
                FROM
                    employees e
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E in (' . $s_allowedEmployeeIds . ')
                GROUP BY
                    e.ID_E
                HAVING
                    invitations_in_period_count = 0
                ORDER BY
                    e.employee';

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
