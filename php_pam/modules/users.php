<?php

require_once('application/model/service/UserLoginService.class.php');
require_once('application/interface/InterfaceXajax.class.php');

function moduleUsers($selected_user_id = NULL) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_USERS)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_USERS);

        if (PermissionsService::isAddAllowed(PERMISSION_USERS)) {
            $add_user_btn = '<input type="button" value="' . TXT_BTN('ADD_NEW_USER') . '" class="btn btn_width_150" onclick="xajax_moduleUsers_addUser();return false;">';
        } else {
            $add_user_btn = '&nbsp;';
        }


        $getgt_data = '<div id="mode_department">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td class="left_panel" style="width:300px; min-width:300px;">
                <div id="scrollDiv">' .
                    getUserList($selected_user_id) . '
                </div><!-- /divLeft -->
            </td>
            <td class="right_panel">
            <div class="top_nav">' . $add_user_btn . '</div>
            <div id="divRight" style="float: left;">';

        $getgt_data .= '</div></td>
        </tr>
        </table>
        </div>';

        $objResponse->assign('module_main_panel', 'innerHTML', $getgt_data);

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_USERS));
    }

    return $objResponse;
}

function getUserList($selected_uid)
{

    if (USER_LEVEL >= UserLevelValue::MANAGER) {
        $q_ap = 'AND user_id = ' . USER_ID;
    } else {
        $q_ap = '';
    }
    $sql = 'SELECT
                u.*,
                ul.level_id
            FROM
                users u
                INNER JOIN user_level ul
                    ON u.user_level = ul.level_id
                        AND u.customer_id = ul.customer_id
            WHERE
                u.customer_id = ' . CUSTOMER_ID . '
                AND u.user_id <> 1
                ' . $q_ap . '
            ORDER BY
                ul.level_id,
                u.name';
    $get_u = BaseQueries::performQuery($sql);
    $getgt_data = '';

    $prev_user_level_id = '';
    if (@mysql_num_rows($get_u) > 0) {
        $getgt_data .= '
        <table border="0" cellspacing="0" cellpadding="0" style="width:280px;">';
        while ($user = @mysql_fetch_assoc($get_u)) {
            $user_level_id = $user['level_id'];
            $user['allow_access_all_departments'] = $user_level_id == UserLevelValue::CUSTOMER_ADMIN ? ALWAYS_ACCESS_ALL_DEPARTMENTS :$user['allow_access_all_departments'];
            $userClass = $user['is_inactive'] == 1 ? 'inactive' : '';
            if ($user_level_id != $prev_user_level_id) {
                $getgt_data .= '<tr><td colspan="100%"><br /><h1>' . UserLevelConverter::display($user_level_id) . '</h1></td></tr>';
            }
            $prev_user_level_id = $user_level_id;
            $row_class = $user['user_id'] == $selected_uid ? 'divLeftWbg' : 'divLeftRow';
            $access_all_indicator = $user['allow_access_all_departments'] == ALWAYS_ACCESS_ALL_DEPARTMENTS ? '*' : '&nbsp;';
            $usernameTitle = $user['name'] . ($user['allow_access_all_departments'] == ALWAYS_ACCESS_ALL_DEPARTMENTS ? ', *=' .TXT_LC('SHOW_ALL_DEPARTMENTS')  : '');
            $edit_btn = '&nbsp;';
            $delete_btn = '&nbsp;';
            $user_display = '<a ' . $inactiveStyle.  ' href="" onclick="xajax_moduleUsers_displayUser(' . $user['user_id'] . '); selectRow(\'rowLeftNav' . $user['user_id'] . '\'); return false;" title="' . $usernameTitle .'">' . $user['name'] . $access_all_indicator. ' (<em>'. $user['username'] . '</em>)</a>';

            if (PermissionsService::isEditAllowed(PERMISSION_USERS)) {
                $edit_btn = '<a href="" onclick="xajax_moduleUsers_editUser(' . $user['user_id'] . ');return false;" title="' . TXT_BTN('EDIT') . '"><img src="' . ICON_EDIT . '" class="icon-style" border="0" align="right"></a>';
            }
            if (PermissionsService::isDeleteAllowed(PERMISSION_USERS)) {
                if ($user['isprimary'] != 1 && $user['user_id'] != USER_ID) {
                    $delete_btn = '<a href="" onclick="xajax_moduleUsers_deleteUser(' . $user['user_id'] . ');return false;" title="' . TXT_BTN('DELETE') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"></a>';
                }
            }

            $getgt_data .= '
            <tr class="'. $userClass . '" id="rowLeftNav' . $user['user_id'] . '">
                <td width="80%" class="' . $row_class . ' dashed_line" style="padding-left: 10px;">' . $user_display . '</td>
                <td width="5%"  class="' . $row_class . ' dashed_line">' . $edit_btn . '</td>
                <td width="5%"  class="' . $row_class . ' dashed_line" align="right">' . $delete_btn . '</td>
            </tr>';
        }
        $getgt_data .= '
        </table>';
    }
    return $getgt_data;
}

