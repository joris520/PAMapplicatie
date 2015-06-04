<?php

require_once('modules/common/moduleConsts.inc.php');
require_once('modules/model/queries/to_refactor/HistoryQueries.class.php');
require_once('modules/process/library/AssessmentCycleSafeFormProcessor.class.php');

/**
 * Makes a timeshot of the active answers and their questions.
 * @param <type> $id_e
 * @param <type> $id_ehpd
 */
function addTimeshotMiscAnswers($id_e, $id_ehpd)
{
    $sql = 'SELECT
                *
            FROM
                employees_misc_answers AS ema
                LEFT JOIN _customers_misc_questions AS cmq
                    ON (ema.ID_MQ = cmq.ID_MQ)
            WHERE
                ema.customer_id = ' . CUSTOMER_ID . '
                AND ema.ID_E = ' . $id_e . '
                AND cmq.active = 1
            ORDER BY
                cmq.seq_num';
    $queryResult = BaseQueries::performQuery($sql);

    while ($row = @mysql_fetch_assoc($queryResult)) {
        $answer = $row['answer'];
        $question = $row['question'];
        $sql = 'INSERT INTO
                    employees_history_misc_answers
                    (   customer_id,
                        ID_EHPD,
                        question,
                        answer
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $id_ehpd . ',
                       "' . mysql_real_escape_string($question) . '",
                       "' . mysql_real_escape_string($answer) . '"
                    )';
        BaseQueries::performQuery($sql);
    }
}

function addTimeshotTotalScores($id_e, $id_ehpd)
{
    $sql = 'SELECT
                total_score,
                behaviour_score,
                results_score,
                total_score_comment,
                behaviour_score_comment,
                results_score_comment
            FROM
                employees_total_scores
            WHERE
                customer_id = ' . CUSTOMER_ID . '
                AND ID_E = ' . $id_e . '
            LIMIT 1';
    $queryResult = BaseQueries::performQuery($sql);

    while ($row = @mysql_fetch_assoc($queryResult)) {
        $total_score = $row['total_score'];
        $behaviour_score = $row['behaviour_score'];
        $results_score = $row['results_score'];
        $total_score_comment = $row['total_score_comment'];
        $behaviour_score_comment = $row['behaviour_score_comment'];
        $results_score_comment = $row['results_score_comment'];

        HistoryQueries::addHistoricalTotalScores($id_ehpd,
                                                 $total_score,
                                                 $behaviour_score,
                                                 $results_score,
                                                 $total_score_comment,
                                                 $behaviour_score_comment,
                                                 $results_score_comment);
    }
}

/**
 * Makes a timeshot of the employee.
 */
