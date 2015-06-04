<?php

/**
 * Description of EmployeeAnswerQueries
 *
 * @author ben.dokter
 */

class EmployeeAnswerQueries
{
    const ID_FIELD = 'ID_EAQA';

    static function getAnswerInPeriod($i_employeeId, $i_questionId, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_question_answer main
                WHERE
                    main.ID_EAQA = (    SELECT
                                            MAX(maxid.ID_EAQA)
                                        FROM
                                            employee_assessment_question_answer maxid
                                        WHERE
                                            maxid.customer_id = ' . CUSTOMER_ID . '
                                            AND maxid.ID_E = ' . $i_employeeId . '
                                            AND maxid.ID_AQ = '. $i_questionId . '
                                            AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                            ' . $minDateFilter . '
                                        )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectAllAnswers($i_employeeId, $i_questionId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_question_answer
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                    AND ID_AQ = '. $i_questionId . '
                ORDER BY
                    saved_datetime DESC,
                    ' . self::ID_FIELD . ' DESC';



        return BaseQueries::performSelectQuery($sql);

    }
    static function insertEmployeeAnswer(   $i_employeeId,
                                            $i_questionId,
                                            $s_question,
                                            $s_answer)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_assessment_question_answer
                    (   customer_id,
                        ID_E,
                        ID_AQ,
                        question,
                        answer,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                        ' . $i_questionId . ',
                       "' . mysql_real_escape_string($s_question) . '",
                       "' . mysql_real_escape_string($s_answer) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

}

?>
