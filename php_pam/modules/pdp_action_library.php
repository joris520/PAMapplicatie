<?php

require_once('modules/model/queries/to_refactor/PdpActionLibraryQueriesDeprecated.class.php');
require_once('modules/model/service/to_refactor/PdpActionsServiceDeprecated.class.php');

function modulePDPActionLibrary_direct($objResponse)
{
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_PDP_ACTION_LIB);

        $add_pdp_btn = '<input type="button" id="showCluster" value="' . TXT_BTN('DISPLAY_PDP_CLUSTERS') . '" class="btn btn_width_150" onclick="xajax_modulePDPActionLibrary_showPDPCluster();return false;">';
        if (PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $add_pdp_btn .= '&nbsp;<input type="button" id="btnaddCluster" value="' . TXT_BTN('ADD_NEW_CLUSTER') . '" class="btn btn_width_150" onclick="xajax_modulePDPActionLibrary_addPDPCluster();return false;">';
            $add_pdp_btn .= '&nbsp;<input type="button" value="' . TXT_BTN('ADD_NEW_PDP_ACTION') . '" class="btn btn_width_150" onclick="xajax_modulePDPActionLibrary_addPDPAction();return false;">';
        }
        $add_pdp_btn .= '&nbsp;<input type="button" class="btn btn_width_180" value="' . TXT_BTN('GENERATE_PDP_ACTION_PRINT') . '" onclick="xajax_modulePDPActionLibrary_printPDPActions();return false;" />';

        $html = '
        <div id="mode_pdp_actionlib">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="left_panel"  style="width:300px; min-width:300px;">
                        <div id="scrollDiv">' . getActionsList(null) . '</div>
                    </td>
                    <td class="right_panel">
                        <div id="top_nav" class="top_nav">' . $add_pdp_btn . '</div>
                        <div id="mod_pdp_actionlib_right"></div>
                    </td>
                </tr>
            </table>
        </div>';

        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_PDP_ACTION_LIB));

}

function modulePDPActionLibrary() {

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        modulePDPActionLibrary_direct($objResponse);
    }

    return $objResponse;
}

function getActionsList($selected_action_id)
{
    $html = '';

    $queryResult = PdpActionLibraryQueriesDeprecated::getPdpActions();

    if (@mysql_num_rows($queryResult) == 0) {
        $html = TXT_UCF('NO_VALUES_RETURNED');
    } else {
        $html .= '
        <table border="0" cellspacing="0" cellpadding="0" style="width:280px;">';

        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            $id_pdpa = $queryResult_row['ID_PDPA'];
            $action = $queryResult_row['action'];
            $action_class = ($selected_action_id != $id_pdpa ) ? 'divLeftRow' : 'divLeftWbg';

            $pdp_action_btns = '';
            if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
                $pdp_action_btns .= '
                <a href="" onclick="xajax_modulePDPActionLibrary_editAction(' . $id_pdpa . ');return false;" title="' . TXT_UCF('EDIT') . '">
                    <img src="' . ICON_EDIT . '" class="icon-style" border="0">
                </a>';
            }
            if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
                $pdp_action_btns .= '
                <a href="" onclick="xajax_modulePDPActionLibrary_deletePDPAction(' . $id_pdpa . ');return false;" title="' . TXT_UCF('DELETE') . '">
                    <img src="' . ICON_DELETE . '" class="icon-style" border="0">
                </a>';
            }
            $pdp_action_btns = empty($pdp_action_btns) ? '&nbsp;' : $pdp_action_btns;

            $html .= '
            <tr id="rowLeftNav' . $id_pdpa . '">
                <td class="dashed_line ' . $action_class . '" id="mod_pdp_actionlib_cat_left" width="80%">
                    <a href="" id="link' . $id_pdpa . '" onclick="xajax_modulePDPActionLibrary_showAction(' . $id_pdpa . '); selectRow(\'rowLeftNav' . $id_pdpa . '\'); return false;">
                        <div id="pdp_actionlib' . $id_pdpa . '" style="float:left">' . $action . '</div>
                    </a>
                <td>
                <td width="20%" class="dashed_line ' . $action_class . '" id="mod_pdp_actionlib_cat_left2">
                    <div align="right">
                        ' . $pdp_action_btns . '
                    </div>
                </td>
            </tr>';

        }

        $html .='
        </table>';
    }

    return $html;
}