function moduleUsers_displayUser($uid)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_USERS)) {
        if (!empty($uid)) {
            $sql = 'SELECT
                        u.*,
                        e.employee,
                        e.is_inactive as employee_is_inactive
                    FROM
                        users u
                        LEFT JOIN employees e
                            ON u.id_e = e.id_e
                    WHERE
                        u.user_id = ' . $uid;
            $getuserQuery = BaseQueries::performQuery($sql);
            $getuser = @mysql_fetch_assoc($getuserQuery);

            $sql = 'SELECT
                        d.department,
                        ud.permission
                    FROM
                        department d
                        INNER JOIN users_department ud
                            ON d.ID_DEPT = ud.ID_DEPT
                            AND ud.ID_UID = ' . $uid . '
                            AND ud.permission = ' . ALLOW_ACCESS_DEPARTMENT . '
                    WHERE
                        d.customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        d.department';
            $get_dept = BaseQueries::performQuery($sql);
            $allowedDepartments = array();
            if (@mysql_num_rows($get_dept) > 0) {
                    while ($dept = @mysql_fetch_assoc($get_dept)) {
                        $allowedDepartments[] = array('name' => $dept['department']);
                    }
            } else {
                $allowedDepartments[] = array('name' => TXT_UCF('NONE'));
            }

            global $smarty;
            $tpl = $smarty->createTemplate('to_refactor/mod_users/user.tpl');
            $tpl->assign('displayName', $getuser['name']);

            if ($getuser['ID_E'] != NULL) {
                $tpl->assign('showEmployee', true);
                $tpl->assign('employeeIsInactive', $getuser['employee_is_inactive']);
                $tpl->assign('employeeName', $getuser['employee']);
            } else {
                $tpl->assign('showEmployee', false);
                $tpl->assign('show_no_employee_link_text', $getuser['user_level'] > UserLevelValue::CUSTOMER_ADMIN);
            }

            $tpl->assign('userLevel', $getuser['user_level']);
            $tpl->assign('userLevelName', UserLevelConverter::display($getuser['user_level']));
            $tpl->assign('emailAddress', $getuser['email']);
            $tpl->assign('username', $getuser['username']);
            $tpl->assign('userIsInactive', $getuser['is_inactive']);
            $tpl->assign('lastLogin', $getuser['last_login']);
            //$tpl->assign('permissionsAllDepartments', $pad);
            $tpl->assign('show_departments', $getuser['user_level'] >= UserLevelValue::HR &&  $getuser['user_level'] <= UserLevelValue::MANAGER);
            $tpl->assign('show_not_applicable_admin', $getuser['user_level'] >= UserLevelValue::EMPLOYEE_EDIT);
            $tpl->assign('show_not_applicable_employee', $getuser['user_level'] >= UserLevelValue::EMPLOYEE_EDIT);
            $tpl->assign('allow_access_all_departments', $getuser['allow_access_all_departments'] == 1);

            $tpl->assign('allowedDepartments', $allowedDepartments);

            $objResponse->assign('divRight', 'innerHTML', $smarty->fetch($tpl));
            if ($getuser['is_inactive'] == 0) {
                InterfaceXajax::removeClass($objResponse, 'rowLeftNav' . $getuser['user_id'], 'inactive');
            } else {
                InterfaceXajax::addClass($objResponse, 'rowLeftNav' . $getuser['user_id'], 'inactive');
            }
        }
    }

    return $objResponse;
}

