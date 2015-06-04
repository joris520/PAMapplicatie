<?php

/**
 * Description of EmployeeProfilePageBuilder
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/profile/EmployeeProfileService.class.php');
require_once('modules/interface/builder/tab/EmployeesTabInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/profile//EmployeeProfileInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/profile//EmployeeProfilePersonalInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/profile//EmployeeProfileOrganisationInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/profile//EmployeeProfileInformationInterfaceBuilder.class.php');
require_once('modules/interface/builder/employee/profile//EmployeeProfileUserInterfaceBuilder.class.php');

class EmployeeProfilePageBuilder
{

    // hier de Profiel pagina opbouwen
    static function getPageHtml($displayWidth,
                                $employeeId,
                                EmployeeInfoValueObject $employeeInfoValueObject,
                                EmployeeProfileCollection $employeeProfileCollection)
    {
        // de onderdelen van de pagina opbouwen
        return
                EmployeeProfileInterfaceBuilder::getEmployeeInfoHeaderHtml(     $displayWidth,
                                                                                $employeeId,
                                                                                $employeeInfoValueObject) .
                (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL) ?
                    EmployeeProfilePersonalInterfaceBuilder::getViewHtml(       $displayWidth,
                                                                                $employeeId,
                                                                                $employeeProfileCollection->getPersonalValueObject()) :
                    '') .
                (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_ORGANISATION) ?
                    EmployeeProfileOrganisationInterfaceBuilder::getViewHtml(   $displayWidth,
                                                                                $employeeId,
                                                                                $employeeProfileCollection->getOrganisationValueObject()) :
                    '') .
                (APPLICATION_SHOW_JOB_PROFILE_IN_PROFILE && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE) ?
                    EmployeeJobProfileInterfaceBuilder::getViewHtml($displayWidth, $employeeId, $employeeProfileCollection->getJobProfileValueObject()) :
                    '') .
                (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_INFORMATION) ?
                    EmployeeProfileInformationInterfaceBuilder::getViewHtml(    $displayWidth,
                                                                                $employeeId,
                                                                                $employeeProfileCollection->getInformationValueObject()) :
                    '') .
                (PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE_USER) ?
                    EmployeeProfileUserInterfaceBuilder::getViewHtml(               $displayWidth,
                                                                                    $employeeId,
                                                                                    $employeeProfileCollection->getUserValueObject()) :
                    '');
    }

    static function getEditPersonalPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeProfilePersonalInterfaceBuilder::getEditHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('PROFILE') . ': ' . TXT_UCF('PERSONAL');
        $formId = 'edit_profile_personal_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getRemovePhotoPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeProfilePersonalInterfaceBuilder::getRemoveHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('REMOVE_PHOTO_THUMBNAIL');
        $formId = 'remove_profile_photo_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getRemovePopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getUploadPhotoPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeProfilePersonalInterfaceBuilder::getUploadHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('UPLOAD_PHOTO_THUMBNAIL');
        $formId = 'upload_profile_photo_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getEditOrganisationPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeProfileOrganisationInterfaceBuilder::getEditHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('PROFILE') . ': ' . TXT_UCF('ORGANISATION');
        $formId = 'edit_profile_organisation_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getEditInformationPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeProfileInformationInterfaceBuilder::getEditHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('PROFILE') . ': ' . TXT_UCF('ADDITIONAL_INFO');
        $formId = 'edit_profile_information_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

    static function getAddUserPopupHtml($displayWidth, $contentHeight, $employeeId)
    {
        list($safeFormHandler, $contentHtml) = EmployeeProfileUserInterfaceBuilder::getAddHtml($displayWidth, $employeeId);

        // popup
        $title = TXT_UCF('EDIT') . ' ' . TXT_LC('PROFILE') . ': ' . TXT_UCF('ADD') . ' ' . TXT_UCF('RELATED_USER');
        $formId = 'edit_profile_information_form_' . $employeeId;
        return ApplicationInterfaceBuilder::getEditPopupHtml($formId, $safeFormHandler, $title, $contentHtml, $displayWidth, $contentHeight);

    }

}

?>
