<?php

require_once('modules/interface/components/select/SelectEmployees.class.php');
require_once('modules/interface/components/select/SelectDocumentCluster.class.php');
require_once('modules/interface/components/select/SelectDocumentAuthorisation.class.php');
require_once('modules/model/service/to_refactor/EmployeeAttachmentsServiceDeprecated.class.php');
require_once('modules/model/service/upload/AttachmentContent.class.php');
require_once('modules/model/service/upload/EvaluationAttachmentContent.class.php');

//DISPLAY ATTACHMENTS SUB MODULES
//function moduleEmployees_attachments_deprecated($id_e) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        moduleEmployees_attachments_direct_deprecated($objResponse, $id_e);
//    }
//    return $objResponse;
//}
//
//function moduleEmployees_attachments_direct_deprecated($objResponse, $id_e)
//{
//    $getemp_attachments = '';
//    ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_ATTACHMENTS);
//
////    $tabNav = ApplicationNavigationInterfaceBuilder::buildEmployeeSubMenu($id_e, MODULE_EMPLOYEE_ATTACHMENTS);
//
////    $attach_btn = '';
////    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
////            $attach_btn = InterfaceBuilder::IconButton('upload',
////                                                       TXT_BTN('UPLOAD_NEW_ATTACHMENT'),
////                                                       'xajax_moduleEmployees_newAttachment_deprecated(' . $id_e . ');',
////                                                       ICON_UPLOAD,
////                                                       'btn_width_150');
////    }
////
////    $top_nav .= InterfaceBuilder::IconButton('print',
////                                             TXT_BTN('GENERATE_ATTACHMENT_PRINT'),
////                                             'xajax_moduleEmployees_printAttachments_deprecated(' . $id_e . ');',
////                                             ICON_PRINT,
////                                             'btn_width_150');
////    $top_nav = $attach_btn . $top_nav;
//
//
//    $get_att = EmployeeDocumentQueries::getEmployeeDocuments($id_e);
//
//    if (@mysql_num_rows($get_att) == 0) {
//        $getemp_attachments .='	 ' . TXT_UCF('NO_ATTACHMENT_RETURN') . ' <br /><br />';
//    } else {
//        $getemp_attachments .='
//                <div class="mod_employees_Attachments">
//                    <br>'; // hmm, deze br lijkt nodig om uberhaupt de table te laten zien...
//        $getemp_attachments .='
//                    <table border="0" cellspacing="0" cellpadding="2" width="100%">';
//
//        $prev_cluster = 'NULL';
//        while ($att_row = @mysql_fetch_assoc($get_att)) {
//            if ($att_row['active'] != BaseDatabaseValue::IS_DELETED ) {
//                $access_list = ModuleUtils::generateAccessList( $att_row[level_id_hr],
//                                                                $att_row[level_id_mgr],
//                                                                $att_row[level_id_emp_edit]);
//                $is_evaluation_attachment = ($att_row['document_type'] == EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION);
//                $is_delete_allowed = (  empty($att_row['ID_EAEDOC']) ||
//                                        $att_row['ID_EDOC'] <> $att_row['ID_EAEDOC']);
//                $row_cluster = $att_row['document_cluster'];
//                $display_cluster_name = '&nbsp;';
//
//                if ($prev_cluster != $row_cluster) {
//                    $display_cluster_name = empty($row_cluster) ? EMPTY_CLUSTER_LABEL : $row_cluster;
//                    if ($is_evaluation_attachment) {
//                        $display_cluster_name = TXT_UCF('EVALUATION_ATTACHMENT');
//                    }
//
//                    $getemp_attachments .= '
//                            <tr>
//                                <td colspan="6" class="shaded_title">&nbsp;<strong>' . $display_cluster_name . '</strong></td>
//                            </tr>
//                            <tr>
//                                <td width="5%">&nbsp;</td>
//                                <td width="20%" class="mod_employees_tasks_heading">' . TXT_UCF('FILENAME') . '</td>
//                                <td width="20%" class="mod_employees_tasks_heading">' . TXT_UCF('ATTACHMENT_ACCESS_RIGHTS') . '</td>
//                                <td width="20%" class="mod_employees_tasks_heading">' . TXT_UCF('DESCRIPTION') . '</td>
//                                <td width="25%" class="mod_employees_tasks_heading">' . TXT_UCF('REMARKS') . '</td>
//                                <td width="10%" class="mod_employees_tasks_heading">&nbsp;</td>
//                            </tr>';
//                }
//                $prev_cluster = $row_cluster;
//
//                if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//                    $edit_attach = InterfaceBuilder::IconButton('editAttachment',
//                                                            TXT_BTN('EDIT'),
//                                                            'xajax_moduleEmployees_editAttachment_deprecated(' . $att_row[ID_EDOC] . ', ' . $id_e . ');',
//                                                            ICON_EDIT,
//                                                            NO_BUTTON_CLASS,
//                                                            FORCE_USE_ICON);
//                    if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS) &&
//                        $is_delete_allowed) {
//                        $edit_attach .= InterfaceBuilder::IconButton('deleteAttachment',
//                                                                    TXT_BTN('DELETE'),
//                                                                    'xajax_moduleEmployees_removeAttachment_deprecated(' . $att_row[ID_EDOC] . ', ' . $id_e . ');',
//                                                                    ICON_DELETE,
//                                                                    NO_BUTTON_CLASS,
//                                                                    FORCE_USE_ICON);
//                    } elseif ($is_evaluation_attachment) {
//                        $edit_attach .= InterfaceBuilder::IconButton('deleteAttachment',
//                                                                    TXT_BTN('EVALUATION_ATTACHMENT'),
//                                                                    null,
//                                                                    ICON_EMPLOYEE_CONVERSATION_COMPLETED_10,
//                                                                    NO_BUTTON_CLASS,
//                                                                    FORCE_USE_ICON);
//                    }
//
//                } else {
//                    $edit_attach = '&nbsp;';
//                }
//
//                $getemp_attachments .='
//                    <tr>
//                        <td class="bottom_line">&nbsp;</td>
//                        <td class="bottom_line"><a href="downloaddb.php?d=' . $att_row['id_contents'] . '&e=' . $id_e . '">' . (!empty($att_row[document_name]) ? $att_row[document_name] : $att_row[document_pad]) . '</a></td>
//                        <td class="bottom_line">' . $access_list . ' &nbsp;</td>
//                        <td class="bottom_line">' . nl2br($att_row[document_description]) . ' &nbsp;</td>
//                        <td class="bottom_line">' . nl2br($att_row[notes]) . ' &nbsp;</td>
//                        <td class="bottom_line" style="text-align: right">' . $edit_attach . '</td>
//                    </tr>';
//
////                $modified_by_user = $att_row[modified_by_user];
////                $modified_date = $att_row[modified_date];
////                $modified_time = $att_row[modified_time];
//            }
//        }
//        $getemp_attachments .='
//                <tr>
//                    <td colspan="6"><br><div id="logs" align="right"></div></td>
//                </tr>
//            </table>
//        </div>';
////        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $modified_by_user, $modified_date, $modified_time);
//    }
//
//    $objResponse->assign('empPrint', 'innerHTML', $getemp_attachments);
//
//    EmployeesTabInterfaceProcessor::displayMenu($objResponse, $id_e, MODULE_EMPLOYEE_ATTACHMENTS);
//    $objResponse->assign('top_nav_btn', 'innerHTML', $top_nav);
//}


