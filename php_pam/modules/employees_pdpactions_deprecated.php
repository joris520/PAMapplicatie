<?php

require_once('modules/model/service/to_refactor/PdpActionSkillServiceDeprecated.class.php');
require_once('modules/common/moduleJSConsts.inc.php');
require_once('modules/interface/components/select/SelectEmployees.class.php');
require_once('modules/model/queries/to_refactor/PdpActionLibraryQueriesDeprecated.class.php');

//function generateShowSkillsByActionsHtml_deprecated($employee_id, $id_pdpea)
//{
//    $employee_action_skills_array = PdpActionSkillServiceDeprecated::getSkillsByAction($employee_id, $id_pdpea);
//
//    global $smarty;
//    $tpl = $smarty->createTemplate('to_refactor/mod_employees_pdpactions/pdpSkillsByActionView.tpl');
//    $tpl->assign('actionSkills', $employee_action_skills_array);
//    return $smarty->fetch($tpl);
//}


//$id_pdpea is edit actie id of null bij nieuwe actie
//function generateCheckCompetencesHtml_deprecated($id_pdpea, $employee_id, $safeFormHandler)
//{
//    $employee_action_skills_array = PdpActionSkillServiceDeprecated::getEmployeeScoredSkills($employee_id, $id_pdpea);
//    $action_skills_array = PdpActionSkillServiceDeprecated::getSkillsByAction($employee_id, $id_pdpea);
//
//    $safeFormHandler->storeSafeValue('IDs_AVAIL_SKILLS', $employee_action_skills_array);
//
//    global $smarty;
//    $tpl = $smarty->createTemplate('to_refactor/mod_employees_pdpactions/pdpSkillsByActionEdit.tpl');
//    $tpl->assign('newAction', empty($id_pdpea));
//    $tpl->assign('scoredSkills', $employee_action_skills_array);
//    $tpl->assign('actionSkills', $action_skills_array);
//    return $smarty->fetch($tpl);
//}

//function moduleEmployees_pdpActions_deprecated($id_e) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        moduleEmployees_pdpActions_direct_deprecated($objResponse, $id_e);
//    }
//
//    return $objResponse;
//}

//function moduleEmployees_pdpActions_direct_deprecated($objResponse, $id_e)
//{
//    ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_PDP_ACTIONS);
//
//    //validate if employees pdp action is empty. If so update
//    $sql = 'SELECT
//                *
//            FROM
//                employees_pdp_actions
//            WHERE
//                customer_id = ' . CUSTOMER_ID . '
//                AND ID_E = ' . $id_e . '
//            ORDER BY
//                CASE WHEN (STR_TO_DATE(end_date, "%d-%m-%Y") >= CURRENT_DATE)
//                     THEN 0
//                     ELSE 1
//                END,
//                STR_TO_DATE(end_date, "%d-%m-%Y") DESC';
//    $get_pdpea_val = BaseQueries::performQuery($sql);
//
//    while ($get_pdpea_row_val = @mysql_fetch_assoc($get_pdpea_val)) {
//
//        // if action is empty update the record with one from pdp_action table
//        if (empty($get_pdpea_row_val['action'])) {
//            $sql = 'SELECT
//                        *
//                    FROM
//                        pdp_actions
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPA = ' . $get_pdpea_row_val['ID_PDPAID'];
//            $pdpActionsQuery = BaseQueries::performQuery($sql);
//
//            $get_pdp_actions_val = @mysql_fetch_assoc($pdpActionsQuery);
//
//            $sql = 'UPDATE
//                        employees_pdp_actions
//                    SET
//                        action = "' . mysql_real_escape_string($get_pdp_actions_val['action']) . '",
//                        provider = "' . mysql_real_escape_string($get_pdp_actions_val['provider']) . '",
//                        duration = "' . mysql_real_escape_string($get_pdp_actions_val['duration']) . '",
//                        costs = "' . mysql_real_escape_string($get_pdp_actions_val['costs']) . '"
//                    where
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_E = ' . $id_e . '
//                        AND ID_PDPEA = ' . $get_pdpea_row_val['ID_PDPEA'] . '
//                        AND ID_PDPAID = ' . $get_pdpea_row_val['ID_PDPAID'];
//            BaseQueries::performQuery($sql);
//        }
//    }
//    //end validations
//
//    $getemp_pdpa = '';
//    $sql = 'SELECT
//                *
//            FROM
//                employees_pdp_actions
//            WHERE
//                customer_id = ' . CUSTOMER_ID . '
//                AND ID_E = ' . $id_e;
//    $pdaQuery = BaseQueries::performQuery($sql);
//    $pdpeas = @mysql_fetch_assoc($pdaQuery);
//    $id_pdpea = empty($pdpeas['ID_PDPEA']) ? '\'\'' : $pdpeas['ID_PDPEA'];
//
//
//    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $pdp_action_btn .= ' <input type="button" id="btnAddPDP" value="' . TXT_BTN('ADD_NEW_PDP_ACTION') . '" class="btn btn_width_150" onclick="xajax_moduleEmployees_pdpActionForm_deprecated(\'\', ' . $id_e . ', ' . FORM_MODE_NEW . ');return false;">';
//        $header_nav .= '&nbsp;';
//    } else {
//        $pdp_action_btn = '';
//    }
//
//    $top_nav = '
//    <input type="button" value="' . TXT_BTN('SUMMARIES'). '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActions_deprecated(' . $id_e . ');return false;">
//    <input type="button" value="' . TXT_BTN('DETAILS') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActionsCollapse_deprecated(' . $id_pdpea . ', ' . $id_e . ', 1);return false;">
//    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
////    $top_nav .= '<input type="button" value="' . TXT_BTN('GENERATE_PDP_ACTION_PRINT') . '" class="btn btn_width_150" onclick="xajax_moduleEmployees_printPDPActions_deprecated(' . $id_e . ');return false;">
////                    <input type="button" value="' . TXT_BTN('PRINT_PDP_COSTS') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_printPDPActionsCosts_deprecated(' . $id_e . ');return false;">';
//    $top_nav .= $pdp_action_btn;
//
//
//    $getemp_pdpa .= '
//    <div class="mod_employees_PDPAction"><br>';
//
////	 $getemp_pdpa .= '<table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- -->
////	  <tr>
////		<td>';
//    $sql = 'SELECT
//                *
//            FROM
//                employees_pdp_actions
//            WHERE
//                customer_id = ' . CUSTOMER_ID . '
//                AND ID_E = ' . $id_e . '
//            ORDER BY
//                CASE WHEN (STR_TO_DATE(end_date, "%d-%m-%Y") >= CURRENT_DATE)
//                     THEN 0
//                     ELSE 1
//                END,
//                STR_TO_DATE(end_date, "%d-%m-%Y") DESC';
//    $get_pdpea = BaseQueries::performQuery($sql);
//    if (@mysql_num_rows($get_pdpea) == 0) {
//        $getemp_pdpa .= TXT_UCF('NO_PDP_ACTIONS_RETURN') . '&nbsp;&nbsp;' .$header_nav;
//    } else {
//        $getemp_pdpa .='
//        <table width="100%" border="0" cellspacing="0" cellpadding="2">
//            <tr>
//                <td width="30%" class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('ACTION') . '</td>
//                <td width="20%" class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('PROVIDER') . '</td>
//                <td width="20%" class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('DEADLINE_DATE') . '</td>
//                <td width="15%" class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('STATUS') . '</td>
//                <td width="20%" class="bottom_line mod_employees_tasks_heading">' . $header_nav . '</td>
//            </tr>';
//
//        while ($get_pdpea_row = @mysql_fetch_assoc($get_pdpea)) {
//
//            if ($get_pdpea_row[is_completed] == 0) {
//                $is_completed = TXT_UCW('NOT_COMPLETED');
//            }
//            $is_completed = $get_pdpea_row[is_completed] == 0 ? TXT_UCW('NOT_COMPLETED') : TXT_UCW('COMPLETED');
//            $greenImage = $get_pdpea_row[is_completed] == 1 ? '<img src="images/green.jpg" width="11" height="10"/>' : '';
//            if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//                $edit_pdp_action = '<a href="" onclick="xajax_moduleEmployees_pdpActionForm_deprecated(' . $get_pdpea_row[ID_PDPEA] . ', ' . $id_e . ', ' . FORM_MODE_EDIT . ');return false;" title="' . TXT_UCF('EDIT') . ' ' . TXT_UCF('ACTION'). '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a>
//                <a href="" onclick="xajax_moduleEmployees_deletePDPActions_deprecated(' . $get_pdpea_row[ID_PDPEA] . ', ' . $id_e . ');return false;" title="' . TXT_UCF('DELETE') . ' ' . TXT_UCF('ACTION') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a> &nbsp; ';
//            } else {
//                $edit_pdp_action = '&nbsp;';
//            }
//
//            $info_action = getpdpAction_link_clickaction_deprecated($get_pdpea_row[ID_PDPEA], $id_e);
//
//            $getemp_pdpa .='
//            <tr>
//                <td class="bottom_line"><a id="pdpAction_link' . $get_pdpea_row[ID_PDPEA] . '" href="" onclick="' . $info_action . '">' . $get_pdpea_row['action'] . '</a></td>
//                <td class="bottom_line">' . $get_pdpea_row[provider] . '</td>
//                <td class="bottom_line">' . $get_pdpea_row[end_date] . '</td>
//                <td class="bottom_line">' . $greenImage . ' ' . $is_completed . '</td>
//                <td class="bottom_line" align="right">' . $edit_pdp_action . '</td>
//            </tr>';
//        }
//
//        $sql = 'SELECT
//                    *
//                FROM
//                    employees_pdp_actions
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_E = ' . $id_e . '
//                ORDER BY
//                    STR_TO_DATE(modified_date, "%Y-%m-%d") DESC,
//                    modified_time DESC';
//
//        $logQuery = BaseQueries::performQuery($sql);
//        $get_pdpea_log = @mysql_fetch_assoc($logQuery);
//        $getemp_pdpa .='
//            <tr>
//                <td colspan="5"><div id="logs" align="right"></div></td>
//            </tr>
//        </table>';
//        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $get_pdpea_log[modified_by_user], $get_pdpea_log[modified_date], $get_pdpea_log[modified_time]);
//    }
//    $getemp_pdpa .='
//    </div><!-- mod_employees_PDPAction -->';
//
//    $objResponse->assign('empPrint', 'innerHTML', $getemp_pdpa);
//
//    EmployeesTabInterfaceProcessor::displayMenu($objResponse, $id_e, MODULE_EMPLOYEE_PDP_ACTIONS);
//
//    $objResponse->assign('top_nav_btn', 'innerHTML', $top_nav);
//}

