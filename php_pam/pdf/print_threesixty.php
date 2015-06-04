<?php

require_once('pdf/employee/EmployeeThreesixtyPdf.class.php');
require_once('pdf/objects/employee/print_employees_table.php');

$pdf = new PdfEmployeeTable();
$pdf->Open();

// CROSS SELECTION
$array_degree_score = explode(',', $_SESSION['degree']);
foreach ($array_degree_score as $id_e) {
    EmployeeThreesixtyPdf::printThreesixty($pdf, $id_e);
}

$pdf->Output();

?>