<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ActionQueries
 *
 * @author wouter.storteboom
 */

require_once('gino/BaseQueries.class.php');
require_once('modules/model/queries/to_refactor/DataQueries.class.php');

class ActionQueries extends DataQueries {
    public function getActionsBasedOnUserLevel($s_employee = NULL,
                                                   $ia_employee_id = NULL,
                                                   $ia_function_id = NULL,
                                                   $ia_department_id = NULL,
                                                   $b_is_boss = NULL,
                                                   $ia_boss_id = NULL) {
        $filters_used = false;

        // Nevenprofielen worden niet ondersteunt bij deze aanroep, alleen de hoofdprofielen
        $filter_function_ids = '';
        if (!empty($ia_function_id)) {
            $filters_used = true;

            if (is_array($ia_function_id)) {
                $filter_function_ids = ' AND e.ID_FID IN (' . implode(',', $ia_function_id) . ')';
            } else {
                $filter_function_ids = ' AND e.ID_FID = ' . $ia_function_id;
            }
        }

        $filter_department_ids = '';
        if (!empty($ia_department_id)) {
            $filters_used = true;

            if (is_array($ia_department_id)) {
                $filter_department_ids = ' AND e.ID_DEPTID IN (' . implode(',', $ia_department_id) . ')';
            } else {
                $filter_department_ids = ' AND e.ID_DEPTID = ' . $ia_department_id;
            }
        }

        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql_filters_extra = '';
            if ($filters_used) {
                $sql_filters_extra = '
                        INNER JOIN employees_pdp_actions epa
                            ON (pdpa.id_pdpa = epa.id_pdpaid)
                        INNER JOIN employees e
                            ON (epa.id_e = e.id_e)';
            }

            $sql = 'SELECT
                        DISTINCT
                        pdpa.ID_PDPA,
                        pdpa.action
                    FROM
                        pdp_actions pdpa
                        ' . $sql_filters_extra . '
                    WHERE
                        pdpa.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_function_ids . '
                        ' . $filter_department_ids . '
                    ORDER BY
                        pdpa.action';
        } else {
            $employee_result = $this->getDataBasedOnUserLevel($s_employee,
                                                                $ia_employee_id,
                                                                $ia_function_id,
                                                                $ia_department_id,
                                                                $b_is_boss,
                                                                $ia_boss_id,
                                                                false,
                                                                NULL);

            $employees  = $this->getEmployeeIdsForResult($employee_result);

            $sql = 'SELECT
                        DISTINCT
                        pdpa.ID_PDPA,
                        pdpa.action
                    FROM
                        pdp_actions pdpa
                        INNER JOIN employees_pdp_actions epa
                            ON (pdpa.id_pdpa = epa.id_pdpaid)
                        INNER JOIN employees e
                            ON (epa.id_e = e.id_e)
                    WHERE
                        pdpa.customer_id = ' . CUSTOMER_ID . '
                        AND e.id_e IN (' . implode(',', $employees) .  ')
                        ' . $filter_function_ids . '
                        ' . $filter_department_ids . '
                    ORDER BY
                        pdpa.action';
        }

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
