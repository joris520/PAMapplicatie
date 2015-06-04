<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {

    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: Job Profile');
    $pdf->PageDataHeaderValues(array(60, 60, 50, 40, 30, 30, 30),
                               array('Function', 'Category', 'Cluster', 'Competence', 'Norm', 'Weight Factor'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');



    $sql = 'SELECT
                ks.knowledge_skill,
                ksc.cluster,
                f.function,
                ksp.knowledge_skill_point,
                fp.scale,
                fp.weight_factor
            FROM
                function_points fp
                LEFT JOIN functions f
                    ON f.ID_F = fp.ID_F
                LEFT JOIN knowledge_skills_points ksp
                    ON fp.ID_KSP = ksp.ID_KSP
                LEFT JOIN knowledge_skill ks
                    ON ks.ID_KS = ksp.ID_KS
                LEFT JOIN knowledge_skill_cluster ksc
                    ON ksc.ID_C = ksp.ID_C
            WHERE
                fp.customer_id= ' . $customer_no . '
            ORDER BY
                f.function,
                ks.knowledge_skill,
                ksc.cluster,
                ksp.knowledge_skill_point';

    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
         $pdf->SetWidths(array(60, 60, 50, 40, 30, 30, 30));
         $pdf->SingleRow('1', '', array($result_row['function'],
                                        $result_row['knowledge_skill'],
                                        $result_row['cluster'],
                                        $result_row['knowledge_skill_point'],
                                        $result_row['scale'],
                                        $result_row['weight_factor']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="job_profiles.pdf"');
}
?>