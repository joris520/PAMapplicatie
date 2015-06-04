<?php
require_once('modules/model/service/to_refactor/ThreesixtyEmailService.class.php');

define('DELETE_EVAL_DESTINATION_360', 1);
define('DELETE_EVAL_DESTINATION_EMPLOYEE', 2);

function get_threesixty_menu_link($id_e, $firstname, $lastname, $is_selected_id) {
    $bg = 'divLeftRow';

    if ($is_selected_id) {
        $bg = 'divLeftWbg';
    }

    $buttons_360 = '';
    if (PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {
        $buttons_360 .= '<a href="" onclick="xajax_module360_deleteEmployee360(' . $id_e . ');return false;" title="' . TXT_UCW('DELETE_360') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"  width="16" height="16"></a>';
    }
    else {
        $buttons_360 .= '&nbsp;';
    }

    $employeename = ModuleUtils::EmployeeName($firstname, $lastname);

    $html .= '<tr class="' . $bg . '" id="deg' . $id_e . '">
                <td class="dashed_line"><a href="" id="link' . $id_e . '" onclick="xajax_module360_display360Degree(' . $id_e . '); selectRow(\'deg' . $id_e . '\') ;return false;">' . $employeename . '</a></td>
                <td class="dashed_line">' . $buttons_360 . '</td>
                </tr>';

    return $html;
}

function filterThreeSixtyDegrees()
{
    $filter_tsk = '';

    $s_employee = $_SESSION[SESSION_SEARCH_TEXT_THEESIXTY_DEGREES];
    if (!empty($s_employee)) {
        $filter_tsk = ' AND (e.lastname LIKE "%' . $s_employee . '%" OR e.firstname LIKE "%' . $s_employee . '%") ';
    }

    $non_admin_join  = ' ';
    $non_admin_where = ' ';
    if (USER_LEVEL != UserLevelValue::CUSTOMER_ADMIN || !USER_ALLOW_ACCESS_ALL_DEPARTMENTS) {
        $sql_is_boss_of_or_employee_filter = ' ';
            if (!is_null(EMPLOYEE_ID)) {
                $boss_result = EmployeesQueries::getBossInfo(EMPLOYEE_ID);
                $boss_row = @mysql_fetch_assoc($boss_result);

                if ($boss_row['is_boss']) {
                    $sql_is_boss_of_or_employee_filter = ' OR e.boss_fid = ' . EMPLOYEE_ID;
                }
            }
        $non_admin_join = '

                users u
                LEFT JOIN users_department ud
                    ON u.user_id = ud.id_uid
                INNER JOIN employees e
                    ON (ud.id_dept = e.ID_DEPTID
                        ' . $sql_is_boss_of_or_employee_filter . ')';


        $non_admin_where = ' AND u.user_id = ' . USER_ID ;
    } else {
        $non_admin_join = 'employees e';
    }

    $sql = 'SELECT
                ti.ID_E,
                e.lastname,
                e.firstname
            FROM
                ' . $non_admin_join . '
                INNER JOIN threesixty_invitations ti
                    ON e.ID_E = ti.ID_E
            WHERE
                e.customer_id = ' . CUSTOMER_ID . '
                AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                ' . $non_admin_where . '
                ' . $filter_tsk . '
                AND ti.completed <> ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
            GROUP BY
                ti.ID_E
            ORDER BY
                e.lastname,
                e.firstname';

    if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT) {
        $sql .= ' LIMIT ' . CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER;
    }

    //die($sql);

    $gettsk = BaseQueries::performQuery($sql);

    $html = '';

    if (@mysql_num_rows($gettsk) == 0) {
        $html .= '<center>' . TXT_UCF('NO_RESULT_ON_SEARCH_CRITERIA') . '</center>';
    } else {
        if (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT &&
            @mysql_num_rows($gettsk) >= CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER) {
            $html .= '<div id="searchLimitText"><p class="info-text">' . TXT_UCF('EMPLOYEES_LIST_LIMITED_RESULTS') . '. <br />' . TXT_UCF_VALUE('ONLY_EMPLOYEES_LIMIT_SHOWN') . '.</p></div>';
        }

        $html .= '<div id="scrollDiv">';

        $html .= '
            <table border="0" cellspacing="0" cellpadding="1" style="width:280px;">';
            while ($gettsk_row = @mysql_fetch_assoc($gettsk)) {
                $is_selected_id = $_SESSION[SESSION_SELECTED_THEESIXTY_DEGREES] == $gettsk_row['ID_E'];
                $html .= get_threesixty_menu_link($gettsk_row['ID_E'], $gettsk_row['firstname'], $gettsk_row['lastname'], $is_selected_id);
            }
            $html .='
            </table>';
        $html .= '</div>';
    }

    return $html;
}

