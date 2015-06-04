<?php
require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_cust_table.php');

$customer_no = $_GET['cid'];
if (isset($customer_no)) {

    $pdf = new PdfCustTable($customer_no);
    $pdf->PageTitle('Customer Data: Employees');
    $pdf->PageDataHeaderValues(array(16, 17, 15, 12, 14, 16, 17, 23, 25, 13, 15, 18, 20, 18, 22.5, 22.5),
                               array('First name', 'Last name', 'Social No.', 'Gender', 'Birthdate', 'Nationality', 'Department', 'Job profile',
                                     'Address', 'Zip code', 'City', 'Tel No.', 'Email address', 'Rating', 'Info', 'Comments'));

    $pdf->Open();

    $pdf->AddPage($orientation = 'L');



    $sql = 'SELECT
                e.*, f.function, d.department
            FROM
                employees e
            LEFT JOIN functions f
                ON e.ID_FID = f.ID_F
            LEFT JOIN department d
                ON d.ID_DEPT = e.ID_DEPTID
            WHERE
                e.customer_id = ' . $customer_no;
    $result = BaseQueries::performQuery($sql);

    while ($result_row = @mysql_fetch_assoc($result)) {
        $pdf->SetWidths(array(16, 17, 15, 12, 14, 16, 17, 23, 25, 13, 15, 18, 20, 18, 22.5, 22.5));
        $pdf->SingleRow('1', '', array(
            $result_row['firstname'],
            $result_row['lastname'],
            $result_row['SN'],
            $result_row['sex'],
            $result_row['birthdate'],
            $result_row['nationality'],
            $result_row['department'],
            $result_row['function'],
            $result_row['address'],
            $result_row['postal_code'],
            $result_row['city'],
            $result_row['phone_number'],
            $result_row['email_address'],
            $result_row['rating'],
            $result_row['additional_info'],
            $result_row['hidden_info']));
    }

    $pdf->Output();

    header('Content-type: application/pdf');

    header('Content-Disposition: attachment; filename="employees.pdf"');
}
?>