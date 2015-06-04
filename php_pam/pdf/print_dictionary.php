<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/dictionary_table.php');

$pdf = new PdfDictionaryTable();
$pdf->PageTitle(TXT_UCF('COMPETENCE_DICTIONARY')); // 497
$pdf->Open();

$sql = 'SELECT
            ks.ID_KS, ks.knowledge_skill,
            CASE WHEN ksc.cluster is NULL
                 THEN " "
                 ELSE ksc.cluster
            END as cluster,
            ksp.ID_KSP,
            ksp.ID_C,
            ksp.knowledge_skill_point,
            ksp.description,
            ksp.scale,
            ksp.1none,
            ksp.2basic,
            ksp.3average,
            ksp.4good,
            ksp.5specialist
        FROM
            knowledge_skill ks
            LEFT JOIN knowledge_skills_points ksp
                ON ksp.ID_KS = ks.ID_KS
            LEFT JOIN knowledge_skill_cluster ksc
                ON ksc.ID_C   = ksp.ID_C
        WHERE
            ksp.customer_id = ' . CUSTOMER_ID . '
        ORDER BY
            ks.knowledge_skill,
            ksc.cluster,
            ksp.knowledge_skill_point';
    $pc = BaseQueries::performQuery($sql);

if (@mysql_num_rows($pc) == 0) {
    //NO DATA RETURN
    $pdf->AddPage();

    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetWidths(array(30.5, 48, 101, 10));
    $pdf->SingleRow('', '', array(TXT_UCF('NO_COMPETENCE_RETURN'), '', '', '')); // 227
    // END NO DATA RETURN
} else {

    $pdf->AddPage();

    $j = 1;
    while ($com = @mysql_fetch_assoc($pc)) {
        if ($pdf->GetY() > 225) {
            $pdf->AddPage();
        }

        $oldks = $ks;
        $ks = $com['knowledge_skill'];
        if ($ks != $oldks || $j == 1) {
            $knowledge_skill = CategoryConverter::display($com['knowledge_skill']);
            $shaded = 1;
        } else {
            $knowledge_skill = '';
            $shaded = '';
            $pdf->Ln(1);
        }

        $oldc = $c;
        $c = $com['cluster'];
        if ($c != $oldc || $j == 1) {
            $cluster = $com['cluster'];
            $shaded = 1;
        } else {
            $cluster = '';
            $shaded = '';
        }
        $norm_text = ModuleUtils::SkillNormText($com[scale]);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetWidths(array(27, 52, 101, 10));
        $pdf->SingleRow('', $shaded, array($knowledge_skill, $cluster, $com[knowledge_skill_point], $norm_text));
        $printks_line = $knowledge_skill . '^0)' . $cluster . '^0)' . $com[knowledge_skill_point] . '^0)' . (($pdf->PageNo()) + 1). '^*'; // hbd: PageNo loopt achter
        $printks .= $printks_line;
        $pdf->Ln(1);
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetWidths(array(30.5, 48, 110));
        $pdf->Row('', array('', '', str_replace("<br />", "", $com[description])));
        if ($com[scale] == ScaleValue::SCALE_1_5) {
            $pdf->Ln(2);
            $pdf->SetWidths(array(78.5, 10, 105));
            $pdf->HandleNorm('1.', $com['1none']);
            $pdf->HandleNorm('2.', $com['2basic']);
            $pdf->HandleNorm('3.', $com['3average']);
            $pdf->HandleNorm('4.', $com['4good']);
            $pdf->HandleNorm('5.', $com['5specialist']);
            $pdf->Ln(1);
        }
        $pdf->SetWidths(array(30.5, 48, 110));
        $pdf->Row('', array('', '', str_repeat('_', 68)));
        $pdf->Ln(0);
        $j++;
    }


    //GENERATE INDEX PAGES
    $pdf->ActivatePrintHeader(1);
    $pdf->ActivatePrintTOCHeader(1);
    $pdf->AddPage();
    $pdf->ActivatePrintFooter(0); // hbd: inhoudsopgave geen footer

    $pageview = explode('^*', substr($printks, 0, -2));
//    $pageview = explode('^*', substr($_SESSION['printks'], 0, -2));

    foreach ($pageview as $ks_view) {
        if ($pdf->GetY() > 268) {
            $pdf->AddPage();
        }
        $pdf->SetWidths(array(30, 50, 103, 10));
        $ks_sub = explode('^0)', $ks_view);

        $pdf->SingleRow('', '', $ks_sub);
        $pdf->Cell(80);
        $pdf->HRDots(129);
        $pdf->Ln(1);

    }
    //unset($_SESSION['printks']);
}

$pdf->Output();
?>