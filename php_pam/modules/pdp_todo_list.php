<?php

function modulePDPToDoList_menu() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $objResponse->call("xajax_modulePDPToDoList");
    }
    return $objResponse;
}

function modulePDPToDoList() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_PDP_TODO_LIST);

        $html = '
        <div id="pdp_todolist_main" class="pdptodolist_window1">
        <table width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="left_panel" width="20%">
                        <div id="pdp_todolist_sub1">
                        <p style="padding-bottom:5px;">' . TXT_UCW('ACTION_OWNER') . '</p>
                        <select name="user" onclick="xajax_pdptodolist_getValues(this.options[this.selectedIndex].value)" style="width: 200px;">
                        ';

        $sql = 'SELECT
                    user_id,
                    username,
                    name
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    name';
        $queryResult = BaseQueries::performQuery($sql);

        $html .='<option value="">- ' . TXT_UCF('SELECT') . ' -</option>';

        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            $html .= '<option value="' . $queryResult_row['user_id'] . '">' . ucwords($queryResult_row['name']) . '</option>
                      ';
        }
        $html .='</select>

                        </div>
                    </td>
                    <td class="right_panel" width="80%">
                    <div id="rightDiv">
                    <div class="top_nav">
                    <input type="button" value="' . TXT_BTN('PRINT_OPTIONS') . '" class="btn btn_width_80" onclick="xajax_pdptodolist_print();return false;">
                    </div>
                        <p>' . TXT_UCF('ACTION') . ':<p>
                        <div id="pdp_todolist_sub2">';

        $html .='
                        <table width="100%" cellspacing="1" cellpadding="1">
                            <tr>
                                <td class="bottom_line pdptodo_tdbg">' . TXT_UCW('ACTION_OWNER') . '</td>
                                <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('ACTION') . '</td>
                                <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('TASKS') . '</td>
                                <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('DEADLINE_DATE') . '</td>
                                <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('EMPLOYEE') . '</td>
                            </tr>';

        if (USER_LEVEL == UserLevelValue::MANAGER || USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
            $sql = 'SELECT
                        u.username,
                        u.name,
                        epa.ID_PDPTOID,
                        epa.ID_PDPEA,
                        e.employee,
                        pa.provider,
                        pa.action,
                        epa.start_date,
                        epa.end_date
                    FROM
                        employees_pdp_actions epa
                        INNER JOIN pdp_actions pa
                            ON epa.ID_PDPAID = pa.ID_PDPA
                        INNER JOIN employees e
                            ON e.ID_E = epa.ID_E
                                AND e.ID_DEPTID in (    SELECT
                                                            ud.ID_DEPT
                                                        FROM
                                                            users_department ud
                                                            INNER JOIN users u
                                                                ON ud.ID_UID = u.user_id
                                                            INNER JOIN department d
                                                                ON ud.ID_DEPT = d.ID_DEPT
                                                            WHERE
                                                                u.user_id = ' . USER_ID . '
                                                    )
                        INNER JOIN users u
                            ON u.user_id = epa.ID_PDPTOID
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    ORDER BY
                        epa.ID_PDPEA DESC,
                        epa.ID_PDPTOID ASC';
        } else {
            $sql = 'SELECT
                        u.username,
                        u.name,
                        epa.ID_PDPTOID,
                        epa.ID_PDPEA,
                        e.employee,
                        pa.provider,
                        pa.action,
                        epa.start_date,
                        epa.end_date
                    FROM
                        employees_pdp_actions epa
                        INNER JOIN pdp_actions pa
                            ON epa.ID_PDPAID = pa.ID_PDPA
                        INNER JOIN employees e
                            ON e.ID_E = epa.ID_E
                        INNER JOIN users u
                            ON u.user_id = epa.ID_PDPTOID
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    ORDER BY
                        epa.ID_PDPEA DESC,
                        epa.ID_PDPTOID ASC';
        }

        $resultQuery = BaseQueries::performQuery($sql);

        while ($queryResult_row = @mysql_fetch_assoc($resultQuery)) {
            $sql = 'SELECT
                        count(ept.id_pdpet) as total_tasks
                    FROM
                        employees_pdp_tasks ept
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ept.ID_PDPEA = '. $queryResult_row['ID_PDPEA'];
            $taskQuery = BaseQueries::performQuery($sql);
            $tasks_found = @mysql_fetch_assoc($taskQuery);
            $html .='
                                <tr>
                                    <td class="pdptodo_bottom_line">' . ucwords($queryResult_row['name']) . '</td>
                                    <td class="pdptodo_bottom_line">
                                        <a id="pdptodo_link_ea_' . $queryResult_row['ID_PDPEA'] .'" href="javascript:void(0);" onclick="xajax_pdptodolist_getTargets(' . $queryResult_row['ID_PDPEA'] . ', 0)">
                                        ' . $queryResult_row['action'] . '</a>
                                    </td>
                                    <td class="pdptodo_bottom_line">' . ($tasks_found[total_tasks] > 0 ? $tasks_found['total_tasks'] : '&nbsp;') .'</td>
                                    <td class="pdptodo_bottom_line">' . $queryResult_row['end_date'] . '</td>
                                    <td class="pdptodo_bottom_line">' . $queryResult_row['employee'] . '</td>
                                                            </tr>
                                                            <tr>
                                                                <td></td>
                                                                <td colspan="4"><div id="pdptodo_list_ea_' . $queryResult_row['ID_PDPEA'] . '"></div></td>
                                </tr>';
        }

        $html .='</table>';

        $html .= '</div>
                    <br>
                        <!--p>' . TXT_UCF('TASKS') . '</p-->
                        <div id="pdp_todolist_sub3">
                        </div>
                    </div>
                    </td>
                </table>
            </div>';



        $objResponse->assign('module_main_panel', 'innerHTML', $html);

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_PDP_TODO_LIST));
    }

    return $objResponse;
}