function modulePDPActionLibrary_addPDPCluster()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__ADD_PDPCLUSTER);

        $safeFormHandler->addStringInputFormatType('cluster');

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <form id="PDPClusterForm" name="PDPClusterForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
            <p>' . TXT_UCF('ADD_NEW_PDP_CLUSTER') . '</p>
            <table width="40%" cellspacing="0" cellpadding="2" class="border1px">
                <tr>
                    <td align="right" class="bottom_line">' . TXT_UCF('CLUSTER') . ':</td>
                    <td align="left"><input type="text" size="40" name="cluster" value=""/></td>
                </tr>
            </table>
            <br>
            <input type="submit" id="submitButton" value="' . TXT_BTN('ADD') . '" class="btn btn_width_80">
            <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPActionLibrary_showPDPCluster();return false;">
        </form>';
        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
    }
    return $objResponse;
}

function modulePDPActionLibrary_editPDPCluster($id_pdpac) {

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__EDIT_PDPCLUSTER);

        $safeFormHandler->addStringInputFormatType('cluster');
        $safeFormHandler->storeSafeValue('id_pdpac', $id_pdpac);

        $safeFormHandler->finalizeDataDefinition();

        $get_pdpac = @mysql_fetch_assoc(PdpActionLibraryQueriesDeprecated::getPdpActionCluster($id_pdpac));
        $html = '
        <form id="PDPClusterForm" name="PDPClusterForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
            <p>' . TXT_UCF('EDIT') . '</p>
            <table width="40%" cellspacing="0" cellpadding="2" class="border1px">
                <tr>
                    <td align="right" class="bottom_line">' . TXT_UCF('CLUSTER') . ':</td>
                    <td align="left"><input type="text" size="40" name="cluster" value="' . $get_pdpac['cluster'] . '"/></td>
                </tr>
            </table>
            <br>
            <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
            <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPActionLibrary_showPDPCluster();return false;">
        </form>';
        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
    }
    return $objResponse;
}

function PDPActionLibrary_processSafeForm_addPDPCluster($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $cluster = $safeFormHandler->retrieveInputValue('cluster');
        list($hasError, $message) = PdpActionsServiceDeprecated::validatePdpActionCluster($cluster, null);

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $cluster_id = PdpActionLibraryQueriesDeprecated::addPdpActionCluster($cluster);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPActionLibrary_showPDPCluster());
        }
    }
    return array($hasError, $message);
}

function PDPActionLibrary_processSafeForm_editPDPCluster($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $id_pdpac = $safeFormHandler->retrieveSafeValue('id_pdpac');
        $cluster = $safeFormHandler->retrieveInputValue('cluster');

        list($hasError, $message) = PdpActionsServiceDeprecated::validatePdpActionCluster($cluster, $id_pdpac);

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            PdpActionLibraryQueriesDeprecated::updatePdpActionCluster($id_pdpac, $cluster);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPActionLibrary_showPDPCluster());
        }
    }
    return array($hasError, $message);
}

function modulePDPActionLibrary_deletePDPCluster($pdpActionClusterId) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        if (PdpActionsServiceDeprecated::countPdpActionsByCluster($pdpActionClusterId) > 0) {
            $objResponse->alert(TXT_UCF('YOU_CANNOT_DELETE_THIS_CLUSTER_BECAUSE_IT_IS_USED_BY_PDP_ACTIONS'));
        } else {
            $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THIS_CLUSTER'));
            $objResponse->call('xajax_modulePDPActionLibrary_executeDeletePDPCluster', $pdpActionClusterId);
        }
    }
    return $objResponse;
}