//function getpdpAction_link_clickaction_deprecated($id_pdpea, $id_e)
//{
//    return 'xajax_moduleEmployees_pdpActionData_deprecated(' . $id_pdpea . ', ' . $id_e . ');return false;';
//}

//function moduleEmployees_pdpActionsCollapse_deprecated($id_pdpea, $id_e) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $getemp_pdpa = '
//        <br>
//        <table width="100%" border="0" cellspacing="0" cellpadding="0" width="100%">';
//
//        $sql = 'SELECT
//                    *
//                FROM
//                    employees_pdp_actions
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_E = ' . $id_e . '
//                ORDER BY
//                    CASE WHEN (STR_TO_DATE(end_date, "%d-%m-%Y") >= CURRENT_DATE)
//                         THEN 0
//                         ELSE 1
//                    END,
//                    STR_TO_DATE(end_date, "%d-%m-%Y") DESC';
//        $get_pdpea = BaseQueries::performQuery($sql);
//
//        if (@mysql_num_rows($get_pdpea) == 0) {
//            $getemp_pdpa .=
//            '<tr>
//                <td>' . TXT_UCF('NO_PDP_ACTIONS_RETURN') . '</td>
//             </tr>';
//        } else {
//
//            while ($get_pdpea_row = @mysql_fetch_assoc($get_pdpea)) {
//                $getemp_pdpa .='
//                <tr>
//                    <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('ACTION') . '</td>
//                    <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('PROVIDER') . '</td>
//                    <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('DURATION') . '</td>
//                    <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('COST'). '</td>
//                    <td class="bottom_line">&nbsp;</td>
//                </tr>';
//
//                $is_completed = $get_pdpea_row['is_completed'] == 0 ? TXT_UCF('NOT_COMPLETED') : TXT_UCF('COMPLETED');
//
//                if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//                    $edit_pdp_action = '
//                    <a href="" onclick="xajax_moduleEmployees_pdpActionForm_deprecated(' . $get_pdpea_row['ID_PDPEA'] . ', ' . $id_e . ', ' . FORM_MODE_EDIT . ');return false;" title="' . TXT_UCF('EDIT') . ' ' . TXT_UCF('ACTION'). '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a>
//                    <a href="" onclick="xajax_moduleEmployees_deletePDPActions_deprecated(' . $get_pdpea_row['ID_PDPEA'] . ', ' . $id_e . ');return false;" title="' . TXT_UCF('DELETE') . ' ' . TXT_UCF('ACTION'). '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a> &nbsp; ';
//                } else {
//                    $edit_pdp_action = '&nbsp;';
//                }
//
//                $getemp_pdpa .='
//                <tr>
//                    <td class="bottom_line shaded_title">' . $get_pdpea_row['action'] . '</td>
//                    <td class="bottom_line shaded_title">' . $get_pdpea_row['provider'] . '</td>
//                    <td class="bottom_line shaded_title">' . $get_pdpea_row['duration'] . '</td>
//                    <td class="bottom_line shaded_title">' . number_format($get_pdpea_row['costs'], 2, ',', '.') . ' &euro;</td>
//                    <td class="bottom_line shaded_title" align="right">' . $edit_pdp_action . '</td>
//                </tr>
//                <tr>
//                    <td colspan="100%">';
//                    $sql = 'SELECT
//                                *
//                            FROM
//                                employees_pdp_actions
//                            WHERE
//                                customer_id = ' . CUSTOMER_ID . '
//                                AND ID_PDPEA = ' . $get_pdpea_row['ID_PDPEA'];
//
//                    $pdpeaQuery = BaseQueries::performQuery($sql);
//                    $pdpea = @mysql_fetch_assoc($pdpeaQuery);
//
//                    $sql = 'SELECT
//                                *
//                            FROM
//                                users
//                            WHERE
//                                customer_id = ' . CUSTOMER_ID . '
//                                AND user_id = ' . $pdpea['ID_PDPTOID'];
//                    $pdptoQuery = BaseQueries::performQuery($sql);
//                    $get_pdpto = @mysql_fetch_assoc($pdptoQuery);
//                    $taskowner = $get_pdpto['name'];
//
//                    $is_completedOk = $pdpea['is_completed'] == 1 ? TXT_UCF('YES') : TXT_UCF('NO');
//                    $connected_skills = generateShowSkillsByActionsHtml_deprecated($id_e, $get_pdpea_row['ID_PDPEA']);
//
//                    $getemp_pdpa .= '
//                    <table width="90%" border="0" cellspacing="0" cellpadding="0" align="right">
//                        <tr>
//                            <th colspan="100%"><p>' . TXT_UCF('DETAILS') . '</p></th>
//                        </tr>
//                        <tr>
//                            <td width="20%"><strong>' . TXT_UCW('ACTION_OWNER') . ':</strong></td>
//                            <td>' . $taskowner . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('NOTIFICATION_DATE') . ':</strong></td>
//                            <td>' . $pdpea['start_date'] . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('DEADLINE_DATE') . ':</strong></td>
//                            <td>' . $pdpea['end_date'] . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('COMPLETED') . ': </strong></td>
//                            <td>' . $is_completedOk . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCF('RELATED_COMPETENCES') . ': </strong>
//                            <td>' . $connected_skills . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('REASONS_REMARKS') . ':</strong></td>
//                            <td>' . nl2br($pdpea['notes']) . '</td>
//                        </tr>
//                        <tr>
//                            <td>&nbsp;</td>
//                        </tr>
//
//                        <tr>
//                            <td>
//                                <strong>' . TXT_UCF('TASKS') . ': </strong>
//                            </td>
//                            <td>';
//
//                            if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//                                $add_pdptask_btn = ' <input type="button" id="addTaskBtn" value="' . TXT_BTN('ADD_NEW_TASK') . '" class="btn btn_width_150" onclick="xajax_moduleEmployees_pdpActionTaskForm_deprecated(\'\', ' . $get_pdpea_row['ID_PDPEA'] . ', ' . $id_e . ', ' . FORM_MODE_NEW . ');return false;">';
//                            } else {
//                                $add_pdptask_btn = '';
//                            }
//
//                            $sql = 'SELECT
//                                        *
//                                    FROM
//                                        employees_pdp_tasks
//                                    WHERE
//                                        customer_id = ' . CUSTOMER_ID . '
//                                        AND ID_PDPEA = ' . $pdpea['ID_PDPEA'] . '
//                                    ORDER BY
//                                        STR_TO_DATE(end_date, "%d-%m-%Y") DESC';
//                            $get_ept = BaseQueries::performQuery($sql);
//                            if (@mysql_num_rows($get_ept) == 0) {
//                                $getemp_pdpa .= TXT_UCF('NO_TASKS_RETURN') . '<br/><br/>
//                                <table border="0" width="100%" cellspacing="0" cellpadding="1">
//                                    <tr>
//                                        <td colspan="3">' . $add_pdptask_btn . '<br/></td>
//                                    </tr>
//                                </table>';
//                                $logs = '';
//                            } else {
//                                $getemp_pdpa .='
//                                <table border="0" width="100%" cellspacing="0" cellpadding="1">';
//
//                                while ($get_ept_row = @mysql_fetch_assoc($get_ept)) {
//                                    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//                                        $edit_pdpTask_action = '
//                                            <a href="" onclick="xajax_moduleEmployees_pdpActionTaskForm_deprecated(' . $get_ept_row['ID_PDPET'] . ', ' . $pdpea['ID_PDPEA'] . ', ' . $id_e . ',' . FORM_MODE_EDIT . ');return false;" title="' . TXT_UCF('EDIT') . ' ' . TXT_UCF('TASK'). '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a>
//                                            <a href="" onclick="xajax_moduleEmployees_deletePDPActionsTask_deprecated(' . $get_ept_row['ID_PDPET'] . ', ' . $pdpea['ID_PDPEA'] . ', ' . $id_e . ');return false;" title="' . TXT_UCF('DELETE') . ' ' . TXT_UCF('TASK'). '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a> &nbsp; ';
//                                    } else {
//                                        $edit_pdpTask_action = '&nbsp;';
//                                    }
//
//                                    $sql = 'SELECT
//                                                *
//                                            FROM
//                                                pdp_task_ownership
//                                            WHERE
//                                                customer_id = ' . CUSTOMER_ID . '
//                                                AND ID_PDPTO = ' . $get_ept_row['ID_PDPTO'];
//                                    $pdptoQuery = BaseQueries::performQuery($sql);
//                                    $get_pdpto = @mysql_fetch_assoc($pdptoQuery);
//                                    $is_completed = $get_ept_row['is_completed'] == 1 ? TXT_UCW('COMPLETED') : TXT_UCW('NOT_COMPLETED');
//
//
//                                    $getemp_pdpa .='
//                                    <tr>
//                                        <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCW('TASK_OWNER') . '</td>
//                                        <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCW('COMPLETION_DATE') . '</td>
//                                        <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCW('STATUS') . '</td>
//                                        <td class="bottom_line mod_employees_tasks_heading">&nbsp;<td>
//                                    </tr>
//                                    <tr>
//                                        <td class="bottom_line shaded_title">' . $get_pdpto['name'] . '</td>
//                                        <td class="bottom_line shaded_title">' . $get_ept_row['end_date'] . '</td>
//                                        <td class="bottom_line shaded_title">' . $is_completed . '</td>
//                                        <td class="bottom_line shaded_title" align="right">' . $edit_pdpTask_action . '</td>
//                                    </tr>
//                                    <tr>
//                                        <td style="padding-bottom: 7px;"><strong>' . TXT_UCF('TASK') . ':</strong></td>
//                                        <td colspan="3" style="padding-bottom: 7px;">' . nl2br($get_ept_row['task']) . '</td>
//                                    </tr>
//                                    <tr>
//                                        <td style="padding-bottom: 7px;"><strong>' . TXT_UCF('REMARKS') . ':</strong></td>
//                                        <td colspan="3" style="padding-bottom: 7px;">' . nl2br($get_ept_row['notes']) . '<br/><br/></td>
//                                    </tr>';
//                                }
//                                $getemp_pdpa .='
//                                    <tr>
//                                        <td colspan="3">' . $add_pdptask_btn . '<br/></td>
//                                        <td><div id="logs" align="right"></div></td>
//                                    </tr>
//                                </table>';
//                            }
//
//
//                            $getemp_pdpa .='
//                            <br />
//                            </td>
//                        </tr>
//                    </table>';
//
//                    //===============
//                    $getemp_pdpa .='
//                    </td>
//                </tr>';
//            }
//        }
//        $getemp_pdpa .='
//        </table>';
//
//        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//            $pdp_action_btn = '<input type="button" id="btnAddPDP" value="' . TXT_BTN('ADD_NEW_PDP_ACTION') . '" class="btn btn_width_150" onclick="xajax_moduleEmployees_pdpActionForm_deprecated(\'\', ' . $id_e . ', ' . FORM_MODE_NEW . ');return false;">';
//        } else {
//            $pdp_action_btn = '';
//        }
//
//        $btns = '
//        <input type="button" value="' . TXT_BTN('SUMMARIES') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActions_deprecated(' . $id_e . ');return false;">
//        <input type="button" value="' . TXT_BTN('DETAILS'). '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActionsCollapse_deprecated(' . $id_pdpea . ', ' . $id_e . ', 1);return false;">
//        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;';
//        $btns .= '<input type="button" value="' . TXT_BTN('GENERATE_PDP_ACTION_PRINT') . '" class="btn btn_width_150" onclick="xajax_moduleEmployees_printPDPActions_deprecated(' . $id_e . ');return false;">
//                  <input type="button" value="' . TXT_BTN('PRINT_PDP_COSTS') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_printPDPActionsCosts_deprecated(' . $id_e . ');return false;">
//        ' . $pdp_action_btn . '
//        ';
//        $objResponse->assign('empPrint', 'innerHTML', $getemp_pdpa);
//        $objResponse->assign('top_nav_btn', 'innerHTML', $btns);
//    }
//
//    return $objResponse;
//}