function pdptodolist_getValues($user_id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $html = '
        <table width="100%" cellspacing="1" cellpadding="1">
            <tr>';
        //if ( empty ($user_id)) {
                $html .= '<td class="bottom_line pdptodo_tdbg">' . TXT_UCW('ACTION_OWNER') . '</td>';
        //}
        $html .= '	<td class="bottom_line pdptodo_tdbg">' . TXT_UCF('ACTION_OWNER') . '</td>
                    <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('ACTION') . '</td>
                    <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('DEADLINE_DATE') . '</td>
                    <td class="bottom_line pdptodo_tdbg">' . TXT_UCF('EMPLOYEE') . '</td>
            </tr>';

        $sql = 'SELECT
                    u.name,
                    epa.ID_PDPEA,
                    e.employee, e.is_inactive,
                    pa.provider,
                    pa.action,
                    epa.start_date,
                    epa.end_date
                FROM
                    employees_pdp_actions epa
                    JOIN pdp_actions pa ON epa.ID_PDPAID = pa.ID_PDPA
                    JOIN employees e ON e.ID_E = epa.ID_E
                    JOIN users u ON u.user_id = epa.ID_PDPTOID
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                   ';

        if (!empty($user_id)) {
            $sql .= ' AND epa.ID_PDPTOID = ' . $user_id . '
                    ';
        }
            $sql .= 'ORDER BY
                        epa.ID_PDPEA DESC,
                        epa.ID_PDPTOID ASC';
        $resultQuery = BaseQueries::performQuery($sql);

        while ($queryResult_row = @mysql_fetch_assoc($resultQuery)) {
            $html .= '
                <tr>';
            //if ( empty ($user_id)) {
                    $html .= '<td class="pdptodo_bottom_line">' . ucwords($queryResult_row['name']) . '</td>';
            //}
            $sql = 'SELECT
                        count(ept.id_pdpet) as total_tasks
                    FROM
                        employees_pdp_tasks ept
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ept.ID_PDPEA = '. $queryResult_row[ID_PDPEA];
            $taskQuery = BaseQueries::performQuery($sql);
            $tasks_found = @mysql_fetch_assoc($taskQuery);

            $html .= '<td class="pdptodo_bottom_line">
                        <a id="pdptodo_link_ea_' . $queryResult_row['ID_PDPEA'] .'" href="javascript:void(0);" onclick="xajax_pdptodolist_getTargets(' . $queryResult_row['ID_PDPEA'] . ', 0)">
                        ' . $queryResult_row['action'] . '</a>
                    </td>
                    <td class="pdptodo_bottom_line">' . ($tasks_found[total_tasks] > 0 ? $tasks_found['total_tasks'] : '&nbsp;') .'</td>

                    <!--<td class="pdptodo_bottom_line">task here</td>-->
                    <td class="pdptodo_bottom_line">' . $queryResult_row['end_date'] . '</td>
                    <td class="pdptodo_bottom_line">' . $queryResult_row['employee'] . '</td>
                </tr>
                <tr>
                    <td></td>
                    <td colspan="4"><div id="pdptodo_list_ea_' . $queryResult_row['ID_PDPEA'] . '"></div></td>
                </tr>';
        }
        $html .='</table>';
        $objResponse->assign('pdp_todolist_sub2', 'innerHTML', $html);
        $objResponse->assign('pdp_todolist_sub3', 'innerHTML', '');
    }

    return $objResponse;
}

