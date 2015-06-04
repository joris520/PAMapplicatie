<?php

/**
 * Description of AlertQueries
 *
 * @author ben.dokter
 */

require_once('application/model/value/databaseValueConsts.inc.php');

class AlertQueries {

    static function getOpenAlertsAsSender($i_employee_id)
    {
        $sql = 'SELECT
                    e.ID_E,
                    COUNT(*) alert_count
                FROM
                    alerts a
                    INNER JOIN employees e
                        ON e.ID_PD = a.ID_PD
                           AND e.ID_E = ' . $i_employee_id . '
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND a.is_done = ' . ALERT_OPEN . '
                GROUP BY
                    e.ID_E';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getNotificationMessages()
    {
        $sql = 'SELECT
                    *
                FROM
                    notification_message
                WHERE
                    customer_id  = ' . CUSTOMER_ID . '
                ORDER BY
                    ID_NM';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertPdpActionAlert($i_employeePdpActionId,
                                         $i_actionOwnerEmployeeId,
                                         $i_personDataId,
                                         $i_alertMessageId,
                                         $s_notificationDate)
    {
        $sql = 'INSERT INTO
                    alerts
                    (   customer_id,
                        action_owner,
                        ID_PDPEA,
                        ID_PD,
                        ID_NM,
                        is_level,
                        alert_date
                    ) values (
                        ' . CUSTOMER_ID . ',
                        ' . $i_actionOwnerEmployeeId . ',
                        ' . $i_employeePdpActionId . ',
                        ' . $i_personDataId . ',
                        ' . $i_alertMessageId . ',
                        ' . ALERT_PDPACTION_EMPLOYEE . ',
                        "' . $s_notificationDate . '"
                    )';

        return BaseQueries::performInsertQuery($sql);
    }


    static function deletePdpActionTaskAlerts($i_employee_id, $i_pdpAction_id)
    {
        // TODO: met inner join?
        // check ook met employees_pdp_tasks?
        $sql = 'DELETE
                FROM
                    alerts
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_level = ' . ALERT_PDPACTIONTASK . '
                    AND ID_PDPET IN
                        (   SELECT
                                ID_PDPET ept
                            FROM
                                employees_pdp_tasks ept
                            WHERE
                                ept.customer_id = ' . CUSTOMER_ID . '
                                AND ept.ID_E = ' . $i_employee_id .  '
                                AND ept.ID_PDPEA = ' . $i_pdpAction_id . '
                        )';

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }


    static function deletePdpActionTaskAlert($i_pdpActionTask_id)
    {
        // TODO: met inner join?
        // check ook met employees_pdp_tasks?
        $sql = 'DELETE
                FROM
                    alerts
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_level = ' . ALERT_PDPACTIONTASK . '
                    AND ID_PDPET = ' . $i_pdpActionTask_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function deletePdpActionAlerts($i_pdpAction_id)
    {
        // TODO: met inner join op employees_pdp_actions?
        $sql = 'DELETE
                FROM
                    alerts
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND (is_level = ' . ALERT_PDPACTION . '
                         OR is_level = ' . ALERT_PDPACTION_EMPLOYEE . ')
                    AND ID_PDPEA = ' . $i_pdpAction_id;

        $sql_result = BaseQueries::performQuery($sql);
        return @mysql_affected_rows($sql_result);
    }

    static function activateCancelledPdpActionAlert($i_pdpAction_id)
    {
        $sql = 'UPDATE
                    alerts
                SET
                    is_done = ' . ALERT_OPEN . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_done = ' . ALERT_CANCELLED . '
                    AND (is_level = ' . ALERT_PDPACTION . '
                         OR is_level = ' . ALERT_PDPACTION_EMPLOYEE . ')
                    AND ID_PDPEA = ' . $i_pdpAction_id .'
                LIMIT 1';

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function deactivateOpenPdpActionAlert($i_pdpAction_id)
    {
        $sql = 'UPDATE
                    alerts
                SET
                    is_done = ' . ALERT_CANCELLED . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_done = ' . ALERT_OPEN . '
                    AND (is_level = ' . ALERT_PDPACTION . '
                         OR is_level = ' . ALERT_PDPACTION_EMPLOYEE . ')
                    AND ID_PDPEA = ' . $i_pdpAction_id .'
                LIMIT 1';

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function activateCancelledPdpActionTaskAlert($i_pdpActionTask_id)
    {
        $sql = 'UPDATE
                    alerts
                SET
                    is_done = ' . ALERT_OPEN . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_done = ' . ALERT_CANCELLED . '
                    AND is_level = ' . ALERT_PDPACTIONTASK . '
                    AND ID_PDPET = ' . $i_pdpActionTask_id .'
                LIMIT 1';

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

    static function deactivateOpenPdpActionTaskAlert($i_pdpActionTask_id)
    {
        $sql = 'UPDATE
                    alerts
                SET
                    is_done = ' . ALERT_CANCELLED . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND is_done = ' . ALERT_OPEN . '
                    AND is_level = ' . ALERT_PDPACTIONTASK . '
                    AND ID_PDPET = ' . $i_pdpActionTask_id .'
                LIMIT 1';

        BaseQueries::performQuery($sql);
        return @mysql_affected_rows();

    }

}

?>
