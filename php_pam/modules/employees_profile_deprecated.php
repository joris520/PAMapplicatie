<?php

require_once('gino/NumberUtils.class.php');
require_once('gino/DateUtils.class.php');
require_once('modules/model/service/to_refactor/PdpActionSkillServiceDeprecated.class.php');
require_once('modules/model/queries/to_refactor/EmployeeScoresQueries.class.php');
require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');
require_once('modules/model/queries/to_refactor/EmployeeProfileQueriesDeprecated.class.php');
require_once('modules/model/service/to_refactor/EmployeeProfileServiceDeprecated.class.php');
require_once('modules/interface/components/select/SelectEmployees.class.php');
require_once('modules/model/service/upload/PhotoContent.class.php');
require_once('application/model/service/UserLoginService.class.php');
require_once('modules/common/moduleConsts.inc.php');
require_once('application/interface/InterfaceBuilder.class.php');

require_once('modules/model/service/employee/profile/EmployeeProfileService.class.php');


function moduleEmployees_no_rights($objResponse) {

    $objResponse->assign('empPrint', 'innerHTML', TXT_UCF('NO_ACCESS'));
    $objResponse->assign('tabNav', 'innerHTML', '');
    $objResponse->assign('top_nav_btn', 'innerHTML', '');
}


function getProfileFormValidator($employee_id) {
    $safeFormHandler = null;
    if (empty($employee_id)) {
        $safeFormHandler =  SafeFormHandler::create(SAFEFORM_EMPLOYEES__ADD_EMPLOYEE_DEPRECATED);
//    } else {
//        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__EDIT_EMPLOYEE_DEPRECATED);
    }
    return $safeFormHandler;
}

