<?php

    require_once('pdf/pdf_config.inc.php');
    require_once('pdf/objects/performance_grid_table.php');

    require_once('modules/model/service/to_refactor/DepartmentsService.class.php');
    require_once('modules/model/service/to_refactor/FunctionsServiceDeprecated.class.php');
    require_once('modules/model/service/to_refactor/EmployeesService.class.php');


    // TODO: via sessie doorgeven en sessie daarna clearen
    $id_f = $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['functionId'];
    $id_dept = $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['departmentIdd'];
    $departmentName = $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['departmentName'];
    $employees = explode(',',$_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['employees']);
    $functionName = $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['functionName'];
    $c = $_SESSION[SESSION_PERFORMANCE_GRID_PRINT]['choice'];

    unset($_SESSION[SESSION_PERFORMANCE_GRID_PRINT]);


    function getStatusImage($employee_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    employees_objective_period
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $employee_id . '
                ORDER BY
                    STR_TO_DATE(end_date, "%d-%m-%Y") DESC';
        $get_eop_stat_query = BaseQueries::performQuery($sql);

        $get_eop_stat = @mysql_fetch_assoc($get_eop_stat_query);
        if ($get_eop_stat['target_status'] == 1) {
            $imgStatus = 'dot_red';
        } elseif ($get_eop_stat['target_status'] == 2) {
            $imgStatus = 'dot_green';
        } elseif ($get_eop_stat['target_status'] == 3) {
            $imgStatus = 'dot_yellow';
        } else {
            $imgStatus = 'dot_white';
        }
        return $imgStatus;
    }