//function moduleEmployees_pdpActionForm_deprecated($id_pdpea, $id_e, $form_mode) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        if (!empty($id_pdpea)) {
//            $sql = 'SELECT
//                        *
//                    FROM
//                        employees_pdp_actions
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPEA = ' . $id_pdpea;
//            $pdpeaQuery = BaseQueries::performQuery($sql);
//            $pdpea = @mysql_fetch_assoc($pdpeaQuery);
//            $pdpea_val = $pdpea[ID_PDPAID];
//        } else {
//            $pdpea_val = 0;
//        }
//
//        if ($form_mode == FORM_MODE_NEW) {
//            $onsubmit_function = SAFEFORM_EMPLOYEES__ADD_PDPACTIONS_DEPRECATED;
//        } elseif ($form_mode == FORM_MODE_EDIT) {
//            $onsubmit_function = SAFEFORM_EMPLOYEES__EDIT_PDPACTIONS_DEPRECATED;
//        }
//
//        $safeFormHandler = SafeFormHandler::create($onsubmit_function);
//
//        $safeFormHandler->storeSafeValue('ID_E', $id_e);
//        if ($form_mode == FORM_MODE_EDIT) {
//            $safeFormHandler->storeSafeValue('ID_PDPEA', $id_pdpea);
//            $safeFormHandler->storeSafeValue('prev_ID_PDPAID', $pdpea_val);
//        }
//
//        $safeFormHandler->addIntegerInputFormatType('ID_PDPAID', true);
//        $safeFormHandler->addPrefixStringInputFormatType('kspid_');
//        $safeFormHandler->addIntegerInputFormatType('user_id');
//        $safeFormHandler->addStringInputFormatType('end_date');
//        $safeFormHandler->addStringInputFormatType('is_completed');
//        $safeFormHandler->addStringInputFormatType('start_date');
//        $safeFormHandler->addIntegerArrayInputFormatType('ID_PD');
//        $safeFormHandler->addStringInputFormatType('notes');
//
//
//        $safeFormHandler->finalizeDataDefinition();
//
//        $getemp_pdpa = '';
//        $getemp_pdpa .= '<br>
//        <table border="0" cellspacing="0" cellpadding="0">
//        <tr><td>
//            <form id="moduleEmployeesPDPForm" name="moduleEmployeesPDPForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';
//
//        $getemp_pdpa .= $safeFormHandler->getTokenHiddenInputHtml();
//
//        $getemp_pdpa .= '
//    <div class="mod_employees_PDPAction">
//    <table width="100%" border="0" cellspacing="0" cellpadding="2">
//        <tr>
//        <td>';
//        $sql = 'SELECT
//                    *
//                FROM
//                    pdp_actions
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                ORDER BY
//                    action';
//        $get_pdpta = BaseQueries::performQuery($sql);
//        if (@mysql_num_rows($get_pdpta) == 0) {
//            $getemp_pdpa .= TXT_UCF('NO_PDP_ACTION_ADDED_FROM_PDP_ACTION_LIBRARY_YET');
//        } else {
//            $getemp_pdpa .='
//        <p> ' . TXT_UCF('ACTIONS') . '</p>';
//            if (empty($pdpea[ID_PDPAID])) {
//                $action_msg = TXT_UCF('CLICK_HERE_TO_SELECT_ACTION');
//                $current_action = '';
//            } else {
//                $action_msg = '<br/>' . TXT_UCF('CLICK_HERE_TO_CHANGE_ACTION');
//                $current_action = TXT_UCF('CURRENT_ACTION') . ': ';
//            }
//
//            $getemp_pdpa .='<div id="pdpaddto">
//                        ' . $current_action . '<strong> ' . $pdpea[action] . '</strong> <a href="" onclick="xajax_moduleEmployees_showPDPActionsForm_deprecated(' . $pdpea_val . ');return false;">' . $action_msg . '</a></div> ';
//        }
//        $getemp_pdpa .='</td>
//        </tr>';
//
//    //    // hbd: tussenvoegen selectie competenties
//    //    $getemp_pdpa .='<tr>';
//    //    $getemp_pdpa .='<td>';
//    //    $getemp_pdpa .= generateSelectorHtml();
//    //
//    //    $getemp_pdpa .='</td>';
//    //    $getemp_pdpa .='</tr>';
//    //    // hbd:end  tussenvoegen selectie competenties
//        // hbd: tussenvoegen checkbox competenties
//        $getemp_pdpa .='<tr>';
//        $getemp_pdpa .='<td><br />';
//        $getemp_pdpa .= generateCheckCompetencesHtml_deprecated($id_pdpea, $id_e, $safeFormHandler);
//
//        $safeFormHandler->finalizeDataDefinition();
//
//        $getemp_pdpa .='</td>';
//        $getemp_pdpa .='</tr>';
//        // hbd:end  tussenvoegen checkbox competenties
//
//        $getemp_pdpa .='
//        <tr>
//        <td>
//        <br>
//        <table>
//        <tr>';
//    //    $getemp_pdpa .='
//    //      <td>';
//        if (empty($id_pdpea)) {
//            $getemp_pdpa .= '<td>&nbsp;</td><td>';
//        } else {
//            $checked_y = $pdpea[is_completed] == 1 ? 'checked' : '';
//            $checked_n = $pdpea[is_completed] == 0 ? 'checked' : '';
//            $getemp_pdpa .='<td>
//        <strong>' . TXT_UCW('COMPLETED') . ': </strong></td>
//
//            <td><input name="is_completed" type="radio" value="1" ' . $checked_y . '> ' . TXT_UCF('YES') . ' &nbsp;
//                <input name="is_completed" type="radio" value="0" ' . $checked_n . '> ' . TXT_UCF('NO');
//        }
//        $getemp_pdpa .='</td>
//        </tr>
//        <td width="130">
//            <strong>' . TXT_UCF('ACTION_OWNER') . ': </strong>
//        </td>
//        <td>';
//                    $sql = 'SELECT
//                                *
//                            FROM
//                                users
//                            WHERE
//                                customer_id = ' . CUSTOMER_ID . '
//                                AND is_inactive = ' . USER_IS_ACTIVE . '
//                            ORDER BY
//                                name';
//                    $get_pdpto = BaseQueries::performQuery($sql);
//                    if (@mysql_num_rows($get_pdpto) == 0) {
//                        $getemp_pdpa .= TXT_UCW('NO_PDP_ACTION_OWNER_RETURN');
//                    } else {
//                    $getemp_pdpa .='
//                <select name="user_id">
//                    <option value=""> - '. TXT_LC('SELECT').' - </option>';
//                        while ($get_pdpto_row = @mysql_fetch_assoc($get_pdpto)) {
//                            $selected_to = $get_pdpto_row[user_id] == $pdpea[ID_PDPTOID] ? 'selected' : '';
//                            $getemp_pdpa .='
//                    <option value="' . $get_pdpto_row[user_id] . '" ' . $selected_to . '>' . $get_pdpto_row[name] . '</option>';
//                        }
//                    $getemp_pdpa .='
//                </select>';
//                    }
//        if (empty($id_pdpea)) { // nieuwe actie
//            $deadline_date = DEFAULT_DATE;
//            $strStartDate = DateUtils::calculateRelativeDisplayDate($deadline_date, DEFAULT_ALERTDATE_OFFSET);
//        } else {
//            $deadline_date = $pdpea[end_date];
//            $strStartDate = $pdpea[start_date];
//        }
//        $getemp_pdpa .='
//        </td>
//        </tr>
//        <tr>
//            <td>
//                <strong>' . TXT_UCF('DEADLINE_DATE') . ':</strong>
//            </td>
//            <td>
//
//                <input type="text" id="end_date" name="end_date" maxlength="0" size="20" onChange="showDateRelative(\'end_date\', ' . JS_DEFAULT_DATE_FORMAT . ', \'start_date\', ' . JS_RELATIVE_DAYS_DEADLINE . ');" value="' . $deadline_date . '" readonly>
//                <input id="end_date_cal" type="reset" value=" ... " onclick="return showCalendar(\'end_date\', ' . JS_DEFAULT_DATE_FORMAT . ');">
//            </td>
//        </tr>
//        <tr>
//            <td>
//                <strong>' . TXT_UCF('NOTIFICATION_DATE') . ':</strong>
//            </td>
//            <td>
//                <input type="text" id="start_date" name="start_date" maxlength="0" size="20" value="' . $strStartDate . '" readonly>
//                <input id="start_date_cal" type="button" value=" ... " onclick="showCalendar(\'start_date\', ' . JS_DEFAULT_DATE_FORMAT . ');">
//                <a href="" onclick="xajax_moduleEmployees_clearNotificationDate_deprecated();return false;"><img src="' . ICON_ERASE . '" class="icon-style" border="0" title="Clear notification date"></a>
//            </td>
//        </tr>
//        </table>
//        <br>
//        <div id="ne">' . getEmailsForNotificationHtml(1, $id_pdpea) . '</div>
//            </td>
//            </tr>
//
//        <tr>
//        <td><strong>' . TXT_UCF('REASONS_REMARKS') . ':</strong><br>
//            <label>
//            <textarea name="notes" style="width:700px;height:130px;">' . $pdpea[notes] . '</textarea>
//        </label></td>
//        </tr>
//    </table>
//    <br>
//        <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
//        <input type="button" value="' . TXT_BTN('CANCEL'). '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActions_deprecated(' . $id_e . ');return false;">
//    </div>
//    <br>
//    </form>
//
//        </td>
//        </tr>
//        </table>';
//        $objResponse->assign('empPrint', 'innerHTML', $getemp_pdpa);
//        $objResponse->assign('btnAddPDP', 'disabled', true);
//    }
//
//    return $objResponse;
//}