function moduleUsers_editUser($uid) {
    return userForm($uid);
}

function moduleUsers_addUser() {
    return userForm(NULL);
}

function userForm($uid)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_USERS)) {

        $getuser = array();
        $act = '';
        if($uid != NULL) {
            $sql = 'SELECT
                        u.*,
                        ul.level_name,
                        e.employee,
                        e.is_inactive as employee_is_inactive
                    FROM
                        users u
                        JOIN user_level ul
                            ON ul.level_id = u.user_level
                        LEFT JOIN employees e
                            ON u.id_e = e.id_e
                    WHERE
                        u.customer_id = ' . CUSTOMER_ID . '
                        AND u.user_id = ' . $uid . '
                    LIMIT 1';
            $query = BaseQueries::performQuery($sql);
            $getuser = @mysql_fetch_assoc($query);

            $act = TXT_UC('EDIT_USER');
        } else {
            $act = TXT_UC('ADD_NEW_USER');
        }

        $user_employee_id = $getuser['ID_E'];
        $user_employee_name = $getuser['employee'];
        $user_user_level = $getuser['user_level'];
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_USERS__EDIT_USER);
        $safeFormHandler->storeSafeValue('user_id', $uid);
        $safeFormHandler->storeSafeValue('employee_id', $user_employee_id);
        $safeFormHandler->storeSafeValue('employee_name', $user_employee_name);
        $safeFormHandler->addStringInputFormatType('displayName');
        $safeFormHandler->addStringInputFormatType('email');
        $safeFormHandler->addStringInputFormatType('username');
        $safeFormHandler->addStringInputFormatType('password');
        $safeFormHandler->addStringInputFormatType('confirm');
        $safeFormHandler->addStringInputFormatType('allow_access_all_departments', true);
        $safeFormHandler->addIntegerInputFormatType('user_level');
        $safeFormHandler->addIntegerInputFormatType('user_enabled');
        $safeFormHandler->addPrefixIntegerInputFormatType('dept');

        $safeFormHandler->finalizeDataDefinition();


        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_users/userEdit.tpl');
        $tpl->assign('formIdentifier', $safeFormHandler->getFormIdentifier());
        $tpl->assign('form_token', $safeFormHandler->getTokenHiddenInputHtml());
        $tpl->assign('actionLabel', $act);
        $tpl->assign('userId', $uid);
        $tpl->assign('displayName', $getuser['name']);
        $tpl->assign('userIsInactive', $getuser['is_inactive']);
        $tpl->assign('allow_access_all_departments', $getuser['allow_access_all_departments']);

        $tpl->assign('showEmployee', $user_employee_id != NULL);
        if ($user_employee_id != NULL) {
            $tpl->assign('employeeIsInactive', $getuser['employee_is_inactive']);
            $tpl->assign('employeeName', $user_employee_name);
        }

        if (USER_LEVEL == UserLevelValue::HR) {
            $tpl->assign('userLevel', $user_user_level);
            $securitylevels = array();
            $securitylevels[] = array('level_id'   => $user_user_level,
                                      'level_name' => UserLevelConverter::display($user_user_level));
        } else {
            $user_level_readonly = $getuser['isprimary'] == USER_PRIMARY_ADMIN ? ' disabled="true" ' : '';

            // Alleen bij employee gebruikers mogen user level id's 4 (Employee - edit) en 5 (Employee - view) getoond worden
            // maar bij een employee mag je er weer geen admin van maken
            $employeeUserLevelsFilter = ($user_employee_id != NULL) ? ' AND level_id > ' . UserLevelValue::CUSTOMER_ADMIN : ' AND level_id < ' . UserLevelValue::EMPLOYEE_EDIT;
//            if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN) {
//                //$employeeUserLevelsFilter .= ($user_user_level == UserLevelValue::CUSTOMER_ADMIN) ? ' OR level_id = ' . UserLevelValue::CUSTOMER_ADMIN : '';
//            }
            $sql = 'SELECT
                        *
                    FROM
                        user_level
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND level_id >= ' . USER_LEVEL . '
                       ' . $employeeUserLevelsFilter;
            $lev = BaseQueries::performQuery($sql);

            $securitylevels = array();
            while ($lev_r = @mysql_fetch_assoc($lev)) {
                $securitylevels[] = array('level_id'   => $lev_r[level_id],
                                          'level_name' => UserLevelConverter::display($lev_r['level_id']));
            }

            $tpl->assign('user_level_readonly', $user_level_readonly);
            $tpl->assign('showSecuritySelect', true);
            $tpl->assign('userLevel', $user_user_level);
            $tpl->assign('securityLevels', $securitylevels);
        }

        $tpl->assign('emailAddress', $getuser['email']);
        $tpl->assign('userName', $getuser['username']);
        $tpl->assign('show_departments_initial', $user_user_level >= UserLevelValue::HR &&  $getuser['user_level'] <= UserLevelValue::MANAGER);

        $sql = 'SELECT
                    *
                FROM
                    department
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    department';
        $get_dept = BaseQueries::performQuery($sql);

        $deptperms = array();
        if (@mysql_num_rows($get_dept) > 0) {
            while ($dept = @mysql_fetch_assoc($get_dept)) {
                $yn = false;
                // TODO: refactor
                if ($uid != NULL) {
                    $sql = 'SELECT
                                *
                            FROM
                                users_department
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND ID_UID = ' . $uid . '
                                AND ID_DEPT = ' . $dept['ID_DEPT'];
                    $chkdept = BaseQueries::performQuery($sql);
                    $yn = @mysql_num_rows($chkdept) > 0 ? true : false;
                }
                $deptperms[] = array('name'       => $dept['department'],
                                     'deptId'     => $dept['ID_DEPT'],
                                     'permission' => $yn);
            }
        }
        $tpl->assign('departmentPermissions', $deptperms);

        $objResponse->assign('divRight', 'innerHTML', $smarty->fetch($tpl));
        $objResponse->assign('divLeft', 'innerHTML', getUserList($uid));
        $objResponse->script("changedUserLevel('user_level', 'departments_div', 'no_department_div', 2, 3);");

        if (PermissionsService::isAccessDenied(PERMISSION_LEVEL_AUTHORIZATION)) {
            $objResponse->assign('lev_adjustment', 'style.visibility', 'hidden');
        } else {
            $objResponse->assign('lev_adjustment', 'style.visibility', 'visible');
        }
    }

    return $objResponse;
}

