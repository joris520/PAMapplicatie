<?php

function modulePDPTaskLibrary_direct($objResponse)
{
    ApplicationNavigationService::setCurrentApplicationModule(MODULE_PDP_TASK_LIB);

    if (PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_LIBRARY)) {
        $add_pdp_task_btn = '<input type="button" value="' . TXT_BTN('ADD_NEW_PDP_TASK') . '" class="btn btn_width_150" onclick="xajax_modulePDPTaskLibrary_addPDPtask();return false;">';
    } else {
        $add_pdp_task_btn = '&nbsp;';
    }

    $html = '
    <div id="mode_pdp_tasklib">
        <table border="0" cellspacing="0" cellpadding="0" width="100%">
            <tr>
                <td class="left_panel" style="width:300px; min-width:300px;">
                    <div id="scrollDiv">' . getTaskList(null) . '</div>
                </td>
                <td class="right_panel">
                    <div class="top_nav">' . $add_pdp_task_btn . '</div>
                    <div id="mod_pdp_tasklib_right"></div>
                </td>
            </tr>
        </table>
    </div>';

    $objResponse->assign('module_main_panel', 'innerHTML', $html);
    $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_PDP_TASK_LIB));

}

function modulePDPTaskLibrary()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TASK_LIBRARY)) {
        modulePDPTaskLibrary_direct($objResponse);
    }
    return $objResponse;
}

function getTaskList($selected_task_id)
{
    $html = '';

    $sql = 'SELECT
                *
            FROM
                pdp_task
            WHERE
                customer_id = ' . CUSTOMER_ID . '
            ORDER BY
                task';
    $queryResult = BaseQueries::performQuery($sql);

    if (@mysql_num_rows($queryResult) == 0) {
        $html = TXT_UCF('NO_TASK_LIBRARY_RETURN');
    } else {
        $html .= '
        <table border="0" cellspacing="0" cellpadding="0" style="width:280px;">';

        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            $id_pdpt = $queryResult_row['ID_PDPT'];
            $task = $queryResult_row['task'];
            $task_class = ($selected_task_id != $id_pdpt ) ? 'divLeftRow' : 'divLeftWbg';

            $pdp_task_btns = '';
            if (PermissionsService::isEditAllowed(PERMISSION_PDP_TASK_LIBRARY)) {
                $pdp_task_btns .= '
                <a href="" onclick="xajax_modulePDPTaskLibrary_editTask(' . $id_pdpt . ');return false;" title="' . TXT_UCF('EDIT') . '">
                    <img src="' . ICON_EDIT . '" class="icon-style" border="0">
                </a>';
            }
            if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_TASK_LIBRARY)) {
                $pdp_task_btns .= '
                <a href="" onclick="xajax_modulePDPTaskLibrary_deletePDPtask(' . $queryResult_row[ID_PDPT] . ');return false;" title="' . TXT_UCF('DELETE') . '">
                    <img src="' . ICON_DELETE . '" class="icon-style" border="0">
                </a>';
            }
            $pdp_task_btns = empty($pdp_task_btns) ? '&nbsp;' : $pdp_task_btns;

            $html .= '
            <tr id="rowLeftNav' . $id_pdpt . '">
                <td class="dashed_line  ' . $task_class . '" id="mod_pdp_tasklib_cat_left" width="80%">
                    <a href="" id="link' . $id_pdpt . '" onclick="xajax_modulePDPTaskLibrary_displayTask(' . $id_pdpt . '); selectRow(\'rowLeftNav' . $id_pdpt . '\'); return false;">
                        <div id="pdp_tasklib' . $id_pdpt . '" style="float:left">' . $task . '</div>
                    </a>
                <td>
                <td width="20%" class="dashed_line ' . $task_class . '" id="mod_pdp_tasklib_cat_left2">
                    <div align="right">
                        ' . $pdp_task_btns . '
                    </div>
                </td>
            </tr>';
        }

        $html .='
        </table>';
    }

    return $html;
}

