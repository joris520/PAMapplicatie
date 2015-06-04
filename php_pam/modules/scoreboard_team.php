<?php

require_once('gino/ImageUtils.class.php');
require_once('modules/common/moduleUtils.class.php');
require_once('modules/common/moduleConsts.inc.php');

require_once('modules/scoreboard_common.class.php');

// services
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceService.class.php');
require_once('modules/model/service/library/AssessmentCycleService.class.php');

// interface objects
require_once('modules/interface/interfaceobjects/report/ScoreboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ScoreboardCompetenceGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ScoreboardView.class.php');

function createSqlForTotalsAndAverage($id_f, $id_e_all)
{
    if (is_array($id_e_all)) {
        $id_e_list = implode($id_e_all,',');
    } else {
        $id_e_list = $id_e_all;
    }

    $sql = 'SELECT
                ks.knowledge_skill as category,
                CASE
                        WHEN ksc.cluster is null
                        THEN "zzz"
                        ELSE ksc.cluster
                END as cluster,
                ksp.knowledge_skill_point as competence,
                ksp.ID_KSP,
                ksp.is_key,
                ksp.is_cluster_main,
                ksp.knowledge_skill_point,
                ksp.scale as ksp_scale,
                fp.scale AS norm,

                count(e.ID_E) as count_ID_E,
                count(ep.ID_E) as emp_with_score_count,
                CASE
                    WHEN (ksp.scale = "' . ScaleValue::SCALE_1_5 . '")
                    THEN sum(ep.scale)
                    ELSE sum(CASE
                                WHEN ep.scale = "Y" THEN 5
                                WHEN ep.scale = "N" THEN 1
                                ELSE 0
                             END)
                END AS total_score,
                CASE
                    WHEN (ksp.scale = "' . ScaleValue::SCALE_1_5 . '")
                    THEN round(sum(ep.scale) / count(ep.ID_E))
                    ELSE round(sum(CASE
                                WHEN ep.scale = "Y" THEN 5
                                WHEN ep.scale = "N" THEN 1
                                ELSE 0
                             END) / count(ep.ID_E))
                END AS avg_score
            FROM
                employees e
                LEFT JOIN function_points fp
                    ON fp.ID_F = ' . $id_f . '
                LEFT JOIN knowledge_skills_points ksp
                    ON ksp.ID_KSP = fp.ID_KSP
                LEFT JOIN knowledge_skill ks
                    ON ks.ID_KS = ksp.ID_KS
                LEFT JOIN knowledge_skill_cluster ksc
                    ON ksc.ID_C = ksp.ID_C
                LEFT JOIN employees_points ep
                    ON ep.ID_KSP = ksp.ID_KSP
                    AND ep.ID_E = e.ID_E
                    AND (ep.scale = "Y" OR ep.scale = "N" OR ep.scale > 0)
            WHERE
                e.ID_E IN (' . $id_e_list . ')
                and e.customer_id = ' . CUSTOMER_ID . '
            GROUP BY
                    ksp.ID_KSP
            ORDER BY
                e.lastname,
                e.firstname,
                ks.knowledge_skill,
                ksc.cluster,
                ksp.is_cluster_main DESC,
                ksp.knowledge_skill_point';
    return $sql;
}

function getTotalsAndAverage($id_f, $id_e_all)
{
    $sql = createSqlForTotalsAndAverage($id_f, $id_e_all);
    $total_scores = MysqlUtils::getData($sql, true);
    for($score_index = 0; $score_index < count($total_scores); $score_index++) {
        if ($total_scores[$score_index]['ksp_scale'] == ScaleValue::SCALE_Y_N) {
            if ($total_scores[$score_index]['avg_score'] > 0) {
                $total_scores[$score_index]['avg_score'] = ($total_scores[$score_index]['avg_score'] > 3) ? 'Y' : 'N';
            }
        }
    }
    return $total_scores;
}

function getEmployeeIdsOnPage($id_e_all, $page, $max_per_page)
{
    $start_offset = ($page-1) * $max_per_page;

    if (is_array($id_e_all)) {
        $id_e_list = array_slice ($id_e_all, $start_offset, $max_per_page, true );
    } else {
        $id_e_list = $id_e_all;
    }
    return $id_e_list;
}

