<?php

/**
 * Description of AssessmentProcessReportQueries
 *
 * @author ben.dokter
 */
class AssessmentProcessReportQueries
{
    const ID_FIELD = 'ID_E';

    static function getProcessCountReportInPeriod(  $s_allowedEmployeeIds,
                                                    $dt_periodStart,
                                                    $dt_periodEnd)
    {

        $sql = 'SELECT
                    COUNT(*) as invitedTotal,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::INVITED . ',1,0)) as phaseInvited,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::SELFASSESSMENT_COMPLETED . ',1,0)) as phaseSelectEvaluation,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',1,0)) as phaseEvaluation,
                    SUM(IF(assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_DONE . ','.
                            'IF(evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',0,'.
                            '1),'.
                        '0)) as evaluationDoneNotRequested,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',' .
                            'IF(evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',' .
                                'IF(assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_NO . ',1,' .
                                    'IF(assessment_evaluation_status IS NULL,1,' .
                                    '0)' .
                                '),' .
                            '0),'.
                        '0)) as evaluationPlanned,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',' .
                            'IF(evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',' .
                                'IF(assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_CANCELLED . ',1,' .
                                '0),' .
                            '0),'.
                        '0)) as evaluationCancelled,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',' .
                            'IF(evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',' .
                                'IF(assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_DONE . ',1,' .
                                '0),'.
                            '0),'.
                        '0)) as evaluationDone,
                    SUM(IF(assessment_process_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . ',' .
                            'IF(evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . ',0,' .
                            '1),'.
                        '0)) as evaluationNotRequested
                FROM
                    employee_assessment_process eap
                    LEFT JOIN employee_assessment_evaluation eae
                        ON eae.ID_E = eap.ID_E
                        AND eae.active = ' . BaseDatabaseValue::IS_ACTIVE . '
                        AND eae.ID_EAE = ( SELECT
                                                    MAX(maxid_eae.ID_EAE)
                                                FROM
                                                    employee_assessment_evaluation maxid_eae
                                                WHERE
                                                    maxid_eae.customer_id = eap.customer_id
                                                    AND maxid_eae.ID_E    = eap.ID_E
                                                    AND DATEDIFF(maxid_eae.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                    AND DATEDIFF(maxid_eae.saved_datetime, "' . $dt_periodStart . '") >= 0
                                                )
                WHERE
                    eap.customer_id = ' . CUSTOMER_ID . '
                    AND eap.ID_E IN (' . $s_allowedEmployeeIds . ')
                    AND eap.invitation_hash_id IS NOT NULL
                    AND assessment_process_status <> ' . AssessmentProcessStatusValue::UNUSED . '
                    AND eap.ID_EAP  =  (   SELECT
                                                MAX(maxid_eap.ID_EAP)
                                            FROM
                                                employee_assessment_process maxid_eap
                                            WHERE
                                                maxid_eap.customer_id = eap.customer_id
                                                AND maxid_eap.ID_E    = eap.ID_E
                                                AND DATEDIFF(maxid_eap.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                AND DATEDIFF(maxid_eap.saved_datetime, "' . $dt_periodStart . '") >= 0
                                        )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getProcessReportInPeriod(   $s_allowedEmployeeIds,
                                                $filterAssessmentProcessStatus,
                                                $dt_periodStart,
                                                $dt_periodEnd)
    {
        $sqlStatusFilter  = is_null($filterAssessmentProcessStatus) || !is_numeric($filterAssessmentProcessStatus) ? '' : 'AND eap.assessment_process_status in (' . $filterAssessmentProcessStatus . ')';

        $sql = 'SELECT
                    eap.ID_EAP,
                    eap.assessment_date,
                    eap.assessment_process_status,
                    eap.score_sum,
                    eap.score_rank,
                    eap.evaluation_request_status,
                    eae.ID_EAE,
                    eae.assessment_evaluation_date,
                    eae.assessment_evaluation_status,
                    e.firstname,
                    e.lastname,
                    e.ID_E
                FROM
                    employee_assessment_process eap
                    INNER JOIN employees e
                        ON eap.ID_E = e.ID_E
                    LEFT JOIN employee_assessment_evaluation eae
                        ON eae.ID_E = eap.ID_E
                        AND eae.active = ' . BaseDatabaseValue::IS_ACTIVE . '
                        AND eae.ID_EAE = ( SELECT
                                                    MAX(maxid_eae.ID_EAE)
                                                FROM
                                                    employee_assessment_evaluation maxid_eae
                                                WHERE
                                                    maxid_eae.customer_id = eap.customer_id
                                                    AND maxid_eae.ID_E    = eap.ID_E
                                                    AND DATEDIFF(maxid_eae.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                    AND DATEDIFF(maxid_eae.saved_datetime, "' . $dt_periodStart . '") >= 0
                                                )
                WHERE
                    eap.customer_id = ' . CUSTOMER_ID . '
                    AND eap.ID_E IN (' . $s_allowedEmployeeIds . ')
                    AND eap.invitation_hash_id IS NOT NULL
                    ' . $sqlStatusFilter . '
                    AND eap.ID_EAP  =  (   SELECT
                                                MAX(maxid_eap.ID_EAP)
                                            FROM
                                                employee_assessment_process maxid_eap
                                            WHERE
                                                maxid_eap.customer_id = eap.customer_id
                                                AND maxid_eap.ID_E    = eap.ID_E
                                                AND DATEDIFF(maxid_eap.saved_datetime, "' . $dt_periodEnd . '") < 0
                                                AND DATEDIFF(maxid_eap.saved_datetime, "' . $dt_periodStart . '") >= 0
                                        )
                ORDER BY
                    e.lastname,
                    e.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
