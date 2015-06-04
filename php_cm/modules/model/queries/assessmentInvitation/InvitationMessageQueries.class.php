<?php

/**
 * Description of InvitationMessageQueries
 *
 * @author ben.dokter
 */
class InvitationMessageQueries
{
    const ID_FIELD = 'ID_TSIM';

    static function insertInvitationMessage($i_messageType,
                                            $s_messageSubject,
                                            $s_messageFrom,
                                            $s_messageTemplate,
                                            $s_messageLanguageText)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    threesixty_invitations_messages
                    (
                        customer_id,
                        message_type,
                        message_date,
                        message_subject,
                        message_from,
                        message_template,
                        message_lang_txt,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                         ' . CUSTOMER_ID . ',
                         ' . $i_messageType . ',
                        NOW(),
                        "' . mysql_real_escape_string($s_messageSubject) . '",
                        "' . mysql_real_escape_string($s_messageFrom) . '",
                        "' . mysql_real_escape_string($s_messageTemplate) . '",
                        "' . mysql_real_escape_string($s_messageLanguageText) . '",
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function getLastInvitationMessage($s_filterMessageType = null)
    {
        $sql_filterMessageType = empty($s_filterMessageType) ? '' : ' AND message_type in (' . $s_filterMessageType . ')';

        $sql = 'SELECT
                    *
                FROM
                    threesixty_invitations_messages
                WHERE
                    customer_id = ' . CUSTOMER_ID .
                    $sql_filterMessageType . '
                ORDER BY
                    message_type desc,
                    ID_TSIM desc
                LIMIT 1';

        return BaseQueries::performQuery($sql);
    }
}

?>
