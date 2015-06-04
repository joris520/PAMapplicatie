<?php

/**
 * Description of FinalScoreReportQueries
 *
 * @author ben.dokter
 */

class FinalScoreReportQueries
{
    //const ID_FIELD = 'ID_E';

    static function getFinalScoreCount( $s_allowedEmployeeIds,
                                        $dt_periodStart,
                                        $dt_periodEnd)
    {

        $sql = 'SELECT
                    total_score,
                    count(e.ID_E) as employee_count
                FROM
                    employees e
                    LEFT JOIN employee_assessment_final_result eafr
                        ON e.ID_E = eafr.ID_E
                        AND eafr.ID_EAFR    =   (   SELECT
                                                        MAX(maxid_eafr.ID_EAFR)
                                                    FROM
                                                        employee_assessment_final_result maxid_eafr
                                                    WHERE
                                                        maxid_eafr.customer_id = e.customer_id
                                                        AND maxid_eafr.ID_E    = e.ID_E
                                                        AND DATEDIFF(maxid_eafr.saved_datetime, "' . $dt_periodEnd . '")  < 0
                                                        AND DATEDIFF(maxid_eafr.saved_datetime, "' . $dt_periodStart . '") >= 0
                                                )
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
                GROUP BY
                    eafr.total_score';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getFinalScoreEmployeesWithScore($scoreId,
                                                    $s_allowedEmployeeIds,
                                                    $dt_periodStart,
                                                    $dt_periodEnd)
    {
        $sql_scoreFilter = is_null($scoreId) ? ' AND eafr.total_score IS NULL ' : ' AND eafr.total_score = ' . $scoreId;

        $sql = 'SELECT
                    e.ID_E
                FROM
                    employees e
                    LEFT JOIN employee_assessment_final_result eafr
                        ON e.ID_E = eafr.ID_E
                        AND eafr.ID_EAFR    =   (   SELECT
                                                        MAX(maxid_eafr.ID_EAFR)
                                                    FROM
                                                        employee_assessment_final_result maxid_eafr
                                                    WHERE
                                                        maxid_eafr.customer_id = e.customer_id
                                                        AND maxid_eafr.ID_E    = e.ID_E
                                                        AND DATEDIFF(maxid_eafr.saved_datetime, "' . $dt_periodEnd . '")  < 0
                                                        AND DATEDIFF(maxid_eafr.saved_datetime, "' . $dt_periodStart . '") >= 0
                                                )
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
                    ' . $sql_scoreFilter ;

        return BaseQueries::performSelectQuery($sql);

    }
}

?>
