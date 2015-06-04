<?php

/**
 * Description of EmployeeJobProfileService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/employee/competence/EmployeeJobProfileQueries.class.php');
require_once('modules/model/queries/employee/competence/EmployeeJobProfileFunctionQueries.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeJobProfileValueObject.class.php');
require_once('modules/model/valueobjects/employee/competence/EmployeeJobProfileFunctionValueObject.class.php');
require_once('modules/model/value/employee/competence/FunctionLevelValue.class.php');


class EmployeeJobProfileService
{

    static function getValueObject($employeeId, $referenceDateTime = REFERENCE_DATE)
    {
        // jobprofile bestaat uit hoofdfunctie en (optionele) nevenfuncties
        $jobProfileQuery = EmployeeJobProfileQueries::getJobProfile($employeeId, $referenceDateTime);
        $jobProfileData = mysql_fetch_assoc($jobProfileQuery);
        mysql_free_result($jobProfileQuery);

        $valueObject = EmployeeJobProfileValueObject::createWithData(   $employeeId,
                                                                        $jobProfileData);

        // alle functies bij jobprofile ophalen volgens nieuwe methode
        $jobProfileId = $valueObject->getId();
        if (!empty($jobProfileId)) {
            $functionQuery = EmployeeJobProfileFunctionQueries::getFunctionsForJobProfile($employeeId, $jobProfileId);
            while ($functionData = mysql_fetch_assoc($functionQuery)) {
                $functionValueObject = EmployeeJobProfileFunctionValueObject::createWithData(   $employeeId,
                                                                                                $jobProfileId,
                                                                                                $functionData);
                // in jobprofile vastleggen
                if ($functionValueObject->isMainFunction()) {
                    $valueObject->setMainFunction($functionValueObject);
                } else {
                    $valueObject->addAdditionalFunction($functionValueObject);
                }
            }
            mysql_free_result($functionQuery);

        } else { // als er nog geen functieprofiel is, dan hack om uit de "oude" data halen....

            $valueObject = EmployeeJobProfileValueObject::createWithValues( $employeeId,
                                                                            NULL,
                                                                            NULL);

            $functionQuery = EmployeeJobProfileQueries::getMainFunction($employeeId);
            $mainFunctionData = mysql_fetch_assoc($functionQuery);
            mysql_free_result($functionQuery);

            $mainFunction = EmployeeJobProfileFunctionValueObject::createWithValues($employeeId, NULL, NULL, $mainFunctionData['ID_F'], $mainFunctionData['function'], FunctionLevelValue::IS_MAIN_FUNCTION);
            $valueObject->setMainFunction($mainFunction);

            // nevenfuncties
            $additionalFunctionsQuery = EmployeeJobProfileQueries::getAdditionalFunctions($employeeId);
            while ($additionalFunctionData = mysql_fetch_assoc($additionalFunctionsQuery)) {
                $additionalFunction = EmployeeJobProfileFunctionValueObject::createWithValues($employeeId, NULL, NULL, $additionalFunctionData['ID_F'], $additionalFunctionData['function'], FunctionLevelValue::IS_ADDITIONAL_FUNCTION);
                $valueObject->addAdditionalFunction($additionalFunction);
            }
            mysql_free_result($additionalFunctionsQuery);
        }
        return $valueObject;
    }

    static function getValueObjects($employeeId)
    {
        $valueObjects = array();

        $query = EmployeeJobProfileQueries::getJobProfiles($employeeId);
        while ($jobProfileData = mysql_fetch_assoc($query)) {


            $valueObject = EmployeeJobProfileValueObject::createWithData(   $employeeId,
                                                                            $jobProfileData);

            // alle functies bij jobprofile ophalen volgens nieuwe methode
            $jobProfileId = $valueObject->getId();

            $functionQuery = EmployeeJobProfileFunctionQueries::getFunctionsForJobProfile($employeeId, $jobProfileId);
            while ($functionData = mysql_fetch_assoc($functionQuery)) {
                $functionValueObject = EmployeeJobProfileFunctionValueObject::createWithData(   $employeeId,
                                                                                                $jobProfileId,
                                                                                                $functionData);
                // in jobprofile vastleggen
                if ($functionValueObject->isMainFunction()) {
                    $valueObject->setMainFunction($functionValueObject);
                } else {
                    $valueObject->addAdditionalFunction($functionValueObject);
                }
            }
            mysql_free_result($functionQuery);

            $valueObjects[] = $valueObject;
        }
        mysql_free_result($query);

        return $valueObjects;
    }


    static function getValueObjectUsingEmployeesTable($employeeId)
    {
        // hoofdfunctie
        $functionQuery = EmployeeJobProfileQueries::getMainFunction($employeeId);
        $mainFunctionData = @mysql_fetch_assoc($functionQuery);
        mysql_free_result($functionQuery);
        $mainFunctionIdValue = IdValue::create($mainFunctionData[EmployeeJobProfileQueries::ID_FIELD], $mainFunctionData['function']);

        // nevenfuncties
        $additionalFunctionIdValues = array();
        $additionalFunctionsQuery = EmployeeJobProfileQueries::getAdditionalFunctions($employeeId);
        while ($additionalFunctionData = @mysql_fetch_assoc($additionalFunctionsQuery)) {
            $additionalFunctionIdValues[] = IdValue::create($additionalFunctionData[EmployeeJobProfileQueries::ID_FIELD], $additionalFunctionData['function']);
        }
        mysql_free_result($additionalFunctionsQuery);

        $functionData = array();
        $functionData[EmployeeJobProfileQueries::ID_FIELD] = $mainFunctionIdValue->getDatabaseId();
        $functionData['mainFunctionIdValue'] = $mainFunctionIdValue;
        $functionData['additionalFunctionIdValues'] = $additionalFunctionIdValues;
        $valueObject = EmployeeJobProfileValueObject::createWithData(   $employeeId,
                                                                        $functionData);
        return $valueObject;
    }

    static function validate(EmployeeJobProfileValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $mainFunction        = $valueObject->getMainFunction();
        $additionalFunctions = $valueObject->getAdditionalFunctions();
        if (empty($mainFunction) &&
            empty($additionalFunctions)) {
            $hasError = true;
            $messages[] = TXT_UCF('SELECTED_MAIN_JOB_PROFILE_NOT_IN_LIST_JOB_PROFILES_OF_EMPLOYEE');
        } elseif (empty($mainFunction)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_A_JOB_PROFILE');
        }
        return array($hasError, $messages);
    }

    static function updateValidated($employeeId,
                                    EmployeeJobProfileValueObject $valueObject)
    {
        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // NIEUWE STIJL OPSLAAN...
        // eerst een EmployeeJobProfile opslaan...
        $functionDate = DateUtils::getCurrentDatabaseDate();
        $jobProfileId = EmployeeJobProfileQueries::insertJobProfile($employeeId, $functionDate, $valueObject->getNote());

        $mainFunction        = $valueObject->getMainFunction();
        $additionalFunctions = $valueObject->getAdditionalFunctions();

        EmployeeJobProfileFunctionQueries::insertJobProfileFunction($employeeId, $jobProfileId, $mainFunction->getFunctionId(), FunctionLevelValue::IS_MAIN_FUNCTION);

        foreach($additionalFunctions as $additionalFunction) {
            EmployeeJobProfileFunctionQueries::insertJobProfileFunction($employeeId, $jobProfileId, $additionalFunction->getFunctionId(), FunctionLevelValue::IS_ADDITIONAL_FUNCTION);
        }

        /////////////////////////////////////////////////////////////////////////////////////////////////////
        // OUDE STIJL OPSLAAN IS OOK NOG NODIG
        // eerst main functie updaten. nu nog in employees tabel...
        EmployeeJobProfileQueries::updateMainFunctionInEmployeesTable($employeeId, $mainFunction->getFunctionId());

        // de nevenfuncties aanpassen.
        EmployeeJobProfileQueries::deleteFromAdditionalFunctionsTable($employeeId);
        foreach ($additionalFunctions as $additionalFunction) {
            EmployeeJobProfileQueries::insertInAdditionalFunctionsTable($employeeId, $additionalFunction->getFunctionId());
        }
    }

    static function insertValidatedValues(  $employeeId,
                                            $mainJobProfileId,
                                            Array $additionalJobProfileIds)
    {
        $functionDate = DateUtils::getCurrentDatabaseDate();
        $jobProfileId = EmployeeJobProfileQueries::insertJobProfile($employeeId, $functionDate, NULL);

        EmployeeJobProfileFunctionQueries::insertJobProfileFunction($employeeId, $jobProfileId, $mainJobProfileId, FunctionLevelValue::IS_MAIN_FUNCTION);

        foreach($additionalJobProfileIds as $additionalJobProfileId) {
            EmployeeJobProfileFunctionQueries::insertJobProfileFunction($employeeId, $jobProfileId, $additionalJobProfileId, FunctionLevelValue::IS_ADDITIONAL_FUNCTION);
        }

    }


}

?>
