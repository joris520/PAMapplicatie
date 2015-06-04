<?php

/**
 * Description of EmployeePortfolioPdf
 *
 * @author ben.dokter
 */
require_once('modules/print/pdf/BasePdf.class.php');

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/employee/print_employees_table.php');

require_once('pdf/employee/EmployeeAttachmentsPdf.class.php');
require_once('pdf/employee/EmployeeFinalResultPdf.class.php');
require_once('pdf/employee/EmployeeProfilePdf.class.php');
require_once('pdf/employee/EmployeeScorePdf.class.php');
require_once('pdf/employee/EmployeePDPActionPdf.class.php');
require_once('pdf/employee/EmployeePDPCostsPdf.class.php');
require_once('pdf/employee/EmployeeTargetPdf.class.php');
require_once('pdf/employee/EmployeeThreesixtyPdf.class.php');
require_once('pdf/employee/EmployeeSignature.class.php');

require_once('modules/model/service/employee/EmployeeSelectService.class.php');
require_once('modules/model/service/employee/finalResult/EmployeeFinalResultService.class.php');
require_once('modules/print/service/employee/EmployeePrintService.class.php');
require_once('modules/print/valueobjects/employee/EmployeePrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeCompetenceDetailPrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeAssessmentCycleDetailPrintOptionValueObject.class.php');

class EmployeePortfolioPdf extends BasePdf
{

    static function create(EmployeePrintOptionValueObject $optionValueObject)
    {
        return new EmployeePortfolioPdf($optionValueObject);
    }

    protected function __construct(EmployeePrintOptionValueObject $optionValueObject)
    {
        $this->pdfObject = new PdfEmployeeTable();
        $this->optionValueObject = $optionValueObject;
    }

    function openPdf()
    {
        $pdf = $this->pdfObject;
        $pdf->Open();
    }

    function outputPdf()
    {
        $pdf = $this->pdfObject;
        return $pdf->Output();
    }

    function resetPageCount()
    {
        $pdf = $this->pdfObject;
        $pdf->requestResetPageCount();
    }

    function generatePdf(   $employeeId,
                            AssessmentCycleValueObject $assessmentCycleValueObject)

    {
        $pdf = $this->pdfObject;

        $optionValueObject  = $this->optionValueObject;
        $options            = $optionValueObject->getPrintOptions();

        // TODO: $employeeInfoValueObject voor de pdf pageheader gebruiken
        $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);