function modulePDPActionLibrary_executeDeletePDPCluster($pdpActionClusterId) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        PdpActionsServiceDeprecated::deleteUnusedPdpActionCluster($pdpActionClusterId);
        $objResponse->loadCommands(modulePDPActionLibrary_showPDPCluster());
    }

    return $objResponse;
}

function getClusterRows()
{
    $get_pdpac = PdpActionLibraryQueriesDeprecated::getPdpActionClusters();
    while ($pdpac = @mysql_fetch_assoc($get_pdpac)) {
        $cluster_id = $pdpac['ID_PDPAC'];
        $cluster = $pdpac['cluster'];

        $cluster_btns = '';
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $cluster_btns .= '
            <a href="" onclick="xajax_modulePDPActionLibrary_editPDPCluster(' . $cluster_id . ');return false;" title="' . TXT_UCF('EDIT') . '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a>';
        }
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $cluster_btns .= '
            <a href="" onclick="xajax_modulePDPActionLibrary_deletePDPCluster(' . $cluster_id . ');return false;" title="' . TXT_UCF('DELETE') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a>';
        }
        $cluster_btns = empty($cluster_btns) ? '&nbsp;' : $cluster_btns;

        $html .= '
        <tr>
            <td class="bottom_line" id="td' . $cluster_id . '">
                <a href="" id="clink' . $cluster_id . '" onclick="xajax_modulePDPActionLibrary_showPDPActionsInCluster(' . $pdpac[ID_PDPAC] . ');return false;">' . $cluster . '</a>
            </td>
            <td class="bottom_line" id="td2' . $cluster_id . '">' . $cluster_btns . '</td>
        </tr>
        <tr>
            <td colspan="2" id="cluster' . $cluster_id . '" style="padding-left:20px; padding-bottom:10px;">
            </td>
        </tr>';
    }
    return $html;
}

function modulePDPActionLibrary_showPDPCluster() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $html = '
        <table width="700" cellspacing="0" cellpadding="1" class="border1px">
            <tr>
                <td align="left" class="bottom_line shaded_title" width="550">' . TXT_UCF('CLUSTER'). ':</td>
                <td align="left" class="bottom_line shaded_title" width="50">&nbsp;</td>
            </tr>' .
            getClusterRows() . '
        </table>
        <br>';
        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
        $objResponse->assign('btnaddCluster', 'disabled', false);
    }

    return $objResponse;
}

