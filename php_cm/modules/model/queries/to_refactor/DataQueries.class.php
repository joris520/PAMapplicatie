<?php

/**
 * Description of DataQueries
 *
 * @author wouter.storteboom
 */

require_once('gino/BaseQueries.class.php');

class DataQueries {

    protected function getDataBasedOnUserLevel($s_employee = null,
                                               $ia_employee_id = null,
                                               $ia_function_id = null,
                                               $ia_department_id = null,
                                               $b_is_boss = null,
                                               $ia_boss_id = null,
                                               $use_limit = true,
                                               $only_with_email = false,
                                               $fieldlist = null,
                                               $sort = 'e.lastname,e.firstname',
                                               $limit = null,
                                               $filter_additional = null)
    {

        $filter_employee_name = '';
        if (!empty($s_employee)) {
            $filter_employee_name = ' AND (lastname LIKE "%' . mysql_real_escape_string($s_employee) . '%"
                                           OR firstname LIKE "%' . mysql_real_escape_string($s_employee) . '%")';
        }

        $filter_employee_id = '';
        if (!empty($ia_employee_id)) {
            if (is_array($ia_employee_id)) {
                $filter_employee_id = ' AND e.ID_E IN (' . implode(',', $ia_employee_id) . ') ';
            } else {
                $filter_employee_id = ' AND e.ID_E = ' . $ia_employee_id . ' ';
            }

        }

        $filter_function_id = '';
        if (!empty($ia_function_id)) {
            if (is_array($ia_function_id)) {
                $filter_function_id = ' AND e.ID_FID IN (' . implode(',', $ia_function_id) . ') ';
            } else {
                $filter_function_id = ' AND e.ID_FID = ' . $ia_function_id . ' ';
            }
        }

        $filter_department_id = '';
        if (!empty($ia_department_id)) {
            if (is_array($ia_department_id)) {
                $filter_department_id = ' AND e.ID_DEPTID IN (' . implode(',', $ia_department_id) . ') ';
            } else {
                $filter_department_id = ' AND e.ID_DEPTID = ' . $ia_department_id;
            }
        }

        $filter_is_boss = '';
        if (!empty($b_is_boss)) {
            $filter_is_boss = ' AND e.is_boss = ' . ($b_is_boss ? EMPLOYEE_IS_MANAGER : EMPLOYEE_IS_EMPLOYEE);
        }

        $filter_boss_id = '';
        if (!empty($ia_boss_id)) {
            if (is_array($ia_boss_id)) {
                $filter_boss_id = ' AND e.boss_fid IN (' . implode(',', $ia_boss_id) . ') ';
            } else {
                if ($ia_boss_id == 'NULL') {
                    $filter_boss_id = ' AND e.boss_fid IS NULL';
                } else {
                    $filter_boss_id = ' AND e.boss_fid = ' . $ia_boss_id;
                }
            }
        }


        if ($only_with_email) {
            $filter_email = ' AND e.email_address IS NOT NULL ';
        }

        if (is_null($fieldlist)) {
            $fieldlist = 'e.firstname,
                          e.lastname,
                          e.employee,
                          e.ID_E,
                          f.ID_F,
                          f.function,
                          de.ID_DEPT,
                          de.department';
        }

