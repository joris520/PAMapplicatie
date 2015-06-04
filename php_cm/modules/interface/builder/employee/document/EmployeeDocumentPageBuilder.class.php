<?php

/**
 * Description of EmployeeAttachmentPageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/document/EmployeeDocumentInterfaceBuilder.class.php');

class EmployeeDocumentPageBuilder
{
    static function getPageHtml($displayWidth,
                                $employeeId,
                                EmployeeInfoValueObject $employeeInfoValueObject)
    {

        return  EmployeeDocumentInterfaceBuilder::getEmployeeInfoHeaderHtml($displayWidth,
                                                                            $employeeId,
                                                                            $employeeInfoValueObject) .
                EmployeeDocumentInterfaceBuilder::getViewHtml(  $displayWidth,
                                                                $employeeId);
    }

    static function getEditPopupHtml(   $displayWidth,
                                        $contentHeight,
                                        $employeeId,
                                        $employeeDocumentId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeDocumentInterfaceBuilder::getEditHtml(   $displayWidth,
                                                                                                $employeeId,
                                                                                                $employeeDocumentId);

        // popup
        $title = TXT_UCF('EDIT_ATTACHMENT_INFO');
        $formId = 'edit_employee_document_form_' . $employeeId . '_' . $employeeDocumentId;
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING);
    }

    static function getRemovePopupHtml( $displayWidth,
                                        $contentHeight,
                                        $employeeId,
                                        $employeeDocumentId)
    {
        $popupHtml = '';
        $title = TXT_UCF('DELETE_ATTACHMENT');

        list($safeFormHandler, $contentHtml) = EmployeeDocumentInterfaceBuilder::getRemoveHtml( $displayWidth,
                                                                                                $employeeId,
                                                                                                $employeeDocumentId);

        // popup
        $formId = 'remove_employee_document_form_' . $employeeId . '_' . $employeeDocumentId;
        $popupHtml = ApplicationInterfaceBuilder::getRemovePopupHtml(   $formId,
                                                                        $safeFormHandler,
                                                                        $title,
                                                                        $contentHtml,
                                                                        $displayWidth,
                                                                        $contentHeight);
        return $popupHtml;
    }

    static function getUploadPopupHtml( $displayWidth,
                                        $contentHeight,
                                        $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeDocumentInterfaceBuilder::getUploadHtml( $displayWidth,
                                                                                                $employeeId);

        // popup
        $title = TXT_UCF('UPLOAD_NEW_ATTACHMENT');
        $formId = 'upload_profile_photo_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING,
                                                                NULL,
                                                                'xajax_public_employeeDocument__cancelUploadDocument('. $employeeId . ')');

    }

}

?>
