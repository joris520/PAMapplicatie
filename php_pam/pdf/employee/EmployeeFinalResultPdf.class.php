<?php

require_once('pdf/objects/employee/print_employees_table.php');
require_once('modules/common/moduleConsts.inc.php');
require_once('modules/model/queries/employee/document/EmployeeDocumentQueries.class.php');

class EmployeeFinalResultPdf {

    static function printFinalResult(   PdfEmployeeTable $pdf,
                                        $employeeId,
                                        EmployeeFinalResultPrintCollection $printCollection)
    {

        $showDetailScores = CUSTOMER_OPTION_SHOW_FINAL_RESULT_DETAIL_SCORES;

        // pagina aanmaken
        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_FINAL_RESULT);
        $pdf->PageTitle(TXT_UCF('FINAL_RESULT')); // 154
        $pdf->ActivatePrintHeader();
        $pdf->ActivateDataHeader();
        $pdf->PageHeaderData($pdf->FillHeader($employeeId));


        $pdf->AddPage('P');
        $hasPrintedFinalResult = false;

        $valueObjects = $printCollection->getValueObjects();
        foreach($valueObjects as $valueObject) {
            $hasPrintedFinalResult = true;
            $assessmentCycleValueObject = $valueObject->getAssessmentCycleValueObject();
            $pdf->HR('190', 'T');
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->HandlePeriodRow(TXT_UCF('ASSESSMENT_CYCLE'),  $assessmentCycleValueObject->getAssessmentCycleName());
            $pdf->HandlePeriodRow(TXT_UCF('START_DATE'),        DateUtils::convertToDisplayDate($assessmentCycleValueObject->getStartDate()));
            $pdf->HandlePeriodRow(TXT_UCF('END_DATE'),          DateUtils::convertToDisplayDate($assessmentCycleValueObject->getEndDate()));
            $pdf->Ln(2);
            $pdf->SetFont('Arial', '', 9);

            $pdf->Ln(1);
            $pdf->HandleFinalResultRowWide( TXT_UCF('CONVERSATION_DATE'),
                                            DateUtils::convertToDisplayDate($valueObject->getAssessmentDate()),
                                            '');
            $pdf->HandleFinalResultRowWide( TXT_UCF('TOTAL_RESULT'),
                                            ScoreConverter::display($valueObject->getTotalScore()),
                                            $valueObject->getTotalScoreComment());
            if ($showDetailScores) {
                $pdf->HandleFinalResultRowWide( TXT_UCF('BEHAVIOUR'),
                                                ScoreConverter::display($valueObject->getBehaviourScore()),
                                                $valueObject->getBehaviourScoreComment());
                $pdf->HandleFinalResultRowWide( TXT_UCF('RESULTS'),
                                                ScoreConverter::display($valueObject->getResultsScore()),
                                                $valueObject->getResultsScoreComment());
            }
            $pdf->Ln(10);
        }

        // alternatieve print
//        $pdf->HandleFinalResultRow( TXT_UCF('CONVERSATION_DATE'),
//                                    DateUtils::convertToDisplayDate($valueObject->getAssessmentDate()));
//        $pdf->HandleFinalResultRow( TXT_UCF('TOTAL_RESULT'),
//                                    ScoreConverter::display($valueObject->getTotalScore()));
//        $pdf->HandleFinalResultRow( '',
//                                    $valueObject->getTotalScoreComment());
//        if ($showDetailScores) {
//            $pdf->HandleFinalResultRow( TXT_UCF('BEHAVIOUR'),
//                                        ScoreConverter::display($valueObject->getBehaviourScore()));
//            $pdf->HandleFinalResultRow( '',
//                                        $valueObject->getBehaviourScoreComment());
//            $pdf->HandleFinalResultRow( TXT_UCF('RESULTS'),
//                                        ScoreConverter::display($valueObject->getResultsScore()));
//            $pdf->HandleFinalResultRow( '',
//                                        $valueObject->getResultsScoreComment());
//        }

        if (!$hasPrintedFinalResult) {
            $pdf->SetWidths(array(200));
            $pdf->SingleRow('', '', array(TXT_UCF('NO_VALUES_RETURNED'))); //342
        }

        $pdf->ActivateDataHeader(0);

    }


}

?>
