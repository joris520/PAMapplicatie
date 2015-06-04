<?php

/**
 * Description of AssessmentReportQueries
 *
 * @author ben.dokter
 */

class AssessmentReportQueries
{

    static function getAssessmentNotCompletedCountInPeriod( $si_employeeIds,
                                                            $dt_periodStart,
                                                            $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    count(*) as not_completed_count
                FROM
                    employees e
                    LEFT JOIN employee_assessment main
                        ON e.ID_E = main.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E IN ( ' . $si_employeeIds . ')
                    AND (main.score_status <> ' . ScoreStatusValue::FINALIZED . '
                         OR main.score_status IS NULL)
                    AND (   main.ID_EA =    (   SELECT
                                                    maxid.ID_EA
                                                FROM
                                                    employee_assessment maxid
                                                WHERE
                                                    maxid.customer_id = e.customer_id
                                                    AND maxid.ID_E = e.ID_E
                                                    AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                    ' . $minDateFilter . '
                                                ORDER BY
                                                    maxid.saved_datetime DESC
                                                LIMIT 1
                                            )
                            OR main.ID_EA IS NULL
                        )';

        return BaseQueries::performSelectQuery($sql);
    }
}
?>
