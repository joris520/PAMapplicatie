<?php

/**
 * Description of EmailMessagesQueries
 *
 * @author hans.prins
 */
class EmailMessagesQueries
{
    static function getEmail360Messages() {

        $sql = 'SELECT
                    *
                FROM
                    notification360_message
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    ID_NM
                LIMIT 2';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateEmail360Message ($i_notificationMessage_id, $s_message) {

        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    notification360_message
                SET
                    message = "' . mysql_real_escape_string($s_message) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_NM = ' . $i_notificationMessage_id;

        return BaseQueries::performUpdateQuery($sql);
    }

    static function getEmailNotificationMessages() {

        $sql = 'SELECT
                    *
                FROM
                    notification_message
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                ORDER BY
                    ID_NM
                LIMIT 2';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateEmailNotificationMessage ($i_notificationMessage_id, $s_message) {

        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    notification_message
                SET
                    message = "' . mysql_real_escape_string($s_message) . '",
                    modified_by_user = "' . $modified_by_user . '",
                    modified_time = "' . $modified_time . '",
                    modified_date = "' . $modified_date . '"
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_NM = ' . $i_notificationMessage_id;

        return BaseQueries::performUpdateQuery($sql);
    }
}

?>
