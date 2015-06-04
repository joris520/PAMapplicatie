<?php

/**
 * Description of EmailAddressesQueries
 *
 * @author hans.prins
 */
class EmailAddressesQueries
{
    static function getExternalEmailAddresses() {

        // TODO: tabel naam "ext" verduidelijken!!
        $sql = 'SELECT
                    ext.ID_EXT,
                    pd.email,
                    pd.lastname,
                    pd.firstname
                FROM
                    ext
                    LEFT JOIN person_data pd
                        ON ext.ID_PD = pd.ID_PD
                WHERE
                    pd.customer_id = ' . CUSTOMER_ID . '
                    AND pd.ID_EC <> ' . ID_EC_INTERNAL . '
                ORDER BY
                    pd.lastname,
                    pd.firstname';

        $emailQuery = BaseQueries::performSelectQuery($sql);

        return $emailQuery;

    }
}

?>
