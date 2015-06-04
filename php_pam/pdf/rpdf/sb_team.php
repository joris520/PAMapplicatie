<?php

require_once('application/interface/ApplicationInterfaceBuilder.class.php');

// services
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceService.class.php');
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/library/CompetenceService.class.php');

// interface objects
require_once('modules/interface/interfaceobjects/report/ScoreboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ScoreboardCompetenceGroup.class.php');
require_once('modules/interface/interfaceobjects/report/ScoreboardView.class.php');

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/pdfConsts.inc.php');
require_once('pdf/objects/common/pdfUtils.inc.php');
require_once('pdf/objects/common/graphUtils.inc.php');
require_once('pdf/objects/rpdf/print_sb_team_table.php');
require_once('plot/phplot/phplot.php');
require_once('modules/scoreboard_common.class.php');

$scoreboardGroup = unserialize($_SESSION['print_sb_team_employees_scores']);
$scoreCount      = count($scoreboardGroup->getInterfaceObjects());
$employees_info  = $_SESSION['print_sb_team_employees_info'];

$pdf = new PdfScoreboardTeamTable($set_max_scores_on_page = 17);

// hbd: todo aanpassen titel
$title     = $_SESSION['print_sb_team_title'];
$subtitle1 = $_SESSION['print_sb_team_subtitle_fun'];
$subtitle2 = $_SESSION['print_sb_team_subtitle_dep'];

$subtitle1  = empty($subtitle1) ? '' : ucfirst($subtitle1);
$subtitle2  = empty($subtitle2) ? '' : TXT_UCF('DEPARTMENT') . ': ' . ucfirst($subtitle2);

 $pdf->PageHeaderData(array( array('', '            ' . $subtitle1),
                             array('', '            ' . $subtitle2 ),
                             array('', '            ' . TXT_UCF('DATE') . ': '. date('d-m-Y', time()))));

$pdf->PageTitle('          ' . $title);

$pdf->Open();

