<?php

/**
 * Description of DocumentContentQueries
 *
 * @author ben.dokter
 */
class DocumentContentQueries
{
    const ID_FIELD = 'id_contents';

    // ivm performance niet direct de base64 content ophalen
    static function getDocumentContent($i_contentId)
    {
        $sql = 'SELECT
                    id_contents,
                    customer_id,
                    filename,
                    file_extension,
                    contents_size,
                    saved_by_user_id,
                    saved_by_user,
                    saved_datetime,
                    database_datetime
                FROM
                    document_contents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contentId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    // TODO: deze wegrefactoren...
    static function getDocumentContentForCustomer($customerId, $i_contentId)
    {
        $sql = 'SELECT
                    id_contents,
                    customer_id,
                    filename,
                    file_extension,
                    contents_size,
                    saved_by_user_id,
                    saved_by_user,
                    saved_datetime,
                    database_datetime
                FROM
                    document_contents
                WHERE
                    customer_id = ' . $customerId . '
                    AND id_contents = ' . $i_contentId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    // TODO: deze wegrefactoren...
    static function getDocumentContentBase64ForCustomer($customerId, $i_contentId)
    {
        $sql = 'SELECT
                    contentsBase64
                FROM
                    document_contents
                WHERE
                    customer_id = ' . $customerId . '
                    AND id_contents = ' . $i_contentId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }
    static function getDocumentContentBase64($i_contentId)
    {
        $sql = 'SELECT
                    contentsBase64
                FROM
                    document_contents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contentId . '
                LIMIT 1';

        return BaseQueries::performSelectQuery($sql);
    }

    static function insertDocumentContents($s_filename, $s_fileExtension, $s_fileContents, $i_fileSize)
    {
        $savedByUserId = USER_ID;
        $savedByUser   = USER;
        $savedDatetime = MODIFIED_DATETIME;

        $sql = 'INSERT INTO
                    document_contents
                    (   customer_id,
                        filename,
                        file_extension,
                        contentsBase64,
                        contents_size,
                        saved_by_user_id,
                        saved_by_user,
                        saved_datetime,
                        database_datetime
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                       "' . mysql_real_escape_string($s_filename) . '",
                       "' . mysql_real_escape_string($s_fileExtension) . '",
                       "' . base64_encode($s_fileContents) . '",
                        ' . $i_fileSize . ',
                        ' . $savedByUserId . ',
                       "' . mysql_real_escape_string($savedByUser) . '",
                       "' . $savedDatetime . '",
                       NOW()
                    )';

        return BaseQueries::performInsertQuery($sql);
    }

    static function deleteDocumentContent($i_contentId)
    {
        $sql = 'DELETE
                FROM
                    document_contents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contentId . '
               LIMIT 1';

        return BaseQueries::performDeleteQuery($sql);
    }



}

?>
