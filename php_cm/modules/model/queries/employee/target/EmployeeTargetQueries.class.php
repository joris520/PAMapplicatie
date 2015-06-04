<?php

/**
 * Description of EmployeeTargetQueries
 *
 * @author hans.prins
 */

require_once('gino/BaseQueries.class.php');

class EmployeeTargetQueries {

    const ID_FIELD = 'ID_ET';

    static function getTargetsInPeriod( $i_employeeId,
                                        $dt_periodStart,
                                        $dt_periodEnd)
    {
        // TODO: standaard manier gebruiken
        if (!empty($dt_periodStart)) {
            $assessmentCycle_boundaries = ' AND UNIX_TIMESTAMP(end_date) > ' . strtotime($dt_periodStart);
        }
        if (!empty($dt_periodEnd)) {
            $assessmentCycle_boundaries .= ' AND UNIX_TIMESTAMP(end_date) <= ' . strtotime($dt_periodEnd);
        }

        $sql = 'SELECT
                    etd.*
                FROM
                    employee_target_data etd
                    INNER JOIN employee_target et
                        on et.ID_ET = etd.ID_ET
                WHERE
                    etd.customer_id  = ' . CUSTOMER_ID . '
                    AND etd.ID_E     = ' . $i_employeeId . '
                    ' . $assessmentCycle_boundaries . '
                    AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                    AND etd.ID_ETD  = ( SELECT
                                            MAX(etd_last.ID_ETD)
                                        FROM
                                            employee_target_data etd_last
                                        WHERE
                                            etd_last.ID_ET = etd.ID_ET
                                      )
                ORDER BY
                    end_date DESC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getTarget(  $i_employeeId,
                                $i_employeeTargetId)
    {
        $sql = 'SELECT
                    etd.*
                FROM
                    employee_target_data etd
                    INNER JOIN employee_target et
                        on et.ID_ET = etd.ID_ET
                WHERE
                    etd.customer_id = ' . CUSTOMER_ID  . '
                    AND etd.ID_E    = ' . $i_employeeId . '
                    AND etd.ID_ET   = ' . $i_employeeTargetId . '
                    AND active = ' . BaseDatabaseValue::IS_ACTIVE . '
                    AND etd.ID_ETD  = ( SELECT
                                            MAX(etd_last.ID_ETD)
                                        FROM
                                            employee_target_data etd_last
                                        WHERE
                                            etd_last.ID_ET = etd.ID_ET
                                      )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertTarget($i_employeeId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_target
                    (
                        customer_id,
                        ID_E,
                        active,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) values (
                         ' . CUSTOMER_ID . ',
                         ' . $i_employeeId . ',
                         ' . BaseDatabaseValue::IS_ACTIVE . ',
                         ' . $savedByUserId . ',
                        "' . mysql_real_escape_string($savedByUser) . '",
                        "' . $savedDatetime . '",
                        NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function insertTargetData(   $i_employeeId,
                                        $i_employeeTargetId,
                                        $s_targetName,
                                        $s_performanceIndicator,
                                        $d_endDate,
                                        $i_status,
                                        $s_evaluation,
                                        $d_evaluationDate)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_target_data
                    (
                        customer_id,
                        ID_E,
                        ID_ET,
                        target_name,
                        performance_indicator,
                        end_date,
                        status,
                        evaluation,
                        evaluation_date,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) values (
                         ' . CUSTOMER_ID . ',
                         ' . $i_employeeId . ',
                         ' . $i_employeeTargetId . ',
                        "' . mysql_real_escape_string($s_targetName) . '",
                        "' . mysql_real_escape_string($s_performanceIndicator) . '",
                        "' . mysql_real_escape_string($d_endDate) . '",
                         ' . BaseQueries::nullableValue($i_status) . ',
                         ' . BaseQueries::nullableString(mysql_real_escape_string($s_evaluation)) . ',
                         ' . BaseQueries::nullableString(mysql_real_escape_string($d_evaluationDate)) . ',
                         ' . $savedByUserId . ',
                        "' . mysql_real_escape_string($savedByUser) . '",
                        "' . $savedDatetime . '",
                        NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

//    static function updateTarget(   $i_employeeId,
//                                    $i_employeeTargetId)
//    {
//        $savedByUserId = USER_ID;
//        $savedByUser   = USER;
//        $savedDatetime = MODIFIED_DATETIME;
//
//        $sql = 'UPDATE
//                    employee_target
//                SET
//                    saved_by_user_id    =  ' . $savedByUserId . ',
//                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
//                    saved_datetime      = "' . $savedDatetime . '",
//                    database_datetime   = NOW()
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_E    = ' . $i_employeeId . '
//                    AND ID_ET   = ' . $i_employeeTargetId . '
//                LIMIT 1';
//
//        return BaseQueries::performUpdateQuery($sql);
//    }

    static function deactivateTarget(   $i_employeeId,
                                        $i_employeeTargetId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employee_target
                SET
                    active              =  ' . BaseDatabaseValue::IS_DELETED . ',
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employeeId . '
                    AND ID_ET   = ' . $i_employeeTargetId;

        return BaseQueries::performDeleteQuery($sql);
    }

    static function getHistory($i_employeeId,
                               $i_employeeTargetId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_target_data
                WHERE
                    customer_id  = ' . CUSTOMER_ID . '
                    AND ID_E     = ' . $i_employeeId . '
                    AND ID_ET    = ' . $i_employeeTargetId . '
                ORDER BY
                    saved_datetime DESC';

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
