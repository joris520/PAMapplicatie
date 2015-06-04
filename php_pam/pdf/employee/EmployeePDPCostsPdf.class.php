<?php

//require_once('pdf/objects/employee/print_employeesPDPCost_table.php');
require_once('pdf/objects/common/pdfConsts.inc.php');
require_once('pdf/objects/employee/print_employees_table.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');

class EmployeePDPCostsPdf {

    // returns costs
    static function printPdpCostsEmployee(  PdfEmployeeTable $pdf,
                                            $employee_id,
                                            AssessmentCycleValueObject $assessmentCycle = NULL,
                                            $header_mode = 0)
    {
        $start_date = is_null($assessmentCycle) ? NULL : $assessmentCycle->getStartDate();
        $end_date   = is_null($assessmentCycle) ? NULL : $assessmentCycle->getEndDate();

        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_PDPCOSTS);
        //$pdf->PageTitle(TXT_UCF('PDP_COSTS')); // 446
        $pdf->ActivatePrintHeader();
        $pdf->PageHeaderData($pdf->FillHeaderPdpCosts($employee_id));//, $start_date, $end_date));

        $pdf->DataHeaderEmployeeCosts($pdf->FillHeader($employee_id));

        $pdf->DataHeaderValues( array(100, 43, 25),
                                array(  TXT_UCF('ACTION'),
                                        TXT_UCF('DEADLINE_DATE'),
                                        TXT_UCF('COST'). ' (' . '€'. ')'),
                                array(  PrintTableBase::ALIGN_LEFT,
                                        PrintTableBase::ALIGN_LEFT,
                                        PrintTableBase::ALIGN_RIGHT));
        // toon employeeheader op pagina
        $pdf->ActivateDataHeader(1);
        EmployeePDPCostsPdf::printEmployeeHeader($pdf, $header_mode);

        $employee_costs = 0;
        if (!empty($employee_id)) {
            $sql = 'SELECT
                        epa.*
                    FROM
                        employees e
                        INNER JOIN employees_pdp_actions epa
                            ON epa.ID_E = e.ID_E
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.ID_E = ' . $employee_id . '
                        AND epa.is_completed in (' . PdpActionCompletedStatusValue::NOT_COMPLETED . ',
                                                 ' . PdpActionCompletedStatusValue::COMPLETED . ')
                    ';
            if (!is_null($start_date) && !is_null($end_date)) {
                $sql .= ' AND STR_TO_DATE(epa.end_date, "%d-%m-%Y") >= "' . $start_date . '"
                          AND STR_TO_DATE(epa.end_date, "%d-%m-%Y") <= "' . $end_date . '"
                        ';
            }
            $sql .= ' ORDER BY
                        STR_TO_DATE(epa.end_date, "%d-%m-%Y") ASC,
                        epa.action,
                        epa.provider';

            $get_emp = BaseQueries::performQuery($sql);

            if (@mysql_num_rows($get_emp) == 0) {
                $pdf->SetWidths(array(40));
                $pdf->Row('', array(TXT_UCF('NO_PDP_COST_RETURN'))); // 471
            } else {
                while ($emp = @mysql_fetch_assoc($get_emp)) {
                    $is_user_defined_indicator = $emp['is_user_defined'] ? PDP_ACTION_INDICATOR_USER_DEFINED : PDP_ACTION_INDICATOR_FROM_LIBRARY;
                    $pdf->SetWidths(array(100, 43, 25));
                    $pdf->SetAligns(array(  PrintTableBase::ALIGN_LEFT,
                                            PrintTableBase::ALIGN_LEFT,
                                            PrintTableBase::ALIGN_RIGHT));
                    $pdf->SingleRow('', '', array($emp['action'] . $is_user_defined_indicator, $emp['end_date'], PdpCostConverter::display($emp['costs'])));
                    $pdf->SetWidths(array(80));
                    $pdf->SetAligns(array(  PrintTableBase::ALIGN_LEFT));
                    $pdf->SingleRow('', '', array(TXT_UCF('PROVIDER') . ': ' . $emp['provider'])); // 79
                    $employee_costs += $emp['costs'];

                    $pdf->SetTextColorHex(COLOR_GRAY);
                    $pdf->Cell(0, 4, str_repeat('-', 180));
                    $pdf->Ln(0);
                    $pdf->SetTextColorHex(COLOR_BLACK);
                    $pdf->Ln(2);
                }
                $pdf->Ln(3);
                $pdf->SetFont('', 'B', 10);
                $pdf->SetWidths(array(100, 43, 25));
                $pdf->SetAligns(array(  PrintTableBase::ALIGN_LEFT,
                                        PrintTableBase::ALIGN_LEFT,
                                        PrintTableBase::ALIGN_RIGHT));
                $pdf->SingleRow('', '', array('', TXT_UCF('TOTAL_COSTS') . ':', PdpCostConverter::display($employee_costs))); // 92

                $pdf->SetTextColorHex(COLOR_GRAY);
                $pdf->Cell(0, 4, str_repeat('-', 160));
                $pdf->Ln(0);
                $pdf->SetTextColorHex(COLOR_BLACK);
            }

        } else {
            $pdf->SetWidths(array(40));
            $pdf->Row('', array(TXT_UCF('NO_PDP_COST_RETURN'))); // 471
        }

        $pdf->ln(10);
        return $employee_costs;
    }

    static function printPdfCostsTotal( PdfEmployeeTable $pdf,
                                        $total_costs) {
        $pdf->Ln(10);
        $pdf->Cell(100);
        $pdf->HR(80, 'B');
        $pdf->SetWidths(array(100, 43, 25));
        $pdf->SetAligns(array(  PrintTableBase::ALIGN_LEFT,
                                PrintTableBase::ALIGN_LEFT,
                                PrintTableBase::ALIGN_RIGHT));
        $pdf->SingleRow('', '', array('', TXT_UCF('TOTAL_COSTS') . ':', PdpCostConverter::display($total_costs))); // 92
//        $pdf->SetWidths(array(80, 30, 30, 40));
//        $pdf->SingleRow('', '', array('', '', TXT_UCF('TOTAL_COSTS') . ':', '€ ' . PdpCostConverter::display($total_costs), ''));

    }

    static function printEmployeeHeader(PdfEmployeeTable $pdf,
                                        $header_mode) {
        $pdf->SetFont($pdf->font_family, '', $pdf->page_fontsize);
        $pdf->SetTextColor(0);

        $pdf->ActivatePrintHeader($header_mode);
        $pdf->Header();
    }

} // class EmployeePDPCosts
?>
