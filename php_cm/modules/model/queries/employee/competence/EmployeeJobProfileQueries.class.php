<?php

/**
 * Description of EmployeeJobProfileQueries
 *
 * @author ben.dokter
 */
class EmployeeJobProfileQueries
{

    const ID_FIELD = 'ID_EJP';

    // job profile is altijd geval apart, omdat deze door de periodes heenloopt.
    // wel proberen de laatste op te halen...
//    static function getJobProfile($i_employeeId, $dt_periodStart, $dt_periodEnd)
    static function getJobProfile($i_employeeId, $dt_periodEnd)
    {
        //$minDateFilter = $dt_periodStart == NULL ? '' : 'AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodStart . '") >= 0' ;
        $minDateFilter = '';

        $sql = 'SELECT
                    *
                FROM
                    employee_job_profile ejp
                WHERE
                    ejp.customer_id = ' . CUSTOMER_ID . '
                    AND ejp.ID_E    = ' .  $i_employeeId . '
                    AND ejp.ID_EJP  =   (   SELECT
                                                MAX(maxid.ID_EJP)
                                            FROM
                                                employee_job_profile maxid
                                            WHERE
                                                maxid.customer_id = ejp.customer_id
                                                AND maxid.ID_E = ejp.ID_E
                                                AND DATEDIFF(maxid.saved_datetime, "' . $dt_periodEnd . '") <= 0
                                                ' . $minDateFilter . '
                                        )';

        return BaseQueries::performSelectQuery($sql);

    }

    static function getJobProfiles($i_employeeId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_job_profile
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId . '
                ORDER BY
                    saved_datetime DESC,
                    ' . self::ID_FIELD . ' DESC';

        return BaseQueries::performSelectQuery($sql);

    }
    static function insertJobProfile(   $i_employeeId,
                                        $d_functionDate,
                                        $s_note)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_job_profile
                    (   customer_id,
                        ID_E,
                        function_date,
                        note,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                       "' . mysql_real_escape_string($d_functionDate) . '",
                        ' . BaseQueries::nullableString(mysql_real_escape_string($s_note)) . ',
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////

    static function getMainFunction($i_employeeId)
    {
        $sql = 'SELECT
                    f.*
                FROM
                    functions f
                    INNER JOIN employees e
                        ON e.ID_FID = f.ID_F
                            AND e.ID_E = ' . $i_employeeId . '
                WHERE
                    f.customer_id = ' . CUSTOMER_ID;

        return BaseQueries::performSelectQuery($sql);
    }

    static function getAdditionalFunctions($i_employeeId)
    {
        $sql = 'SELECT
                    f.*
                FROM
                    functions f
                    INNER JOIN employees_additional_functions eaf
                        ON eaf.ID_F = f.ID_F
                            AND eaf.ID_E = ' .  $i_employeeId . '
                WHERE
                    f.customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    f.function';

        return BaseQueries::performSelectQuery($sql);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // om het huidige systeem werkend te houden moet de main functie ook in de employees tabel gezet worden...
    static function updateMainFunctionInEmployeesTable($i_employeeId, $i_functionId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'UPDATE
                    employees
                SET
                    ID_FID = ' . $i_functionId . ',
                    saved_by_user_id = ' . $savedByUserId . ',
                    saved_by_user = "' . mysql_real_escape_string($savedByUser) . '",
                    saved_datetime = "' . $savedDatetime . '",
                    database_datetime = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performUpdateQuery($sql);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // om het huidige systeem werkend te houden moeten de nevenfunctie ook in de employees_additional_functions tabel gezet worden...
    static function deleteFromAdditionalFunctionsTable($i_employeeId)
    {
        $sql = 'DELETE
                FROM
                    employees_additional_functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employeeId;

        return BaseQueries::performDeleteQuery($sql);
    }

    static function insertInAdditionalFunctionsTable($i_employeeId, $i_functionId)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employees_additional_functions
                    (   customer_id,
                        ID_E,
                        ID_F,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employeeId . ',
                        ' . $i_functionId . ',
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

}

?>
