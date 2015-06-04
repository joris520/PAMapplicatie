<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {

    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: PDP Task Owner');
    $pdf->PageDataHeaderValues(array(120),
                               array('Name'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');


    $sql = 'SELECT
                name
            FROM
                pdp_task_ownership
            WHERE
                customer_id = ' . $customer_no . '
            ORDER BY
                name';

    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
        $pdf->setWidths(array(120));
        $pdf->SingleRow('1', '', array($result_row['name']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="pdp_task_owner.pdf"');
}
?>