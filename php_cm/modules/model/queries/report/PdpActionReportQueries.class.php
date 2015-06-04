<?php

/**
 * Description of PdpActionReportQueries
 *
 * @author ben.dokter
 */

class PdpActionReportQueries
{
    static function getPdpActionCount(  $s_allowedEmployeeIds,
                                        $dt_periodStart,
                                        $dt_periodEnd)
    {

        // letop: count(e.ID_E) is gelijk aan het aantal pdp acties omdat de telling over de epa gaat.
        // door de e.ID_E te tellen krijg je wel het aantal medewerkers zonder pdp actie
        // want (count(epa.ID_PDPEA) as pdp_action_count geeft alleen de telling over bestaande pdp acties
        $sql = 'SELECT
                    if (epa.ID_PDPEA is NULL,
                        ' . PdpActionCompletedStatusValue::NO_PDP_ACTION . ',
                        IF(DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), CURDATE())  < 0,
                            IF(epa.is_completed = ' . PdpActionCompletedStatusValue::NOT_COMPLETED . ',' . PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED . ',epa.is_completed),
                            epa.is_completed)) as completed_status,
                    COUNT(e.ID_E) AS status_count,
                    count(distinct(e.ID_E)) as unique_employees
                FROM
                    employees e
                    LEFT JOIN employees_pdp_actions epa
                        ON epa.ID_E = e.ID_E
                            AND DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), "' . $dt_periodEnd . '")  < 0
                            AND DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), "' . $dt_periodStart . '") >= 0
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
                GROUP BY
                    epa.is_completed,
                    if (epa.ID_PDPEA is NULL,
                        ' . PdpActionCompletedStatusValue::NO_PDP_ACTION . ',
                        IF(DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), CURDATE()) < 0,
                            IF(epa.is_completed = ' . PdpActionCompletedStatusValue::NOT_COMPLETED . ',' . PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED . ', epa.is_completed),
                            epa.is_completed))';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getEmployeesWithCompletedStatus($i_completedStatus,
                                                    $s_allowedEmployeeIds,
                                                    $dt_periodStart,
                                                    $dt_periodEnd)
    {

        // letop: count(e.ID_E) is gelijk aan het aantal pdp acties omdat de telling over de epa gaat.
        // door de e.ID_E te tellen krijg je wel het aantal medewerkers zonder pdp actie
        // want (count(epa.ID_PDPEA) as pdp_action_count geeft alleen de telling over bestaande pdp acties
        $sql = 'SELECT
                    e.ID_E,
                    count(epa.ID_PDPEA) as pdp_action_count
                FROM
                    employees e
                    LEFT JOIN employees_pdp_actions epa
                        ON epa.ID_E = e.ID_E
                            AND DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), "' . $dt_periodEnd . '")  < 0
                            AND DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), "' . $dt_periodStart . '") >= 0
                WHERE
                    e.customer_id = ' . CUSTOMER_ID . '
                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
                    AND if (epa.ID_PDPEA is NULL,
                        ' . PdpActionCompletedStatusValue::NO_PDP_ACTION . ',
                        IF(DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), CURDATE())  < 0,
                            IF(epa.is_completed = ' . PdpActionCompletedStatusValue::NOT_COMPLETED . ',' . PdpActionCompletedStatusValue::NOT_COMPLETED_EXPIRED . ',epa.is_completed),
                            epa.is_completed)) = ' . $i_completedStatus . '
                GROUP BY
                    e.ID_E';

        return BaseQueries::performSelectQuery($sql);
    }
//    static function getEmployeePdpActionCount(  $s_allowedEmployeeIds,
//                                                $dt_periodStart,
//                                                $dt_periodEnd)
//    {
//
//        $sql = 'SELECT
//                    is_completed,
//                    if(DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), CURDATE())  < 0,1,2),
//                    count(epa.ID_PDPEA) as pdp_action_count
//                FROM
//                    employees e
//                    LEFT JOIN employees_pdp_actions epa
//                        ON e.ID_E = epa.ID_E
//                WHERE
//                    e.customer_id = ' . CUSTOMER_ID . '
//                    AND e.ID_E IN (' . $s_allowedEmployeeIds . ')
//                    AND DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), "' . $dt_periodEnd . '")  < 0
//                    AND DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), "' . $dt_periodStart . '") >= 0
//                GROUP BY
//                    epa.is_completed,
//                    if(DATEDIFF(STR_TO_DATE(epa.end_date, "%d-%m-%Y"), CURDATE())  < 0,1,2)';
//
//        return BaseQueries::performSelectQuery($sql);
//    }

}

?>