function modulePDPActionLibrary_showPDPActionsInCluster($id_pdpac)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

        $getpac = PdpActionLibraryQueriesDeprecated::getPdpActionsByCluster($id_pdpac);

        if (@mysql_num_rows($getpac) == 0) {
            $html .= TXT_UCF('NO_PDP_ACTION_RETURN_TO_THIS_CLUSTER');
        } else {
            $html .='
            <table border="0" cellspacing="0" cellpadding="1" width="100%" align="right" class="border1px">
                <tr>
                    <td class="shaded_title bottom_line"><strong>' . TXT_UCF('ACTION') . '</strong></td>
                    <td class="shaded_title bottom_line"><strong>' . TXT_UCF('PROVIDER') . '</strong></td>
                    <td class="shaded_title bottom_line"><strong>' . TXT_UCF('DURATION') . '</strong></td>
                    <td class="shaded_title bottom_line"><strong>' . TXT_UCF('COST') . '</strong></td>
                    <td class="shaded_title bottom_line">&nbsp;</td>
                </tr>';

            while ($pac = @mysql_fetch_assoc($getpac)) {

                if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
                    $del_btn = '<a href="" onclick="xajax_modulePDPActionLibrary_editAction(' . $pac[ID_PDPA] . ');return false;" title="' . TXT_UCF('EDIT') . '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a> <a href="" onclick="xajax_modulePDPActionLibrary_deletePDPAction(' . $pac[ID_PDPA] . ');return false;" title="' . TXT_UCF('DELETE') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a>';
                } else {
                    $del_btn = '&nbsp;';
                }

                $html .='
                <tr>
                    <td width="37%" class="shaded_title bottom_line">' . $pac[action] . '</td>
                    <td width="15%" class="shaded_title bottom_line">' . $pac[provider] . '</td>
                    <td width="20%" class="shaded_title bottom_line">' . $pac[duration] . '</td>
                    <td width="10%" class="shaded_title bottom_line">' . $pac[costs] . '</td>
                    <td width="8%"  class="shaded_title bottom_line">' . $del_btn . '</td>
                </tr>';
            }
            $html .='
                <tr>
                    <td colspan="5" class="shaded_title"><div id="logs" align="right"></div></td>
                </tr>
            </table>';

            $sql = 'SELECT
                        *
                    FROM
                        pdp_actions pa
                    WHERE
                        pa.customer_id = ' . CUSTOMER_ID . '
                        AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    ORDER BY
                        STR_TO_DATE(pa.modified_date, "%Y-%m-%d") DESC,
                        pa.modified_time DESC';
            $pdpActionsQuery = BaseQueries::performQuery($sql);
            $get_pa_log = @mysql_fetch_assoc($pdpActionsQuery);
            $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $get_pa_log['modified_by_user'], $get_pa_log['modified_date'], $get_pa_log['modified_time']);
        }

        $sql = 'SELECT
                    *
                FROM
                    pdp_action_cluster pac
                WHERE
                    pac.customer_id = ' . CUSTOMER_ID . '
                    AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER;
        $clearCdivQuery = BaseQueries::performQuery($sql);

        while ($clear = @mysql_fetch_assoc($clearCdivQuery)) {
            $objResponse->assign('cluster' . $clear[ID_PDPAC], 'innerHTML', '');
            $objResponse->assign('cluster' . $id_pdpac, 'innerHTML', $html);
            $objResponse->assign('clink' . $clear[ID_PDPAC], 'style.color', '');
            $objResponse->assign('clink' . $clear[ID_PDPAC], 'style.font', 'normal');
            $objResponse->assign('td' . $clear[ID_PDPAC], 'style.background', '');
            $objResponse->assign('td2' . $clear[ID_PDPAC], 'style.background', '');
        }

        $objResponse->assign('cluster' . $id_pdpac, 'innerHTML', $html);
        $objResponse->assign('clink' . $id_pdpac, 'style.color', '#FF0000');
        $objResponse->assign('clink' . $id_pdpac, 'style.font', 'bold');
        $objResponse->assign('td' . $id_pdpac, 'style.background', '#eeeeee');
        $objResponse->assign('td2' . $id_pdpac, 'style.background', '#eeeeee');
    }

    return $objResponse;
}