function pdptodolist_getTargets($ID_PDPEA, $hide_targets = 0) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $html = '
        <table width="100%" cellspacing="0" cellpadding="1">
                <tr><td><strong>' . TXT_UCF('TASKS') . '</strong></td></tr>
                <tr><td>&nbsp;</td></tr>';

        $sql = 'SELECT
                    ept.ID_PDPET,
                    ept.end_date,
                    pto.name,
                    e.employee,
                    ept.task,
                    ept.is_completed
                FROM
                    employees_pdp_tasks ept
                    INNER JOIN pdp_task_ownership pto
                        ON pto.ID_PDPTO = ept.ID_PDPTO
                    INNER JOIN employees e
                        ON e.ID_E = ept.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND ept.ID_PDPEA = ' . $ID_PDPEA . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                ORDER BY
                    ept.ID_PDPET';
        $resultQuery = BaseQueries::performQuery($sql);

        if (mysql_num_rows($resultQuery) > 0) {

            $i = 0;
            while ($queryResult_row = @mysql_fetch_assoc($resultQuery)) {

                if ($i != 0) {
                    $html .='<tr><td colspan="4"><hr></td></tr>';
                }

                $html .='<tr>
                        <td width="10%">&nbsp;
                        <a  class="a_emp" href="javascript:void(0);"
                            onclick="MM_openBrWindow(\'print/print_pdptodolist.php?id_pdpet=' . $queryResult_row['ID_PDPET'] . '\',\'\',\'resizable=yes, width=800,height=800\');return false;">
                            <img src="images/pdf.png" class="a_emp" width="15px" height="15px"/></a>
                        &nbsp;' . TXT_UCF('DEADLINE') . ':</td>
                        <td align="left" width="45%"><b> ' . $queryResult_row['end_date'] . '</b></td>
                        <td align="right" width="5%"><!--' . TXT_UCF('EMPLOYEE') . ':--></td>
                        <td align="left" width="30%"><!--b> ' . $queryResult_row['employee'] . '</b--></td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;' . TXT_UCF('COMPLETED'). ':</td>
                        <td align="left" colspan="3"> ' . ($queryResult_row['is_completed'] == '1' ? TXT_UCF('YES') : TXT_UCF('NO')) . '</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;' . TXT_UCW('TASK_OWNER') . ':</td>
                        <td align="left" colspan="3"> ' . $queryResult_row['name'] . '</td>
                    </tr>
                    <tr>
                        <td>&nbsp;&nbsp;' . TXT_UCF('TASK') . ':</td>
                        <td colspan="3"> ' . $queryResult_row['task'] . '</td>
                    </tr>';
                $i++;
            }
        } else {

            $html .='

            <tr><td><font size="1" color="indicator">&nbsp;&nbsp;' . TXT_UCF('THERE_ARE_NO_TASK_UNDER_THE_SELECTED_ACTION') . '</font></td></tr>';
        }


        $html .='<tr><td>&nbsp;</td></tr>
            </table>';

        if ($hide_targets == 1) {
    //        $objResponse->assign('pdptodo_list_ea_'. $ID_PDPEA, 'innerHTML', '<td colspan="5"></td>');
            $objResponse->assign('pdptodo_list_ea_'. $ID_PDPEA, 'innerHTML', '');
            $objResponse->addEvent('pdptodo_link_ea_' . $ID_PDPEA, 'onclick', 'xajax_pdptodolist_getTargets(' .$ID_PDPEA . ', 0);return false;');
        } else {
    //        $objResponse->assign('pdptodo_list_ea_'. $ID_PDPEA, 'innerHTML', '<td></td><td colspan="4">' . $html . '</td>');
            $objResponse->assign('pdptodo_list_ea_'. $ID_PDPEA, 'innerHTML', $html);
            $objResponse->addEvent('pdptodo_link_ea_' . $ID_PDPEA, 'onclick', 'xajax_pdptodolist_getTargets(' .$ID_PDPEA . ', 1);return false;');
        }
    }

    return $objResponse;
}

