<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {

    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: Employees Score');
    $pdf->PageDataHeaderValues(array(30, 30, 40, 25, 40, 40, 40, 15, 15),
                               array('Last name', 'First name', 'Function', 'Category', 'Cluster', 'Department', 'Competence', 'Norm', 'Score'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');

    $sql = 'SELECT
                e.lastname,
                e.firstname,
                f.function,
                ks.knowledge_skill,
                ksc.cluster,
                d.department,
                ksp.knowledge_skill_point,
                fp.scale AS norm,
                ep.scale AS score
            FROM
                employees e
                LEFT JOIN function_points fp
                    ON fp.ID_F = e.ID_FID
                LEFT JOIN functions f
                    ON f.ID_F = e.ID_FID
                LEFT JOIN knowledge_skills_points ksp
                    ON ksp.ID_KSP = fp.ID_KSP
                LEFT JOIN knowledge_skill ks
                    ON ks.ID_KS = ksp.ID_KS
                LEFT JOIN employees_points ep
                    ON ep.ID_KSP = ksp.ID_KSP AND ep.ID_E = e.ID_E
                LEFT JOIN department d
                    ON d.ID_DEPT = e.ID_DEPTID
                LEFT JOIN knowledge_skill_cluster ksc
                    ON ksc.ID_C = ksp.ID_C
            WHERE
                e.is_inactive = 0
                AND e.customer_id = ' . $customer_no . '
            ORDER BY
                e.lastname,
                e.firstname,
                ks.knowledge_skill,
                ksc.cluster,
                ksp.knowledge_skill_point';

    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
         $pdf->setWidths(array(30, 30, 40, 25, 40, 40, 40, 15, 15));
         $pdf->SingleRow('1', '', array($result_row['lastname'],
                                        $result_row['firstname'],
                                        $result_row['function'],
                                        $result_row['knowledge_skill'],
                                        $result_row['cluster'],
                                        $result_row['department'],
                                        $result_row['knowledge_skill_point'],
                                        $result_row['norm'],
                                        $result_row['score']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="employee_scores.pdf"');
}
?>