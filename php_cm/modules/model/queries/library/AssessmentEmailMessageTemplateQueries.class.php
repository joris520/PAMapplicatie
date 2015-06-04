<?php

/**
 * Description of AssessmentEmailMessageQueries
 *
 * @author ben.dokter
 */
class AssessmentEmailMessageTemplateQueries
{
    static function getNotificationMessages()
    {
        $sql = 'SELECT
                    message
                FROM
                    notification360_message
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    ID_NM';

        return BaseQueries::performSelectQuery($sql);
    }

}

?>