function module360_searchEmployees($search) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_REPORT_360)) {
        $_SESSION[SESSION_SEARCH_TEXT_THEESIXTY_DEGREES] = addslashes($search['search_threesixty_text']);

        $objResponse->assign('searchTheeSixtyResult', 'innerHTML', filterThreeSixtyDegrees());
    }
    return $objResponse;
}

function module360_display360Employees() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_REPORT_360)) {
        module360_display360_direct($objResponse);
    }
    return $objResponse;
}

function module360_display360_direct($objResponse)
{
    ApplicationNavigationService::setCurrentApplicationModule(MODULE_360);

    $html = '
    <table border="0" cellspacing="0" cellpadding="0" width="100%">
    <tr>
        <td class="left_panel" style="width:300px; min-width:300px;">';

    $html .= '<div id="search_threesixty" class="search">
                    <form id="srcfrmthreesixty" action="javascript:void(0);" method="post" name="srcfrmthreesixty">
                        <table border="0">
                            <tr>
                                <td><strong>' . TXT_UCF('SEARCH_EMPLOYEE') . ': </strong></td>
                                <td><input type="text" name="search_threesixty_text" id="search_threesixty_text" onkeyup="xajax_module360_searchEmployees(xajax.getFormValues(\'srcfrmthreesixty\')); return false;" maxlength="10" size="20" /></td>
                            </tr>
                        </table>
                    </form>
                </div>';
    $html .='<div id="searchTheeSixtyResult">';

    unset($_SESSION[SESSION_SELECTED_THEESIXTY_DEGREES]);
    unset($_SESSION[SESSION_SEARCH_TEXT_THEESIXTY_DEGREES]);

    $html .= filterThreeSixtyDegrees();

    $html .= '</div></td>
    <td class="right_panel" >
    <div class="top_nav" id="top_nav">&nbsp;</div>
    <div id="mod_function_right">
    <br><br><br><br><br><br><br><br><br><br>
    </div>
    </td></tr>
    </table><br />';

    $objResponse->assign('module_main_panel', 'innerHTML', $html);
    $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_360));
}

function moduleEmployees_360_direct($objResponse, $id_e)
{
    ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_360);

    $html = display360Degree_content($id_e, DELETE_EVAL_DESTINATION_EMPLOYEE);
    $objResponse->assign('empPrint', 'innerHTML', $html);

    EmployeesTabInterfaceProcessor::displayMenu($objResponse, $id_e, MODULE_EMPLOYEE_360);
    $objResponse->assign('top_nav_btn', 'innerHTML', '');
}


function module360_display360Degree($id_e) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_REPORT_360)) {
        $html = display360Degree_content($id_e, DELETE_EVAL_DESTINATION_360);

        $objResponse->assign('mod_function_right', 'innerHTML', $html);
        $buttons_360 .= '<input type="button" id="genPrints" value="' . TXT_BTN('PRINT_360') . '" class="btn btn_width_150" onclick="xajax_module360_executePrintSingleEmployeeThreesixty(' . $id_e . ');return false;">';
        $objResponse->assign('top_nav', 'innerHTML', $buttons_360);
    }
    return $objResponse;
}

