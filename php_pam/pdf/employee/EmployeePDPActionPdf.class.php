<?php

require_once('pdf/objects/employee/print_employees_table.php');
require_once('modules/model/service/to_refactor/PdpActionSkillServiceDeprecated.class.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');
require_once('modules/interface/converter/employee/pdpAction/PdpActionCompletedConverter.class.php');

class EmployeePDPActionPdf {

    static function generatePrintSkills($employeeId, $id_pdpea)
    {
        $employee_action_skills_data = PdpActionSkillServiceDeprecated::getSkillsByAction($employeeId, $id_pdpea);

        if (count($employee_action_skills_data) == 0) {
            $generatedInfoCode = TXT_UCF('NO_RELATED_COMPETENCES');
            //$generatedInfoCode .= ': ' . $employee_action_skills_qry;
        } else {
            $generatedInfoCode = '';
            foreach($employee_action_skills_data as $employee_action_skill) {
                $skill_name   = $employee_action_skill[skill_name];
                if (!empty($generatedInfoCode)) $generatedInfoCode .= ', ';
                $generatedInfoCode .= $skill_name;
            }
        }

        return $generatedInfoCode;
    }

    static function printPdpAction( PdfEmployeeTable $pdf,
                                    $employeeId,
                                    AssessmentCycleValueObject $assessmentCycle = NULL)
    {
        $showtask = 0;
        $start_date = is_null($assessmentCycle) ? NULL : $assessmentCycle->getStartDate();
        $end_date   = is_null($assessmentCycle) ? NULL : $assessmentCycle->getEndDate();

        if (!empty($employeeId)) {
            $sql = 'SELECT
                        epa.*
                    FROM
                        employees_pdp_actions epa
                        WHERE
                            epa.customer_id = ' . CUSTOMER_ID . '
                            AND epa.ID_E = ' . $employeeId . '
                    ';
            if (!is_null($start_date) && !is_null($end_date)) {
                $sql .= '       AND STR_TO_DATE(epa.end_date, "%d-%m-%Y") >= "' . $start_date . '"
                                AND STR_TO_DATE(epa.end_date, "%d-%m-%Y") <= "' . $end_date . '"
                        ';
            }
            $sql .= '       ORDER BY
                                STR_TO_DATE(epa.end_date, "%d-%m-%Y") ASC,
                                epa.action,
                                epa.provider';
            $get_pdpa = BaseQueries::performQuery($sql);


            if (@mysql_num_rows($get_pdpa) > 0) {
                $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_PDPACTION);
                $pdf->PageTitle(TXT_UCF('EMPLOYEE_PERSONAL_DEVELOPMENT_PROFILE')); // 509
                $pdf->ActivatePrintHeader();
                $pdf->PageHeaderData($pdf->fillHeaderPdpAction($employeeId, $start_date, $end_date));
                $pdf->AddPage();

                $pdf->Ln(7);
                $pdf->HR('190', 'T');
        //        echo 'rowcount:' . @mysql_num_rows($get_pdpa);
                $pdf->SetFont('Arial', '', 9);
                while ($pdpa = @mysql_fetch_assoc($get_pdpa)) {


                    $costs = $pdpa['costs'];
                    $is_completed = PdpActionCompletedConverter::display($pdpa['is_completed']);
                    $is_user_defined_indicator = $pdpa['is_user_defined'] ? PDP_ACTION_INDICATOR_USER_DEFINED : PDP_ACTION_INDICATOR_FROM_LIBRARY;

                    $datacol_width = 140;
                    $pdf->HandleDataRow(TXT_UCF('PDP_ACTION'), $pdpa['action'] . $is_user_defined_indicator, $datacol_width); // 456
                    $pdf->HandleDataRow(TXT_UCF('PROVIDER'), $pdpa['provider'], $datacol_width); // 79
                    $pdf->HandleDataRow(TXT_UCF('DURATION'), $pdpa['duration'], $datacol_width); // 91
                    $pdf->HandleDataRow(TXT_UCF('COST') . ' (' . '€' . ')', PdpCostConverter::display($costs), $datacol_width); // 92
                    $pdf->HandleDataRow(TXT_UCF('DEADLINE_DATE'), $pdpa['end_date'], $datacol_width); // 235
                    $pdf->HandleDataRow(TXT_UCF('COMPLETED'), '' . $is_completed, $datacol_width); // 81
                    // hbd: tonen gekoppelde competenries
                    $comp_text =  EmployeePDPActionPdf::generatePrintSkills($employeeId, $pdpa['ID_PDPEA']);
                    $pdf->HandleDataRow(TXT_UCF('COMPETENCES'), $comp_text, $datacol_width);

                    $greenImage = $pdpa[is_completed] == '1' ? $pdf->Image('../images/green.jpg', $pdf->GetX() + 41, $pdf->GetY() - 11.5, '3', '3') : '';
                    $pdf->HandleDataRow(TXT_UCF('REMARKS'), $pdpa['notes'], $datacol_width); // 69


                    //DISPLAY TASK: weg
                    $pdf->Ln(5);
                    $pdf->HR('190', 'T');
                    $pdf->Ln(3);
                    //END DISPLAY TASK
                } // while $pdpa
//            } else {
//                $pdf->Ln(20);
//    //            $pdf->SetFont('Arial', '', 10);
//                $pdf->Cell(0, -10, TXT_UCF('NO_VALUES_RETURNED'), 0, 0, 'L'); // 116
            }
        } else {
//            $pdf->HR('190', 'T');
            $pdf->Ln(20);
            $pdf->SetFont('Arial', '', 10);
            $pdf->SetWidths(array(200));
            $pdf->Cell(0, -10, TXT_UCF('NO_EMPLOYEES_RETURN'), 0, 0, 'L'); // 116
        }
    }

}
?>