//function moduleEmployees_showPDPActionsForm_deprecated($pdpea_val = NULL) {
//
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $getemp_pdpa = '<div style="border-bottom: 1px solid #dddddd; height: 200px; overflow:auto;">
//        <table width="500" border="0" cellspacing="0" cellpadding="1" class="border1px">';
//        $sql = 'SELECT
//                    CASE
//                        WHEN pac.cluster is null
//                        THEN "zzz"
//                        ELSE pac.cluster
//                    END AS cluster,
//                    pa.action,
//                    pa.ID_PDPAC
//                FROM
//                    pdp_actions pa
//                    LEFT JOIN pdp_action_cluster pac
//                        ON pac.ID_PDPAC = pa.ID_PDPAC
//                WHERE
//                    pa.customer_id = ' . CUSTOMER_ID . '
//                    AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
//                GROUP BY
//                    pac.cluster
//                ORDER BY
//                    cluster';
//        $get_pdpac = BaseQueries::performQuery($sql);
//
//        while ($pdpac = @mysql_fetch_assoc($get_pdpac)) {
//            $clusterz = str_replace("zzz", "Unclustered", $pdpac[cluster]);
//            $getemp_pdpa .= '
//            <tr>
//                <td class="bottom_line" id="td' . $pdpac[ID_PDPAC] . '">
//                    <a href="" id="clink' . $pdpac[ID_PDPAC] . '" onclick="xajax_moduleEmployees_showEmpIndPDPCluster_deprecated(' . $pdpac[ID_PDPAC] . (empty($pdpea_val) ? '' : ',' . $pdpea_val) . ');return false;">&nbsp;' . $clusterz . '</a>
//                </td>
//            </tr>
//            <tr>
//                <td id="cluster' . $pdpac[ID_PDPAC] . '" style="padding-left:20px; padding-bottom:10px;">';
//            if ($pdpea_val <> 0) {
//                //$objResponse->call("xajax_moduleEmployees_showEmpIndPDPCluster_deprecated",$pdpac[ID_PDPAC], $pdpea_val);
//            }
//            $getemp_pdpa .= '
//                </td>
//            </tr>
//            ';
//        }
//
//
//        $getemp_pdpa .='</table>
//        </div>';
//        $objResponse->assign('pdpaddto', 'innerHTML', $getemp_pdpa);
//    }
//    return $objResponse;
//}

//function moduleEmployees_clearNotificationDate_deprecated() {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        InterfaceXajax::setValue($objResponse, 'start_date', '');
//        InterfaceXajax::setHtml($objResponse, 'ne', getEmailsForNotificationHtml('', '')); // reset selectie.
//        // mooier is helemaal weghalen, maar dan moet de selector teruggezet worden als er weer een datum ingevuld wordt.
//        //InterfaceXajax::setHtml($objResponse, 'ne', ''); // helemaal weghalen
//    }
//    return $objResponse;
//}
//
//function prefill_pdp_action_deprecated($id_pdpaid)
//{
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $sql = 'SELECT
//                    *
//                FROM
//                    pdp_actions
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_PDPA = ' . $id_pdpaid;
//        //die($sql);
//        $query = BaseQueries::performQuery($sql);
//        $getpa = mysql_fetch_assoc($query);
////        $cluster_id = $getpa['ID_PDPAC'];
////        $objResponse->assign('fill_cluster', 'innerHTML', getClusterSelect($cluster_id));
//        $objResponse->assign('fill_action',     'value', $getpa['action']);
//        $objResponse->assign('fill_provider',   'value', $getpa['provider']);
//        $objResponse->assign('fill_duration',   'value', $getpa['duration']);
//        $objResponse->assign('fill_cost',       'value', PdpCostConverter::input($getpa['costs']));
//        $objResponse->assign('hidden_action',     'value', $getpa['action']);
//        $objResponse->assign('hidden_provider',   'value', $getpa['provider']);
//        $objResponse->assign('hidden_duration',   'value', $getpa['duration']);
//        $objResponse->assign('hidden_cost',        'value', PdpCostConverter::input($getpa['costs']));
////        if (!CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
//            $objResponse->assign('show_action',     'innerHTML', $getpa['action']);
//            $objResponse->assign('show_provider',   'innerHTML', $getpa['provider']);
//            $objResponse->assign('show_duration',   'innerHTML', $getpa['duration']);
//            $objResponse->assign('show_cost',       'innerHTML', PdpCostConverter::display($getpa['costs']));
////        }
//    }
//    return $objResponse;
//}

//function moduleEmployees_showEmpIndPDPCluster_deprecated($id_pdpac, $id_pdpaid = NULL) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $sql = 'SELECT
//                    *
//                FROM
//                    pdp_actions
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_PDPAC = ' . $id_pdpac;
//        $getpac = BaseQueries::performQuery($sql);
//
//        if (@mysql_num_rows($getpac) == 0) {
//            $html .= TXT_UCW('NO_PDP_ACTION_RETURN_TO_THIS_CLUSTER');
//        } else {
//            while ($pac = @mysql_fetch_assoc($getpac)) {
//                $checked = $pac[ID_PDPA] == $id_pdpaid ? 'checked' : '';
//                $html .= '<input type="radio" onClick="xajax_prefill_pdp_action_deprecated('. $pac[ID_PDPA] .');" name="ID_PDPAID" value="' . $pac[ID_PDPA] . '" ' . $checked . '>' . $pac[action] . '<br>';
//            }
//        }
//        $sql = 'SELECT
//                    *
//                FROM
//                    pdp_action_cluster
//                WHERE
//                    customer_id = ' . CUSTOMER_ID;
//        $clearCdiv = BaseQueries::performQuery($sql);
//
//        $objResponse->assign('cluster0', 'innerHTML', '');
//        $objResponse->assign('clink0', 'style.color', '');
//        $objResponse->assign('clink0', 'style.font', 'normal');
//        while ($clear = @mysql_fetch_assoc($clearCdiv)) {
//            $objResponse->assign('cluster' . $clear[ID_PDPAC], 'innerHTML', '');
//            $objResponse->assign('cluster' . $id_pdpac, 'innerHTML', $html);
//            $objResponse->assign('clink' . $clear[ID_PDPAC], 'style.color', '');
//            $objResponse->assign('clink' . $clear[ID_PDPAC], 'style.font', 'normal');
//        }
//
//        $objResponse->assign('cluster' . $id_pdpac, 'innerHTML', $html);
//        $objResponse->assign('clink' . $id_pdpac, 'style.color', '#FF0000');
//        $objResponse->assign('clink' . $id_pdpac, 'style.font', 'bold');
//    }
//
//    return $objResponse;
//}


//function moduleEmployees_pdpActionData_Details_deprecated($id_pdpea, $id_e, $id_ksp=null)
//{
//    return moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e, $id_ksp);
//}

