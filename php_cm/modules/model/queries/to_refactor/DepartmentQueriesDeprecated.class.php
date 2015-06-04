<?php

/**
 * Description of DepartmentQueriesDeprecated
 *
 * @author ben.dokter
 */
require_once('gino/BaseQueries.class.php');
require_once('modules/model/queries/to_refactor/DataQueries.class.php');

class DepartmentQueriesDeprecated extends DataQueries
{

    static function getDepartment($i_department_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    department
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_DEPT = ' . $i_department_id;
        return BaseQueries::performQuery($sql);
    }

    static function getAllowedDepartments($filter_id_dept = null)
    {
        $filter_dept = empty($filter_id_dept) ? '' : ' AND d.ID_DEPT = ' . $filter_id_dept . ' ';
        // TODO: HR alleen toegekende afdelingen?? nu alles
        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN ||
            USER_LEVEL == UserLevelValue::HR) {
            $sql = 'SELECT
                        d.ID_DEPT,
                        d.department
                    FROM
                        department d
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_dept . '
                    ORDER BY
                        department';
        } elseif (USER_LEVEL == UserLevelValue::MANAGER) { // manager mag alleen eigen depts zien
            $sql = 'SELECT
                        d.ID_DEPT,
                        d.department
                    FROM
                        department d
                        INNER JOIN users_department ud
                            ON d.ID_DEPT = ud.ID_DEPT
                        INNER JOIN users u
                            ON ud.ID_UID = u.user_id
                    WHERE
                        ud.ID_UID = ' . USER_ID . '
                        AND d.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_dept . '
                    ORDER BY
                        department';
        } elseif (USER_LEVEL == UserLevelValue::EMPLOYEE_EDIT ||
                  USER_LEVEL == UserLevelValue::EMPLOYEE_VIEW) { // EMPS alleen eigen afdeling
            $sql = 'SELECT
                        d.ID_DEPT,
                        d.department
                    FROM
                        department d
                        INNER JOIN employees e
                            ON d.ID_DEPT = e.ID_DEPTID
                    WHERE
                        e.ID_E = ' . EMPLOYEE_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_dept . '
                    ORDER BY
                        department';
        }

        return BaseQueries::performQuery($sql);
    }

    function getFunctionsForDepartments($departments_list, $functions_list = null)
    {
        $filter_depts = empty($departments_list) ? '' : ' AND e.ID_DEPTID in (' . $departments_list . ') ';
        $filter_func = empty($functions_list) ? '' : ' AND f.ID_F in (' . $functions_list . ') ';
        $sql = 'SELECT
                    f.*
                FROM
                    functions f
                    INNER JOIN employees e
                        ON e.ID_FID = f.ID_F
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    ' . $filter_depts . '
                    ' . $filter_func . '
                GROUP BY
                    f.ID_F
                ORDER BY f.function';

        return BaseQueries::performQuery($sql);
    }

    public function getDepartmentsBasedOnUserLevel($s_employee = null,
                                                   $ia_employee_id = null,
                                                   $ia_function_id = null,
                                                   $ia_department_id = null,
                                                   $b_is_boss = null,
                                                   $ia_boss_id = null) {
        // Nevenprofielen worden niet ondersteunt bij deze aanroep, alleen de hoofdprofielen
        $filter_function_ids = '';
        if (!empty($ia_function_id)) {
            if (is_array($ia_function_id)) {
                $filter_function_ids = ' AND e.ID_FID IN (' . implode(',', $ia_function_id) . ')';
            } else {
                $filter_function_ids = ' AND e.ID_FID = ' . $ia_function_id;
            }
        }

        $filter_department_ids = '';
        if (!empty($ia_department_id)) {
            if (is_array($ia_department_id)) {
                $filter_department_ids = ' AND e.ID_DEPTID IN (' . implode(',', $ia_department_id) . ')';
            } else {
                $filter_department_ids = ' AND e.ID_DEPTID = ' . $ia_department_id;
            }
        }

        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = 'SELECT
                        d.ID_DEPT,
                        d.department
                    FROM
                        department d
                        LEFT JOIN employees e
                            ON d.ID_DEPT = e.ID_DEPTID
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_department_ids . '
                        ' . $filter_function_ids . '
                    GROUP BY
                        d.ID_DEPT,
                        d.department
                    ORDER BY
                        d.department';
        } else {
            $employee_result = $this->getDataBasedOnUserLevel($s_employee,
                                                              $ia_employee_id,
                                                              $ia_function_id,
                                                              $ia_department_id,
                                                              $b_is_boss,
                                                              $ia_boss_id,
                                                              false,
                                                              null);

            $employees  = $this->getEmployeeIdsForResult($employee_result);
            // TODO: wat als er 0 employees zijn???
            $sql = 'SELECT
                        d.ID_DEPT,
                        d.department
                    FROM
                        department d
                        INNER JOIN employees e
                            ON e.ID_DEPTID = d.ID_DEPT
                    WHERE
                        e.id_e IN ('. implode(',', $employees) . ')
                        AND e.customer_id = ' . CUSTOMER_ID . '
                        ' . $filter_department_ids . '
                        ' . $filter_function_ids . '
                    GROUP BY
                        d.ID_DEPT,
                        d.department
                    ORDER BY
                        d.department';
        }

        return BaseQueries::performQuery($sql);
    }

}

?>