function modulePDPTaskLibrary_addPDPtask()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPTASKLIBRARY__ADD_PDPTASK);

        $safeFormHandler->addStringInputFormatType('task');
        $safeFormHandler->addStringInputFormatType('task_description');

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <div id="mode_pdp_tasklib">
            <form id="pdp_tasklibAddNewForm" name="pdp_tasklibAddNewForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
                <p>' . TXT_UCW('ADD') . ' ' .TXT_UCW('TASK') . ' </p>
                <table width="40%" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                        <td align="right" class="bottom_line">' . TXT_UCF('TASK') . ':</td>
                        <td align="left">
                            <input size="40" type="text" name="task" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td align="right">' . TXT_UCF('DESCRIPTION') . ':</td>
                        <td align="left">
                            <textarea name="task_description" cols="40" rows="6"></textarea>
                        </td>
                    </tr>
                </table>
                <br>
                <input type="submit" id="submitButton" value="' . TXT_BTN('ADD'). '" class="btn btn_width_80">
                <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPTaskLibrary();return false;">
            </form>
        </div>';

        $objResponse->assign('mod_pdp_tasklib_right', 'innerHTML', $html);
    }

    return $objResponse;
}


//Display PDP Task Lib
function modulePDPTaskLibrary_displayTask($task_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_PDP_TASK_LIBRARY)) {

        $sql = 'SELECT
                    *
                FROM
                    pdp_task
                WHERE
                    ID_PDPT = ' . $task_id . '
                    AND customer_id = ' . CUSTOMER_ID;
        $queryResult = BaseQueries::performQuery($sql);
        $queryResult_row = @mysql_fetch_assoc($queryResult);

        $task = $queryResult_row[task];
        $task_description = $queryResult_row[task_description];

        $html = '
        <p>' . TXT_UCF('TASK') . ' : ' . $task . '</p>
        <table width="600" cellspacing="0" cellpadding="2" class="border1px">
            <tr>
                <td width="10%" class="bottom_line">' . TXT_UCF('TASK') . ':</td>
                <td width="30%" align="left">' . $task . '</td>
            </tr>
            <tr>
                <td>' . TXT_UCF('DESCRIPTION') . ':</td>
                <td align="left">' . nl2br($task_description) . '</td>
            </tr>
        </table>
        <table width="600" cellspacing="0" cellpadding="0">
            <tr>
                <td>
                    <div id="logs" align="right"></div>
                </td>
            </tr>
        </table>';

        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $queryResult_row[modified_by_user], $queryResult_row[modified_date], $queryResult_row[modified_time]);
        $objResponse->assign('mod_pdp_tasklib_right', 'innerHTML', $html);
    }
    return $objResponse;
}

//Edit PDP Task Lib
function modulePDPTaskLibrary_editTask($selected_task_id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_PDP_TASK_LIBRARY)) {

        $sql = 'SELECT
                    *
                FROM
                    pdp_task
                WHERE
                    ID_PDPT = ' . $selected_task_id . '
                    AND customer_id = ' . CUSTOMER_ID;
        $queryResult = BaseQueries::performQuery($sql);
        $queryResult_row = @mysql_fetch_assoc($queryResult);

        $task_id = $queryResult_row['ID_PDPT'];
        $task = trim($queryResult_row['task']);
        $task_description = trim($queryResult_row['task_description']);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPTASKLIBRARY__EDIT_TASK);

        $safeFormHandler->addStringInputFormatType('task');
        $safeFormHandler->addStringInputFormatType('task_description');
        $safeFormHandler->storeSafeValue('id_pdpt', $task_id);

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <form id="pdp_tasklibEditForm" name="pdp_tasklibEditForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
            <p>' . TXT_UCW('EDIT') . ' ' . TXT_UCW('TASK') . ' : ' . $task . '</p>
            <table width="600" cellspacing="0" cellpadding="2" class="border1px">
                <tr>
                    <td width="10%" class="bottom_line">' . TXT_UCF('TASK') . ':</td>
                    <td width="30%" align="left"><input type="text" size="40" name="task" value="' . $task . '"/></td>
                </tr>
                <tr>
                    <td>' . TXT_UCF('DESCRIPTION') . ' :</td>
                    <td align="left">
                        <textarea name="task_description" cols="40" rows="6">' . $task_description . '</textarea>
                    </td>
                </tr>
            </table>
            <br>
            <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
            <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_modulePDPTaskLibrary_displayTask(' . $task_id . ');return false;">
        </form>';

        $objResponse->assign('mod_pdp_tasklib_right', 'innerHTML', $html);
    }
    return $objResponse;
}