function moduleEmployees_profileForm_deprecated($id_e) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
        $id_e = empty($id_e) ? '0' : $id_e;

        if (!empty($id_e)) {
            $sql = 'SELECT
                        e.*,
                        u.user_level,
                        u.username
                    FROM
                        employees e
                        LEFT JOIN users u
                            ON e.ID_E = u.ID_E
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.ID_E = ' . $id_e;
            $employeeQuery = BaseQueries::performQuery($sql);
            $get_e = @mysql_fetch_assoc($employeeQuery);
        } else {
            $get_e = null;
        }
        $boss_row = @mysql_fetch_assoc(EmployeesQueries::getBossInfo($id_e));
        $subordinate_count = $boss_row['subordinate_count'];

        $display_rating_selector = CUSTOMER_OPTION_USE_RATING_DICTIONARY ? '' : ' style="display:none"';

        $btn = $id_e == 0 ? TXT_UCF('ADD_NEW_EMPLOYEE'): TXT_UCF('UPDATE_EMPLOYEE');

        $safeFormHandler = getProfileFormValidator($id_e);

        if (!empty($id_e)) {
            $safeFormHandler->storeSafeValue('ID_E', $id_e);
            $safeFormHandler->storeSafeValue('ID_F', $get_e['ID_FID']);
            $safeFormHandler->storeSafeValue('ID_PD', $get_e['ID_PD']);
            $safeFormHandler->storeSafeValue('subordinate_count', $subordinate_count);
        }

        $safeFormHandler->addStringInputFormatType('firstname');
        $safeFormHandler->addStringInputFormatType('lastname');
        $safeFormHandler->addStringInputFormatType('SN');
        $safeFormHandler->addStringInputFormatType('sex');
        $safeFormHandler->addStringInputFormatType('birthdate');
        $safeFormHandler->addStringInputFormatType('nationality');
        $safeFormHandler->addStringInputFormatType('is_boss', true);
        $safeFormHandler->addStringInputFormatType('selectedID_Fs');
        $safeFormHandler->addStringInputFormatType('username', true);
        $safeFormHandler->addStringInputFormatType('password', true);
        $safeFormHandler->addStringInputFormatType('address');
        $safeFormHandler->addStringInputFormatType('postal_code');
        $safeFormHandler->addStringInputFormatType('city');
        $safeFormHandler->addStringInputFormatType('phone_number');
        $safeFormHandler->addStringInputFormatType('email_address');
        $safeFormHandler->addStringInputFormatType('phone_number_work');
        $safeFormHandler->addStringInputFormatType('employment_date');
        $safeFormHandler->addStringInputFormatType('employment_FTE');
        $safeFormHandler->addStringInputFormatType('additional_info', true);
        $safeFormHandler->addStringInputFormatType('hidden_info', true);

        $safeFormHandler->addIntegerInputFormatType('ID_DEPTID', true);
        $safeFormHandler->addIntegerInputFormatType('boss_fid', true);
        $safeFormHandler->addIntegerInputFormatType('ID_FID', true);
        $safeFormHandler->addIntegerInputFormatType('contract_state_fid', true);
        $safeFormHandler->addIntegerInputFormatType('user_level', true);
        $safeFormHandler->addIntegerInputFormatType('education_level_fid', true);

        $safeFormHandler->finalizeDataDefinition();

        $getemp_data .= '
        <div id="mode_employees">
            <form id="employeesProfileForm" name="employeesProfileForm" onSubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">
            ' . $safeFormHandler->getTokenHiddenInputHtml() . '
            <p>' . $btn . '</p>
            <table border="0" cellspacing="2" cellpadding="3" width="80%"><!-- layout table -->
                <tr>
                    <td class="border1px">
                        <table width="100%" border="0" cellspacing="2" cellpadding="0"><!-- inner table -->
                            <tr>
                                <td class="bottom_line" width="250">' . TXT_UCF('FIRST_NAME') . ' ' . REQUIRED_FIELD_INDICATOR . ' : </td>
                                <td id="blink">
                                    <input type="text" id="firstname" name="firstname" size="30" value="' . htmlspecialchars($get_e[firstname]) . '" tabindex="1">
                                </td>
                                <td class="bottom_line">' . TXT_UCF('STREET'). ' : </td>
                                <td>
                                    <input name="address" type="text" id="address" size="30" value="' . htmlspecialchars($get_e[address]) . '" tabindex="13">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('LAST_NAME') . ' ' . REQUIRED_FIELD_INDICATOR . '  : </td>
                                <td>
                                    <label>
                                        <input name="lastname" type="text" id="lastname" size="30" value="' . htmlspecialchars($get_e[lastname]) . '" tabindex="2">
                                    </label>
                                </td>
                                <td class="bottom_line">' . TXT_UCF('ZIP_CODE') . ' : </td>
                                <td>
                                    <input name="postal_code" type="text" id="postal_code" size="30" value="' . htmlspecialchars($get_e[postal_code]) . '" tabindex="14">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('SOCIAL_NUMBER') . ' : </td>
                                <td>
                                    <input name="SN" type="text" id="SN" size="30" value="' . htmlspecialchars($get_e[SN]) . '" tabindex="3">
                                </td>
                                <td class="bottom_line">' . TXT_UCF('CITY') . ' : </td>
                                <td>
                                    <input name="city" type="text" id="city" size="30" value="' . htmlspecialchars($get_e[city]) . '" tabindex="15">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('GENDER'). ' : </td>
                                <td>';
                                    $male = $get_e[sex] == 'Male' ? 'checked' : '';
                                    $female = $get_e[sex] == 'Female' ? 'checked' : '';
                                    $getemp_data .='
                                    <input name="sex" type="radio" value="Male" ' . $male . ' tabindex="4"> ' . TXT_UCF('MALE') . '
                                    <input name="sex" type="radio" value="Female" ' . $female . '> ' . TXT_UCF('FEMALE') . '
                                </td>
                                <td class="bottom_line">' . TXT_UCF('TELEPHONE_NUMBER') . ' : </td>
                                <td>
                                    <input name="phone_number" type="text" id="phone_number" size="30" value="' . htmlspecialchars($get_e[phone_number]) . '" tabindex="16">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('DATE_OF_BIRTH') . ' : </td>
                                <td>';
                                    $birthdeyt = empty($get_e[birthdate]) ? '' : $get_e[birthdate];

                                    $email_required_title = '';
                                    $email_required_title .= (AlertsService::hasOpenAlertsAsSender($id_e)) ? TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL_WITH_UNSEND_ALERTS') . '<br />' : '';
                                    $email_required_title .= ($get_e[username] != '') ? TXT_UCF('EMPLOYEE_USER_LINK') : '';
                                    $email_required_title = 'title="'. $email_required_title . '"';

                                    $email_required_indicator = (CUSTOMER_OPTION_REQUIRED_EMP_EMAIL) ||
                                                                ($get_e[username] != '') ||
                                                                (AlertsService::hasOpenAlertsAsSender($id_e)) ?
                                                                    '<span ' . $email_required_title . '>' . REQUIRED_FIELD_INDICATOR . '</span>' :
                                                                    '';

                                    $getemp_data .= '<input name="birthdate" type="text" id="birthdate" size="18" maxlength="10" value="' . $birthdeyt . '" tabindex="5">
                                        <input id="birthdate_cal" type="reset" value=" ... " onclick="return showCalendar(\'birthdate\', \'%d-%m-%Y\');">
                                </td>
                                <td class="bottom_line">' . TXT_UCF('E_MAIL_ADDRESS') . ' ' . $email_required_indicator . ' : </td>
                                <td>
                                    <input name="email_address" maxlength="78" type="text" id="email_address" size="30" value="' . htmlspecialchars($get_e[email_address]) . '" tabindex="17">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('NATIONALITY') . ' : </td>
                                <td><input name="nationality" type="text" id="nationality" size="30" value="' . htmlspecialchars($get_e[nationality]) . '" tabindex="6"></td>
                                <td>&nbsp; </td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('DEPARTMENT') . ' ' . REQUIRED_FIELD_INDICATOR . ' : </td>
                                <td>
                                    <select name="ID_DEPTID" id="ID_DEPTID" tabindex="7">
                                        <option value="">- ' . TXT_LC('SELECT') . ' -</option>
                                        ';
                                        $departmentqueries = new DepartmentQueriesDeprecated();
                                        $get_d = $departmentqueries->getDepartmentsBasedOnUserLevel(null,
                                                                                                    null,
                                                                                                    null,
                                                                                                    null,
                                                                                                    null,
                                                                                                    null);
                                        while ($get_d_row = @mysql_fetch_assoc($get_d)) {
                                            $id_dept = $get_d_row[ID_DEPT] == $get_e[ID_DEPTID] ? 'selected="selected"' : '';
                                            $getemp_data .= '<option value="' . $get_d_row[ID_DEPT] . '" ' . $id_dept . '>' . $get_d_row[department] . '</option>';
                                        }
                                    $getemp_data .= '
                                    </select>
                                </td>
                                <td class="bottom_line">' . TXT_UCF('PHONE_WORK') . ' : </td>
                                <td>
                                    <input name="phone_number_work" type="text" id="phone_number_work" size="30" value="' . htmlspecialchars($get_e[phone_number_work]) . '" tabindex="18">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('BOSS') . ' : </td>
                                <td>
                                    <select name="boss_fid" id="boss_fid" tabindex="8">
                                        <option value="">- ' . TXT_LC('SELECT') . ' -</option>';
                                        if (!empty($get_e['ID_E'])) {
                                            $filterNotSelf = 'AND ID_E <> ' . $get_e['ID_E'];
                                        }
                                        // hbd: check USER_LEVEL ?
                                        $sql = 'SELECT
                                                    ID_E,
                                                    firstname,
                                                    lastname
                                                FROM
                                                    employees
                                                WHERE
                                                    customer_id = ' . CUSTOMER_ID . '
                                                    ' . $filterNotSelf . '
                                                    AND is_inactive = 0
                                                    AND is_boss = 1
                                                ORDER BY
                                                    lastname,
                                                    firstname';

                                        $bossQuery = BaseQueries::performQuery($sql);
                                        while ($get_boss_row = @mysql_fetch_assoc($bossQuery)) {
                                            $id_boss_sel = $get_boss_row[ID_E] == $get_e[boss_fid] ? 'selected="selected"' : '';
                                            $getemp_data .= '<option value="' . $get_boss_row[ID_E] . '" ' . $id_boss_sel . '>' . ModuleUtils::BossName($get_boss_row['firstname'], $get_boss_row['lastname']) . '</option>';
                                        }
                                    $getemp_data .= '
                                    </select>
                                </td>
                                <td class="bottom_line">' . TXT_UCF('EMPLOYMENT_DATE') . ' : </td>
                                <td>';
                                    $empldeyt = empty($get_e[employment_date]) ? '' : $get_e[employment_date];
                                    $is_boss_checked = $get_e['is_boss'] == 1 ? ' checked' : '';

                                    $is_boss_editable = '';
                                    $boss_has_subordinates = '';
                                    if ($subordinate_count > 0) {
                                        $is_boss_editable = $is_boss_checked ? 'disabled="disabled"' : '';
                                        $boss_has_subordinates = '(' . TXT_UCF('BOSS_CURRENTLY_HAS_SUBORDINATES') . ')';
                                    }

                                    $getemp_data .= '
                                    <input name="employment_date" type="text" id="employment_date" size="18" maxlength="0" value="' . $empldeyt . '" tabindex="19" readonly="readonly">
                                    <input id="employment_date_cal" type="reset" value=" ... " onclick="return showCalendar(\'employment_date\', \'%d-%m-%Y\');">
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('IS_SELECTABLE_AS_BOSS') . ' : </td>
                                <td><input type="checkbox" ' . $is_boss_editable . ' name="is_boss" id="is_boss" value="ON"' . $is_boss_checked . ' tabindex="9" />' . $boss_has_subordinates . '</td>
                                <td class="bottom_line">' . TXT_UCF('EMPLOYMENT_PERCENTAGE') . ' : </td>
                                <td>
                                    <input name="employment_FTE" maxlength="4" type="text" id="employment_FTE" size="30" value="' . NumberUtils::convertFloat($get_e[employment_FTE], LANG_ID) . '" tabindex="20">
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                                <td class="bottom_line">' . TXT_UCF('EDUCATION_LEVEL') . ' : </td>
                                <td>
                                    <select name="education_level_fid" id="education_level_fid" tabindex="21">
                                        <option value="">- ' . TXT_LC('SELECT') .' -</option>';
                                        $sql = 'SELECT
                                                    *
                                                FROM
                                                    choice_education_levels
                                                WHERE
                                                    deprecated IS NULL';
                                        $get_education = BaseQueries::performQuery($sql);
                                        while ($get_education_row = @mysql_fetch_assoc($get_education)) {
                                            $get_education_sel = $get_education_row[ID] == $get_e[education_level_fid] ? 'selected="selected"' : '';
                                            $getemp_data .= '<option value="' . $get_education_row[ID] . '" ' . $get_education_sel . '>' . TXT_UCF($get_education_row[LABEL_REF]) . '</option>';
                                        }
                                    $getemp_data .= '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" rowspan="6">';
                                if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {
                                    // hier moeten IDs van alle hoofd- en nevenfunctieprofielen in lijstje getoond worden.
                                    $sql = 'SELECT
                                                ID_F,
                                                function
                                            FROM
                                                functions
                                            WHERE
                                                customer_id = ' . CUSTOMER_ID . '
                                                AND ID_F = (    SELECT
                                                                    ID_FID
                                                                FROM
                                                                    employees
                                                                WHERE
                                                                    ID_E = ' . $id_e . '
                                                        )
                                                OR ID_F IN (    SELECT
                                                                    ID_F
                                                                FROM
                                                                    employees_additional_functions
                                                                WHERE
                                                                    ID_E = ' . $id_e . '
                                                            )
                                            ORDER BY
                                                function';
                                    //die($sql);
                                    $all_emp_FIDQuery = BaseQueries::performQuery($sql);
                                    $all_emp_FIDs = MysqlUtils::result2Array2D($all_emp_FIDQuery);

                                    $all_emp_FIDQuery2 = BaseQueries::performQuery($sql);
                                    $all_emp_ID_Fs = implode(",", MysqlUtils::result2Array($all_emp_FIDQuery2));

                                    $getemp_data .= '
                                    <input type=hidden name="selectedID_Fs" id="selectedID_Fs" value="' . $all_emp_ID_Fs . '">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr>
                                        <td width="200"> ' . TXT_UCF('JOB_PROFILES_OF_EMPLOYEE') . ':<br>
                                            &nbsp;&nbsp;&nbsp;<em>' . TXT_UCF('AVAILABLE_JOB_PROFILES') . '</em>
                                        </td>
                                        <td width="50">&nbsp;</td>
                                        <td>&nbsp;<br>&nbsp;<em>' . TXT_UCF('SELECTED') . '</em></td>
                                        </tr>
                                        <tr>
                                        <td align="right">
                                            <select name="sourceSelect"    id="sourceSelect"      size="10" multiple="multiple" ondblclick="moveJobProfile(); return false;">
                                            ';
        //                                        <optgroup label="' . TXT_UCF('AVAILABLE_JOB_PROFILES') . '">
                                            // hier moeten alle functieprofielen minus de hoofd- en nevenfunctieprofielen in lijstje getoond worden
                                            $sql = 'SELECT
                                                        *
                                                    FROM
                                                        functions
                                                    WHERE
                                                        customer_id = ' . CUSTOMER_ID;
                                            if ($id_e != 0) {
                                                // hier moeten alle profielen van id_e worden getoond.
                                                $sql .= '
                                                        AND ID_F != (   SELECT
                                                                            ID_FID
                                                                        FROM
                                                                            employees
                                                                        WHERE
                                                                            ID_E = ' . $id_e . '
                                                                    )
                                                        AND ID_F NOT IN (   SELECT
                                                                                ID_F
                                                                            FROM
                                                                                employees_additional_functions
                                                                            WHERE
                                                                                ID_E = ' . $id_e . '
                                                                        )
                                                        ';
                                            }
                                            $sql .= '
                                                    ORDER BY
                                                        function';
                                            $qResult = BaseQueries::performQuery($sql);
                                            $available_FIDs = MysqlUtils::result2Array2D($qResult);
                                            mysql_free_result($qResult);
                                            for ($i = 0; $i < count($available_FIDs); $i++) {
                                                $getemp_data .= '<option value="' . $available_FIDs[$i]['ID_F'] . '">' . $available_FIDs[$i]['function'] . '</option>';
                                            }
                                            $getemp_data .= '
                                            </select>
                                        </td>
                                        <td align="center" valign="middle">
                                            &nbsp;<br>
                                            <input type="reset" name="forward" id="buttonadd" value="&gt;&gt;" onclick="moveJobProfile(); return false;"/> <br>
                                            <br>
                                            <input type="reset" name="back" id="buttonremove" value="&lt;&lt;" onclick="moveJobProfile(\'remove\'); return false;"/>
                                        </td>
                                        <td align="left">
                                            <select name="destinationSelect" id="destinationSelect" size="10" multiple="multiple" ondblclick="moveJobProfile(\'remove\'); return false;">';
                                            // hier moeten alle hoofd- en nevenfunctieprofielen in lijstje getoond worden.
                                            //$all_emp_FIDQuery
                                            for ($i = 0; $i < count($all_emp_FIDs); $i++) {
                                                $getemp_data .= '<option value="' . $all_emp_FIDs[$i]['ID_F'] . '">' . $all_emp_FIDs[$i]['function'] . '</option>';
                                            }
                                            $getemp_data .= '
                                            </select>
                                        </td>
                                        </tr>
                                    </table>
                                    <br>';
                                }
                                $getemp_data .= '
                                </td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <!--<td colspan="2"> 2 </td>-->
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <!--<td colspan="2"> 3 </td>-->
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <!--<td colspan="2"> 4 </td>-->
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <!--<td colspan="2"> 5 </td>-->

                                <td colspan="2" rowspan="10">
                                    ' . TXT_UCF('ADDITIONAL_INFO') . ' : <br>
                                    <textarea name="additional_info" id="additional_info" cols="40" rows="5" tabindex="22">' . htmlspecialchars($get_e[additional_info]) . '</textarea>
                                        <br /><br />';
                                    if (/*USER_LEVEL <= 3 && */ PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_MANAGER_COMMENTS)) {
                                    $getemp_data .= TXT_UCF('MANAGERS_COMMENTS') . ' :<br />
                                        <textarea name="hidden_info" id="hidden_info" cols="40" rows="5" tabindex="23">' . htmlspecialchars($get_e[hidden_info]) . '</textarea>';
                                    }
                                    $getemp_data .= '
                                </td>
                            </tr>
                            <tr>
                                <!--<td colspan="2"> 6 </td>-->
                            </tr>
                            <tr>';
                                if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {
                                $getemp_data .= '
                                <td class="bottom_line">' . TXT_UCF('MAIN_JOB_PROFILE') . ' ' . REQUIRED_FIELD_INDICATOR . ' :  </td>
                                <td>
                                    <select name="ID_FID" id="ID_FID" tabindex="10">
                                        <option value="">- ' . TXT_LC('SELECT') . ' -</option>';
                                        // hier moeten hoofd- en alle nevenfunctieprofielen in een lijstje getoond worden.
                                        if (@mysql_num_rows($all_emp_FIDQuery) != 0)
                                            mysql_data_seek($all_emp_FIDQuery, 0);

                                        //mysql_free_result($all_emp_FIDQuery);
                                        for ($i = 0; $i < count($all_emp_FIDs); $i++) {
                                            $extra_attr = $all_emp_FIDs[$i]['ID_F'] == $get_e[ID_FID] ? ' selected="selected"' : '';
                                            $getemp_data .= '<option value="' . $all_emp_FIDs[$i]['ID_F'] . '"' . ($extra_attr) . '>' . $all_emp_FIDs[$i]['function'] . '</option>';
                                        }
                                        $getemp_data .='
                                    </select>
                                </td>';
                                } else {
                                    $getemp_data .= '
                                    <td colspan="2">&nbsp;</td>';
                                }
                            $getemp_data .= '

                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('CONTRACT_STATE') . ' :  </td>
                                <td>
                                    <select name="contract_state_fid" id="contract_state_fid" tabindex="11">
                                        <option value="">- ' . TXT_LC('SELECT') . ' -</option>';
                                        $sql = 'SELECT
                                                    *
                                                FROM
                                                    choice_contract_states
                                                WHERE
                                                    deprecated IS NULL';
                                        $get_contract = BaseQueries::performQuery($sql);
                                        while ($get_contract_row = @mysql_fetch_assoc($get_contract)) {
                                            $id_contract_sel = $get_contract_row[ID] == $get_e[contract_state_fid] ? 'selected="selected"' : '';
                                            $getemp_data .= '<option value="' . $get_contract_row[ID] . '" ' . $id_contract_sel . '>' . TXT_UCF($get_contract_row[LABEL_REF]) . '</option>';
                                        }
                                    $getemp_data .= '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line"' . $display_rating_selector . '>' . TXT_UCF('RATING') . ' ' . REQUIRED_FIELD_INDICATOR . ' : </td>
                                <td>';

                                    $option_dictionary = '';
                                    if (CUSTOMER_OPTION_USE_RATING_DICTIONARY) {
                                        $selected_rating_dictionary = $get_e['rating'] == RATING_DICTIONARY ? ' selected="selected"' : '';
                                        $option_dictionary = '<option value="' . RATING_DICTIONARY . '"' . $selected_rating_dictionary . '>' . TXT_UCF('BASED_ON_DICTIONARY') . '</option>';
                                    } else {
                                        $get_e['rating'] = RATING_FUNCTION_PROFILE;
                                    }

                                    $selected_rating_job_profile = (empty($get_e['rating']) || $get_e['rating'] == RATING_FUNCTION_PROFILE) ? ' selected="selected"' : '';

                                    $getemp_data .='
                                    <select name="rating" id="rating" tabindex="12"' . $display_rating_selector . '>
                                        <option value="">- ' . TXT_LC('SELECT') . ' -</option>
                                        <option value="' . RATING_FUNCTION_PROFILE . '"' . $selected_rating_job_profile . '>' . TXT_UCF('BASED_ON_JOB_PROFILE') . '</option>
                                        ' . $option_dictionary . '
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">&nbsp;</td>
                            </tr>';
                                    if (PermissionsService::isEditAllowed(PERMISSION_USERS) && ($id_e == 0 || $get_e['username'] == NULL)) {
                                        $username = $get_e['username'] != NULL ? $get_e['username'] : '';

                                        $getemp_data .='
                                        <tr>
                                            <td class="bottom_line">' . TXT_UCF('USERNAME') . ' : </td>
                                            <td><input name="username" type="text" id="username" size="30" value="' . $username . '" tabindex="23"></td>
                                        </tr>
                                        <tr>
                                            <td class="bottom_line">' . TXT_UCF('PASSWORD') . ' : </td>
                                            <td><input name="password" type="password" id="password" size="30" value="" tabindex="24"></td>
                                        </tr>
                                        <tr>
                                            <td class="bottom_line">' . TXT_UCF('SECURITY'). ' : </td>
                                            <td>
                                                <select name="user_level" id="user_level" tabindex="25">
                                                    <option value="">- ' . TXT_LC('SELECT_SECURITY_LEVEL') . ' -</option>
                                                    <option value="2">' . UserLevelConverter::display(2) . '</option>
                                                    <option value="3">' . UserLevelConverter::display(3) . '</option>
                                                    <option value="4">' . UserLevelConverter::display(4) . '</option>
                                                    <option value="5">' . UserLevelConverter::display(5) . '</option>
                                                </select>
                                            </td>
                                        </tr>';
                                    }

                                    $getemp_data .='
                            <tr>
                                <td colspan="4">&nbsp;</td>
                            </tr>
                        </table><!-- end inner table -->
                    </td>
                </tr>
            </table><!-- layout table -->
            <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE'). '" class="btn btn_width_80">
            <input type="button" value="' . TXT_BTN('CANCEL'). '" class="btn btn_width_80" onClick="xajax_moduleEmployees_cancelAddEmployee_deprecated();return false;">
            </form>
        </div>';

        $objResponse->assign('empPrint', 'innerHTML', $getemp_data);
        $objResponse->assign('tabNav', 'innerHTML', '');
        $objResponse->assign('top_nav_btn', 'innerHTML', '');

        $objResponse->script('xajax.$("firstname").focus();');
    }
    return $objResponse;
}

