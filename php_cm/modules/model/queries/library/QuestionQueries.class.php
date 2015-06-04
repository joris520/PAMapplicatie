<?php

/**
 * Description of QuestionQueries
 *
 * @author ben.dokter
 */

class QuestionQueries
{

    const ID_FIELD = 'ID_AQ';

    static function getQuestions($activeOnly = true)
    {
        $filter = ($activeOnly) ? ' AND active = ' . BaseDatabaseValue::IS_ACTIVE . ' ' : '';

        $sql = 'SELECT
                    *
                FROM
                    assessment_question
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    ' . $filter . '
                ORDER BY
                    sort_order';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectQuestion($i_questionId)
    {

        $sql = 'SELECT
                    *
                FROM
                    assessment_question
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_AQ = ' . $i_questionId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }


    static function countQuestionUsage($i_questionId)
    {
        $sql = 'SELECT
                    count(*) as counted
                FROM
                    employee_assessment_question_answer
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_AQ = ' . $i_questionId;

        return BaseQueries::performSelectQuery($sql);

        // alle sortorder <= $i_sortOrder eentje opschuiven naar boven
    }

    static function insertQuestion( $s_question,
                                    $i_sortOrder)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    assessment_question
                    (   customer_id,
                        sort_order,
                        question,
                        active,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_sortOrder . ',
                        "' . mysql_real_escape_string($s_question) . '",
                         ' . BaseDatabaseValue::IS_ACTIVE . ',
                         ' . $savedByUserId . ',
                        "' . mysql_real_escape_string($savedByUser) . '",
                        "' . $savedDatetime . '",
                        NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateQuestion( $i_questionId,
                                    $s_question,
                                    $i_sortOrder)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    assessment_question
                SET
                    sort_order          = ' . $i_sortOrder . ',
                    question            = "' .  mysql_real_escape_string($s_question) . '",
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_AQ = ' . $i_questionId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deactivateQuestion($i_questionId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    assessment_question
                SET
                    active              = ' . BaseDatabaseValue::IS_DELETED . ',
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_AQ = ' . $i_questionId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deleteQuestion($i_questionId)
    {
        $sql = 'DELETE FROM
                    assessment_question
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_AQ = ' . $i_questionId . '
                LIMIT 1';

        return BaseQueries::performDeleteQuery($sql);
    }


}

?>
