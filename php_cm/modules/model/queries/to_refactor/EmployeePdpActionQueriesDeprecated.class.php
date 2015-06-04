<?php
/**
 * Description of EmployeePdpActionQueriesDeprecated
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');

class EmployeePdpActionQueriesDeprecated {

    static function getEmployeePdpActions($i_employee_id)
    {
        // enddate in de toekomst onderaan;
        // dit verklaart ook de af en toe rare volgorde??
        // extra veld toegevoegd om snel te kunnen zien of een actie actueel is of in de toekomst ligt
        $sql = 'SELECT
                    epa.*,
                    STR_TO_DATE(epa.end_date, "%d-%m-%Y") as pdp_end_date,
                    STR_TO_DATE(epa.start_date, "%d-%m-%Y") as pdp_email_date,
                    CASE
                        WHEN use_action_owner = ' . PDP_ACTION_OWNER_EMPLOYEE . '
                        THEN e.employee
                        ELSE u.name
                    END as action_owner_name,
                    count(ept.ID_PDPET) as number_of_tasks,
                    CASE
                        WHEN (STR_TO_DATE(epa.end_date, "%d-%m-%Y") >= CURRENT_DATE)
                        THEN 1
                        ELSE 0
                    END as action_in_future
                FROM
                    employees_pdp_actions epa
                    LEFT JOIN employees_pdp_tasks ept
                        ON ept.ID_PDPEA = epa.ID_PDPEA
                    LEFT JOIN employees e
                        on e.ID_E = epa.action_owner
                    LEFT JOIN users u
                        on u.user_id = epa.ID_PDPTOID
                WHERE
                    epa.customer_id = ' . CUSTOMER_ID . '
                    AND epa.ID_E = ' . $i_employee_id .  '
                GROUP BY
                    epa.ID_PDPEA
                ORDER BY
                    CASE
                        WHEN (STR_TO_DATE(epa.end_date, "%d-%m-%Y") >= CURRENT_DATE)
                        THEN 0
                        ELSE 1
                    END,
                    STR_TO_DATE(epa.end_date, "%d-%m-%Y") DESC,
                    epa.ID_PDPEA DESC'; // volgorde van invoer meenemen bij gelijke datums

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEmployeePdpAction($i_employee_id, $i_pdpAction_id)
    {
        // extra veld toegevoegd om snel te kunnen zien of een actie actueel is of in de toekomst ligt
        $sql = 'SELECT
                    epa.*,
                    CASE
                        WHEN use_action_owner = ' . PDP_ACTION_OWNER_EMPLOYEE . '
                        THEN e.employee
                        ELSE u.name
                    END as actionowner,
                    CASE
                        WHEN use_action_owner = ' . PDP_ACTION_OWNER_EMPLOYEE . '
                        THEN e.employee
                        ELSE u.name
                    END as action_owner_name,
                    CASE
                        WHEN (STR_TO_DATE(epa.end_date, "%d-%m-%Y") >= CURRENT_DATE)
                        THEN 1
                        ELSE 0
                    END as action_in_future
                FROM
                    employees_pdp_actions epa
                    LEFT JOIN employees e
                        on e.ID_E = epa.action_owner
                    LEFT JOIN users u
                        on u.user_id = epa.ID_PDPTOID
                WHERE
                    epa.customer_id = ' . CUSTOMER_ID . '
                    AND epa.ID_E = ' . $i_employee_id .  '
                    AND epa.ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function getEmployeePdpActionTasks($i_employee_id, $i_pdpAction_id)
    {
        // TODO: inner joinen met epa ?
        $sql = 'SELECT
                    ept.*,
                    pto.name as taskowner
                FROM
                    employees_pdp_tasks ept
                    LEFT JOIN pdp_task_ownership pto
                        ON ept.ID_PDPTO = pto.ID_PDPTO
                WHERE
                    ept.customer_id = ' . CUSTOMER_ID . '
                    AND ept.ID_E = ' . $i_employee_id .  '
                    AND ept.ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function deletePdpActionTasks($i_employee_id, $i_pdpAction_id)
    {
        $sql = 'DELETE
                FROM
                    employees_pdp_tasks
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id .  '
                    AND ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function getEmployeePdpActionTaskState($i_employee_id, $i_pdpActionTask_id)
    {
        $sql = 'SELECT
                    ept.is_completed
                FROM
                    employees_pdp_tasks ept
                WHERE
                    ept.customer_id = ' . CUSTOMER_ID . '
                    AND ept.ID_E = ' . $i_employee_id .  '
                    AND ept.ID_PDPET = ' . $i_pdpActionTask_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function updateEmployeePdpActionTaskState($i_employee_id, $i_pdpActionTask_id, $i_pdpActionTaskState)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_pdp_tasks
                set
                    is_completed = ' . $i_pdpActionTaskState . ',
                    modified_by_user     = "' . $modified_by_user . '",
                    modified_time        = "' . $modified_time . '",
                    modified_date        = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id .  '
                    AND ID_PDPET = ' . $i_pdpActionTask_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function deletePdpActionTask($i_employee_id, $i_pdpAction_id, $i_pdpActionTask_id)
    {
        $sql = 'DELETE
                FROM
                    employees_pdp_tasks
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id .  '
                    AND ID_PDPEA = ' . $i_pdpAction_id . '
                    AND ID_PDPET = ' . $i_pdpActionTask_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function deletePdpAction($i_employee_id, $i_pdpAction_id)
    {
        $sql = 'DELETE
                FROM
                    employees_pdp_actions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id .  '
                    AND ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }


    static function getEmployeePdpActionState($i_employee_id, $i_pdpAction_id)
    {
        $sql = 'SELECT
                    epa.is_completed
                FROM
                    employees_pdp_actions epa
                WHERE
                    epa.customer_id = ' . CUSTOMER_ID . '
                    AND epa.ID_E = ' . $i_employee_id .  '
                    AND epa.ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function updateEmployeePdpActionState($i_employee_id, $i_pdpAction_id, $i_pdpActionState)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_pdp_actions
                set
                    is_completed = ' . $i_pdpActionState . ',
                    modified_by_user     = "' . $modified_by_user . '",
                    modified_time        = "' . $modified_time . '",
                    modified_date        = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id .  '
                    AND ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function addEmployeePdpAction($i_employee_id,
                                         $i_pdpActionLibraryId,
                                         $i_actionOwnerEmployeeId,
                                         $s_action,
                                         $s_provider,
                                         $s_duration,
                                         $f_costs,
                                         $i_is_completed,
                                         $s_deadline_date,
                                         $s_notification_date,
                                         $s_notes)

    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;


        $sql = 'INSERT INTO
                    employees_pdp_actions
                    (   customer_id,
                        ID_E,
                        ID_PDPAID,
                        ID_PDPTOID,
                        action_owner,
                        use_action_owner,
                        action,
                        provider,
                        duration,
                        costs,
                        is_completed,
                        start_date,
                        end_date,
                        notes,
                        modified_by_user,
                        modified_time,
                        modified_date
                    )  VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_employee_id . ',
                         ' . $i_pdpActionLibraryId . ',
                         NULL,
                         ' . $i_actionOwnerEmployeeId . ',
                         ' . PDP_ACTION_OWNER_EMPLOYEE. ',
                        "' . mysql_real_escape_string($s_action) . '",
                        "' . mysql_real_escape_string($s_provider) . '",
                        "' . mysql_real_escape_string($s_duration) . '",
                         ' . mysql_real_escape_string($f_costs) . ',
                         ' . $i_is_completed . ',
                        "' . mysql_real_escape_string($s_notification_date) . '",
                        "' . mysql_real_escape_string($s_deadline_date) . '",
                        "' . mysql_real_escape_string($s_notes) . '",
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }


    static function updateEmployeePdpAction($i_employee_id,
                                            $i_employeePdpActionId,
                                            $i_pdpActionLibraryId,
                                            $i_actionOwnerEmployeeId,
                                            $s_action,
                                            $s_provider,
                                            $s_duration,
                                            $f_costs,
                                            $s_deadline_date,
                                            $s_notification_date,
                                            $s_notes)

    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_pdp_actions
                SET
                    ID_PDPAID = ' . $i_pdpActionLibraryId . ',
                    ID_PDPTOID = NULL,
                    action_owner = ' . $i_actionOwnerEmployeeId . ',
                    use_action_owner = ' . PDP_ACTION_OWNER_EMPLOYEE . ',
                    action = "' . mysql_real_escape_string($s_action) . '",
                    provider = "' . mysql_real_escape_string($s_provider) . '",
                    duration = "' . mysql_real_escape_string($s_duration) . '",
                    costs = ' . mysql_real_escape_string($f_costs) . ',
                    start_date = "' . mysql_real_escape_string($s_notification_date) . '",
                    end_date = "' . mysql_real_escape_string($s_deadline_date) . '",
                    notes = "' . mysql_real_escape_string($s_notes) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_PDPEA = ' . $i_employeePdpActionId . '
                    AND ID_E = ' . $i_employee_id;

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();
    }



    static function getEmployeePdpActionCompetences($i_employee_id, $i_employeePdpActionId)
    {
        $sql = 'SELECT
                    ID_KSP_FID as competence_id
                FROM
                    employees_pdp_actions_skill_points
                WHERE
                    ID_E_FID = ' . $i_employee_id . '
                    AND ID_PDPEA_FID = ' . $i_employeePdpActionId;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function insertEmployeePdpActionCompetence($i_employee_id, $i_employeePdpActionId, $i_selectedCompetenceId)
    {
        $sql = 'INSERT INTO
                    employees_pdp_actions_skill_points
                    (   ID_E_FID,
                        ID_PDPEA_FID,
                        ID_KSP_FID
                    ) VALUES (
                        ' . $i_employee_id . ',
                        ' . $i_employeePdpActionId . ',
                        ' . $i_selectedCompetenceId . '
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();
    }

    static function deleteEmployeePdpActionCompetences($i_employee_id, $i_employeePdpActionId)
    {
        $sql = 'DELETE
                FROM
                    employees_pdp_actions_skill_points
                WHERE
                    ID_E_FID = ' . $i_employee_id . '
                    AND ID_PDPEA_FID = ' . $i_employeePdpActionId;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

}

?>
