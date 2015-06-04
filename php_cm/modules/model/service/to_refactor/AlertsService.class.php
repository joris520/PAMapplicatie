<?php

/**
 * Description of Alerts
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/to_refactor/AlertQueries.class.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');

class AlertsService {

    static function checkHashExistence($s_hash_id, $destination_table)
    {
        $sql = 'SELECT
                    hash_id
                FROM
                    ' . $destination_table . '
                WHERE
                    hash_id = "' . mysql_real_escape_string($s_hash_id) . '"';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function hasOpenAlertsAsSender($employee_id)
    {
        $alertInfo = @mysql_fetch_assoc(AlertQueries::getOpenAlertsAsSender($employee_id));
        return ($alertInfo['alert_count'] > 0);
    }

    static function getPdpActionNotificationMessageId()
    {
        $firstNotificationMessageIsAlertMessage = @mysql_fetch_assoc(AlertQueries::getNotificationMessages());
        return $firstNotificationMessageIsAlertMessage['ID_NM'];
    }

    static function insertPdpActionAlert($employeePdpActionId,
                                         $actionOwnerEmployeeId,
                                         $personDataId,
                                         $alertMessageId,
                                         $notificationDate)
    {
        return AlertQueries::insertPdpActionAlert($employeePdpActionId,
                                                  $actionOwnerEmployeeId,
                                                  $personDataId,
                                                  $alertMessageId,
                                                  $notificationDate);
    }
    static function updatePdpActionAlert($employeePdpActionId,
                                         $actionOwnerEmployeeId,
                                         $personDataId,
                                         $alertMessageId,
                                         $notificationDate)
    {
        $alertId = NULL;
        AlertQueries::deletePdpActionAlerts($employeePdpActionId);
        if (!empty($notificationDate)) {

            $alertId = AlertQueries::insertPdpActionAlert($employeePdpActionId,
                                                          $actionOwnerEmployeeId,
                                                          $personDataId,
                                                          $alertMessageId,
                                                          $notificationDate);
        }
        return $alertId;
    }

    static function deletePdpActionAlerts($pdpAction_id)
    {
        return AlertQueries::deletePdpActionAlerts($pdpAction_id);
    }

    static function deletePdpActionAlert($pdpAction_id)
    {
        return AlertQueries::deletePdpActionAlert($pdpAction_id);
    }

    static function deletePdpActionTaskAlerts($employee_id, $pdpAction_id)
    {
        return AlertQueries::deletePdpActionTaskAlerts($employee_id, $pdpAction_id);
    }

    static function deletePdpActionTaskAlert($pdpActionTask_id)
    {
        return AlertQueries::deletePdpActionTaskAlert($pdpActionTask_id);
    }

    static function activateCancelledPdpActionAlert($pdpAction_id)
    {
        return AlertQueries::activateCancelledPdpActionAlert($pdpAction_id);
    }

    static function deactivateOpenPdpActionAlert($pdpAction_id)
    {
        return AlertQueries::deactivateOpenPdpActionAlert($pdpAction_id);
    }

    static function activateCancelledPdpActionTaskAlert($pdpActionTask_id)
    {
        return AlertQueries::activateCancelledPdpActionTaskAlert($pdpActionTask_id);
    }

    static function deactivateOpenPdpActionTaskAlert($pdpActionTask_id)
    {
        return AlertQueries::deactivateOpenPdpActionTaskAlert($pdpActionTask_id);
    }
}

?>
