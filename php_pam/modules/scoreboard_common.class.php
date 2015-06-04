<?php

require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');
require_once('modules/common/moduleUtils.class.php');
require_once('gino/ImageUtils.class.php');

define('FILTER_OWN_PROFILE', 0);
define('FILTER_EMPLOYEE_ANY_JOB_PROFILE', 1);
define('FILTER_JOB_PROFILE', 2);
define('FILTER_DEPARTMENT_JOB_PROFILE', 3);

define('EMPLOYEES_PER_PAGE', 10);

class ScoreboardCommon {

    static function getCompetencesForFunctionAndScoresForEmployee($i_function_id, $i_employee_id)
    {
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
                    ksp.scale as ksp_scale,
                    fp.scale as norm,
                    fp.id_fp,
                    ep.scale as emp_score
                FROM
                    knowledge_skill ks
                    INNER JOIN knowledge_skills_points ksp
                        ON ks.ID_KS = ksp.ID_KS
                    INNER JOIN function_points fp
                        ON fp.ID_KSP = ksp.ID_KSP
                            AND fp.ID_F = ' . $i_function_id . '
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                    LEFT JOIN employees_points ep
                        ON ep.ID_KSP = ksp.ID_KSP
                            AND ep.ID_E = ' . $i_employee_id . '
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    ksp.id_ksp
                ORDER BY
                    category,
                    cluster,
                    ksp.is_cluster_main DESC,
                    competence';
        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }


    static function getGridPlacement($value)
    {
        $value_grid = 0;
        switch ($value) {
            case 1:
            case 'N':
                $value_grid = 0;
                break;
            case 2:
                $value_grid = 250;
                break;
            case 3:
                $value_grid = 500;
                break;
            case 4:
                $value_grid = 750;
                break;
            case 'Y':
            case 5:
                $value_grid = 1000;
                break;
        }
        return $value_grid;
    }

    static function getGridCellColor($score, $norm, $is_cluster_main)
    {
        if (!$score == '') {
            if (is_numeric(trim($norm))) { // 1-5
                $result = $norm - $score;
                switch ($result) {
                    case 0:
                        $bgcolor = COLOUR_GREEN;
                        $font_color = COLOUR_BLACK;
                        break;
                    case 1:
                        $bgcolor = COLOUR_LIGHT_BLUE;
                        $font_color = COLOUR_WHITE;//COLOUR_BLACK;
                        break;
                    case 2:
                        $bgcolor = COLOUR_DARK_BLUE;
                        $font_color = COLOUR_WHITE;
                        break;
                    case 3:
                        $bgcolor = COLOUR_RED;
                        $font_color = COLOUR_WHITE;
                        break;
                    case 4:
                        $bgcolor = COLOUR_RED;
                        $font_color = COLOUR_WHITE;
                        break;
                }



                if ($norm == 3 && $score == 1) {
                    $bgcolor = COLOUR_RED;
                    $font_color = COLOUR_WHITE;
                }

                if ($result < 0) {
                    $bgcolor = COLOUR_YELLOW;
                    $font_color = COLOUR_BLACK;
                }
            } else { // Y/N
                if (trim($norm) == trim($score)) { // op norm
                    $bgcolor = COLOUR_GREEN;
                    $font_color = COLOUR_WHITE;//COLOUR_BLACK;

                } else if (trim($norm) == 'N' && trim($score) == 'Y' ) { // above norm
                    $bgcolor = COLOUR_YELLOW;
                    $font_color = COLOUR_BLACK;
                } else { // onder norm
                    $bgcolor = COLOUR_RED;
                    $font_color = COLOUR_WHITE;
                }
            }
        } else {
            $bgcolor = $is_cluster_main == 1 ? COLOUR_LIGHT_GRAY : COLOUR_WHITE;
            $font_color = COLOUR_BLACK;
        }
        return array($bgcolor, $font_color);
    }

    static function generateScoreGraph($filename, $data, $b_is_team)
    {
        $full_filename = ModuleUtils::getCustomerTempPath() . $filename;
        $spacer = $b_is_team ? 21.85 : 22.9;

        $area_width = $b_is_team ? 105 : 155;
        $area_length = $spacer * (count($data));

        $space_width = $b_is_team ? 100 : 150;
        $space_length = $spacer * (count($data));

        /* andere team waarden??
        *                         $spacer = 16.75;

                            $area_length = $spacer * ($count_ks);
                            $area_width = 65;

                            $space_length = $spacer * ($count_ks);
                            $space_width = 60;

        */

        $plot = new PHPlot($area_length, $area_width);
        $plot->SetImageBorderType('plain');
        $plot->SetPlotAreaPixels(0, 3, $space_length, $space_width);
        $plot->SetDataType('text-data');
        $plot->SetDataValues($data);
        $plot->SetPlotAreaWorld(NULL, 0, NULL, 1000);
        $plot->SetXDataLabelPos('none');
        $plot->SetYTickPos('none');
        $plot->SetYTickLabelPos('none');
        $plot->SetXTickPos('none');
        $plot->SetXTickLabelPos('none');
        $plot->SetDataColors(array(COLOUR_GRAY, COLOUR_BLACK));
        $plot->SetYTickIncrement(250);
        $plot->SetPlotType('linepoints');
        $plot->SetImageBorderColor(COLOUR_WHITE);
        $plot->SetGridColor(COLOUR_GRAY);
        $plot->SetPlotBorderType('none');
        $plot->SetIsInline(true);
        $plot->SetOutputfile($full_filename);
        $plot->DrawGraph();

        ImageUtils::rotateImageFile($full_filename, $full_filename, 270);
    }


