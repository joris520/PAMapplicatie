<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {

    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: PDP Action Library');
    $pdf->PageDataHeaderValues(array(40, 60, 60, 40, 20, 20, 20),
                               array('Cluster', 'Action', 'Provider', 'Duration', 'Costs', 'Start date', 'End date'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');

    $sql = 'SELECT
                pac.cluster,
                pa.customer_id,
                pa.action,
                pa.ID_PDPAC,
                pa.provider,
                pa.duration,
                pa.start_date,
                pa.end_date,
                pa.costs
            FROM
                pdp_actions pa
                LEFT OUTER JOIN pdp_action_cluster pac
                    ON pac.ID_PDPAC = pa.ID_PDPAC
            WHERE
                pa.customer_id = ' . $customer_no . '
                and pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER . '
            ORDER BY
                pac.cluster,
                pa.action';

    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
         $pdf->setWidths(array(40, 60, 60, 40, 20, 20, 20));
         $pdf->SingleRow('1', '', array($result_row['cluster'],
                                        $result_row['action'],
                                        $result_row['provider'],
                                        $result_row['duration'],
                                        '� '.$result_row['costs'],
                                        $result_row['start_date'],
                                        $result_row['end_date']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="pdp_action_library.pdf"');
}
?>