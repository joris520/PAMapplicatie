<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/print_history_prev_table.php');

// hbd: spul uit sessie halen
$id_employee = $_SESSION['history_prev_id_e'];
$history_sql = $_SESSION['history_prev_sql'];
$id_ehpd = $_SESSION['history_prev_id_ehpd']; // hbd: laatst geselecteerde

$pdf = new PdfHistoryPrevTable($print_mode);
$page_title = TXT_UCF('SCORE') . ' '. // CUSTOMER_MGR_SCORE_LABEL?
              TXT_UCF('HISTORY') . ': ';

if ($print_mode == PRINTMODE_FUNCTION) {
    $page_title .= TXT_UCF('FUNCTION');
} else {
    $page_title .= TXT_UCF('COMPETENCE');
}

$pdf->PageTitle($page_title);
$pdf->Open();
$pdf->PageHeaderData($pdf->FillHeader($id_employee));

// TODO: anders
$sql = $history_sql;
$result = BaseQueries::performQuery($sql);

if (@mysql_num_rows($result) == 0) {
    //NO DATA RETURN
    $pdf->AddPage($orientation = 'L');

    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetWidths(array(60, 80, 20, 120));
    $pdf->SingleRow('', '', array(TXT_UCF('NO_EMPLOYEES_RETURN'), '', '', ''));
    // END NO DATA RETURN
} else {

    $pdf->AddPage($orientation = 'L');
    $history_last_txt = ' (' . TXT_UCF('LATEST_SAVED') . ')'; // 70

    while ($result_row = @mysql_fetch_assoc($result)) {

        $remark = ModuleUtils::Abbreviate($result_row['note'], 50);

        $scale = $result_row['standard_assessment'];
        if ($scale == 'NULL') {
            $scale = "-";
        }
        $standard = $result_row['standard_function'];

        $date_display = date("d-m-Y", strtotime($result_row['modified_date']));
        $conversation_date = ($result_row['conversation_date'] != 0) ? date("d-m-Y", strtotime($result_row['conversation_date'])) : '';

        $knowledge_skill = $result_row['knowledge_skill_point'];

        $is_last_row = ($result_row['ID_EHPD'] == $id_ehpd);

        $pdf->HandleHistoryRow($is_last_row,
                               $date_display, $history_last_txt,
                               $knowledge_skill, $scale,
                               $standard, $remark, $conversation_date);
    }
}

$pdf->Output();
?>