    // hbd, todo: betere html
    static function getLegendaHtml()
    {
        $html = '<table width="100%">
                    <tr>
                        <td align="right">
                            <table>
                                <tr>
                                    <td>
                                        <img src="images/lines_label.png"/>
                                    </td>
                                    <td>
                                        <table>
                                            <tr>
                                                <td colspan="2" style="text-align:left;"><font size="1">' . TXT_UCF('COLOUR_SCALE') . ':</font></td>
                                            </tr>

                                            <tr bgcolor="' . COLOUR_RED . '">
                                                <td align="right"><font color="white" size="1">' . TXT_UCF('COLOUR_SCALE_RED') . '</font></td>
                                                <td align="left"><font color="white" size="1">' . TXT_UCF('SCALE_3_BELOW_NORM') . '</font></td>
                                            </tr>
                                            <tr bgcolor="' . COLOUR_DARK_BLUE . '">
                                                <td align="right"><font color="white" size="1">' . TXT_UCF('COLOUR_SCALE_DARK_BLUE') . '</font></td>
                                                <td align="left"><font color="white" size="1">' . TXT_UCF('SCALE_2_BELOW_NORM') . '</font></td>
                                            </tr>
                                            <tr  bgcolor="' . COLOUR_LIGHT_BLUE . '">
                                                <td align="right"><font size="1" color="white">' . TXT_UCF('COLOUR_SCALE_LIGHT_BLUE') . '</font></td>
                                                <td align="left"><font size="1" color="white">' . TXT_UCF('SCALE_1_BELOW_NORM') . '</font></td>
                                            </tr>
                                            <tr bgcolor="' . COLOUR_GREEN . '">
                                                <td align="right"><font size="1">' . TXT_UCF('COLOUR_SCALE_GREEN') . '</font></td>
                                                <td align="left"><font size="1">' . TXT_UCF('SCALE_ON_NORM') . '</font></td>
                                            </tr>
                                            <tr bgcolor="' . COLOUR_YELLOW . '">
                                                <td align="right"><font size="1">' . TXT_UCF('COLOUR_SCALE_YELLOW') . '</font></td>
                                                <td align="left"><font size="1">' . TXT_UCF('SCALE_ABOVE_NORM') . '</font></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                    <!--table>
                                            <tr><td colspan="2"><font size="1">' . TXT_UCF('SCALE') . ':</td></tr>
                                            <tr><td><font size="1">1</font></td><td><font size="1">' . SCALE_NONE . '</font></td></tr>
                                            <tr><td><font size="1">2</font></td><td><font size="1">' . SCALE_BASIC . '</font></td></tr>
                                            <tr><td><font size="1">3</font></td><td><font size="1">' . SCALE_AVERAGE . '</font></td></tr>
                                            <tr><td><font size="1">4</font></td><td><font size="1">' . SCALE_GOOD . '</font></td></tr>
                                            <tr><td><font size="1">5</font></td><td><font size="1">' . SCALE_SPECIALIST . '</font></td></tr>
                                    </table -->
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>';
        return $html;
    }

    static function showOnPage($page_e_array, $id_e)
    {
        $show_on_page=false;
        foreach($page_e_array as $id_e_on_page) {
            if ($id_e_on_page == $id_e) {
                $show_on_page=true;
                break;
            }
        }
        return true;//$show_on_page;
    }

    static function getDepartmentName($department_id)
    {
        $d = new DepartmentQueriesDeprecated();
        $result = $d->getDepartmentsBasedOnUserLevel(null, null, null,$department_id, null, null);
        $department_info = @mysql_fetch_assoc($result);
        return $department_info['department'];
    }

    static function getFunctionName($function_id)
    {
        $result = FunctionQueriesDeprecated::getFunction($function_id);
        $function_info = @mysql_fetch_assoc($result);
        return $function_info['function'];
    }

    static function getScoreTitle($filter_options, $function_id, $department_id)
    {
            $function_name = ScoreboardCommon::getFunctionName($function_id);
            $department_name = ScoreboardCommon::getDepartmentName($department_id);
            $display_title = '';
            $subtitle_dep = '';
            switch ($filter_options) {
                case FILTER_OWN_PROFILE:
                    $title = TXT_UCF('SCORE_EMPLOYEE_IN_OWN_JOB_PROFILE');
                    $subtitle_fun = $function_name;
                    $display_title = $title . ': ' . $subtitle_fun;
                    break;
                case FILTER_EMPLOYEE_ANY_JOB_PROFILE:
                    $title = TXT_UCF('EMPLOYEE_IN_JOB_PROFILE');
                    $subtitle_fun = $function_name;
                    $display_title = $title . ': ' . $subtitle_fun;
                    break;
                case FILTER_JOB_PROFILE:
                    $title = TXT_UCF('JOB_PROFILE');
                    $subtitle_fun = $function_name;
                    $display_title = $title . ': ' . $subtitle_fun;
                    break;
                case FILTER_DEPARTMENT_JOB_PROFILE:
                    $title = TXT_UCF('JOB_PROFILE');
                    $subtitle_fun = $function_name;
                    $subtitle_dep = $department_name;
                    $display_title = $title . ': ' . $subtitle_fun . ', ' . TXT_UCF('DEPARTMENT') . ' '. $subtitle_dep;
                    break;
            }
            $_SESSION['print_sb_team_title'] = $title;
            $_SESSION['print_sb_team_subtitle_fun'] = $subtitle_fun;
            $_SESSION['print_sb_team_subtitle_dep'] = $subtitle_dep;
            return $display_title;
    }

} // class
?>