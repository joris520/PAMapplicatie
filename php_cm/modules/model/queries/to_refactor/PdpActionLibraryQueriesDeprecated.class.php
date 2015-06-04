<?php

/**
 * Description of PdpActionLibraryQueriesDeprecated
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');
require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');

class PdpActionLibraryQueriesDeprecated {

    static function getPdpActionClusters()
    {
        $sql = 'SELECT
                    ID_PDPAC,
                    cluster
                FROM
                    pdp_action_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                ORDER BY
                    cluster';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getPdpActionCluster($i_action_cluster_id)
    {
        $sql = 'SELECT
                    ID_PDPAC,
                    cluster
                FROM
                    pdp_action_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND ID_PDPAC = ' . $i_action_cluster_id;

        return BaseQueries::performSelectQuery($sql);
    }

    static function addEmployeePdpAction(   $i_id_e,
                                            $i_id_pdpaid,
                                            $i_id_pdptoid,
                                            $i_action_owner,
                                            $i_use_action_owner,
                                            $s_action,
                                            $i_provider,
                                            $s_duration,
                                            $s_costs,
                                            $i_user_defined,
                                            $i_is_completed,
                                            $s_start_date,
                                            $s_end_date,
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
                        is_user_defined,
                        is_completed,
                        start_date,
                        end_date,
                        notes,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_id_e . ',
                         ' . $i_id_pdpaid . ',
                         ' . BaseQueries::nullableValue($i_id_pdptoid) . ',
                         ' . BaseQueries::nullableValue($i_action_owner) . ',
                         ' . $i_use_action_owner . ',
                        "' . mysql_real_escape_string($s_action) . '",
                        "' . mysql_real_escape_string($i_provider) . '",
                        "' . mysql_real_escape_string($s_duration) . '",
                        "' . mysql_real_escape_string($s_costs) . '",
                         ' . $i_user_defined . ',
                         ' . $i_is_completed . ',
                        "' . mysql_real_escape_string($s_start_date) . '",
                        "' . mysql_real_escape_string($s_end_date) . '",
                        "' . mysql_real_escape_string($s_notes) . '",
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function addPdpActionAlert(  $i_id_pdptoid,
                                        $i_action_owner,
                                        $i_id_pdpea,
                                        $s_hash_id,
                                        $i_id_pd,
                                        $i_id_nm,
                                        $s_alert_date)
    {
        $sql = 'INSERT INTO
                    alerts
                    (   customer_id,
                        user_id,
                        action_owner,
                        ID_PDPEA,
                        hash_id,
                        ID_PD,
                        ID_NM,
                        is_level,
                        alert_date
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . BaseQueries::nullableValue($i_id_pdptoid) . ',
                         ' . BaseQueries::nullableValue($i_action_owner) . ',
                         ' . $i_id_pdpea . ',
                        "' . $s_hash_id . '",
                         ' . $i_id_pd . ',
                         ' . $i_id_nm . ',
                         ' . ALERT_PDPACTION . ',
                        "' . mysql_real_escape_string($s_alert_date) . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function addPdpActionTask(   $i_id_pdpea,
                                        $i_id_e,
                                        $i_id_pdpto,
                                        $s_task,
                                        $s_notes,
                                        $s_start_date,
                                        $s_end_date,
                                        $i_is_completed)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'INSERT INTO
                    employees_pdp_tasks
                    (
                        customer_id,
                        ID_PDPEA,
                        ID_E,
                        ID_PDPTO,
                        task,
                        notes,
                        start_date,
                        end_date,
                        is_completed,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_id_pdpea . ',
                         ' . $i_id_e . ',
                         ' . $i_id_pdpto . ',
                        "' . mysql_real_escape_string($s_task) . '",
                        "' . mysql_real_escape_string($s_notes) . '",
                        "' . mysql_real_escape_string($s_start_date) . '",
                        "' . mysql_real_escape_string($s_end_date) . '",
                         ' . $i_is_completed . ',
                        "' . $modified_by_user . '",
                        "' . $modified_time . '",
                        "' . $modified_date . '"

                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function addPdpActionTaskAlert(  $i_id_pdpto,
                                            $s_hash_id,
                                            $i_id_pdpet,
                                            $i_id_pd,
                                            $i_id_nm,
                                            $s_alert_date)
    {
        $sql = 'INSERT INTO
                    alerts
                    (
                        customer_id,
                        ID_PDPTO,
                        hash_id,
                        ID_PDPET,
                        ID_PD,
                        ID_NM,
                        is_level,
                        alert_date
                    ) values (
                         ' . CUSTOMER_ID . ',
                         ' . $i_id_pdpto . ',
                        "' . $s_hash_id . '",
                         ' . $i_id_pdpet . ',
                         ' . $i_id_pd . ',
                         ' . $i_id_nm . ',
                        ' . ALERT_PDPACTIONTASK . ',
                        "' . mysql_real_escape_string($s_alert_date) . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function addPdpActionCluster($s_cluster_name)
    {
        $sql = 'INSERT INTO
                    pdp_action_cluster
                    (   customer_id,
                        cluster
                    ) VALUES (
                       ' . CUSTOMER_ID . ',
                      "'. mysql_real_escape_string($s_cluster_name) . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function updatePdpActionCluster($i_cluster_id, $s_cluster_name)
    {
        $sql = 'UPDATE
                    pdp_action_cluster
                SET
                    cluster = "'. mysql_real_escape_string($s_cluster_name) . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND ID_PDPAC =' . $i_cluster_id;


        return BaseQueries::performUpdateQuery($sql);
    }

    static function findExistingPdpActionCluster($s_cluster_name, $i_exclude_cluster_id)
    {
        $not_self = empty($i_cluster_id) ? '' : ' AND ID_PDPAC <> ' . $i_exclude_cluster_id;
        $sql = 'SELECT
                    ID_PDPAC
                FROM
                    pdp_action_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND cluster LIKE "' . mysql_real_escape_string($s_cluster_name) . '"' .
                    $not_self;

        return BaseQueries::performSelectQuery($sql);
    }

    static function getPdpActions()
    {
        $sql = 'SELECT
                    *
                FROM
                    pdp_actions pa
                WHERE
                    pa.customer_id = ' . CUSTOMER_ID . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                ORDER BY
                    pa.action';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getClusteredPdpActions()
    {
        $sql = 'SELECT
                    pac.cluster,
                    pa.*
                FROM
                    pdp_actions pa
                    INNER JOIN pdp_action_cluster pac
                        ON pa.ID_PDPAC = pac.ID_PDPAC
                WHERE
                    pa.customer_id = ' . CUSTOMER_ID . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                ORDER BY
                    pac.cluster,
                    action';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getPdpActionsByCluster($i_cluster_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    pdp_actions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND ID_PDPAC = ' . $i_cluster_id ;

        return BaseQueries::performSelectQuery($sql);
    }

    static function getPdpAction($i_pdp_action_id)
    {
        $sql = 'SELECT
                    pa.*,
                    pac.cluster
                FROM
                    pdp_actions pa
                    INNER JOIN pdp_action_cluster pac
                        ON pa.ID_PDPAC = pac.ID_PDPAC
                WHERE
                    pa.customer_id = ' . CUSTOMER_ID . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND pa.ID_PDPA = ' . $i_pdp_action_id;

        return BaseQueries::performSelectQuery($sql);
    }

    static function deletePdpActionCluster($i_cluster_id)
    {
        $sql = 'DELETE
                FROM
                    pdp_action_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
                    AND ID_PDPAC = ' . $i_cluster_id ;

        return BaseQueries::performDeleteQuery($sql);
    }

    ///////////// DIT HOORT IN ActionQueries.class.php of in EmployeePdpActionQueriesDeprecated.class.php
    //**************************************************************************
    // hbd: TODO: dit (de logica van het ophalen van de employees) mag niet zo,
    // moet in object gebeuren!
    static function getPDPActionTaskNotifcationMessageAlerts($i_owner_id = null) {
        $allowed_employees_result = EmployeesQueries::getEmployeesBasedOnUserLevel();

        $allowed_employees = array();
        while ($allowed_employees_row = @mysql_fetch_assoc($allowed_employees_result)) {
            $allowed_employees[] = $allowed_employees_row['ID_E'];
        }

        $filter_allowed_employees = implode(',', $allowed_employees);

        $filter_owner = '';
        if (!empty($i_owner_id) && is_integer($i_owner_id)) {
            $filter_owner = ' AND pto.ID_PDPTO = ' . $i_owner_id;
        }

        $sql = 'SELECT
                    ept.task,
                    e.employee,
                    pd.email,
                    pto.name,
                    a.alert_date,
                    a.sent_email,
                    a.is_done,
                    a.is_confirmed
                FROM
                    employees_pdp_tasks ept
                    LEFT JOIN employees e
                        ON e.ID_E = ept.ID_E
                    LEFT JOIN pdp_task_ownership pto
                        ON pto.ID_PDPTO = ept.ID_PDPTO
                    LEFT JOIN alerts a
                        ON a.ID_PDPET = ept.ID_PDPET
                    LEFT JOIN person_data pd on pd.ID_PD = a.ID_PD
                WHERE
                    a.is_level = ' . ALERT_PDPACTIONTASK . '
                    AND a.customer_id = ' . CUSTOMER_ID . '
                    AND ept.id_e IN (' . $filter_allowed_employees . ')
                    ' . $filter_owner;

        return BaseQueries::performSelectQuery($sql);
    }

    //**************************************************************************
    // hbd: TODO: dit (de logica van het ophalen van de employees) mag niet zo,
    // moet in object gebeuren!
    static function getPDPActionNotifcationMessageAlerts($i_owner_id = null) {
        $allowed_employees_result = EmployeesQueries::getEmployeesBasedOnUserLevel();

        $allowed_employees = array();
        while ($allowed_employees_row = @mysql_fetch_assoc($allowed_employees_result)) {
            $allowed_employees[] = $allowed_employees_row['ID_E'];
        }

        $filter_allowed_employees = implode(',', $allowed_employees);

        $filter_owner = '';
        if (!empty($i_owner_id) && is_integer($i_owner_id)) {
            $filter_owner = ' AND u.user_id = ' . $i_owner_id;
        }

        $sql = 'SELECT
                    pa.action,
                    e.employee,
                    pd.email,
                    u.name,
                    a.alert_date,
                    a.sent_email,
                    a.is_done,
                    a.is_confirmed
                FROM
                    employees_pdp_actions epa
                    LEFT JOIN employees e
                        ON e.ID_E = epa.ID_E
                    LEFT JOIN pdp_actions pa
                        ON pa.ID_PDPA = epa.ID_PDPAID
                    LEFT JOIN users u
                        ON u.user_id = epa.ID_PDPTOID
                    INNER JOIN alerts a
                        ON a.ID_PDPEA = epa.ID_PDPEA
                    INNER JOIN person_data pd
                        ON pd.ID_pd = a.ID_PD
                WHERE
                    a.is_level = ' . ALERT_PDPACTION . '
                    AND a.customer_id = ' . CUSTOMER_ID . '
                    AND epa.id_e IN (' . $filter_allowed_employees . ')
                    ' . $filter_owner ;
        return BaseQueries::performSelectQuery($sql);
    }

    //**************************************************************************
    // hbd: TODO: dit (de logica van het ophalen van de employees) mag niet zo,
    // moet in object gebeuren!
    static function getPDPActionOwners() {
        $allowed_employees_result = EmployeesQueries::getEmployeesBasedOnUserLevel();

        $allowed_employees = array();
        while ($allowed_employees_row = @mysql_fetch_assoc($allowed_employees_result)) {
            $allowed_employees[] = $allowed_employees_row['ID_E'];
        }

        $filter_allowed_employees = implode(',', $allowed_employees);

        $sql = 'SELECT
                    u.user_id,
                    u.name
                FROM
                    employees_pdp_actions epa
                    LEFT JOIN users u
                        ON u.user_id = epa.ID_PDPTOID
                    INNER JOIN alerts a
                        ON a.ID_PDPEA = epa.ID_PDPEA
                WHERE
                    a.is_level = ' . ALERT_PDPACTION . '
                    AND a.customer_id= ' . CUSTOMER_ID . '
                    AND epa.id_e IN (' . $filter_allowed_employees . ')
                GROUP BY
                    u.name';

        return BaseQueries::performSelectQuery($sql);
    }

    //**************************************************************************
    // hbd: TODO: dit (de logica van het ophalen van de employees) mag niet zo,
    // moet in object gebeuren!
    static function getPDPActionTaskOwners() {
        $allowed_employees_result = EmployeesQueries::getEmployeesBasedOnUserLevel();

        $allowed_employees = array();
        while ($allowed_employees_row = @mysql_fetch_assoc($allowed_employees_result)) {
            $allowed_employees[] = $allowed_employees_row['ID_E'];
        }

        $filter_allowed_employees = implode(',', $allowed_employees);

        $sql = 'SELECT
                    pto.ID_PDPTO,
                    pto.name
                FROM
                    employees_pdp_tasks ept
                    LEFT JOIN pdp_task_ownership pto
                        ON pto.ID_PDPTO = ept.ID_PDPTO
                    LEFT JOIN alerts a
                        ON a.ID_PDPET = ept.ID_PDPET
                WHERE
                    a.is_level = ' . ALERT_PDPACTIONTASK . '
                    AND a.customer_id = ' . CUSTOMER_ID . '
                    AND ept.id_e IN (' . $filter_allowed_employees . ')
                GROUP BY
                    pto.name';

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
