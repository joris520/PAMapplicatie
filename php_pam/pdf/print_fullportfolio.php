<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/employee/print_employees_table.php');

require_once('pdf/employee/EmployeeAttachmentsPdf.class.php');
require_once('pdf/employee/EmployeeProfilePdf.class.php');
require_once('pdf/employee/EmployeeScorePdf.class.php');
require_once('pdf/employee/EmployeePDPActionPdf.class.php');
require_once('pdf/employee/EmployeePDPCostsPdf.class.php');
require_once('pdf/employee/EmployeeTargetPdf.class.php');
require_once('pdf/employee/EmployeeThreesixtyPdf.class.php');



$pdf = new PdfEmployeeTable();

//$pdf = new PDF_MC_Table();
$pdf->Open();

$id_e = $_GET['id_e'];
$i = 0;
foreach ($_GET['fullprint'] as $option) {
    switch ($option) {
        case "attachments": {

                function full_attachment() {}

                EmployeeAttachmentsPdf::printAttachments($pdf, $id_e);
                break;
            }

        case "profile": {
                function full_profile() {}

                EmployeeProfilePdf::printProfile($pdf, $id_e);
                break;
            }

        case "score": {

                function full_score() {}

                $select360 = '1';
                $rating = 2;
                $act = 1;
                $show_remarks = 1;
                EmployeeScorePdf::printScore($pdf, $id_e, $rating, $select360, $act, $show_remarks);
                break;
            }
        case "pdp_actions": {

                function full_pdpactions() {}

                // Print all available PDP actions
                EmployeePDPActionPdf::printPdpAction($pdf, $id_e, NULL, NULL, 1);
                break;
            }
        case "pdp_costs": {

                function full_pdp_costs() {}

                $pdf->ActivatePrintHeader(0);
                $pdf->PageTitle(TXT_UCF('PDP_COSTS')); // 446
                $pdf->AddPage();
                $total_costs = EmployeePDPCostsPdf::printPdpCostsEmployee($pdf, $id_e, NULL, NULL, $header_mode = 1);
                if ($total_costs >0) EmployeePDPCostsPdf::printPdfCostsTotal($pdf, $total_costs);
                unset($total_costs);
                break;
            }
        case "targets": {

                function full_targets() {}

                EmployeeTargetPdf::printTargets($pdf, $id_e, NULL, $form);
                break;
            }
        case "threesixty": {
                EmployeeThreesixtyPdf::printThreesixty($pdf, $id_e);
        }
    }
    $i++;
}

$pdf->Output();

?>