<?php

require_once('modules/model/queries/employee/target/EmployeeTargetQueries.class.php');
require_once('modules/model/valueobjects/employee/target/EmployeeTargetValueObject.class.php');
require_once('modules/model/valueobjects/employee/target/EmployeeTargetCollection.class.php');

class EmployeeTargetService
{
    const VALIDATE_STATUS = true;
    const IGNORE_STATUS = false;

    static function getCollections($employeeId)
    {
        $collections = array();

        $employeeTargetValueObjects = self::getValueObjects($employeeId);

        foreach ($employeeTargetValueObjects as $employeeTargetValueObject) {

            $assessmentCycle = AssessmentCycleService::getCurrentValueObject($employeeTargetValueObject->getEndDate());
            $assessmentCycleStartDate = $assessmentCycle->getStartDate();
            $collection = $collections[$assessmentCycleStartDate];
            if (empty($collection)) {
                $collection = EmployeeTargetCollection::create($assessmentCycle);
            }
            $collection->addEmployeeTargetValueObject($employeeTargetValueObject);
            $collections[$assessmentCycleStartDate] = $collection;
        }

        // controleer of de huidige assessment cycle voorkomt
        $currentAssessmentCycle = AssessmentCycleService::getCurrentValueObject();
        $currentCycleStartDate = $currentAssessmentCycle->getStartDate();
//
        if (!in_array($currentCycleStartDate, array_keys($collections))) {
            $valueObject = EmployeeTargetValueObject::createWithData(   $employeeId,
                                                                        NULL);
            //$valueObject->setAssessmentCycleValueObject($currentAssessmentCycle);
            $collection = EmployeeTargetCollection::create($currentAssessmentCycle);
            $collection->addEmployeeTargetValueObject($valueObject);
            $collections[$currentCycleStartDate] = $collection;
        }

        krsort($collections);
        return $collections;
    }

    static function getValueObjects($employeeId,
                                    $startDate = NULL,
                                    $endDate   = NULL)
    {
        $valueObjects = array();

        $query = EmployeeTargetQueries::getTargetsInPeriod($employeeId,
                                                           $startDate,
                                                           $endDate);

        while ($employeeTargetData = @mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeTargetValueObject::createWithData($employeeId,
                                                                        $employeeTargetData);
        }

        mysql_free_result($query);
        return $valueObjects;
    }

    static function getValueObject($employeeId, $employeeTargetId)
    {
        $valueObject = NULL;

        $query = EmployeeTargetQueries::getTarget($employeeId, $employeeTargetId);
        $employeeTargetData = @mysql_fetch_assoc($query);
        $valueObject = EmployeeTargetValueObject::createWithData($employeeId, $employeeTargetData);

        mysql_free_result($query);
        return $valueObject;
    }


    // Add voegt een taakdoel met evt een status toe.
    static function validateAdd(EmployeeTargetValueObject $valueObject, $validateStatus = self::VALIDATE_STATUS)
    {
        $hasError = false;
        $messages = array();

        $targetName             = $valueObject->getTargetName();
        $performanceIndicator   = $valueObject->getPerformanceIndicator();
        $endDate                = $valueObject->getEndDate();

        if ($validateStatus == self::VALIDATE_STATUS && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
            $status             = $valueObject->getStatus();
            if (!EmployeeTargetStatusValue::isValidValue($status)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_ENTER_A_TARGET_STATUS');
            }
        }

        if (empty($targetName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_TARGET');
        }
        if (empty($performanceIndicator)) {
            $hasError   = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_VALID_PERFORMANCE_INDICATOR');
        }
        if (empty($endDate)) {
            $hasError   = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_TARGET_END_DATE');
        }
        return array($hasError, $messages);
    }


    static function addValidated(   $employeeId,
                                    EmployeeTargetValueObject $valueObject)
    {
        $targetName             = $valueObject->getTargetName();
        $performanceIndicator   = $valueObject->getPerformanceIndicator();
        $endDate                = $valueObject->getEndDate();
        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
            $status             = $valueObject->getStatus();
        } else {
            $status             = NULL;
        }
        $evaluation     = NULL;
        $evaluationDate = NULL;


        $employeeTargetId = EmployeeTargetQueries::insertTarget($employeeId);
        EmployeeTargetQueries::insertTargetData($employeeId,
                                                $employeeTargetId,
                                                $targetName,
                                                $performanceIndicator,
                                                $endDate,
                                                $status,
                                                $evaluation,
                                                $evaluationDate);

        return $employeeTargetId;
    }



