<?php
/**
 * Description of EmployeePdpActions
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/to_refactor/EmployeePdpActionQueriesDeprecated.class.php');
require_once('modules/model/service/to_refactor/PdpActionsServiceDeprecated.class.php');

class EmployeePdpActionsServiceDeprecated {

    static function getEmployeePdpActions($employee_id)
    {
        $employeePdpActions = array();
        $employeePdpActionsResult = EmployeePdpActionQueriesDeprecated::getEmployeePdpActions($employee_id);
        while ($employeePdpAction = @mysql_fetch_assoc($employeePdpActionsResult)) {
            $employeePdpActions[] = $employeePdpAction;
        }
        return $employeePdpActions;
    }

    static function getPdpActionDetails($employee_id, $pdpAction_id)
    {
        $employeePdpActionDetails = array();
        $employeePdpActionDetailResult = EmployeePdpActionQueriesDeprecated::getEmployeePdpAction($employee_id, $pdpAction_id);
        $employeePdpAction = @mysql_fetch_assoc($employeePdpActionDetailResult);

        $owner_mode_label = '';
        if ($employeePdpAction['use_action_owner'] == PDP_ACTION_OWNER_EMPLOYEE) {
            if ($employeePdpAction['action_owner'] == $employee_id ) {
                $owner_mode_label = TXT_LC('EMPLOYEE');
            } else {
                $owner_mode_label = TXT_LC('BOSS');
            }
            $owner_mode_label = '(' . $owner_mode_label . ')';
//        } else {
//            $owner_mode_label = TXT_LC('USER');
        }


        $employeePdpAction['owner_mode_label'] = $owner_mode_label;
        $employeePdpActionDetails['actionDetails'] = $employeePdpAction;
        $employeePdpActionDetails['actionTasks'] = array();

        $employeePdpActionTasksResult = EmployeePdpActionQueriesDeprecated::getEmployeePdpActionTasks($employee_id, $pdpAction_id);

        while ($employeePdpActionTask = @mysql_fetch_assoc($employeePdpActionTasksResult)) {
            $employeePdpActionDetails['actionTasks'][] = $employeePdpActionTask;
        }

        return $employeePdpActionDetails;
    }

    static function getEmployeePdpActionCompetences($employee_id, $employeePdpActionId)
    {
        $competenceIds = array();
        $competencesResult = EmployeePdpActionQueriesDeprecated::getEmployeePdpActionCompetences($employee_id, $employeePdpActionId);
        while ($competence = @mysql_fetch_assoc($competencesResult)) {
            $competenceIds[] = $competence['competence_id'];
        }
        return $competenceIds;
    }

    static function deleteEmployeePdpAction($employee_id, $pdpAction_id)
    {
        // hbd: ook de actie/skill koppeling verwijderen
        PdpActionSkillServiceDeprecated::deletePdpActionSkills($pdpAction_id);

        AlertsService::deletePdpActionTaskAlerts($employee_id, $pdpAction_id);
        AlertsService::deletePdpActionAlerts($pdpAction_id);
        EmployeePdpActionQueriesDeprecated::deletePdpActionTasks($employee_id, $pdpAction_id);
        EmployeePdpActionQueriesDeprecated::deletePdpAction($employee_id, $pdpAction_id);
    }

    static function deleteEmployeePdpActionTask($employee_id, $pdpAction_id, $pdpActionTask_id)
    {
        AlertsService::deletePdpActionTaskAlert($pdpActionTask_id);
        EmployeePdpActionQueriesDeprecated::deletePdpActionTask($employee_id, $pdpAction_id, $pdpActionTask_id);
    }


    static function getEmployeePdpActionState($employee_id, $pdpAction_id)
    {
        $employeePdpActionDetailResult = EmployeePdpActionQueriesDeprecated::getEmployeePdpActionState($employee_id, $pdpAction_id);
        $employeePdpAction = @mysql_fetch_assoc($employeePdpActionDetailResult);

        return $employeePdpAction['is_completed'];
    }

    static function getEmployeePdpActionTaskState($employee_id, $pdpActionTask_id)
    {
        $employeePdpActionTaskDetailResult = EmployeePdpActionQueriesDeprecated::getEmployeePdpActionTaskState($employee_id, $pdpActionTask_id);
        $employeePdpAction = @mysql_fetch_assoc($employeePdpActionTaskDetailResult);

        return $employeePdpAction['is_completed'];
    }

    static function validatePdpActionState($state_value)
    {
        $hasError = false;
        $message = '';

        if ($state_value != PdpActionCompletedStatusValue::NOT_COMPLETED &&
            $state_value != PdpActionCompletedStatusValue::COMPLETED &&
            $state_value != PdpActionCompletedStatusValue::CANCELLED) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_STATUS');
        }
        return array($hasError, $message);
    }

    static function validateAndUpdatePdpActionState($employee_id, $pdpAction_id, $state_value)
    {
        $hasError = false;
        $message = '';

        list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionState($state_value);
        if (!$hasError) {
            EmployeePdpActionQueriesDeprecated::updateEmployeePdpActionState($employee_id, $pdpAction_id, $state_value);
            // TODO: onderliggende tasks alerts ??
            if ($state_value == PdpActionCompletedStatusValue::NOT_COMPLETED) {
                AlertsService::activateCancelledPdpActionAlert($pdpAction_id);
            } else {
                AlertsService::deactivateOpenPdpActionAlert($pdpAction_id);
            }
        }
        return array($hasError, $message);
    }

    static function validatePdpActionTaskState($state_value)
    {
        $hasError = false;
        $message = '';

        if ($state_value != PDP_TASK_COMPLETED && $state_value != PDP_TASK_NOT_COMPLETED) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_STATUS');
        }
        return array($hasError, $message);
    }

    static function validateAndUpdatePdpActionTaskState($employee_id, $pdpActionTask_id, $state_value)
    {
        $hasError = false;
        $message = '';

        list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionTaskState($state_value);
        if (!$hasError) {
            EmployeePdpActionQueriesDeprecated::updateEmployeePdpActionTaskState($employee_id, $pdpActionTask_id, $state_value);
            // TODO: onderliggende tasks alerts ??
            if ($state_value == PdpActionCompletedStatusValue::NOT_COMPLETED) {
                AlertsService::activateCancelledPdpActionTaskAlert($pdpActionTask_id);
            } else {
                AlertsService::deactivateOpenPdpActionTaskAlert($pdpActionTask_id);
            }
        }
        return array($hasError, $message);
    }

    static function validatePdpActionSelectedAction($selectedPdpAction_id)
    {
        $hasError = false;
        $message = '';

        if (empty($selectedPdpAction_id)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
        } else {
            $pdpLibraryAction = PdpActionsServiceDeprecated::getPdpAction($selectedPdpAction_id);
            if (empty($pdpLibraryAction['ID_PDPA']) || $pdpLibraryAction['ID_PDPA'] != $selectedPdpAction_id) {
                $hasError = true;
                $message = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
            }
        }
        return array($hasError, $message);

    }

    static function validatePdpActionSelectedCompetences($employee_id, $selectedCompetenceIds)
    {
        $hasError = false;
        $message = '';

        // TODO: controleren of dit bestaande competenties zijn?

        return array($hasError, $message);

    }

    static function validatePdpActionOwnerDates($employee_id,
                                                $actionOwnerEmployeeId,
                                                $deadlineDate,
                                                $notificationDate)
    {
        $hasError = false;
        $message = '';

        if (empty($actionOwnerEmployeeId)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
        } elseif (empty($deadlineDate)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_START_DATE');
        } elseif (!empty($notificationDate) && strtotime($notificationDate) >= strtotime($deadlineDate)) {
            $hasError = true;
            $message = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_DEADLINE_DATE');
        } elseif (!empty($notificationDate)) {
            // ophalen email actionOwner
            $employeeInfo = EmployeeProfileServiceDeprecated::getEmployeeProfileInfo($actionOwnerEmployeeId);
            $notificationEmail = $employeeInfo['email_address'];
            if (empty($notificationEmail)) {
                $hasError = true;
                $message = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
            }
        }
//        } else {
//            $pdpLibraryAction = PdpActionsServiceDeprecated::getPdpAction($selectedPdpAction_id);
//            if (empty($pdpLibraryAction['ID_PDPA']) || $pdpLibraryAction['ID_PDPA'] != $selectedPdpAction_id) {
//                $hasError = true;
//                $message = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
//            }
//        }
        return array($hasError, $message);

    }

    static function validateAndAddEmployeePdpAction($employee_id,
                                                    $selectedPdpActionId,
                                                    $selectedCompetenceIds,
                                                    $actionOwnerEmployeeId,
                                                    $deadlineDate,
                                                    $notificationDate,
                                                    $notes)
    {
        $hasError = false;
        $message = '';
        $newEmployeePdpActionId = null;

        // validatie
        list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionSelectedAction($selectedPdpActionId);
        if (!$hasError) {
            list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionSelectedCompetences($employee_id,
                                                                                                 $selectedCompetenceIds);
        }
        if (!$hasError) {
            list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionOwnerDates($employee_id,
                                                                                        $actionOwnerEmployeeId,
                                                                                        $deadlineDate,
                                                                                        $notificationDate);
        }

        if (!$hasError) {
            // verwerken
            $hasError = true;
            BaseQueries::startTransaction();

            // 1) ophalen pdpactie gegevens uit library
            $pdpAction = PdpActionsServiceDeprecated::getPdpAction($selectedPdpActionId);
            $action    = $pdpAction['action'];
            $provider  = $pdpAction['provider'];
            $duration  = $pdpAction['duration'];
            $costs     = $pdpAction['costs'];

            // 1) employee actie toevoegen
            $newEmployeePdpActionId = EmployeePdpActionQueriesDeprecated::addEmployeePdpAction($employee_id,
                                                                                     $selectedPdpActionId,
                                                                                     $actionOwnerEmployeeId,
                                                                                     $action,
                                                                                     $provider,
                                                                                     $duration,
                                                                                     $costs,
                                                                                     PdpActionCompletedStatusValue::NOT_COMPLETED,
                                                                                     $deadlineDate,
                                                                                     $notificationDate,
                                                                                     $notes);
            // 2) alert

            if (!empty($notificationDate)) {
                $personData = personDataService::getPersonDataByEmployeeId($actionOwnerEmployeeId);
                $alertMessageId = AlertsService::getPdpActionNotificationMessageId();
                AlertsService::insertPdpActionAlert($newEmployeePdpActionId,
                                             $actionOwnerEmployeeId,
                                             $personData['ID_PD'],
                                             $alertMessageId,
                                             $notificationDate);
            }
            // gekoppelde competenties opslaan
            EmployeePdpActionsServiceDeprecated::processPdpActionCompetences($employee_id,
                                                            $newEmployeePdpActionId,
                                                            $selectedCompetenceIds);

            BaseQueries::finishTransaction();
            $hasError = false;
        }

        return array($hasError, $message, $newEmployeePdpActionId);
    }

    static function validateAndUpdateEmployeePdpAction($employee_id,
                                                       $updateEmployeePdpActionId,
                                                       $selectedPdpActionId,
                                                       $selectedCompetenceIds,
                                                       $actionOwnerEmployeeId,
                                                       $deadlineDate,
                                                       $notificationDate,
                                                       $notes)
    {
        $hasError = false;
        $message = '';

        // validatie
        list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionSelectedAction($selectedPdpActionId);
        if (!$hasError) {
            list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionSelectedCompetences($employee_id,
                                                                                                 $selectedCompetenceIds);
        }
        if (!$hasError) {
            list($hasError, $message) = EmployeePdpActionsServiceDeprecated::validatePdpActionOwnerDates($employee_id,
                                                                                        $actionOwnerEmployeeId,
                                                                                        $deadlineDate,
                                                                                        $notificationDate);
        }

        if (!$hasError) {
            // verwerken
            $hasError = true;
            BaseQueries::startTransaction();

            // 1) ophalen pdpactie gegevens uit library

            $pdpAction = PdpActionsServiceDeprecated::getPdpAction($selectedPdpActionId);
            $action = $pdpAction['action'];
            $provider = $pdpAction['provider'];
            $duration = $pdpAction['duration'];
            $costs = $pdpAction['costs'];

            // 1) employee actie updaten
            EmployeePdpActionQueriesDeprecated::updateEmployeePdpAction($employee_id,
                                                              $updateEmployeePdpActionId,
                                                              $selectedPdpActionId,
                                                              $actionOwnerEmployeeId,
                                                              $action,
                                                              $provider,
                                                              $duration,
                                                              $costs,
                                                              $deadlineDate,
                                                              $notificationDate,
                                                              $notes);

            $personData = personDataService::getPersonDataByEmployeeId($actionOwnerEmployeeId);
            $alertMessageId = AlertsService::getPdpActionNotificationMessageId();
            AlertsService::updatePdpActionAlert($updateEmployeePdpActionId,
                                         $actionOwnerEmployeeId,
                                         $personData['ID_PD'],
                                         $alertMessageId,
                                         $notificationDate);
            // gekoppelde competenties vervangen
            EmployeePdpActionsServiceDeprecated::processPdpActionCompetences($employee_id,
                                                            $updateEmployeePdpActionId,
                                                            $selectedCompetenceIds);

            BaseQueries::finishTransaction();
            $hasError = false;
        }

        return array($hasError, $message, $updateEmployeePdpActionId);
    }

    // TODO: refactor pdpActionSkills!
    static function processPdpActionCompetences($employee_id, $employeePdpActionId, $selectedCompetenceIds)
    {
        EmployeePdpActionQueriesDeprecated::deleteEmployeePdpActionCompetences($employee_id, $employeePdpActionId);
        foreach ($selectedCompetenceIds as $selectedCompetenceId) {
            EmployeePdpActionQueriesDeprecated::insertEmployeePdpActionCompetence($employee_id,
                                                                        $employeePdpActionId,
                                                                        $selectedCompetenceId);
        }

    }



    static function deletePdpAction($employee_id, $pdpAction_id)
    {
        // TODO: implement!
    }

    static function deletePdpActionTask($employee_id, $pdpAction_id, $pdpActionTask_id)
    {
        AlertsService::deletePdpActionTaskAlert($pdpActionTask_id);
        return EmployeePdpActionQueriesDeprecated::deletePdpActionTask($employee_id, $pdpAction_id, $pdpActionTask_id);
    }


}

?>