function pdptodolist_print() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_PDP_TODO_LIST)) {

        $html = '
        <div class="pdptodolist_print">
        <form name ="frm_pdptodolist" id="pdptodolist_frm" action="#">
        <font size="3"><b>' . TXT_UCF('PDP_TODO_LIST') . '</b></font>
        <table width="100%">
            <tr>
                <td align="right" colspan="5">
                    <input type="button" disabled value="' . TXT_UCF('PRINT') . '" id="pdp_print_btn" class="btn btn_width_80"
                    onclick="MM_openBrWindow(\'print/print_pdptodolist_defined.php?uid=\' + document.getElementById(\'hid_selactionOwner\').value + \'&id_e=\' + document.getElementById(\'hid_selEmployees\').value + \'&id_pdpto=\' + document.getElementById(\'hid_selTaskOwners\').value + \'&id_pdppa=\' + document.getElementById(\'hid_selAction\').value + \'&radoption=\' + document.getElementById(\'hid_print_options_rad\').value,\'\',\'resizable=yes, width=800,height=800\');return false;">&nbsp;&nbsp;
                    <input type="button" value="' . TXT_UCF('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPToDoList();return false;">
                </td>
            </tr>
            <tr>
                <td align="left" width="25%">
                ' . TXT_UCF('OPTIONS') . '
                <div class="pdptodolist_printOptions">
                    <input type="radio" name="print_options" id="print_options" value="4"
                        onclick="xajax_modulePDPTodoList_actionOwner(); document.getElementById(\'hid_print_options_rad\').value = 4; xajax_pdptodolist_setUsers(4); xajax.$(\'pdp_print_btn\').disabled=true;"/>
                        ' . TXT_UCW('ACTION_OWNER') . '<br/>

                    <input type="radio" name="print_options" id="print_options" value="0"
                        onclick="xajax_pdptodolist_singleEmployee(); document.getElementById(\'hid_print_options_rad\').value = 0; xajax_pdptodolist_setUsers(0); xajax.$(\'pdp_print_btn\').disabled=true;"/>
                        ' . TXT_UCW('SINGLE_EMPLOYEE') . '<br/>

                    <input type="radio" name="print_options" id="print_options" value="1"
                        onclick="xajax_pdptodolist_allEmployees(); document.getElementById(\'hid_print_options_rad\').value = 1; xajax_pdptodolist_setUsers(1); xajax.$(\'pdp_print_btn\').disabled=false;"/>
                        ' . TXT_UCF('ALL_EMPLOYEES') . ' <br/>

                    <input type="radio" name="print_options" id="print_options" value="2"
                        onclick="xajax_pdptodolist_taskOwner(); document.getElementById(\'hid_print_options_rad\').value = 2; xajax_pdptodolist_setUsers(2); xajax.$(\'pdp_print_btn\').disabled=true;" />
                        ' . TXT_UCW('TASK_OWNER') . '<br/>

                    <input type="radio" name="print_options" id="print_options" value="3"
                        onclick="xajax_modulePDPTodoList_allActions(); document.getElementById(\'hid_print_options_rad\').value = 3; xajax_pdptodolist_setUsers(3); xajax.$(\'pdp_print_btn\').disabled=true;" />
                        ' . TXT_UCF('ACTION') . '<br/>

                    <input type="hidden" name="hid_print_options_rad" id="hid_print_options_rad" value="0" />
                    <input type="hidden" name="hid_selactionOwner" id="hid_selactionOwner" value="0" />
                    <input type="hidden" name="hid_selEmployees" id="hid_selEmployees" value="0" />
                    <input type="hidden" name="hid_selTaskOwners" id="hid_selTaskOwners" value="0" />
                    <input type="hidden" name="hid_selAction" id="hid_selAction" value="0" />
                    <br>
                </div>
                </td>
                <td align="left" width="15%">
                    <div id="td_users">';

        $html .= '
                    ' . TXT_UCW('ACTION_OWNER') . ':<br/>
                    <select class="pdptodolist_selUsers" disabled name="sel_users" id="sel_users" size="20"
                                onclick="xajax_pdptodolist_getSelectValues(this.options[this.selectedIndex].value, document.getElementById(\'hid_print_options_rad\').value);">';

        $sql = 'SELECT
                    user_id,
                    username,
                    name
                FROM
                    users
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    username';
        $resultQuery = BaseQueries::performQuery($sql);

        while ($queryResult_row = @mysql_fetch_assoc($resultQuery)) {

            $html .='
                                <option value="' . $queryResult_row['user_id'] . '">
                                    ' . ucwords($queryResult_row['name']) . '
                                </option>';
        }
        $html .='
                    </select>';


        $html .= '</div>
                </td>
                <td align="left" width="20%">
                    <div id="td_taskowners">';

        $html .='
                    ' . TXT_UCW('TASK_OWNER') . ':<br/>
                    <select class="pdptodolist_selTaskOwners" disabled name="sel_taskowners" id="sel_taskowners" size="20"
                    onclick="document.getElementById(\'hid_selTaskOwners\').value = this.options[this.selectedIndex].value;
                    document.getElementById(\'hid_selEmployees\').value = 0;
                    xajax.$(\'pdp_print_btn\').disabled=false;">';

        $sql = 'SELECT
                    pto.ID_PDPTO,
                    pto.name
                FROM
                    employees_pdp_tasks ept
                    JOIN employees_pdp_actions epa ON epa.ID_PDPEA = ept.ID_PDPEA
                    JOIN users u ON u.user_id = epa.ID_PDPTOID
                    JOIN pdp_actions pa ON pa.ID_PDPA = epa.ID_PDPAID
                    JOIN pdp_task_ownership pto ON pto.ID_PDPTO = ept.ID_PDPTO
                    JOIN employees e ON e.ID_E = ept.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                GROUP BY
                    pto.name';

        $taskQuery = BaseQueries::performQuery($sql);
        while ($taskRow = @mysql_fetch_assoc($taskQuery)) {
            $html .='
                                <option value="' . $taskRow['ID_PDPTO'] . '" >
                                    ' . $taskRow['name'] . '
                                </option>';
        }

        $html .='
                    </select>';

        $html .='</div>
                </td>
                <td align="left" width="20%">
                    <div id="td_employees">';


        $html .='
                    ' . TXT_UCF('EMPLOYEE') . ':<br/>
                    <select class="pdptodolist_selEmployees" disabled name="sel_employees" id="sel_employees" size="20"
                    onclick="document.getElementById(\'hid_selEmployees\').value = this.options[this.selectedIndex].value;
                    document.getElementById(\'hid_selTaskOwners\').value = 0;
                    xajax.$(\'pdp_print_btn\').disabled=false;">';

        $sql = 'SELECT
                    e.ID_E,
                    e.employee
                FROM
                    employees_pdp_tasks ept
                    INNER JOIN employees_pdp_actions epa ON epa.ID_PDPEA = ept.ID_PDPEA
                    INNER JOIN users u ON u.user_id = epa.ID_PDPTOID
                    INNER JOIN pdp_actions pa ON pa.ID_PDPA = epa.ID_PDPAID
                    INNER JOIN pdp_task_ownership pto ON pto.ID_PDPTO = ept.ID_PDPTO
                    INNER JOIN employees e ON e.ID_E = ept.ID_E
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                GROUP BY
                    e.employee';

        $employeeQuery = BaseQueries::performQuery($sql);

        $i = 1;
        while ($employeeRow = @mysql_fetch_assoc($employeeQuery)) {
            $html .='
                                <option value="' . $employeeRow['ID_E'] . '" >
                                    ' . $employeeRow['employee'] . '
                                </option>';
            $i++;
        }

        $html .='
                    </select>';


        $html .= '</div>
                </td>
                <td align="left" width="20%">
                    <div id="td_actions">';

        $html .= '
                    ' . TXT_UCF('ACTION') . ':<br/>
                    <select class="pdptodolist_selAction" disabled name="sel_actions" id="sel_actions" size="20"
                                onclick="xajax_pdptodolist_getSelectValues(this.options[this.selectedIndex].value, document.getElementById(\'hid_print_options_rad\').value);"';
        $sql = 'SELECT
                    ID_PDPA,
                    action
                FROM
                    pdp_actions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    action;';

        $actionQuery = BaseQueries::performQuery($sql);

        while ($actionRow = @mysql_fetch_assoc($actionQuery)) {

            $html .='
                                <option value="' . $actionRow['ID_PDPA'] . '">
                                    ' . $actionRow['action'] . '
                                </option>';
        }
        $html .='
                    </select>';

        $html .= '</div>
                </td>
            </tr>
        </table>
        </form>
        </div>
        ';

        $objResponse->assign('rightDiv', 'innerHTML', $html);

        $objResponse->assign('pdp_todolist_sub1', 'style.visibility', 'hidden');
    }

    return $objResponse;
}

function modulePDPTodoList_actionOwner() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $objResponse->script('
            document.getElementById("sel_users").value = 0;
        ');

        $objResponse->assign("sel_users", "disabled", false);
        $objResponse->assign("sel_taskowners", "disabled", true);
        $objResponse->assign("sel_employees", "disabled", true);
        $objResponse->assign("sel_actions", "disabled", true);
    }

    return $objResponse;
}

function pdptodolist_singleEmployee() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $objResponse->script('
            document.getElementById("sel_taskowners").value = 0;
        ');


        $objResponse->assign("sel_taskowners", "disabled", true);
        $objResponse->assign("sel_employees", "disabled", false);
        $objResponse->assign("sel_actions", "disabled", true);
        $objResponse->assign("sel_users", "disabled", true);
    }

    return $objResponse;
}

function pdptodolist_allEmployees() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {

        $objResponse->assign("sel_users", "disabled", true);
        $objResponse->assign("sel_taskowners", "disabled", true);
        $objResponse->assign("sel_employees", "disabled", true);
        $objResponse->assign("sel_actions", "disabled", true);
    }

    return $objResponse;
}

