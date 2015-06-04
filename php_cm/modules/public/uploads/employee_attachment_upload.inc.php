<?php

require_once('modules/interface/components/select/SelectEmployees.class.php');
require_once('modules/interface/components/select/SelectDocumentCluster.class.php');
require_once('modules/interface/components/select/SelectDocumentAuthorisation.class.php');
require_once('modules/model/service/to_refactor/EmployeeAttachmentsServiceDeprecated.class.php');
require_once('modules/model/service/upload/EvaluationAttachmentContent.class.php');
require_once('modules/model/service/upload/AttachmentContent.class.php');

require_once('modules/model/service/employee/competence/EmployeeAssessmentEvaluationService.class.php');

// Hans, todo: Betere oplossing voor deze functie, wellicht scheiden van de form opbouw en dataopslag.
function handle_upload_batch_attachment($xajax, $employee_id)
{
    global $smarty;

    $selectEmps = new SelectEmployees();
    $selectDocumentCluster = new SelectDocumentCluster();
    $selectDocumentAuthorisation = new SelectDocumentAuthorisation();
    $attachmentContent = new AttachmentContent();

    // aanmaken van template
    $tpl = $smarty->createTemplate('to_refactor/file_upload/addDocumentForm.tpl');

    if (isset($_POST['submitButton'])) {

        list($isValidForm, $safeUploadFormHandler) = SafeUploadFormHandler::retrieveAndValidate($_POST['formIdentifier'], $_POST);
        // HP: todo: Een (nog te schrijven) functie aanroepen die de integriteit van het bestand checkt.
        // bijv: SafeUploadFormHandler::validateFileUpload($_POST['formIdentifier'])
        if ($isValidForm) {
            list($hasError, $messageTxt) = EmployeeAttachmentsServiceDeprecated::processAddAttachment(  $safeUploadFormHandler,
                                                                                                        $attachmentContent,
                                                                                                        $employee_id,
                                                                                                        $selectEmps,
                                                                                                        EmployeeAttachmentTypeValue::NORMAL,
                                                                                                        $selectDocumentCluster,
                                                                                                        $selectDocumentAuthorisation);
        }

        if ($hasError) {
            $tpl->assign('val_description', $safeUploadFormHandler->retrieveInputValue('description'));
            $tpl->assign('val_remarks',     $safeUploadFormHandler->retrieveInputValue('remarks'));
            $tpl->assign('upload_error_string', $messageTxt);
        } else {
            $tpl->assign('upload_ok_string', $messageTxt);
        }
    } else {

        $safeUploadFormHandler = SafeUploadFormHandler::create(SAFEUPLOADFORM_ATTACHMENT__UPLOAD_FILE);
        $safeUploadFormHandler->addIntegerInputFormatType('doc_cluster');
        $safeUploadFormHandler->addIntegerInputFormatType('doc_userlevel_hr');
        $safeUploadFormHandler->addIntegerInputFormatType('doc_userlevel_mgr');
        $safeUploadFormHandler->addIntegerInputFormatType('doc_userlevel_emp');
        $safeUploadFormHandler->addStringInputFormatType('description');
        $safeUploadFormHandler->addStringInputFormatType('remarks');
        $safeUploadFormHandler->finalizeDataDefinition();
        $formToken = $safeUploadFormHandler->getTokenHiddenInputHtml();
        $formIdentifier = '<input type="hidden" value="' . $safeUploadFormHandler->getFormIdentifier() . '" name="formIdentifier">';
        $tpl->assign('formToken', $formToken);
        $tpl->assign('formIdentifier', $formIdentifier);
    }

    $tpl->assign('theme', THEME);
    $tpl->assign('xajaxJavascript', $xajax->getJavascript());
    $tpl->assign('max_size', $attachmentContent->getMaxUploadFileSize());
    $tpl->assign('max_size_label', $attachmentContent->getMaxUploadFileSizeLabel());

    //$tpl->assign('info', $info);
    $tpl->assign('extensions', $attachmentContent->getAllowedUploadExtensionsText());

    $selectDocumentCluster->setSelectedClusterId($_SESSION['file_selected_cluster']['selected_cluster']);
    $selectDocumentCluster->fillComponent($tpl);

    $selectDocumentAuthorisation->setAuthorisationLevels($_SESSION['file_selected_authorisations']);
    $selectDocumentAuthorisation->fillComponent($tpl);

    if ($_GET['showSelectEmployees'] == "true") {
        $selectEmps->fillComponent($tpl);
        $tpl->assign('showSelectEmployees', true);
    }

    unset($_SESSION['file_selected_authorisations']);
    unset($_SESSION['file_selected_cluster']);

    return $smarty->fetch($tpl);
}

