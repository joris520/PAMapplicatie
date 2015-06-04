<?php

/**
 * Description of EmployeeJobProfileFunctionQueries
 *
 * @author ben.dokter
 */
class EmployeeJobProfileFunctionQueries
{

    const ID_FIELD = 'ID_EJPF';

    // functies hangen direct onder een employeeJobProfile, dus kan zonder datum opgehaald
    static function getFunctionsForJobProfile($i_employeeId, $i_jobProfileId)
    {
        $sql = 'SELECT
                    *
                FROM
                    employee_job_profile_function
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E    = ' .  $i_employeeId . '
                    AND ID_EJP  = ' . $i_jobProfileId . '
                ORDER BY
                    is_main_function,
                    `function`';

        return BaseQueries::performSelectQuery($sql);

    }
    static function insertJobProfileFunction($i_employeeId, $i_jobProfileId, $i_functionId, $i_isMainFunction)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    employee_job_profile_function
                    (   customer_id,
                        ID_E,
                        ID_EJP,
                        ID_F,
                        `function`,
                        is_main_function,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    )   SELECT
                            ' . CUSTOMER_ID . ',
                            ' . $i_employeeId . ',
                            ' . $i_jobProfileId . ',
                            ' . $i_functionId . ',
                            function,
                            ' . $i_isMainFunction . ',
                            ' . $savedByUserId . ',
                           "' . mysql_real_escape_string($savedByUser) . '",
                           "' . $savedDatetime . '",
                            NOW()
                        FROM
                            functions
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_F = ' . $i_functionId ;

        return BaseQueries::performInsertQuery($sql);
    }

}

?>
