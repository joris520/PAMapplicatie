<?php

require_once('modules/process/library/PdpActionInterfaceProcessor.class.php');

function public_library__displayPdpActions()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayView($objResponse);
    }
    return $objResponse;
}

function public_library__addPdpAction()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayAdd($objResponse);
    }
    return $objResponse;
}

function public_library__editPdpAction($pdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) ) {
        PdpActionInterfaceProcessor::displayEdit(   $objResponse,
                                                    $pdpActionId);
    }
    return $objResponse;
}

function public_library__removePdpAction($pdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayRemove( $objResponse,
                                                    $pdpActionId);
    }
    return $objResponse;
}

function public_library__detailPdpActionEmployees($pdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayDetailEmployees($objResponse,
                                                            $pdpActionId);
    }
    return $objResponse;
}

function public_library__editPdpActionCluster($clusterId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) ) {
        PdpActionInterfaceProcessor::displayEditCluster($objResponse,
                                                        $clusterId);
    }
    return $objResponse;
}

function public_library__removePdpActionCluster($clusterId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayRemoveCluster(  $objResponse,
                                                            $clusterId);
    }
    return $objResponse;
}

function public_library__printPdpActions()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayPrint($objResponse);
    }
    return $objResponse;
}

function public_library__editUserDefinedEmployeePdpAction(  $employeeId,
                                                            $employeePdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        PdpActionInterfaceProcessor::displayEditUserDefined(    $objResponse,
                                                                $employeeId,
                                                                $employeePdpActionId);
    }
    return $objResponse;
}

//////////////////////////////////////////////////////////////////////////////////////////////////////////////
// eerst overgenomen uit employees_pdpactions_deprecated.php
function moduleEmployees_clearNotificationDate_deprecated() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
        InterfaceXajax::setValue($objResponse, 'start_date', '');
        InterfaceXajax::setHtml($objResponse, 'ne', getEmailsForNotificationHtml('', '')); // reset selectie.
        // mooier is helemaal weghalen, maar dan moet de selector teruggezet worden als er weer een datum ingevuld wordt.
        //InterfaceXajax::setHtml($objResponse, 'ne', ''); // helemaal weghalen
    }
    return $objResponse;
}

function prefill_pdp_action_deprecated($id_pdpaid)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
        $sql = 'SELECT
                    *
                FROM
                    pdp_actions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_PDPA = ' . $id_pdpaid;
        //die($sql);
        $query = BaseQueries::performQuery($sql);
        $getpa = mysql_fetch_assoc($query);
//        $cluster_id = $getpa['ID_PDPAC'];
//        $objResponse->assign('fill_cluster', 'innerHTML', getClusterSelect($cluster_id));
        $objResponse->assign('fill_action',     'value', $getpa['action']);
        $objResponse->assign('fill_provider',   'value', $getpa['provider']);
        $objResponse->assign('fill_duration',   'value', $getpa['duration']);
        $objResponse->assign('fill_cost',       'value', PdpCostConverter::input($getpa['costs']));
        $objResponse->assign('hidden_action',     'value', $getpa['action']);
        $objResponse->assign('hidden_provider',   'value', $getpa['provider']);
        $objResponse->assign('hidden_duration',   'value', $getpa['duration']);
        $objResponse->assign('hidden_cost',        'value', PdpCostConverter::input($getpa['costs']));
//        if (!CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
            $objResponse->assign('show_action',     'innerHTML', $getpa['action']);
            $objResponse->assign('show_provider',   'innerHTML', $getpa['provider']);
            $objResponse->assign('show_duration',   'innerHTML', $getpa['duration']);
            $objResponse->assign('show_cost',       'innerHTML', PdpCostConverter::display($getpa['costs']));
//        }
    }
    return $objResponse;
}

