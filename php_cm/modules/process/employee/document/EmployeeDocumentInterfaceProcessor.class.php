<?php

/**
 * Description of EmployeeDocumentInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/employee/document/EmployeeDocumentPageBuilder.class.php');

class EmployeeDocumentInterfaceProcessor
{
    const DISPLAY_WIDTH         = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const EDIT_WIDTH            = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const EDIT_CONTENT_HEIGHT   = 300;

    const REMOVE_CONTENT_HEIGHT = 200;
    const REMOVE_DIALOG_WIDTH   = ApplicationInterfaceBuilder::DETAIL_WIDTH;

    const UPLOAD_WIDTH  = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const UPLOAD_HEIGHT = 500;


    static function displayView(xajaxResponse $objResponse,
                                $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {

                $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);

                // omdat de verdere refactoring van de EmployeeAttachments nog niet is gedaan,
                // eerst gewoon gebruik maken van de code in employees_attachments_deprecated...

                //
                // of collectie...
//                $valueObjects = EmployeeDocumentService::getValueObjects(    $employeeId);

                $viewHtml = EmployeeDocumentPageBuilder::getPageHtml(   self::DISPLAY_WIDTH,
                                                                        $employeeId,
                                                                        $employeeInfoValueObject);
            }
            EmployeesTabInterfaceProcessor::displayContent( $objResponse,
                                                            $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu(    $objResponse,
                                                            $employeeId,
                                                            MODULE_EMPLOYEE_ATTACHMENTS);
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function displayEdit(xajaxResponse$objResponse,
                                $employeeId,
                                $employeeDocumentId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            $popupHtml = EmployeeDocumentPageBuilder::getEditPopupHtml( self::EDIT_WIDTH,
                                                                        self::EDIT_CONTENT_HEIGHT,
                                                                        $employeeId,
                                                                        $employeeDocumentId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::EDIT_CONTENT_HEIGHT);
        }
    }

    static function finishEdit( xajaxResponse $objResponse,
                                $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function displayRemove(  $objResponse,
                                    $employeeId,
                                    $employeeDocumentId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            $popupHtml = EmployeeDocumentPageBuilder::getRemovePopupHtml(   self::REMOVE_DIALOG_WIDTH,
                                                                            self::REMOVE_CONTENT_HEIGHT,
                                                                            $employeeId,
                                                                            $employeeDocumentId);
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::REMOVE_DIALOG_WIDTH,
                                                self::REMOVE_CONTENT_HEIGHT);
        }
    }

    static function finishRemove(   $objResponse,
                                    $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }

    static function finishUpload(   $objResponse,
                                    $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }

    static function cancelUploadDocument(   $objResponse,
                                            $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
            // TODO: refactor deze functie. naar controller?
            $employeeDocumentId = EmployeeAssessmentEvaluationService::retrieveUploadedEvaluationDocumentId();
            if (!empty($employeeDocumentId)) {
                EmployeeDocumentService::removeDocument($employeeId, $employeeDocumentId);
            }
        }
        EmployeeAssessmentEvaluationService::clearUploadedEvaluationDocumentId();

        self::displayView(  $objResponse,
                            $employeeId);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    static function displayUploadDocument(  $objResponse,
                                            $employeeId)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {

            $popupHtml = EmployeeDocumentPageBuilder::getUploadPopupHtml(   self::UPLOAD_WIDTH,
                                                                            self::UPLOAD_HEIGHT,
                                                                            $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::UPLOAD_WIDTH,
                                            self::UPLOAD_HEIGHT);
        }
    }

    static function finishUploadDocument(   $objResponse,
                                            $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView(  $objResponse,
                            $employeeId);
    }



}

?>