//function moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e, $id_ksp=null)
//{
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        if (!empty($id_pdpea)) {
//            $sql = 'SELECT
//                        *
//                    FROM
//                        employees_pdp_actions
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPEA = ' . $id_pdpea;
//            $employeePdpActionQuery = BaseQueries::performQuery($sql);
//            $pdpea = @mysql_fetch_assoc($employeePdpActionQuery);
//        }
//
//        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS) && ($id_ksp == null)) {
//            $edit_pdp_btn = '<a href="" onclick="xajax_moduleEmployees_pdpActionForm_deprecated(' . $id_pdpea . ', ' . $id_e . ', ' . FORM_MODE_EDIT . ');return false;" title="' . TXT_UCF('EDIT') . ' ' . TXT_UCF('ACTION'). '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a> <a href="" onclick="xajax_moduleEmployees_deletePDPActions_deprecated(' . $id_pdpea . ', ' . $id_e . ');return false;" title="' . TXT_UCF('DELETE') . ' ' . TXT_UCF('ACTION'). '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a> &nbsp; ';
//        } else {
//            $edit_pdp_btn = '&nbsp;';
//        }
//
//        $sql = 'SELECT
//                    *
//                FROM
//                    users
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND user_id = ' . $pdpea['ID_PDPTOID'];
//        $pdptoQuery = BaseQueries::performQuery($sql);
//
//        $get_pdpto = @mysql_fetch_assoc($pdptoQuery);
//        $taskowner = $get_pdpto['name'];
//        $is_completedOk = $pdpea['is_completed'] == PdpActionCompletedStatusValue::NOT_COMPLETED ? TXT_UCF('NO') : TXT_UCF('YES'); // cancelled ?
//        $connected_skills = generateShowSkillsByActionsHtml_deprecated($id_e, $id_pdpea);
//
//        $getemp_pdpa = '';
//        $getemp_pdpa .= '
//        <br>
//        <table width="100%" border="0" cellspacing="0" cellpadding="0"><!-- pdfActionData -->
//            <tr>
//                <td colspan="6">
//                    <table width="100%" border="0" cellspacing="0" cellpadding="1">
//                        <tr>
//                            <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('ACTION') . '</td>
//                            <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('PROVIDER') . '</td>
//                            <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('DURATION') . '</td>
//                            <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCF('COST'). '</td>
//                            <td class="bottom_line">&nbsp;</td>
//                        </tr>
//                        <tr>
//                            <td class="bottom_line shaded_title">' . $pdpea['action'] . '</td>
//                            <td class="bottom_line shaded_title">' . $pdpea['provider'] . '</td>
//                            <td class="bottom_line shaded_title">' . $pdpea['duration'] . '</td>
//                            <td class="bottom_line shaded_title">' . number_format($pdpea['costs'], 2, ',', '.') . ' &euro;</td>
//                            <td class="bottom_line shaded_title" align="right">' . $edit_pdp_btn . '</td>
//                        </tr>
//                    </table>';
//
//                    $getemp_pdpa .= '
//                    <table width="90%" border="0" cellspacing="0" cellpadding="0" align="right"><!-- details action -->
//                        <tr>
//                            <td width="20%"><strong>' . TXT_UCW('ACTION_OWNER') . ':</strong></td>
//                            <td>' . $taskowner . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('NOTIFICATION_DATE') . ':</strong></td>
//                            <td>' . $pdpea['start_date'] . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('DEADLINE_DATE') . ':</strong></td>
//                            <td>' . $pdpea['end_date'] . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('COMPLETED') . ': </strong></td>
//                            <td>' . $is_completedOk . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCF('RELATED_COMPETENCES') . ': </strong>
//                            <td>' . $connected_skills . '</td>
//                        </tr>
//                        <tr>
//                            <td><strong>' . TXT_UCW('REASONS_REMARKS') . ':</strong></td>
//                            <td>' . nl2br($pdpea['notes']) . '</td>
//                        </tr>
//                        <tr>
//                            <td>&nbsp;</td>
//                        </tr>
//                        <tr>
//                            <td>
//                                <strong>' . TXT_UCF('TASKS') . ': </strong>
//                            </td>
//                            <td>';
//
//                            if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS) && ($id_ksp == null)) {
//                                $add_pdptask_btn = '
//                                <input type="button" id="addTaskBtn" value="' . TXT_BTN('ADD_NEW_TASK') . '" class="btn btn_width_150" onclick="xajax_moduleEmployees_pdpActionTaskForm_deprecated(\'\', ' . $id_pdpea . ', ' . $id_e . ',' . FORM_MODE_NEW . ');return false;">';
//                            } else {
//                                $add_pdptask_btn = '&nbsp;';
//                            }
//
//                            $sql = 'SELECT
//                                        *
//                                    FROM
//                                        employees_pdp_tasks
//                                    WHERE
//                                        customer_id = ' . CUSTOMER_ID . '
//                                        AND ID_PDPEA = ' . $pdpea['ID_PDPEA'] . '
//                                    ORDER BY
//                                        STR_TO_DATE(end_date, "%d-%m-%Y") DESC';
//                            $get_ept = BaseQueries::performQuery($sql);
//
//                            if (@mysql_num_rows($get_ept) == 0) {
//                                $getemp_pdpa .= TXT_UCF('NO_TASKS_RETURN') . '<br/><br/>';
//                                $logs = '';
//                            } else {
//                                $getemp_pdpa .='
//                                <table border="0" width="100%" cellspacing="0" cellpadding="1">';
//
//                                while ($get_ept_row = @mysql_fetch_assoc($get_ept)) {
//                                    $sql = 'SELECT
//                                                *
//                                            FROM
//                                                pdp_task_ownership
//                                            WHERE
//                                                customer_id = ' . CUSTOMER_ID . '
//                                                AND ID_PDPTO = ' . $get_ept_row['ID_PDPTO'];
//                                    $pdptoQuery = BaseQueries::performQuery($sql);
//                                    $get_pdpto = @mysql_fetch_assoc($pdptoQuery);
//
//                                    $is_completed = $get_ept_row[is_completed] == 1 ? TXT_UCW('COMPLETED') : TXT_UCW('NOT_COMPLETED');
//
//                                    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS) && ($id_ksp == null)) {
//                                        $edit_pdptask_btn = '
//                                        <a href="" onclick="xajax_moduleEmployees_pdpActionTaskForm_deprecated(' . $get_ept_row['ID_PDPET'] . ', ' . $id_pdpea . ', ' . $id_e . ', ' . FORM_MODE_EDIT . ');return false;" title="' . TXT_UCF('EDIT') . ' ' . TXT_UCF('TASK'). '">
//                                            <img src="' . ICON_EDIT . '" class="icon-style" border="0">
//                                        </a>
//                                        <a href="" onclick="xajax_moduleEmployees_deletePDPActionsTask_deprecated(' . $get_ept_row['ID_PDPET'] . ', ' . $id_pdpea . ', ' . $id_e . ');return false;" title="' . TXT_UCF('DELETE') . ' ' . TXT_UCF('TASK'). '">
//                                            <img src="' . ICON_DELETE . '" class="icon-style" border="0">
//                                        </a> &nbsp; ';
//                                    } else {
//                                        $edit_pdptask_btn = '&nbsp;';
//                                    }
//
//                                    $getemp_pdpa .='
//                                    <tr>
//                                        <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCW('TASK_OWNER') . '</td>
//                                        <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCW('COMPLETION_DATE') . '</td>
//                                        <td class="bottom_line mod_employees_tasks_heading">' . TXT_UCW('STATUS') . '</td>
//                                        <td class="bottom_line mod_employees_tasks_heading">&nbsp;<td>
//                                    </tr>
//                                    <tr>
//                                        <td class="bottom_line shaded_title">' . $get_pdpto['name'] . '</td>
//                                        <td class="bottom_line shaded_title">' . $get_ept_row['end_date'] . '</td>
//                                        <td class="bottom_line shaded_title">' . $is_completed . '</td>
//                                        <td class="bottom_line shaded_title" align="right">' . $edit_pdptask_btn . '</td>
//                                    </tr>
//                                    <tr>
//                                        <td style="padding-bottom: 7px;"><strong>' . TXT_UCF('TASK') . ':</strong></td>
//                                        <td colspan="3" style="padding-bottom: 7px;">' . nl2br($get_ept_row['task']) . '</td>
//                                    </tr>
//                                    <tr>
//                                        <td style="padding-bottom: 7px;"><strong>' . TXT_UCF('REMARKS') . ':</strong></td>
//                                        <td colspan="3" style="padding-bottom: 7px;">' . nl2br($get_ept_row['notes']) . '<br/><br/></td>
//                                    </tr>';
//                                }
//                                $getemp_pdpa .='
//                                    <tr>
//                                        <td colspan="100%"><div id="logs" align="right"></div></td>
//                                    </tr>
//                                </table>';
//                            }
//
//
//                            $getemp_pdpa .='
//                            </td>
//                        </tr>
//                        <tr>
//                            <td>';
//                            if ($id_ksp == null) {
//                                $getemp_pdpa .='
//                                <input type="button" id="moduleEmployeesPDPbackBtn" value="&laquo; ' . TXT_BTN('BACK') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActions_deprecated(' . $id_e . ');return false;">';
//                            } else {
//                                $getemp_pdpa .='
//                                <input type="button" id="moduleEmployeesPDPbackBtn" value="&laquo; ' . TXT_BTN('BACK') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_score_Dict_deprecated(' . $id_e . ','. $id_ksp.');return false;"> ' ;
//                            }
//                            $getemp_pdpa .='<!-- -->
//                            </td>
//                            <td>' . $add_pdptask_btn . '</td>
//                        </tr>
//                    </table>
//                </td>
//            </tr>
//        </table>';
//
//        $sql = 'SELECT
//                    *
//                FROM
//                    employees_pdp_tasks
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_E = ' . $id_e . '
//                    AND ID_PDPEA = ' . $id_pdpea . '
//                ORDER BY
//                    STR_TO_DATE(modified_date, "%Y-%m-%d") DESC,
//                    modified_time DESC';
//        $logQuery = BaseQueries::performQuery($sql);
//        $get_pdpet_log = @mysql_fetch_assoc($logQuery);
//
//        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $get_pdpet_log[modified_by_user], $get_pdpet_log[modified_date], $get_pdpet_log[modified_time]);
//        $objResponse->assign('empPrint', 'innerHTML', $getemp_pdpa);
//    }
//
//    return $objResponse;
//}

//function moduleEmployees_score_Dict_deprecated($id_e, $id_ksp) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORES)) {
//        $isEdit = 0;
//        $showAsSub = 0;
//
//        $objResponse->call(xajax_moduleEmployees_subScoreDisplayDict_deprecated, $id_e , $id_ksp, $isEdit, $showAsSub);
//    }
//
//    return $objResponse;
//}


//function employees_processSafeForm_addPDPActions_deprecated($objResponse, $safeFormHandler)
//{
//    $hasError = true;
//    if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $id_e = $safeFormHandler->retrieveSafeValue('ID_E');
//        $id_pd = $safeFormHandler->retrieveSafeValue('ID_PD');
//        $id_pdpaid = $safeFormHandler->retrieveSafeValue('ID_PDPAID');
//
//        $id_pdptoid = $safeFormHandler->retrieveInputValue('user_id');
//        $start_date = $safeFormHandler->retrieveInputValue('start_date');
//        $end_date = $safeFormHandler->retrieveInputValue('end_date');
//        $notes = $safeFormHandler->retrieveInputValue('notes');
//        $prev_skills = $safeFormHandler->retrieveInputValue('IDs_PREV_SKILLS'); // ?
//
//        if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
//            //$fill_cluster   = $safeFormHandler->retrieveInputValue('fill_cluster');
//            $fill_action    = $safeFormHandler->retrieveInputValue('fill_action');
//            $fill_provider  = $safeFormHandler->retrieveInputValue('fill_provider');
//            $fill_duration  = $safeFormHandler->retrieveInputValue('fill_duration');
//            $fill_cost      = $safeFormHandler->retrieveInputValue('fill_cost');
//        }
//
//        // validatie
//        $hasError = false;
//
//
//        if (empty($id_pdpaid) && !CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
//        }
//        if (empty($id_pdptoid)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
//        }
//        if (empty($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_A_DEADLINE_DATE');
//        }
//        if (!empty($start_date) && strtotime($start_date) >= strtotime($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_DEADLINE_DATE');
//        }
//        if(!empty($start_date) && empty($id_pd)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
//        }
//        if(!empty($id_pd) && empty($start_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AN_EMAIL_DATE');
//        }
//
//        if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
////            if (empty($fill_cluster)) {
////                $hasError = true;
////                $message = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
////            } else
//            if (empty($fill_action)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_ACTION');
//            }
//            if (empty($fill_provider)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
//            }
//            if (empty($fill_duration)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_DURATION');
//            }
//            if (!is_numeric($fill_cost)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_COST');
//            }
//        }
//
//        // einde validatie
//
//        if (!$hasError) {
//
//            $hasError = true;
//            BaseQueries::startTransaction();
//
//            if (empty($id_pdpaid)) {
//                //&& CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION)
//                $sql = 'SELECT
//                            *
//                        FROM
//                            pdp_actions
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                            AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER;
//            } else {
//                $sql = 'SELECT
//                            *
//                        FROM
//                            pdp_actions
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                            AND ID_PDPA = ' . $id_pdpaid;
//            }
//            $actionQuery = BaseQueries::performTransactionalSelectQuery($sql);
//            $ge_act_info = @mysql_fetch_assoc($actionQuery);
//
//            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
//                $action         = $ge_act_info['action'];
//                $provider       = $ge_act_info['provider'];
//                $duration       = $ge_act_info['duration'];
//                $cost           = $ge_act_info['costs'];
//
//                $isUserDefined  =   $action     != $fill_action ||
//                                    $provider   != $fill_provider ||
//                                    $duration   != $fill_duration ||
//                                    $cost       != $fill_cost;
//            } else {
//                $fill_action    = $ge_act_info['action'];
//                $fill_provider  = $ge_act_info['provider'];
//                $fill_duration  = $ge_act_info['duration'];
//                $fill_cost      = $ge_act_info['costs'];
//                $isUserDefined  = false;
//            }
//            $is_completed   = 0;
//
//
//
//            $id_pdpea = PdpActionLibraryQueriesDeprecated::addEmployeePdpAction($id_e,
//                                                                                $id_pdpaid,
//                                                                                $id_pdptoid,
//                                                                                $fill_action,
//                                                                                $fill_provider,
//                                                                                $fill_duration,
//                                                                                $fill_cost,
//                                                                                ($isUserDefined ? PDP_ACTION_USER_DEFINED : PDP_ACTION_FROM_LIBRARY),
//                                                                                $is_completed,
//                                                                                $start_date,
//                                                                                $end_date,
//                                                                                $notes);
//
//            if (!empty($start_date) && !empty($id_pd)) {
//                $sql = 'SELECT
//                            *
//                        FROM
//                            notification_message
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                        ORDER BY
//                            ID_NM';
//                $neQuery = BaseQueries::performQuery($sql);
//                $ne = @mysql_fetch_assoc($neQuery);
//
//                foreach ($id_pd as $value => $id_pd2) {
//                    $hash_id = ModuleUtils::createUniqueHash('alerts');
//                    PdpActionLibraryQueriesDeprecated::addPdpActionAlert( $id_pdptoid,
//                            NULL,
//                                                                $id_pdpea,
//                                                                $hash_id,
//                                                                $id_pd2,
//                                                                $ne['ID_NM'],
//                                                                $start_date);
//
//                }
//            }
//            PdpActionSkillServiceDeprecated::processActionSkills($id_pdpea, $id_e, $safeFormHandler);
//
//            BaseQueries::finishTransaction();
//            $hasError = false;
//
//            $objResponse->loadCommands(moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e));
//        }
//    }
//    return array($hasError, $message);
//}
//
//function employees_processSafeForm_editPDPActions_deprecated($objResponse, $safeFormHandler)
//{
//    $hasError = true;
//    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//
//        $id_pdpea = $safeFormHandler->retrieveSafeValue('ID_PDPEA');
//        $id_e = $safeFormHandler->retrieveSafeValue('ID_E');
//        $id_pd = $safeFormHandler->retrieveSafeValue('ID_PD');
//
//        $id_pdpaid = $safeFormHandler->retrieveInputValue('ID_PDPAID');
//        $id_pdpaid = !empty($id_pdpaid) ? $id_pdpaid : $safeFormHandler->retrieveSafeValue('prev_ID_PDPAID');
//
//
//        $id_pdptoid = $safeFormHandler->retrieveInputValue('user_id');
//        $is_completed = $safeFormHandler->retrieveInputValue('is_completed');
//        $start_date = $safeFormHandler->retrieveInputValue('start_date');
//        $end_date = trim($safeFormHandler->retrieveInputValue('end_date'));
//        $notes = trim($safeFormHandler->retrieveInputValue('notes'));
//        $prev_skills = $safeFormHandler->retrieveInputValue('IDs_PREV_SKILLS');
//
//        if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
//            $fill_cluster   = $safeFormHandler->retrieveInputValue('fill_cluster');
//            $fill_action    = $safeFormHandler->retrieveInputValue('fill_action');
//            $fill_provider  = $safeFormHandler->retrieveInputValue('fill_provider');
//            $fill_duration  = $safeFormHandler->retrieveInputValue('fill_duration');
//            $fill_cost      = $safeFormHandler->retrieveInputValue('fill_cost');
//        }
//
//        $hasError = false;
//        if (empty($id_pdpaid)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
//        } elseif (empty($id_pdptoid)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
//        } elseif (!empty($start_date) && strtotime($start_date) >= strtotime($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_DEADLINE_DATE');
//        }  elseif(!empty($start_date) && empty($id_pd)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
//        }  elseif(!empty($id_pd) && empty($start_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AN_EMAIL_DATE');
//        }
//        if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
//            if (empty($fill_cluster)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
//            } elseif (empty($fill_action)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_ACTION');
//            } elseif (empty($fill_provider)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
//            } elseif (empty($fill_duration)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_DURATION');
//            } elseif (!is_numeric($fill_cost)) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_ENTER_THE_COST');
//            }
//        }
//
//        if (!$hasError) {
//            $hasError = true;
//            BaseQueries::startTransaction();
//
//            $modified_by_user = USER;
//            $modified_time = MODIFIED_TIME;
//            $modified_date = MODIFIED_DATE;
//
//            $sql = 'SELECT
//                        *
//                    FROM
//                        pdp_actions
//                    WHERE
//                        customer_id = ' .CUSTOMER_ID . '
//                        AND ID_PDPA = ' . $id_pdpaid;
//            $infoQuery = BaseQueries::performTransactionalSelectQuery($sql);
//            $ge_act_info = @mysql_fetch_assoc($infoQuery);
//
//            $action = $ge_act_info['action'];
//            $provider = $ge_act_info['provider'];
//            $duration = $ge_act_info['duration'];
//            $costs = $ge_act_info['costs'];
//
//
//            $sql = 'UPDATE
//                        employees_pdp_actions
//                    SET
//                        ID_PDPAID = ' . $id_pdpaid . ',
//                        ID_PDPTOID = ' . $id_pdptoid . ',
//                        action = "' . mysql_real_escape_string($action) . '",
//                        provider = "' . mysql_real_escape_string($provider) . '",
//                        duration = "' . mysql_real_escape_string($duration) . '",
//                        costs = "' . mysql_real_escape_string($costs) . '",
//                        start_date = "' . mysql_real_escape_string($start_date) . '",
//                        end_date = "' . mysql_real_escape_string($end_date) . '",
//                        notes = "' . mysql_real_escape_string($notes) . '",
//                        is_completed = ' . $is_completed . ',
//                        modified_by_user = "' . $modified_by_user . '",
//                        modified_time = "' . $modified_time . '",
//                        modified_date = "' . $modified_date . '"
//                    WHERE
//                        customer_id = ' .CUSTOMER_ID . '
//                        AND ID_E = ' . $id_e . '
//                        AND ID_PDPEA = ' . $id_pdpea;
//            BaseQueries::performUpdateQuery($sql);
//
//            // Ook de alerts aanpassen.
//            // Eerst de bestaande, nog niet verstuurde action alerts verwijderen
//            if (! empty($id_pdpea) ) {
//                $sql = 'DELETE
//                        FROM
//                            alerts
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                            AND is_done = ' . ALERT_OPEN . '
//                            AND is_level = ' . ALERT_PDPACTION . '
//                            AND ID_PDPEA = ' . $id_pdpea;
//                BaseQueries::performDeleteQuery($sql);
//            }
//            if (!empty($start_date) && !empty($id_pd)) {
//                $sql = 'SELECT
//                            *
//                        FROM
//                            notification_message
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                        ORDER BY
//                            ID_NM';
//                $neQuery = BaseQueries::performTransactionalSelectQuery($sql);
//                $ne = @mysql_fetch_assoc($neQuery);
//
//                foreach ($id_pd as $value => $id_pd2) {
//
//                    $hash_id = ModuleUtils::createUniqueHash('alerts');
//                    PdpActionLibraryQueriesDeprecated::addPdpActionAlert( $id_pdptoid,
//                            NULL,
//                                                                $id_pdpea,
//                                                                $hash_id,
//                                                                $id_pd2,
//                                                                $ne['ID_NM'],
//                                                                $start_date);
//
//                }
//            }
//
//            PdpActionSkillServiceDeprecated::processActionSkills($id_pdpea, $id_e, $safeFormHandler);
//
//            BaseQueries::finishTransaction();
//            $hasError = false;
//
//            $objResponse->loadCommands(moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e));
//        }
//    }
//    return array($hasError, $message);
//}
//
//function moduleEmployees_deletePDPActions_deprecated($id_pdpea, $id_e) {
//
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_EMPLOYEE_PDP_ACTION'));
//        $objResponse->call("xajax_moduleEmployees_executeDeletePDPActions_deprecated", $id_pdpea, $id_e);
//    }
//
//    return $objResponse;
//}

//function moduleEmployees_executeDeletePDPActions_deprecated($id_pdpea, $id_e) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        // hbd: ook de actie/skill koppeling verwijderen
//        PdpActionSkillServiceDeprecated::deletePdpActionSkills($id_pdpea);
//
//        // taken ophalen
//        $sql = 'SELECT
//                    *
//                FROM
//                    employees_pdp_tasks
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_PDPEA  = ' . $id_pdpea;
//        $get_pdpet = BaseQueries::performQuery($sql);
//
//        if (@mysql_num_rows($get_pdpet) > 0) {
//            // per taak de alert verwijderen
//            while ($get_pdpet_row = @mysql_fetch_assoc($get_pdpet)) {
//                if ( ! empty($get_pdpet_row['ID_PDPET'])) {
//                    $sql = 'DELETE
//                            FROM
//                                alerts
//                            WHERE
//                                customer_id = ' . CUSTOMER_ID . '
//                                AND ID_PDPET = ' . $get_pdpet_row['ID_PDPET'] . '
//                                AND is_level = ' . ALERT_PDPACTIONTASK;
//                    BaseQueries::performQuery($sql);
//                }
//            }
//        }
//
//        // dan de actie alert
//        if (!empty($id_pdpea)) {
//            $sql = 'DELETE
//                    FROM
//                        alerts
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPEA = ' . $id_pdpea . '
//                        AND is_level = ' . ALERT_PDPACTION;
//            BaseQueries::performQuery($sql);
//
//            // vervolgens eerst de taken verwijderen vanwege foreign key constraint
//            $sql = 'DELETE
//                    FROM
//                        employees_pdp_tasks
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPEA = ' . $id_pdpea;
//            BaseQueries::performQuery($sql);
//            // tenslotte de actie
//            $sql = 'DELETE
//                    FROM
//                        employees_pdp_actions
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPEA = ' . $id_pdpea;
//            BaseQueries::performQuery($sql);
//        }
//    }
//
//    return moduleEmployees_pdpActions_deprecated($id_e);
//}

//function getActionTaskFormValidator($form_mode) {
//    $safeFormHandler = null;
//
//    if ($form_mode == FORM_MODE_NEW) {
//        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__ADD_PDPACTIONSTASK_DEPRECATED);
//    } else {
//        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__EDIT_PDPACTIONSTASK_DEPRECATED);
//    }
//
//    return $safeFormHandler;
//}

//function moduleEmployees_pdpActionTaskForm_deprecated($id_pdpet, $id_pdpea, $id_e, $form_mode) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $sql = 'SELECT
//                    *
//                FROM
//                    employees_pdp_actions
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_PDPEA = ' . $id_pdpea;
//        $pdpeaQuery = BaseQueries::performQuery($sql);
//        $pdpea = @mysql_fetch_assoc($pdpeaQuery);
//        if (!empty($id_pdpet)) {
//            $sql = 'SELECT
//                        *
//                    FROM
//                        employees_pdp_tasks
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPET = '. $id_pdpet;
//            $pdpetQuery = BaseQueries::performQuery($sql);
//            $pdpet = @mysql_fetch_assoc($pdpetQuery);
//
//            $title = TXT_UCW('UPDATE_TASK');
//        } else {
//            $title = TXT_UCW('ADD_NEW_TASK');
//        }
//
//        $safeFormHandler = getActionTaskFormValidator($form_mode);
//
//        $safeFormHandler->storeSafeValue('ID_PDPET', $id_pdpet);
//        $safeFormHandler->storeSafeValue('ID_PDPEA', $id_pdpea);
//        $safeFormHandler->storeSafeValue('ID_E', $id_e);
//
//        $safeFormHandler->addStringInputFormatType('task');
//        $safeFormHandler->addStringInputFormatType('end_date');
//        $safeFormHandler->addStringInputFormatType('start_date');
//        $safeFormHandler->addStringInputFormatType('notes');
//        $safeFormHandler->addIntegerInputFormatType('ID_PDPTO', true);
//        $safeFormHandler->addIntegerInputFormatType('is_completed');
//        $safeFormHandler->addIntegerArrayInputFormatType('ID_PD');
//
//        $safeFormHandler->finalizeDataDefinition();
//
////        $objResponse->call("xajax_moduleEmployees_getEmailsForNotification_deprecated", 2, $id_pdpet);
//        $pdpActionTask .= '
//        <b>' . $title . '</b><br>
//        <div class="mod_employees_Tasks">
//        <form id="employeesPDPTaskForm" name="employeesPDPTaskForm" onsubmit="submitSafeForm( \'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">
//        ' . $safeFormHandler->getTokenHiddenInputHtml() . '
//        <table  border="0" cellspacing="2" cellpadding="0">
//            <tr>
//            <td width="130">' . TXT_UCW('TASK') . ': </td>
//                    <td>
//                    <select id="addtask" onchange="xajax_moduleEmployees_addPDPTask_deprecated(this.options[this.selectedIndex].value);return false;">
//                    <option value=""> - ' . TXT_LC('SELECT_A_PRE_SELECTED_TASK') . ' - </option>';
//                        $sql = 'SELECT
//                                    task,
//                                    ID_PDPT
//                                FROM
//                                    pdp_task
//                                WHERE
//                                    customer_id = ' . CUSTOMER_ID . '
//                                ORDER BY
//                                    task';
//                        $get_task = BaseQueries::performQuery($sql);
//                        if (@mysql_num_rows($get_task) > 0) {
//                            while ($get_task_row = @mysql_fetch_assoc($get_task)) {
//                            $pdpActionTask .= '
//                            <option value="' . $get_task_row['ID_PDPT'] . '">' . $get_task_row['task'] . '</option>';
//            }
//        }
//        $pdpActionTask .= '
//                    </select>
//                    </td>
//                <tr>
//                <tr>
//                    <td colspan="2">
//                            <textarea id="task" name="task" cols="60" rows="4">' . $pdpet[task] . '</textarea>
//                    </td>
//            </tr>
//        <tr>
//            <td>' . TXT_UCW('TASK_OWNER') . ': </td>';
//
//                    $sql = 'SELECT
//                                *
//                            FROM
//                                pdp_task_ownership
//                            WHERE
//                                customer_id = ' . CUSTOMER_ID . '
//                            ORDER BY
//                                name';
//                    $get_pdpto = BaseQueries::performQuery($sql);
//                    if (@mysql_num_rows($get_pdpto) > 0) {
//                        $pdpActionTask .='
//                    <td>
//                        <select name="ID_PDPTO">
//                            <option value=""> - ' . TXT_UCF('SELECT_TASK_OWNER') . ' - </option>';
//                            while ($pdpto_row = @mysql_fetch_assoc($get_pdpto)) {
//                                $selected = $pdpto_row[ID_PDPTO] == $pdpet[ID_PDPTO] ? 'selected="selected"' : '';
//                                $pdpActionTask .='<option value="' . $pdpto_row[ID_PDPTO] . '" ' . $selected . '>' . $pdpto_row[name] . '</option>';
//                            }
//                        $pdpActionTask .='
//                        </select>
//                    </td>
//            </tr>';
//        }
//        if (empty($id_pdpet)) {
//            $completion_date = $pdpea[end_date];
//            $strStartDate = DateUtils::calculateRelativeDisplayDate($completion_date, DEFAULT_ALERTDATE_OFFSET);
//        } else {
//            $completion_date = $pdpet[end_date];
//            $strStartDate = $pdpet[start_date];
//        }
//        $pdpActionTask .='
//            <tr>
//                <td>' . TXT_UCW('COMPLETION_DATE') . ': </td>
//                <td>
//                <input type="text" name="end_date" id="end_date" size="20" maxlength="0" value="' . $completion_date . '" readonly>
//                <input id="end_date_cal" type="reset" value=" ... " onclick="return showCalendar(\'end_date\', ' . JS_DEFAULT_DATE_FORMAT . ');">
//                </td>
//            </tr>
//        <tr>
//                <td>' . TXT_UCW('NOTIFICATION_DATE') . ': </td>
//                <td>
//                <input type="text" name="start_date" id="start_date" size="20" maxlength="0" value="' . $strStartDate . '" readonly>
//                <input id="start_date_cal" type="reset" value=" ... " onclick="return showCalendar(\'start_date\', ' . JS_DEFAULT_DATE_FORMAT . ');">
//            <a href="" onclick="xajax_moduleEmployees_clearNotificationDate_deprecated();return false;"><img src="' . ICON_ERASE . '" class="icon-style" border="0" title="Clear notification date"></a>
//            </td>
//            </tr>
//            <tr>
//                <td colspan="2">
//                    <div id="ne">' . getEmailsForNotificationHtml(2, $id_pdpet) . '</div>
//                </td>
//            </tr>
//
//        <tr>
//            <td>' . TXT_UCW('COMPLETED') . ': </td>
//                    <td>';
//                        $is_YCompleted = $pdpet[is_completed] == 1 ? 'checked="checked"' : '';
//                        $is_NCompleted = $pdpet[is_completed] <> 1 ? 'checked="checked"' : '';
//                        $pdpActionTask .='
//                        <input name="is_completed" type="radio" value="1" ' . $is_YCompleted . '> ' . TXT_UCF('YES') . '&nbsp;
//                        <input name="is_completed" type="radio" value="0" ' . $is_NCompleted . '> ' . TXT_UCF('NO') . '
//            </td>
//        </tr>
//        <tr>
//            <td colspan="2">' . TXT_UCW('REASONS_REMARKS') . ': <br>
//            <textarea name="notes" cols="60" rows="4">' . $pdpet[notes] . '</textarea>
//            </td>
//        </tr>
//        <tr>
//            <td colspan="2">
//            <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
//            <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleEmployees_pdpActionData_deprecated(' . $id_pdpea . ', ' . $id_e . ');return false;">
//            </td>
//        </tr>
//        </table>
//        </form></div>
//        ';
//        $objResponse->assign('addTaskBtn', 'disabled', true);
//        $objResponse->assign('moduleEmployeesPDPBtn', 'disabled', true);
//        $objResponse->assign('moduleEmployeesPDPbackBtn', 'disabled', true);
//        $objResponse->assign('delTaskBtn', 'disabled', true);
//        $objResponse->assign('empPrint', 'innerHTML', $pdpActionTask);
//    }
//
//    return $objResponse;
//}
//
//function moduleEmployees_addPDPTask_deprecated($task_id) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        if (!empty($task_id)) {
//            $sql = 'SELECT
//                        task,
//                        task_description
//                    FROM
//                        pdp_task
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPT = ' . $task_id;
//            $task_result = BaseQueries::performQuery($sql);
//            $task_info = @mysql_fetch_assoc($task_result);
//
//            // er zijn klanten die alleen de taak hebben ingevuld, dus dan die invoegen
//            $task_description = empty($task_info['task_description']) ? $task_info['task'] :$task_info['task_description'];
//            $objResponse->append('task', 'value', $task_description);
//        }
//    }
//    return $objResponse;
//}
//
//function employees_processSafeForm_addPDPActionsTask_deprecated($objResponse, $safeFormHandler)
//{
//    $hasError = true;
//    if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//
//        $id_e = $safeFormHandler->retrieveSafeValue('ID_E');
//        $id_pdpea = $safeFormHandler->retrieveSafeValue('ID_PDPEA');
//
//        $id_pdpto = $safeFormHandler->retrieveInputValue('ID_PDPTO');
//        $end_date = $safeFormHandler->retrieveInputValue('end_date');
//        $start_date = $safeFormHandler->retrieveInputValue('start_date');
//        $task = addslashes(trim($safeFormHandler->retrieveInputValue('task')));
//        $notes = addslashes(trim($safeFormHandler->retrieveInputValue('notes')));
//        $is_completed = $safeFormHandler->retrieveInputValue('is_completed');
//        $ID_PD = $safeFormHandler->retrieveInputValue('ID_PD');
//
//        $hasError = false;
//        if (empty($task)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_ENTER_A_TASK');
//        } elseif (empty($id_pdpto)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_TASK_OWNER');
//        } elseif (empty($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_A_COMPLETION_DATE');
//        } elseif (strtotime($start_date) >= strtotime($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_COMPLETION_DATE');
//        }  elseif(!empty($start_date) && empty($ID_PD)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
//        }  elseif(!empty($ID_PD) && empty($start_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AN_EMAIL_DATE');
//        }
//
//
//        if (!$hasError) {
//            $hasError = true;
//            BaseQueries::startTransaction();
//
//            $id_pdpet = PdpActionLibraryQueriesDeprecated::addPdpActionTask(  $id_pdpea,
//                                                                    $id_e,
//                                                                    $id_pdpto,
//                                                                    $task,
//                                                                    $notes,
//                                                                    $start_date,
//                                                                    $end_date,
//                                                                    $is_completed);
//
//            if (!empty($ID_PD)) {
//                $sql = 'SELECT
//                            *
//                        FROM
//                            notification_message
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                        ORDER BY
//                            ID_NM DESC';
//                $messageQuery = BaseQueries::performTransactionalSelectQuery($sql);
//                $ne2 = @mysql_fetch_assoc($messageQuery);
//
//                foreach ($ID_PD as $value => $id_pd) {
//                    $hash_id = ModuleUtils::createUniqueHash('alerts');
//                    PdpActionLibraryQueriesDeprecated::addPdpActionTaskAlert( $id_pdpto,
//                                                                    $hash_id,
//                                                                    $id_pdpet,
//                                                                    $id_pd,
//                                                                    $ne2['ID_NM'],
//                                                                    $start_date);
//                }
//            }
//            BaseQueries::finishTransaction();
//            $hasError = false;
//
//            $objResponse->loadCommands(moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e));
//        }
//    }
//    return array($hasError, $message);
//}
//
//function employees_processSafeForm_editPDPActionsTask_deprecated($objResponse, $safeFormHandler)
//{
//    $hasError = true;
//    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//
//        $id_e = $safeFormHandler->retrieveSafeValue('ID_E');
//        $id_pdpet = $safeFormHandler->retrieveSafeValue('ID_PDPET');
//        $id_pdpea = $safeFormHandler->retrieveSafeValue('ID_PDPEA');
//
//        $id_pdpto = $safeFormHandler->retrieveInputValue('ID_PDPTO');
//        $is_completed = $safeFormHandler->retrieveInputValue('is_completed');
//        $end_date = $safeFormHandler->retrieveInputValue('end_date');
//        $start_date = $safeFormHandler->retrieveInputValue('start_date');
//        $task = addslashes(trim($safeFormHandler->retrieveInputValue('task')));
//        $notes = addslashes(trim($safeFormHandler->retrieveInputValue('notes')));
//        $ID_PD = $safeFormHandler->retrieveInputValue('ID_PD');
//
//        $hasError = false;
//        if (empty($task)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_ENTER_A_TASK');
//        } elseif (empty($id_pdpto)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_TASK_OWNER');
//        } elseif (empty($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_A_COMPLETION_DATE');
//        } elseif (strtotime($start_date) >= strtotime($end_date)) {
//            $hasError = true;
//            $message = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_COMPLETION_DATE');
//        }  elseif(!empty($start_date) && empty($ID_PD)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
//        }  elseif(!empty($ID_PD) && empty($start_date)) {
//            $hasError = true;
//            $message = TXT_UCF('PLEASE_SELECT_AN_EMAIL_DATE');
//        }
//
//        if (!$hasError) {
//            $hasError = true;
//            BaseQueries::startTransaction();
//
//            $modified_by_user = USER;
//            $modified_time = MODIFIED_TIME;
//            $modified_date = MODIFIED_DATE;
//
//            $sql = 'UPDATE
//                        employees_pdp_tasks
//                    SET
//                        ID_PDPTO = ' . $id_pdpto . ',
//                        task = "' . mysql_real_escape_string($task) . '",
//                        notes = "' . mysql_real_escape_string($notes) . '",
//                        start_date = "' . mysql_real_escape_string($start_date) . '",
//                        end_date = "' . mysql_real_escape_string($end_date) . '",
//                        is_completed = ' . $is_completed . ',
//                        modified_by_user = "' . $modified_by_user . '",
//                        modified_time = "' . $modified_time . '",
//                        modified_date = "' . $modified_date . '"
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_PDPET = ' . $id_pdpet;
//            BaseQueries::performUpdateQuery($sql);
//
//            if (! empty($id_pdpet)) {
//                // Eerst de bestaande, nog niet verstuurde alerts verwijderen
//                $sql = 'DELETE
//                        FROM
//                            alerts
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                            AND is_done  = ' . ALERT_OPEN . '
//                            AND is_level = ' . ALERT_PDPACTIONTASK . '
//                            AND ID_PDPET = ' . $id_pdpet;
//                BaseQueries::performDeleteQuery($sql);
//            }
//
//            if (!empty($ID_PD)) {
//                $sql = 'SELECT
//                            *
//                        FROM
//                            notification_message
//                        WHERE
//                            customer_id = ' . CUSTOMER_ID . '
//                        ORDER BY
//                            ID_NM DESC';
//                $ne2Query = BaseQueries::performTransactionalSelectQuery($sql);
//                $ne2 = @mysql_fetch_assoc($ne2Query);
//
//                foreach ($ID_PD as $value => $id_pd) {
//                    $hash_id = ModuleUtils::createUniqueHash('alerts');
//                    PdpActionLibraryQueriesDeprecated::addPdpActionTaskAlert( $id_pdpto,
//                                                                    $hash_id,
//                                                                    $id_pdpet,
//                                                                    $id_pd,
//                                                                    $ne2['ID_NM'],
//                                                                    $start_date);
//                }
//            }
//            BaseQueries::finishTransaction();
//            $hasError = false;
//
//            $objResponse->loadCommands(moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e));
//        }
//    }
//    return array($hasError, $message);
//}
//
//function moduleEmployees_deletePDPActionsTask_deprecated($id_pdpet, $id_pdpea, $id_e) {
//
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_PDP_ACTION_TASK'));
//        $objResponse->call("xajax_moduleEmployees_executeDeletePDPActionsTask_deprecated", $id_pdpet, $id_pdpea, $id_e);
//    }
//
//    return $objResponse;
//}
//
//function moduleEmployees_executeDeletePDPActionsTask_deprecated($id_pdpet, $id_pdpea, $id_e) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
//        $sql = 'DELETE
//                FROM
//                    employees_pdp_tasks
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_PDPET = ' . $id_pdpet;
//        BaseQueries::performQuery($sql);
//
//        $sql = 'DELETE
//                FROM
//                    alerts
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND is_level = ' . ALERT_PDPACTIONTASK . '
//                    AND ID_PDPET = ' . $id_pdpet;
//        BaseQueries::performQuery($sql);
//    }
//
//    return moduleEmployees_pdpActionData_deprecated($id_pdpea, $id_e);
//}

// +-----------------------+
// | PRINT MODULES         +
// +-----------------------+

?>