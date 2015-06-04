<?php

/**
 * Description of EmployeeAssessmentQueries
 *
 * @author ben.dokter
 */

class EmployeeAssessmentQueries
{
    const ID_FIELD = 'ID_EA';

    static function getAssessmentInPeriod($si_employeeIds, $dt_periodStart, $dt_periodEnd)
    {
        $minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;

        $sql = 'SELECT
                    *
                FROM
                    employee_assessment main
                WHERE
                    main.customer_id = ' . CUSTOMER_ID . '
                    AND main.ID_E IN ( ' . $si_employeeIds . ')
                    AND main.ID_EA = (  SELECT
                                            maxid.ID_EA
                                        FROM
                                            employee_assessment maxid
                                        WHERE
                                            maxid.customer_id = main.customer_id
                                            AND maxid.ID_E = main.ID_E
                                            AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") < 0
                                            ' . $minDateFilter . '
                                        ORDER BY
                                            maxid.saved_datetime DESC
                                        LIMIT 1
                                     )';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getAssessments($i_employeeId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                ORDER BY
                    saved_datetime DESC,
                    ' . self::ID_FIELD . ' DESC';

        return BaseQueries::performSelectQuery($sql);
    }

    static function selectAssessment($i_employeeId, $i_assessmentId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_assessment
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' . $i_employeeId . '
                    AND ID_EA   = ' . $i_assessmentId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertAssessment(   $i_employeeId,
                                        $d_assessmentDate,
                                        $i_scoreStatus,
                                        $s_assessmentNote)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_assessment
                    (   customer_id,
                        ID_E,
                        assessment_date,
                        score_status,
                        assessment_note,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                       "' . mysql_real_escape_string($d_assessmentDate) . '",
                        ' . $i_scoreStatus . ',
                       "' . mysql_real_escape_string($s_assessmentNote) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

}

?>