function moduleEmployees_cancelAddEmployee_deprecated() {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_CANCEL_THIS_FORM'));
        $objResponse->loadCommands(public_navigation_startApplication());
    }

    return $objResponse;
}

//ADD PROFILE
function moduleEmployees_addEmployee_deprecated() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
        // hbd: letop de niet actieve tellen ook mee omdat deze nog gerestored kunnen worden!
        if (!EmployeesService::isAddEmployeePossible()) {
            InterfaceXajax::alertMessage($objResponse, TXT_UCF('MAXIMUM_NUMBER_OF_EMPLOYEE_ALLOWED_EXCEEDED'));
        } else {
            deselect_employee_in_menu_deprecated($objResponse, ApplicationNavigationService::retrieveSelectedEmployeeId());

            $objResponse->call("xajax_moduleEmployees_profileForm_deprecated", 0);
        }
    }
    return $objResponse;
}

// PROFILE ADD/VALIDATE/EXECUTE
function employees_processSafeForm_addEmployee_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE)) {

        $ID_FID = $safeFormHandler->retrieveInputValue('ID_FID');
        $ID_DEPTID = $safeFormHandler->retrieveInputValue('ID_DEPTID');
        $firstname = $safeFormHandler->retrieveInputValue('firstname');
        $lastname = $safeFormHandler->retrieveInputValue('lastname');
        $employee = $firstname . ' ' . $lastname; // TODO: via functie
        $rating = CUSTOMER_OPTION_USE_RATING_DICTIONARY ? $safeFormHandler->retrieveInputValue('rating') : RATING_FUNCTION_PROFILE;
        $SN = $safeFormHandler->retrieveInputValue('SN');
        $sex = $safeFormHandler->retrieveInputValue('sex');
        $birthdate = $safeFormHandler->retrieveInputValue('birthdate');
        $nationality = $safeFormHandler->retrieveInputValue('nationality');
        $address = $safeFormHandler->retrieveInputValue('address');
        $postal_code = $safeFormHandler->retrieveInputValue('postal_code');
        $city = $safeFormHandler->retrieveInputValue('city');
        $phone_number = $safeFormHandler->retrieveInputValue('phone_number');
        $email_address = $safeFormHandler->retrieveInputValue('email_address');
        $additional_info = $safeFormHandler->retrieveInputValue('additional_info');
        $hidden_info = $safeFormHandler->retrieveInputValue('hidden_info');
        $customer_id = CUSTOMER_ID;//$empProfileForm['customer_id'];
        $selectedID_Fs = $safeFormHandler->retrieveInputValue('selectedID_Fs');
        // hbd: nieuwe velden
        $phone_number_work = $safeFormHandler->retrieveInputValue('phone_number_work');
        $employment_date = $safeFormHandler->retrieveInputValue('employment_date');

        $boss_fid = $safeFormHandler->retrieveInputValue('boss_fid');
        $boss_fid = (!empty($boss_fid) ? intval($boss_fid) : 'NULL');

        $education_level_fid = $safeFormHandler->retrieveInputValue('education_level_fid');
        $education_level_fid = (!empty($education_level_fid) ? intval($education_level_fid) : 'NULL');

        $contract_state_fid = $safeFormHandler->retrieveInputValue('contract_state_fid');
        $contract_state_fid = (!empty($contract_state_fid) ? intval($contract_state_fid) : 'NULL');

        $employment_FTE = floatval(str_replace(',', '.', $safeFormHandler->retrieveInputValue('employment_FTE')));
        $is_boss = intval($safeFormHandler->retrieveInputValue('is_boss') == 'ON');

        $username = $safeFormHandler->retrieveInputValue('username');
        $password = $safeFormHandler->retrieveInputValue('password');
        $user_level = $safeFormHandler->retrieveInputValue('user_level');

        $sql = 'SELECT
                    *
                FROM
                    users
                WHERE
                    username = "' . mysql_real_escape_string($username) . '"';
        $checkUsernameQuery = BaseQueries::performSelectQuery($sql);

        // hbd: letop de niet actieve tellen ook mee omdat deze nog gerestored kunnen worden!
        $sql = 'SELECT
                    COUNT(ID_E) AS total_employees
                FROM
                    employees
                WHERE
                    customer_id = ' . CUSTOMER_ID;
        $num_employeeQuery = BaseQueries::performSelectQuery($sql);
        $num_employee = @mysql_fetch_assoc($num_employeeQuery);

        $sql = 'SELECT
                    num_employees as max_employees
                FROM
                    customers
                WHERE
                    customer_id = ' . CUSTOMER_ID;
        $max_employeeQuery = BaseQueries::performSelectQuery($sql);
        $max_employee = @mysql_fetch_assoc($max_employeeQuery);


        $hasError = false;

        if ($num_employee['total_employees'] >= $max_employee['max_employees'] ||
            $max_employee['max_employees'] == '' ||
            $max_employee['max_employees'] == '0') {
            $message = TXT_UCF('MAXIMUM_NUMBER_OF_EMPLOYEE_ALLOWED_EXCEEDED');
            $hasError = true;
        } elseif (empty($firstname)) {
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_FIRST_NAME');
            $hasError = true;
        } elseif (empty($lastname)) {
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_LAST_NAME');
            $hasError = true;
        } elseif (CUSTOMER_OPTION_REQUIRED_EMP_EMAIL && empty($email_address)) { // hbd: email ook verplicht
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL');
            $hasError = true;
        } elseif (!empty($email_address) && !ModuleUtils::IsEmailAddressValidFormat($email_address)) {
            $message = TXT_UCF('EMAIL_ADDRESS_IS_INVALID');
            $hasError = true;
        } elseif (empty($ID_DEPTID)) {
            $message = TXT_UCF('PLEASE_SELECT_A_DEPARTMENT');
            $hasError = true;
        //} elseif (empty($empProfileForm[selectedID_Fs])  ||  empty($empProfileForm['ID_FID'])) { // hbd: toegevoegde controle uit addEmployee sdj: toevoeging om te kijken of lijst met functies niet leeg is.
        } elseif (empty($selectedID_Fs)) { // sdj: toevoeging om te kijken of lijst met functies niet leeg is.
            $message = TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE');
            $hasError = true;
        } elseif (!in_array($ID_FID, explode(",", $selectedID_Fs))) { // sdj: toegevoegde controle
            $message = TXT_UCF('SELECTED_MAIN_JOB_PROFILE_NOT_IN_LIST_JOB_PROFILES_OF_EMPLOYEE');
            $hasError = true;
        } elseif (CUSTOMER_OPTION_USE_RATING_DICTIONARY && empty($rating)) {
            $message = TXT_UCF('PLEASE_SELECT_A_RATING');
            $hasError = true;
        } elseif (!empty($username) && @mysql_num_rows($checkUsernameQuery) > 0) { // TODO: dubbele controles op !empty username eruit!
            $message = TXT_UCF('USERNAME_ALREADY_EXIST_PLEASE_TRY_AGAIN');
            $objResponse->assign('username', 'value', '');
            $objResponse->script('xajax.$("username").focus();');
            $hasError = true;
        } elseif (!empty($username) && empty($password)) {
            $message = TXT_UCF('PLEASE_ENTER_A_PASSWORD');
            $hasError = true;
        } elseif (!empty($username) && $username == $password) {
            $message = TXT_UCF('PASSWORD_MUST_NOT_BE_THE_SAME_AS_THE_USERNAME');
            $objResponse->assign('password', 'value', '');
            $objResponse->script('xajax.$("password").focus();');
            $hasError = true;
        } elseif (!empty($username) && empty($email_address)) {
            $message = TXT_UCF('PLEASE_ENTER_AN_EMPLOYEE_EMAIL_REQUIRED_FOR_USER');
            $objResponse->script('xajax.$("email_address").focus();');
            $hasError = true;
        } elseif (!empty($username) && !UserLoginService::isPasswordValidFormat($password)) {
            $message = TXT_UCF('VALID_PASSWORD_FORMAT');
            $objResponse->assign('password', 'value', '');
            $objResponse->script('xajax.$("password").focus();');
            $hasError = true;
        } elseif (!empty($username) && empty($user_level)) {
            $message = TXT_UCF('PLEASE_SELECT_A_USER_LEVEL');
            $objResponse->script('xajax.$("user_level").focus();');
            $hasError = true;
        }

        // hier "afwijkende controles, dus niet in de elseif
        if (! $hasError  && ! empty($birthdate)) {
            $checkResult = DateUtils::ValidateDisplayDate(trim($birthdate)); // TODO: error_message verwerken in Validate
            if ($checkResult > 0) {
                $error_message = TXT_UCF('DATE_OF_BIRTH');
                switch ($checkResult) {
                    case 1: $error_message .= ': ' . TXT('INVALID_DATE_FORMAT');
                        break;
                    case 2: $error_message .= ': ' . TXT('INVALID_DATE');
                        break;
                    default: $error_message .= ': ' . TXT('INVALID_DATE_FORMAT');
                }
                $message = $error_message;
                $hasError = true;
            }
        }
        if (! $hasError  && ! empty($employment_FTE)) {
            $check_employment_FTE = floatval(str_replace(',', '.', trim($employment_FTE)));
            if (empty($check_employment_FTE) || $check_employment_FTE < 0.0 || $check_employment_FTE > 1.0 ) {
                $error_message = TXT_UCF('EMPLOYMENT_PERCENTAGE'). ': ' . TXT_UCF('INVALID_FTE_VALUE');
                $message = $error_message;
                $hasError = true;
            }
        }
        // einde validatie

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $id_pd = personDataService::insertPersonalData($customer_id, ID_EC_INTERNAL, $firstname, $lastname, $email_address);

            // ===========
            //databse insertion
            $sql = 'INSERT INTO
                        employees
                        (   customer_id,
                            ID_FID,
                            ID_DEPTID,
                            firstname,
                            lastname,
                            employee,
                            rating,
                            SN,
                            sex,
                            birthdate,
                            nationality,
                            address,
                            postal_code,
                            city,
                            phone_number,
                            email_address,
                            foto_thumbnail,
                            additional_info,
                            hidden_info,
                            modified_by_user,
                            modified_time,
                            modified_date,
                            is_inactive,
                            phone_number_work,
                            employment_date,
                            boss_fid,
                            education_level_fid,
                            contract_state_fid,
                            employment_FTE,
                            ID_PD,
                            is_boss
                        ) VALUES (
                             ' . $customer_id . ',
                             ' . $ID_FID . ',
                             ' . $ID_DEPTID . ',
                            "' . mysql_real_escape_string($firstname) . '",
                            "' . mysql_real_escape_string($lastname) . '",
                            "' . mysql_real_escape_string($employee) . '",
                             ' . $rating . ',
                            "' . mysql_real_escape_string($SN) . '",
                            "' . mysql_real_escape_string($sex) . '",
                            "' . mysql_real_escape_string($birthdate) . '",
                            "' . mysql_real_escape_string($nationality) . '",
                            "' . mysql_real_escape_string($address) . '",
                            "' . mysql_real_escape_string($postal_code) . '",
                            "' . mysql_real_escape_string($city) . '",
                            "' . mysql_real_escape_string($phone_number) . '",
                            "' . mysql_real_escape_string($email_address) . '",
                            NULL,
                            "' . mysql_real_escape_string($additional_info) . '",
                            "' . mysql_real_escape_string($hidden_info) . '",
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '",
                             ' . EMPLOYEE_IS_ACTIVE . ',
                            "' . mysql_real_escape_string($phone_number_work) . '",
                            "' . mysql_real_escape_string($employment_date) . '",
                             ' . $boss_fid . ',
                             ' . $education_level_fid . ',
                             ' . $contract_state_fid . ',
                            "' . mysql_real_escape_string($employment_FTE) . '",
                             ' . $id_pd . ',
                             ' . $is_boss . '
                        )';

            $id_e = BaseQueries::performInsertQuery($sql);

            // hoofd-functie en array van neven-functies uit formulier
            $mainJobProfileId = $ID_FID;
            $additionalJobProfileIds = explode(",", $selectedID_Fs);

            // nieuwe neven functieprofielen toevoegen aan database
            $realAdditionalFunctionIds = array();
            foreach($additionalJobProfileIds as $additionalJobProfileId) {
                if ($additionalJobProfileId != $mainJobProfileId) {
                    $realAdditionalFunctionIds[] = $mainJobProfileId;
                    EmployeeJobProfileQueries::insertInAdditionalFunctionsTable($id_e, $additionalJobProfileId);
                }
            }

            // job profile history initieren...
            EmployeeJobProfileService::insertValidatedValues(   $id_e,
                                                                $mainJobProfileId,
                                                                $realAdditionalFunctionIds);

            // TODO: employees_topics eigenlijk weg
            //insert employees topics
            $sql = 'INSERT INTO
                        employees_topics
                        (   customer_id,
                            ID_E,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                            ' . $customer_id . ',
                            ' . $id_e . ',
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '"
                        )';
            BaseQueries::performInsertQuery($sql);


            //insert pdp_task_ownership
            $sql = 'INSERT INTO
                        pdp_task_ownership
                        (   customer_id,
                            name,
                            ID_E,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                            ' . $customer_id . ',
                           "' . mysql_real_escape_string($employee) . '",
                            ' . $id_e . ',
                           "' . $modified_by_user . '",
                           "' . $modified_time . '",
                           "' . $modified_date . '"
                        )';
            BaseQueries::performInsertQuery($sql);

            //insert user login
            if (!empty($username)) {
                    $sql = 'INSERT INTO
                                users
                                (   customer_id,
                                    username,
                                    name,
                                    user_level,
                                    ID_E,
                                    email,
                                    modified_by_user,
                                    modified_time,
                                    modified_date,
                                    created_date
                                ) VALUES (
                                     ' . $customer_id . ',
                                    "' . mysql_real_escape_string($username) . '",
                                    "' . mysql_real_escape_string($employee) . '",
                                     ' . $user_level . ',
                                     ' . $id_e . ',
                                    "' . mysql_real_escape_string($email_address) . '",
                                    "' . $modified_by_user . '",
                                    "' . $modified_time . '",
                                    "' . $modified_date . '",
                                    "' . $modified_date . '"
                                )';

                    $new_user_id = BaseQueries::performInsertQuery($sql);

                    UserLoginService::changePassword($new_user_id, $password, true, USER);
            }

            BaseQueries::finishTransaction();
            $hasError = false;

            ApplicationNavigationService::storeSelectedEmployeeId($id_e);
            $_SESSION['employee_display_name'] = ModuleUtils::EmployeeName($first_name, $last_name);

            $objResponse->call("xajax_public_navigation_startApplication");
        }
    }
    return array($hasError, $message);
}



?>