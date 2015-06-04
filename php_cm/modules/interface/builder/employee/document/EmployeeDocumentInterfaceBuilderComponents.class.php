<?php

/**
 * Description of EmployeeDocumentInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeDocumentInterfaceBuilderComponents
{

    static function getEditLink($employeeId,
                                $employeeDocumentId)
    {
        $html = '';
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
            $html .= InterfaceBuilder::iconLink('edit_employee_document_' . $employeeId . '_' . $employeeDocumentId,
                                                TXT_BTN('EDIT'),
                                                'xajax_public_employeeDocument__editDocumentInfo(' . $employeeId . ',' . $employeeDocumentId . ');',
                                                ICON_EDIT);
        }
        return $html;
    }

    static function getRemoveLink(  $employeeId,
                                    $employeeDocumentId,
                                    $isDeletePossible,
                                    $isEvaluationAttachment)
    {
        $html = '';

        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS) &&
            $isDeletePossible) {
            $html .= InterfaceBuilder::iconLink('delete_employee_document_' . $employeeId . '_' . $employeeDocumentId,
                                                TXT_BTN('DELETE'),
                                                'xajax_public_employeeDocument__removeDocument(' . $employeeId . ',' . $employeeDocumentId . ');',
                                                ICON_DELETE);
        } elseif ($isEvaluationAttachment) {
            $html .= InterfaceBuilder::iconLink('delete_employee_document_' . $employeeId . '_' . $employeeDocumentId,
                                                TXT_BTN('EVALUATION_ATTACHMENT'),
                                                null,
                                                ICON_EMPLOYEE_CONVERSATION_COMPLETED_10);
        }
        return $html;
    }

    static function getUploadDocumentLink($employeeId)
    {
        $html = '';
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
            $html .= InterfaceBuilder::iconLink('upload_employee_document_' . $employeeId,
                                                TXT_BTN('UPLOAD_NEW_ATTACHMENT'),
                                                'xajax_public_employeeDocument__uploadDocument(' . $employeeId . ');',
                                                ICON_ADD);
        }
        return $html;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // tijdelijk hier
    static function getAttachmentClusterSelectionHTML($documentClusterId)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('components/select/selectDocumentCluster.tpl');

        $selectDocumentCluster = new SelectDocumentCluster();
        $selectDocumentCluster->setSelectedClusterId($documentClusterId);
        $selectDocumentCluster->fillComponent($tpl);

        return $smarty->fetch($tpl);
    }

    static function getAttachmentAuthorisationSelectionHTML($employeeDocumentId)
    {
        global $smarty;
        $tpl = $smarty->createTemplate('components/select/selectDocumentAuthorisation.tpl');

        $selectDocumentAuthorisation = new SelectDocumentAuthorisation();
        $selectDocumentAuthorisation->setDocumentId($employeeDocumentId);
        $selectDocumentAuthorisation->fillComponent($tpl);

        return $smarty->fetch($tpl);
    }


}

?>
