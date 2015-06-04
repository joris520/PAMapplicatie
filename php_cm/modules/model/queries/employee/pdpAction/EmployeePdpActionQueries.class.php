<?php

/**
 * Description of EmployeePdpActionQueries
 *
 * @author ben.dokter
 */

class EmployeePdpActionQueries
{
    const ID_FIELD              = 'ID_PDPEA';
    const PDP_ACTION_ID_FIELD   = 'ID_PDPAID';

    static function getEmployeePdpActions($i_employeeId,
                                          $i_employeePdpActionId = NULL)
    {
        $sql_filterEmployeePdpAction = empty($i_employeePdpActionId) ? '' : 'AND ID_PDPEA = ' . $i_employeePdpActionId;

        $sql = 'SELECT
                epa.*,
                STR_TO_DATE(epa.end_date, "%d-%m-%Y") as pdp_end_date,
                STR_TO_DATE(epa.start_date, "%d-%m-%Y") as pdp_email_date,
                CASE
                    WHEN epa.use_action_owner = ' . PDP_ACTION_OWNER_EMPLOYEE . '
                    THEN e.employee
                    ELSE u.name
                END as action_owner_name
            FROM
                employees_pdp_actions epa
                LEFT JOIN employees e
                    on e.ID_E = epa.action_owner
                LEFT JOIN users u
                    on u.user_id = epa.ID_PDPTOID
            WHERE
                epa.customer_id = ' . CUSTOMER_ID . '
                AND epa.ID_E = ' . $i_employeeId .  '
                ' . $sql_filterEmployeePdpAction . '
            GROUP BY
                epa.ID_PDPEA
            ORDER BY
                STR_TO_DATE(epa.end_date, "%d-%m-%Y") ASC,
                epa.action';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateExistingEmployeePdpActions(   $i_pdpActionId,
                                                        $s_actionName,
                                                        $s_provider,
                                                        $s_duration,
                                                        $s_cost)
    {
        $sql = 'UPDATE
                    employees_pdp_actions
                SET
                    action   = "' . mysql_real_escape_string($s_actionName) . '",
                    provider = "' . mysql_real_escape_string($s_provider) . '",
                    duration = "' . mysql_real_escape_string($s_duration) . '",
                    costs    = "' . mysql_real_escape_string($s_cost) . '"
                WHERE
                    customer_id         = ' . CUSTOMER_ID . '
                    AND ID_PDPAID       = ' . $i_pdpActionId . '
                    AND is_user_defined = ' . PDP_ACTION_FROM_LIBRARY;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function updateUserDefinedPdpAction( $i_employeeId,
                                                $i_employeePdpActionId,
                                                $i_pdpActionId,
                                                $i_isUserDefined,
                                                $s_actionName,
                                                $s_provider,
                                                $s_duration,
                                                $s_cost)
    {
        $sql = 'UPDATE
                    employees_pdp_actions
                SET
                    ID_PDPAID       = ' . $i_pdpActionId . ',
                    is_user_defined = ' . $i_isUserDefined . ',
                    action          = "' . mysql_real_escape_string($s_actionName) . '",
                    provider        = "' . mysql_real_escape_string($s_provider) . '",
                    duration        = "' . mysql_real_escape_string($s_duration) . '",
                    costs           = "' . mysql_real_escape_string($s_cost) . '"
                WHERE
                    customer_id  = ' . CUSTOMER_ID . '
                    AND ID_E     = ' . $i_employeeId . '
                    AND ID_PDPEA = ' . $i_employeePdpActionId;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function findEmployees(  $i_pdpActionId,
                                    $a_allowedEmployeeIds)
    {
        $sqlFilter = (!empty($a_allowedEmployeeIds)) ? 'AND e.ID_E ' . (is_array($a_allowedEmployeeIds) ? 'in (' . implode(',',$a_allowedEmployeeIds) . ')' : '= '.$a_allowedEmployeeIds) : '';

        $sql = 'SELECT
                    e.*,
                    count(epa.ID_PDPEA) as pdp_action_count
                FROM
                    employees e
                    INNER JOIN employees_pdp_actions epa
                        ON epa.ID_E = e.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                   ' . $sqlFilter . '
                    AND ID_PDPAID       = ' . $i_pdpActionId . '
                    -- AND is_user_defined = ' . PDP_ACTION_FROM_LIBRARY . '
                GROUP BY
                    e.ID_E
                ORDER BY
                    e.lastname,
                    e.firstname';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getUserDefinedPdpActions($as_allowedEmployeeIds,
                                             $i_employeePdpActionId = NULL)
    {
        $sqlEmployeeFilter          = (!empty($as_allowedEmployeeIds)) ? 'AND epa.ID_E ' . (is_array($as_allowedEmployeeIds) ? 'in (' . implode(',',$as_allowedEmployeeIds) . ')' : '= ' .$as_allowedEmployeeIds) : '';
        $sqlEmployeePdpActionFilter = (!empty($i_employeePdpActionId)) ? 'AND epa.ID_PDPEA = '. $i_employeePdpActionId : '';

        $sql = 'SELECT
                    epa.ID_PDPEA,
                    epa.ID_E,
                    epa.ID_PDPAID,
                    epa.end_date,
                    epa.is_completed,
                    epa.action   as user_action,
                    epa.action   as user_action,
                    epa.provider as user_provider,
                    epa.duration as user_duration,
                    epa.costs    as user_costs,
                    pa.ID_PDPA,
                    pa.action,
                    pa.provider,
                    pa.duration,
                    pa.costs,
                    pa.is_customer_library,
                    e.ID_E,
                    e.firstname as employee_first_name,
                    e.lastname  as employee_last_name,
                    d.department,
                    b.firstname as boss_first_name,
                    b.lastname  as boss_last_name
                FROM
                    employees_pdp_actions epa
                    INNER JOIN pdp_actions pa
                        ON pa.ID_PDPA = epa.ID_PDPAID
                    INNER JOIN employees e
                        ON e.ID_E = epa.ID_E
                    INNER JOIN department d
                        on e.ID_DEPTID = d.ID_DEPT
                    LEFT JOIN employees b
                        ON b.ID_E = e.boss_fid
                WHERE
                    epa.customer_id = ' . CUSTOMER_ID . '
                   ' . $sqlEmployeeFilter . '
                   ' . $sqlEmployeePdpActionFilter . '
                    AND epa.is_user_defined = ' . PDP_ACTION_USER_DEFINED . '
                ORDER BY
                    pa.is_customer_library desc,
                    epa.action,
                    epa.ID_PDPAID';

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
