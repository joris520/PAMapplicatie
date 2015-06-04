<?php

/**
 * Description of EmployeeSignature
 *
 * @author hans.prins
 */

class EmployeeSignature
{
    static function printSignature( PdfEmployeeTable $pdf,
                                    $employeeId,
                                    EmployeeInfoValueObject $employeeInfoValueObject)
    {
        $pdf->PageTitle(TXT_UCF('PRINT_SIGNATURE_FORM'));
        $pdf->ActivatePrintHeader();
        $pdf->ActivateDataHeader(0);

        $employeeName   = $employeeInfoValueObject->getEmployeeName();
        $bossName       = $employeeInfoValueObject->getBossName();

        $pdf->PageHeaderData($pdf->FillHeader($employeeId));
        $pdf->AddPage();

        $signature_line = '...........................................';

        $pdf->Ln(10);
        $pdf->SetWidths(array(100, 100));

        $pdf->SingleRow('', '', array(TXT_UCF('DATE') . ':', TXT_UCF('DATE') . ':'));
        $pdf->ln(10);
        $pdf->SingleRow('', '', array($signature_line,  $signature_line));
        $pdf->Ln(20);
        $pdf->SingleRow('', '', array(TXT_UCF('SIGNATURE_MANAGER') . ':', TXT_UCF('SIGNATURE_EMPLOYEE') . ':'));
        $pdf->ln(15);
        $pdf->SingleRow('', '', array($signature_line,  $signature_line));
        $pdf->SingleRow('', '', array($bossName, $employeeName));
    }
}

?>
