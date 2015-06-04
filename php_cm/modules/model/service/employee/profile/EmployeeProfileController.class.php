<?php

/**
 * Description of EmployeeProfileController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/employee/profile/EmployeeProfileService.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfileInformationService.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfileOrganisationService.class.php');
require_once('modules/model/service/employee/profile/EmployeeProfilePersonalService.class.php');
require_once('modules/model/service/upload/PhotoService.class.php');

require_once('application/model/service/UserService.class.php');

class EmployeeProfileController
{

    static function processEditInformation( $employeeId,
                                            EmployeeProfileInformationValueObject $valueObject,
                                            $isEditAllowedManagerInfo)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeProfileInformationService::validate($valueObject);
        if (!$hasError) {
            EmployeeProfileInformationService::updateValidated($employeeId, $valueObject, $isEditAllowedManagerInfo);

            BaseQueries::finishTransaction();
        }

        return array($hasError, $messages);
    }

    static function processEditOrganisation($employeeId,
                                            EmployeeProfileOrganisationValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeProfileOrganisationService::validate($valueObject);
        if (!$hasError) {
            EmployeeProfileOrganisationService::updateValidated($employeeId, $valueObject);

            BaseQueries::finishTransaction();
        }

        return array($hasError, $messages);
    }

    static function processEditPersonal($employeeId,
                                        EmployeeProfilePersonalValueObject $valueObject,
                                        $isEmailRequired)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        $valueObject->setEmployeeName(  EmployeeNameConverter::display( $valueObject->getFirstName(),
                                                                        $valueObject->getLastName(),
                                                                        EmployeeNameConverter::FORMAT_FIRSTNAME_FIRST));

        list($hasError, $messages) = EmployeeProfilePersonalService::validate($valueObject, $isEmailRequired);
        if (!$hasError) {
            EmployeeProfilePersonalService::updateValidated($employeeId, $valueObject);
            EmployeeProfilePersonalService::updateNameAndEmailRelated($employeeId, $valueObject);

            BaseQueries::finishTransaction();
        }

        return array($hasError, $messages);
    }

    static function processRemoveEmployee($employeeId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeProfileService::validateRemove($employeeId);

        if (!$hasError) {
            EmployeeProfileService::archiveEmployee($employeeId);

            // bijbehorende gebruiker disabled en sessie verwijderen
            UserService::disableUserForEmployeeId($employeeId);

            BaseQueries::finishTransaction();
        }

        return array($hasError, $messages);
    }

    static function processRemovePhoto( $employeeId,
                                        EmployeeProfilePersonalValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        if (!$hasError) {
            // De oude contents verwijderen
            $photoFile      = $valueObject->getPhotoFile();
            $photoContentId = $valueObject->getPhotoContentId();
            EmployeeProfilePersonalService::clearPersonalPhoto($employeeId);
            PhotoService::removeContentFromDatabase($photoContentId);

            BaseQueries::finishTransaction();

            // als de transacties goed zijn gegaan, dan pas de fysieke file verwijderen
            PhotoService::deletePhotoFile($photoFile);
        }

        return array($hasError, $messages);
    }

    static function processEditPhoto(   $employeeId,
                                        EmployeeProfilePersonalValueObject $valueObject,
                                        $newPhotoContentId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeProfileService::validatePhoto($newPhotoContentId);
        if (!$hasError) {
            $oldPhotoFile      = $valueObject->getPhotoFile();
            $oldPhotoContentId = $valueObject->getPhotoContentId();

            $newPhoto = PhotoService::getValueObjectById($newPhotoContentId);
            $newFilename = $newPhoto->getFilename();
            // nieuw photo info opslaan
            EmployeeProfilePersonalService::updatePersonalPhoto($employeeId,
                                                                $newFilename,
                                                                $newPhotoContentId);

            // de oude Contents verwijderen
            PhotoService::removeContentFromDatabase($oldPhotoContentId);

            // we moeten nu het bestand uit de database restoren in het customer logo path
            PhotoService::placePhotoInFilePath($newPhotoContentId, $newFilename);

            BaseQueries::finishTransaction();

            // als de transacties goed zijn gegaan, dan pas de fysieke file verwijderen
            PhotoService::deletePhotoFile($oldPhotoFile);
        }

        return array($hasError, $messages);
    }

}

?>