function getEmailsForNotificationHtml($A_LEVEL, $ID_PDPEA_OR_ET)
{
    if (empty($ID_PDPEA_OR_ET) || ($A_LEVEL != 1 && $A_LEVEL != 2)) { // alle emails
        // met de left join op alle niet actieve employees kun je de actieve eruit filteren door
        // door te kijken naar de "lege" employees aan de "rechter" kant.
        // Zo komen alle externen (zonder ID_E) en alle actieve internen (ook zonder ID_E) uit PersonData
        $sql = 'SELECT
                    0 as alert_count,
                    pd.*
                FROM person_data pd
                    LEFT JOIN employees e
                        ON (e.id_pd = pd.id_pd AND e.is_inactive = 1)
                WHERE pd.customer_id= ' . CUSTOMER_ID . '
                    AND pd.ID_EC in (1,2)
                    AND pd.email <> ""
                    AND e.ID_E IS NULL
                ORDER BY pd.lastname, pd.firstname';
    } else {
        if ($A_LEVEL == 1) { // de actie emails, level = 1
            $sql = 'SELECT
                        count(a.ID_A) as alert_count,
                        pd.*
                    FROM
                        person_data pd
                        LEFT JOIN alerts a
                            ON pd.ID_PD = a.ID_PD
                                AND a.ID_PDPEA = '. $ID_PDPEA_OR_ET . '
                                AND a.is_level = 1
                                AND a.is_done = 0
                        LEFT JOIN employees e
                            ON e.id_pd = pd.id_pd
                                AND e.is_inactive = 1
                    WHERE
                        pd.customer_id = ' . CUSTOMER_ID . '
                        AND pd.ID_EC in (1,2)
                        AND pd.email <> ""
                        AND e.ID_E IS NULL
                    GROUP
                        BY pd.id_pd
                    ORDER BY
                        lastname,
                        firstname';
        } else if ($A_LEVEL == 2) { // we hebben de taak emails nodig
            $sql = 'SELECT
                        count(a.ID_A) as alert_count,
                        pd.*
                    FROM person_data pd
                        LEFT JOIN alerts a
                            ON pd.ID_PD = a.ID_PD
                                AND a.ID_PDPET = '. $ID_PDPEA_OR_ET . '
                                AND a.is_level = 2
                                AND a.is_done = 0
                        LEFT JOIN employees e
                            ON e.id_pd = pd.id_pd
                                AND e.is_inactive = 1
                    WHERE pd.customer_id = ' . CUSTOMER_ID . '
                        AND pd.ID_EC in (1,2)
                        AND pd.email <> ""
                        AND e.ID_E IS NULL
                    GROUP BY
                        pd.id_pd
                    ORDER BY
                        lastname,
                        firstname';
        }
    }
    $get_pd = BaseQueries::performQuery($sql);

    if (@mysql_num_rows($get_pd) == 0) {
        $html .= '<strong>' . TXT_UCW('NOTIFICATION_EMAILS') . '</strong>
    <span style="font-size:smaller;">' . TXT_UCF('NOTIFICATION_EMAILS') . '</span><br>' . TXT_UCW('NO_NOTIFICATION_EMAILS_RETURN') . '';
    } else {
        $html .= '<strong>' . TXT_UCW('NOTIFICATION_EMAILS') . '</strong>
    <br><span style="font-size:smaller;">' . TXT_UCF('NOTIFICATION_EMAILS') . ' (* = '. TXT_UCF('EXTERNAL') . ')</span><br><select name="ID_PD" size="5" multiple style="width: 300px;">';
        while ($pd = @mysql_fetch_assoc($get_pd)) {
            $selected = $pd[alert_count] > 0 ? ' selected' : '';
            $html .= '<option value="' . $pd[ID_PD] . '" ' . $selected . '>' . ModuleUtils::EmailName($pd[firstname], $pd[lastname], $pd[email], $pd[ID_EC]) . '</option>';
        }
        $html .= '</select>';
    }
    return $html;
}

?>
