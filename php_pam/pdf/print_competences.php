<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/competence_table.php');

$pdf = new PdfCompetenceTable();
$pdf->PageTitle(TXT_UCF('COMPETENCE_DICTIONARY'));
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
            ksp.is_key
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

    $pdf->AddPage(); // hbd: doet automatisch Header();

    $pdf->SetWidths(array(30.5, 48, 101, 10));
    $pdf->SingleRow('', '', array(TXT_UCF('NO_COMPETENCE_RETURN'), '', '', ''));
// END NO DATA RETURN
} else {
    $pdf->AddPage();

    $j = 1;
    while ($com = @mysql_fetch_assoc($pc)) {


        $oldks = $ks;
        $ks = $com['knowledge_skill'];
        if ($ks != $oldks || $j == 1) {
            if ($j != 1) {
                $pdf->AddPage(); // hbd: doet automatisch Header();
            }

            $knowledge_skill = CategoryConverter::display($ks);
            $shaded = 1;
        } else {
            $knowledge_skill = '';
            $shaded = '';
        }

        $oldc = $c;
        $c = $com['cluster'];
        if ($c != $oldc || $j == 1) {
            $cluster = $com['cluster'];
            $shaded = 1;
        } else {
            $cluster = '';
        }
        $is_key = $com[is_key] == '1' ? '* ' : '  ';
        $com_scale = ModuleUtils::SkillNormText($com[scale]);
        $pdf->SetWidths(array(27, 52, 101, 10));
        $pdf->SingleRow('', $shaded, array($knowledge_skill, $cluster, $is_key . $com[knowledge_skill_point], $com_scale));
        $pdf->Ln(0);
        $j++;
        if ($pdf->GetY() > 260) {
            $pdf->AddPage(); // hbd: doet automatisch Header();
        }
    }
}

$pdf->Output();
?>