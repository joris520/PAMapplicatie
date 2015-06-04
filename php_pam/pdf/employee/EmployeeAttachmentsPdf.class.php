<?php

require_once('pdf/objects/employee/print_employees_table.php');
require_once('modules/common/moduleConsts.inc.php');
require_once('modules/model/queries/employee/document/EmployeeDocumentQueries.class.php');

class EmployeeAttachmentsPdf {

    static function printAttachments(PdfEmployeeTable $pdf, $employee_id)
    {
        // pagina aanmaken
        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_ATTACHMENT);
        $pdf->PageTitle(TXT_UCF('EMPLOYEE_ATTACHMENTS')); // 154
        $pdf->ActivatePrintHeader();
        $pdf->ActivateDataHeader();
        $pdf->PageHeaderData($pdf->FillHeader($employee_id));

        $pdf->DataHeaderValues(array(46, 46, 66, 64, 60),
                               array(TXT_UCF('CLUSTER'),
                                     TXT_UCF('FILENAME'),
                                     TXT_UCF('ACCESS'),
                                     TXT_UCF('DESCRIPTION'),
                                     TXT_UCF('REMARKS')));

        $pdf->AddPage('L');
        if (!empty($employee_id)) {
            // voeg de employee attachments toe
            $get_att = EmployeeDocumentQueries::getEmployeeDocuments($employee_id);

            if (@mysql_num_rows($get_att) > 0) {
                $prev_cluster = NULL;
                while ($att = @mysql_fetch_assoc($get_att)) {
                    $row_cluster = $att['document_cluster'];
                    $display_cluster_name = '';
                    if ($prev_cluster != $row_cluster) {
                        $display_cluster_name = empty($row_cluster) ? TXT_UCF('EMPTY_CLUSTER_LABEL') : $row_cluster;
                    }
                    $display_access_list = ModuleUtils::generateAccessList($att['level_id_hr'], $att['level_id_mgr'], $att['level_id_emp_edit']);
                    $pdf->SetWidths(array(46,  46,  66,  64,  60));
                    $pdf->SingleRow('', '', array($display_cluster_name, $att['document_name'], $display_access_list, $att['document_description'], $att['notes']));
                    $prev_cluster = $row_cluster;
                }
            } else {
                $pdf->SetWidths(array(200));
                $pdf->SingleRow('', '', array(TXT_UCF('NO_ATTACHMENT_RETURN'))); //342
            }
        } else {
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetWidths(array(200));
            $pdf->Cell(0, -10, TXT_UCF('NO_EMPLOYEES_RETURN'), 0, 0, 'L'); // 116
        }

        $pdf->ActivateDataHeader(0);

    } // END FUNCTION printAttachments
}

?>