/* TODO
 * sdj: deze mag nog wel gerefactored worden
 *
 * m.n. het berekenen van de positie van de stip in het raster gebeurd
 * keer op keer opnieuw en mogelijk soms net iets anders
 *
 */
    $pdf = new PdfPerformanceGridTable();
    $pdf->PageTitle(TXT_UCF('PERFORMANCE_GRID'));
    $pageheaders = array();
    $pageheaders[] = array(TXT_UCF('DATE') . ' :', date('d-m-Y', time()));
    if (!empty($departmentName)) {
        $pageheaders[] = array(TXT_UCF('DEPARTMENT') . ' :', $departmentName);
    }
    if (!empty($functionName)) {
        $pageheaders[] = array(TXT_UCF('JOB_PROFILE') . ' :', $functionName);
    }
    $pdf->PageHeaderData($pageheaders);

    $pdf->Open();

    $array_cross_score = $employees;

    $pdf->AddPage();
    $pdf->Ln(1);

    if (LANG_ID == 1) {
        $pdf->Image('../images/performance_grid.gif', 73, 29, 131, 134);
        $pdf->Image('../images/pg_legend.gif', 80, 165, '120');
    } elseif (LANG_ID == 2) {
        $pdf->Image('../images/performance_grid_dutch.gif', 73, 29, 131, 134);
        $pdf->Image('../images/pg_legend_dutch.gif', 80, 165, '120');
    }

    //=========== PERFORM SINGLE EMPLOYEE PRINT
    foreach ($array_cross_score as $employee_id) {
        if (!empty($employee_id)) {
            //DISPLAY HERE
            $pdf->Ln(1);

            $employeeName = EmployeeProfileServiceDeprecated::getEmployeeName($employee_id);

            // initialize/reset
            $tot = '';
            $wtot = '';
            $tot2 = '';
            $wtot2 = '';
            $vtot = '';
            $htot = '';
            $hwtot = '';
            $htot2 = '';
            $hwtot2 = '';
    //        $r_vtot = '';
    //        $r_htot = '';
    //        $horizontal = '';
    //        $vertical = '';
            $mtot = '';
            $mwtot = '';
            $mtot2 = '';
            $mwtot2 = '';
            $mvtot = '';
    //        $real_tot = '';


            //GET THE CALCULATIONS
            //
            //GET PERSONAL COMPUTATION
            $sql = 'SELECT
                        e.employee,
                        ep.id_ksp,
                        CASE WHEN ep.scale = "N"
                            THEN 1
                            WHEN ep.scale = "Y"
                            THEN 5
                            ELSE ep.scale
                        END AS scale,
                        ksp.knowledge_skill_point,
                        ks.knowledge_skill,
                        ks.axes,
                        fp.scale as norm,
                        fp.weight_factor
                    FROM
                        employees e
                        INNER JOIN employees_points ep
                            ON ep.ID_E = e.ID_E
                        INNER JOIN knowledge_skills_points ksp
                            ON ksp.ID_KSP = ep.ID_KSP
                        INNER JOIN function_points fp
                            ON fp.ID_KSP = ksp.ID_KSP
                                AND fp.ID_F = e.ID_FID
                        INNER JOIN knowledge_skill ks
                            ON ks.ID_KS = ksp.ID_KS
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . $employee_id . '
                        AND ks.ID_KS = ' . CategoryValue::PERSONAL_ID . '
                        AND ep.scale <> ""
                    ORDER BY
                        ks.knowledge_skill';

            $get_v = BaseQueries::performQuery($sql);
            //GET MANAGERIAL COMPUTATION
            $sql = 'SELECT
                        e.employee,
                        ep.id_ksp,
                        CASE WHEN ep.scale = "N"
                            THEN 1
                            WHEN ep.scale = "Y"
                            THEN 5
                            ELSE ep.scale
                        END AS scale,
                        ksp.knowledge_skill_point,
                        ks.knowledge_skill,
                        ks.axes,
                        fp.scale as norm,
                        fp.weight_factor
                    FROM
                        employees e
                        INNER JOIN employees_points ep
                            ON ep.ID_E = e.ID_E
                        INNER JOIN knowledge_skills_points ksp
                            ON ksp.ID_KSP = ep.ID_KSP
                        INNER JOIN function_points fp
                            ON fp.ID_KSP = ksp.ID_KSP
                                AND fp.ID_F = e.ID_FID
                        INNER JOIN knowledge_skill ks
                            ON ks.ID_KS = ksp.ID_KS
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . $employee_id . '
                        AND ks.ID_KS = ' . CategoryValue::MANAGERIAL_ID . '
                        AND ep.scale <> ""
                    ORDER BY
                        ks.knowledge_skill';
            $get_m = BaseQueries::performQuery($sql);

            //PERSONAL
            if (@mysql_num_rows($get_v) > 0) {
                while ($v_row = @mysql_fetch_assoc($get_v)) {
                    $tot = $v_row[scale] * $v_row[weight_factor];
                    $wtot = $v_row[weight_factor] * 5;
                    $tot2 += $tot;
                    $wtot2 += $wtot;
                }
                $vtot = $tot2 / $wtot2;
            }
            //end PERSONAL
            //MANAGERIAL
            if (@mysql_num_rows($get_m) > 0) {
                while ($m_row = @mysql_fetch_assoc($get_m)) {
                    $mtot = $m_row[scale] * $m_row[weight_factor];
                    $mwtot = $m_row[weight_factor] * 5;
                    $mtot2 += $mtot;
                    $mwtot2 += $mwtot;
                }
                $mvtot = $mtot2 / $mwtot2;
            }
            //end MANAGERIAL
            $real_tot = ($vtot + $mvtot) / 2;

            //get horizontal axe
            $sql = 'SELECT
                        e.employee,
                        ep.id_ksp,
                        CASE WHEN ep.scale = "N"
                            THEN 1
                            WHEN ep.scale = "Y"
                            THEN 5
                            ELSE ep.scale
                        END AS scale,
                        ksp.knowledge_skill_point,
                        ks.knowledge_skill,
                        ks.axes,
                        fp.scale as norm,
                        fp.weight_factor
                    FROM
                        employees e
                        INNER JOIN employees_points ep
                            ON ep.ID_E = e.ID_E
                        INNER JOIN knowledge_skills_points ksp
                            ON ksp.ID_KSP = ep.ID_KSP
                        INNER JOIN function_points fp
                            ON fp.ID_KSP = ksp.ID_KSP
                                AND fp.ID_F = e.ID_FID
                        INNER JOIN knowledge_skill ks
                            ON ks.ID_KS = ksp.ID_KS
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . $employee_id . '
                        AND ks.axes = 2
                        AND ep.scale <> ""
                    ORDER BY
                        ks.knowledge_skill';
            $get_h = BaseQueries::performQuery($sql);

            if (@mysql_num_rows($get_h) > 0) {
                while ($h_row = @mysql_fetch_assoc($get_h)) {
                    $htot = $h_row[scale] * $h_row[weight_factor];
                    $hwtot = $h_row[weight_factor] * 5;
                    $htot2 += $htot;
                    $hwtot2 += $hwtot;
                }
                $htot = $htot2 / $hwtot2;
            }
            $r_vtot = ceil($real_tot * 100);
            $r_htot = ceil($htot * 100);

            //$r_vtot = ceil($vtot * 100);
            //$r_htot = ceil($htot * 100);
            $min_h = 87;
            //$max_h = 185;

            //$min_v = 46;
            $max_v = 146;

            $horizontal = $min_h + $r_htot;
            $vertical = $max_v - $r_vtot;

            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(-6);
            $pdf->SetWidths(array(19.5, 50));
            $pdf->SingleRow('1', '', array('' . $employee_id . '', ' ' . $employeeName . ' (' . ceil($vtot * 100) . '-' . ceil($mvtot * 100) . ') ' . $r_vtot . ',' . $r_htot . ''));
            $pdf->Ln(4);

            $ivertic = $vertical - 1;
            $pdf->SetFont('Arial', '', 7);
            $pdf->Text($horizontal, $ivertic, $employee_id);

            //calculate eval period and target
            $sql = 'SELECT
                        e.employee,
                        CASE WHEN eop.target_status is null
                                THEN 0
                                ELSE eop.target_status
                        END AS target_status,
                        CASE WHEN eo.objective_status is null
                                THEN 0
                                ELSE eo.objective_status
                        END as objective_status
                    FROM
                        employees e
                        INNER JOIN employees_objective_period eop
                            ON eop.ID_E = e.ID_E
                        LEFT JOIN employees_objectives eo
                            ON eo.ID_EOBJP = eop.ID_EOP
                    WHERE
                        e.customer_id = ' . CUSTOMER_ID . '
                        AND e.is_inactive = ' . EMPLOYEE_IS_ACTIVE . '
                        AND e.ID_E = ' . $employee_id;
            $getS = BaseQueries::performQuery($sql);
            if (@mysql_num_rows($getS) == 0) {
                $imgStatus = 'dot_white';
            } else {
                while ($imgS = @mysql_fetch_assoc($getS)) {
                    $os = $imgS[target_status];
                    //$pdf->Ln(6); $pdf->SetWidths(array(30)); $pdf->SingleRow('1', '', array('OS '.$os));
                    $oS += $os;
                }
                // TODO: hbd: score lijkt niet gebruikt. is de query hierboven dan wel nodig?
                $score = floor($oS / @mysql_num_rows($getS));
                $imgStatus = getStatusImage($employee_id);
            }
            $oS = 0;
            //end calculate eval period and target

            $pdf->Image('../images/' . $imgStatus . '.gif', $horizontal, $vertical, 2);
            // TODO: dit moet eigenlijk in de newPage functionaliteit van de print class
            if ($pdf->GetY() > 250) {
                $pdf->AddPage();
                $pdf->Ln(10);
                $pdf->HR('190', 'T');

                if (LANG_ID == 1) {
                    $pdf->Image('../images/performance_grid.gif', 73, 29, 131, 134);
                    $pdf->Image('../images/pg_legend.gif', 80, 165, '120');
                } elseif (LANG_ID == 2) {
                    $pdf->Image('../images/performance_grid_dutch.gif', 73, 29, 131, 134);
                    $pdf->Image('../images/pg_legend_dutch.gif', 80, 165, '120');
                }
            }
        }
    }

    $pdf->Output();

?>