function display360Degree_content($id_e, $delete_destination)
{

    $delete_function = ($delete_destination == DELETE_EVAL_DESTINATION_360 ? 'xajax_module360_delete360SingleEvaluation' : 'xajax_module360_employee_delete360SingleEvaluation');
    $sql = 'SELECT
                ti.completed,
                ksp.knowledge_skill_point,
                te.ID_TSE,
                te.hash_id,
                te.date_sentback,
                te.evaluator,
                te.threesixty_score,
                te.notes,
                et.score_status,
                ti.is_self_evaluation,
                ti.threesixty_scores_status
            FROM
                threesixty_invitations ti
                INNER JOIN employees e
                    ON e.ID_E = ti.ID_E
                INNER JOIN employees_topics et
                    ON e.ID_E = et.ID_E
                LEFT JOIN threesixty_evaluation te
                    ON ti.hash_id = te.hash_id
                LEFT JOIN knowledge_skills_points ksp
                    ON ksp.ID_KSP = te.ID_KSP
            WHERE
                ti.ID_E = ' . $id_e . '
                AND ti.customer_id = ' . CUSTOMER_ID . '
                AND ti.completed <> ' . AssessmentInvitationCompletedValue::NOT_COMPLETED . '
            ORDER BY
                te.date_sentback DESC,
                ti.hash_id,
                ksp.knowledge_skill_point';
    $deg = MysqlUtils::getData($sql, true);

    $evaluator_width = '20%';
    $competence_width = '50%';
    if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
        $evaluator_width = '15%';
        $competence_width = '45%';
    }

    if ($deg) {
        $html .='<table border="0" cellspacing="1" cellpadding="2" width="750" class="border1px"><tr>
            <td width="' . $evaluator_width .'" class="bottom_line shaded_title"><strong>' . TXT_UCF('EVALUATOR') . '</strong></td>
            <td width="5%" class="bottom_line shaded_title">&nbsp;</td>
            <td width="15%" class="bottom_line shaded_title"><strong>' . TXT_UCF('DATE_SENT') . '</strong></td>
            <td width="' . $competence_width . '" class="bottom_line shaded_title"><strong>' . TXT_UCF('COMPETENCE') . '</strong></td>
            <td width="10%" class="bottom_line shaded_title centered"><strong>' . TXT_UCF(CUSTOMER_360_SCORE_LABEL) . '</strong></td>';

        if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
            $html .='<td width="10%" class="bottom_line shaded_title"><strong>' . TXT_UCF('REMARKS') . '</strong></td>';
        }

        $html .='</tr>';
        $newHashId = '';

        foreach ($deg as $e) {
            $ksp_name = empty($e['knowledge_skill_point']) ? TXT_UCF('ASSESSMENT_DELETED') : $e['knowledge_skill_point'];
            $is_deleted =  $e['completed'] == AssessmentInvitationCompletedValue::RESULT_DELETED;
            $is_self_evaluation = $e['is_self_evaluation'] == AssessmentInvitationTypeValue::IS_SELF_EVALUATION;
            $is_actual_evaluation = $e['threesixty_scores_status'] < AssessmentInvitationStatusValue::HISTORICAL;

            // TODO: deze is fout want kijkt nog naar employees_topics !!
            $is_score_display_allowed = (CUSTOMER_OPTION_USE_SELFASSESSMENT && $is_self_evaluation && $is_actual_evaluation) ? ($e['score_status'] == ScoreStatusValue::FINALIZED) : true;
            $oldHasId = $newHashId;
            $newHashId = $e['hash_id'];
            $sentbackDate = $e['date_sentback'];

            $is_new_evaluation = $oldHasId <> $newHashId;

            $evaluator = $is_new_evaluation ? $e['evaluator'] : '&nbsp;';
            $button_delete_evaluation = '';
            if ($is_new_evaluation &&
                !$is_deleted &&
                PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {
                $button_delete_evaluation .= '<a href="" onclick="' . $delete_function . '(' . $id_e . ', \'' . $e['hash_id']. '\');return false;" title="' . TXT_UCW('DELETE_360') . '"><img src="' . ICON_DELETE . '" class="icon-style" border="0"  width="16" height="16"></a>';
            }

            // datum conversie als <> old
            // wel tonen bij volgende hash
            $sentBack = $is_new_evaluation ? date("d-m-Y", strtotime($sentbackDate)) : '&nbsp;';
            $remarks = nl2br(htmlspecialchars($e['notes']));

            // omdat de $is_score_display_allowed niet goed werkt mag alleen de HR/admin de tab inzien (zie module_access tabel).
            // daarom mag de score altijd getoond worden
            $employeeScoreDisplay = $is_deleted ? 'X' : ModuleUtils::ScorepointLetter($e['threesixty_score']);
            $employeeNoteDisplay =  $is_deleted ? 'X' : $remarks ;

//            $employeeScoreDisplay = ($is_deleted ? 'X' : ($is_score_display_allowed ? ModuleUtils::ScorepointLetter($e['threesixty_score']) : '<span title="'. TXT_UCF('MANAGER_HAS_NOT_FILLED_IN_ASSESSMENT') . '">!</span>'));
//            $employeeNoteDisplay =  $is_deleted ? 'X' : ($is_score_display_allowed ? $remarks : '');

            $shaded = $is_new_evaluation ? 'shaded_title' : '';

            $html .='
            <tr>
                <td class="bottom_line ' . $shaded . '">' . $evaluator . '</td>
                <td class="bottom_line ' . $shaded . '">' . $button_delete_evaluation . '</td>
                <td class="bottom_line ' . $shaded . '">' . $sentBack . '</td>
                <td class="bottom_line ' . $shaded . '">' . $ksp_name . '</td>
                <td class="bottom_line ' . $shaded . ' centered">' . $employeeScoreDisplay . '</td>';

            if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                $html .= '<td class="bottom_line ' . $shaded . '">' . $employeeNoteDisplay . '</td>';
            }

            $html .= '</tr>';
        }
        $html .='</table>';
    } else {
        $html = '<br /><p class="info-text">' . TXT_UCF('NO_VALUES_RETURNED') . '</p>';
    }
    return $html;
}



