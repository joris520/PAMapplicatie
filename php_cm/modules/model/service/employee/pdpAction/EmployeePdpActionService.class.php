<?php

/**
 * Description of EmployeePdpActionService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/employee/pdpAction/EmployeePdpActionQueries.class.php');
require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionValueObject.class.php');
require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionUserDefinedValueObject.class.php');
require_once('modules/model/value/employee/pdpAction/PdpActionCompletedStatusValue.class.php');

require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionUserDefinedCollection.class.php');
require_once('modules/model/valueobjects/library/PdpActionUserDefinedCollection.class.php');

class EmployeePdpActionService
{

    static function getValueObjects($employeeId)
    {
        $valueObjects = array();

        $query = EmployeePdpActionQueries::getEmployeePdpActions($employeeId);

        while ($employeePdpActionData = @mysql_fetch_assoc($query)) {
            $valueObject = EmployeePdpActionValueObject::createWithData($employeeId,
                                                                        $employeePdpActionData);

            $todoBeforeDate = $valueObject->getTodoBeforeDate();

            // bij welke assessment cycle hoort deze actie?
            $assessmentCycleValueObject = AssessmentCycleService::getCurrentValueObject($todoBeforeDate);

            // nog snel even de assessment cycle in de data opslaan
            $valueObject->setAssessmentCycleValueObject($assessmentCycleValueObject);

            // en groeperen per assessment cycle. Omdat er geen periodes met dezelfde startdatum mogen zijn kan dit als groupering gebruikt worden
            $valueObjects[$assessmentCycleValueObject->getStartDate()][] = $valueObject;
        }

        mysql_free_result($query);

        // controleer of de huidige assessment cycle voorkomt
        $currentAssessmentCycle = AssessmentCycleService::getCurrentValueObject();
        $currentCycleStartDate = $currentAssessmentCycle->getStartDate();

        if (!in_array($currentCycleStartDate, array_keys($valueObjects))) {
            $valueObject = EmployeePdpActionValueObject::createWithData($employeeId,
                                                                        NULL);
            $valueObject->setAssessmentCycleValueObject($currentAssessmentCycle);
            $valueObjects[$currentAssessmentCycle->getStartDate()][] = $valueObject;
        }
        // omdat de query de oudste datum eerst geeft moet de sortering voor de groupering omgedraaid worden
        krsort($valueObjects);

        return $valueObjects;
    }

    static function getValueObject( $employeeId,
                                    $employeePdpActionId)
    {
        $query = EmployeePdpActionQueries::getEmployeePdpActions(   $employeeId,
                                                                    $employeePdpActionId);
        $employeePdpActionData = @mysql_fetch_assoc($query);

        $valueObject = EmployeePdpActionValueObject::createWithData($employeeId,
                                                                    $employeePdpActionData);

        mysql_free_result($query);

        return $valueObject;
    }

    static function removeEmployeePdpAction($employeeId,
                                            $employeePdpActionId)
    {
        if (!empty($employeePdpActionId)) {
            // de actie/skill koppeling verwijderen
            PdpActionSkillServiceDeprecated::deletePdpActionSkills($employeePdpActionId);

            // taken ophalen
            $sql = 'SELECT
                        *
                    FROM
                        employees_pdp_tasks
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_PDPEA  = ' . $employeePdpActionId;
            $get_pdpet = BaseQueries::performQuery($sql);

            if (@mysql_num_rows($get_pdpet) > 0) {
                // per taak de alert verwijderen
                while ($get_pdpet_row = @mysql_fetch_assoc($get_pdpet)) {
                    if ( ! empty($get_pdpet_row['ID_PDPET'])) {
                        $sql = 'DELETE
                                FROM
                                    alerts
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_PDPET = ' . $get_pdpet_row['ID_PDPET'] . '
                                    AND is_level = ' . ALERT_PDPACTIONTASK;
                        BaseQueries::performQuery($sql);
                    }
                }
            }

            // dan de actie alert
            $sql = 'DELETE
                    FROM
                        alerts
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_PDPEA = ' . $employeePdpActionId . '
                        AND is_level = ' . ALERT_PDPACTION;
            BaseQueries::performQuery($sql);

            // vervolgens eerst de taken verwijderen vanwege foreign key constraint
            $sql = 'DELETE
                    FROM
                        employees_pdp_tasks
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_E = ' . $employeeId . '
                        AND ID_PDPEA = ' . $employeePdpActionId;
            BaseQueries::performQuery($sql);
            // tenslotte de actie
            $sql = 'DELETE
                    FROM
                        employees_pdp_actions
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_E = ' . $employeeId . '
                        AND ID_PDPEA = ' . $employeePdpActionId;
            BaseQueries::performQuery($sql);
        }
    }

    static function updateExistingEmployeePdpActions(PdpActionValueObject $pdpActionValueObject)
    {
        $pdpActionId = $pdpActionValueObject->getId();

        $updateCount = 0;
        if (!empty($pdpActionId)) {
            $updateCount = EmployeePdpActionQueries::updateExistingEmployeePdpActions(  $pdpActionId,
                                                                                        $pdpActionValueObject->getActionName(),
                                                                                        $pdpActionValueObject->getProvider(),
                                                                                        $pdpActionValueObject->getDuration(),
                                                                                        $pdpActionValueObject->getCost());
        }
        return $updateCount;
    }

    static function getEmployeeValueObjectsForPdpAction($pdpActionId,
                                                        $allowedEmployeeIds)
    {
        $valueObjects = array();
        $query = EmployeePdpActionQueries::findEmployees(   $pdpActionId,
                                                            $allowedEmployeeIds);
        while ($employeeProfileData = mysql_fetch_assoc($query)) {

            $valueObjects[] = EmployeeProfilePersonalValueObject::createWithData(   $employeeProfileData[EmployeeProfileQueries::ID_FIELD],
                                                                                    $employeeProfileData);
        }

        mysql_free_result($query);
        return $valueObjects;
    }

    static function getEmployeeIdValuesForPdpAction($pdpActionId,
                                                    Array $allowedEmployeeIds)
    {
        $employeeValueIds = array();
        $query = EmployeePdpActionQueries::findEmployees(   $pdpActionId,
                                                            $allowedEmployeeIds);
        while ($employeeProfileData = mysql_fetch_assoc($query)) {
            $employeeId     = $employeeProfileData[EmployeeProfileQueries::ID_FIELD];
            $pdpActionCount = $employeeProfileData['pdp_action_count'];
            $employeeValueIds[$employeeId] = IdValue::create($employeeId, $pdpActionCount);
        }

        mysql_free_result($query);
        return $employeeValueIds;
    }

    static function getUserDefinedClusterGroupCollection($allowedEmployeeIds)
    {

        $userDefinedClusterValueObject = PdpActionClusterService::getUserDefinedClusterValueObject();

        $groupCollection = PdpActionUserDefinedGroupCollection::create($userDefinedClusterValueObject);
        // alle user defined pdp acties bij de medewerkers vinden

        $query = EmployeePdpActionQueries::getUserDefinedPdpActions($allowedEmployeeIds);
        while ($pdpActionUserDefinedData = mysql_fetch_assoc($query)) {
            $valueObject = EmployeePdpActionUserDefinedValueObject::createWithData($pdpActionUserDefinedData);
            $pdpActionId = $valueObject->getId();

            $collection = $groupCollection->getCollection($pdpActionId);
            if (empty($collection)) {
                $collection = EmployeePdpActionUserDefinedCollection::create(   $pdpActionId,
                                                                                $valueObject->getLibraryActionName(),
                                                                                $valueObject->isCustomerLibrary());
            }

            $collection->addValueObject($valueObject);

            $groupCollection->setCollection($pdpActionId,
                                            $collection);
        }
        return $groupCollection;
    }


    // user defined edit in de pdp action library
    static function getUserDefinedValueObject(  $employeeId,
                                                $employeePdpActionId)
    {
        $query = EmployeePdpActionQueries::getUserDefinedPdpActions($employeeId,
                                                                    $employeePdpActionId);

        while ($pdpActionUserDefinedData = mysql_fetch_assoc($query)) {
            $userDefinedValueObject = EmployeePdpActionUserDefinedValueObject::createWithData($pdpActionUserDefinedData);
        }
        return $userDefinedValueObject;
    }

    static function validateUserDefined(EmployeePdpActionUserDefinedValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();


        $pdpActionId    = $valueObject->getId();
        $actionName     = $valueObject->getUserDefinedActionName();
        $provider       = $valueObject->getUserDefinedProvider();
        $duration       = $valueObject->getUserDefinedDuration();
        $cost           = $valueObject->getUserDefinedCost();

        if (empty($pdpActionId)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
        }
        if (empty($actionName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_ACTION');
        }
        if (empty($provider)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
        }
        if (empty($duration)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_DURATION');
        }
        if (!is_numeric($cost)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_THE_COST');
        }

        return array($hasError, $messages);
    }

    static function updateValidatedUserDefined( $employeeId,
                                                $employeePdpActionId,
                                                EmployeePdpActionUserDefinedValueObject $valueObject)
    {
        EmployeePdpActionQueries::updateUserDefinedPdpAction(   $employeeId,
                                                                $employeePdpActionId,
                                                                $valueObject->getId(),
                                                                $valueObject->isUserDefined() ? PDP_ACTION_USER_DEFINED : PDP_ACTION_FROM_LIBRARY,
                                                                $valueObject->getUserDefinedActionName(),
                                                                $valueObject->getUserDefinedProvider(),
                                                                $valueObject->getUserDefinedDuration(),
                                                                $valueObject->getUserDefinedCost());


    }
}

?>