function addTimeshotScores($id_e, $id_f, $historical_note, $mode = RATING_FUNCTION_PROFILE, $conversation_date = null)
{
    $modified_by_user = USER;
    $modified_time = MODIFIED_TIME;
    $modified_date = MODIFIED_DATE;

    if (empty($conversation_date)) {
        $conversation_date = EmployeeScoresService::getEvaluationDate($id_e);
    }
    $conversation_date = empty($conversation_date) ? date('d-m-Y') : $conversation_date;

    // Bij een woordenboek wordt geen functieprofiel meegegeven
    if ($mode == RATING_DICTIONARY) {
        $id_f = 'NULL';
    }

    // get function name
    if ($mode == RATING_FUNCTION_PROFILE) {
        $function = FunctionsServiceDeprecated::getFunction($id_f);
        $functionName = $function['function'];
    }

    $sql = 'INSERT INTO
                employees_history_points_date
                (   customer_id,
                    ID_E,
                    rating,
                    ID_F,
                    function ,
                    eh_date,
                    historical_note,
                    conversation_date,
                    modified_by_user ,
                    modified_time ,
                    modified_date
                ) VALUES (
                    ' . CUSTOMER_ID . ',
                    ' . $id_e . ',
                   "' . mysql_real_escape_string($mode) . '",
                    ' . $id_f . ',
                   "' . mysql_real_escape_string($functionName) . '",
                   "' . $modified_date . '",
                   "' . mysql_real_escape_string($historical_note) . '",
                   "' . mysql_real_escape_string($conversation_date) . '",
                   "' . $modified_by_user . '",
                   "' . $modified_time . '",
                   "' . $modified_date . '"
                )';

    $queryExecute = BaseQueries::performQuery($sql);

    $id_ehpd = mysql_insert_id();

    if ($mode == RATING_FUNCTION_PROFILE) {
        $sql = 'SELECT
                    DISTINCT(ksp.knowledge_skill_point),
                    ks.ID_KS,
                    ks.knowledge_skill,
                    ksp.ID_KSP,
                    ksp.ID_C,
                    ksp.is_cluster_main,
                    ksc.cluster,
                    fp.scale AS norm,
                    ep.scale AS score,
                    ep.note
                FROM
                    function_points fp
                    INNER JOIN knowledge_skills_points ksp
                        ON ksp.ID_KSP = fp.ID_KSP
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksp.ID_C = ksc.ID_C
                    LEFT JOIN employees_points ep
                        ON ep.ID_KSP = ksp.ID_KSP
                WHERE
                    ep.ID_E = ' . $id_e . '
                    AND fp.ID_F = ' . $id_f . '
                    AND fp.customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    ksp.knowledge_skill_point';
    } else if ($mode == RATING_DICTIONARY) {
        $sql = 'SELECT
                    DISTINCT(ksp.knowledge_skill_point),
                    ks.ID_KS,
                    ks.knowledge_skill,
                    ksp.ID_KSP,
                    ksp.ID_C,
                    ksp.is_cluster_main,
                    ksc.cluster,
                    emp_sub.score,
                    emp_sub.note
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksp.ID_C = ksc.ID_C
                    LEFT JOIN ( SELECT
                                    e.ID_E,
                                    ep.ID_KSP,
                                    ep.scale as score,
                                    ep.note
                                FROM
                                    employees_points ep
                                    INNER JOIN employees e
                                        ON e.ID_E = ep.ID_E
                                WHERE
                                    ep.ID_E = ' . $id_e . '
                              ) emp_sub
                        ON emp_sub.ID_KSP = ksp.ID_KSP
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    ks.knowledge_skill,
                    ksp.knowledge_skill_point';
    }

    $queryResult = BaseQueries::performQuery($sql);

    while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {

        $knowledge_skill = $queryResult_row['knowledge_skill'];
        $knowledge_skill_point = $queryResult_row['knowledge_skill_point'];
        $score = $queryResult_row['score'];
        $norm = $queryResult_row['norm'];
        $note = $queryResult_row['note'];
        $cluster = $queryResult_row['cluster'];
        $is_cluster_main = $queryResult_row['is_cluster_main'];
        $id_ks = $queryResult_row['ID_KS'];
        $id_ksp = $queryResult_row['ID_KSP'];
        $id_c = $queryResult_row['ID_C'];

        if (!$score) {
            $score = "NULL";
        } else {
            $score = $queryResult_row[score];
        }

        $sql = 'INSERT INTO
                    employees_history_points
                    (   customer_id,
                        ID_EHPD,
                        ID_KS,
                        knowledge_skill,
                        ID_KSP,
                        knowledge_skill_point,
                        standard_assessment,
                        standard_function,
                        note,
                        ID_C,
                        cluster,
                        is_cluster_main,
                        modified_by_user,
                        modified_time,
                        modified_date
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $id_ehpd . ',
                        ' . $id_ks . ',
                       "' . mysql_real_escape_string($knowledge_skill) . '",
                        ' . $id_ksp . ',
                       "' . mysql_real_escape_string($knowledge_skill_point) . '",
                       "' . mysql_real_escape_string($score) . '",
                       "' . mysql_real_escape_string($norm) . '",
                       "' . mysql_real_escape_string($note) . '",
                        ' . $id_c . ',
                       "' . mysql_real_escape_string($cluster) . '",
                        ' . $is_cluster_main . ',
                       "' . $modified_by_user . '",
                       "' . $modified_time . '",
                       "' . $modified_date . '"
                    )';

        $queryExecute = BaseQueries::performQuery($sql);
    }

    return $id_ehpd;
}

/**
 * Creates overview of timeshots.
 */

