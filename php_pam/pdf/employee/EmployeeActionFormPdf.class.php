<?php

require_once('pdf/objects/employee/print_employees_table.php');


class EmployeeActionFormPdf {


    static function printActionForm($pdf, $employee_id, $misc_question_array, $open_actions_array)
    {
        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_ACTIONFORM);

        $pdf->PageTitle(TXT_UCF('ACTION_FORM_MEETING')); // 298
        $pdf->ActivatePrintHeader();
        $pdf->ActivateDataHeader(0);
        $pdf->PageHeaderData($pdf->FillHeader($employee_id));  // hbd: bij actieformulier wel functieprofiel in header tonen
        $pdf->AddPage();
        $pdf->ActivatePrintFooter(0);
        $pdf->ResetPageCount();

        EmployeeActionFormPdf::printActionFormContent($pdf, $misc_question_array, $open_actions_array);

    }

    static function printDottedArea($pdf, $area_title)
    {
        if ($pdf->GetY() > 240) {
            $pdf->AddPage();
        }
        $pdf->Ln(9);
        $pdf->SetWidths(array(80));
        $pdf->SingleRow('', '', array($area_title . ' :'));
        $pdf->Ln(8);
        $pdf->HRDots(190);
        $pdf->Ln(5);
        $pdf->HRDots(190);
        $pdf->Ln(5);
        $pdf->HRDots(190);
        $pdf->Ln(5);
        $pdf->HRDots(190);
        $pdf->Ln(5);
        $pdf->HRDots(190);
    }



    static function printMeetingArea($pdf)
    {

        $pdf->Ln(3);

        if ($pdf->CurOrientation == 'L') {
            if ($pdf->GetY() > 182) {
                $pdf->AddPage('L');
            }
            $pdf->SetWidths(array(150, 150));
        } else {
            if ($pdf->GetY() > 240) {
                $pdf->AddPage();
            }
            $pdf->SetWidths(array(100, 100));
        }
        $pdf->SingleRow('', '', array(TXT_UCF('NAME_MANAGER') . ' :', TXT_UCF('DATE_MEETING') . ' :')); // 196, 494
        $pdf->ln(-3);
        $signature_line = '                                 ...........................................';
        $pdf->SingleRow('', '', array($signature_line,  $signature_line)); // 507, 506

    }

    static function printSignatureArea($pdf)
    {
        $pdf->Ln(10);
        if ($pdf->CurOrientation == 'L') {
            if ($pdf->GetY() > 182) {
                $pdf->AddPage('L');
            }
            $pdf->SetWidths(array(150, 150));
        } else {
            if ($pdf->GetY() > 240) {
                $pdf->AddPage();
            }
            $pdf->SetWidths(array(130, 40));
        }
        $pdf->SingleRow('', '', array(TXT_UCF('SIGNATURE_MANAGER') . ' :', TXT_UCF('SIGNATURE_EMPLOYEE') . ' :')); // 507, 506
        if ($pdf->CurOrientation == 'L') {
            $pdf->ln(-3);
            $signature_line = '                                               ...........................................';
        } else {
            $pdf->ln(10);
            $signature_line = '...........................................';
        }
        $pdf->SingleRow('', '', array($signature_line,  $signature_line)); // 507, 506
    }

    static function printActionFormContent($pdf, $misc_question_array, $open_actions_array)
    {
        $pdf->SetTextColorHex(COLOR_BLACK);
        EmployeeActionFormPdf::printMeetingArea($pdf);
        //$pdf->SetFont('Arial', '', 9);
        $pdf->Ln(7);

        $pdf->SetWidths(array(80, 60, 26, 25));
        $pdf->SetFont('', 'B', '');
        $pdf->RowT('1', '', array( TXT_UCF('ACTIONS'). ' ('.TXT_UCF('NOT_COMPLETED') . ')',
                                   TXT_UCF('RELATED_COMPETENCES'),
                                   TXT_UCF('ACTION_OWNER'),
                                   TXT_UCF('DEADLINE'))); //495, 496, 310, 73
        $pdf->Ln(1);
        $pdf->SetFont('', '', '');
        if (empty($open_actions_array)) {
            $pdf->RowT('', '', array(TXT_UCF('NO_PDP_ACTIONS_RETURN'),
                                      '', '', ''));

        } else {
            foreach ((array)$open_actions_array as $open_action) {
                $pdf->RowT('1', '', array($open_action[action],
                                          $open_action[comptetences],
                                          $open_action[action_owner],
                                          $open_action[deadline_date]));
                $pdf->Ln(1);
            }
        }

        $pdf->Ln(5);

        $pdf->SetWidths(array(71, 69, 26, 25));
        $pdf->SetFont('', 'B', '');
        $pdf->RowT('1', '', array(TXT_UCF('SELECTED_COMPETENCIES_FOR_SPECIFIC_EVALUATION'),
                                   TXT_UCF('AGREED_ACTIONS_FOR_FURTHER_PERSONAL_DEVELOPMENT'),
                                   TXT_UCF('ACTION_OWNER'),
                                   TXT_UCF('DEADLINE'))); //495, 496, 310, 73
//        $pdf->Ln(1);
        $pdf->SetFont('', '', '');

        //$pdf->SetFont('Arial', '', 9.5);
//        $pdf->SetWidths(array(71, 69, 26, 25));
//        $pdf->RowT('1', '', array('', '', '', ''));

        for ($i = 0; $i <= 15; $i++) {
            $pdf->SetWidths(array(71, 69, 26, 25));
            $pdf->Ln(1);
            $pdf->RowT('1', '', array('', '', '', ''));
        }

        // hbd: Hier de extra open vragen toevoegen
        foreach ((array)$misc_question_array as $misc_question) {
            EmployeeActionFormPdf::printDottedArea($pdf, $misc_question[question]); // 108
        }

        EmployeeActionFormPdf::printSignatureArea($pdf);
    }


}

?>