//function moduleEmployees_newAttachment_deprecated($id_e) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        $objResponse->call("xajax_moduleEmployees_uploader_form_deprecated", $id_e);
//    }
//    return $objResponse;
//}

//function getAttachmentLink($employee_id, $document_id)
//{
//    $attachmentLink = '';
//    if (!empty($employee_id) && !empty($document_id)) {
//        $attachmentResult = DocumentQueries::getEmployeesDocumentInfo($document_id, $employee_id);
//        $attachment = @mysql_fetch_assoc($attachmentResult);
//        if (!empty($attachment['id_contents']) && !empty($attachment['document_name'])) {
//            $attachmentLink = '<a href="downloaddb.php?d=' . $attachment['id_contents'] . '&e=' . $employee_id . '">' . $attachment['document_name'] . '</a>';
//        }
//    }
//    return $attachmentLink;
//}
//
//UPLOAD FORM
//function moduleEmployees_uploader_form_deprecated($id_e) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        $_SESSION['ID_E'] = $id_e;
//        $getemp_attachments .= '
//            <p>' . TXT_UCW('UPLOAD_NEW_ATTACHMENT'). '</p>';
//            $getemp_attachments .= '
//            <iframe src ="upload_attachment.php" width="99%" height="400" frameBorder="0" class="border1px">
//            <p>Your browser does not support iframes.</p>
//            </iframe>';
////        }
//        $objResponse->assign('empPrint', 'innerHTML', $getemp_attachments);
//    }
//    return $objResponse;
//}

