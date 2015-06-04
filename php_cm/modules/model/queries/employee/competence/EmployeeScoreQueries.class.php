<?php

/**
 * Description of EmployeeScoreQueries
 *
 * @author ben.dokter
 */

class EmployeeScoreQueries
{
    const ID_FIELD = 'ID_ECS';

    static function getScoreInPeriod($i_employeeId, $i_competenceId, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    *
                FROM
                    employee_competence_score main
                WHERE
                    main.ID_ECS = ( SELECT
                                        MAX(maxid.ID_ECS)
                                    FROM
                                        employee_competence_score maxid
                                    WHERE
                                        maxid.customer_id = ' . CUSTOMER_ID . '
                                        AND maxid.ID_E = ' . $i_employeeId . '
                                        AND maxid.ID_KSP = '. $i_competenceId . '
                                        AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                        ' . $minDateFilter . '
                                    )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getScores($i_employeeId, $i_competenceId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_competence_score
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                    AND ID_KSP = '. $i_competenceId . '
                ORDER BY
                    saved_datetime DESC,
                    ' . self::ID_FIELD . ' DESC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getScoreInPeriodFiltered($i_employeeId, $i_competenceId, $i_operator, $i_score, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;
        $sql_score = $i_score;

        $s_operator = OperatorConverter::sql($i_operator);
        if ($i_score == ScoreValue::SCORE_Y || $i_score == ScoreValue::SCORE_N) {
            $sql_score = '"' . $i_score . '"';
        }

        $sql = 'SELECT
                    main.*,
					e.employee
                FROM
                    employee_competence_score main
				INNER JOIN
					employees e
				ON
					e.ID_E = main.ID_E
                WHERE
                    main.ID_ECS = ( SELECT
                                        MAX(maxid.ID_ECS)
                                    FROM
                                        employee_competence_score maxid
                                    WHERE
                                        maxid.customer_id = ' . CUSTOMER_ID . '
                                        AND maxid.ID_E = ' . $i_employeeId . '
                                        AND maxid.ID_KSP = '. $i_competenceId . '
                                        AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                        ' . $minDateFilter . '
                                        AND maxid.score ' . $s_operator . ' ' . $sql_score . '
                                    )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertScore($i_employeeId,
                                $i_competenceId,
                                $s_score,
                                $s_note)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_competence_score
                    (   customer_id,
                        ID_E,
                        ID_KSP,
                        score,
                        note,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                        ' . $i_competenceId . ',
                       "' . mysql_real_escape_string($s_score) . '",
                       "' . mysql_real_escape_string($s_note) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

}

?>
