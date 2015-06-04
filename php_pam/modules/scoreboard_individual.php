<?php

require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');
require_once('modules/common/moduleUtils.class.php');
require_once('gino/ImageUtils.class.php');

require_once('modules/scoreboard_common.class.php');

// services
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceService.class.php');
require_once('modules/model/service/library/AssessmentCycleService.class.php');

// interface objects
require_once('modules/interface/interfaceobjects/report/ScoreboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ScoreboardCompetenceGroup.class.php');

function moduleScoreboard_calcProcess_individual()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) &&
        PermissionsService::isViewAllowed(PERMISSION_SCOREBOARD)) {

        $select_mode = $_SESSION['scoreboard_mode_option'];
        $filter_options = $_SESSION['scoreboard_filter_option'];
        // Er is hier altijd 1 functie en 1 medewerker gekozen
        $id_f = $_SESSION['scoreboard_selected_function_id'];
//        $function_name = $_SESSION['scoreboard_selected_function_name'];
        $id_dept = $_SESSION['scoreboard_selected_department_id'];
//        $department_name = $_SESSION['scoreboard_selected_department_name'];
        $id_e = $_SESSION['scoreboard_selected_employee_ids'][0];

        // TODO: check dat functie en department de juiste zijn
        $emps = new EmployeesQueries();
        $employee_info_qry = $emps->getEmployeesBasedOnUserLevel(null, $id_e);

        $employee_info = @mysql_fetch_assoc($employee_info_qry);
        $employee_name = $employee_info['employee'];
        $department_name = $employee_info['department'];
        $function_name = $employee_info['function'];

        $display_title = ScoreboardCommon::getScoreTitle($filter_options, $id_f, $id_dept);
        $html .= '
        <table width="100%">
            <tr>
                <td align="left" width="50%"><br /><strong>' . $display_title . '</strong></td>
                <td align="right" width="50%">
                    <input type="button" class="btn btn_width_80"  value="' . TXT_BTN('BACK') . '" id="mainCalcBtn" onclick="xajax_moduleScoreboard_calc(' . SELECTMODE_ADD . ')"/>&nbsp;&nbsp;
                    <input type="button" class="btn btn_width_150" value="' . TXT_BTN('PRINT_SCORE') . '" id="printbtn" onclick="MM_openBrWindow(\'print/rpdf_scoreboard.php\',\'\',\'resizable=yes, width=800,height=800\');return false;"/>
                </td>
            </tr>
            <tr>
                <td colspan="100%">
                    <hr style="background-color:#CCCCCC">
                </td>
            </tr>
        </table>';

        $html .= '
        <table width="80%"  style="text-align:left;"  class="calcProcTbl">
            <tr>
                <td>
                    <strong>' . TXT_UCF('EMPLOYEE_NAME') . ':&nbsp;' . $employee_name . '</strong><br />
                    <strong>' . TXT_UCF('DEPARTMENT') . ':&nbsp;' . $department_name . '</strong><br />
                    <strong>' . TXT_UCF('JOB_PROFILE') . ':&nbsp;' . $function_name . '</strong><br /><br />
                </td>
            </tr>
        </table>';

        $displayWidth       = ApplicationInterfaceBuilder::VIEW_WIDTH;
        $currentPeriod      = AssessmentCycleService::getCurrentValueObject();
        $scoreboardGroup    = ScoreBoardGroup::create($displayWidth);
        $competenceObjects  = EmployeeCompetenceService::getValueObjects($id_e, $id_f);

        if (count($competenceObjects) > 0) {
            $graph_data = array();
            foreach($competenceObjects as $competenceObject) {

                $scoreObject = EmployeeScoreService::getValueObject($id_e,
                                                                    $competenceObject->getCompetenceId(),
                                                                    $currentPeriod);
                $score = $scoreObject->getScore();
                $groupInterfaceObject = ScoreboardCompetenceGroup::create($competenceObject, $displayWidth);
                $groupInterfaceObject->setScore($score);
                $scoreboardGroup->addInterfaceObject($groupInterfaceObject);

                $graph_data[] = array($score,
                                      ScoreboardCommon::getGridPlacement($competenceObject->competenceFunctionNorm),
                                      ScoreboardCommon::getGridPlacement($score));
            }

            $_SESSION['print_sb_individual_employee_scores'] = serialize($scoreboardGroup);

            $filename = time() . '.png'; // TODO: controle of deze al bestaat??
            ScoreboardCommon::generateScoreGraph($filename, $graph_data, true);

            //$queryString = 'options=' . $filter_options . '&id_e=' . $id_e . '&id_f=' . $id_f . '&id_dept=' . $id_dept;
            $html .= '
            <table style="text-align:left;" cellspacing="0" class="calcProcTbl">
                <tr>
                    <td class="bottom_line standard_tbl ehp_tdbg" style="padding-left: 10px;width:220px; min-width:220px;">' . TXT_UCF('CATEGORY') . '</td>
                    <td class="bottom_line standard_tbl ehp_tdbg" style="width:220px; min-width:220px;">' . TXT_UCF('CLUSTER') . '</td>
                    <td class="bottom_line standard_tbl ehp_tdbg" style="width:330px; min-width:330px;">' . TXT_UCF('COMPETENCE') . '</td>
                    <td class="bottom_line standard_tbl ehp_tdbg centered" style="width:80px;">' . TXT_UCF('SCORE') . '</td>
                    <td class="bottom_line standard_tbl ehp_tdbg centered" style="width:80px;">' . TXT_UCF('NORM') . '</td>
                    <td class="bottom_line standard_tbl" align="left" style="width:100px;">&nbsp;1&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;2&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;3&nbsp;&nbsp;&nbsp;&nbsp;4&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;5&nbsp;</td>
                </tr>';


                //$prev_category = null;
                //$prev_cluster = null;
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
                    $score           = $scoreboardCompetence->getScore();

                    $category_label = ($category != $prev_category) ? CategoryConverter::display($category) : '&nbsp;';
                    $score_label = ModuleUtils::ScorepointLetter($score);
                    $norm_label = ModuleUtils::ScoreNormLetter($norm);
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
                    list($bgcolor, $font_color) = ScoreboardCommon::getGridCellColor($score, $norm, $is_cluster_main);

                    $comp_class = $is_cluster_main == 1 ? ' main_competence' : '';
                    $bg_norm_color = $is_cluster_main == 1 ? COLOUR_LIGHT_GRAY : COLOUR_WHITE;

                    $html .= '
                    <tr>
                        <td class="ehp_bottom_line standard_tbl center_align">' . $category_label . '</td>
                        <td class="ehp_bottom_line standard_tbl center_align' . $comp_class . '">' . $cluster_label . '</td>
                        <td class="ehp_bottom_line standard_tbl center_align' . $comp_class . '">' . $competence_prefix . $competence_label . '</td>
                        <td class="ehp_bottom_line standard_tbl center_align centered ' . $comp_class . '" style="background-color:' . $bgcolor . ';color:' . $font_color . ';">' . $score_label . '</td>
                        <td class="ehp_bottom_line standard_tbl center_align centered ' . $comp_class . '" bgcolor="' . $bg_norm_color . '">' . $norm_label . '</td>';
                    if ($show_graph) {
                        $html .= '<td rowspan="' . count($competenceObjects) . '">
                                        &nbsp;<img src="' . ModuleUtils::getCustomerTempUrl() . $filename . '"/>
                                    </td>';
                        $show_graph = false;
                    }
                    $html .= '
                    </tr>';
                }
//TODO: tabel goed inrichten....dit schreeuwt om een template
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
                $html .= '<p><strong>' . TXT_UCF('NO_COMPETENCE_RETURN') . '</strong></p><br />';
            }

            $html .= '
            </div><!-- divwindow2 -->';

            $objResponse->assign('sb_window1', 'innerHTML', $html);
    }
    return $objResponse;
}


?>