function pdptodolist_taskOwner() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $objResponse->script('
            document.getElementById("sel_users").value = 0;
            document.getElementById("sel_employees").value = 0;
            document.getElementById("sel_actions").value = 0;
        ');

        $objResponse->assign("sel_users", "disabled", true);
        $objResponse->assign("sel_taskowners", "disabled", false);
        $objResponse->assign("sel_employees", "disabled", true);
        $objResponse->assign("sel_actions", "disabled", true);
    }

    return $objResponse;
}

function modulePDPTodoList_allActions() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {
        $objResponse->script('
            document.getElementById("sel_users").value = 0;
            document.getElementById("sel_taskowners").value = 0;
            document.getElementById("sel_employees").value = 0;
        ');

        $objResponse->assign("sel_users", "disabled", true);
        $objResponse->assign("sel_taskowners", "disabled", true);
        $objResponse->assign("sel_employees", "disabled", true);
        $objResponse->assign("sel_actions", "disabled", false);
    }

    return $objResponse;
}

function pdptodolist_getSelectValues($user_id, $option_value) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {

        if ($option_value == 0) {
            $sql = 'SELECT
                        e.ID_E,
                        e.employee
                    FROM
                        employees_pdp_tasks ept
                        INNER JOIN employees_pdp_actions epa
                            ON epa.ID_PDPEA = ept.ID_PDPEA
                        INNER JOIN users u
                            ON u.user_id = epa.ID_PDPTOID
                        INNER JOIN pdp_actions pa
                            ON pa.ID_PDPA = epa.ID_PDPAID
                        INNER JOIN pdp_task_ownership pto
                            ON pto.ID_PDPTO = ept.ID_PDPTO
                        INNER JOIN employees e
                            ON e.ID_E = ept.ID_E
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND u.user_id = ' . $user_id . '
                    GROUP BY
                        e.employee';

            $query = BaseQueries::performQuery($sql);
            $i = 1;
            if (!mysql_num_rows($query)) {
                $objResponse->alert(TXT_UCF('NO_EMPLOYEE_ASSOCIATED_WITH_THE_SELECTED_ACTION_OWNER'));

                $objResponse->assign("sel_users", "disabled", false);
                $objResponse->assign("sel_taskowners", "disabled", true);
                $objResponse->assign("sel_employees", "disabled", true);
                $objResponse->assign("sel_actions", "disabled", true);
            } else {

                $html = '
                        ' . TXT_UCF('EMPLOYEE') . ':<br/>
                        <select class="pdptodolist_selEmployees" name="sel_employees" id="sel_employees" size="20"
                        onclick="document.getElementById(\'hid_selEmployees\').value = this.options[this.selectedIndex].value;
                        document.getElementById(\'hid_selTaskOwners\').value = 0;
                        xajax.$(\'pdp_print_btn\').disabled=false;">';


                while ($queryResult_row = @mysql_fetch_assoc($query)) {
                    $html .='
                                    <option value="' . $queryResult_row['ID_E'] . '" >
                                        ' . $queryResult_row['employee'] . '
                                    </option>';
                    $i++;
                }

                $html .='
                        </select>';
                $objResponse->assign('td_employees', 'innerHTML', $html);
            }
        } elseif ($option_value == 2) {

            $objResponse->assign("sel_taskowners", "disabled", false);

            $html = '
                    ' . TXT_UCW('TASK_OWNER') . ':<br/>
                    <select class="pdptodolist_selTaskOwners" name="sel_taskowners" id="sel_taskowners" size="20"
                    onclick="document.getElementById(\'hid_selTaskOwners\').value = this.options[this.selectedIndex].value;
                    document.getElementById(\'hid_selEmployees\').value = 0;
                    xajax.$(\'pdp_print_btn\').disabled=false;">';

            $sql = 'SELECT
                        pto.ID_PDPTO,
                        pto.name
                    FROM
                        employees_pdp_tasks ept
                        INNER JOIN employees_pdp_actions epa
                            ON epa.ID_PDPEA = ept.ID_PDPEA
                        INNER JOIN users u
                            ON u.user_id = epa.ID_PDPTOID
                        INNER JOIN pdp_actions pa
                            ON pa.ID_PDPA = epa.ID_PDPAID
                        INNER JOIN pdp_task_ownership pto
                            ON pto.ID_PDPTO = ept.ID_PDPTO
                        INNER JOIN employees e
                            ON e.ID_E = ept.ID_E
                    WHERE
                        u.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND u.user_id = ' . $user_id . '
                    GROUP BY
                        pto.name';
            $queryResult = BaseQueries::performQuery($sql);

            if (!mysql_num_rows($queryResult)) {
                $objResponse->alert(TXT_UCF('NO_TASK_OWNER_ASSOCIATED_WITH_THE_SELECTED_ACTION_OWNER'));

                $objResponse->assign("sel_users", "disabled", false);
                $objResponse->assign("sel_taskowners", "disabled", true);
                $objResponse->assign("sel_employees", "disabled", true);
                $objResponse->assign("sel_actions", "disabled", true);
            } else {

                while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
                    $html .='
                            <option value="' . $queryResult_row['ID_PDPTO'] . '" >
                                ' . $queryResult_row['name'] . '
                            </option>';
                }

                $html .='
                    </select>';

                $objResponse->assign('td_taskowners', 'innerHTML', $html);
            }
        } elseif ($option_value == 3) {

            $objResponse->assign('pdp_print_btn', 'disabled', false);


            $objResponse->assign('hid_selAction', 'value', $user_id);
        } elseif ($option_value == 4) {

            $objResponse->assign('pdp_print_btn', 'disabled', false);


            $objResponse->assign('hid_selactionOwner', 'value', $user_id);
        }
    }

    return $objResponse;
}

function pdptodolist_setUsers($radoption) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TODO_LIST)) {

        if ($radoption == 0 || $radoption == 2) {
            $html = '
            ' . TXT_UCW('ACTION_OWNER') . ':<br/>
            <select class="pdptodolist_selUsers" name="sel_users" id="sel_users" size="20"
                        onclick="xajax_pdptodolist_getSelectValues(this.options[this.selectedIndex].value, document.getElementById(\'hid_print_options_rad\').value);">';

            $sql = 'SELECT
                        user_id,
                        username,
                        name
                    FROM
                        users
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        username';
            $queryResult = BaseQueries::performQuery($sql);

            while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {

                $html .='
                        <option value="' . $queryResult_row['user_id'] . '">
                            ' . ucwords($queryResult_row['name']) . '
                        </option>';
            }
            $html .='
            </select>';

            $objResponse->assign('td_users', 'innerHTML', $html);
        } elseif ($radoption == 3) {
            $html = '
            ' . TXT_UCF('ACTION') . ':<br/>
            <select class="pdptodolist_selAction" name="sel_actions" id="sel_actions" size="20"
                        onclick="xajax_pdptodolist_getSelectValues(this.options[this.selectedIndex].value, document.getElementById(\'hid_print_options_rad\').value);">';

            $sql = 'SELECT
                        ID_PDPA, action
                    FROM
                        pdp_actions
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                    GROUP BY
                        action';
            $queryResult = BaseQueries::performQuery($sql);

            while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {

                $html .='
                        <option value="' . $queryResult_row['ID_PDPA'] . '">
                            ' . $queryResult_row['action'] . '
                        </option>';
            }
            $html .='
            </select>';
            $objResponse->assign('td_actions', 'innerHTML', $html);
        }
    }

    return $objResponse;
}

?>