function buildTimeshotDates($employee_id,
                            $selected_id,
                            $mode = RATING_FUNCTION_PROFILE,
                            $showEmployeeName = true)
{
    $evaluationPeriodTimeshots  = array();
    $assessmentCycles           = array();
    $displayWidth               = 500;

    $sql = 'SELECT
                ehpd.ID_EHPD,
                ehpd.eh_date,
                ehpd.conversation_date,
                ehpd.function,
                ehpd.historical_note
            FROM
                employees_history_points_date ehpd
                LEFT JOIN employees e
                    ON e.ID_E = ehpd.ID_E
            WHERE
                ehpd.customer_id = ' . CUSTOMER_ID . '
                AND ehpd.ID_E    = ' . $employee_id . '
                AND	ehpd.rating  = ' . $mode .  '
            ORDER BY
                ehpd.ID_EHPD DESC';

    $queryResult = BaseQueries::performQuery($sql);

    if (mysql_num_rows($queryResult) > 0) {

        while ($timeshot = @mysql_fetch_assoc($queryResult)) {
            if ($timeshot['ID_EHPD'] == $selected_id) {
                $timeshot['selected'] = true;
            }
            $timeshotDate = $timeshot['eh_date'];
            $timeshot['eh_date_display'] = DateUtils::convertToDisplayDate($timeshotDate);
            $assessmentCycle = AssessmentCycleService::getCurrentValueObject($timeshotDate);
            $assessmentCycleId = $assessmentCycle->getId();
            //$assessmentCycleId = empty($assessmentCycleId) ? '-' : $assessmentCycleId;

            $assessmentCycles[$assessmentCycleId] = $assessmentCycle;
            $evaluationPeriodTimeshots[$assessmentCycleId][] = $timeshot;
        }
    }


    $timeshotDatesHtml = '';

    global $smarty;

    $timeshotDateTemplate = $smarty->createTemplate('to_refactor/mod_history/timeshotDateView.tpl');
    $timeshotDateTemplate->assign('id_e', $employee_id);
    $timeshotDateTemplate->assign('mode', $mode);
    $timeshotDateTemplate->assign('displayWidth', $displayWidth);
    $timeshotDateTemplate->assign('showEmployeeName', $showEmployeeName);
    $timeshotDateTemplate->assign('showFunction', $mode == RATING_FUNCTION_PROFILE);
    $timeshotDateTemplate->assign('isDeleteAllowed', PermissionsService::isDeleteAllowed(PERMISSION_HISTORY));

    foreach($evaluationPeriodTimeshots as $assessmentCycleId => $timeshots) {
        $assessmentCycle = $assessmentCycles[$assessmentCycleId];
        $timeshotDateTemplate->assign('assessmentCycleDescriptionHtml', AssessmentCycleInterfaceBuilder::getDetailHtml($displayWidth, $assessmentCycle));
        $timeshotDateTemplate->assign('timeshots', $timeshots);
        $timeshotDatesHtml .= $smarty->fetch($timeshotDateTemplate) ;
    }

    $employeeName = EmployeeProfileServiceDeprecated::getEmployeeName($employee_id);
    $tpl = $smarty->createTemplate('to_refactor/mod_history/timeshotDateGroup.tpl');
    $tpl->assign('name', $employeeName);
    $tpl->assign('timeshotDatesHtml', $timeshotDatesHtml);
    $tpl->assign('id_e', $employee_id);
    $tpl->assign('mode', $mode);
    $tpl->assign('displayWidth', $displayWidth);
    $tpl->assign('showEmployeeName', $showEmployeeName);
    $tpl->assign('showFunction', $mode == RATING_FUNCTION_PROFILE);
    $tpl->assign('isDeleteAllowed', PermissionsService::isDeleteAllowed(PERMISSION_HISTORY));

    return $smarty->fetch($tpl);
}

/**
 * Shows the selected timeshot.
 */