function modulePDPActionLibrary_printPDPActions() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $html = '
        <form id="clusterPrintForm" method="POST" action="javascript:void(0);">
            <input type="hidden" value="3" name="op">
            <br>
            <table border="0" width="600" cellspacing="0" cellpadding="0" align="center" class="border1px">
                <tr>
                    <td>
                        <div class="mod_employees_empPrint">
                            <table width="100%" border="0" cellspacing="3" cellpadding="0">
                                <tr>
                                    <td width="30%"><strong>' . TXT_UCF('OPTIONS') . '</strong></td>
                                    <td><strong>' . TXT_UCF('CLUSTER'). '</strong></td>
                                </tr>
                                <tr>
                                    <td class="border1px">
                                        <input type="radio" name="option" value="1"  onclick="clusterAll()" checked>' . TXT_UCF('ALL') . '</input>
                                        <br>
                                        <input type="radio" name="option" value="2" onclick="clusterPer()">' . TXT_UCF('CLUSTER'). '</input>
                                    </td>
                                    <td class="border1px">
                                        <select name="cluster[]" id="cluster" size="20" style="width:100%" multiple="multiple" disabled>';
                                        $getC = PdpActionLibraryQueriesDeprecated::getPdpActionClusters();
                                        if (@mysql_num_rows($getC) > 0) {
                                            while ($c_row = @mysql_fetch_assoc($getC)) {
                                                $html .='
                                            <option value="' . $c_row['ID_PDPAC'] . '">' . $c_row['cluster'] . '</option>';
                                            }
                                        }
                                        $html .='
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </form>
        <br>';
        $print_btns .= '
        <input type="button" id="btnEmpPrint" value="&laquo; ' . TXT_BTN('BACK') . '" class="btn btn_width_80" onclick="xajax_modulePDPActionLibrary();return false;">
        <input type="button" id="btnEmpPrint" value="' . TXT_UCF('PRINT_PDP_ACTION') . '" class="btn btn_width_150" onclick="print_actionlib()"; return false;">';

        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
        $objResponse->assign('top_nav', 'innerHTML', $print_btns);
    }
    return $objResponse;
}

function modulePDPActionLibrary_addPDPAction()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__ADD_PDPACTION);

        $safeFormHandler->addIntegerInputFormatType('id_pdpac');
        $safeFormHandler->addStringInputFormatType('action');
        $safeFormHandler->addStringInputFormatType('provider');
        $safeFormHandler->addStringInputFormatType('duration');
        $safeFormHandler->addStringInputFormatType('costs'); // eigenlijk numeric of zo

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <div id="mode_pdp_actionlib">
            <form id="pdp_actionlibAddNewForm" name="pdp_actionlibAddNewForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
                <p>' . TXT_UCF('ADD_NEW_PDP_ACTION') . '</p>
                <table width="40%" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                        <td align="right" class="bottom_line">' . TXT_UCF('CLUSTER') . ':</td>
                        <td align="left">' . getClusterSelect(null) . '</td>
                    </tr>
                    <tr>
                        <td align="right" class="bottom_line">' . TXT_UCF('ACTION') . ':</td>
                        <td align="left"><input type="text" size="60" name="action" value=""/></td>
                    </tr>
                    <tr>
                        <td align="right" class="bottom_line">' . TXT_UCF('PROVIDER') . ':</td>
                        <td align="left"><input type="text" size="60" name="provider" value=""/></td>
                    </tr>
                    <tr>
                        <td align="right" class="bottom_line">' . TXT_UCF('DURATION') . ':</td>
                        <td align="left"><input type="text" size="60" name="duration" value=""/></td>
                    </tr>
                    <tr>
                        <td align="right">' . TXT_UCF('COST') . ':</td>
                        <td align="left"><input type="text" name="costs" value=""/> &euro;</td>
                    </tr>
                </table>
                <br>
                <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPActionLibrary();return false;">
            </form>
        </div>';
        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
    }
    return $objResponse;
}