// deze functie was al refactored, en staat nu in employee_attachments_interface.inc.php
//function getAttachmentClusterSelectionHTML($id_doc_cluster)
//{
//    global $smarty;
//    $tpl = $smarty->createTemplate('components/select/selectDocumentCluster.tpl');
//
//    $selectDocumentCluster = new SelectDocumentCluster();
//    $selectDocumentCluster->setSelectedClusterId($id_doc_cluster);
//    $selectDocumentCluster->fillComponent($tpl);
//
//    return $smarty->fetch($tpl);
//}


// deze functie was al refactored, en staat nu in employee_attachments_interface.inc.php
//function getAttachmentAuthorisationSelectionHTML($id_doc_cluster)
//{
//    global $smarty;
//    $tpl = $smarty->createTemplate('components/select/selectDocumentAuthorisation.tpl');
//
//    $selectDocumentAuthorisation = new SelectDocumentAuthorisation();
//    $selectDocumentAuthorisation->setDocumentId($id_doc_cluster);
//    $selectDocumentAuthorisation->fillComponent($tpl);
//
//    //$tpl->assign('selected_entry', $id_doc_cluster);
//    return $smarty->fetch($tpl);
//}


//EDIT ATTACHMENT
//function moduleEmployees_editAttachment_deprecated($id_edoc, $id_e) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        $sql = 'SELECT
//                    *
//                FROM
//                    employees_documents
//                WHERE
//                    customer_id = ' . CUSTOMER_ID . '
//                    AND ID_E = ' . $id_e . '
//                    AND ID_EDOC = ' . $id_edoc;
//        $documentQuery = BaseQueries::performQuery($sql);
//        $get_edoc = @mysql_fetch_assoc($documentQuery);
//
//        $cluster_selection_html = ($get_edoc['document_type'] == EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION)
//                                  ?  $display_cluster_name = TXT_UCF('EVALUATION_ATTACHMENT')
//                                  :  getAttachmentClusterSelectionHTML($get_edoc[ID_DC]);
//        $authorisation_selection_html = getAttachmentAuthorisationSelectionHTML($id_edoc);
//
//        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__EDIT_ATTACHMENT_DEPRECATED);
//
//        $safeFormHandler->storeSafeValue('ID_E', $id_e);
//        $safeFormHandler->storeSafeValue('ID_EDOC', $id_edoc);
//
//        $safeFormHandler->addIntegerInputFormatType('doc_cluster', true);
//        $safeFormHandler->addIntegerInputFormatType('doc_userlevel_hr');
//        $safeFormHandler->addIntegerInputFormatType('doc_userlevel_mgr');
//        $safeFormHandler->addIntegerInputFormatType('doc_userlevel_emp');
//        $safeFormHandler->addStringInputFormatType('description');
//        $safeFormHandler->addStringInputFormatType('remarks');
//
//        $safeFormHandler->finalizeDataDefinition();
//
//        $getemp_attachments = '';
//        $getemp_attachments .= '
//        <p>' . TXT_UCW('EDIT_ATTACHMENT') . '</p>
//        <form id="upload_form" name="upload_form" onsubmit="submitSafeForm( \'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;" enctype="multipart/form-data">';
//
//        $getemp_attachments .= $safeFormHandler->getTokenHiddenInputHtml();
//
//        $getemp_attachments .= '
//            <table width="436" border="0" cellspacing="2" cellpadding="2">
//            <tr>
//                <td>' . TXT_UCF('CLUSTER') . ' :</td>
//                <td>' . $cluster_selection_html . '</td>
//            </tr>
//            <tr>
//                <td>' . TXT_UCF('ATTACHMENT_ACCESS_RIGHTS') . ' :</td>
//                <td>' . $authorisation_selection_html . '</td>
//            </tr>
//            <tr>
//                <td>' . TXT_UCF('DESCRIPTION') . ' : </td>
//                <td><textarea name="description" cols="35" rows="3" id="description">' . $get_edoc[document_description] . '</textarea></td>
//            </tr>
//            <tr>
//                <td>' . TXT_UCF('REMARKS') . ' : </td>
//                <td><label>
//                <textarea name="remarks" cols="35" rows="3" id="remarks">' . $get_edoc[notes] . '</textarea>
//                </label></td>
//            </tr>
//            <tr>
//                <td colspan="2">
//                    <input type="submit" id="submitButton" value=" ' . TXT_BTN('SAVE') . ' " class="btn btn_width_80"/>
//                    <input type="button" onClick="xajax_moduleEmployees_attachments_deprecated(' . $id_e . '); return false;" value=" ' . TXT_BTN('CANCEL') . ' " class="btn btn_width_80"/>
//                </td>
//            </tr>
//            </table>
//        </form>';
//        $objResponse->assign('empPrint', 'innerHTML', $getemp_attachments);
//    }
//
//    return $objResponse;
//}