function buildTimeshot($id_ehpd, $mode = RATING_FUNCTION_PROFILE)
{
    global $smarty;

    // history points
    $sql = 'SELECT
                distinct(ehp.knowledge_skill_point),
                ehp.ID_EHPD,
                ehp.knowledge_skill,
                ehp.cluster,
                ehp.standard_assessment,
                ehp.is_cluster_main,
                ehp.standard_function,
                ehp.note
            FROM
                employees_history_points ehp
            WHERE
                ehp.customer_id = ' . CUSTOMER_ID . '
                AND ehp.ID_EHPD = ' . $id_ehpd . '
            ORDER BY
                ehp.knowledge_skill,
                CASE
                    WHEN ehp.cluster is null
                    THEN "zzz"
                    ELSE ehp.cluster
                END,
                ehp.is_cluster_main DESC,
                ehp.knowledge_skill_point';
    $ehpData = BaseQueries::performQuery($sql);

    $emp_points = array();
    while ($row = @mysql_fetch_assoc($ehpData)) {
        $row['cluster'] = empty($row['cluster']) ? '-' : $row['cluster'];
        $emp_points[] = $row;
    }

    // timeshot datum info
    $sql = 'SELECT
                ehpd.function,
                ehpd.conversation_date
            FROM
                employees_history_points_date ehpd
            WHERE
                ehpd.customer_id = ' . CUSTOMER_ID . '
                AND ehpd.ID_EHPD = ' . $id_ehpd;
    $ehpdData = BaseQueries::performQuery($sql);

    $ehpd_info = @mysql_fetch_assoc($ehpdData);

    // extra vragen
    $sql = 'SELECT
                ehma.question,
                ehma.answer
            FROM
                employees_history_misc_answers ehma
            WHERE
                ehma.customer_id = ' . CUSTOMER_ID . '
                AND ehma.ID_EHPD = ' . $id_ehpd;
    $ehmaData =  BaseQueries::performQuery($sql);

    $misc_questions = array();
    while ($row = @mysql_fetch_assoc($ehmaData)) {
        $misc_questions[] = $row;
    }

    $tpl = $smarty->createTemplate('to_refactor/mod_history/timeshot.tpl');

    if (CUSTOMER_OPTION_SHOW_FINAL_RESULT_TIMESHOTS &&
        PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEE_FINAL_RESULT)) {
        $getTS = HistoryQueries::historicalTotalScores($id_ehpd);
        $getTS_row = @mysql_fetch_assoc($getTS);

        $tpl->assign('showTotalScoreHistory', 1);
        $tpl->assign('total_result_score', ModuleUtils::ScorepointTextDescriptionNew($getTS_row["total_score"]));
        $tpl->assign('total_result_comment', $getTS_row["total_score_comment"]);
        $tpl->assign('behaviour_score', ModuleUtils::ScorepointTextDescriptionNew($getTS_row["behaviour_score"]));
        $tpl->assign('behaviour_comment', $getTS_row["behaviour_score_comment"]);
        $tpl->assign('results_score', ModuleUtils::ScorepointTextDescriptionNew($getTS_row["results_score"]));
        $tpl->assign('results_comment', $getTS_row["results_score_comment"]);
    } else {
        $tpl->assign('showTotalScoreHistory', 0);
    }

    $tpl->assign('emp_points', $emp_points);
    $tpl->assign('conversation_date', $ehpd_info['conversation_date']);
    $tpl->assign('job_profile', $ehpd_info['function']);
    $tpl->assign('misc_questions', $misc_questions);
    $tpl->assign('showFunction', $mode == RATING_FUNCTION_PROFILE);
    $tpl->assign('showNorm', ($mode == RATING_FUNCTION_PROFILE) AND (CUSTOMER_OPTION_SHOW_NORM));
    $tpl->assign('showDefaultQuestions', CUSTOMER_OPTION_USE_DEFAULT_QUESTIONS);
    $tpl->assign('showRemarks', CUSTOMER_OPTION_USE_SKILL_NOTES);
    return $smarty->fetch($tpl);
}

function moduleHistory_menu($mode = RATING_FUNCTION_PROFILE)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_HISTORY)) {
        unset($_SESSION['history_id_e']);
        $objResponse->call('xajax_moduleHistory', $mode);
    }
    return $objResponse;
}


function getAllHistoryEmployeeIds()
{
    $queryResult = HistoryQueries::getHistoryEmployeeIds();
    $historyEmployees = array();
    while ($historyEmployee = @mysql_fetch_assoc($queryResult)) {
        $historyEmployees[$historyEmployee['ID_E']] = $historyEmployee['ID_E'];
    }
    return $historyEmployees;
}

function filterHistoryEmployees($search_emp) {

    $historyEmployees = getAllHistoryEmployeeIds();
    $emps = new EmployeesQueries();
    $queryResult = $emps->getEmployeesBasedOnUserLevel($search_emp);

    $employees = array();
    while ($row = @mysql_fetch_assoc($queryResult)) {
        // alleen toevoegen als de employee ook history heeft
        if ($historyEmployees[$row['ID_E']] == $row['ID_E']) {
            $employees[] = $row;
        }
    }

    return $employees;
}

function moduleHistory($mode = RATING_FUNCTION_PROFILE) {
    global $smarty;
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_HISTORY)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_HISTORY);

        $history_id_e = @$_SESSION['history_id_e'];
        $tpl = $smarty->createTemplate('to_refactor/mod_history/mod_history.tpl');
        $employees = filterHistoryEmployees('');
        //$tpl->assign('mode', $mode);
        $tpl->assign('history_id_e', $history_id_e);
        $tpl->assign('showlimit', (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT && count($employees) >= CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER));
        $tpl->assign('menuLevel', $menuLevel);
        $tpl->assign('active', $active_module);

        $tpl->assign('employees', $employees);

        $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($tpl));

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_HISTORY));
    }
    return $objResponse;
}

