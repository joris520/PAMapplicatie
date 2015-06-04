<?php

/**
 * Description of EmployeeAttachmentsServiceDeprecated
 *
 * @author wouter.storteboom
 */

require_once('modules/model/queries/to_refactor/DocumentQueries.class.php');
require_once('modules/model/queries/library/DocumentClusterQueries.class.php');
require_once('modules/model/queries/to_refactor/EmployeeAttachmentsQueriesDeprecated.class.php');

require_once('modules/model/service/employee/competence/EmployeeAssessmentEvaluationService.class.php');

class EmployeeAttachmentsServiceDeprecated {

    static function getAttachmentInfos($employeeId)
    {
        $infos = array();
        $employeeAttachmentsResult = EmployeeAttachmentsQueriesDeprecated::getEmployeeAttachments($employeeId);
        while ($attachmentInfo = @mysql_fetch_assoc($employeeAttachmentsResult)) {
            $attachmentInfo['document_cluster'] = empty($attachmentInfo['document_cluster']) ? TXT_UCF('EMPTY_CLUSTER_LABEL') : $attachmentInfo['document_cluster'];
            $infos[] = $attachmentInfo;
        }
        return $infos;
    }

    static function getAttachmentInfo($employeeId, $document_id)
    {
        $employeeAttachmentResult = EmployeeAttachmentsQueriesDeprecated::getEmployeeAttachments($employeeId, $document_id);
        $attachmentInfo =  @mysql_fetch_assoc($employeeAttachmentResult);
        return $attachmentInfo;
    }

    static function DeleteAttachment($document_file, $document_id_contents)
    {
        if (!empty($document_file)) {
            // check if document is linked to other employees
            $connected_documents = @mysql_fetch_assoc(DocumentQueries::getDocumentFileUseCount($document_file));
            if ($connected_documents['found'] < 1) {
                @unlink(ModuleUtils::getCustomerAttachmentPath(CUSTOMER_ID) . $document_file);
            }
        }

        if (!empty($document_id_contents)) {
            // check if content is linked to other employees
            $connected_contents = @mysql_fetch_assoc(DocumentQueries::getDocumentContentUseCount($document_id_contents));
            if ($connected_contents['found'] < 1) {
                DocumentQueries::deleteDocumentContent($document_id_contents);
            }
        }
    }