////PROCESS EDITED ATTACHMENT AND PROCESS DB
//function employees_processSafeForm_editAttachment_deprecated($objResponse, $safeFormHandler)
//{
//    $hasError = true;
//    if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//
//        $id_e = $safeFormHandler->retrieveSafeValue('ID_E');
//        $id_edoc = $safeFormHandler->retrieveSafeValue('ID_EDOC');
//
//        $document_description = $safeFormHandler->retrieveInputValue('description');
//        $notes = $safeFormHandler->retrieveInputValue('remarks');
//
//        $hasError = false;
//        $selectDocumentCluster = new SelectDocumentCluster();
//        if ($selectDocumentCluster->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
//            $selected_results = $selectDocumentCluster->getResults();
//            $document_cluster_id = empty($selected_results['selected_cluster']) ? 'NULL' : $selected_results['selected_cluster'];
//        } else {
//            $hasError = true;
//            $message .= $selectDocumentCluster->getErrorTxt() . "\n";
//        }
//
//
//        $selectDocumentAuthorisation = new SelectDocumentAuthorisation();
//        if ($selectDocumentAuthorisation->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
//            $selected_results = $selectDocumentAuthorisation->getResults();
//            $document_auth_hr  = empty($selected_results['selected_hr'])  ? 'NULL' : $selected_results['selected_hr'];
//            $document_auth_mgr = empty($selected_results['selected_mgr']) ? 'NULL' : $selected_results['selected_mgr'];
//            $document_auth_emp_edit = empty($selected_results['selected_emp_edit']) ? 'NULL' : $selected_results['selected_emp_edit'];
//            $document_auth_emp_view = empty($selected_results['selected_emp_view']) ? 'NULL' : $selected_results['selected_emp_view'];
//        } else {
//            $hasError = true;
//            $message .= $selectDocumentAuthorisation->getErrorTxt() . "\n";
//        }
//
//        if (!$hasError) {
//            $hasError = true;
//            BaseQueries::startTransaction();
//
//            $modified_by_user = USER;
//            $modified_time = MODIFIED_TIME;
//            $modified_date = MODIFIED_DATE;
//
//            $sql = 'UPDATE
//                        employees_documents
//                    SET
//                        ID_DC                =  ' . $document_cluster_id . ',
//                        level_id_hr          =  ' . $document_auth_hr  . ',
//                        level_id_mgr         =  ' . $document_auth_mgr . ',
//                        level_id_emp_edit    =  ' . $document_auth_emp_edit . ',
//                        level_id_emp_view    =  ' . $document_auth_emp_view . ',
//                        document_description = "' . mysql_real_escape_string($document_description) . '",
//                        notes                = "' . mysql_real_escape_string($notes) . '",
//                        modified_by_user     = "' . $modified_by_user . '",
//                        modified_time        = "' . $modified_time . '",
//                        modified_date        = "' . $modified_date . '"
//                    WHERE
//                        customer_id = ' . CUSTOMER_ID . '
//                        AND ID_EDOC = ' . $id_edoc;
//            BaseQueries::performUpdateQuery($sql);
//
//            BaseQueries::finishTransaction();
//            $hasError = false;
//
//            $objResponse->loadCommands(moduleEmployees_attachments_deprecated($id_e));
//        }
//    }
//    return array($hasError, $message);
//}

