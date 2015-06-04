<?php

require_once('pdf/pdf_config.inc.php');

require_once('pdf/objects/print_pdptodolist_table.php');

$pdf = new PdfPdpToDoListTableBase();
$pdf->PageTitle(TXT_UCF('PDP_TODO_LIST')); // 38
$pdf->Open();

$id_pdpet = $_GET['id_pdpet'];

$sql = '
SELECT
	u.username,
	pto.name,
	ept.ID_PDPET,
	ept.end_date,
	e.employee,
        e.lastname,
        e.firstname,
	ept.task,
	pa.action,
	pa.provider,
	ept.notes,
	ept.is_completed
FROM
	employees_pdp_tasks ept
	JOIN employees_pdp_actions epa ON epa.ID_PDPEA = ept.ID_PDPEA
	JOIN users u ON u.user_id = epa.ID_PDPTOID
	JOIN pdp_actions pa ON pa.ID_PDPA = epa.ID_PDPAID
	JOIN pdp_task_ownership pto ON pto.ID_PDPTO = ept.ID_PDPTO
	JOIN employees e ON e.ID_E = ept.ID_E
WHERE
	ept.ID_PDPET = ' . $id_pdpet . '
	AND u.customer_id = ' . CUSTOMER_ID;

$result = BaseQueries::performQuery($sql);

$j = 1;
while ($result_row = @mysql_fetch_assoc($result)) {
    //echo print_r($result_row);
    $old_action_owner = $action_owner;
    $action_owner = $result_row['username'];
    if ($action_owner != $old_action_owner || $j == 1) {
        $header_data_array = array(array(TXT_UCF('ACTION_OWNER') . ': ',  $action_owner ),  // 71, 72 -> (hbd:) 310
                                   array(TXT_UCF('EMPLOYEE') . ': ', ModuleUtils::EmployeeName($result_row[firstname], $result_row[lastname])), // 24
                                   array(TXT_UCF('PROVIDER'). ': ', ucwords($result_row['provider'])) ); // 79
        $pdf->PageHeaderData($header_data_array);
        $pdf->AddPage($orientation = 'L');
    }

    $pdf->Ln(25);
    $pdf->SetTextColorHex(COLOR_RED);
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Cell(100, -35, TXT_UCF('ACTION') . ': ' . ucwords($result_row['action'])); // 71

    $pdf->SetTextColorHex(COLOR_BLACK);
    $pdf->Ln(-14);
    $pdf->HR(280, 'B');
    $pdf->Ln(4);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SetWidths(array(280));
    $pdf->SingleRow('', '', array(TXT_UCF('TASK_OWNER')  . ': ' . $result_row['name'])); // 75, 72 -> 313
    $pdf->Ln(3);

    $pdf->SingleRow('', '', array(TXT_UCF('COMPLETION_DATE') . ': ' . $result_row['end_date'])); // 314

    if (trim($result_row['is_completed']) == PdpActionCompletedStatusValue::COMPLETED) {
        $image_name = 'completed.png';
    } else {
        $image_name = 'not_completed.png';
    }
    $pdf->SingleRow('', '', array($pdf->image('../images/'.$image_name, 11, $pdf->GetY(), null, 3, 'PNG') .
                                  '     ' . TXT_UCF('COMPLETED'))); // 81


    $pdf->Ln(3);

    $pdf->SingleRow('', '', array(TXT_UCF('TASK') . ': ')); // 75

    $pdf->SetFont('Arial', '', 9);
    $pdf->SingleRow('', '', array($result_row['task']));
    $pdf->Ln(3);

    $pdf->SetFont('Arial', 'B', 9);
    $pdf->SingleRow('', '', array(TXT_UCF('REMARKS') . ': ')); // 69

    $pdf->SetFont('Arial', '', 9);
    $pdf->SingleRow('', '', array($result_row['notes']));

    $pdf->Ln(4);
    $pdf->HR(280, 'B');
    $j++;
}

$pdf->Output();
?>