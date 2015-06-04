<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/pdfUtils.inc.php');
require_once('pdf/objects/print_functions_table.php');

ModuleUtils::DefineScales(CUSTOMER_ID);

$c = $_GET['c'];
$array_func_selection = $_GET['func'];


$pdf = new PdfFunctionsTable();
$pdf->PageTitle(TXT_UCF('JOB_PROFILE')); // 23
$pdf->DataHeaderValues(array(27, 47, 18, 15),
                       array(TXT_UCF('CATEGORY'), // 253
                             TXT_UCF('COMPETENCE'),  // 45
                             TXT_UCF('NORM'),  // 47
                             TXT_UCF('SCALE') . ':')); // 55
$pdf->Open();

foreach ($array_func_selection as $id_f) {

        $sql = 'SELECT
                    *
                FROM
                    functions
                WHERE
                    ID_F = ' . $id_f;
        $functionQuery = BaseQueries::performQuery($sql);
        $get_f = @mysql_fetch_assoc($functionQuery);

        $pdf->PageHeaderData(array(array(TXT_UCF('DATE') . ':', date('d-m-Y', time())),
                                   array(TXT_UCF('FUNCTION') . ':', $get_f['function'])));
        $pdf->AddPage();

        $sql = 'SELECT
                    fp.ID_F,
                    fp.scale as scale,
                    ks.knowledge_skill,
                    ksp.knowledge_skill_point,
                    ksp.1none,
                    ksp.2basic,
                    ksp.3average,
                    ksp.4good,
                    ksp.5specialist,
                    ksp.description,
                    ksp.scale as ksp_scale,
                    ksc.cluster
                FROM
                    functions f
                    INNER JOIN function_points fp
                        ON fp.ID_F = f.ID_F
                    LEFT JOIN knowledge_skills_points ksp
                        ON ksp.ID_KSP = fp.ID_KSP
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                WHERE
                    f.ID_F = ' . $id_f . '
                GROUP BY
                    fp.ID_KSP
                ORDER BY
                    ks.knowledge_skill,
                    ksc.cluster,
                    ksp.knowledge_skill_point';
        $get_ks = BaseQueries::performQuery($sql);
        if (@mysql_num_rows($get_ks) == 0) {
            $pdf->SetWidths(array(190));
            $pdf->SingleRow('', '', array(TXT_UCF('NO_COMPETENCE_RETURN')));
            $pdf->Ln(5);
        } else {
            $i = 1;
            while ($ks_row = @mysql_fetch_assoc($get_ks)) {
                $oldks = $ks;

                $ks = CategoryConverter::display($ks_row['knowledge_skill']);

                $ksp = $ks_row[knowledge_skill_point];
                $norm = $ks_row[scale];
                $norm_text = ModuleUtils::ScoreNormText($norm);
                $scale = ModuleUtils::ScaleText($norm);
                if ($norm == 1) {
                    $desc = $ks_row['1none'];
                } elseif ($norm == 2) {
                    $desc = $ks_row['2basic'];
                } elseif ($norm == 3) {
                    $desc = $ks_row['3average'];
                } elseif ($norm == 4) {
                    $desc = $ks_row['4good'];
                } elseif ($norm == 5) {
                    $desc = $ks_row['5specialist'];
                } elseif ($norm == 'Y') {
                    $desc = $ks_row[description];
                } elseif ($norm == 'N') {
                    $desc = $ks_row[description];
                }

                if ($ks != $oldks || $i == 1) {
                    $pdf->Ln(1);
                    $pdf->SetFont('Arial', 'B', 8);
                    $pdf->SetWidths(array(190));
                    $pdf->SingleRow('', '1', array($ks));
                    $pdf->Ln(5);
                }


                $cluster = $ks_row['cluster'];

                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(28);
                $pdf->HR(163, 'B');
                $pdf->Ln(0);
                $pdf->SetWidths(array(27, 48, 17, 98));
                $pdf->Row('', array('', $cluster, '', ''));
                $pdf->Ln(0);
                $pdf->Row('', array('', $ksp, $norm_text, $scale));

                $pdf->SetWidths(array(27, 48, 115));

                $pdf->SetTextColorHex(COLOR_GRAY);

                $pdf->Row('', array('', TXT_UCF('EXPLANATION') . ': ', ''));
                $pdf->Ln(0);
                $pdf->SetWidths(array(27, 163));
                //if($ks_row[ksp_scale] == ScaleValue::SCALE_1_5) {
                $pdf->Row('', array('', $desc));
                //}
                $pdf->Ln(1.6);

                $pdf->SetTextColorHex(COLOR_BLACK);

                if ($_GET['c'] == 2) {
                    if ($ks_row[ksp_scale] == ScaleValue::SCALE_1_5) {
                        $pdf->Ln(2);

                        $pdf->SetWidths(array(28, 0, 163));
                        $pdf->Row('', array('', '', $ks_row[description]));
                        $pdf->Ln(1);
                        $pdf->SetWidths(array(28, 5, 163));
                        $pdf->Row('', array('', '1', $ks_row['1none']));
                        $pdf->Ln(1);
                        $pdf->SetWidths(array(28, 5, 163));
                        $pdf->Row('', array('', '2', $ks_row['2basic']));
                        $pdf->Ln(1);
                        $pdf->SetWidths(array(28, 5, 163));
                        $pdf->Row('', array('', '3', $ks_row['3average']));
                        $pdf->Ln(1);
                        $pdf->SetWidths(array(28, 5, 163));
                        $pdf->Row('', array('', '4', $ks_row['4good']));
                        $pdf->Ln(1);
                        $pdf->SetWidths(array(28, 5, 163));
                        $pdf->Row('', array('', '5', $ks_row['5specialist']));
                        $pdf->Ln(1);
                        $pdf->Ln(1);
                    }
                }
                $i++;
                if ($pdf->GetY() > 200) {
                    $pdf->AddPage();
                }
            }
        }
}

$pdf->Output();
?>