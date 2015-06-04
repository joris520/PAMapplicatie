<?php

/**
 * Description of TargetReportQueries
 *
 * @author ben.dokter
 */

class TargetReportQueries
{

    static function getTargetCount( $s_allowedEmployeeIds,
                                    $dt_periodStart,
                                    $dt_periodEnd)
    {
        // letop: count(e.ID_E) is gelijk aan het aantal targets omdat de telling over de et gaat.
        // door de distinct e.ID_E te tellen krijg je wel het aantal medewerkers zonder target
        // want anders krijg je de telling over de targets bij een employee

        $sql = 'SELECT
                    count(e.ID_E) as status_count,
                    count(distinct(e.ID_E)) as unique_employees,
                    if (etd.ID_ETD is NULL, 0, 1) as has_target,
                    if (etd.ID_ETD is NULL,
                        ' . EmployeeTargetStatusValue::NO_TARGET . ',
                        if (etd.status is NULL,
                            if(DATEDIFF(etd.end_date, CURDATE())  < 0,
                            ' . EmployeeTargetStatusValue::NO_STATUS_EXPIRED . ',
                            ' . EmployeeTargetStatusValue::NO_STATUS . '),
                        etd.status)) as target_status
                FROM
                    employees e
                    LEFT JOIN employee_target_data etd
                        ON etd.ID_E = e.ID_E
                            AND etd.ID_ETD =    (   SELECT
                                                        MAX(maxid_etd.ID_ETD)
                                                    FROM
                                                        employee_target_data maxid_etd
                                                        INNER JOIN employee_target et
                                                            ON maxid_etd.ID_ET = et.ID_ET
                                                                AND et.active = ' . BaseDatabaseValue::IS_ACTIVE . '
                                                    WHERE
                                                        maxid_etd.ID_ET = etd.ID_ET
                                                        AND DATEDIFF(maxid_etd.end_date, "' . $dt_periodEnd . '")  < 0
                                                        AND DATEDIFF(maxid_etd.end_date, "' . $dt_periodStart . '") >= 0
                                                )
                WHERE
                    e.customer_id  = ' . CUSTOMER_ID . '
                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
                GROUP BY
                    if (etd.ID_ETD is NULL,
                        ' . EmployeeTargetStatusValue::NO_TARGET . ',
                        if (etd.status is NULL,
                            if(DATEDIFF(etd.end_date, CURDATE())  < 0,
                            ' . EmployeeTargetStatusValue::NO_STATUS_EXPIRED . ',
                            ' . EmployeeTargetStatusValue::NO_STATUS . '),
                        etd.status))';

        return BaseQueries::performSelectQuery($sql);
    }


    static function getEmployeesWithTargetStatus(   $i_targetStatus,
                                                    $s_allowedEmployeeIds,
                                                    $dt_periodStart,
                                                    $dt_periodEnd)
    {
        $sql = 'SELECT
                    e.ID_E,
                    count(etd.ID_ETD) as target_count
                FROM
                    employees e
                    LEFT JOIN employee_target_data etd
                        ON etd.ID_E = e.ID_E
                            AND etd.ID_ETD =    (   SELECT
                                                        MAX(maxid_etd.ID_ETD)
                                                    FROM
                                                        employee_target_data maxid_etd
                                                        INNER JOIN employee_target et
                                                            ON maxid_etd.ID_ET = et.ID_ET
                                                                AND et.active = ' . BaseDatabaseValue::IS_ACTIVE . '
                                                    WHERE
                                                        maxid_etd.ID_ET = etd.ID_ET
                                                        AND DATEDIFF(maxid_etd.end_date, "' . $dt_periodEnd . '")  < 0
                                                        AND DATEDIFF(maxid_etd.end_date, "' . $dt_periodStart . '") >= 0
                                                )
                WHERE
                    e.customer_id  = ' . CUSTOMER_ID . '
                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
                    AND if (etd.ID_ETD is NULL,
                        ' . EmployeeTargetStatusValue::NO_TARGET . ',
                        if (etd.status is NULL,
                            if(DATEDIFF(etd.end_date, CURDATE())  < 0,
                            ' . EmployeeTargetStatusValue::NO_STATUS_EXPIRED . ',
                            ' . EmployeeTargetStatusValue::NO_STATUS . '),
                        etd.status)) = ' . $i_targetStatus . '
                GROUP BY
                    e.ID_E';

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
