<?php
require_once('gino/NumberUtils.class.php');
require_once('pdf/objects/common/pdfUtils.inc.php');
require_once('pdf/objects/employee/print_employees_table.php');

require_once('modules/model/service/upload/PhotoContent.class.php');
require_once('application/interface/converter/DateConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeFteConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeContractStateConverter.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeEducationLevelConverter.class.php');

class EmployeeProfilePdf {

    static function printProfile(PdfEmployeeTable $pdf, $employee_id) {
        $pdf->EmployeePageType(PdfEmployeeTable::PAGETYPE_PROFILE);
        $pdf->ActivatePrintHeader();
        $pdf->PageTitle(TXT_UCF('EMPLOYEE_PROFILE')); //139
        $pdf->PageHeaderData($pdf->fillHeader($employee_id));
        $pdf->AddPage();
        if (!empty($employee_id)) {
            // hbd: TODO: optimalisatie queries voor veel medewerkers
            $sql = 'SELECT
                        e.*,
                        STR_TO_DATE(e.employment_date, "%d-%m-%Y") as employment_realdate,
                        d.department,
                        f.function
                    FROM
                        employees e
                        INNER JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        INNER JOIN functions f
                            ON f.ID_F = e.ID_FID
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.ID_E = ' . $employee_id;
            $employeeQuery = BaseQueries::performQuery($sql);
            $get_e = @mysql_fetch_assoc($employeeQuery);


            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
                if (!empty($get_e[foto_thumbnail])) {
                    $employee_photo = new PhotoContent();
                    list($displayable_photo, $dummy_photo_width, $dummy_photo_height) = $employee_photo->getEmployeePrintablePhoto($get_e['foto_thumbnail']);
                    if (!empty($displayable_photo)) {
                        $pdf->Image(CUSTOMER_PHOTO_PATH . $get_e['foto_thumbnail'], 140, 50, 50);
                    }
                }
            }
            $pdf->HR('190', 'T');
            $pdf->SetTextColorHex(COLOR_BLACK);
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
                $pdf->HandleDataRow(TXT_UCF('SOCIAL_NUMBER'), $get_e[SN]); // 158
                $pdf->HandleDataRow(TXT_UCF('GENDER'), TXT_UCF(strtoupper($get_e[sex]))); // 159
                $pdf->HandleDataRow(TXT_UCF('DATE_OF_BIRTH'), $get_e[birthdate]); // 160
                $pdf->HandleDataRow(TXT_UCF('NATIONALITY'), $get_e[nationality]); // 161
                $pdf->HandleDataRow(TXT_UCF('STREET'), $get_e[address]); // 181
                $pdf->HandleDataRow(TXT_UCF('ZIP_CODE'), $get_e[postal_code]); // 182
                $pdf->HandleDataRow(TXT_UCF('CITY'), $get_e[city]); // 183
                $pdf->HandleDataRow(TXT_UCF('TELEPHONE_NUMBER'), $get_e[phone_number]); // 16
            }
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_ORGANISATION)) {
                $pdf->HandleDataRow(TXT_UCF('PHONE_WORK'), $get_e[phone_number_work]); // nieuw 3.0
            }
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
                $pdf->HandleDataRow(TXT_UCF('E_MAIL_ADDRESS'), $get_e[email_address]); // 184
            }
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {
                // hbd: ophalen additionele functies.
                // alleen als er nevenfuncties zijn dit blokje tonen, want het hoofdprofiel staat los ook al in de header.
                $sql = 'SELECT
                            f.function
                        FROM
                            employees_additional_functions eaf
                            INNER JOIN functions f
                                ON f.ID_f = eaf.ID_F
                        WHERE
                            eaf.customer_id = ' . CUSTOMER_ID . '
                            AND eaf.ID_E = ' . $employee_id;
                $get_additional_functions = PdfUtils::getData($sql, true);
                $additional_function_label = TXT_UCF('ADDITIONAL_JOB_PROFILES');
                if (!empty($get_additional_functions)) {
                    $pdf->HandleDataRow(TXT_UCF('MAIN_JOB_PROFILE'), $get_e['function']);
                    foreach ($get_additional_functions as $additional_function_name) {
                        $pdf->HandleDataRow($additional_function_label, $additional_function_name['function']);
                        $additional_function_label = '';
                    }
                }
            }
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_ORGANISATION)) {
                $pdf->HandleDataRow(TXT_UCF('EMPLOYMENT_DATE'), DateConverter::display($get_e[employment_realdate])); // nieuw 3.0
                $pdf->HandleDataRow(TXT_UCF('EMPLOYMENT_PERCENTAGE'), EmployeeFteConverter::display($get_e['employment_FTE'])); // nieuw 3.0
                $pdf->HandleDataRow(TXT_UCF('CONTRACT_STATE'),  EmployeeContractStateConverter::display($get_e['contract_state_fid'])); // nieuw 3.0
            }
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
                $pdf->HandleDataRow(TXT_UCF('EDUCATION_LEVEL'), EmployeeEducationLevelConverter::display($get_e['education_level_fid'])); // nieuw 3.0
            }
            if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_INFORMATION)) {
                $pdf->HandleDataRow(TXT_UCF('ADDITIONAL_INFO'), $get_e[additional_info]); // 174
                if (/*USER_LEVEL <= 3 && */PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_MANAGER_COMMENTS)) {
                    $pdf->HandleDataRow(TXT_UCF('MANAGERS_COMMENTS'), $get_e[hidden_info]); // 176
                }
            }
        } else {
            $pdf->HR('190', 'T');
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 10);
            $pdf->Cell(0, -10, TXT_UCF('NO_EMPLOYEES_RETURN'), 0, 0, 'L'); // 116
        }
    } // END FUNCTION printProfile

}

?>