function isAllowedUsername($name)
{
    $check_name = strtolower($name);
    return strcmp($check_name, 'admin') != 0 &&
           strcmp($check_name, 'administrator') != 0 &&
           strcmp($check_name, 'beheerder') != 0;
}

// TODO: uit elkaar halen add en edit!! dan user_id via safeValue
function users_processSafeForm_editUser($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_USERS)) {

        //die('$safeFormHandler'.$safeFormHandler->)
        $user_id = $safeFormHandler->retrieveInputValue('user_id'); // todo: controle isIntValue want het gaat zo de query in...
        $is_adding_user = empty($user_id);

        $displayName = $safeFormHandler->retrieveInputValue('displayName');
        $email = $safeFormHandler->retrieveInputValue('email');
        $user_level = $safeFormHandler->retrieveInputValue('user_level');
        $username = $safeFormHandler->retrieveInputValue('username');
        $password = $safeFormHandler->retrieveInputValue('password');
        $confirm_password = $safeFormHandler->retrieveInputValue('confirm');
        $t_allow_access_all_departments = $safeFormHandler->retrieveInputValue('allow_access_all_departments');
        $allow_access_all_departments = !empty($t_allow_access_all_departments) ? 1 : 0;

        $userEnabledSelection = $safeFormHandler->retrieveInputValue('user_enabled');

        $is_employee_user = (!empty($user_employee_id));
        // validatie
        $hasError = false;
        if ($is_adding_user) { // kennelijk is er een add. TODO: veiliger controleren want zo kun je wel erg eenvoudig een gebruiker toevoegen in een "fout" situatie
            $sql = 'SELECT
                        *
                    FROM
                        users
                    WHERE
                        username = "' . mysql_real_escape_string($username) . '"';
            $check_usernameIfExist = BaseQueries::performSelectQuery($sql);
        } else {
            $sql = 'SELECT
                        u.*,
                        e.is_inactive as employee_is_inactive
                    FROM
                        users u
                        INNER JOIN employees e
                            ON u.ID_E = e.ID_E
                    WHERE
                        u.user_id = ' . $user_id;
            $get_user = BaseQueries::performSelectQuery($sql);
            $user_result = @mysql_fetch_assoc($get_user);

            $id_e = $user_result['ID_E'];
            $is_employee_user = (!empty($id_e));
            $isInactiveEmployee = $user_result['employee_is_inactive'] == EMPLOYEE_IS_DISABLED;

            if ($is_employee_user) {
                $displayName = $user_result['name'];
            }

            $sql = 'SELECT
                        *
                    FROM
                        users
                    WHERE
                        username = "' . mysql_real_escape_string($username) . '"
                        AND user_id <> '. $user_id;
            $check_usernameIfExist = BaseQueries::performSelectQuery($sql);
        }
        if ($isInactiveEmployee) {
            $isInactiveUser = USER_IS_DISABLED;
        } else {
            $isInactiveUser = empty($userEnabledSelection) ? ($is_adding_user ? USER_IS_ACTIVE: USER_IS_DISABLED) : ($userEnabledSelection == 1 ? USER_IS_ACTIVE : USER_IS_DISABLED);
        }

        if (empty($displayName)) { // naam niet gekoppeld aan employee moet gevuld zijn
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_NAME');
        } elseif (empty($user_id) && empty($username)) { // alleen bij een nieuwe user
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_USERNAME');
        } elseif (empty($email)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_AN_EMAIL_ADDRESS');
            $objResponse->script('xajax.$("email").focus();');
        } elseif (!ModuleUtils::IsEmailAddressValidFormat($email)) {
            $hasError = true;
            $message = TXT_UCF('EMAIL_ADDRESS_IS_INVALID');
            $objResponse->script('xajax.$("email").focus();');
        } elseif (@mysql_num_rows($check_usernameIfExist) > 0 || !isAllowedUsername($username)) {
            $hasError = true;
            $message = TXT_UCF('USERNAME_ALREADY_EXIST_PLEASE_TRY_ANOTHER_ONE');
            $objResponse->script('xajax.$("username").focus();');
        } elseif ($user_result['isprimary'] != USER_PRIMARY_ADMIN && empty($user_level)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_USER_LEVEL');
            $objResponse->script('xajax.$("user_level").focus();');
        } elseif (!empty($username) && $username == $password) {
            $hasError = true;
            $message = TXT_UCF('PASSWORD_MUST_NOT_BE_THE_SAME_AS_THE_USERNAME');
            $objResponse->script('xajax.$("password").focus();');
            $objResponse->assign('password', 'value', '');
            $objResponse->assign('confirm', 'value', '');
        } elseif (!empty($username) && $password <> $confirm_password) { // TODO: strcmp?
            $hasError = true;
            $message = TXT_UCF('SUPPLIED_PASSWORD_AND_CONFIRM_PASSWORD_DOES_NOT_MATCH');
            $objResponse->assign('password', 'value', '');
            $objResponse->assign('confirm', 'value', '');
            $objResponse->script('xajax.$("password").focus();');
        } elseif (!empty($username) && !empty($password) && !UserLoginService::isPasswordValidFormat($password)) {
            $hasError = true;
            $message = TXT_UCF('VALID_PASSWORD_FORMAT');
            $objResponse->assign('password', 'value', '');
            $objResponse->assign('confirm', 'value', '');
            $objResponse->script('xajax.$("password").focus();');
        }
        // einde validatie

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;
            $created_date = MODIFIED_DATE;

            $update_allow_acces_all_departments = '';
            if ($user_level == UserLevelValue::HR ||
                $user_level == UserLevelValue::MANAGER) {
                $update_allow_acces_all_departments = ' allow_access_all_departments = ' . $allow_access_all_departments . ',';
            } elseif ($user_level == UserLevelValue::CUSTOMER_ADMIN) {
                $update_allow_acces_all_departments = ' allow_access_all_departments = ' . ALWAYS_ACCESS_ALL_DEPARTMENTS . ',';
            }

            if (!empty($user_id)) {
                if ($user_result['isprimary'] == USER_PRIMARY_ADMIN) {
                    $sql = 'UPDATE
                                users
                            SET
                                name = "' . mysql_real_escape_string($displayName) . '",
                                is_inactive = "' . $isInactiveUser . '",
                                email = "' . mysql_real_escape_string($email) . '",
                                modified_by_user = "' . $modified_by_user . '",
                                modified_time = "' . $modified_time . '",
                                modified_date = "' . $modified_date . '"
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND user_id = ' . $user_id;
                    BaseQueries::performUpdateQuery($sql);
                } else {
                    $sql = 'UPDATE
                                users
                            SET
                                name = "' . mysql_real_escape_string($displayName) . '",
                                is_inactive = "' . $isInactiveUser . '",
                                email = "' . mysql_real_escape_string($email) . '",
                                user_level = "' . $user_level . '",
                                ' . $update_allow_acces_all_departments . '
                                modified_by_user = "' . $modified_by_user . '",
                                modified_time = "' . $modified_time . '",
                                modified_date = "' . $modified_date . '"
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND user_id = ' . $user_id;
                    BaseQueries::performUpdateQuery($sql);
                }

                // alleen als beiden gevuld (en hierboven gecontroleerd) dan updaten.
                if (!empty($username) && !empty($password)) {
                    $sql = 'UPDATE
                                users
                            SET
                                username = "' . mysql_real_escape_string($username) . '",
                                modified_by_user = "' . $modified_by_user . '",
                                modified_time = "' . $modified_time . '",
                                modified_date = "' . $modified_date . '"
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND user_id = ' . $user_id;
                    BaseQueries::performUpdateQuery($sql);

                    UserLoginService::changePassword($user_id, $password, $modified_by_user);
                }

                //update users department

                $sql = 'DELETE
                        FROM
                            users_department
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_UID = ' . $user_id;
                BaseQueries::performDeleteQuery($sql);

                if ($user_level <= UserLevelValue::MANAGER) {
                    updateAllowedUserDepartments($user_id, $safeFormHandler);
                }

                if ($is_employee_user) {
                    // hbd: let op hier worden 2 tabellen in 1 update aanpast...
                    $sql = 'UPDATE
                                person_data pd
                                INNER JOIN employees e
                                    ON e.id_pd = pd.id_pd
                            SET
                                pd.email = "' . mysql_real_escape_string($email) . '",
                                e.email_address = "' . mysql_real_escape_string($email) . '"
                            WHERE
                                e.customer_id = ' . CUSTOMER_ID . '
                                AND e.id_e = ' . $id_e;
                    BaseQueries::performUpdateQuery($sql);
                }
                $return_user_id = $user_id;

            } else {  // empty($user_id)

                $sql = 'INSERT INTO
                            users
                            (   customer_id,
                                username,
                                is_inactive,
                                name,
                                email,
                                user_level,
                                allow_access_all_departments,
                                modified_by_user,
                                modified_time,
                                modified_date,
                                created_date
                            ) VALUES (
                                 ' . CUSTOMER_ID . ',
                                "' . mysql_real_escape_string($username) . '",
                                 ' . $isInactiveUser . ',
                                "' . mysql_real_escape_string($displayName) . '",
                                "' . mysql_real_escape_string($email) . '",
                                "' . $user_level . '",
                                 ' . $allow_access_all_departments . ',
                                "' . $modified_by_user . '",
                                "' . $modified_time . '",
                                "' . $modified_date . '",
                                "' . $created_date . '"
                            )';

                $new_uid = BaseQueries::performInsertQuery($sql);

                UserLoginService::changePassword($new_uid, $password, $modified_by_user);

                updateAllowedUserDepartments($new_uid, $safeFormHandler);

                $return_user_id = $new_uid;
            }
            BaseQueries::finishTransaction();

            $hasError = false;

            if ($is_adding_user) {
                $objResponse->loadCommands(moduleUsers($return_user_id));
            } else {
                $objResponse->loadCommands(moduleUsers_displayUser($return_user_id));
            }
        }
    }
    return array($hasError, $message);
}

