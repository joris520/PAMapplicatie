<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {

    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: Competence');
    $pdf->PageDataHeaderValues(array(20, 30, 23, 40, 21, 30, 30, 30, 30, 30),
                               array('Category', 'Cluster', 'Competence', 'Description', 'Scale', '1', '2', '3', '4', '5'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');
    $sql = 'SELECT
                ks.knowledge_skill,
                ksc.cluster,
                ksp.knowledge_skill_point,
                ksp.description,
                ksp.scale,
                ksp.is_key,
                ksp.1none,
                ksp.2basic,
                ksp.3average,
                ksp.4good,
                ksp.5specialist
            FROM
                knowledge_skills_points ksp
                LEFT JOIN knowledge_skill ks
                    ON ks.ID_KS = ksp.ID_ks
                LEFT JOIN knowledge_skill_cluster ksc
                    ON ksc.ID_C = ksp.ID_C
            WHERE
                ksp.customer_id = ' . $customer_no . '
            ORDER BY
                ks.knowledge_skill,
                ksc.cluster,
                ksp.knowledge_skill_point';

    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
        $pdf->SetWidths(array(20, 30, 23, 40, 21, 30, 30, 30, 30, 30));
        $pdf->SingleRow('1', '', array($result_row['knowledge_skill'],
                                    $result_row['cluster'],
                                    $result_row['knowledge_skill_point'],
                                    $result_row['description'],
                                    $result_row['scale'],
                                    $result_row['1none'],
                                    $result_row['2basic'],
                                    $result_row['3average'],
                                    $result_row['4good'],
                                    $result_row['5specialist']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="competences.pdf"');
}
?>