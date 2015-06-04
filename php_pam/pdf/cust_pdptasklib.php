<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {
    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: PDP Task Library');
    $pdf->PageDataHeaderValues(array(100, 120),
                               array('Task', 'Description'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');

    $sql = 'SELECT
                task,
                task_description
            FROM
                pdp_task
            WHERE
                customer_id = ' . $customer_no . '
            ORDER BY
                task';

    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
        $pdf->setWidths(array(100, 120));
         $pdf->SingleRow('1', '', array($result_row['task'],
                                        $result_row['task_description']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="pdp_task_library.pdf"');
}
?>