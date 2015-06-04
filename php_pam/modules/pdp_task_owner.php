<?php

function get_pdpto_menu_link($id_pdpto, $name, $is_selected_id) {
    $bg = 'divLeftRow';

    if ($is_selected_id) {
        $bg = 'divLeftWbg';
    }

    $html .= '
    <tr id="rowLeftNav' . $id_pdpto . '">
        <td class="dashed_line divLeftRow" id="mod_pdp_tasklib_cat_left" width="80%">
            <a href="" id="link' . $id_pdpto . '" onclick="xajax_modulePDPTaskOwnerLibrary_displayTaskOwner(' . $id_pdpto . '); selectRow(\'rowLeftNav' . $id_pdpto . '\'); return false;">
                <div id="pdp_taskownerlib' . $id_pdpto . '" style="float:left">' . $name . '</div>
            </a>
        </td>';

    $del_pdp_taskOwner_btn = '';
    if (PermissionsService::isEditAllowed(PERMISSION_PDP_TASK_OWNERS)) {
        $del_pdp_taskOwner_btn .= '<a href="" onclick="xajax_modulePDPTaskOwnerLibrary_editTaskOwner(' . $id_pdpto . ');return false;" title="' . TXT_UCF('EDIT') . '"><img src="' . ICON_EDIT . '" class="icon-style" border="0"></a>';
    }
    if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_TASK_OWNERS)) {
        $del_pdp_taskOwner_btn .= '<a href="" onclick="xajax_modulePDPTaskOwnerLibrary_deleteTaskOwner(' . $id_pdpto . ');return false;" title="' . TXT_UCF('DELETE') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a>';
    }
    $del_pdp_taskOwner_btn = empty($del_pdp_taskOwner_btn) ? '&nbsp;' : $del_pdp_taskOwner_btn;

    $html .= '
        <td align="right" width="20%" class="dashed_line" id="mod_pdp_tasklib_cat_left2">
            <div align="right">
                ' . $del_pdp_taskOwner_btn . '
            </div>
        </td>
    </tr>';

    return $html;
}

function filterPDPTaskOwners() {
    $s_pdpto = $_SESSION[SESSION_SEARCH_TEXT_PDP_TASKOWNER];
    $filter_pdpto = '';
    if (!empty($s_pdpto)) {
        $filter_pdpto = ' AND name like "%' . mysql_real_escape_string($s_pdpto) . '%" ';
    }

    $employee_filter = '';
    if (USER_LEVEL != UserLevelValue::CUSTOMER_ADMIN && !USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
        $employeeQueries = new EmployeesQueries();
        $employeesResult = $employeeQueries->getEmployeesBasedOnUserLevel(null,null, null,null,null,null, false);

        $employee_ids = array();
        if (@mysql_num_rows($employeesResult) > 0) {
            while ($employee = @mysql_fetch_assoc($employeesResult)) {
                $employee_ids[] = $employee['ID_E'];
            }
        }
        $employee_filter = ' AND (pdpto.id_e IN (' . implode(',', $employee_ids) . ') OR (pdpto.id_e IS NULL)) ';
    }

    $sql = 'SELECT
                pdpto.id_pdpto,
                pdpto.name
            FROM
                pdp_task_ownership pdpto
            WHERE
                pdpto.customer_id = ' . CUSTOMER_ID .
                $filter_pdpto .
                $emps_filter . '
            ORDER BY
                pdpto.name';

    if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT) {
        $sql .= ' LIMIT ' . CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER;
    }


    //END USER VALIDATION
    $pdptoQuery = BaseQueries::performQuery($sql);

    $html = '';

    if (@mysql_num_rows($pdptoQuery) == 0) {
        $html .= '<center>' . TXT_UCF('NO_RESULT_ON_SEARCH_CRITERIA') . '</center>';
    } else {
        if(CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT && @mysql_num_rows($pdptoQuery) >= CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER) {
            $html .= '<div id="searchLimitText"><p style="font-weight: normal;">' . TXT_UCF('PDP_TASKOWNERS_LIST_LIMIT_SHOWN') . '. <br />' . TXT_UCF('ONLY_EMPLOYEES_LIMIT_SHOWN') . '.</p></div>';
        }

        $html .= '<div id="scrollDiv">';

        $html .= '
            <table border="0" cellspacing="0" cellpadding="1" width="95%">';
            while ($getpdpto_row = @mysql_fetch_assoc($pdptoQuery)) {
                $is_selected_id = $_SESSION[SESSION_SELECTED_PDP_TASKOWNER] == $getpdpto_row['id_pdpto'];
                $html .= get_pdpto_menu_link($getpdpto_row['id_pdpto'], $getpdpto_row['name'], $is_selected_id);
            }
            $html .='
            </table>';
        $html .= '</div>';
    }

    return $html;
}

