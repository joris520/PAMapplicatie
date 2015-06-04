<?php
//require_once('application/interface/ApplicationInterfaceBuilder.class.php');

// services
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/employee/target/EmployeeTargetService.class.php');
require_once('modules/interface/converter/employee/target/EmployeeTargetStatusConverter.class.php');

require_once('modules/print/option/EmployeeModuleDetailPrintOption.class.php');


require_once('pdf/objects/employee/print_employees_table.php');
require_once('pdf/employee/EmployeeActionFormPdf.class.php');

class EmployeeTargetPdf
{
    static function printTargets(   PdfEmployeeTable $pdf,
                                    $employeeId,
                                    EmployeeAssessmentCycleDetailPrintOptionValueObject  $printOptionValueObject,
                                    AssessmentCycleValueObject $assessmentCycleValueObject,
                                    Array $employeeTargetCollections)
    {
        $assessmentCycleOption = $printOptionValueObject->getAssessmentCycleOption();
        $hasPrintedTargets = false;

        if (!empty($employeeId)) {

            $employeeTargetCollectionsCount = count($employeeTargetCollections);
            $currentAssessmentCycleId       = $assessmentCycleValueObject->getId();

            $isViewAllowedEvaluation = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION);

            // pagina aanmaken
            $pdf->DataHeaderValues(array(), array(), NULL);
            $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_TARGET);
            $pdf->PageTitle(TXT_UCF('EMPLOYEE'). ' ' . TXT_LC(CUSTOMER_TARGETS_TAB_LABEL)); // 24
            $pdf->ActivatePrintHeader();
            $pdf->PageHeaderData($pdf->FillHeader($employeeId));
            $pdf->AddPage();

            if ($employeeTargetCollectionsCount > 0) {

                foreach($employeeTargetCollections as $employeeTargetCollection) {

                    $assessmentCycleValueObject = $employeeTargetCollection->getAssessmentCycleValueObject();
                    $assessmentCycleId          = $assessmentCycleValueObject->getId();

                    if ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_ALL_CYCLES ||
                       ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE && $assessmentCycleId == $currentAssessmentCycleId)) {

                        $hasPrintedTargets = true;
                        $assessmentCycleName      = $assessmentCycleValueObject->getAssessmentCycleName();
                        $assessmentCycleStartDate = $assessmentCycleValueObject->getStartDate();
                        $assessmentCycleEndDate   = $assessmentCycleValueObject->getEndDate();

                        $pdf->HR('190', 'T');
                        $pdf->SetFont('Arial', 'B', 9);
                        $pdf->HandlePeriodRow(TXT_UCF('ASSESSMENT_CYCLE'),  $assessmentCycleName);
                        $pdf->HandlePeriodRow(TXT_UCF('START_DATE'),        DateUtils::convertToDisplayDate($assessmentCycleStartDate));
                        $pdf->HandlePeriodRow(TXT_UCF('END_DATE'),          DateUtils::convertToDisplayDate($assessmentCycleEndDate));
                        $pdf->Ln(2);
                        $pdf->SetFont('Arial', '', 9);

                        $employeeTargetValueObjects = $employeeTargetCollection->getEmployeeTargetValueObjects();

                        foreach($employeeTargetValueObjects as $employeeTargetValueObject) {

                            $targetName           = $employeeTargetValueObject->getTargetName();
                            $performanceIndicator = $employeeTargetValueObject->getPerformanceIndicator();
                            $targetEndDate        = $employeeTargetValueObject->getEndDate();
                            $targetStatus         = $employeeTargetValueObject->getStatus();
                            if ($isViewAllowedEvaluation) {
                                $targetEvaluationDate = $employeeTargetValueObject->getEvaluationDate();
                                $targetEvaluation     = $employeeTargetValueObject->getEvaluation();
                            }

                            $pdf->Ln(1);
                            //$pdf->Cell(40);
                            //$pdf->HR('150', 'T');
                            $pdf->Ln(1);

                            $statusLabel = '     '; // ruimte voor het plaatje
                            unset($statusImage);
                            switch ($targetStatus) {
                                case 1: { // below status
                                    $statusImage = 'dot_red.jpg';
                                    break;
                                }
                                case 2: { // on target
                                    $statusImage = 'dot_green.jpg';
                                    break;
                                }
                                case 3: { // below target
                                    $statusImage = 'dot_yellow.jpg';
                                    break;
                                }
                                default:
                                    $statusLabel = '';
                            }
                            $statusLabel .= EmployeeTargetStatusConverter::display($targetStatus);


                            $pdf->HandleObjectiveRow(TXT_UCF('TARGET'), $targetName);
                            $pdf->HandleObjectiveRow(TXT_UCF('KPI'),    $performanceIndicator);
                            if ($isViewAllowedEvaluation) {
                                $pdf->HandleObjectiveRow(TXT_UCF('TARGET_STATUS'), $statusLabel);
                            }
                            $pdf->HandleObjectiveRow(TXT_UCF('TARGET_END_DATE'), DateUtils::convertToDisplayDate($targetEndDate));

                            if ($isViewAllowedEvaluation && !empty($statusImage)) {
                                $pdf->Image('../images/' . $statusImage, 91, $pdf->GetY() - 9, 2.5);
                            }
                            if ($isViewAllowedEvaluation) {
                                $pdf->Ln(2);
                                if (!empty($targetEvaluationDate)) {
                                    $pdf->HandleObjectiveRow(TXT_UCF('CONVERSATION_DATE'), DateUtils::convertToDisplayDate($targetEvaluationDate));
                                }
                                if (!empty($targetEvaluation)) {
                                    $pdf->HandleObjectiveRow(TXT_UCF('EVALUATION'), $targetEvaluation);
                                }
                            }

                            $pdf->Ln(2);
                            $pdf->Cell(40);
                            $pdf->HR('150', 'T');

                        }
                    }
                }
            }
            if (!$hasPrintedTargets) {
                $pdf->HR('190', 'T');
                $pdf->Ln(10);
                $pdf->SetFont('Arial', '', 10);
                $pdf->Cell(0, -10, TXT_UCF('NO_TARGET_AND_PERIOD_S_RETURN'), 0, 0, 'L');
            }
        } else {
            $pdf->HR('190', 'T');
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, -10, TXT_UCF('NO_EMPLOYEES_RETURN'), 0, 0, 'L');
        }
    }
}
?>