//Display PDP Action Lib
function modulePDPActionLibrary_showAction($pdpActionId)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $pdpActionDetail = PdpActionsServiceDeprecated::getPdpAction($pdpActionId);

        $cluster   = empty($pdpActionDetail['cluster']) ? '-' : $pdpActionDetail['cluster'];
        $action    = $pdpActionDetail['action'];
        $provider  = $pdpActionDetail['provider'];
        $duration  = $pdpActionDetail['duration'];
        $costs     = $pdpActionDetail['costs'];

        $html = '
        <p>' . TXT_UCF('DISPLAY_ACTION_LIBRARY') . ' </p>
        <table width="600" cellspacing="0" cellpadding="3" class="border1px">
            <tr>
                <td width="10%" class="bottom_line">' . TXT_UCF('CLUSTER'). ':</td>
                <td align="left" width="30%"> ' . $cluster . '</td>
            </tr>
            <tr>
                <td width="10%" class="bottom_line"><strong>' . TXT_UCF('ACTION') . ':</strong></td>
                <td align="left" width="30%"> ' . $action . '</td>
            </tr>
            <tr>
                <td class="bottom_line"><strong>' . TXT_UCF('PROVIDER') . ':</strong></td>
                <td align="left"> ' . $provider . '</td>
            </tr>
            <tr>
                <td class="bottom_line"><strong>' . TXT_UCF('DURATION') . ':</strong></td>
                <td align="left"> ' . $duration . '</td>
            </tr>
            <tr>
                <td><strong>' . TXT_UCF('COST') . ':</strong></td>
                <td align="left">&euro; ' . $costs . '</td>
            </tr>
        </table>
        <table width="600" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div id="logs" align="right"></div>
                </td>
            </tr>
        </table>';

        $objResponse->assign('scrollDiv', 'innerHTML', getActionsList($pdpActionId));
        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $pdpActionDetail[modified_by_user], $pdpActionDetail[modified_date], $pdpActionDetail[modified_time]);

    }

    return $objResponse;
}

function getClusterSelect($cluster_id)
{
    $html = '';
    $sql = 'SELECT
                pac.ID_PDPAC,
                pac.cluster
            FROM
                pdp_action_cluster pac
            WHERE
                pac.customer_id = ' . CUSTOMER_ID . '
                AND pac.is_customer_library = ' . PDP_ACTION_LIBRARY_CLUSTER_CUSTOMER . '
            ORDER BY
                pac.cluster';
    $get_pdpac = BaseQueries::performQuery($sql);
    $html .= '
    <select name="id_pdpac">
        <option value="">- ' . TXT_LC('SELECT') . ' - </option>';
    while ($pdpac = @mysql_fetch_assoc($get_pdpac)) {
        $selected = $pdpac['ID_PDPAC'] == $cluster_id ? ' selected' : '';
        $html .= '
        <option value="' . $pdpac['ID_PDPAC'] . '"' . $selected . '>' . $pdpac['cluster'] . '</option>';
    }
    $html .= '
    </select>';

    return $html;
}

//Edit PDP Action Lib
function modulePDPActionLibrary_editAction($action_id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__EDIT_ACTION);
        $safeFormHandler->storeSafeValue('action_id', $action_id);

        $safeFormHandler->addIntegerInputFormatType('id_pdpac');
        $safeFormHandler->addStringInputFormatType('action');
        $safeFormHandler->addStringInputFormatType('provider');
        $safeFormHandler->addStringInputFormatType('duration');
        $safeFormHandler->addStringInputFormatType('costs'); // eigenlijk numeric of zo
        $safeFormHandler->addIntegerInputFormatType('applyto');

        $safeFormHandler->finalizeDataDefinition();

        $sql = 'SELECT
                    *
                FROM
                    pdp_actions pa
                WHERE
                    pa.ID_PDPA = ' . $action_id . '
                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                    AND pa.customer_id = ' . CUSTOMER_ID;
        $queryResult = BaseQueries::performQuery($sql);
        $queryResult_row = @mysql_fetch_assoc($queryResult);

        $cluster_id = $queryResult_row['ID_PDPAC'];
        $action     = $queryResult_row['action'];
        $provider   = $queryResult_row['provider'];
        $duration   = $queryResult_row['duration'];
        $costs      = $queryResult_row['costs'];


        $html = '
        <form id="pdp_actionlibEditForm" name="pdp_actionlibEditForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
            <p>' . TXT_UCF('EDIT_ACTION_LIBRARY') . '</p>
            <table width="600" cellspacing="1" cellpadding="2" class="border1px">
                <tr>
                    <td class="bottom_line">' . TXT_UCF('CLUSTER') . ' :</td>
                    <td align="left">' . getClusterSelect($cluster_id) . '</td>
                </tr>
                <tr>
                    <td width="10%" class="bottom_line"><strong>' . TXT_UCF('ACTION') . ' :</strong></td>
                    <td align="left" width="30%">
                        <input type="text" size="60" name="action" value="' . $action . '"/>
                    </td>
                </tr>
                <tr>
                    <td class="bottom_line"><strong>' . TXT_UCF('PROVIDER') . ' :</strong></td>
                    <td align="left">
                        <input type="text" size="60" name="provider" value="' . $provider . '"/>
                    </td>
                </tr>
                <tr>
                    <td class="bottom_line"><strong>' . TXT_UCF('DURATION') . ' :</strong></td>
                    <td align="left"><input type="text" size="60" name="duration" value="' . $duration . '"/></td>
                </tr>
                <tr>
                    <td><strong>' . TXT_UCF('COST') . ' :</strong></td>
                    <td align="left">&euro; <input type="text" name="costs" value="' . $costs . '"/></td>
                </tr>
            </table>
            <br>
            <table width="600" cellspacing="1" cellpadding="2" class="border1px">
                <tr>
                    <td class="bottom_line">' . TXT_UCF('APPLY_ONLY_TO_NEW_EMPLOYEE_ACTIONS') . ' </td>
                    <td><input type="radio" name="applyto" value="1" checked></td>
                </tr>
                    <tr>
                        <td width="70%">' . TXT_UCF('APPLY_TO_EXISTING_EMPLOYEE_ACTIONS') . '</td>
                        <td><input type="radio" name="applyto" value="2"></td>
                    </tr>
            </table>
            <br>
            <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
            <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPActionLibrary_showAction(' . $action_id . ');return false;">
        </form>';

        $objResponse->assign('mod_pdp_actionlib_right', 'innerHTML', $html);
    }
    return $objResponse;
}