function modulePDPTaskOwner_searchPDPTaskOwner($search_pdpto) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TASK_OWNERS)) {

        $_SESSION[SESSION_SEARCH_TEXT_PDP_TASKOWNER] = $search_pdpto['search_pdpto_text'];

        $objResponse->assign('searchPDPTOResult', 'innerHTML', filterPDPTaskOwners());
    }

    return $objResponse;
}

function modulePDPTaskOwnerLibrary_direct($objResponse)
{
    unset($_SESSION[SESSION_SELECTED_PDP_TASKOWNER]);
    ApplicationNavigationService::setCurrentApplicationModule(MODULE_PDP_TASK_OWNER);

    $sql = 'SELECT
                *
            FROM
                pdp_task_ownership
            WHERE
                customer_id = ' . CUSTOMER_ID . '
            ORDER BY
                name';
    $pdpTaskOwnersResult = BaseQueries::performQuery($sql);

    $html = '';
    if (@mysql_num_rows($pdpTaskOwnersResult) == 0) {

        if (PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_OWNERS)) {
            $add_pdp_taskOwner_btn = '<input type="button" value="' . TXT_BTN('ADD_NEW_PDP_TASK_OWNER') . '" class="btn btn_width_150" onclick="xajax_modulePDPTaskOwnerLibrary_addTaskOwner();return false;">';
        } else {
            $add_pdp_taskOwner_btn = '&nbsp;';
        }

        $html .= '<div id="mode_pdp_taskownerlib">
        <table border="0" cellspacing="0" cellpadding="0" width="100%"><tr>
        <td class="left_panel" width="20%">' . TXT_UCF('NO_VALUES_RETURNED') . '
        </td>
        <td class="right_panel" width="80%">
        <div class="top_nav">' . $add_pdp_taskOwner_btn . '</div>
        <div id="mod_pdp_taskownerlib_right"></div>
        </td>
        </tr>
        </table>
        </div>';
    } else {
        $html .='
        <div id="mode_pdp_taskownerlib">
                <table border="0" cellspacing="0" cellpadding="0" width="100%">
                    <tr>
                        <td class="left_panel" width="20%">';

        $html .= '<div id="search_pdpto">
                    <form id="srcfrmpdpto" action="javascript:void(0);" method="post" name="srcfrmpdpto">
                        <table border="0">
                            <tr>
                                <td><strong>' . TXT_UCF('SEARCH_PDP_TASKOWNER') . ': </strong></td>
                                <td><input type="text" name="search_pdpto_text" id="search_pdpto_text" onkeyup="xajax_modulePDPTaskOwner_searchPDPTaskOwner(xajax.getFormValues(\'srcfrmpdpto\')); return false;" maxlength="10" size="20" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <br />';
        $html .='<div id="searchPDPTOResult">';

        unset($_SESSION[SESSION_SEARCH_TEXT_PDP_TASKOWNER]);

        $html .= filterPDPTaskOwners();

        if (PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_OWNERS)) {
            $add_pdp_taskOwner_btn = '<input type="button" value="' . TXT_BTN('ADD_NEW_PDP_TASK_OWNER') . '" class="btn btn_width_150" onclick="xajax_modulePDPTaskOwnerLibrary_addTaskOwner();return false;"> &nbsp; &nbsp; ';
        } else {
            $add_pdp_taskOwner_btn = '&nbsp;';
        }

        $html .='
                        </div>
                        </td>
                        <td class="right_panel">
                        <div class="top_nav">' . $add_pdp_taskOwner_btn . '</div>
                            <div id="mod_pdp_taskownerlib_right">
                            </div>
                        </td>
                    </tr>
                </table>
    </div>';
    }

    $objResponse->assign('module_main_panel', 'innerHTML', $html);
    $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_PDP_TASK_OWNER));

}
function modulePDPTaskOwnerLibrary() {

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TASK_OWNERS)) {
        modulePDPTaskOwnerLibrary_direct($objResponse);
    }
    return $objResponse;
}

