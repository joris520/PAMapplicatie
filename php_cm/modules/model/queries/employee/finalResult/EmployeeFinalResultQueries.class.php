<?php

/**
 * Description of EmployeeFinalResultQueries
 *
 * @author ben.dokter
 */
class EmployeeFinalResultQueries
{
    const ID_FIELD = 'ID_EAFR';

    static function getFinalResultInPeriod($i_employeeId, $dt_periodStart, $dt_periodEnd)
    {
        $maxDateFilter = empty($dt_periodEnd)   ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd   . '") <  0' ;
        $minDateFilter = empty($dt_periodStart) ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_final_result main
                WHERE
                    main.ID_EAFR = (    SELECT
                                            MAX(maxid.ID_EAFR)
                                        FROM
                                            employee_assessment_final_result maxid
                                        WHERE
                                            maxid.customer_id = ' . CUSTOMER_ID . '
                                            AND maxid.ID_E = ' . $i_employeeId . '
                                            ' . $maxDateFilter . '
                                            ' . $minDateFilter . '
                                        )
                ORDER BY
                    main.saved_datetime DESC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectFinalResults($i_employeeId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_final_result
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                ORDER BY
                    saved_datetime DESC,
                    ' . self::ID_FIELD . ' DESC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectFinalResult($i_employeeId, $i_finalResultId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_final_result
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employeeId . '
                    AND ID_EAFR = ' . $i_finalResultId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertFinalResult(  $i_employeeId,
                                        $d_assessmentDate,
                                        $i_totalScore,
                                        $s_totalScoreComment,
                                        $i_behaviourScore,
                                        $s_behaviourScoreComment,
                                        $i_resultsScore,
                                        $s_resultsScoreComment)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_assessment_final_result
                    (   customer_id,
                        ID_E,
                        assessment_date,
                        total_score,
                        total_score_comment,
                        behaviour_score,
                        behaviour_score_comment,
                        results_score,
                        results_score_comment,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                       "' . mysql_real_escape_string($d_assessmentDate) . '",
                        ' . BaseQueries::nullableValue($i_totalScore) . ',
                       "' . mysql_real_escape_string($s_totalScoreComment) . '",
                        ' . BaseQueries::nullableValue($i_behaviourScore) . ',
                       "' . mysql_real_escape_string($s_behaviourScoreComment) . '",
                        ' . BaseQueries::nullableValue($i_resultsScore) . ',
                       "' . mysql_real_escape_string($s_resultsScoreComment) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

}

?>
