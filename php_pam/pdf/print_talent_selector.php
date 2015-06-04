<?php
require_once('application/interface/ApplicationInterfaceBuilder.class.php');

// services
require_once('modules/model/service/library/AssessmentCycleService.class.php');
require_once('modules/model/service/report/TalentSelectorService.class.php');
require_once('modules/model/service/employee/competence/EmployeeScoreService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceService.class.php');

// value objects
require_once('modules/model/valueobjects/report/TalentSelectorCompetenceValueObject.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorRequestedValueObject.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorValueObject.class.php');
require_once('modules/model/valueobjects/report/TalentSelectorResultCollection.class.php');

// converters
require_once('modules/interface/converter/library/competence/ScoreConverter.class.php');
require_once('modules/interface/converter/report/OperatorConverter.class.php');
require_once('modules/model/value/report/OperatorValue.class.php');

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/common/printDataTableBase.class.php');

$resultCollection = unserialize($_SESSION['print_talent_selector_object']);
unset($_SESSION['print_talent_selector_object']);

$employeesMatchCount = $resultCollection->getEmployeesMatchCount();
$requestedCount = $resultCollection->getRequestedCount();
$resultObjects = $resultCollection->getResultObjects();

$pdf = new PdfDataTableBase();
$pdf->PageTitle(TXT_UCF('TALENT_SELECTOR')); // 35
$pdf->DataHeaderValues(array(80, 60),
                           array(TXT_UCF('EMPLOYEE'),  // 43
                                 TXT_UCF('SCORE')));  // 46

$pdf->Open();
$pdf->AddPage($orientation = 'P');

foreach($resultObjects as $resultObject) {

    if ($resultObject->hasScoreObjects()) {

        $valueObject    = $resultObject->getValueObject();
        $scoreObjects   = $resultObject->getScoreObjects();

        $competenceName = $valueObject->getCompetenceName();
        $operator       = $valueObject->getOperator();
        $requestedScore = $valueObject->getScore();

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetTextColorHex(COLOR_RED);
        $pdf->Ln(4);
        $criteria = $competenceName . ' ' . OperatorConverter::display($operator) . ' ' . ScoreConverter::display($requestedScore) . ' - ' . ScoreConverter::description($requestedScore);
//        $criteria = $competenceName . ' ' . $operator . ' ' . ModuleUtils::ScorepointText($requestedScore);
        $pdf->Cell(0, 0, $criteria, 0, 0, 'L');
        $pdf->Ln(3);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetTextColorHex(COLOR_BLACK);

        foreach ($scoreObjects as $scoreObject) {
            $employeeId = $scoreObject->getEmployeeId();
            if ($employeesMatchCount[$employeeId] == $requestedCount) {
                $employeeName = $scoreObject->getEmployeeName();
                $score        = $scoreObject->getScore();
                $pdf->setWidths(array(80, 60));
                $pdf->SingleRow('', '', array($employeeName, ScoreConverter::display($score) . ' - ' . ScoreConverter::description($score)));
            }
        }
    }
}

$pdf->Output();
?>