function updateAllowedUserDepartments($user_id, $safeFormHandler) // TODO: niet via de safeformhandler maar gewoon array meegeven
{
    $sql = 'SELECT
                ID_DEPT
            FROM
                department
            WHERE
                customer_id = ' . CUSTOMER_ID;
    $get_dept = BaseQueries::performTransactionalSelectQuery($sql);

    if (@mysql_num_rows($get_dept) > 0) {
        while ($dept_row = @mysql_fetch_assoc($get_dept)) {
            // TODO: leesbaarder maken, zie boven
            if  (($safeFormHandler->retrieveInputValue('dept' . $dept_row['ID_DEPT'])) == $dept_row['ID_DEPT']) {
                $sql = 'INSERT INTO
                            users_department
                            (   customer_id,
                                ID_UID,
                                permission,
                                ID_DEPT
                            ) VALUES (
                                ' . CUSTOMER_ID . ',
                                ' . $user_id . ',
                                ' . ALLOW_ACCESS_DEPARTMENT . ',
                                ' . $dept_row['ID_DEPT'] . '
                            )';
                BaseQueries::performInsertQuery($sql);
            }
        }
    }

}


function users_processSafeForm_editPassword($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PamApplication::hasValidSession($objResponse)) { // niet nodig
        $oldpassword = $safeFormHandler->retrieveInputValue('oldPass');
        $newpassword = $safeFormHandler->retrieveInputValue('newPass');
        $confirmpassword = $safeFormHandler->retrieveInputValue('confirmPass');

        BaseQueries::startTransaction();

        list($hasError, $message) = UserLoginService::handleChangePasswordUserRequest($oldpassword, $newpassword, $confirmpassword);

        BaseQueries::finishTransaction();

        if ($hasError) {
            $objResponse->assign('oldPass', 'value', '');
            $objResponse->assign('newPass', 'value', '');
            $objResponse->assign('confirmPass', 'value', '');
            $objResponse->script('xajax.$("oldPass").focus();');
        } else {
            $message = TXT_UCF('PASSWORD_HAS_BEEN_CHANGED');
            $objResponse->loadCommands(public_navigation_applicationMenu_settings());
        }
    }
    return array($hasError, $message);
}


