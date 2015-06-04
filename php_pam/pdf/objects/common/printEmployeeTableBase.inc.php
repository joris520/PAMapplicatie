<?php

require_once('pdf/objects/common/printTableBase.inc.php');

class PdfEmployeeTableBase extends PrintTableBase {

    /**
     *
     * @param <type> $employee_id
     * @param <type> $show_function: "boolean"; 1 - show, 0 - hide
     * @return string
     */
    function FillHeader($employee_id, $show_function = 1)
    {
        if (!empty($employee_id)) {
            $sql = 'SELECT
                        e.*,
                        d.department,
                        f.function,
                        b.ID_E boss_id,
                        b.firstname boss_first_name,
                        b.lastname boss_last_name
                    FROM
                        employees e
                        LEFT JOIN department d
                            ON d.ID_DEPT = e.ID_DEPTID
                        LEFT JOIN functions f
                            ON f.ID_F = e.ID_FID
                        LEFT JOIN employees b
                            ON b.ID_E = e.boss_fid
                                AND b.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                    WHERE
                        e.ID_E = ' . $employee_id;
            $sql_get_employee = BaseQueries::performQuery($sql);
            $get_employee_data = @mysql_fetch_assoc($sql_get_employee);
        } else {
            $get_employee_data = null;
        }
        // header data bepalen
        if (!empty($get_employee_data)) {
            $header_data = array();
            $max_header_data = 5; // hoeveel elementen in header_data, ivm opvulling lege ruimte bovenin pagina

            /* 195, 22, 23 */
            $header_data[]=array(TXT_UCF('EMPLOYEE_NAME') . ': ', ModuleUtils::EmployeeName($get_employee_data['firstname'], $get_employee_data['lastname']));
            $header_data[]=array(TXT_UCF('DEPARTMENT') .    ': ', $get_employee_data['department']);
            if (!empty($get_employee_data['boss_id'])) {
                $header_data[] = array(TXT_UCF('BOSS') .    ': ', ModuleUtils::BossName($get_employee_data['boss_first_name'], $get_employee_data['boss_last_name']));
            }
            if ($show_function == 1 && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {
                $header_data[] = array(TXT_UCF('MAIN_JOB_PROFILE') .   ': ', ($get_employee_data['function']));
            }

            // opvullen met dummy regels ivm te reserveren ruimte header en logo
            while (count($header_data) < $max_header_data) {
                $header_data[] = array(' ', ' ');
            }

        }
        return $header_data;
    }


    // hbd: dataheader niet van toepassing op de meeste employee prints
//    function DataHeader() {}
}

?>
