<?php

/**
 * Description of EmployeeTargetController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/employee/target/EmployeeTargetService.class.php');
require_once('modules/print/service/employee/EmployeePrintService.class.php');

class EmployeeTargetController
{
    const NEEDS_VALIDATION  = true;
    const ALREADY_VALIDATED = false;

    // Deze functie is ook in gebruik door de batch add, en daar is de target validatie al gedaan
    static function processAddTarget(   $employeeId,
                                        EmployeeTargetValueObject $targetValueObject,
                                        $validation = self::NEEDS_VALIDATION)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        if ($validation == self::NEEDS_VALIDATION) {
            list($hasError, $messages) = EmployeeTargetService::validateAdd($targetValueObject);
        }
        if (!$hasError) {
            $employeeTargetId = EmployeeTargetService::addValidated($employeeId, $targetValueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $employeeTargetId);
    }

    // TODO: deze aanpassen zodat alleen de uitgevraagde waarden gevalideerd en "overschreven" worden
    static function processEditTarget(  $employeeId,
                                        $employeeTargetId,
                                        EmployeeTargetValueObject $targetValueObject)
    {
        BaseQueries::startTransaction();

        list($hasError, $messages) = EmployeeTargetService::validateEdit($targetValueObject);

        if (!$hasError) {

            $storedValueObject = EmployeeTargetService::getValueObject($employeeId, $employeeTargetId);

            if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
                $targetName           = $targetValueObject->getTargetName();
                $performanceIndicator = $targetValueObject->getPerformanceIndicator();
                $endDate              = $targetValueObject->getEndDate();
            } else {
                $targetName           = $storedValueObject->getTargetName();
                $performanceIndicator = $storedValueObject->getPerformanceIndicator();
                $endDate              = $storedValueObject->getEndDate();
            }

            if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
                $status               = $targetValueObject->getStatus();
                $evaluation           = $targetValueObject->getEvaluation();
                $evaluationDate       = $targetValueObject->getEvaluationDate();
            } else {
                $status               = $storedValueObject->getStatus();
                $evaluation           = $storedValueObject->getEvaluation();
                $evaluationDate       = $storedValueObject->getEvaluationDate();
            }

            $valueObject = EmployeeTargetValueObject::createWithValues( $employeeId,
                                                                        $employeeTargetId,
                                                                        $targetName,
                                                                        $performanceIndicator,
                                                                        $endDate,
                                                                        $status,
                                                                        $evaluation,
                                                                        $evaluationDate);

            EmployeeTargetService::updateValidated($employeeId, $employeeTargetId, $valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processRemoveTarget($employeeId, $employeeTargetId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        EmployeeTargetService::remove($employeeId, $employeeTargetId);

        BaseQueries::finishTransaction();

        return array($hasError, $messages);
    }

    static function processPrintOptionsTarget($employeeId, $showAssessmentCycle)
    {
        list($hasError, $messages) = EmployeeTargetService::validatePrintOptions($showAssessmentCycle);

        if (!$hasError) {
            EmployeePrintService::storeEmployeeIds(                             array($employeeId));
            EmployeePrintService::storeOptionShowEmployeeTargetAssessmentCycleOption( $showAssessmentCycle);
        }
        return array($hasError, $messages);
    }
}
?>