function buildTimeshotNav($id_e = null, $isEmployeeSelected = false) {
    global $smarty;
    $tpl = $smarty->createTemplate('to_refactor/mod_history/mod_history_nav.tpl');
    $tpl->assign('isEmployeeSelected', $isEmployeeSelected);
    $tpl->assign('id_e', $id_e);
    return $smarty->fetch($tpl);
}

/**
 * Shows the searchresults.
 * @param <type> $sForm
 * @return xajaxResponse
 */
function moduleHistory_searchHistoryE($sForm) {
    global $smarty;
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_HISTORY)) {

        $mode = $sForm[mode];
        $search_emp = addslashes($sForm['s_employee']);
        $history_id_e = @$_SESSION['history_id_e'];

        $employees = filterHistoryEmployees($search_emp);

        $tpl = $smarty->createTemplate('to_refactor/mod_history/mod_history_emps.tpl');
        $tpl->assign('mode', $mode);
        $tpl->assign('showlimit', (CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT && count($employees)  >= CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER));
        $tpl->assign('history_id_e', $history_id_e);
    //    $tpl->assign('active', $active_module);
        $tpl->assign('employees', $employees);

        $objResponse->assign('searchEmployeesResult', 'innerHTML', $smarty->fetch($tpl));
    }

    return $objResponse;
}

//------->

/**
 * Shows an overview of the timeshots for selected employee and mode.
 */

function moduleEmployees_history_direct($objResponse, $id_e, $mode = RATING_FUNCTION_PROFILE)
{
    global $smarty;
    ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_HISTORY);

    $tpl = $smarty->createTemplate('to_refactor/mod_history/mod_history_empdata.tpl');
    $objResponse->assign('empPrint', 'innerHTML', $smarty->fetch($tpl));
    $objResponse->assign('ehp_window2', 'innerHTML', buildTimeshotDates($id_e, 0, $mode, 0));

    EmployeesTabInterfaceProcessor::displayMenu($objResponse, $id_e, MODULE_EMPLOYEE_HISTORY);
    
    $objResponse->assign('top_nav_btn', 'innerHTML', '');

    //$objResponse->assign('eh_nav', 'innerHTML', buildTimeshotNav($id_e, true));
}

function moduleHistory_showEmployeeHistory($id_e, $mode = RATING_FUNCTION_PROFILE, $showEmployeeName = true)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_HISTORY)) {
        $mode = CUSTOMER_OPTION_USE_RATING_DICTIONARY ? $mode : RATING_FUNCTION_PROFILE;

        $objResponse->assign('ehp_window3', 'innerHTML', '');

        //WINDOW 2: SHOW ALL DATE HISTORY PER EMPLOYEEE
        $objResponse->assign('ehp_window2', 'innerHTML', buildTimeshotDates($id_e, 0, $mode, $showEmployeeName));
        $objResponse->assign('eh_nav', 'innerHTML', buildTimeshotNav($id_e, true));
    }

    return $objResponse;
}

function isConversationDateAvailable($id_e)
{
    $sql = 'SELECT
                DATE_FORMAT(conversation_date, "%d-%m-%Y") conversation_date
            FROM
                employees_topics
            WHERE
                customer_id = ' . CUSTOMER_ID . '
                AND ID_E = ' . $id_e . '
            LIMIT 1';
    $res = BaseQueries::performQuery($sql);

    $conversation_date = '';
    if(@mysql_num_rows($res) > 0) {
        $row = @mysql_fetch_assoc($res);
        $conversation_date = $row['conversation_date'];
    }

    mysql_free_result($res);

    return $conversation_date;
}

/**
 * Adds a timeshot.
 * @param <type> $id_e
 * @param <type> $mode
 * @return xajaxResponse
 */