function validateActionForm($id_pdpac,
                            $action,
                            $provider,
                            $duration,
                            $costs)
{
    $hasError = false;
    $message = '';

    // validatie
    if (empty($id_pdpac)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
    } elseif (empty($action)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_THE_ACTION');
    } elseif (empty($provider)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
    } elseif (empty($duration)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_THE_DURATION');
    } elseif (!is_numeric($costs)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_THE_COST');
    }
    return array($hasError, $message);
}

function PDPActionLibrary_processSafeForm_editPDPAction($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        // ophalen
        $action_id  = $safeFormHandler->retrieveSafeValue('action_id');

        $id_pdpac   = $safeFormHandler->retrieveInputValue('id_pdpac');
        $action     = $safeFormHandler->retrieveInputValue('action');
        $provider   = $safeFormHandler->retrieveInputValue('provider');
        $duration   = $safeFormHandler->retrieveInputValue('duration');
        $costs      = $safeFormHandler->retrieveInputValue('costs');
        $applyto    = $safeFormHandler->retrieveInputValue('applyto');

        // valideren
        list($hasError, $message) = validateActionForm($id_pdpac,
                                                       $action,
                                                       $provider,
                                                       $duration,
                                                       $costs);

        // verwerken
        if (!$hasError) {
            $costs = str_replace(',', '.', $costs);

            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            //EDIT
            $sql = 'UPDATE
                        pdp_actions
                    SET
                        action   = "' . mysql_real_escape_string($action) . '",
                        ID_PDPAC =  ' . $id_pdpac . ',
                        provider = "' . mysql_real_escape_string($provider) . '",
                        duration = "' . mysql_real_escape_string($duration) . '",
                        costs    = "' . mysql_real_escape_string($costs) . '",
                        modified_by_user = "' . $modified_by_user . '",
                        modified_time    = "' . $modified_time . '",
                        modified_date    = "' . $modified_date . '"
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND id_pdpa = ' . $action_id;

            $updatedRows = BaseQueries::performUpdateQuery($sql);

            if ($applyto == 2) { // TODO: magic number weg!!
                if ($updatedRows > 0) {
                    $sql = 'UPDATE
                                employees_pdp_actions
                            SET
                                action =   "' . mysql_real_escape_string($action) . '",
                                provider = "' . mysql_real_escape_string($provider) . '",
                                duration = "' . mysql_real_escape_string($duration) . '",
                                costs = "' . mysql_real_escape_string($costs) . '"
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND ID_PDPAID = ' . $action_id . '
                                AND is_user_defined = ' . PDP_ACTION_FROM_LIBRARY;
                    BaseQueries::performUpdateQuery($sql);
                }
            }
            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPActionLibrary_showAction($action_id));
        }
    }
    return array($hasError, $message);
}

