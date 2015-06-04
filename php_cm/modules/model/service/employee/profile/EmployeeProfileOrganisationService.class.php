<?php

/**
 * Description of EmployeeProfileOrganisationService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/profile/EmployeeProfileOrganisationValueObject.class.php');
require_once('modules/model/queries/employee/profile/EmployeeProfileQueries.class.php');

require_once('application/model/value/BooleanValue.class.php');
require_once('modules/model/value/employee/profile/EmployeeContractStateValue.class.php');

class EmployeeProfileOrganisationService
{
    const INCLUDE_DETAILS   = true;
    const NO_DETAILS        = false;

    static function getValueObject($employeeId, $includeDetails = self::INCLUDE_DETAILS)
    {
        $valueObject = NULL;

        $query = EmployeeProfileQueries::selectEmployeeProfileOrganisation($employeeId);
        $employeeOrganisationData = @mysql_fetch_assoc($query);
        $valueObject = EmployeeProfileOrganisationValueObject::createWithData($employeeId, $employeeOrganisationData);
        mysql_free_result($query);

        if ($includeDetails == self::INCLUDE_DETAILS) {
            // department
            $departmentValueObject = DepartmentService::getValueObjectById($valueObject->getDepartmentId(), false);
            $valueObject->setDepartmentName($departmentValueObject->getDepartmentName());


            // boss
            if ($valueObject->hasBoss()) {
                $bossValueObject = EmployeeProfilePersonalService::getValueObject($valueObject->getBossId());
                $valueObject->setBossEmployeeName($bossValueObject->getEmployeeName());
                $valueObject->setBossEmailAddress($bossValueObject->getEmailAddress());
            }
            // als boss, dan aantal medewerkers
            if ($valueObject->isBoss()) {
                $subordinatesCount = EmployeeSelectService::getBossSubordinateCount($employeeId);
                $valueObject->setBossSubordinateCount($subordinatesCount);
            }
        }
        return $valueObject;
    }

    static function validate(EmployeeProfileOrganisationValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $fteValue = $valueObject->getFte();
        if (!empty($fteValue)) {

            if (!EmployeeFteConverter::isValidNumber($fteValue) || $fteValue < 0.0 || $fteValue > 1.0 ) {
                $hasError = true;
                $messages[] = TXT_UCF('EMPLOYMENT_PERCENTAGE'). ': ' . TXT('INVALID_FTE_VALUE');
            }
        }

        $departmentId = $valueObject->getDepartmentId();
        if (empty($departmentId)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_A_DEPARTMENT');
        }

        $contractState = $valueObject->getContractState();
        if (!EmployeeContractStateValue::isValidValue($contractState)) {
            $hasError = true;
            $messages[] = TXT_UCF('CONTRACT_STATE_IS_INVALID');
        }

        return array($hasError, $messages);
    }

    static function updateValidated($employeeId,
                                    EmployeeProfileOrganisationValueObject $valueObject)
    {
        EmployeeProfileQueries::updateProfileOrganisation(  $employeeId,
                                                            $valueObject->getBossId(),
                                                            $valueObject->isBoss() ? 1 : 0, // TODO: conversie
                                                            $valueObject->getDepartmentId(),
                                                            $valueObject->getPhoneNumberWork(),
                                                            $valueObject->getEmploymentDate(),
                                                            $valueObject->getFte(),
                                                            //$valueObject->getEmployeeNumber(),
                                                            $valueObject->getContractState());
    }
}

?>
