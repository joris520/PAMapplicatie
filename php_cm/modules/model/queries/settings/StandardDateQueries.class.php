<?php


/**
 * Description of StandardDateQueries
 *
 * @author ben.dokter
 */

class StandardDateQueries
{
    const ID_FIELD = 'customer_id';

    static function getStandardDate()
    {
        $sql = 'SELECT
                    *
                FROM
                    standard_date
                WHERE
                    customer_id  = ' . CUSTOMER_ID . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateStandardDate($d_defaultEndDate)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

            $sql = 'UPDATE
                        standard_date
                    SET
                        default_end_date    = "' . mysql_real_escape_string($d_defaultEndDate) . '",
                        saved_by_user_id    =  ' . $savedByUserId . ',
                        saved_by_user       = "' . mysql_real_escape_string($savedByUser) . '",
                        saved_datetime      = "' . $savedDatetime . '",
                        database_datetime   = NOW()
                    WHERE
                        customer_id = ' . CUSTOMER_ID;

        return BaseQueries::performUpdateQuery($sql);

    }

}

?>