function handle_upload_employee_attachment($xajax, $employeeId)
{
    global $smarty;

    $selectEmps = new SelectEmployees();
    $selectDocumentCluster = new SelectDocumentCluster();
    $selectDocumentAuthorisation = new SelectDocumentAuthorisation();
    $attachmentContent = new AttachmentContent();
    EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

    // aanmaken van template
    $tpl = $smarty->createTemplate('to_refactor/file_upload/addDocumentForm.tpl');

    if (isset($_POST['submitButton'])) {

        list($isValidForm, $safeUploadFormHandler) = SafeUploadFormHandler::retrieveAndValidate($_POST['formIdentifier'], $_POST);
        // HP: todo: Een (nog te schrijven) functie aanroepen die de integriteit van het bestand checkt.
        // bijv: SafeUploadFormHandler::validateFileUpload($_POST['formIdentifier'])
        if ($isValidForm) {
            $employeeId = $safeUploadFormHandler->retrieveSafeValue('ID_E');
            list($hasError, $messageTxt) = EmployeeAttachmentsServiceDeprecated::processAddAttachment(  $safeUploadFormHandler,
                                                                                                        $attachmentContent,
                                                                                                        $employeeId,
                                                                                                        $selectEmps,
                                                                                                        EmployeeAttachmentTypeValue::NORMAL,
                                                                                                        $selectDocumentCluster,
                                                                                                        $selectDocumentAuthorisation);
        }

        if ($hasError) {
            $tpl->assign('val_description', $safeUploadFormHandler->retrieveInputValue('description'));
            $tpl->assign('val_remarks',     $safeUploadFormHandler->retrieveInputValue('remarks'));
            $tpl->assign('upload_error_string', $messageTxt);
        } else {
            $tpl->assign('upload_ok_string', $messageTxt);
        }
    } else {

        $safeUploadFormHandler = SafeUploadFormHandler::create(SAFEUPLOADFORM_ATTACHMENT__UPLOAD_FILE, SAFEFORM_EMPLOYEES__UPLOAD_ATTACHMENT_DEPRECATED);
        $safeUploadFormHandler->storeSafeValue('ID_E',    $employeeId);
        $safeUploadFormHandler->addIntegerInputFormatType('doc_cluster');
        $safeUploadFormHandler->addIntegerInputFormatType('doc_userlevel_hr');
        $safeUploadFormHandler->addIntegerInputFormatType('doc_userlevel_mgr');
        $safeUploadFormHandler->addIntegerInputFormatType('doc_userlevel_emp');
        $safeUploadFormHandler->addStringInputFormatType('description');
        $safeUploadFormHandler->addStringInputFormatType('remarks');
        $safeUploadFormHandler->finalizeDataDefinition();
        $formToken = $safeUploadFormHandler->getTokenHiddenInputHtml();
        $formIdentifier = '<input type="hidden" value="' . $safeUploadFormHandler->getFormIdentifier() . '" name="formIdentifier">';
        $tpl->assign('formToken', $formToken);
        $tpl->assign('formIdentifier', $formIdentifier);
    }

    $tpl->assign('theme', THEME);
    $tpl->assign('xajaxJavascript', $xajax->getJavascript());
    $tpl->assign('max_size', $attachmentContent->getMaxUploadFileSize());
    $tpl->assign('max_size_label', $attachmentContent->getMaxUploadFileSizeLabel());

    //$tpl->assign('info', $info);
    $tpl->assign('extensions', $attachmentContent->getAllowedUploadExtensionsText());

    $selectDocumentCluster->setSelectedClusterId($_SESSION['file_selected_cluster']['selected_cluster']);
    $selectDocumentCluster->fillComponent($tpl);

    $selectDocumentAuthorisation->setAuthorisationLevels($_SESSION['file_selected_authorisations']);
    $selectDocumentAuthorisation->fillComponent($tpl);

    if ($_GET['showSelectEmployees'] == "true") {
        $selectEmps->fillComponent($tpl);
        $tpl->assign('showSelectEmployees', true);
    }

    unset($_SESSION['file_selected_authorisations']);
    unset($_SESSION['file_selected_cluster']);

    return $smarty->fetch($tpl);
}

