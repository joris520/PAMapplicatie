<?php

/**
 * Description of EmployeeAssessmentProcessQueries
 *
 * @author ben.dokter
 */

class EmployeeAssessmentProcessQueries
{
    const ID_FIELD = 'ID_EAP';
    const ID_EMPLOYEE_FIELD = 'ID_E';


    static function getAssessmentProcessInPeriod($s_allowedEmployeeIds, $filterAssessmentProcessStatus, $dt_periodStart, $dt_periodEnd)
    {
        $sqlMinDateFilter = $dt_periodStart == NULL                 ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;
        $sqlStatusFilter  = empty($filterAssessmentProcessStatus)   ? '' : 'AND assessment_process_status in (' . $filterAssessmentProcessStatus . ')';

        $sql = 'SELECT
                    *
                FROM
                    employee_assessment_process main
                WHERE
                    main.customer_id = ' . CUSTOMER_ID . '
                    AND main.ID_E    IN (' . $s_allowedEmployeeIds . ')
                    ' . $sqlStatusFilter . '
                    AND main.ID_EAP  =  (   SELECT
                                                MAX(maxid.ID_EAP)
                                            FROM
                                                employee_assessment_process maxid
                                            WHERE
                                                maxid.customer_id = main.customer_id
                                                AND maxid.ID_E = main.ID_E
                                                AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                ' . $sqlMinDateFilter . '
                                        )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertAssessmentProcess($i_employeeId,
                                            $s_invitationHash,
                                            $d_assessmentDate,
                                            $i_assessmentProcessStatus,
                                            $i_scoreSum,
                                            $i_scoreRank,
                                            $i_evaluationRequestStatus)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_assessment_process
                    (   customer_id,
                        ID_E,
                        invitation_hash_id,
                        assessment_date,
                        assessment_process_status,
                        score_sum,
                        score_rank,
                        evaluation_request_status,
                        evaluation_request_status_database_datetime,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                        "' . $s_invitationHash . '",
                        "' . mysql_real_escape_string($d_assessmentDate) . '",
                        ' . $i_assessmentProcessStatus . ',
                        ' . BaseQueries::nullableValue($i_scoreSum) . ',
                        ' . BaseQueries::nullableValue($i_scoreRank) . ',
                        ' . $i_evaluationRequestStatus . ',
                        NOW(),
                        ' . $savedByUserId . ',
                        "' . mysql_real_escape_string($savedByUser) . '",
                        "' . $savedDatetime . '",
                        NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updateEvaluationRequestStatus($i_employeeId, $i_processId, $i_evaluationRequestStatus)
    {
        $sql = 'UPDATE
                    employee_assessment_process
                SET
                    evaluation_request_status = ' . $i_evaluationRequestStatus . ',
                    evaluation_request_status_database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employeeId . '
                    AND ID_EAP  = ' . $i_processId;

        return BaseQueries::performUpdateQuery($sql);
    }

}

?>
