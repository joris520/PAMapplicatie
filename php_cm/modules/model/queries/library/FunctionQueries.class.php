<?php

/**
 * Description of FunctionQueries
 *
 * @author ben.dokter
 */
class FunctionQueries
{
    const ID_FIELD = 'ID_F';

    static function getFunctions()
    {
        $sql = 'SELECT
                    *
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                GROUP BY
                    function
                ORDER BY
                    function';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getFunctionById($i_functionId)
    {
        $sql = 'SELECT
                    *
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_F = ' . $i_functionId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function getFunctionsNotUsedByEmployee($i_employeeId)
    {
        // hier moeten alle profielen van de employee uitgesloten worden.
        $sql = 'SELECT
                    ID_F,
                    function
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_F NOT IN (   SELECT
                                            ID_FID
                                        FROM
                                            employees
                                        WHERE
                                            ID_E = ' . $i_employeeId . '
                                    )
                    AND ID_F NOT IN (   SELECT
                                            ID_F
                                        FROM
                                            employees_additional_functions
                                        WHERE
                                            ID_E = ' . $i_employeeId . '
                                    )
                ORDER BY
                    function';

        return BaseQueries::performSelectQuery($sql);
    }
}

?>