function module360_executePrintSingleEmployeeThreesixty($id_e) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_REPORT_360)) {
        $_SESSION['degree'] = $id_e;

        $objResponse->script('window.open(\'print/print_threesixty.php\',\'\',\'resizable=yes,width=860,height=800\')');
    }

    return $objResponse;
}

function module360_executePrintThreesixty($tForm) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_REPORT_360)) {
        $selectEmps = new SelectEmployees();
        $alert_txt = '';

        if (!$selectEmps->validateFormInput($tForm, $_SESSION)) {
            $alert_txt .= $selectEmps->getErrorTxt();
            $hasError = true;
        }

        if (!$hasError) {
            $selectedEmpsIds = $selectEmps->processResults($tForm, $_SESSION);

            $_SESSION['degree'] = implode(',', $selectedEmpsIds);

            $objResponse->script('window.open(\'print/print_threesixty.php\',\'\',\'resizable=yes,width=860,height=800\')');
        } else {
            $objResponse->alert($alert_txt);
        }
    }

    return $objResponse;
}


function module360_deleteEmployee360($id_e)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {

        $objResponse->confirmCommands(1, TXT_UCF('DO_YOU_WANT_TO_DELETE_THIS_EVALUATION'). ' ?');
        $objResponse->call("xajax_module360_executeDeleteEmployee360", $id_e);
    }

    return $objResponse;
}


function module360_executeDeleteEmployee360($id_e) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {

        unset($_SESSION[SESSION_SELECTED_THEESIXTY_DEGREES]);

        // hbd: niet meer verwijderen, alleen markeren!!!
        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    completed = ' . AssessmentInvitationCompletedValue::RESULT_DELETED . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND ID_E = ' . $id_e;

        BaseQueries::performQuery($sql);

        $objResponse->alert(TXT_UCF('360_EVALUATION_DELETED'));

        $objResponse->loadCommands(module360_display360Employees());
    }

    return $objResponse;
}

function module360_employee_delete360SingleEvaluation($id_e, $hash_id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {

        $objResponse->confirmCommands(2, TXT_UCF('DO_YOU_WANT_TO_DELETE_THIS_EVALUATION'). ' ?');
        $objResponse->call("xajax_module360_executeDelete360SingleEvaluation", $id_e, $hash_id);
        $objResponse->call('xajax_moduleEmployees_360_menu_deprecated', $id_e);
    }

    return $objResponse;
}

function module360_delete360SingleEvaluation($id_e, $hash_id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {

        $objResponse->confirmCommands(2, TXT_UCF('DO_YOU_WANT_TO_DELETE_THIS_EVALUATION'). ' ?');
        $objResponse->call('xajax_module360_executeDelete360SingleEvaluation', $id_e, $hash_id);
        $objResponse->call('xajax_module360_display360Degree', $id_e);
    }

    return $objResponse;
}


function module360_executeDelete360SingleEvaluation($id_e, $hash_id) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_REPORT_360)) {

        unset($_SESSION[SESSION_SELECTED_THEESIXTY_DEGREES]);

        $sql = 'UPDATE
                    threesixty_invitations
                SET
                    completed = ' . AssessmentInvitationCompletedValue::RESULT_DELETED . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND hash_id = "' . $hash_id . '"
                    AND completed = ' . AssessmentInvitationCompletedValue::COMPLETED . '
                    AND ID_E = ' . $id_e;

        BaseQueries::performQuery($sql);
        $objResponse->alert(TXT_UCF('360_EVALUATION_DELETED'));
    }

    return $objResponse;
}




?>