    // als $selectDocumentCluster of $selectDocumentAuthorisation objecten
    // null zijn dan de respectievelijke $document_cluster_id en $document_authorisations gebruiken voor cluster en rechten
    static function processAddAttachment($safeUploadFormHandler,
                                         $attachment_content,
                                         $employeeId,
                                         $selectEmps,
                                         $documentType,
                                         $selectDocumentCluster,
                                         $selectDocumentAuthorisation,
                                         $document_cluster_id = null,
                                         $document_authorisations = null)
    {
        $hasError = false;
        $alertTxt = '';

        // ophalen cluster
        if (!empty($selectDocumentCluster)) {
            if (!$selectDocumentCluster->validateFormInput($safeUploadFormHandler->retrieveCleanedValues())) {
                $hasError = true;
                $alertTxt .= $selectDocumentCluster->getErrorTxt();
            } else {
                // TODO: clusterid bewaren in sessie om bij errors te kunnen herstellen
                $selected_document_cluster_id = $selectDocumentCluster->getResults();
                $_SESSION['file_selected_cluster'] = $selected_document_cluster_id;
                $document_cluster_id = $selected_document_cluster_id[selected_cluster];
                if (empty($document_cluster_id)) {
                    $document_cluster_id = 'null';
                }
            }
        } else {
            if (empty($document_cluster_id)) {
                $document_cluster_id = 'null';
            }
        }

        // ophalen autorisatie
        if (!empty($selectDocumentAuthorisation)) {
            if (!$selectDocumentAuthorisation->validateFormInput($safeUploadFormHandler->retrieveCleanedValues())) {
                $hasError = true;
                $alertTxt .= $selectDocumentAuthorisation->getErrorTxt();
            } else {
                // Authorisation
                // todo: leesbaarder maken
                $selected_authorisation_results = $selectDocumentAuthorisation->getResults();
                $_SESSION['file_selected_authorisations'] = $selected_authorisation_results;
                $document_auth_hr  =        empty($selected_authorisation_results['selected_hr'])       ? 'NULL' : $selected_authorisation_results['selected_hr'];
                $document_auth_mgr =        empty($selected_authorisation_results['selected_mgr'])      ? 'NULL' : $selected_authorisation_results['selected_mgr'];
                $document_auth_emp_edit =   empty($selected_authorisation_results['selected_emp_edit']) ? 'NULL' : $selected_authorisation_results['selected_emp_edit'];
                $document_auth_emp_view =   empty($selected_authorisation_results['selected_emp_view']) ? 'NULL' : $selected_authorisation_results['selected_emp_view'];
            }
        } else {
            $document_auth_hr  =        empty($document_authorisations['selected_hr'])       ? 'NULL' : $document_authorisations['selected_hr'];
            $document_auth_mgr =        empty($document_authorisations['selected_mgr'])      ? 'NULL' : $document_authorisations['selected_mgr'];
            $document_auth_emp_edit =   empty($document_authorisations['selected_emp_edit']) ? 'NULL' : $document_authorisations['selected_emp_edit'];
            $document_auth_emp_view =   empty($document_authorisations['selected_emp_view']) ? 'NULL' : $document_authorisations['selected_emp_view'];
        }

        // ophalen employees
        if ($_GET['showSelectEmployees'] == "true") {

            if (!$selectEmps->validateFormInput($_POST, $_SESSION)) {
                $hasError = true;
                $alertTxt .= $selectEmps->getErrorTxt();
            } else {
                $employees = $selectEmps->processResults($_POST, $_SESSION);
            }
        } else {
            if (empty($employeeId)) {
                $hasError = true;
                $alertTxt .= ' ' . TXT_UCF('NO_EMPLOYEE_SELECTED');
            }
        }

        // alles gechecked, nu upload regelen
        if (!$hasError) {
            $hasError = $attachment_content->uploadAndProcessFile();
            $alertTxt = $attachment_content->message;
            $id_contents = $attachment_content->id_contents;
            $document_name = $attachment_content->document_name;
            $document_pad = $attachment_content->local_name;
        }

        // als uploaden ook goed ging, spul bewaren
        if (!$hasError) {
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;
            $document_description = $safeUploadFormHandler->retrieveInputValue('description');
            $notes = $safeUploadFormHandler->retrieveInputValue('remarks');

            EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

            // employees
            if ($_GET['showSelectEmployees'] == 'true') {
                foreach ($employees as $id_e) {
                    DocumentQueries::insertEmployeeDocument($id_e, $documentType, $document_cluster_id, $id_contents,
                                                            $document_auth_hr, $document_auth_mgr, $document_auth_emp_edit, $document_auth_emp_view,
                                                            $document_pad, $document_name, $document_description, $notes,
                                                            $modified_time, $modified_date);
                }
            } else {
                if (! empty($employeeId)) {
                    EmployeeAssessmentEvaluationService::storeUploadedEvaluationDocumentId(
                            DocumentQueries::insertEmployeeDocument($employeeId, $documentType, $document_cluster_id, $id_contents,
                                                                    $document_auth_hr, $document_auth_mgr, $document_auth_emp_edit, $document_auth_emp_view,
                                                                    $document_pad, $document_name, $document_description, $notes,
                                                                    $modified_time, $modified_date));
                }
            }

            // als alles goed is gegaan zijn deze niet meer nodig...
            unset($_SESSION['file_selected_authorisations']);
            unset($_SESSION['file_selected_cluster']);
        }
        return array($hasError, $alertTxt);
    }

    static function validateAndUpdateDocumentInfo($employeeId,
                                                  $document_id,
                                                  $document_cluster_id,
                                                  $document_auth_hr,
                                                  $document_auth_mgr,
                                                  $document_auth_emp_edit,
                                                  $document_auth_emp_view,
                                                  $document_description,
                                                  $notes)
    {
        // validate

        // update
        EmployeeAttachmentsQueriesDeprecated::updateDocumentInfo($employeeId,
                                                                $document_id,
                                                                $document_cluster_id,
                                                                $document_auth_hr,
                                                                $document_auth_mgr,
                                                                $document_auth_emp_edit,
                                                                $document_auth_emp_view,
                                                                $document_description,
                                                                $notes);
    }

    static function getClusterIdByName($cluster_name)
    {
        $documentClusterInfo = @mysql_fetch_assoc(DocumentClusterQueries::getClusterByName($cluster_name));
        return $documentClusterInfo['ID_DC'];
    }

}

?>