function moduleHistory_addEmployeeHistory($id_e, $mode, $page_name, $historical_note, $conversation_date = null) {

    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) &&
        (PermissionsService::isEditAllowed(PERMISSION_HISTORY) || PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_SCORES))) {

        $hasError = false;
        $conversation_date = empty($conversation_date) ? DateUtils::convertToDisplayDate(EmployeeScoresService::getEvaluationDate($id_e)) : $conversation_date;
        if (empty($conversation_date)) {
            $hasError = true;
            $objResponse->alert(TXT_UCF('PLEASE_ENTER_A_CONVERSATION_DATE'));
        }

        if (!$hasError) {
            if ($mode == RATING_FUNCTION_PROFILE) {
                addTimeshotFunctionMode($id_e, $historical_note, $conversation_date);
            } else if ($mode == RATING_DICTIONARY) {
                addTimeshotCompetenceMode($id_e, $historical_note, $conversation_date);
            }

            if ($page_name == "history") {
                // aangeroepen vanaf de historie pagina, niet vanuit medewerkersprofiel

                $objResponse->script('xajax_moduleHistory_showEmployeeHistory( ' . $id_e . ', \'' . $mode . '\')');

            } else {
                // aangeroepen vanaf de medewerkersprofielpagina (niet vanaf historiepagina)

                // slechts een verandering aan pagina: datum laatste aanpassing moet opnieuw worden opgehaald en getoond:
                $date_display = HistoryService::getLastTimeshotdateHtml($id_e);
                $objResponse->assign('last_time_shot_date', 'innerHTML', $date_display);
            }
        }
    }

    return $objResponse;
}


function addTimeshotFunctionMode($employee_id, $timeshot_note, $conversation_date)
{
    $functionIds = getAllFunctions($employee_id);
    foreach ($functionIds as $functionId) {
        $id_timeshot = addTimeshotScores($employee_id, $functionId, $timeshot_note, RATING_FUNCTION_PROFILE, $conversation_date);
        addTimeshotMiscAnswers($employee_id, $id_timeshot);

        if (CUSTOMER_OPTION_USE_FINAL_RESULT) {
            addTimeshotTotalScores($employee_id, $id_timeshot);
        }
    }
}

function addTimeshotCompetenceMode($employee_id, $timeshot_note, $conversation_date)
{
    $id_timeshot = addTimeshotScores($employee_id, '', $timeshot_note, RATING_DICTIONARY, $conversation_date);
    addTimeshotMiscAnswers($employee_id, $id_timeshot);

    if(CUSTOMER_OPTION_USE_FINAL_RESULT) {
        addTimeshotTotalScores($employee_id, $id_timeshot);
    }
}

function getAllFunctions($id_e) {
    $functions = array();
    $sql = 'SELECT
                e.ID_FID
            FROM
                employees e
            WHERE
                e.customer_id = ' . CUSTOMER_ID . '
                AND e.ID_E = ' . $id_e . '
            LIMIT 1';
    $result = BaseQueries::performQuery($sql);
    $row = @mysql_fetch_assoc($result);

    $functions[] = $row['ID_FID'];

    $sql = 'SELECT
                eaf.ID_F
            FROM
                employees_additional_functions eaf
            WHERE
                eaf.customer_id = ' . CUSTOMER_ID . '
                AND eaf.ID_E = ' . $id_e;
    $result = BaseQueries::performQuery($sql);

    while($row = @mysql_fetch_assoc($result)) {
        $functions[] = $row['ID_F'];
    }
    return $functions;
}

/**
 * Shows selected timeshot.
 * @global <type> $smarty
 * @param <type> $eid
 * @param <type> $id_ehpd
 * @param <type> $mode
 * @return xajaxResponse
 */
function moduleHistory_showSelectedEmployeeHistory($eid, $id_ehpd, $mode = RATING_FUNCTION_PROFILE, $showEmployeeName) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_HISTORY)) {

        $show_prev_html = TXT_UCF('SHOW_LAST') . '&nbsp;
                                    <select name="sel_last_hist" id="sel_last_hist"
                                    onchange="xajax_moduleHistory_showPreviousHistories(' . $eid . ',' . $id_ehpd . ', this.options[this.selectedIndex].value, \''.$mode.'\')">';

        $show_prev_html .='<option value="0">-' . TXT_LC('SELECT') . '-</option>';

        for ($i = 1; $i <= 10; $i++) {
            $show_prev_html .='<option value="' . $i . '">' . $i . '</option>';
        }

        $show_prev_html .='</select>';

        //$objResponse->alert('Eto yun 2');

        $objResponse->assign('ehp_window2', 'innerHTML', buildTimeshotDates($eid, $id_ehpd, $mode, $showEmployeeName));
        $objResponse->assign('ehp_window3', 'innerHTML', buildTimeshot($id_ehpd, $mode));
        $objResponse->assign('topPrint', 'innerHTML',
                $show_prev_html .
                '&nbsp;<input type="button" class="btn btn_width_80" value="' . TXT_BTN('PRINT') . '"
                                onclick="MM_openBrWindow(\'print/rpdf_print_history.php?mode='.$mode.'&id_ehpd=' . $id_ehpd . '\',\'\',\'resizable=yes, width=800,height=800\');return false;" />');
    }

    return $objResponse;
}