        foreach($options as $option) {
            switch ($option) {
                case EmployeeModulePrintOption::OPTION_ATTACHMENT:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        EmployeeAttachmentsPdf::printAttachments($pdf, $employeeId);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_PROFILE:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        EmployeeProfilePdf::printProfile($pdf, $employeeId);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_COMPETENCE:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        $competenceOptionsValueObject = $optionValueObject->getDetailPrintOptionValueObject($option);
                        $showRemarks    = $competenceOptionsValueObject->showRemarks();
                        $showThreeSixty = $competenceOptionsValueObject->show360();
                        $showPdpAction  = $competenceOptionsValueObject->showPdpAction();

                        // de data verzamelen
                        $employeeCategoryScoreCollection = EmployeeCompetenceService::getEmployeeCompetenceCategoryClusterScoreCollection(  $employeeId,
                                                                                                                                            EmployeeCompetenceService::INCLUDE_360,
                                                                                                                                            $assessmentCycleValueObject);
                        $employeeAnswerCollection = EmployeeAnswerService::getCollection($employeeId, $assessmentCycleValueObject);
                        $invitationValueObject = EmployeeSelfAssessmentInvitationService::getValueObject($employeeId, $assessmentCycleValueObject);
                        EmployeeScorePdf::printScore(   $pdf,
                                                        $employeeId,
                                                        RATING_FUNCTION_PROFILE,
                                                        $showThreeSixty,
                                                        $showPdpAction,
                                                        $showRemarks,
                                                        $invitationValueObject->isInvited(),
                                                        $employeeCategoryScoreCollection,
                                                        $employeeAnswerCollection);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_PDP_ACTION:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        $detailOptionsValueObject   = $optionValueObject->getDetailPrintOptionValueObject($option);
                        // ff een hack want pdp acties is nog niet refactored...
                        $assessmentCycleOption      = $detailOptionsValueObject->getAssessmentCycleOption();
                        if ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE) {
                            EmployeePDPActionPdf::printPdpAction(   $pdf,
                                                                    $employeeId,
                                                                    $assessmentCycleValueObject);
                        } elseif ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_ALL_CYCLES) {

                            $assessmentCycleValueObjects = AssessmentCycleService::getValueObjects();

                            foreach ($assessmentCycleValueObjects as $pdpAssessmentCycleValueObject) {
                                EmployeePDPActionPdf::printPdpAction(   $pdf,
                                                                        $employeeId,
                                                                        $pdpAssessmentCycleValueObject);
                            }
                        }
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_PDP_COST:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        $pdf->ActivatePrintHeader(0);
                        $pdf->PageTitle(TXT_UCF('PDP_COSTS')); // 446
                        $pdf->AddPage();
//                        $assessmentCycleOption      = $detailOptionsValueObject->getAssessmentCycleOption();
//                        if ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_CURRENT_CYCLE) {
                            $total_costs = EmployeePDPCostsPdf::printPdpCostsEmployee(  $pdf,
                                                                                        $employeeId,
                                                                                        $assessmentCycleValueObject,
                                                                                        $header_mode = 1);
//                        } elseif ($assessmentCycleOption == EmployeeModuleDetailPrintOption::SELECT_ALL_CYCLES) {
//
//                            $assessmentCycleValueObjects = AssessmentCycleService::getValueObjects();
//
//                            foreach($assessmentCycleValueObjects as $assessmentCycleValueObject) {
//                                $total_costs += EmployeePDPCostsPdf::printPdpCostsEmployee( $pdf,
//                                                                                            $employeeId,
//                                                                                            $assessmentCycleValueObject,
//                                                                                            $header_mode = 1);
//                            }
//                        }
                        if ($total_costs > 0) {
                            EmployeePDPCostsPdf::printPdfCostsTotal($pdf,
                                                                    $total_costs);
                        }
                        unset($total_costs);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_TARGET:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        $targetOptionsValueObject   = $optionValueObject->getDetailPrintOptionValueObject($option);
                        $assessmentCycleOption      = $targetOptionsValueObject->getAssessmentCycleOption();

                        $employeeTargetCollections  = EmployeeTargetService::getCollections($employeeId);

                        EmployeeTargetPdf::printTargets($pdf,
                                                        $employeeId,
                                                        $targetOptionsValueObject,
                                                        $assessmentCycleValueObject,
                                                        $employeeTargetCollections);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_FINAL_RESULT:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        $detailOptionsValueObject   = $optionValueObject->getDetailPrintOptionValueObject($option);
                        $assessmentCycleOption      = $detailOptionsValueObject->getAssessmentCycleOption();

                        $printCollection = EmployeeFinalResultService::getPrintCollection(  $employeeId,
                                                                                            $assessmentCycleValueObject,
                                                                                            $assessmentCycleOption);


                        EmployeeFinalResultPdf::printFinalResult(   $pdf,
                                                                    $employeeId,
                                                                    $printCollection);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_360:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        EmployeeThreesixtyPdf::printThreesixty( $pdf,
                                                                $employeeId);
                    }
                    break;
                case EmployeeModulePrintOption::OPTION_SIGNATURE:
                    if ($optionValueObject->selectedModuleOption($option)) {
                        EmployeeSignature::printSignature(  $pdf,
                                                            $employeeId,
                                                            $employeeInfoValueObject);
                    }
                    break;
            }
        }
    }
}

?>
