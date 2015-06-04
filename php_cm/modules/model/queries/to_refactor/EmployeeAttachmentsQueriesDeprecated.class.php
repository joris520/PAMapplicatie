<?php

/**
 * Description of EmployeeAttachmentsQueriesDeprecated
 *
 * @author ben.dokter
 */
class EmployeeAttachmentsQueriesDeprecated {

    static function getEmployeeAttachments($i_employee_id, $i_document_id = null)
    {
        // afhankelijk van het USER_LEVEL van de ingelogde gebruiker
        switch (USER_LEVEL) {
            case UserLevelValue::HR: {
                $authorisation_condition = ' AND ed.level_id_hr = ' . UserLevelValue::HR;
                break;
            }
            case UserLevelValue::MANAGER: {
                $authorisation_condition = ' AND ed.level_id_mgr = '. UserLevelValue::MANAGER;
                break;
            }
            case UserLevelValue::EMPLOYEE_EDIT: {
                $authorisation_condition = ' AND ed.level_id_emp_edit = '. UserLevelValue::EMPLOYEE_EDIT;
                break;
            }
            case UserLevelValue::EMPLOYEE_VIEW: {
                $authorisation_condition = ' AND ed.level_id_emp_view = '. UserLevelValue::EMPLOYEE_VIEW;
                break;
            }
            default:
                $authorisation_condition = '';
        }

        if (!empty($i_document_id)) {
            $filter_document = ' AND ed.ID_EDOC = ' . $i_document_id;
        }

        $sql = 'SELECT
                    dc.document_cluster,
                    ed.*,
                    eae.ID_EDOC as ID_EAEDOC,
                    eae.active
                FROM
                    employees_documents ed
                    LEFT JOIN employee_assessment_evaluation eae
                        ON eae.ID_E = ed.ID_E
                            -- AND eae.active = ' . BaseDatabaseValue::IS_ACTIVE . '
                            AND eae.ID_EDOC = ed.ID_EDOC
                    LEFT JOIN document_clusters dc
                        ON dc.ID_DC = ed.ID_DC
                WHERE
                    ed.customer_id = ' . CUSTOMER_ID . '
                    AND ed.ID_E = ' . $i_employee_id . '
                    AND ed.id_contents IS NOT NULL
                    ' . $authorisation_condition . '
                    ' . $filter_document . '
                ORDER BY
                    CASE
                        WHEN dc.document_cluster is null
                        THEN "zzzzzz"
                        ELSE CASE   WHEN ed.document_type = ' . EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION . '
                                    THEN "yyyyyy"
                             END
                    END,
                    ed.document_name';

        return BaseQueries::performSelectQuery($sql);
    }

    static function updateDocumentInfo($i_employee_id,
                                       $i_document_id,
                                       $i_document_cluster_id,
                                       $i_document_auth_hr,
                                       $i_document_auth_mgr,
                                       $i_document_auth_emp_edit,
                                       $i_document_auth_emp_view,
                                       $s_document_description,
                                       $s_notes)
    {
        $modified_by_user = USER;
        $modified_time = MODIFIED_TIME;
        $modified_date = MODIFIED_DATE;

        $sql = 'UPDATE
                    employees_documents
                SET
                    ID_DC                =  ' . $i_document_cluster_id . ',
                    level_id_hr          =  ' . $i_document_auth_hr  . ',
                    level_id_mgr         =  ' . $i_document_auth_mgr . ',
                    level_id_emp_edit    =  ' . $i_document_auth_emp_edit . ',
                    level_id_emp_view    =  ' . $i_document_auth_emp_view . ',
                    document_description = "' . mysql_real_escape_string($s_document_description) . '",
                    notes                = "' . mysql_real_escape_string($s_notes) . '",
                    modified_by_user     = "' . $modified_by_user . '",
                    modified_time        = "' . $modified_time . '",
                    modified_date        = "' . $modified_date . '",
                    database_datetime    = NOW()
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $i_employee_id . '
                    AND ID_EDOC = ' . $i_document_id . '
                LIMIT 1';
        $sql_result = BaseQueries::performQuery($sql);
        return $sql_result;

    }
}
?>