/**
 * Deletes a timeshot.
 * @param <type> $dateForm
 * @return xajaxResponse
 */
function moduleHistory_deleteSelectedEmployeeHistory($dateForm, $showEmployeeName)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_HISTORY)) {

        if ($dateForm['id_ehpd']) {
            $empid = $dateForm['empid'];
            $id_ehpd = $dateForm['id_ehpd'];
            $s_id_ehpd = implode(",", $id_ehpd);

            $sql = 'DELETE FROM
                        employees_history_total_scores
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_EHPD IN (' . $s_id_ehpd . ')';

            $queryExecute = BaseQueries::performQuery($sql);

            $sql = 'DELETE FROM
                        employees_history_points
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_EHPD IN (' . $s_id_ehpd . ')';

            $queryExecute = BaseQueries::performQuery($sql);

            $sql = 'DELETE FROM
                        employees_history_misc_answers
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_EHPD IN (' . $s_id_ehpd . ')';

            $queryExecute = BaseQueries::performQuery($sql);

            $sql = 'DELETE FROM
                        employees_history_points_date
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_EHPD IN (' . $s_id_ehpd . ')';

            $queryExecute = BaseQueries::performQuery($sql);

            $objResponse->script('xajax_moduleHistory_showEmployeeHistory( ' . $empid . ', \'' . $dateForm[mode] . '\', \'' . $showEmployeeName . '\')');
        } else {
            $objResponse->alert(TXT_UCF('PLEASE_SELECT_HISTORY_DATES_TO_DELETE'));
        }

        $objResponse->assign("delbtn", "disabled", false);
    }

    return $objResponse;
}

/**
 * Processes the select box and shows multiple timeshots at once.
 * @param <type> $id_e
 * @param <type> $id_ehpd
 * @param <type> $last_hist_count
 * @param <type> $mode
 * @return xajaxResponse
 */
