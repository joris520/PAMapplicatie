<?php

/**
 * Description of EmployeeProfileInformationSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/model/service/employee/profile/EmployeeProfileController.class.php');

class EmployeeProfileInformationSafeFormProcessor
{
    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_INFORMATION)) {

            $employeeId                 = $safeFormHandler->retrieveSafeValue('employeeId');
            $isEditAllowedManagerInfo   = $safeFormHandler->retrieveSafeValue('isEditAllowedManagerInfo');

            $educationLevel     = $safeFormHandler->retrieveInputValue('education_level');
            $additionalInfo     = $safeFormHandler->retrieveInputValue('additional_info');
            $managerInfo        = $safeFormHandler->retrieveInputValue('manager_info');


            $valueObject = EmployeeProfileInformationValueObject::createWithValues( $employeeId,
                                                                                    $educationLevel,
                                                                                    $additionalInfo,
                                                                                    $managerInfo);

            list($hasError, $messages) = EmployeeProfileController::processEditInformation($employeeId, $valueObject, $isEditAllowedManagerInfo);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeProfileInterfaceProcessor::finishEditInformation($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }
}

?>
