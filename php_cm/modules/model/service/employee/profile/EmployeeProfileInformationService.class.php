<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EmployeeProfileInformationService
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/employee/profile/EmployeeProfileInformationValueObject.class.php');
require_once('modules/model/value/employee/profile/EmployeeEducationLevelValue.class.php');

class EmployeeProfileInformationService
{
    static function getValueObject($employeeId)
    {
        $valueObject = NULL;

        $query = EmployeeProfileQueries::selectEmployeeProfileInformation($employeeId);
        $employeeInformationData = @mysql_fetch_assoc($query);
        $valueObject = EmployeeProfileInformationValueObject::createWithData($employeeId, $employeeInformationData);

        mysql_free_result($query);

        return $valueObject;
    }


    function validate(EmployeeProfileInformationValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $educationLevel = $valueObject->getEducationLevel();
        if (!EmployeeEducationLevelValue::isValidValue($educationLevel)) {
            $hasError = true;
            $messages[] = TXT_UCF('EDUCATION_LEVEL_IS_INVALID');
        }

        return array($hasError, $messages);
    }

    static function updateValidated($employeeId,
                                    EmployeeProfileInformationValueObject $valueObject,
                                    $isEditAllowedManagerInfo)
    {
        return EmployeeProfileQueries::updateProfileInformation($employeeId,
                                                                $isEditAllowedManagerInfo,
                                                                $valueObject->getEducationLevel(),
                                                                $valueObject->getAdditionalInfo(),
                                                                $valueObject->getManagerInfo());
    }

}

?>