        $sql = '';
        //USER VALIDATION
        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS
                        ' . $fieldlist . '
                    FROM
                        employees e
                        INNER JOIN department de
                            ON de.ID_DEPT = e.ID_DEPTID
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        ' . $filter_employee_id . '
                        ' . $filter_function_id . '
                        ' . $filter_employee_name . '
                        ' . $filter_department_id . '
                        ' . $filter_is_boss . '
                        ' . $filter_boss_id . '
                        ' . $filter_email . '
                        ' . $filter_additional . '
                    ORDER BY
                        ' . $sort;

        } elseif (USER_LEVEL == UserLevelValue::HR ||
                  USER_LEVEL == UserLevelValue::MANAGER) {
            $sql_is_boss_of_or_employee_filter = ' ';
            if (!is_null(EMPLOYEE_ID)) {
                $boss_result = EmployeesQueries::getBossInfo(EMPLOYEE_ID);
                $boss_row = @mysql_fetch_assoc($boss_result);

                if ($boss_row['is_boss']) {
                    $sql_is_boss_of_or_employee_filter = ' OR e_allowed.boss_fid = ' . EMPLOYEE_ID;
                }

                // Zo kan een HR/MGR zichzelf zien
//                $sql_is_boss_of_or_employee_filter .= ' OR e_allowed.id_e = ' . EMPLOYEE_ID;
            }

            $sql = 'SELECT SQL_CALC_FOUND_ROWS
                        ' . $fieldlist . '
                    FROM
                        employees e
                        LEFT JOIN department de
                            ON (de.ID_DEPT = e.ID_DEPTID)
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                    WHERE
                        e.customer_id=  ' . CUSTOMER_ID  . '
                        AND e.id_e in   (   SELECT
                                                DISTINCT (e_allowed.id_e)
                                            FROM
                                                users u_allowed
                                                LEFT JOIN users_department ud_allowed
                                                    ON u_allowed.user_id = ud_allowed.id_uid
                                                INNER JOIN employees e_allowed
                                                        ON (ud_allowed.id_dept = e_allowed.ID_DEPTID
                                                            ' . $sql_is_boss_of_or_employee_filter . ')
                                            WHERE
                                                e_allowed.customer_id=  ' . CUSTOMER_ID  . '
                                                AND e_allowed.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                                                AND u_allowed.user_id = ' . USER_ID . '
                                        )
                        ' . $filter_employee_name . '
                        ' . $filter_employee_id . '
                        ' . $filter_function_id . '
                        ' . $filter_emp_name . '
                        ' . $filter_department_id . '
                        ' . $filter_is_boss . '
                        ' . $filter_boss_id . '
                        ' . $filter_email . '
                        ' . $filter_additional . '
                    GROUP BY
                        e.ID_E
                    ORDER BY
                        ' . $sort;
        } else {
            $sql = 'SELECT SQL_CALC_FOUND_ROWS
                        ' . $fieldlist . '
                    FROM
                        employees e
                        INNER JOIN department de
                            ON de.ID_DEPT = e.ID_DEPTID
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . EMPLOYEE_ID . '
                        ' . $filter_employee_id . '
                        ' . $filter_function_id . '
                        ' . $filter_emp_name . '
                        ' . $filter_department_id . '
                        ' . $filter_is_boss . '
                        ' . $filter_boss_id . '
                        ' . $filter_email . '
                        ' . $filter_additional . '
                    ORDER BY
                        ' . $sort;
        }
        //END USER VALIDATION
        if (!empty($limit)) {
            $sql .= ' LIMIT ' . $limit;
        } else {
            if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT && $use_limit) {
                $sql .= ' LIMIT ' . CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER;
            }
        }

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    function getEmployeeIdsForResult($employee_results)
    {
        $employeeIds = array();
        if (@mysql_num_rows($employee_results) > 0) {
            while ($employee = @mysql_fetch_assoc($employee_results)) {
                $employeeIds[] = $employee['ID_E'];
            }
        }
        return $employeeIds;
    }

    static function getScoreStatusFilteredEmployees($s_employee = null,
                                                    $b_employee_email_address_filled_in = null,
                                                    $ia_employee_id = null,
                                                    $i_function_id = null,
                                                    $i_department_id = null,
                                                    $b_is_boss = null,
                                                    $i_boss_id = null,
                                                    $use_limit = true,
                                                    $i_employees_filter = null)
    {
        $custom_join = 'INNER JOIN employees_topics et
                            ON et.ID_E = e.ID_E';

        $custom_select_fields = 'et.score_status';

        switch ($i_employees_filter) {
            case FILTER_EMPLOYEES_STATUS_MANAGER_PRELIMINARY:
                $custom_filter = ' et.score_status = ' . ScoreStatusValue::PRELIMINARY;
                break;
            case FILTER_EMPLOYEES_STATUS_MANAGER_FINAL:
                $custom_filter = ' et.score_status = ' . ScoreStatusValue::FINALIZED;
                break;
            default:
                $custom_filter = null;
        }

        return DataQueries::getEmployeesBasedOnUserLevelCustomFilters($s_employee,
                                                                      $b_employee_email_address_filled_in,
                                                                      $ia_employee_id,
                                                                      $i_function_id,
                                                                      $i_department_id,
                                                                      $b_is_boss,
                                                                      $i_boss_id,
                                                                      $use_limit,
                                                                      $custom_filter,
                                                                      $custom_join,
                                                                      $custom_select_fields,
                                                                      NULL);
    }

    static function getSelfAssessmentFilteredEmployees($s_employee = null,
                                                       $b_employee_email_address_filled_in = null,
                                                       $ia_employee_id = null,
                                                       $i_function_id = null,
                                                       $i_department_id = null,
                                                       $b_is_boss = null,
                                                       $i_boss_id = null,
                                                       $use_limit = true,
                                                       $i_employees_filter = null)
    {
        // "default join"
        $custom_join = 'LEFT JOIN threesixty_invitations ti
                            ON ti.ID_E = e.ID_E
                                AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                        INNER JOIN employees_topics et
                            ON et.ID_E = e.ID_E';


        $custom_filter = '';
        if ($i_employees_filter != FILTER_EMPLOYEES_ALPHABETICAL
            && $i_employees_filter != FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN_NO_LOS
            && $i_employees_filter != FILTER_EMPLOYEES_EMPLOYEE_INVITED_NO_LOS
            /* && $i_employees_filter != FILTER_EMPLOYEES_EMPLOYEE_NOT_INVITED */) {
            $custom_sort_order_prefix = 'assessment_status_sortorder,
                                         assessment_evaluation_request_status DESC,';
        }
        if ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                    ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_NOT_INVITED) {
            $custom_join = ' LEFT JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E ';

            $custom_filter = ' (ti.hash_id IS NULL
                               OR ti.invitation_date IS NULL
                               OR DATEDIFF(CURRENT_DATE, ti.invitation_date) >= ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . ')';

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED_EMPLOYEE_NOT_FILLED_IN) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND ti.completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED_MANAGER_NOT_FILLED_IN) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                              INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.score_status = ' . ScoreStatusValue::PRELIMINARY . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                               AND et.score_status = ' . ScoreStatusValue::FINALIZED . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_ASSESSMENT_STATE) {
            // default...
        } elseif ($i_employees_filter == FILTER_EMPLOYEES_TODO_EVALUATION) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                              INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . '
                               AND et.assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_NOT_DONE_DEPRECATED . '
                               AND et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::REQUESTED . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_DONE_EVALUATION) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_DONE . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_NO_EVALUATION) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . '
                               AND et.assessment_evaluation_status = ' . AssessmentEvaluationStatusValue::EVALUATION_NOT_DONE_DEPRECATED . '
                               AND et.assessment_evaluation_request_status = ' . AssessmentProcessEvaluationRequestValue::NOT_REQUESTED . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED_MANAGER_COMPLETED) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.score_status = ' . ScoreStatusValue::FINALIZED . '
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED_BOTH_FILLED_IN_NO_LOS) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . '
                               AND ti.completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                               AND et.score_status = ' . ScoreStatusValue::FINALIZED . '
                               AND ti.ID_TSIM_LOS IS NULL
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;

        } elseif ($i_employees_filter == FILTER_EMPLOYEES_EMPLOYEE_INVITED_NO_LOS) {
            $custom_join = ' INNER JOIN threesixty_invitations ti
                                ON ti.id_e = e.ID_E
                                    AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                                    AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                             INNER JOIN employees_topics et
                                ON et.ID_E = e.ID_E';

            $custom_filter = ' ti.invitation_date IS NOT NULL
                               AND et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . '
                               AND ti.ID_TSIM_LOS IS NULL
                               AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS;
        }

        $custom_select_fields = ' IF(et.score_rank IS NOT NULL, et.score_rank, ' . AssessmentProcessScoreRankingValue::NO_RANKING . ') as score_rank,
                                  et.assessment_evaluation_request_status,
                                  et.assessment_evaluation_status,
                                  et.score_status,
                                  et.score_sum as manager_score,
                                  ti.threesixty_scores_sum as employee_score,
                                  ti.threesixty_score_diff_sum as employee_diff_score,
                                  ti.completed,
                                  ti.ID_TSIM_LOS as letter_of_satisfaction_id,
                                  IF(et.assessment_status > 0, et.assessment_status, ' . NEVER_INVITED_ASSESSMENT . ') as assessment_status,
                                  CASE WHEN ti.hash_id IS NULL
                                       THEN ' . NEVER_INVITED_ASSESSMENT .'
                                       ELSE CASE WHEN DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                                                 THEN IF(et.score_status = ' . ScoreStatusValue::FINALIZED . ', ' . MANAGER_FILLED_IN_ASSESSMENT . ', ' . MANAGER_NOT_FILLED_IN_ASSESSMENT . ')
                                                 ELSE ' . NOT_INVITED_ASSESSMENT_THIS_PERIOD .'
                                            END
                                       END manager_assessment_status,
                                  CASE WHEN ti.hash_id IS NULL
                                       THEN ' . NEVER_INVITED_ASSESSMENT .'
                                       ELSE CASE WHEN DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                                                 THEN IF(ti.completed <> ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . ', ' . EMPLOYEE_FILLED_IN_ASSESSMENT . ', ' . EMPLOYEE_NOT_FILLED_IN_ASSESSMENT . ')
                                                 ELSE ' . NOT_INVITED_ASSESSMENT_THIS_PERIOD .'
                                            END
                                       END employee_assessment_status,
                                  CASE WHEN ti.hash_id IS NULL
                                       THEN ' . SORTORDER_ASSESSMENT_STATUS_UNUSED . '
                                       ELSE CASE WHEN DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                                                 THEN CASE WHEN et.assessment_status = ' . AssessmentProcessStatusValue::INVITED . '
                                                           THEN (et.assessment_status * 10)
                                                                 + IF(et.score_status = ' . ScoreStatusValue::FINALIZED . ', ' . MANAGER_FILLED_IN_ASSESSMENT . ', ' . MANAGER_NOT_FILLED_IN_ASSESSMENT . ')
                                                                 + IF(ti.completed = ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . ',
                                                                      IF(et.score_status = ' . ScoreStatusValue::FINALIZED . ', ' . EMPLOYEE_FILLED_IN_ASSESSMENT . ', 1+' . EMPLOYEE_NOT_FILLED_IN_ASSESSMENT . '),
                                                                      ' . EMPLOYEE_NOT_FILLED_IN_ASSESSMENT . ')
                                                           ELSE CASE WHEN et.assessment_status = ' . AssessmentProcessStatusValue::EVALUATION_SELECTED . '
                                                                     THEN (et.assessment_status * 10) - IF(et.assessment_evaluation_status > ' . AssessmentEvaluationStatusValue::EVALUATION_NOT_DONE_DEPRECATED . ',-' . SORTORDER_STATUS_EVALUATION_DONE . ', et.assessment_evaluation_request_status + et.assessment_evaluation_status )
                                                                     ELSE (et.assessment_status * 10) - IF(et.score_rank IS NOT NULL, et.score_rank, 0)
                                                                END
                                                      END
                                                 ELSE ' . SORTORDER_NOT_INVITED_ASSESSMENT_THIS_PERIOD . '
                                            END
                                  END as assessment_status_sortorder';

        return DataQueries::getEmployeesBasedOnUserLevelCustomFilters($s_employee,
                                                                      $b_employee_email_address_filled_in,
                                                                      $ia_employee_id,
                                                                      $i_function_id,
                                                                      $i_department_id,
                                                                      $b_is_boss,
                                                                      $i_boss_id,
                                                                      $use_limit,
                                                                      $custom_filter,
                                                                      $custom_join,
                                                                      $custom_select_fields,
                                                                      $custom_sort_order_prefix);
    }

    static function getEmployeesBasedOnUserLevelCustomFilters($s_employee = null,
                                                              $b_employee_email_address_filled_in = null,
                                                              $ia_employee_id = null,
                                                              $i_function_id = null,
                                                              $i_department_id = null,
                                                              $b_is_boss = null,
                                                              $i_boss_id = null,
                                                              $use_limit = true,
                                                              $s_custom_filter = null,
                                                              $s_custom_join = null,
                                                              $s_custom_select_fields = null,
                                                              $custom_sort_order_prefix = null)
    {
        $filter_emp_name = '';
        if (!empty($s_employee)) {
            $filter_emp_name = ' AND (lastname LIKE "%' . mysql_real_escape_string($s_employee) . '%"
                                 OR firstname LIKE "%' . mysql_real_escape_string($s_employee) . '%")';
        }

        $filter_emp_email_address = '';
        if (!empty($b_employee_email_address_filled_in) && $b_employee_email_address_filled_in) {
            $filter_emp_email_address = ' AND e.email_address <> ""';
        }

        $filter_emp_id = '';
        if (!empty($ia_employee_id)) {
            if (is_array($ia_employee_id)) {
                $filter_emp_id = ' AND e.ID_E IN (' . implode(',', $ia_employee_id) . ') ';
            } else {
                $filter_emp_id = ' AND e.ID_E = ' . intval($ia_employee_id) . ' ';
            }
        }

        $filter_function_id = '';
        if (!empty($i_function_id)) {
            $filter_function_id = ' AND e.ID_FID = ' . $i_function_id . ' ';
        }

        $filter_department_id = '';
        if (!empty($i_department_id)) {
            $filter_department_id = ' AND e.ID_DEPTID = ' . $i_department_id;
        }

        $filter_is_boss = '';
        if (!empty($b_is_boss)) {
            $filter_is_boss = ' AND e.is_boss = ' . ($b_is_boss ? EMPLOYEE_IS_MANAGER : EMPLOYEE_IS_EMPLOYEE);
        }

        $filter_boss_id = '';
        if (!empty($i_boss_id)) {
            if ($i_boss_id == 'NULL') {
                $filter_boss_id = ' AND e.boss_fid IS NULL';
            } else {
                $filter_boss_id = ' AND e.boss_fid = ' . $i_boss_id;
            }
        }
        $select_fields = ' e.firstname,
                           e.lastname,
                           e.employee,
                           e.ID_E,
                           f.ID_F,
                           f.function,
                           d.ID_DEPT,
                           d.department ';
        if (!empty($s_custom_select_fields)) {
            $select_fields .= ', ' . $s_custom_select_fields . ' ';
        }

        $extra_where_filters = '';
        if (!empty($s_custom_filter)) {
            $extra_where_filters = ' AND ' . $s_custom_filter . ' ';
        }

        $extra_joins = '';
        if (!empty($s_custom_join)) {
            $extra_joins = ' ' .  $s_custom_join . ' ';
        }

        $sql = '';
        //USER VALIDATION
        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = 'SELECT
                        ' . $select_fields . '
                    FROM
                        employees e
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                        ' . $extra_joins . '
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        ' . $filter_emp_id . '
                        ' . $filter_emp_email_address . '
                        ' . $filter_function_id . '
                        ' . $filter_emp_name . '
                        ' . $filter_department_id . '
                        ' . $filter_is_boss . '
                        ' . $filter_boss_id . '
                        ' . $extra_where_filters . '
                    ORDER BY
                        ' . $custom_sort_order_prefix . '
                        e.lastname,
                        e.firstname';
            //die($sql);
        } elseif (USER_LEVEL == UserLevelValue::HR ||
                  USER_LEVEL == UserLevelValue::MANAGER) {
            $sql_is_boss_of_or_employee_filter = ' ';
            if (!is_null(EMPLOYEE_ID)) {
                $boss_result = EmployeesQueries::getBossInfo(EMPLOYEE_ID);
                $boss_row = @mysql_fetch_assoc($boss_result);

                if ($boss_row['is_boss']) {
                    $sql_is_boss_of_or_employee_filter = ' OR e_allowed.boss_fid = ' . EMPLOYEE_ID;
                }
            }

            $sql = 'SELECT
                       ' . $select_fields . '
                    FROM
                        employees e
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                        ' . $extra_joins . '
                    WHERE
                        e.customer_id= ' . CUSTOMER_ID . '
                        -- AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.id_e in   (   SELECT
                                                DISTINCT (e_allowed.id_e)
                                            FROM
                                                users u_allowed
                                                LEFT JOIN users_department ud_allowed
                                                    ON u_allowed.user_id = ud_allowed.id_uid
                                                INNER JOIN employees e_allowed
                                                        ON (ud_allowed.id_dept = e_allowed.ID_DEPTID
                                                            ' . $sql_is_boss_of_or_employee_filter . ')
                                            WHERE
                                                e_allowed.customer_id=  ' . CUSTOMER_ID  . '
                                                AND e_allowed.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                                                AND u_allowed.user_id = ' . USER_ID . '
                                        )
                        ' . $filter_emp_id . '
                        ' . $filter_emp_email_address . '
                        ' . $filter_function_id . '
                        ' . $filter_emp_name . '
                        ' . $filter_department_id . '
                        ' . $filter_is_boss . '
                        ' . $filter_boss_id . '
                        ' . $extra_where_filters . '
                    GROUP BY
                        e.ID_E
                    ORDER BY
                        ' . $custom_sort_order_prefix . '
                        e.lastname,
                        e.firstname';
        } else {
            $sql = 'SELECT
                        ' . $select_fields . '
                    FROM
                        employees e
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                        ' . $extra_joins . '
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . EMPLOYEE_ID . '
                        ' . $filter_emp_id . '
                        ' . $filter_emp_email_address . '
                        ' . $filter_function_id . '
                        ' . $filter_emp_name . '
                        ' . $filter_department_id . '
                        ' . $filter_is_boss . '
                        ' . $filter_boss_id . '
                        ' . $extra_where_filters . '
                    ORDER BY
                        ' . $custom_sort_order_prefix . '
                        e.lastname,
                        e.firstname';
        }
        //END USER VALIDATION

        if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT && $use_limit) {
            $sql .= ' LIMIT ' . CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER;
        }
        $sql_result = BaseQueries::performQuery($sql);

        return $sql_result;
    }

    function getAssessmentsStates($i_boss_id)
    {
        $sql = 'SELECT
                    et.assessment_status
                FROM
                    employees e
                    INNER JOIN employees_topics et
                        ON e.ID_E = et.ID_E
                    LEFT JOIN threesixty_invitations ti
                        ON e.ID_E = ti.id_e
                        AND ti.is_self_evaluation = ' . AssessmentInvitationTypeValue::IS_SELF_EVALUATION . '
                        AND ti.threesixty_scores_status < ' . AssessmentInvitationStatusValue::HISTORICAL . '
                where
                    e.customer_id = ' . CUSTOMER_ID .'
                    AND e.boss_fid = ' . $i_boss_id .'
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    AND DATEDIFF(CURRENT_DATE, ti.invitation_date) < ' . CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS . '
                GROUP BY
                    et.assessment_status
                ORDER BY
                    et.assessment_status';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

}

?>