function moduleHistory_showPreviousHistories($id_e, $id_ehpd, $last_hist_count, $mode = RATING_FUNCTION_PROFILE)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_HISTORY)) {

        $sql = 'SELECT
                    function
                FROM
                    employees_history_points_date
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_EHPD = ' . $id_ehpd;
        $result = BaseQueries::performQuery($sql);

        $row = @mysql_fetch_assoc($result);
        $function = $row["function"];

        $last_hist_count++;

        $sql = 'SELECT
                    ID_EHPD
                FROM
                    employees_history_points_date
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $id_e . '
                    AND ID_EHPD <= ' . $id_ehpd . '
                    AND rating = ' . $mode . '
                    AND (function = "' . $function . '" OR rating = "' . RATING_DICTIONARY . '")
                ORDER BY
                    ID_EHPD DESC
                LIMIT 0, ' . $last_hist_count;

        $queryResult = BaseQueries::performQuery($sql);
        $id_ehpds = '';
        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
            $id_ehpds = $id_ehpds . $queryResult_row['ID_EHPD'] . ', ';
        }

        $id_ehpds = substr($id_ehpds, 0, strlen($id_ehpds) - 2);

        $html = '';

        if (CUSTOMER_OPTION_USE_FINAL_RESULT) {
            $sql = 'SELECT
                        total_score,
                        behaviour_score,
                        results_score,
                        total_score_comment,
                        behaviour_score_comment,
                        results_score_comment
                    FROM
                        employees_history_total_scores
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_EHPD IN (' . $id_ehpds . ')
                    ORDER BY
                        ID_EHPD';
            $queryResult = BaseQueries::performQuery($sql);

            while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {
// WAT DOEN WE HIER?
            }

        }

        $sql = 'SELECT
                    DISTINCT(ehp.knowledge_skill_point),
                    ehp.ID_EHPD,
                    ehp.knowledge_skill,
                    ehp.cluster,
                    ehp.standard_assessment,
                    ehp.standard_function,
                    ehp.note,
                    ehp.cluster,
                    ehp.modified_date,
                    ehpd.conversation_date
                FROM
                    employees_history_points ehp
                    INNER JOIN employees_history_points_date ehpd
                        ON ehp.ID_EHPD = ehpd.ID_EHPD
                WHERE
                    ehp.customer_id = ' . CUSTOMER_ID . '
                    AND ehp.ID_EHPD IN (' . $id_ehpds . ')
                ORDER BY
                    knowledge_skill_point,
                    ID_EHPD,
                    ID_EHP';
        $queryResult = BaseQueries::performQuery($sql);

        // wordt niet gebruikt??? -> jawel, in print
        $_SESSION['history_prev_sql'] = $sql;
        $_SESSION['history_prev_id_e'] = $id_e;
        $_SESSION['history_prev_id_ehpd'] = $id_ehpd;



        if ($mode == RATING_FUNCTION_PROFILE) {
            $html .= '<table>
                        <tr>
                            <td><strong>' . TXT_UCF('JOB_PROFILE'). ' :</strong></td>
                            <td>' . $function . '</td>
                        </tr>
                    </table>';
        }


        $html .= '<table width="99%">
                    <tr>
                        <td class="bottom_line ehp_tdbg" width="15%">' . TXT_UCF('TIMESHOT_DATE') . '</td>
                        <td class="bottom_line ehp_tdbg" width="15%">' . TXT_UCF('CONVERSATION_DATE') . '</td>
                        <td class="bottom_line ehp_tdbg" width="25%">' . TXT_UCF('COMPETENCE') . '</td>
                        <td class="bottom_line ehp_tdbg centered" width="7.5%">' . TXT_UCF(CUSTOMER_MGR_SCORE_LABEL) . '</td>
                        <td class="bottom_line ehp_tdbg">' . TXT_UCF('REMARKS') . '</td>
                    </tr>';

        $i = 1;

        $bgcolor = "bgcolor=FFFFFF";

        while ($queryResult_row = @mysql_fetch_assoc($queryResult)) {

            $scale = ModuleUtils::ScorepointTextDescription($queryResult_row['standard_assessment'], $queryResult_row['standard_assessment_description']);//, TXT('NA'));

            $date_display = date("d-m-Y", strtotime($queryResult_row['modified_date']));
            $conversation_date = ($queryResult_row['conversation_date'] != 0) ? date("d-m-Y", strtotime($queryResult_row['conversation_date'])) : '';

            if ($queryResult_row['ID_EHPD'] == $id_ehpd) {
                $html .='
                    <tr>
                        <td class="ehp_bottom_line" ' . $bgcolor . '>&nbsp;' . $date_display . '</td>
                        <td class="ehp_bottom_line" ' . $bgcolor . '>&nbsp;' . $conversation_date . '</td>
                        <td class="ehp_bottom_line" ' . $bgcolor . '><strong>&nbsp;' . $queryResult_row[knowledge_skill_point] . '</strong></td>
                        <td class="ehp_bottom_line centered" ' . $bgcolor . '><strong>&nbsp;' . $scale . '</strong></td>
                        <td class="ehp_bottom_line" ' . $bgcolor . '><strong>&nbsp;' . nl2br($queryResult_row[note]) . '</strong></td>
                    </tr>';

                $result = $i % 2;

                if ($result == 1) {
                    $bgcolor = "bgcolor=cccccc";
                } else {
                    $bgcolor = "bgcolor=FFFFFF";
                }

                $i++;
            } else {
                $html .='
                    <tr>
                        <td class="ehp_bottom_line" ' . $bgcolor . '><font color="#595959">&nbsp;' . $date_display . '</td>
                        <td class="ehp_bottom_line" ' . $bgcolor . '><font color="#595959">&nbsp;' . $conversation_date . '</td>
                        <td class="ehp_bottom_line" ' . $bgcolor . '><font color="#595959">&nbsp;' . $queryResult_row[knowledge_skill_point] . '</td>
                        <td class="ehp_bottom_line centered" ' . $bgcolor . '><font color="#595959">&nbsp;' . $scale . '</td>
                        <td class="ehp_bottom_line" ' . $bgcolor . '><font color="#595959">&nbsp;' . nl2br($queryResult_row[note]) . '</td>
                    </tr>';
            }
        }

        $html .= '<tr>
                        <td colspan="5" align="right">
                            &nbsp;
                        </td>
                    </tr>
                    </table>';

        $objResponse->assign('ehp_window3', 'innerHTML', $html);

        $objResponse->assign('topPrint', 'innerHTML', '
                                <input type="button" class="btn btn_width_80" value="' . TXT_BTN('PRINT') . '"
                                onclick="MM_openBrWindow(\'print/history_prev.php?mode='.$mode.'\',\'\',\'resizable=yes, width=800,height=800\');return false;" />');
    }

    return $objResponse;
}


?>