// PDP Execute EDIT
function PDPTaskLibrary_processSafeForm_editTask($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_PDP_TASK_LIBRARY)) {

        $task_id = $safeFormHandler->retrieveSafeValue('id_pdpt');
        $task = $safeFormHandler->retrieveInputValue('task');
        $task_description = $safeFormHandler->retrieveInputValue('task_description');

        list($hasError, $message) = validateTask($task, $task_id);

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'UPDATE
                        pdp_task
                    SET
                        task = "' . mysql_real_escape_string($task) . '",
                        task_description = "' . mysql_real_escape_string($task_description) . '",
                        modified_by_user = "' . $modified_by_user . '",
                        modified_time = "' . $modified_time . '",
                        modified_date = "' . $modified_date . '"
                    WHERE
                        id_pdpt = ' . $task_id . '
                        AND customer_id = ' . CUSTOMER_ID;

            BaseQueries::performUpdateQuery($sql);
            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPTaskLibrary_displayTask($task_id));
        }
    }
    return array($hasError, $message);
}

function validateTask($task, $task_id)
{
    $hasError = false;
    $message = '';
    if (empty($task)) {
        $message = TXT_UCF('PLEASE_ENTER_THE_TASK');
        $hasError = true;
    } else {
        $not_self = empty($task_id) ? '' : ' AND ID_PDPT <> ' . $task_id;
        $sql = 'SELECT
                    ID_PDPT
                FROM
                    pdp_task
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND task LIKE "' . mysql_real_escape_string($task) . '"' .
                    $not_self;

        $chkResult = BaseQueries::performSelectQuery($sql);
        if (@mysql_numrows($chkResult) > 0) {
            $message = TXT_UCF('TASK_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_TASK_NAME');
            $hasError = true;
        }
    }
    return array($hasError, $message);

}
// PDP Process EDIT

function PDPTaskLibrary_processSafeForm_addPDPtask($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_PDP_TASK_LIBRARY)) {

        $task = $safeFormHandler->retrieveInputValue('task');
        $task_description = $safeFormHandler->retrieveInputValue('task_description');

        list($hasError, $message) = validateTask($task, null);

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'INSERT INTO
                        pdp_task
                        (customer_id,
                         task,
                         task_description,
                         modified_by_user,
                         modified_time,
                         modified_date
                        ) VALUES (
                          ' . CUSTOMER_ID . ',
                         "' . mysql_real_escape_string($task) . '",
                         "' . mysql_real_escape_string($task_description) . '",
                         "' . $modified_by_user . '",
                         "' . $modified_time . '",
                         "' . $modified_date . '"
                        )';


            $task_id = BaseQueries::performInsertQuery($sql);
            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(modulePDPTaskLibrary_displayTask($task_id));
        }
    }
    return array($hasError, $message);
}

//DELETE PDP TASK
function modulePDPTaskLibrary_deletePDPtask($delete_task_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_TASK_LIBRARY)) {
        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE'));
        $objResponse->call("xajax_modulePDPTaskLibrary_executeDeletePDPtask", $delete_task_id);
    }
    return $objResponse;
}

//EXECUTE DELETE PDP TASK
function modulePDPTaskLibrary_executeDeletePDPtask($delete_task_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_PDP_TASK_LIBRARY)) {
        $sql = 'DELETE FROM
                    pdp_task
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_pdpt = ' . $delete_task_id . '
                LIMIT 1';
        BaseQueries::performQuery($sql);
        return modulePDPTaskLibrary(); // todo: anders oplossen
    }
    return $objResponse;
}

?>