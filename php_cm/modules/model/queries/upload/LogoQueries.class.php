<?php

/**
 * Description of LogoQueries
 *
 * @author ben.dokter
 */

require_once('application/model/queries/CustomerQueries.class.php');

class LogoQueries
{
    // deprecated!?!
    static function getCustomerLogoInfo()
    {
        $sql = 'SELECT
                    logo,
                    logo_size_width,
                    logo_size_height,
                    id_contents
                FROM
                    customers
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateCustomerLogoInfo($s_filename, $i_logoWidth, $i_logoHeight, $i_contentId)
    {
        $sql = 'UPDATE
                    customers
                SET
                    logo                = "' . mysql_real_escape_string($s_filename) . '" ,
                    logo_size_width     =  ' . $i_logoWidth . ' ,
                    logo_size_height    =  ' . $i_logoHeight . ' ,
                    id_contents         =  ' . $i_contentId . '
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function clearCustomerLogoInfo()
    {
        $sql = 'UPDATE
                    customers
                SET
                    logo = null,
                    logo_size_width  = null ,
                    logo_size_height = null ,
                    id_contents = null
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                LIMIT 1';

        return BaseQueries::performUpdateQuery($sql);
    }

}

?>
