<?php

/**
 * Description of EmployeeJobProfileSafeFormProcessor
 *
 * @author ben.dokter
 */
require_once('modules/model/value/employee/competence/FunctionLevelValue.class.php');
require_once('modules/model/service/library/FunctionService.class.php');
require_once('modules/model/service/employee/competence/EmployeeCompetenceController.class.php');

class EmployeeJobProfileSafeFormProcessor
{

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_JOB_PROFILE)) {

            $employeeId     = $safeFormHandler->retrieveSafeValue('employeeId');

            $selectedFunctions = $safeFormHandler->retrieveInputValue('selectedID_Fs');
            $selectedMainFunctionId = $safeFormHandler->retrieveInputValue('ID_FID');
            $jobProfileNote = $safeFormHandler->retrieveInputValue('note');

            $valueObject = EmployeeJobProfileValueObject::createWithValues( $employeeId,
                                                                            NULL,
                                                                            $jobProfileNote);

            // omzetten
            // omzetten van commaseperated naar array
            $selectedFunctionIds = explode(',', $selectedFunctions);

            foreach($selectedFunctionIds as $selectedFunctionId) {
                if (is_numeric($selectedFunctionId)) {
                    // controleren of de id ook echt bestaat als functie van de customer
                    $functionIdValue = FunctionService::getFunctionIdValue(intval($selectedFunctionId));
                    if (!empty($functionIdValue)) {
                        if ($functionIdValue->getDatabaseId() == $selectedMainFunctionId) {
                            $functionValueObject = EmployeeJobProfileFunctionValueObject::createWithValues( $employeeId,
                                                                                                            NULL,
                                                                                                            NULL,
                                                                                                            $functionIdValue->getDatabaseId(),
                                                                                                            $functionIdValue->getValue(),
                                                                                                            FunctionLevelValue::IS_MAIN_FUNCTION);
                            $valueObject->setMainFunction($functionValueObject);
                        } else {
                            $functionValueObject = EmployeeJobProfileFunctionValueObject::createWithValues( $employeeId,
                                                                                                            NULL,
                                                                                                            NULL,
                                                                                                            $functionIdValue->getDatabaseId(),
                                                                                                            $functionIdValue->getValue(),
                                                                                                            FunctionLevelValue::IS_ADDITIONAL_FUNCTION);
                            $valueObject->addAdditionalFunction($functionValueObject);
                        }
                    }
                }
            }


            list($hasError, $messages) = EmployeeCompetenceController::processEditJobProfile($employeeId, $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeeCompetenceInterfaceProcessor::finishEditFunction($objResponse, $employeeId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
