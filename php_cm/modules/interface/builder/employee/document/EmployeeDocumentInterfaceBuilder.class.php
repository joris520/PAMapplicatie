<?php

/**
 * Description of EmployeeDocumentInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/AbstractEmployeeInterfaceBuilder.class.php');

require_once('modules/interface/builder/employee/document/EmployeeDocumentInterfaceBuilderComponents.class.php');


require_once('modules/model/service/employee/document/EmployeeDocumentService.class.php');
require_once('modules/model/queries/employee/document/EmployeeDocumentQueries.class.php');

class EmployeeDocumentInterfaceBuilder extends AbstractEmployeeInterfaceBuilder
{
    static function getViewHtml($displayWidth,
                                $employeeId)
    {
        $contentHtml = '';
        $query = EmployeeDocumentQueries::getEmployeeDocuments($employeeId);

        if (@mysql_num_rows($query) == 0) {
            $contentHtml .= TXT_UCF('NO_ATTACHMENT_RETURN');
        } else {
            $contentHtml .='
                <div class="mod_employees_Attachments">';
            $contentHtml .='
                    <table border="0" cellspacing="0" cellpadding="6" width="100%">';

            $prev_cluster = 'NULL';
            while ($documentData = @mysql_fetch_assoc($query)) {
                if ($documentData['active'] != BaseDatabaseValue::IS_DELETED ) {


                    $access_list = ModuleUtils::generateAccessList( $documentData['level_id_hr'],
                                                                    $documentData['level_id_mgr'],
                                                                    $documentData['level_id_emp_edit'],
                                                                    false);

                    $employeeDocumentId     =   $documentData['ID_EDOC'];
                    $isEvaluationAttachment = ( $documentData['document_type'] == EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION);
                    $isDeletePossible       = ( empty($documentData['ID_EAEDOC']) ||
                                                $documentData['ID_EDOC'] <> $documentData['ID_EAEDOC']);

                    $editLink   = EmployeeDocumentInterfaceBuilderComponents::getEditLink(  $employeeId,
                                                                                            $employeeDocumentId);
                    $removeLink = EmployeeDocumentInterfaceBuilderComponents::getRemoveLink($employeeId,
                                                                                            $employeeDocumentId,
                                                                                            $isDeletePossible,
                                                                                            $isEvaluationAttachment);
                    $row_cluster = $documentData['document_cluster'];
                    $display_cluster_name = '&nbsp;';

                    if ($prev_cluster != $row_cluster) {
                        $display_cluster_name = empty($row_cluster) ? TXT_UCF('EMPTY_CLUSTER_LABEL') : $row_cluster;
                        if ($isEvaluationAttachment) {
                            $display_cluster_name = TXT_UCF('EVALUATION_ATTACHMENT');
                        }

                        $contentHtml .= '
                            <tr>
                                <td colspan="100%" class="">
                                    <h3 style="margin:0px; padding:10px 0px 0px 0px">' . $display_cluster_name . '</h3>
                                </td>
                            </tr>
                            <tr style="padding-left: 5px;">
                                <td class="shaded_title">' . TXT_UCF('FILENAME') . '</td>
                                <td class="shaded_title" style="width:110px;">' . TXT_UCF('ATTACHMENT_ACCESS_RIGHTS') . '</td>
                                <td class="shaded_title" style="width:190px;">' . TXT_UCF('DESCRIPTION') . '</td>
                                <td class="shaded_title" style="width:190px;">' . TXT_UCF('REMARKS') . '</td>
                                <td class="shaded_title" style="width:50px;">&nbsp;</td>
                            </tr>';
                    }
                    $prev_cluster = $row_cluster;


                    // todo: gebruik getAttachmentLink
                    $contentHtml .='
                        <tr>
                            <td class="bottom_line" style="padding-left:10px;">
                                <a title="' . TXT_UCF('VIEW_ATTACHMENT') . '" href="downloaddb.php?d=' . $documentData['id_contents'] . '&e=' . $employeeId . '">' .
                                    (!empty($documentData['document_name']) ? $documentData['document_name'] : $documentData['document_pad']) . '
                                </a>
                            </td>
                            <td class="bottom_line">' . $access_list . ' &nbsp;</td>
                            <td class="bottom_line">' . nl2br($documentData['document_description']) . ' &nbsp;</td>
                            <td class="bottom_line">' . nl2br($documentData['notes']) . ' &nbsp;</td>
                            <td class="bottom_line" style="text-align: right">' . $editLink . $removeLink . '</td>
                        </tr>';
                }
            }
        }
        $contentHtml .='
            </table>
        </div>';

        $employeeDocumentsTitle = TXT_UCF('EMPLOYEE_ATTACHMENTS');
        $employeeDocumentsBlock = BaseBlockHtmlInterfaceObject::create($employeeDocumentsTitle, $displayWidth);
        $employeeDocumentsBlock->setContentHtml($contentHtml);
        $employeeDocumentsBlock->addActionLink( EmployeeDocumentInterfaceBuilderComponents::getUploadDocumentLink($employeeId));

        return $employeeDocumentsBlock->fetchHtml();
    }

    static function getEditHtml($displayWidth,
                                $employeeId,
                                $employeeDocumentId)
    {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__EDIT_ATTACHMENT_DEPRECATED);

        $safeFormHandler->storeSafeValue('ID_E',    $employeeId);
        $safeFormHandler->storeSafeValue('ID_EDOC', $employeeDocumentId);

        $safeFormHandler->addIntegerInputFormatType('doc_cluster', true);
        $safeFormHandler->addIntegerInputFormatType('doc_userlevel_hr');
        $safeFormHandler->addIntegerInputFormatType('doc_userlevel_mgr');
        $safeFormHandler->addIntegerInputFormatType('doc_userlevel_emp');
        $safeFormHandler->addStringInputFormatType('description');
        $safeFormHandler->addStringInputFormatType('remarks');

        $safeFormHandler->finalizeDataDefinition();


        $documentData = EmployeeDocumentService::getDocumentData(   $employeeId,
                                                                    $employeeDocumentId);

        $cluster_selection_html = ($documentData['document_type'] == EmployeeAttachmentTypeValue::ASSESSMENT_EVALUATION)
                                  ?  $display_cluster_name = TXT_UCF('EVALUATION_ATTACHMENT')
                                  :  EmployeeDocumentInterfaceBuilderComponents::getAttachmentClusterSelectionHTML($documentData['ID_DC']);
        $authorisation_selection_html = EmployeeDocumentInterfaceBuilderComponents::getAttachmentAuthorisationSelectionHTML($employeeDocumentId);

        $contentHtml = '
            <table width="' . $displayWidth . '" border="0" cellspacing="2" cellpadding="4">
                <tr>
                    <td>' . TXT_UCF('CLUSTER') . ':</td>
                    <td>' . $cluster_selection_html . '</td>
                </tr>
                <tr>
                    <td>' . TXT_UCF('ATTACHMENT_ACCESS_RIGHTS') . ':</td>
                    <td>' . $authorisation_selection_html . '</td>
                </tr>
                <tr>
                    <td>' . TXT_UCF('DESCRIPTION') . ': </td>
                    <td>
                        <textarea name="description" cols="60" rows="3" id="description">' . $documentData['document_description'] . '</textarea>
                    </td>
                </tr>
                <tr>
                    <td>' . TXT_UCF('REMARKS') . ': </td>
                    <td>
                        <textarea name="remarks" cols="60" rows="3" id="remarks">' . $documentData['notes'] . '</textarea>
                    </td>
                </tr>
            </table>';


        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml(  $displayWidth,
                                    $employeeId,
                                    $employeeDocumentId)
    {
        $documentData = EmployeeDocumentService::getDocumentData(   $employeeId,
                                                                    $employeeDocumentId);


        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__DELETE_ATTACHMENT_DEPRECATED);

        $safeFormHandler->storeSafeValue('ID_E',    $employeeId);
        $safeFormHandler->storeSafeValue('ID_EDOC', $employeeDocumentId);
        $safeFormHandler->finalizeDataDefinition();

        $contentHtml = '
            <p>' . TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THE_FILE') . '</p>
            <table width="' . $displayWidth . '" border="0" cellspacing="2" cellpadding="4">
                <tr>
                    <td class="bottom_line form-label" style="width:100px;">' . TXT_UCF('FILENAME') . ':</td>
                    <td>' . $documentData['document_name'] . '</td>
                </tr>
                <tr>
                    <td class="bottom_line form-label" >' . TXT_UCF('DESCRIPTION') . ':</td>
                    <td>' . nl2br($documentData['document_description']) . '</td>
                </tr>
            </table>';

        return array($safeFormHandler, $contentHtml);
    }

    static function getUploadHtml(  $displayWidth,
                                    $employeeId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMPLOYEES__UPLOAD_ATTACHMENT_DEPRECATED);

        // todo: zie functioneringsgesprek
        $safeFormHandler->storeSafeValue('ID_E',    $employeeId);
        $safeFormHandler->finalizeDataDefinition();
        $_SESSION['ID_E'] = $employeeId;

        $contentHtml = '
            <iframe src ="upload_employee_attachment.php" width="' . $displayWidth . '" height="450" frameBorder="0">
                <p>Your browser does not support iframes.</p>
            </iframe>';

        return array($safeFormHandler, $contentHtml);
    }
}

?>