function modulePDPTaskOwnerLibrary_addTaskOwner() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_OWNERS)) {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPTASKOWNERLIBRARY__ADD_TASKOWNER);
        $safeFormHandler->addStringInputFormatType('taskowner');

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <div id="mode_pdp_taskownerlib">
        <p>' . TXT_UCF('ADD_NEW_PDP_TASK_OWNER') . ' </p>
            <form id="pdp_taskownerlibAddNewForm" name="pdp_taskownerlibAddNewForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">
                ' . $safeFormHandler->getTokenHiddenInputHtml() . '
                <table width="100%" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                        <td align="left" width="20%" class="bottom_line">' . TXT_UCF('TASK_OWNER') . ' :</td>
                        <td align="left" width="80%"><input type="text" name="taskowner" value="" size="38"/></td>
                    </tr>
                    <tr>
                        <td colspan="2" align="center">
                            <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                            <input type="button" value="' . TXT_UCF('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPTaskOwnerLibrary();return false;">	</td>
                    </tr>
                    <tr>
                        <td align="right">&nbsp;</td>
                    </tr>
                </table>
            </form>

        ';
        $objResponse->assign('mod_pdp_taskownerlib_right', 'innerHTML', $html);
    }

    return $objResponse;
}

// PDP Execute ADD
function PDPTaskOwnerLibrary_processSafeForm_addTaskOwner($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_OWNERS)) {
        $taskowner = $safeFormHandler->retrieveInputValue('taskowner');

        $hasError = false;
        if (empty($taskowner)) {
            $message = TXT_UCF('PLEASE_ENTER_TASK_OWNER');
            $hasError = true;
        } else {
            // TODO: gebruik count
            $sql = 'SELECT
                        name
                    from
                        pdp_task_ownership
                    WHERE
                        name = "' . mysql_real_escape_string($taskowner) . '"'; // TODO: gebruik like??
            $nameQuery = BaseQueries::performSelectQuery($sql);
            if (mysql_num_rows($nameQuery) > 0) {
                $message = TXT_UCF('PROFILE_NAME_YOU_ENTERED_IS_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_PROFILE_NAME');
                $hasError = true;
            }
        }

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'INSERT INTO
                        pdp_task_ownership
                        (   customer_id,
                            name,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                             ' . CUSTOMER_ID . ',
                            "' . mysql_real_escape_string($taskowner) . '",
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '")';

            BaseQueries::performInsertQuery($sql);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPTaskOwnerLibrary());
        }
    }
    return array($hasError, $message);
}

//Display PDP Task Owner Lib
function modulePDPTaskOwnerLibrary_displayTaskOwner($id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TASK_OWNERS)) {

        $prev_pdp_task_owner = $_SESSION[SESSION_SELECTED_PDP_TASKOWNER];
        $_SESSION[SESSION_SELECTED_PDP_TASKOWNER] = $id;

        $sql = 'SELECT
                    *
                FROM
                    pdp_task_ownership
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_PDPTO = ' . $id;
        $queryResult = BaseQueries::performQuery($sql);

        $queryResult_row = @mysql_fetch_assoc($queryResult);

        $taskowner = trim(addslashes($queryResult_row[name]));
        $taskowner_description = trim(addslashes($queryResult_row[task_description]));

        $html = '
        <p>' . TXT_UCW('DISPLAY_TASK_OWNER_LIBRARY') . '</p>
        <table width="100%" cellspacing="0" cellpadding="0"><tr><td>
                <table width="100%" cellspacing="1" cellpadding="2" class="border1px" align="left">
                    <tr>
                        <td width="20%" class="bottom_line">' . TXT_UCF('TASK_OWNER') . ' :</td>
                        <td width="80%">' . $taskowner . '</td>
                    </tr>
                    <tr>
                        <td align="right" colspan="2">&nbsp;</td>
                    </tr>
                </table>
        </td></tr><tr><td>
                <div id="logs" align="right"></div>
        </td></tr></table>
        ';
        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $queryResult_row[modified_by_user], $queryResult_row[modified_date], $queryResult_row[modified_time]);

        $objResponse->assign('mod_pdp_taskownerlib_right', 'innerHTML', $html);

        if(isset($prev_pdp_task_owner) && $prev_pdp_task_owner != $id) {
            $objResponse->assign('rowLeftNav' . $prev_pdp_task_owner, 'className',  'divLeftRow');
        }
    }

    return $objResponse;
}