    //TODO: samenvoegen target deel validatie in eigen functie
    static function validateEdit(EmployeeTargetValueObject $valueObject)
    {
        $hasError = true;
        $messages = array();
        $evaluationRequired = true;

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGETS)) {
            $hasError = false;
            // als de target editable is hoeft de evaluatie dat niet te zijn.
            $evaluationRequired = false;

            $targetName           = $valueObject->getTargetName();
            $performanceIndicator = $valueObject->getPerformanceIndicator();
            $endDate              = $valueObject->getEndDate();

            if (empty($targetName)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_ENTER_A_TARGET');
            }
            if (empty($performanceIndicator)) {
                $hasError   = true;
                $messages[] = TXT_UCF('PLEASE_ENTER_A_VALID_PERFORMANCE_INDICATOR');
            }
            if (empty($endDate)) {
                $hasError   = true;
                $messages[] = TXT_UCF('PLEASE_ENTER_TARGET_END_DATE');
            }
        }

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_TARGET_EVALUATION)) {
            $hasError = false;

            $status               = $valueObject->getStatus();
            $evaluationDate       = $valueObject->getEvaluationDate();
            $evaluation           = $valueObject->getEvaluation();

            if (!empty($status) || !empty($evaluationDate) || !empty($evaluation)) {
                if (!EmployeeTargetStatusValue::isValidValue($status)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_A_TARGET_STATUS');
                }
                if (!empty($evaluationDate) &&
                    empty($status) && empty($evaluation)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_A_TARGET_STATUS_OR_AN_EVALUATION');
                }
                // als er een status of evaluatie is moet de datum ook ingevuld zijn
                if ((!empty($status) || !empty($evaluation)) &&
                    empty($evaluationDate) ) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_A_CONVERSATION_DATE');
                }
            } else {
                if ($evaluationRequired) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_A_TARGET_STATUS_OR_AN_EVALUATION');
                }
            }
        }
        return array($hasError, $messages);
    }

    static function updateValidated(    $employeeId,
                                        $employeeTargetId,
                                        EmployeeTargetValueObject $valueObject)
    {
        return EmployeeTargetQueries::insertTargetData( $employeeId,
                                                        $employeeTargetId,
                                                        $valueObject->getTargetName(),
                                                        $valueObject->getPerformanceIndicator(),
                                                        $valueObject->getEndDate(),
                                                        $valueObject->getStatus(),
                                                        $valueObject->getEvaluation(),
                                                        $valueObject->getEvaluationDate());
    }

    static function remove($employeeId, $employeeTargetId)
    {
        return EmployeeTargetQueries::deactivateTarget($employeeId, $employeeTargetId);
    }

    static function getHistoryValueObjects($employeeId,
                                           $employeeTargetId)
    {
        $valueObjects = array();

        $query = EmployeeTargetQueries::getHistory($employeeId,
                                                   $employeeTargetId);

        while ($employeeTargetData = @mysql_fetch_assoc($query)) {
            $valueObjects[] = EmployeeTargetValueObject::createWithData($employeeId, $employeeTargetData);
        }

        return $valueObjects;
    }

    static function validatePrintOptions($selectedAssessmentCycleOption)
    {
        $hasError = false;
        $messages = array();

        if (!EmployeeModuleDetailPrintOption::isValidOption($selectedAssessmentCycleOption)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_VALID_ASSESSMENT_CYCLE');
        }

        return array($hasError, $messages);
    }

    static function hasStatus(EmployeeTargetValueObject $valueObject)
    {
        return in_array($valueObject->getStatus(), EmployeeTargetStatusValue::values());
    }

}
?>