function getInfoForEmployees($id_es_on_page)
{
    if (is_array($id_es_on_page)) {
        $id_e_list = implode($id_es_on_page,',');
    } else {
        $id_e_list = $id_es_on_page;
    }

    $sql = 'SELECT
                e.ID_E,
                e.lastname,
                e.firstname,
                e.employee
            FROM
                employees e
            WHERE
                e.ID_E IN (' . $id_e_list . ')
                AND e.customer_id = ' . CUSTOMER_ID . '
            GROUP BY
                ID_E
            ORDER BY
                e.lastname,
                e.firstname';

    $query_result = BaseQueries::performQuery($sql);
    $employees_on_page = MysqlUtils::result2IndexedArray2D(&$query_result, 'ID_E');
    return $employees_on_page;
}

function getScoreForEmployees($id_f, $id_es_on_page)
{
    $displayWidth       = ApplicationInterfaceBuilder::VIEW_WIDTH;

    $currentPeriod  = AssessmentCycleService::getCurrentValueObject();
    $scoreboardGroup = ScoreBoardGroup::create($displayWidth);
    $competenceObjects = CompetenceService::getValueObjects($id_f);
    $sumScore = array();
    $totalScores = array();
    $averageScores = array();

    foreach($competenceObjects as $competenceObject) {
        $competenceId = $competenceObject->getId();
        $sumScore[$competenceId] = 0;
        $totalScores[$competenceId] = 0;
        $averageScores[$competenceId] = 0;

        $groupInterfaceObject = ScoreboardCompetenceGroup::create($competenceObject, $displayWidth);

        foreach ($id_es_on_page as $id_e) {
            $scoreObject = EmployeeScoreService::getValueObject($id_e, $competenceId, $currentPeriod);
            $score = $scoreObject->score;
            $viewInterfaceObject = ScoreboardView::create(ApplicationInterfaceBuilder::VIEW_WIDTH);
            $viewInterfaceObject->setEmployeeId($id_e);
            $viewInterfaceObject->setScore($score);
            $groupInterfaceObject->addScore($score);
            $groupInterfaceObject->addInterfaceObject($viewInterfaceObject);
        }

        $scoreboardGroup->addInterfaceObject($groupInterfaceObject);
    }

    return $scoreboardGroup;
}

function getPageLinks($current_page, $required_pages, $graph_filename)
{
    $html = TXT_UCF('PAGE') . ': ';
    for ($page_index = 1; $page_index <= $required_pages; $page_index++) {
        if ($page_index == $current_page) {
            $html .= '
            <u>' . $page_index . '</u>&nbsp;&nbsp;';
        } else {
            $html .= '
            <a href="javascript:void(0)" onclick="xajax_moduleScoreboard_calcProcess_team(' . $page_index . ', \''. $graph_filename . '\')">' . $page_index . '</a>&nbsp;&nbsp;';
        }
    }
    return $html;
}

