<?php
/**
 * Description of ScoreQuestionsQueries
 *
 * @author ben.dokter
 */
class ScoreQuestionsQueries {

    static function getScoreQuestions($active_only = false) {

        $filter = ($active_only == true) ? ' AND active = 1 ' : '';

        $sql = 'SELECT
                    ID_MQ,
                    active,
                    question
                FROM
                    _customers_misc_questions
                WHERE
                    customer_id = ' . CUSTOMER_ID .
                    $filter . '
                ORDER BY
                    seq_num';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getScoreAnswers($i_employee_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    employees_misc_answers ema
                    INNER JOIN _customers_misc_questions cmq
                        ON ema.ID_MQ = cmq.ID_MQ
                WHERE
                    cmq.customer_id = ' . CUSTOMER_ID . '
                    AND cmq.active = 1
                    AND ema.ID_E = ' . $i_employee_id . '
                ORDER BY
                    seq_num';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getQuestionsAndAnswers($i_employee_id)
    {
        $sql = 'SELECT
                    cmq.*,
                    ema.ID_MA,
                    ema.answer
                FROM
                    _customers_misc_questions cmq
                    LEFT JOIN employees_misc_answers ema
                        ON ema.ID_MQ = cmq.ID_MQ
                            AND ema.ID_E = ' . $i_employee_id . '
                WHERE
                    cmq.customer_id = ' . CUSTOMER_ID . '
                    AND cmq.active = 1
                ORDER BY
                    seq_num';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getQuestionAnswer($i_employee_id,
                                      $i_question_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    employees_misc_answers
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employee_id . '
                    AND ID_MQ   = ' . $i_question_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function insertQuestionAnswer($i_employee_id,
                                         $i_question_id,
                                         $s_answer)
    {
        $sql = 'INSERT INTO
                    employees_misc_answers
                    ( customer_id,
                      ID_E,
                      ID_MQ,
                      answer
                    ) VALUES (
                       ' . CUSTOMER_ID . ',
                       ' . $i_employee_id . ',
                       ' . $i_question_id . ',
                      "' . mysql_real_escape_string($s_answer) . '"
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();

    }

    static function updateQuestionAnswer($i_employee_id,
                                         $i_question_id,
                                         $i_answer_id,
                                         $s_answer)
    {
        $sql = 'UPDATE
                    employees_misc_answers
                SET
                    answer = "' . mysql_real_escape_string($s_answer) . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E   = ' . $i_employee_id . '
                    AND ID_MQ  = ' . $i_question_id . '
                    AND ID_MA  = ' . $i_answer_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }
}

?>
