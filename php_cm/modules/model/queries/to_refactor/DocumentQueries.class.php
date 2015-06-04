<?php

/**
 * Description of DocumentQueries
 *
 * @author ben.dokter
 */

require_once('gino/BaseQueries.class.php');

class DocumentQueries
{

    static function insertDocumentContents($s_filename, $s_file_extension, $s_file_contents, $i_file_size)
    {
        $sql = 'INSERT INTO
                    document_contents
                    (   customer_id,
                        filename,
                        file_extension,
                        contentsBase64,
                        contents_size
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        "' . mysql_real_escape_string($s_filename) . '",
                        "' . mysql_real_escape_string($s_file_extension) . '",
                        "' . base64_encode($s_file_contents) . '",
                        ' . $i_file_size . '
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();
    }


    static function insertEmployeeDocument($i_employee_id, $i_document_type, $i_document_cluster_id, $i_contents_id,
                                           $i_document_auth_hr, $i_document_auth_mgr, $i_document_auth_emp_edit, $i_document_auth_emp_view,
                                           $s_document_pad, $s_document_name, $s_document_description, $s_notes,
                                           $s_modified_time, $s_modified_date)
    {
        $sql = 'INSERT INTO
                    employees_documents
                    (   `customer_id`,
                        `ID_E`,
                        `document_type`,
                        `ID_DC`,
                        `id_contents`,
                        `level_id_hr`,
                        `level_id_mgr`,
                        `level_id_emp_edit`,
                        `level_id_emp_view`,
                        `document_pad`,
                        `document_name`,
                        `document_description`,
                        `notes`,
                        `modified_by_user`,
                        `modified_time`,
                        `modified_date`,
                        `database_datetime`
                    ) VALUES (
                        ' . CUSTOMER_ID . ',
                        ' . $i_employee_id . ',
                        ' . $i_document_type . ',
                        ' . $i_document_cluster_id . ',
                        ' . $i_contents_id . ',
                        ' . $i_document_auth_hr  . ',
                        ' . $i_document_auth_mgr . ',
                        ' . $i_document_auth_emp_edit . ',
                        ' . $i_document_auth_emp_view . ',
                        "' . mysql_real_escape_string($s_document_pad) . '",
                        "' . mysql_real_escape_string($s_document_name) . '",
                        "' . mysql_real_escape_string($s_document_description) . '",
                        "' . mysql_real_escape_string($s_notes) . '",
                        "Added by: ' . USER . '",
                        "' . $s_modified_time . '",
                        "' . $s_modified_date . '",
                        NOW()
                    )';

        BaseQueries::performQuery($sql);
        return @mysql_insert_id();

    }

    static function getDocumentFileUseCount($s_document_path)
    {
        $sql = 'SELECT
                    count(ID_EDOC) as found
                FROM
                    employees_documents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND document_pad  = "' . mysql_real_escape_string($s_document_path) . '"';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getDocumentContentUseCount($i_contents_id)
    {
        $sql = 'SELECT
                    count(id_contents) as found
                FROM
                    employees_documents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contents_id;

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEmployeeDocumentContentInfo($i_document_id, $i_employee_id)
    {
        $sql = 'SELECT
                    document_pad,
                    id_contents
                FROM
                    employees_documents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_EDOC=' . $i_document_id . '
                    AND ID_E = ' . $i_employee_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function deleteEmployeeDocuments($i_document_id, $i_employee_id)
    {
        $sql = 'DELETE
                FROM
                    employees_documents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_EDOC = ' . $i_document_id . '
                    AND ID_E = ' . $i_employee_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function deleteDocumentContent($i_contents_id)
    {
        $sql = 'DELETE
                FROM
                    document_contents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contents_id . '
               LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getDocumentContent($i_contents_id)
    {
        $sql = 'SELECT
                    *
                FROM
                    document_contents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contents_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getDocumentContentInfo($i_contents_id)
    {
        $sql = 'SELECT
                    id_contents,
                    filename,
                    file_extension,
                    contents_size
                FROM
                    document_contents
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND id_contents = ' . $i_contents_id . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;

    }

    static function getUserLevelFilter() {
        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN) {
            return '';
        } else {
            $result = ' AND ';
            switch (USER_LEVEL) {
                case UserLevelValue::HR:
                    $result .= 'ed.level_id_hr = ' . USER_LEVEL;
                    break;
                case UserLevelValue::MANAGER:
                    $result .= 'ed.level_id_mgr = ' . USER_LEVEL;
                    break;
                case UserLevelValue::EMPLOYEE_EDIT:
                    $result .= 'ed.level_id_emp_edit = ' . USER_LEVEL;
                    break;
                case UserLevelValue::EMPLOYEE_VIEW:
                    $result .= 'ed.level_id_emp_view = ' . USER_LEVEL;
                    break;
                default:
                    $result .= 'AND'; // Query met opzet laten foutgaan om inbreuk tegen te gaan.
                    break;
            }

            return $result;
        }
    }

    static function getEmployeesDocumentContent($i_id_contents, $i_employee_id)
    {
        $user_level_filter = DocumentQueries::getUserLevelFilter();

        $sql = 'SELECT
                    ed.document_name,
                    dc.filename,
                    dc.file_extension,
                    dc.contents_size,
                    dc.contentsBase64
                FROM
                    employees_documents ed
                    INNER JOIN document_contents dc
                        ON (ed.id_contents = dc.id_contents
                            AND ed.customer_id = dc.customer_id)
                WHERE
                    ed.customer_id = ' . CUSTOMER_ID . '
                    AND ed.id_e = ' . $i_employee_id . '
                    AND ed.id_contents = ' . $i_id_contents . '
                    ' . $user_level_filter . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }

    static function getEmployeesDocumentInfo($i_document_id, $i_employee_id)
    {
        $user_level_filter = DocumentQueries::getUserLevelFilter();

        $sql = 'SELECT
                    ed.document_name,
                    ed.id_contents,
                    ed.document_pad
                FROM
                    employees_documents ed
                WHERE
                    ed.customer_id = ' . CUSTOMER_ID . '
                    AND ed.id_e = ' . $i_employee_id . '
                    AND ed.id_edoc = ' . $i_document_id . '
                    ' . $user_level_filter . '
                LIMIT 1';

        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;
    }
}
?>