function handle_upload_employee_attachment2($xajax, $employee_id)
{
    global $smarty;
    $attachmentContent = new EvaluationAttachmentContent();
    EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();
    $finished_upload = false;

    // aanmaken van template
    $tpl = $smarty->createTemplate('to_refactor/file_upload/addDocumentForm.tpl');

    if (isset($_POST['submitButton'])) {
        list($isValidForm, $safeUploadFormHandler) = SafeUploadFormHandler::retrieveAndValidate($_POST['formIdentifier'], $_POST);
        if ($isValidForm) {
            $document_cluster_id = null;//EmployeeAttachmentsServiceDeprecated::getClusterIdByName(EVALUATION_ATTACHMENT_CLUSTER_NAME);
            $document_authorisations = array();
            $document_authorisations['selected_hr'] = UserLevelValue::HR;
            $document_authorisations['selected_mgr'] = UserLevelValue::MANAGER;
            $document_authorisations['selected_emp_edit'] = UserLevelValue::EMPLOYEE_EDIT;
            $document_authorisations['selected_emp_view'] = UserLevelValue::EMPLOYEE_VIEW;

            list($hasError, $messageTxt) = EmployeeAttachmentsServiceDeprecated::processAddAttachment(  $safeUploadFormHandler,
                                                                                                        $attachmentContent,
                                                                                                        $employee_id,
                                                                                                        null,
                                                                                                        EmployeeAttachmentTypeValue::NORMAL,
                                                                                                        null,
                                                                                                        null,
                                                                                                        $document_cluster_id,
                                                                                                        $document_authorisations);
        }

        if ($hasError) {
            $tpl->assign('upload_error_string', $messageTxt);
        } else {
            $tpl->assign('upload_ok_string', $messageTxt);
            $finished_upload = true;
        }
    }

    if (!$finished_upload) { // bij errors opnieuw een safeform aanmaken
        $safeUploadFormHandler = SafeUploadFormHandler::create(SAFEUPLOADFORM_EVALUATION__UPLOAD_FILE, SAFEFORM_EMPLOYEE__EDIT_ASSESSEMENT_EVALUATION);
        $safeUploadFormHandler->finalizeDataDefinition();
        $formToken = $safeUploadFormHandler->getTokenHiddenInputHtml();
        $formIdentifier = '<input type="hidden" value="' . $safeUploadFormHandler->getFormIdentifier() . '" name="formIdentifier">';
        $tpl->assign('formToken', $formToken);
        $tpl->assign('formIdentifier', $formIdentifier);
        $frameHeight = 180;//'select_attachment';
    } else {
        $frameHeight = 80;//'show_attachment';
    }

    $tpl->assign('finished_upload', $finished_upload);
    $tpl->assign('theme', THEME);
    $tpl->assign('xajaxJavascript', $xajax->getJavascript());
    $tpl->assign('max_size', $attachmentContent->getMaxUploadFileSize());
    $tpl->assign('max_size_label', $attachmentContent->getMaxUploadFileSizeLabel());

    //$tpl->assign('info', $info);
    $tpl->assign('extensions', $attachmentContent->getAllowedUploadExtensionsText());

    unset($_SESSION['file_selected_authorisations']);
    unset($_SESSION['file_selected_cluster']);

    return array($smarty->fetch($tpl), $frameHeight);

}
function handle_upload_evaluation_attachment($xajax, $employee_id)
{
    global $smarty;
    $attachmentContent = new EvaluationAttachmentContent();
    EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();
    $finished_upload = false;

    // aanmaken van template
    $tpl = $smarty->createTemplate('to_refactor/file_upload/addEvaluationDocumentForm.tpl');

    if (isset($_POST['submitButton'])) {
        list($isValidForm, $safeUploadFormHandler) = SafeUploadFormHandler::retrieveAndValidate($_POST['formIdentifier'], $_POST);
        if ($isValidForm) {
            $document_cluster_id = null;//EmployeeAttachmentsServiceDeprecated::getClusterIdByName(EVALUATION_ATTACHMENT_CLUSTER_NAME);
            $document_authorisations = array();
            $document_authorisations['selected_hr'] = UserLevelValue::HR;
            $document_authorisations['selected_mgr'] = UserLevelValue::MANAGER;
            $document_authorisations['selected_emp_edit'] = UserLevelValue::EMPLOYEE_EDIT;
            $document_authorisations['selected_emp_view'] = UserLevelValue::EMPLOYEE_VIEW;

            list($hasError, $messageTxt) = EmployeeAttachmentsServiceDeprecated::processAddAttachment($safeUploadFormHandler,
                                                                                            $attachmentContent,
                                                                                            $employee_id,
                                                                                            null,
                                                                                            EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION,
                                                                                            null,
                                                                                            null,
                                                                                            $document_cluster_id,
                                                                                            $document_authorisations);
        }

        if ($hasError) {
            $tpl->assign('upload_error_string', $messageTxt);
        } else {
            $tpl->assign('upload_ok_string', $messageTxt);
            $finished_upload = true;
        }
    }

    if (!$finished_upload) { // bij errors opnieuw een safeform aanmaken
        $safeUploadFormHandler = SafeUploadFormHandler::create(SAFEUPLOADFORM_EVALUATION__UPLOAD_FILE, SAFEFORM_EMPLOYEE__EDIT_ASSESSEMENT_EVALUATION);
        $safeUploadFormHandler->finalizeDataDefinition();
        $formToken = $safeUploadFormHandler->getTokenHiddenInputHtml();
        $formIdentifier = '<input type="hidden" value="' . $safeUploadFormHandler->getFormIdentifier() . '" name="formIdentifier">';
        $tpl->assign('formToken', $formToken);
        $tpl->assign('formIdentifier', $formIdentifier);
        $frameHeight = 180;//'select_attachment';
    } else {
        $frameHeight = 80;//'show_attachment';
    }

    $tpl->assign('finished_upload', $finished_upload);
    $tpl->assign('theme', THEME);
    $tpl->assign('xajaxJavascript', $xajax->getJavascript());
    $tpl->assign('max_size', $attachmentContent->getMaxUploadFileSize());
    $tpl->assign('max_size_label', $attachmentContent->getMaxUploadFileSizeLabel());

    //$tpl->assign('info', $info);
    $tpl->assign('extensions', $attachmentContent->getAllowedUploadExtensionsText());

    unset($_SESSION['file_selected_authorisations']);
    unset($_SESSION['file_selected_cluster']);

    return array($smarty->fetch($tpl), $frameHeight);

}

?>