//Edit PDP Task Owner Lib
function modulePDPTaskOwnerLibrary_editTaskOwner($id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_PDP_TASK_OWNERS)) {

        $prev_pdp_task_owner = $_SESSION[SESSION_SELECTED_PDP_TASKOWNER];
        $_SESSION[SESSION_SELECTED_PDP_TASKOWNER] = $id;

        $sql = 'SELECT
                    *
                FROM
                    pdp_task_ownership
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_PDPTO = ' . $id;
        $queryResult = BaseQueries::performQuery($sql);
        $queryResult_row = @mysql_fetch_assoc($queryResult);

        $taskowner = trim(addslashes($queryResult_row[name]));

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPTASKOWNERLIBRARY__EDIT_TASKOWNER);

        $safeFormHandler->storeSafeValue('ID_PDPTO', $id);
        $safeFormHandler->addStringInputFormatType('taskowner');

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <p>' . TXT_UCW('EDIT_TASK_OWNER_LIBRARY') . ' </p>
                <form id="pdp_taskownerlibEditForm" name="pdp_taskownerlibEditForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">
                    <table width="100%" cellspacing="0" cellpadding="2" class="border1px">
                        ' . $safeFormHandler->getTokenHiddenInputHtml() . '
                        <tr>
                            <td align="left" class="bottom_line" width="20%">' . TXT_UCF('TASK_OWNER') . ' :</td>
                            <td align="left" width="80%"><input type="text" name="taskowner" value="' . $taskowner . '" size="38"/></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="center">
                                <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                                <input type="button" value="' . TXT_UCF('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPTaskOwnerLibrary_displayTaskOwner(' . $id . ');return false;">
                                </td>
                        </tr>
                        <tr><td align="right">&nbsp;</td>	</tr>
                    </table>
                </form>
        ';

        $objResponse->assign('mod_pdp_taskownerlib_right', 'innerHTML', $html);

        if(isset($prev_pdp_task_owner) && $prev_pdp_task_owner != $id) {
            $objResponse->assign('rowLeftNav' . $prev_pdp_task_owner, 'className',  'divLeftRow');
        }

        $objResponse->assign('rowLeftNav' . $id, 'className',  'divLeftWbg');
    }

    return $objResponse;
}

// PDP Execute
function PDPTaskOwnerLibrary_processSafeForm_editTaskOwner($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_PDP_TASK_OWNERS)) {

        $id = $safeFormHandler->retrieveSafeValue('ID_PDPTO');
        $taskowner = $safeFormHandler->retrieveInputValue('taskowner');

        $hasError = false;
        if (empty($taskowner)) {
            $message = TXT_UCF('PLEASE_ENTER_TASK_OWNER');
            $hasError = true;
        }

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'UPDATE
                        pdp_task_ownership
                    SET
                        name = "' . mysql_real_escape_string($taskowner) . '",
                        modified_by_user = "' . $modified_by_user . '",
                        modified_time = "' . $modified_time . '",
                        modified_date = "' . $modified_date . '"
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_PDPTO = ' . $id;

            BaseQueries::performUpdateQuery($sql);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPTaskOwnerLibrary_displayTaskOwner($id));
        }
    }
    return array($hasError, $message);
}


function modulePDPTaskOwnerLibrary_deleteTaskOwner($id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_TASK_OWNERS)) {

        $prev_pdp_task_owner = $_SESSION[SESSION_SELECTED_PDP_TASKOWNER];
        $_SESSION[SESSION_SELECTED_PDP_TASKOWNER] = $id;

        if(isset($prev_pdp_task_owner) && $prev_pdp_task_owner != $id) {
            $objResponse->assign('rowLeftNav' . $prev_pdp_task_owner, 'className',  'divLeftRow');
        }

        $objResponse->assign('rowLeftNav' . $id, 'className',  'divLeftWbg');

        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_TASK_OWNER'));
        $objResponse->call("xajax_modulePDPTaskOwnerLibrary_executeDeleteTaskOwner", $id);
    }
    return $objResponse;
}

function modulePDPTaskOwnerLibrary_executeDeleteTaskOwner($id) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_TASK_OWNERS)) {
        unset($_SESSION[SESSION_SELECTED_PDP_TASKOWNER]);

        $sql = 'DELETE FROM
                    pdp_task_ownership
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_PDPTO=' . $id;
        BaseQueries::performQuery($sql);
        return modulePDPTaskOwnerLibrary();
    }

    return $objResponse;
}

?>