// vastleggen verschuivingen
$const_vertical_offset = 15; // afstand vanaf bovenkant pagina
$const_value_margin = 6; // breedte van een score/norm element
$const_employee_position = 148.5;
$const_box_vertical_offset = 34;
$const_text_vertical_offset = 37.5;
$const_box_side = 4.5;
$employee_name_box_length = 33;
$const_norm_offset = 18;
$const_team_offset = 18;
$const_graph_offset = 24;

    function newPage($pdf, $employees_info) {
        $pdf->SetFont('Arial', '', 8);
        $pdf->AddPage($orientation = 'L');
        return drawHeader($pdf, $employees_info);
    }

    function drawHeader($pdf, $employees_info)
    {
        global $const_vertical_offset;
        global $const_value_margin;
        global $const_employee_position;
        global $const_norm_offset;
        global $const_team_offset;
        global $const_box_vertical_offset;
        global $const_text_vertical_offset;
        global $const_box_side;
        global $employee_name_box_length;

        $fill_mode = 'FD';

        $counter = 151.85;

        $pdf->Ln(-10);

        $pdf->setFillColorHex(COLOR_LIGHTGRAY);

        $pdf->Rect(9, $const_box_vertical_offset + $const_vertical_offset, 24.5, $const_box_side, $fill_mode);
        $pdf->Text(10, $const_text_vertical_offset + $const_vertical_offset, TXT_UCF('CATEGORY')); // 43

        $pdf->Rect(34.5, $const_box_vertical_offset + $const_vertical_offset, 45, $const_box_side, $fill_mode);
        $pdf->Text(36, $const_text_vertical_offset + $const_vertical_offset, TXT_UCF('CLUSTER')); // 44

        $pdf->Rect(80.5, $const_box_vertical_offset + $const_vertical_offset, 66, $const_box_side, $fill_mode);
        $pdf->Text(81, $const_text_vertical_offset + $const_vertical_offset, TXT_UCF('COMPETENCE')); // 44

        // employees vullen
        $move_right = $const_employee_position;
        $fill_mode_emp = 'D';

        foreach ($employees_info as $employee_info) {
            $emp = $employee_info['employee'];
            $pdf->Rect($move_right,  ($const_vertical_offset + $employee_name_box_length - 42.5), $const_box_side, $const_vertical_offset + $employee_name_box_length, $fill_mode_emp);

            $capitalize = ucwords($emp);
            $pdf->TextWithDirection($counter, $const_text_vertical_offset + $const_vertical_offset, $capitalize, 'U');
            $counter = $counter + $const_value_margin;
            $move_right = $move_right + $const_value_margin;
        }

        // norm
        $pdf->Rect($move_right, $const_box_vertical_offset + $const_vertical_offset, 17, $const_box_side, $fill_mode);
        $pdf->Text($move_right + 3.5, $const_text_vertical_offset + $const_vertical_offset, 'Team');
        $move_right += $const_norm_offset;
        // team
        $pdf->Rect($move_right, $const_box_vertical_offset + $const_vertical_offset, 17, $const_box_side, $fill_mode);
        $pdf->Text($move_right + 3.5, $const_text_vertical_offset + $const_vertical_offset, 'Norm');
        $move_right += $const_team_offset;


        $pdf->Ln(36);

        return $move_right;
    } // new page

    function drawGraph($pdf, $graph_data, $filename_offset, $graph_offset_hori)
    {
        global $const_vertical_offset;
        global $const_graph_offset;
        global $const_box_vertical_offset;
        global $const_text_vertical_offset;
        global $const_box_side;

        $graph_location_verti = $const_box_vertical_offset + $const_vertical_offset + $const_box_side;//$const_vertical_offset + $pdf->GetDataHeaderOffsetY() ;
        GraphUtils::DrawPdfGraph($pdf, $graph_data, $filename_offset, $graph_location_verti, $graph_offset_hori + $const_graph_offset + 3, true);//, $area_length, $area_width);

        // graph header
        $fill_mode = FILLMODE_BORDER_FILL;
        $pdf->setFillColorHex(COLOR_LIGHTGRAY);
        $pdf->Rect($graph_offset_hori, $const_box_vertical_offset + $const_vertical_offset, 28, $const_box_side, $fill_mode);
        $pdf->Text($graph_offset_hori + 1.5, $const_text_vertical_offset + $const_vertical_offset, '1     2     3     4     5');
        // legenda
        GraphUtils::addScoreLegenda($pdf, 210 , 185.4, 235, 175);
    }

    function drawCompetence($pdf, $row, $category, $cluster, $competence, $team_score, $team_bg_color, $team_fg_color, $norm, $norm_bg_color, $scoreboardViews)
    {
        global $const_vertical_offset;
        global $const_value_margin;
        global $const_employee_position;
        global $const_team_offset;
        global $const_graph_offset;
        global $const_box_vertical_offset;
        global $const_text_vertical_offset;
        global $const_box_side;

        $vertical_offset = $const_vertical_offset + ($row * $const_value_margin);
        $fill_mode = FILLMODE_BORDER_FILL;

        $counter = $const_employee_position;//151.85;

        $pdf->Ln(-10);
        $pdf->SetTextColorHex(COLOR_BLACK);
        $pdf->setFillColorHex($norm_bg_color);

        $pdf->Rect(9, $const_box_vertical_offset + $vertical_offset, 24.5, $const_box_side, $fill_mode);
        $pdf->Text(10, $const_text_vertical_offset + $vertical_offset, $category); // 43

        $pdf->Rect(34.5, $const_box_vertical_offset + $vertical_offset, 45, $const_box_side, $fill_mode);
        $pdf->Text(36, $const_text_vertical_offset + $vertical_offset, $cluster); // 44

        $pdf->Rect(80.5, $const_box_vertical_offset + $vertical_offset, 66, $const_box_side, $fill_mode);
        $pdf->Text(81, $const_text_vertical_offset + $vertical_offset, $competence); // 44

        // employees vullen
        $move_right = $const_employee_position;
        $fill_mode_emp = FILLMODE_BORDER_FILL;

        foreach ($scoreboardViews as $scoreboardView) {

            $score_bg_color = $scoreboardView->emp_score_bg_color;
            $score_fg_color = $scoreboardView->emp_score_fg_color;
            $pdf->setFillColorHex($score_bg_color);
            $pdf->SetTextColorHex($score_fg_color);

            $score = $scoreboardView->emp_score_label;

            $pdf->Rect($move_right, $const_box_vertical_offset + $vertical_offset, $const_box_side, $const_box_side, $fill_mode_emp);

            $pdf->Text($counter + 1.25, $const_text_vertical_offset + $vertical_offset, $score);
            $counter = $counter + $const_value_margin;
            $move_right = $move_right + $const_value_margin;
        }

        // team
        $pdf->setFillColorHex($team_bg_color);
        $pdf->SetTextColorHex($team_fg_color);
        $pdf->Rect($move_right, $const_box_vertical_offset + $vertical_offset, 17, $const_box_side, $fill_mode);
        $pdf->Text($move_right + 7, $const_text_vertical_offset + $vertical_offset, $team_score);

        // norm
        $move_right += $const_team_offset;
        $pdf->setFillColorHex($norm_bg_color);
        $pdf->SetTextColorHex(COLOR_BLACK);

        $pdf->Rect($move_right, $const_box_vertical_offset + $vertical_offset, 17, $const_box_side, $fill_mode);
        $pdf->Text($move_right + 7, $const_text_vertical_offset + $vertical_offset, $norm);

        // graph header
        $move_right += $const_graph_offset;

    } // draw competence

    $graph_offset_hori = NewPage($pdf, $employees_info);

    $category = '';
    $cluster = '';
    $graph_data = array();
    $competence_next_prefix = '';

    $total_records = 1;
    $scores_on_page = 1;

    foreach ($scoreboardGroup->getInterfaceObjects() as $scoreboardCompetence) {

        $competenceValueObject = $scoreboardCompetence->getValueObject();

        $prev_category = $category;
        $prev_cluster  = $cluster;

        $category = $competenceValueObject->categoryName;
        $cluster =  $competenceValueObject->clusterName;
        $competence = $competenceValueObject->competenceName;
        $is_cluster_main = $competenceValueObject->competenceIsMain;
        $norm = $competenceValueObject->competenceFunctionNorm;
        $team_score = $scoreboardCompetence->getScoreAverage();

        list($avg_bgcolor, $avg_font_color) = ScoreboardCommon::getGridCellColor($team_score, $norm, $is_cluster_main);
        $team_score_label = ModuleUtils::ScorepointLetter($team_score);
        $norm_label = ModuleUtils::ScoreNormLetter($norm);
        $norm_bg_color = $is_cluster_main == 1 ? COLOUR_LIGHT_GRAY : COLOUR_WHITE;

        $category_label = ($category != $prev_category) ? CategoryConverter::display($category) : '';
        $competence_label = ($competence == '') ? '' : ModuleUtils::Abbreviate($competence, 40);
        if ($cluster != $prev_cluster) {
            $cluster_label = (trim($cluster) == '') ? '' : ModuleUtils::Abbreviate($cluster, 30);
            $competence_prefix = '';
            $competence_next_prefix = '   ';
        } else {
            $cluster_label = '';
            $competence_prefix = $competence_next_prefix;
        }

        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE && $is_cluster_main == 1) {
            $competence_next_prefix = KSP_INDENT;
        }

        $scoreboardViews = array();
        foreach ($scoreboardCompetence->getInterfaceObjects() as $scoreboardView) {
            $employeeScore = $scoreboardView->getScore();
            $emp_score_label = ModuleUtils::ScorepointLetter($employeeScore);
            list($emp_score_bg_color, $emp_score_fg_color) = ScoreboardCommon::getGridCellColor($employeeScore, $norm, $is_cluster_main);
            $scoreboardView->emp_score_label = '' . $emp_score_label;
            $scoreboardView->emp_score_bg_color = $emp_score_bg_color;
            $scoreboardView->emp_score_fg_color = $emp_score_fg_color;
            $scoreboardViews[] = $scoreboardView;
        }

        drawCompetence($pdf, $scores_on_page, $category_label, $cluster_label, $competence_label, $team_score_label, $avg_bgcolor, $avg_font_color, $norm_label, $norm_bg_color, $scoreboardViews);

        $score_grid = GraphUtils::EvalScoreToGraphValue($team_score, $norm);
        $norm_grid = GraphUtils::EvalNormToGraphValue($norm);
        $graph_data[] = array($team_score, $norm_grid, $score_grid);
        if ($scores_on_page % $pdf->MaxScoresOnPage() == 0) {
            drawGraph($pdf, $graph_data, $total_records, $graph_offset_hori);
            $graph_data = array();
            $graph_offset_hori = NewPage($pdf, $employees_info);
            $scores_on_page = 0;
            $category = '';
            $cluster = '';
        }

        $scores_on_page++;
        $total_records++;
    } // while


    if ($scores_on_page > 0) {
        drawGraph($pdf, $graph_data, $total_records, $graph_offset_hori);
    }

$pdf->Output();

?>
