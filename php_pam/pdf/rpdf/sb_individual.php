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
require_once('pdf/objects/rpdf/print_scoreboard_table.php');
require_once('pdf/objects/common/graphUtils.inc.php');
require_once('modules/scoreboard_common.class.php');
require_once('modules/model/queries/to_refactor/FunctionQueriesDeprecated.class.php');

// Er is hier altijd 1 functie en 1 medewerker gekozen
$id_e            = $_SESSION['scoreboard_selected_employee_ids'][0];
$id_f            = $_SESSION['scoreboard_selected_function_id'];
$scoreboardGroup = unserialize($_SESSION['print_sb_individual_employee_scores']);

$function_info_qry = FunctionQueriesDeprecated::getFunction($id_f);
$function_info     = @mysql_fetch_assoc($function_info_qry);
$function_name     = $function_info['function'];

$graph_offset_hori = 186.5;

// TODO: object van maken....

    function NewPage($pdf)
    {
        $pdf->AddPage($orientation = 'L');
        $pdf->ln(5); // hbd: extra ruimte in de tekst nodig om het plaatje goed onder de header neer te zetten
        GraphUtils::addScoreLegenda($pdf, 150 , 185.4, 235, 175);
    }

$pdf = new PdfEmployeeScoreboardTable($set_max_scores_on_page = 15, $set_gray_col = 4);
$pdf->PageTitle(TXT_UCF('EMPLOYEE') . ' ' . TXT_UCF('JOB_PROFILE_NAME'));
$pdf->SetWidths($pdf->WidthArray());
$pdf->PageHeaderData($pdf->FillHeader($id_e, $function_name));

$pdf->Open();

if (count($scoreboardGroup->getInterfaceObjects()) == 0) {
    //NO DATA RETURN
    $pdf->AddPage($orientation = 'L');
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetWidths(array(120, 20, 20, 20));
    $pdf->SingleRow('', '', array(TXT_UCF('NO_COMPETENCE_RETURN'), '', '', ''));
    // END NO DATA RETURN
} else {

    $scores_on_page = 1;
    $total_records = 1;

    NewPage($pdf);

    $category = '';
    $cluster = '';
    $graph_data = array();
    $next_competence_prefix = '';
//    while ($employee_score = @mysql_fetch_assoc($employee_scores_qry)) {
    foreach ($scoreboardGroup->getInterfaceObjects() as $scoreboardCompetence) {

        $competenceValueObject = $scoreboardCompetence->getValueObject();

        $oldcategory = $category;
        $oldcluster = $cluster;

        $category        = $competenceValueObject->categoryName;
        $cluster         = $competenceValueObject->clusterName;
        $competence      = $competenceValueObject->competenceName;
        $is_cluster_main = $competenceValueObject->competenceIsMain;
        $norm            = $competenceValueObject->competenceFunctionNorm;
        $score           = $scoreboardCompetence->getScore();

        if ($category != $oldcategory) {
            $pdf->Ln(0);
            $category_label = CategoryConverter::display($category);
        } else {
            $category_label = '';
        }

        if ($cluster != $oldcluster) {
            $cluster_label = ModuleUtils::Abbreviate($cluster, 20);
            $competence_prefix = '';
            if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                $next_competence_prefix = ($is_cluster_main == 1) ?  '    '  : '';
            }
        } else {
            $cluster_label = '';
            $competence_prefix = $next_competence_prefix;
        }

        $competence_label = $competence_prefix . ModuleUtils::Abbreviate($competence, 30);
        $score_disp = ModuleUtils::ScorepointLetter($score);
        $norm_disp = ModuleUtils::ScoreNormLetter($norm);

        list($score_bg_color, $score_fg_color) = ScoreboardCommon::getGridCellColor($score, $norm, $is_cluster_main);

        // regel positie vasthouden
        $score_color_y = $pdf->GetY();

        // hoofdcluster aangeven (todo: in functie)
        if ($is_cluster_main == 1) {
            $pdf->setFillColorHex(COLOUR_LIGHT_GRAY);
            $pdf->Rect(40, $score_color_y - 0.5, 140, 5, "F");
        }

        // de score afwijking kleuren (todo: in functie)
        $pdf->setFillColorHex($score_bg_color);
        $pdf->setTextColorHex($score_fg_color);
        $pdf->Rect(126, $score_color_y - 0.5, 6, 5, "F");
        $pdf->Text(128, $score_color_y + 3 , $score_disp);
        $pdf->setTextColorHex(COLOUR_BLACK);

        // de rest van de regel printen
        $pdf->SingleRow('', '', array(' ' . $category_label, $cluster_label, $competence_label, '', '   ' . $norm_disp, '', '', '', '', ''));
        $pdf->Ln(2.6);

        // grafiekdata opslaan
        $score_grid = GraphUtils::EvalScoreToGraphValue($score, $norm);
        $norm_grid = GraphUtils::EvalNormToGraphValue($norm);
        $graph_data[] = array('2000', $norm_grid, $score_grid);

        // als max scores op pagina bereikt dan grafiek tekenen en nieuwe pagina starten
        if ($scores_on_page % $pdf->MaxScoresOnPage() == 0) {
            $graph_location_verti = $pdf->GetDataHeaderOffsetY() + 0.8;
            GraphUtils::DrawPdfGraph($pdf, $graph_data, $total_records, $graph_location_verti, $graph_offset_hori, false);
            $graph_data = array();
            NewPage($pdf);
        }

        $scores_on_page++;
        $total_records++;
    } // while
    if (count($graph_data) > 0) {
        // hbd: en voor het printen van de rest van de data
        $graph_location_verti = $pdf->GetDataHeaderOffsetY() + 0.8;
        GraphUtils::DrawPdfGraph($pdf, $graph_data, $total_records, $graph_location_verti, $graph_offset_hori, false);
    }

} // if

$pdf->Output();

?>