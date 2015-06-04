<?php

/**
 * Description of EmployeeDocumentSafeFormProcessor
 *
 * @author ben.dokter
 */

class EmployeeDocumentSafeFormProcessor
{

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            $employeeId= $safeFormHandler->retrieveSafeValue('ID_E');
            $employeeDocumentId = $safeFormHandler->retrieveSafeValue('ID_EDOC');

            $document_description = $safeFormHandler->retrieveInputValue('description');
            $notes = $safeFormHandler->retrieveInputValue('remarks');

            $hasError = false;
            $selectDocumentCluster = new SelectDocumentCluster();
            if ($selectDocumentCluster->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
                $selected_results = $selectDocumentCluster->getResults();
                $document_cluster_id = empty($selected_results['selected_cluster']) ? 'NULL' : $selected_results['selected_cluster'];
            } else {
                $hasError   = true;
                $messages[] = $selectDocumentCluster->getErrorTxt();
            }


            $selectDocumentAuthorisation = new SelectDocumentAuthorisation();
            if ($selectDocumentAuthorisation->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
                $selected_results = $selectDocumentAuthorisation->getResults();
                $document_auth_hr  = empty($selected_results['selected_hr'])  ? 'NULL' : $selected_results['selected_hr'];
                $document_auth_mgr = empty($selected_results['selected_mgr']) ? 'NULL' : $selected_results['selected_mgr'];
                $document_auth_emp_edit = empty($selected_results['selected_emp_edit']) ? 'NULL' : $selected_results['selected_emp_edit'];
                $document_auth_emp_view = empty($selected_results['selected_emp_view']) ? 'NULL' : $selected_results['selected_emp_view'];
            } else {
                $hasError   = true;
                $messages[] = $selectDocumentAuthorisation->getErrorTxt();
            }

            if (!$hasError) {
                $hasError = true;
                BaseQueries::startTransaction();

                $modified_by_user = USER;
                $modified_time = MODIFIED_TIME;
                $modified_date = MODIFIED_DATE;

                $sql = 'UPDATE
                            employees_documents
                        SET
                            ID_DC                =  ' . $document_cluster_id . ',
                            level_id_hr          =  ' . $document_auth_hr  . ',
                            level_id_mgr         =  ' . $document_auth_mgr . ',
                            level_id_emp_edit    =  ' . $document_auth_emp_edit . ',
                            level_id_emp_view    =  ' . $document_auth_emp_view . ',
                            document_description = "' . mysql_real_escape_string($document_description) . '",
                            notes                = "' . mysql_real_escape_string($notes) . '",
                            modified_by_user     = "' . $modified_by_user . '",
                            modified_time        = "' . $modified_time . '",
                            modified_date        = "' . $modified_date . '",
                            database_datetime    = NOW()
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_E    = ' . $employeeId . '
                            AND ID_EDOC = ' . $employeeDocumentId;
                BaseQueries::performUpdateQuery($sql);

                BaseQueries::finishTransaction();
                $hasError = false;

                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeDocumentInterfaceProcessor::finishEdit( $objResponse,
                                                                $employeeId);

            }
        }
        return array($hasError, $messages);
    }


    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            $employeeId= $safeFormHandler->retrieveSafeValue('ID_E');
            $employeeDocumentId = $safeFormHandler->retrieveSafeValue('ID_EDOC');

            $hasError = true;
            BaseQueries::startTransaction();

            EmployeeDocumentService::removeDocument($employeeId,
                                                    $employeeDocumentId);
            BaseQueries::finishTransaction();

            $hasError = false;
            $safeFormHandler->finalizeSafeFormProcess();
            EmployeeDocumentInterfaceProcessor::finishRemove(   $objResponse,
                                                                $employeeId);
        }
        return array($hasError, $messages);
    }

    static function processUpload($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            $employeeId= $safeFormHandler->retrieveSafeValue('ID_E');

            $employeeDocumentId = EmployeeAssessmentEvaluationService::retrieveUploadedEvaluationDocumentId();

            if (!empty($employeeDocumentId)) {
                $hasError = false;
            } else {
                $messages[] = TXT_UCF('NO_ATTACHMENT_UPLOADED');
            }

            if (!$hasError) {
                EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeDocumentInterfaceProcessor::finishUpload(   $objResponse,
                                                                    $employeeId);
            }
        }
        return array($hasError, $messages);
    }
}

?>