function moduleUsers_deleteUser($uid) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_USERS)) {
        if (is_numeric($uid)) {
            $user_id = intval($uid);
            $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THE_USER'));
            $objResponse->call("xajax_moduleUsers_executeDeleteUser", $user_id);
        }

    }

    return $objResponse;
}


//EXECUTE DELETE FUNCTION
function moduleUsers_executeDeleteUser($uid) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_USERS)) {
        if ($uid == SYS_ADMIN_USER_ID) {
            $objResponse->alert('The System Admin User cannot be deleted');
        } else {
            try {
                BaseQueries::startTransaction();

                $username_res = UserQueries::getUsernameByUserId($uid);
                $username = '';
                if (@mysql_num_rows($username_res) > 0) {
                    $username_row = @mysql_fetch_assoc($username_res);
                    $username = $username_row['username'];
                }

                $sql = 'UPDATE
                            users
                        SET
                            ID_E = null
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND user_id = ' . $uid;
                BaseQueries::performUpdateQuery($sql);

                // de gebruiker "vervangen" door admin in pdp acties waar deze de actie-eigenaar is.
                $sql = 'UPDATE
                            employees_pdp_actions
                        SET
                            ID_PDPTOID =    (   SELECT
                                                    user_id
                                                FROM
                                                    users
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    AND isprimary = 1
                                            )
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_PDPTOID = ' . $uid;
                BaseQueries::performUpdateQuery($sql);

                $sql = 'UPDATE
                            alerts
                        SET
                            user_id =   (   SELECT
                                                user_id
                                            FROM
                                                users
                                            WHERE
                                                customer_id = ' . CUSTOMER_ID . '
                                                AND isprimary = 1
                                        )
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND user_id = ' . $uid;
                BaseQueries::performUpdateQuery($sql);


                $sql = 'DELETE
                        FROM
                            users_department
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_UID  =' . $uid;
                BaseQueries::performDeleteQuery($sql);

                $sql = 'DELETE
                        FROM
                            users
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND user_id = ' . $uid;
                BaseQueries::performDeleteQuery($sql);

                BaseQueries::finishTransaction();

                // TODO: anders!
                return moduleUsers();

            } catch (TimecodeException $timecodeException) {
                PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException);
            }
        }
    }
    return $objResponse;
}



?>
