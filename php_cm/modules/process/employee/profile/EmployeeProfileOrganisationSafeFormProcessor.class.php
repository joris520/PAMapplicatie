<?php

/**
 * Description of EmployeeProfileOrganisationSafeFormProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/converter/employee/profile/EmployeeFteConverter.class.php');

class EmployeeProfileOrganisationSafeFormProcessor
{
    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE_ORGANISATION)) {

            $employeeId         = $safeFormHandler->retrieveSafeValue('employeeId');
            $subordinateCount   = $safeFormHandler->retrieveSafeValue('subordinateCount');

            $departmentId       = $safeFormHandler->retrieveInputValue('department');
            $bossId             = $safeFormHandler->retrieveInputValue('boss');
            $isBossInput        = $safeFormHandler->retrieveInputValue('is_boss');
            $phoneNumberWork    = $safeFormHandler->retrieveInputValue('phone_number_work');
            $fteInput           = $safeFormHandler->retrieveInputValue('employment_FTE');
            $employmentDate     = $safeFormHandler->retrieveInputValue('employment_date');
            $contractState      = $safeFormHandler->retrieveInputValue('contract_state');

            if (EmployeeFteConverter::isValidNumber($fteInput)) {
                // als het een valide waarde is dan converteren
                $fte = EmployeeFteConverter::value($fteInput);
            } else {
                // anders  de validatie het op laten lossen
                $fte = $fteInput;
            }

            $isBossValue = $subordinateCount > 0 ? BooleanValue::TRUE : ($isBossInput == 'is_boss' ? BooleanValue::TRUE : BooleanValue::FALSE);

            $valueObject = EmployeeProfileOrganisationValueObject::createWithValues($employeeId,
                                                                                    $bossId,
                                                                                    $isBossValue,
                                                                                    $departmentId,
                                                                                    $phoneNumberWork,
                                                                                    $employmentDate,
                                                                                    $fte,
                                                                                    //$employeeNumber,
                                                                                    $contractState);

            list($hasError, $messages) = EmployeeProfileController::processEditOrganisation($employeeId,
                                                                                            $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeProfileInterfaceProcessor::finishEditOrganisation(  $objResponse,
                                                                            $employeeId);
            }
        }
        return array($hasError, $messages);
    }
}

?>