function moduleScoreboard_calcProcess_team($current_page, $graph_filename = null)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {
        // hbd: $id_e_all voor alle gevraagde ID_E, dus over pagina's heen
        $filter_options = $_SESSION['scoreboard_filter_option'];
        $select_mode = $_SESSION['scoreboard_mode_option'];

        $id_f = $_SESSION['scoreboard_selected_function_id'];
        $id_dept = $_SESSION['scoreboard_selected_department_id'];

        // alle employees
        $all_employees = $_SESSION['scoreboard_selected_employee_ids'];
        $required_pages = ceil(count($all_employees) / EMPLOYEES_PER_PAGE);

        // alleen de relevante emps voor deze pagina eruit halen...
        $id_es_on_page = getEmployeeIdsOnPage($all_employees, $current_page, EMPLOYEES_PER_PAGE);
        // todo: check of er employees in zitten!

        $employees_info = getInfoForEmployees($id_es_on_page);
        $scoreboardGroup = getScoreForEmployees($id_f, $id_es_on_page);
        $scoreCount = count($scoreboardGroup->getInterfaceObjects());

        // van de competenties bij de functie de totalen
        // $score_totals = getTotalsAndAverage($id_f, $all_employees);
        $display_title = ScoreboardCommon::getScoreTitle($filter_options, $id_f, $id_dept);

        // doorgeven aan print.. TODO: opruimen
        $_SESSION['print_sb_team_employees_scores'] = serialize($scoreboardGroup);
        $_SESSION['print_sb_team_employees_info']   = $employees_info;


        $html = '
        <table width="100%" style="text-align:left;">
            <tr>
                <td>
                    <div id="page_display">' .
                        getPageLinks($current_page, $required_pages, $graph_filename) . '
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left" width="50%"><strong>' . $display_title . '</strong></td>
                <td align="right" width="50%">
                    <input type="button" class="btn btn_width_80" value="' . TXT_BTN('BACK') . '" id="mainCalcBtn" onclick="xajax_moduleScoreboard_calc(' . SELECTMODE_NEW . ')"/>&nbsp;&nbsp;
                    <input type="button" class="btn btn_width_150" value="' . TXT_BTN('PRINT_SCORE') . '" id="printbtn" onclick="MM_openBrWindow(\'print/rpdf_sb_team.php\',\'\',\'resizable=yes, menubar=yes, width=900,height=830, scrollbars=yes\');return false;"/>
                </td>
            </tr>
            <tr>
                <td colspan="100%">
                    <hr style="background-color:#CCCCCC">
                </td>
            </tr>
        </table>';


        if ($scoreCount > 0) {
            // hergebruik al aangemaakte grafiek
            if (empty($graph_filename)) {
                $graph_filename = time() . '.png';
                $file_exists = false;
            } else {
                $file_exists = file_exists( ModuleUtils::getCustomerTempPath() . $graph_filename);
            }
            if (!$file_exists) {
                $graph_data = array();

                foreach ($scoreboardGroup->getInterfaceObjects() as $scoreboardCompetence) {
                    $numericAverage = $scoreboardCompetence->getNumericAverage();
                    $graph_data[] = array($numericAverage,
                                          ScoreboardCommon::getGridPlacement($scoreboardCompetence->getValueObject()->competenceFunctionNorm),
                                          ScoreboardCommon::getGridPlacement($numericAverage));
                }

                ScoreboardCommon::generateScoreGraph($graph_filename, $graph_data, true);
            }


            $html .= '
            <table class="calcProcTbl"  style="text-align:left;">
                <tr>
                    <td class="bottom_line ehp_tdbg" style="width:220px; min-width:220px; vertical-align:bottom;">' . TXT_UCF('CATEGORY') . '</td>
                    <td class="bottom_line ehp_tdbg" style="width:220px; min-width:220px; vertical-align:bottom;">' . TXT_UCF('CLUSTER') . '</td>
                    <td class="bottom_line ehp_tdbg" style="width:330px; min-width:330px; vertical-align:bottom;">' . TXT_UCF('COMPETENCE') . '</td>';
                    foreach($employees_info as $employee_info) {
                        $html .= '<td class="bottom_line ehp_tdbg left" style="width:80px;"><font size="1">' . $employee_info['firstname'] . '<br>' . $employee_info['lastname'] . '</font></td>';
                    }
                    $html .= '
                    <td class="" >&nbsp;</td>
                    <td class="bottom_line standard_tbl3 centered" style="width:30px;font-size:smaller">' . 'Team' . '</td>
                    <td class="" >&nbsp;</td>
                    <td class="bottom_line standard_tbl3 centered" style="width:30px;font-size:smaller">' . TXT_UCF('NORM') . '</td>
                    <td class="" >&nbsp;</td>
                    <td class="bottom_line centered" style="text-align:left; vertical-align:bottom; style="width:100px;">1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5&nbsp;</td>
                </tr>';

            // Hier per competentie een regel toevoegen met de scores per emp en team
            $competence_next_prefix = '';
            $show_graph = true;
            foreach ($scoreboardGroup->getInterfaceObjects() as $scoreboardCompetence) {

                $competenceValueObject = $scoreboardCompetence->getValueObject();

                $prev_category   = $category;
                $prev_cluster    = $cluster;

                $category        = $competenceValueObject->categoryName;
                $cluster         = $competenceValueObject->clusterName;
                $competence      = $competenceValueObject->competenceName;
                $is_cluster_main = $competenceValueObject->competenceIsMain;
                $norm            = $competenceValueObject->competenceFunctionNorm;
                $avg_score       = $scoreboardCompetence->getScoreAverage();

                list($avg_bgcolor, $avg_font_color) = ScoreboardCommon::getGridCellColor($avg_score, $norm, $is_cluster_main);
                $avg_score_label = ModuleUtils::ScorepointLetter($avg_score);
                $norm_label = ModuleUtils::ScoreNormLetter($norm);
                $norm_bg_color = $is_cluster_main == 1 ? COLOUR_LIGHT_GRAY : COLOUR_WHITE;

                $category_label = ($category != $prev_category) ? CategoryConverter::display($category) : '&nbsp;';
                $competence_label = ($competence == '') ? '&nbsp;' : ModuleUtils::Abbreviate($competence, 40);
                if ($cluster != $prev_cluster) {
                    $cluster_label = (trim($cluster) == '') ? '&nbsp;' : ModuleUtils::Abbreviate($cluster, 30);
                    $competence_prefix = '';
                    $competence_next_prefix = '';
                } else {
                    $cluster_label = '&nbsp;';
                    $competence_prefix = $competence_next_prefix;
                }

                if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE && $is_cluster_main == 1) {
                    $competence_next_prefix = KSP_INDENT;
                }

                $competence_class = $is_cluster_main == 1 ? ' main_competence' : '';

                $html .= '
                <tr>
                    <td class="ehp_bottom_line standard_tbl">' . $category_label . '</td>
                    <td class="ehp_bottom_line standard_tbl' . $competence_class . '">' . $cluster_label . '</td>
                    <td class="ehp_bottom_line standard_tbl' . $competence_class . '">' . $competence_prefix . $competence_label . '</td>';
                    // hier per employee de score toevoegen
                    foreach ($scoreboardCompetence->getInterfaceObjects() as $scoreboardView) {
                        $employeeScore = $scoreboardView->getScore();

                        list($bgcolor, $font_color) = ScoreboardCommon::getGridCellColor($employeeScore, $norm, $is_cluster_main);
                        $score_label = ModuleUtils::ScorepointLetter($employeeScore);
                        $html .= '<td class="ehp_bottom_line standard_tbl centered' . $competence_class . '" style="color:' . $font_color . '; background-color:' . $bgcolor . ';">' . $score_label . '</td>';
                    }
                    $html2 = '
                        <td class="" >&nbsp;</td>
                        <td class="ehp_bottom_line standard_tbl centered" style="background-color:'. $avg_bgcolor .'; color:'. $avg_font_color.';">' . $avg_score_label . '</td>
                        <td >&nbsp;</td>
                        <td class="ehp_bottom_line standard_tbl centered" style="background-color:' . $norm_bg_color .';">' . $norm_label . '</td>
                        <td >&nbsp;</td>';
                    $html3 = '';
                    if ($show_graph) {
                        $html3 .= '<td rowspan="' . $scoreCount . '">
                                        <img src="' . ModuleUtils::getCustomerTempUrl() . $graph_filename . '"/>
                                    </td>';
                        $show_graph = false;
                    }
                    $html .= $html2 . $html3 . '
                </tr>';
            }

            $html .= '
            </table>';

            // legenda
            $html .= '
            <table width="100%">
                <tr style="align: right;">
                    <td>&nbsp;</td>
                    <td>' . ScoreboardCommon::getLegendaHtml() . '</td>
                </tr>
            </table>
            <br />';

        } else {
            $html .= '<p><strong>' . TXT_UCF('NO_COMPETENCE_RETURN') . '</strong></p>';
        }
        $objResponse->assign('sb_window1', 'innerHTML', $html);
        $objResponse->assign("subCalcBtn", "disabled", false);
    }

    return $objResponse;
}

?>