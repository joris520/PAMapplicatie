<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/pdfConsts.inc.php');
require_once('pdf/objects/rpdf/print_history_scoreboard_table.php');
require_once('pdf/objects/common/graphUtils.inc.php');
//require_once('plot/phplot/phplot.php');

$pdf = new PdfEmployeeHistoryScoreboardTable($print_mode, $set_max_scores_on_page = 15, $set_gray_col = 4);
$pdf->Open();

$page_title = TXT_UCF(CUSTOMER_MGR_SCORE_LABEL) . ' '. // 46
              TXT_UCF('HISTORY') . ': '; // 37

if ($print_mode == PRINTMODE_FUNCTION) {
    $page_title .= TXT_UCF('FUNCTION');
} else {
    $page_title .= TXT_UCF('COMPETENCE');// 45
}

$pdf->PageTitle($page_title);


$id_ehpd = $_GET['id_ehpd'];

$sql = 'SELECT
            ehpd.ID_E,
            e.employee,
            ehp.knowledge_skill,
            ehp.knowledge_skill_point,
            ehp.standard_assessment AS score ,
            ehp.standard_function AS norm,
            ehp.note,
            CASE
                WHEN ehp.cluster is null
                THEN "zzz"
                ELSE ehp.cluster
            END as cluster,
            ehp.is_cluster_main,
            DATE_FORMAT(ehpd.eh_date,\'%d-%m-%Y\') as hist_date,
            ehpd.function,
            d.department,
            ehpd.conversation_date
        FROM
            employees_history_points ehp
            INNER JOIN employees_history_points_date ehpd ON
                (ehpd.ID_EHPD = ehp.ID_EHPD)
            INNER JOIN employees e ON
                (e.ID_E = ehpd.ID_E)
            INNER JOIN department d ON
                (d.ID_DEPT = e.ID_DEPTID)
        WHERE
            ehp.ID_EHPD = ' . $id_ehpd . '
            AND e.customer_id = ' . CUSTOMER_ID . '
        GROUP BY
            ehp.knowledge_skill_point
        ORDER BY
            ehp.knowledge_skill,
            cluster,
            ehp.is_cluster_main DESC,
            ehp.knowledge_skill_point';

$result = BaseQueries::performQuery($sql);


if (mysql_num_rows($result) > 0) {

    //$num_interval = $pdf->num_interval;

    $data = array();

    $j = 1;
    $k = 0;
    $total_records = 0;
    $ks = '';
    $old_cluster = '';
    $cluster = '';
    $new_ksp_prefix = '';
    $ksp_prefix = '';

    while ($result_row = @mysql_fetch_assoc($result)) {
        $id_employee = $result_row[ID_E];
        //print_r($result_row);
//        echo $id_employee;
        $oldemp = $emp;
        $emp = $result_row['employee'];
        //echo $emp;
        $function_profile = $result_row['function'];
        $history_date = $result_row['hist_date'];
        $conversation_date = $result_row['conversation_date'];
        $pdf->PrepareDataHeaderValues();
        $pdf->PageHeaderData($pdf->FillHeader($id_employee, $function_profile, $history_date, $conversation_date));
        $pdf->SetWidths($pdf->WidthArray());

        $main_cluster_shading = '';
        if ($result_row['is_cluster_main']) {
            $main_cluster_shading = '[x]';
        }

        if ($emp != $oldemp) {
            $pdf->AddPage($orientation = 'L');
            $pdf->ln(5); // hbd: extra ruimte in de tekst nodig om het plaatje goed onder de header neer te zetten
        }

//        $pdf->SetFont('Arial', '', 8.5);

        $oldks = $ks;
        $ks = CategoryConverter::display($result_row['knowledge_skill']);
        if ($ks != $oldks || $j == 1) {
            $pdf->Ln(0);
            $knowledge_skill = ModuleUtils::Abbreviate($ks, 7);

        } else {
            $knowledge_skill = '';
        }
        $knowledge_skill .= $main_cluster_shading;


        $remark = '';
        if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
            $remark = ModuleUtils::Abbreviate($result_row['note'], 60);
        }

        $knowledge_skill_point = ModuleUtils::Abbreviate($result_row['knowledge_skill_point'], 25);
        $knowledge_skill_point .= $main_cluster_shading;

        $score_disp = '-';
        if (is_numeric($result_row['score'])) {
            $score = intval($result_row['score']);
            if ($score < 1 || $score > 5) {
                unset($score);
            } else {
                $score_disp = $score;
            }
        } else {
            $score = $result_row['score'];
            if ($score == 'Y' || $score == 'N') {
                $score_disp = ModuleUtils::ScorepointLetter($score);
            } else {
                unset($score);
            }
        }

        $cluster_text = '';
        $cluster = $result_row['cluster'] == 'zzz' ? EMPTY_CLUSTER_LABEL : $result_row['cluster'];
        if ($cluster != $old_cluster) {
            $old_cluster = $cluster;
            $cluster_text = ModuleUtils::Abbreviate($cluster, 20);

            $new_ksp_prefix = '';
            $ksp_prefix = '';
            if ($result_row['is_cluster_main']) {
                $new_ksp_prefix = '    ';
            }
        }
        $cluster_text .= $main_cluster_shading;

        if ($pdf->PrintMode() == PRINTMODE_FUNCTION) {
            $norm_disp = '';
            $norm = trim($result_row['norm']);
            if (is_numeric($norm)) {
                $norm = intval($norm);
                if ($norm < 1 || $norm > 5) {
                    unset($norm);
                } else {
                    $norm_disp = $norm;
                }
            } else {
                if ($norm == 'Y' || $norm == 'N') {
                    $norm_disp = ModuleUtils::ScoreNormLetter($norm);
                } else {
                    unset($norm);
                }
            }
            $norm1 = $norm;
            $score1 = $score;

            $attention_image = GraphUtils::AttentionImage($score1, $norm1, $score_disp);
            if (!empty($attention_image)) {
                $score_color_y = $pdf->GetY();
                $pdf->image('../images/score/'.$attention_image, 122, $score_color_y, null, 4, 'PNG');
            }

            $row_data = array($knowledge_skill,
                            $cluster_text,
                            $ksp_prefix . $knowledge_skill_point,
                            '   ' . $score_disp ,
                            '   ' . $norm_disp,
                            '',
                            '',
                            '',
                            '',
                            '');

            if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                $row_data[] = $remark . '[-]';
            }

            $pdf->SingleRow('', '', $row_data);

        } else {
            $row_data = array($knowledge_skill,
                            $cluster_text,
                            $ksp_prefix . $knowledge_skill_point,
                            '   ' . $score_disp,
                            '',
                            '',
                            '',
                            '',
                            '');

            if (CUSTOMER_OPTION_USE_SKILL_NOTES) {
                $row_data[] = $remark . '[-]';
            }

            $pdf->SingleRow('', '', $row_data);
        }
        $pdf->Ln(2.6);

        $graph_offset_hori = 182;
        $score_grid = GraphUtils::EvalScoreToGraphValue($score, $norm);

        $norm_grid = GraphUtils::EvalNormToGraphValue($norm);

        $data[] = array('2000', $norm_grid, $score_grid);


        if ($j % $pdf->MaxScoresOnPage() == 0) {
            GraphUtils::DrawPageGraph($pdf, $data, $total_records, $graph_offset_hori);
            reset($data);
            $data = "";
            $pdf->AddPage($orientation = 'L');
            $pdf->ln(5); // hbd: extra ruimte in de tekst nodig om het plaatje goed onder de header neer te zetten

            $k++;
        }

        $ksp_prefix = $new_ksp_prefix;
        $j++;
        $total_records++;
    }

    // hbd: en voor het printen van de rest van de data
    GraphUtils::DrawPageGraph($pdf, $data, $total_records, $graph_offset_hori);

    $pdf->Ln(7);

    // legenda voor score
    $legenda =  '  [1] ' . SCALE_NONE .
                '  [2] ' . SCALE_BASIC .
                '  [3] ' . SCALE_AVERAGE .
                '  [4] ' . SCALE_GOOD .
                '  [5] ' . SCALE_SPECIALIST;
    $pdf->SetWidths(array(210, 70));
    $pdf->SingleRow('', '', array(TXT_UCF('SCALE') . ':'. $legenda ));



    // hbd: na de score graph de open vragen toevoegen.
    $pdf->ActivateDataHeader(0); // hbd: voor evt vervolgpagina's geen dataheader meer tonen.
    $pdf->SetWidths(array(260));
    $pdf->Ln(15);
    $pdf->HR(280, 'B');
    $pdf->Ln(15);
    // hbd: snelle hack voor extra vragen ------
    $sql = 'SELECT
                question,
                answer
            FROM
                employees_history_misc_answers
            WHERE
                ID_EHPD = ' . $id_ehpd . '
                AND customer_id = ' . CUSTOMER_ID . '
            ORDER BY
                id_ehma';
    $misc_answer_query = BaseQueries::performQuery($sql);

    while ($misc_answer_row = @mysql_fetch_assoc($misc_answer_query)) {
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SingleRow('', '', array($misc_answer_row['question'] . ' :'));
        $pdf->SetFont('Arial', '', 9);
        $pdf->SingleRow('', '', array($misc_answer_row['answer']));
    }
    // ------

} else {

    $pdf->AddPage($orientation = 'L');
    $pdf->HR(280, 'B');
    $pdf->Ln(5);
    $pdf->Cell(0, 20, 'The date selected has no score.');
}

$pdf->Output();

?>
