<?php
/**
 * Description of HistoryQueries
 *
 * @author wouter.storteboom
 */

require_once('gino/BaseQueries.class.php');

class HistoryQueries
{
    static function historicalTotalScores($id_ehpd)
    {
        $sql = 'SELECT
                    total_score,
                    behaviour_score,
                    results_score,
                    total_score_comment,
                    behaviour_score_comment,
                    results_score_comment
                FROM
                    employees_history_total_scores ehts
                WHERE
                    ehts.customer_id = ' . CUSTOMER_ID . '
                    AND id_ehpd = ' . $id_ehpd;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function addHistoricalTotalScores($id_ehpd,
                                             $total_score,
                                             $behaviour_score,
                                             $results_score,
                                             $total_score_comment,
                                             $behaviour_score_comment,
                                             $results_score_comment)
    {
        $sql = 'INSERT INTO
                    employees_history_total_scores
                    ( customer_id,
                      ID_EHPD,
                      total_score,
                      behaviour_score,
                      results_score,
                      total_score_comment,
                      behaviour_score_comment,
                      results_score_comment
                    ) VALUES (
                       ' . CUSTOMER_ID . ',
                       ' . $id_ehpd . ',
                       ' . $total_score . ',
                       ' . $behaviour_score . ',
                       ' . $results_score . ',
                      "' . mysql_real_escape_string($total_score_comment) . '",
                      "' . mysql_real_escape_string($behaviour_score_comment) . '",
                      "' . mysql_real_escape_string($results_score_comment) . '"
                    )';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function lastHistorypoint($i_employee_id)
    {
        $sql = 'SELECT
                    eh_date
                FROM
                    employees_history_points_date
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id . '
                ORDER BY
                    ID_EHPD DESC
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getHistoryEmployeeIds()
    {
        $sql = 'SELECT
                    DISTINCT(ID_E)
                FROM
                    employees_history_points_date
                WHERE
                    customer_id = ' . CUSTOMER_ID;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }
}
?>
