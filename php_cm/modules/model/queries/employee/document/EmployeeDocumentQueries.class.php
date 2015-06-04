<?php

/**
 * Description of EmployeeDocumentQueries
 *
 * @author ben.dokter
 */

class EmployeeDocumentQueries
{
    const ID_FIELD = 'ID_EDOC';

    static function getEmployeeDocuments(   $i_employeeId,
                                            $i_employeeDocumentId = NULL)
    {
        // afhankelijk van het USER_LEVEL van de ingelogde gebruiker
        switch (USER_LEVEL) {
            case UserLevelValue::HR: {
                $sql_authorisationCondition = ' AND ed.level_id_hr = ' . UserLevelValue::HR;
                break;
            }
            case UserLevelValue::MANAGER: {
                $sql_authorisationCondition = ' AND ed.level_id_mgr = '. UserLevelValue::MANAGER;
                break;
            }
            case UserLevelValue::EMPLOYEE_EDIT: {
                $sql_authorisationCondition = ' AND ed.level_id_emp_edit = '. UserLevelValue::EMPLOYEE_EDIT;
                break;
            }
            case UserLevelValue::EMPLOYEE_VIEW: {
                $sql_authorisationCondition = ' AND ed.level_id_emp_view = '. UserLevelValue::EMPLOYEE_VIEW;
                break;
            }
            default:
                $sql_authorisationCondition = '';
        }

        if (!empty($i_employeeDocumentId)) {
            $sql_filterDocument = ' AND ed.ID_EDOC = ' . $i_employeeDocumentId;
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
                    AND ed.ID_E = ' . $i_employeeId . '
                    AND ed.id_contents IS NOT NULL
                    ' . $sql_authorisationCondition . '
                    ' . $sql_filterDocument . '
                ORDER BY
                    CASE
                        WHEN dc.document_cluster is null
                        THEN "zzzzzz"
                        ELSE CASE   WHEN ed.document_type = ' . EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION . '
                                    THEN "yyyyyy"
                                    ELSE document_cluster
                             END
                    END,
                    ed.document_name';

        return BaseQueries::performSelectQuery($sql);
    }


}

?>
