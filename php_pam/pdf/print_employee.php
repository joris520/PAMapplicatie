<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/objects/employee/print_employees_table.php');

require_once('pdf/employee/EmployeeAttachmentsPdf.class.php');
require_once('pdf/employee/EmployeeProfilePdf.class.php');
require_once('pdf/employee/EmployeeScorePdf.class.php');
require_once('pdf/employee/EmployeePDPActionPdf.class.php');
require_once('pdf/employee/EmployeePDPCostsPdf.class.php');
require_once('pdf/employee/EmployeeTargetPdf.class.php');
require_once('pdf/employee/EmployeeThreesixtyPdf.class.php');

require_once('application/model/value/BooleanValue.class.php');

require_once('modules/print/service/employee/EmployeePrintService.class.php');
require_once('modules/print/valueobjects/employee/EmployeePrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeCompetenceDetailPrintOptionValueObject.class.php');
require_once('modules/print/valueobjects/employee/EmployeeAssessmentCycleDetailPrintOptionValueObject.class.php');

require_once('modules/print/valueobjects/employee/EmployeePrintOptionValueObject.class.php');
require_once('modules/print/pdf/employee/EmployeePortfolioPdf.class.php');


// TODO: via CLASS!!
if (EmployeePrintService::isPrintAllowed()) {
    $optionValueObject = EmployeePrintService::retrievePrintOptionValueObject();
    EmployeePrintService::clearPrintStore();

    if (!empty($optionValueObject)) {
        // de employeeId zit in het optionValueObject
        $employeeIds        = $optionValueObject->getEmployeeIds();
        $assessmentCycle    = $optionValueObject->getAssessmentCycleValueObject();

        $portfolioPdf = EmployeePortfolioPdf::create($optionValueObject);

        $portfolioPdf->openPdf();
        foreach($employeeIds as $employeeId) {
            $portfolioPdf->resetPageCount();
            $portfolioPdf->generatePdf($employeeId, $assessmentCycle);
        }
        $portfolioPdf->outputPdf();
    }
}
?>