//REMOVE ATTACHMENT FILES
//function moduleEmployees_removeAttachment_deprecated($id_edoc, $id_e) {
//    $objResponse = new xajaxResponse();
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THE_FILE'));
//        $objResponse->call("xajax_moduleEmployees_executeRemoveAttachment_deprecated", $id_edoc, $id_e);
//    }
//
//    return $objResponse;
//}

//function moduleEmployees_executeRemoveAttachment_deprecated($id_edoc, $id_e)
//{
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        removeAttachment_direct($id_edoc, $id_e);
//
//        return moduleEmployees_attachments_deprecated($id_e);
//    }
//    return $objResponse;
//}

//function removeAttachment_direct($id_edoc, $id_e)
//{
//    $getedoc = @mysql_fetch_assoc(DocumentQueries::getEmployeeDocumentContentInfo($id_edoc, $id_e));
//    $document_pad =  $getedoc['document_pad'];
//    $document_id_contents =  $getedoc['id_contents'];
//
//    // attachment kan nu weg bij employee, en dan bestand zelf evt ook.
//    DocumentQueries::deleteEmployeeDocuments($id_edoc, $id_e);
//    BatchQueries::clearAssessmentEvaluationAttachment($id_e, $id_edoc);
//
//    EmployeeAttachmentsServiceDeprecated::DeleteAttachment($document_pad, $document_id_contents);
//}

//function moduleEmployees_printAttachments_deprecated($id_e) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        $_SESSION['empIDs2print'] = array($id_e);
//        $objResponse->script('window.open(\'print/print_employeesAttachments.php\',\'\',\'resizable=yes,width=800,height=800\')');
//    }
//    return $objResponse;
//}
//
//function moduleEmployees_executePrintAttachments_deprecated($printProfile) {
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
//        $alert_txt = "";
//        $hasError = false;
//
//        $selectEmps = new SelectEmployees();
//
//        if (!$selectEmps->validateFormInput($printProfile, $_SESSION)) {
//            $alert_txt .= $selectEmps->getErrorTxt();
//            $hasError = true;
//        }
//
//        if ($hasError) {
//            $objResponse->alert($alert_txt);
//        } else {
//            $_SESSION['empIDs2print'] = $selectEmps->processResults($printProfile, $_SESSION);
//            $objResponse->script('window.open(\'print/print_employeesAttachments.php\',\'\',\'resizable=yes,width=800,height=800\')');
//        }
//
//    }
//    return $objResponse;
//}


?>