<?php

/**
 * Description of OrganisationInfoQueries
 *
 * @author ben.dokter
 */
class OrganisationInfoQueries
{
    const ID_FIELD = 'customer_id';

    static function getOrganisationInfo()
    {
        $sql = 'SELECT
                    *
                FROM
                    organisation_info
                WHERE
                    customer_id  = ' . CUSTOMER_ID . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateOrganisationInfo($s_infoText)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

            $sql = 'UPDATE
                        organisation_info
                    SET
                        info_text           = "' . mysql_real_escape_string($s_infoText) . '",
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
