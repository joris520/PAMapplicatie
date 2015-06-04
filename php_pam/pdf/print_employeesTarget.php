<?php

require_once('pdf/pdf_config.inc.php');
require_once('pdf/employee/EmployeeTargetPdf.class.php');

//require_once('modules/print/option/AssessmentCyclePrintOption.class.php');
require_once('modules/model/service/employee/target/EmployeeTargetService.class.php');
require_once('modules/print/service/employee/EmployeePrintService.class.php');

$pdf = new PdfEmployeeTable();
$pdf->Open();


$employeeIds            = EmployeePrintService::retrieveEmployeeIds();
$printOptionValueObject = EmployeePrintService::retrievePrintOptionValueObject();

EmployeePrintService::clearPrintStore();
//
//if (!empty($employeeIds)) {
//    foreach ((array)$employeeIds as $employeeId) {
//        EmployeeTargetPdf::printTargets($pdf,
//                                        $employeeId,
//                                        $printOptionValueObject);
//    }
//}

$pdf->Output();
?>