// PDP Execute ADD
function PDPActionLibrary_processSafeForm_addPDPAction($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

        // ophalen
        $id_pdpac = $safeFormHandler->retrieveInputValue('id_pdpac');
        $action = trim($safeFormHandler->retrieveInputValue('action'));
        $provider = trim($safeFormHandler->retrieveInputValue('provider'));
        $duration = trim($safeFormHandler->retrieveInputValue('duration'));
        $costs = trim($safeFormHandler->retrieveInputValue('costs'));

        // valideren
        list($hasError, $message) = validateActionForm($id_pdpac,
                                                       $action,
                                                       $provider,
                                                       $duration,
                                                       $costs);

        //verwerken
        if (!$hasError) {
            $costs = str_replace(',', '.', $costs);

            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'INSERT INTO
                        pdp_actions
                        (   action,
                            customer_id,
                            ID_PDPAC,
                            provider,
                            duration,
                            costs,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                          "' . mysql_real_escape_string($action) . '",
                           ' . CUSTOMER_ID . ',
                           ' . $id_pdpac . ',
                          "' . mysql_real_escape_string($provider) . '",
                          "' . mysql_real_escape_string($duration) . '",
                           ' . $costs . ',
                          "' . $modified_by_user . '",
                          "' . $modified_time . '",
                          "' . $modified_date . '"
                        )';
            $action_id = BaseQueries::performInsertQuery($sql);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPActionLibrary_showAction($action_id));
        }
    }
    return array($hasError, $message);
}

//DELETE PDP ACTION
function modulePDPActionLibrary_deletePDPAction($action_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ACTION'));
        $objResponse->call("xajax_modulePDPActionLibrary_executeDeletePDPAction", $action_id);
    }
    return $objResponse;
}

//EXECUTE DELETE PDP ACTION
function modulePDPActionLibrary_executeDeletePDPAction($action_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        $sql = 'SELECT
                    *
                FROM
                    employees_pdp_actions
                WHERE
                    ID_PDPAID = ' . $action_id . '
                    AND customer_id = ' . CUSTOMER_ID;
        $chk_emp_query = BaseQueries::performQuery($sql);
        if (@mysql_num_rows($chk_emp_query) > 0) {
            $objResponse->alert(TXT_UCF('YOU_CANNOT_DELETE_THE_PDP_ACTION_WHILE_SOME_OF_THE_EMPLOYEE_IS_CONNECTED_IN_IT'));
        } else {
            $sql = 'DELETE
                    FROM
                        pdp_actions
                    WHERE
                        id_pdpa = ' . $action_id . '
                        AND is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
                        AND customer_id = ' . CUSTOMER_ID;
            BaseQueries::performQuery($sql);
            return modulePDPActionLibrary(); // todo: anders
        }
    }
    return $objResponse;
}

function modulePDPActionLibrary_processPrintPDPActions($cForm)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
        if ($cForm['option'] == 2) {
            $total_text = '';
            foreach ($cForm['cluster'] as $value => $text) {
                $total_text = $total_text . $text . '^';
            }
            $_SESSION['clus'] = $total_text;
        }
        $objResponse->script('window.open(\'print/print_pdpactionlib.php?c=' . $cForm['option'] . '\',\'\',\'resizable=yes,width=950,height=800\')');
    }

    return $objResponse;
}

?>