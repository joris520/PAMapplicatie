<?php

/**
 * Description of EmployeeAssessmentEvaluationQueries
 *
 * @author ben.dokter
 */

class EmployeeAssessmentEvaluationQueries
{
    const ID_FIELD = 'ID_EAE';

    static function getAssessmentEvaluationInPeriod($i_employeeId, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_evaluation main
                WHERE
                    main.ID_EAE = ( SELECT
                                        MAX(maxid.ID_EAE)
                                    FROM
                                        employee_assessment_evaluation maxid
                                    WHERE
                                        maxid.customer_id = ' . CUSTOMER_ID . '
                                        AND maxid.ID_E = ' . $i_employeeId . '
                                        AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                        ' . $minDateFilter . '
                                    )
                    AND main.active = ' . BaseDatabaseValue::IS_ACTIVE;

        return BaseQueries::performSelectQuery($sql);
    }

    static function getAssessmentEvaluations($i_employeeId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_evaluation
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employeeId . '
                    -- AND active  = ' . BaseDatabaseValue::IS_ACTIVE . '
                ORDER BY
                    saved_datetime DESC,
                    ' . self::ID_FIELD . ' DESC';

        return BaseQueries::performSelectQuery($sql);

    }

    static function selectAssessmentEvaluation($i_employeeId, $i_assessmentEvaluationId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_evaluation
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employeeId . '
                    AND ID_EAE  = ' . $i_assessmentEvaluationId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertAssessmentEvaluation( $i_employeeId,
                                                $d_assessmentEvaluationDate,
                                                $i_assessmentEvaluationStatus,
                                                $i_attachmentId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_assessment_evaluation
                    (   customer_id,
                        ID_E,
                        active,
                        assessment_evaluation_date,
                        assessment_evaluation_status,
                        ID_EDOC,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                        ' . BaseDatabaseValue::IS_ACTIVE . ',
                       "' . mysql_real_escape_string($d_assessmentEvaluationDate) . '",
                        ' . $i_assessmentEvaluationStatus . ',
                        ' . BaseQueries::nullableValue($i_attachmentId) . ',
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function deactivateAssessmentEvaluation($i_employeeId, $i_assessmentEvaluationId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employee_assessment_evaluation
                SET
                    active = ' . BaseDatabaseValue::IS_DELETED . ',
                    saved_by_user_id    =  ' . $savedByUserId . ',
                    saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime      = "' . $savedDatetime . '",
                    database_datetime   = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID  . '
                    AND ID_E    = ' . $i_employeeId . '
                    AND ID_EAE  = ' . $i_assessmentEvaluationId;

        return BaseQueries::performUpdateQuery($sql);
    }

}

?>
