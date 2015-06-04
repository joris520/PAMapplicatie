<?php

/**
 * Description of AssessmentCycleQueries
 *
 * @author hans.prins
 */

require_once('gino/BaseQueries.class.php');

class AssessmentCycleQueries
{

    const ID_FIELD = 'ID_AC';

    static function getAssessmentCycles($limitNumber)
    {

        $limitFilter = empty($limitNumber) ? '' : 'LIMIT ' . $limitNumber;
        $sql = 'SELECT
                    *
                FROM
                    assessment_cycle
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                ORDER BY
                    start_date DESC
                ' . $limitFilter;

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectAssessmentCycle($i_assessmentCycleId)
    {
        $sql = 'SELECT
                    *
                FROM
                    assessment_cycle
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_AC = ' . $i_assessmentCycleId;

        return BaseQueries::performSelectQuery($sql);
    }

    static function findAssessmentCycleForDate($d_date)
    {
        $sql = '(
                    SELECT
                        assessment_cycle.*,
                        1 as currentRecord
                    FROM
                        assessment_cycle
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                        AND DATEDIFF(start_date, "' . $d_date . '") <= 0
                    ORDER BY
                        start_date DESC
                    LIMIT 1
                ) UNION (
                    SELECT
                        assessment_cycle.*,
                        0 as currentRecord
                    FROM
                        assessment_cycle
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                        AND DATEDIFF(start_date, "' . $d_date . '") > 0
                    ORDER BY
                        start_date ASC
                    LIMIT 1
                )' ;

        return BaseQueries::performSelectQuery($sql);
    }

    static function findAssessmentCycleBeforeDate($d_date)
    {
        $sql = 'SELECT
                    *
                FROM
                    assessment_cycle
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                    AND DATEDIFF(start_date, "' . $d_date . '") < 0
                ORDER BY
                    start_date DESC
                LIMIT 1' ;

        return BaseQueries::performSelectQuery($sql);
    }

    static function findAssessmentCycleWithStartDate($d_date)
    {
        $sql = 'SELECT
                    *
                FROM
                    assessment_cycle
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                    AND DATEDIFF(start_date, "' . $d_date . '") = 0
                ORDER BY
                    start_date DESC
                LIMIT 1' ;

        return BaseQueries::performSelectQuery($sql);
    }

    static function findAssessmentCycleWithName($s_cycle_name)
    {
        $sql = 'SELECT
                    *
                FROM
                    assessment_cycle
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                    AND UPPER(cycle_name) = UPPER("' . $s_cycle_name . '")
                ORDER BY
                    start_date DESC
                LIMIT 1' ;

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertAssessmentCycle($s_cycleName,
                                          $d_startDate)
    {

        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    assessment_cycle
                    (   customer_id,
                        cycle_name,
                        start_date,
                        active,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) values (
                         ' . CUSTOMER_ID . ',
                        "' . mysql_real_escape_string($s_cycleName) . '",
                        "' . mysql_real_escape_string($d_startDate) . '",
                         ' . BaseDatabaseValue::IS_ACTIVE . ',
                         ' . $savedByUserId . ',
                        "' . mysql_real_escape_string($savedByUser) . '",
                        "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateAssessmentCycle($i_assessmentCycleId,
                                          $s_cycleName,
                                          $d_startDate)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    assessment_cycle
                SET
                    cycle_name          = "' . mysql_real_escape_string($s_cycleName) . '",
                    start_date          = "' . mysql_real_escape_string($d_startDate) . '",
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_AC = ' . $i_assessmentCycleId . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

    static function deactivateAssessmentCycle($i_assessmentCycleId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    assessment_cycle
                SET
                    active = ' . BaseDatabaseValue::IS_DELETED . ',
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_AC = ' . $i_assessmentCycleId . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

//    static function deleteAssessmentCycle($i_assessmentCycleId)
//    {
//        $sql = 'DELETE
//                FROM
//                    assessment_cycle
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_AC = ' . $i_assessmentCycleId . '
//                LIMIT 1';
//        return BaseQueries::performDeleteQuery($sql);
//    }

}

?>
