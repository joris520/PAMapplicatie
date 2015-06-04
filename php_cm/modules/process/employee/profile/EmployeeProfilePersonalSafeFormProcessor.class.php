<?php

/**
 * Description of EmployeeProfilePersonalSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/profile/EmployeeProfilePersonalService.class.php');
require_once('modules/interface/converter/employee/profile/EmployeeNameConverter.class.php');

class EmployeeProfilePersonalSafeFormProcessor
{
    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_PERSONAL)) {

            $employeeId         = $safeFormHandler->retrieveSafeValue('employeeId');
            $isEmailRequired    = $safeFormHandler->retrieveSafeValue('isEmailRequired');

            $firstName          = $safeFormHandler->retrieveInputValue('firstname');
            $lastName           = $safeFormHandler->retrieveInputValue('lastname');
            $bsn                = $safeFormHandler->retrieveInputValue('SN');
            $gender             = $safeFormHandler->retrieveInputValue('sex');
            $birthDisplayDate   = $safeFormHandler->retrieveInputValue('birth_date'); // vanwege de !readonly een string
            $nationality        = $safeFormHandler->retrieveInputValue('nationality');
            $street             = $safeFormHandler->retrieveInputValue('street');
            $postcode           = $safeFormHandler->retrieveInputValue('postal_code');
            $city               = $safeFormHandler->retrieveInputValue('city');
            $phoneNumber        = $safeFormHandler->retrieveInputValue('phone_number');
            $emailAddress       = $safeFormHandler->retrieveInputValue('email_address');


            $valueObject = EmployeeProfilePersonalValueObject::createWithValues($employeeId,
                                                                                $firstName,
                                                                                $lastName,
                                                                                NULL,
                                                                                $gender,
                                                                                $birthDisplayDate,
                                                                                $bsn,
                                                                                $nationality,
                                                                                $street,
                                                                                $postcode,
                                                                                $city,
                                                                                $phoneNumber,
                                                                                $emailAddress);

            list($hasError, $messages) = EmployeeProfileController::processEditPersonal($employeeId, $valueObject, $isEmailRequired);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                $employeeIdValue = IdValue::create($employeeId, EmployeeNameConverter::displaySortable($firstName, $lastName));
                EmployeeProfileInterfaceProcessor::finishEditPersonal(  $objResponse,
                                                                        $employeeIdValue);
            }
        }
        return array($hasError, $messages);
    }


    static function processRemovePhoto($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PROFILE)) {

            $employeeId  = $safeFormHandler->retrieveSafeValue('employeeId');
            $valueObject = EmployeeProfilePersonalService::getValueObject($employeeId);

            list($hasError, $messages) = EmployeeProfileController::processRemovePhoto($employeeId, $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeProfileInterfaceProcessor::finishRemovePhoto($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEditPhoto($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE)) {

            $employeeId  = $safeFormHandler->retrieveSafeValue('employeeId');
            $valueObject = EmployeeProfilePersonalService::getValueObject($employeeId);
            $newPhotoContentId = EmployeeProfilePersonalService::retrieveUploadedPhotoContentId();

            list($hasError, $messages) = EmployeeProfileController::processEditPhoto($employeeId, $valueObject, $newPhotoContentId);
            if (!$hasError) {
                EmployeeProfilePersonalService::clearUploadedPhotoContentID();

                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeProfileInterfaceProcessor::finishRemovePhoto($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
