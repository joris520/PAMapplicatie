<?php

/**
 * Description of EmployeeProfileInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/employee/profile/EmployeeProfilePageBuilder.class.php');
require_once('modules/process/tab/EmployeesTabInterfaceProcessor.class.php');

class EmployeeProfileInterfaceProcessor
{
    const DISPLAY_WIDTH = ApplicationInterfaceBuilder::VIEW_WIDTH;
    const EDIT_WIDTH    = ApplicationInterfaceBuilder::DETAIL_WIDTH;

    const PERSONAL_CONTENT_HEIGHT = 330;
    const ORGANISATION_CONTENT_HEIGHT = 230;
    const INFORMATION_CONTENT_HEIGHT = 200;
    const USER_CONTENT_HEIGHT = 120;
    const UPLOAD_CONTENT_HEIGHT = 200;
    const REMOVE_CONTENT_HEIGHT = 300;
    const REMOVE_DIALOG_WIDTH = 500;

    static function displayView($objResponse, $employeeId)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)) {

            if (empty($employeeId)) {
                $viewHtml = TXT_UCF('NO_EMPLOYEE_SELECTED');
            } else {

                // de data ophalen die getoont moet worden
                $employeeInfoValueObject = EmployeeSelectService::getValueObject($employeeId);
                $employeeProfileCollection = EmployeeProfileService::getCollection($employeeId);

                $viewHtml = EmployeeProfilePageBuilder::getPageHtml(self::DISPLAY_WIDTH,
                                                                    $employeeId,
                                                                    $employeeInfoValueObject,
                                                                    $employeeProfileCollection);
            }
            EmployeesTabInterfaceProcessor::displayContent($objResponse, $viewHtml);
            EmployeesTabInterfaceProcessor::displayMenu($objResponse, $employeeId, MODULE_EMPLOYEE_PROFILE);
        }
    }

    static function displayEditPersonal($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {

            $popupHtml = EmployeeProfilePageBuilder::getEditPersonalPopupHtml(  self::EDIT_WIDTH,
                                                                                self::PERSONAL_CONTENT_HEIGHT,
                                                                                $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::PERSONAL_CONTENT_HEIGHT);
        }
    }

    static function finishEditPersonal( xajaxResponse $objResponse,
                                        IdValue $employeeIdValue)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        EmployeeListInterfaceProcessor::updateEmployeeNameInList(   $objResponse,
                                                                    $employeeIdValue);
        self::displayView(  $objResponse,
                            $employeeIdValue->getDatabaseId());
    }

    static function displayRemovePhoto($objResponse, $employeeId)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {

            $popupHtml = EmployeeProfilePageBuilder::getRemovePhotoPopupHtml(   self::REMOVE_DIALOG_WIDTH,
                                                                                self::REMOVE_CONTENT_HEIGHT,
                                                                                $employeeId);
            InterfaceXajax::showRemoveDialog(   $objResponse,
                                                $popupHtml,
                                                self::REMOVE_DIALOG_WIDTH,
                                                self::REMOVE_CONTENT_HEIGHT);
        }
    }

    static function finishRemovePhoto($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId);
    }

    static function displayUploadPhoto($objResponse, $employeeId)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
            EmployeeProfilePersonalService::clearUploadedPhotoContentId();

            $popupHtml = EmployeeProfilePageBuilder::getUploadPhotoPopupHtml(   self::EDIT_WIDTH,
                                                                                self::UPLOAD_CONTENT_HEIGHT,
                                                                                $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::UPLOAD_CONTENT_HEIGHT);
        }
    }

    static function finishUploadPhoto($objResponse, $employeeId)
    {
        EmployeeProfilePersonalService::clearUploadedPhotoContentId();

        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId);
    }

    // letop: beetje een uitzondering...
    static function cancelUploadPhoto($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {
            // TODO: refactor deze functie. naar controller?
            $photoContentId = EmployeeProfilePersonalService::retrieveUploadedPhotoContentId();
            if (!empty($photoContentId)) {
                PhotoContent::removeContentFromDatabase($photoContentId);
            }
        }
        EmployeeProfilePersonalService::clearUploadedPhotoContentId();

        self::displayView($objResponse, $employeeId);
    }

    static function displayEditOrganisation($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_ORGANISATION)) {

            $popupHtml = EmployeeProfilePageBuilder::getEditOrganisationPopupHtml(  self::EDIT_WIDTH,
                                                                                    self::ORGANISATION_CONTENT_HEIGHT,
                                                                                    $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::ORGANISATION_CONTENT_HEIGHT);
        }
    }

    static function finishEditOrganisation($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId);
    }


    static function displayEditInformation($objResponse, $employeeId)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_INFORMATION)) {

            $popupHtml = EmployeeProfilePageBuilder::getEditInformationPopupHtml(   self::EDIT_WIDTH,
                                                                                    self::INFORMATION_CONTENT_HEIGHT,
                                                                                    $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::INFORMATION_CONTENT_HEIGHT);
        }
    }

    static function finishEditInformation($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId);
    }

    static function displayAddUser($objResponse, $employeeId)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_USERS)) {

            $popupHtml = EmployeeProfilePageBuilder::getAddUserPopupHtml(   self::EDIT_WIDTH,
                                                                            self::USER_CONTENT_HEIGHT,
                                                                            $employeeId);
            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_WIDTH,
                                            self::USER_CONTENT_HEIGHT);
        }
    }

    static function finishAddUser($objResponse, $employeeId)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        self::displayView($objResponse, $employeeId);
    }


}

?>
