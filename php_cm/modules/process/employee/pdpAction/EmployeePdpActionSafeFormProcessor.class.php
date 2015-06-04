<?php

/**
 * Description of EmployeePdpActionSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('modules/process/employee/pdpAction/EmployeePdpActionInterfaceProcessor.class.php');
require_once('modules/model/service/employee/pdpAction/EmployeePdpActionService.class.php');
require_once('modules/model/service/employee/pdpAction/EmployeePdpActionController.class.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');

class EmployeePdpActionSafeFormProcessor
{

    static function processRemove(  $objResponse,
                                    $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $employeeId             = $safeFormHandler->retrieveSafeValue('employeeId');
            $employeePdpActionId    = $safeFormHandler->retrieveSafeValue('employeePdpActionId');


            list($hasError, $messages) = EmployeePdpActionController::processRemove($employeeId,
                                                                                    $employeePdpActionId);

            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                EmployeePdpActionInterfaceProcessor::finishRemove(  $objResponse,
                                                                    $employeeId);
            }
        }
        return array($hasError, $messages);
    }


    function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
            $employeeId = $safeFormHandler->retrieveSafeValue('ID_E');
            $id_pdpaid = $safeFormHandler->retrieveSafeValue('ID_PDPAID');
            $id_pdptoid = $safeFormHandler->retrieveInputValue('user_id');
            $start_date = $safeFormHandler->retrieveInputValue('start_date');
            $end_date = $safeFormHandler->retrieveInputValue('end_date');
            $notes = $safeFormHandler->retrieveInputValue('notes');
            $is_completed = $safeFormHandler->retrieveInputValue('is_completed');

            $prev_skills = $safeFormHandler->retrieveInputValue('IDs_PREV_SKILLS'); // ?

            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                //$fill_cluster   = $safeFormHandler->retrieveInputValue('fill_cluster');
                $fill_action    = $safeFormHandler->retrieveInputValue('fill_action');
                $fill_provider  = $safeFormHandler->retrieveInputValue('fill_provider');
                $fill_duration  = $safeFormHandler->retrieveInputValue('fill_duration');

                $fill_cost   = $safeFormHandler->retrieveInputValue('fill_cost');
                if (PdpCostConverter::isValidNumber($fill_cost)) {
                    $fill_cost = PdpCostConverter::value($fill_cost);
                }
            }

            if (CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {
                $action_owner       = $safeFormHandler->retrieveInputValue('action_owner');
                $use_action_owner   = PDP_ACTION_OWNER_EMPLOYEE;
                $id_pds             = NULL;
            } else {
                $action_owner       = NULL;
                $use_action_owner   = PDP_ACTION_OWNER_USER;
                $id_pds             = $safeFormHandler->retrieveSafeValue('ID_PD');
            }

            if (empty($id_pdpaid)
                && CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                $sql = 'SELECT
                            pa.*
                        FROM
                            pdp_actions pa
                        WHERE
                            pa.customer_id = ' . CUSTOMER_ID . '
                            AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_SYSTEM;
                $query = BaseQueries::performTransactionalSelectQuery($sql);
                $actionData = @mysql_fetch_assoc($query);
                $id_pdpaid  = $actionData['ID_PDPA'];
                mysql_free_result($query);
            }

            // validatie
            $hasError = false;

            if (empty($id_pdpaid)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
            }
            if ((empty($id_pdptoid) && !CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) ||
                (empty($action_owner) && CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
            }
            if (empty($end_date)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_A_DEADLINE_DATE');
            }
            if (!PdpActionCompletedStatusValue::isValidValue($is_completed)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_A_COMPLETED_STATUS');
            }
            if (!empty($start_date) && strtotime($start_date) > strtotime($end_date)) {
                $hasError = true;
                $messages[] = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_DEADLINE_DATE');
            }
            if (!CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {
                if(!empty($start_date) && empty($id_pds)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
                } elseif(!empty($id_pds) && empty($start_date)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_SELECT_AN_EMAIL_DATE');
                }
            }
            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
    //            if (empty($fill_cluster)) {
    //                $hasError = true;
    //                $messages[] = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
    //            } else
                if (empty($fill_action)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_ACTION');
                }
                if (empty($fill_provider)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
                }
                if (empty($fill_duration)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_DURATION');
                }
                if (!is_numeric($fill_cost)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_COST');
                }
            }
            // einde validatie

            if (!$hasError) {

                $hasError = true;
                BaseQueries::startTransaction();

                if (CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {

                    $actionOwnerValueObject = EmployeeSelectService::getValueObject($action_owner);
                    $id_pds                 = array($actionOwnerValueObject->getPersonDataId());
                }

                $sql = 'SELECT
                            pa.*
                        FROM
                            pdp_actions pa
                        WHERE
                            pa.customer_id = ' . CUSTOMER_ID . '
                            AND pa.ID_PDPA = ' . $id_pdpaid;
                $actionQuery = BaseQueries::performTransactionalSelectQuery($sql);
                $ge_act_info = @mysql_fetch_assoc($actionQuery);

                if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                    $action         = $ge_act_info['action'];
                    $provider       = $ge_act_info['provider'];
                    $duration       = $ge_act_info['duration'];
                    $cost           = $ge_act_info['costs'];

                    $isUserDefined  =   $action     != $fill_action ||
                                        $provider   != $fill_provider ||
                                        $duration   != $fill_duration ||
                                        $cost       != $fill_cost;
                } else {
                    $fill_action    = $ge_act_info['action'];
                    $fill_provider  = $ge_act_info['provider'];
                    $fill_duration  = $ge_act_info['duration'];
                    $fill_cost      = $ge_act_info['costs'];
                    $isUserDefined  = false;
                }

                //$is_completed = 0;

                $id_pdpea = PdpActionLibraryQueriesDeprecated::addEmployeePdpAction($employeeId,
                                                                                    $id_pdpaid,
                                                                                    $id_pdptoid,
                                                                                    $action_owner,
                                                                                    $use_action_owner,
                                                                                    $fill_action,
                                                                                    $fill_provider,
                                                                                    $fill_duration,
                                                                                    $fill_cost,
                                                                                    ($isUserDefined ? PDP_ACTION_USER_DEFINED : PDP_ACTION_FROM_LIBRARY),
                                                                                    $is_completed,
                                                                                    $start_date,
                                                                                    $end_date,
                                                                                    $notes);

                if (!empty($start_date) && !empty($id_pds)) {
                    $sql = 'SELECT
                                *
                            FROM
                                notification_message
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                            ORDER BY
                                ID_NM';
                    $neQuery = BaseQueries::performQuery($sql);
                    $ne = @mysql_fetch_assoc($neQuery);

                    foreach ($id_pds as $id_pd) {
                        $hash_id = ModuleUtils::createUniqueHash('alerts');
                        PdpActionLibraryQueriesDeprecated::addPdpActionAlert(   $id_pdptoid,
                                                                                $action_owner,
                                                                                $id_pdpea,
                                                                                $hash_id,
                                                                                $id_pd,
                                                                                $ne['ID_NM'],
                                                                                $start_date);

                    }
                }
                PdpActionSkillServiceDeprecated::processActionSkills($id_pdpea, $employeeId, $safeFormHandler);

                BaseQueries::finishTransaction();
                $hasError = false;

                $safeFormHandler->finalizeSafeFormProcess();
                EmployeePdpActionInterfaceProcessor::finishAdd( $objResponse,
                                                                $employeeId);

            }
        }
//        die('error'.print_r($messages,true));
        return array($hasError, $messages);
    }

    function processEdit(   $objResponse,
                            $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $id_pdpea = $safeFormHandler->retrieveSafeValue('ID_PDPEA');
            $employeeId = $safeFormHandler->retrieveSafeValue('ID_E');

            $id_pdpaid = $safeFormHandler->retrieveInputValue('ID_PDPAID');
            $id_pdpaid = !empty($id_pdpaid) ? $id_pdpaid : $safeFormHandler->retrieveSafeValue('prev_ID_PDPAID');

            $id_pdptoid = $safeFormHandler->retrieveInputValue('user_id');
            $is_completed = $safeFormHandler->retrieveInputValue('is_completed');

            $start_date = $safeFormHandler->retrieveInputValue('start_date');
            $end_date = trim($safeFormHandler->retrieveInputValue('end_date'));
            $notes = trim($safeFormHandler->retrieveInputValue('notes'));
            $prev_skills = $safeFormHandler->retrieveInputValue('IDs_PREV_SKILLS');

            //if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                //$fill_cluster   = $safeFormHandler->retrieveInputValue('fill_cluster');
                $fill_action    = $safeFormHandler->retrieveInputValue('fill_action');
                $fill_provider  = $safeFormHandler->retrieveInputValue('fill_provider');
                $fill_duration  = $safeFormHandler->retrieveInputValue('fill_duration');

                $fill_cost   = $safeFormHandler->retrieveInputValue('fill_cost');
                if (PdpCostConverter::isValidNumber($fill_cost)) {
                    $fill_cost = PdpCostConverter::value($fill_cost);
                }
            //}

            if (CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {
                // TODO: validatie
                $action_owner     = $safeFormHandler->retrieveInputValue('action_owner');
                $use_action_owner = PDP_ACTION_OWNER_EMPLOYEE;
                $id_pds           = NULL;
            } else {
                $action_owner       = 'NULL';
                $use_action_owner   = PDP_ACTION_OWNER_USER;
                $id_pds             = $safeFormHandler->retrieveSafeValue('ID_PD');
            }

            if (empty($id_pdpaid)) {
                //&& CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION)
                $sql = 'SELECT
                            pa.*
                        FROM
                            pdp_actions pa
                        WHERE
                            pa.customer_id = ' . CUSTOMER_ID . '
                            AND pa.is_customer_library = ' . PDP_ACTION_LIBRARY_CUSTOMER;
                $query = BaseQueries::performTransactionalSelectQuery($sql);
                $actionData = @mysql_fetch_assoc($query);
                $id_pdpaid  = $actionData['ID_PDPA'];
            }

            // validatie
            $hasError = false;

            if (empty($id_pdpaid)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
            }
            if ((empty($id_pdptoid) && !CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) ||
                (empty($action_owner) && CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
            }
            if (!empty($start_date) && strtotime($start_date) > strtotime($end_date)) {
                $hasError = true;
                $messages[] = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_DEADLINE_DATE');
            }
            if (!PdpActionCompletedStatusValue::isValidValue($is_completed)) {
                $hasError = true;
                $messages[] = TXT_UCF('PLEASE_SELECT_A_COMPLETED_STATUS');
            }
            if (!CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {

                if(!empty($start_date) && empty($id_pds)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_SELECT_AT_LEAST_ONE_EMAIL_ADDRESS');
                } elseif(!empty($id_pds) && empty($start_date)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_SELECT_AN_EMAIL_DATE');
                }
            }
            if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
    //            if (empty($fill_cluster)) {
    //                $hasError = true;
    //                $messages[] = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
    //            } else
                if (empty($fill_action)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_ACTION');
                }
                if (empty($fill_provider)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_PROVIDER');
                }
                if (empty($fill_duration)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_DURATION');
                }
                if (!is_numeric($fill_cost)) {
                    $hasError = true;
                    $messages[] = TXT_UCF('PLEASE_ENTER_THE_COST');
                }
            }
            // end validatie

            if (!$hasError) {
                $hasError = true;
                BaseQueries::startTransaction();

                if (CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER) {

                    $actionOwnerValueObject = EmployeeSelectService::getValueObject($action_owner);
                    $id_pds                 = array($actionOwnerValueObject->getPersonDataId());
                }

                $modified_by_user = USER;
                $modified_time = MODIFIED_TIME;
                $modified_date = MODIFIED_DATE;

                $sql = 'SELECT
                            pa.*
                        FROM
                            pdp_actions pa
                        WHERE
                            pa.customer_id = ' . CUSTOMER_ID . '
                            AND pa.ID_PDPA = ' . $id_pdpaid;
                $actionQuery = BaseQueries::performTransactionalSelectQuery($sql);
                $ge_act_info = @mysql_fetch_assoc($actionQuery);

                if (CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION) {
                    $action         = $ge_act_info['action'];
                    $provider       = $ge_act_info['provider'];
                    $duration       = $ge_act_info['duration'];
                    $cost           = $ge_act_info['costs'];

                    $isUserDefined  =   $action     != $fill_action ||
                                        $provider   != $fill_provider ||
                                        $duration   != $fill_duration ||
                                        $cost       != $fill_cost;
                } else {
//                    $fill_action    = $ge_act_info['action'];
//                    $fill_provider  = $ge_act_info['provider'];
//                    $fill_duration  = $ge_act_info['duration'];
//                    $fill_cost      = $ge_act_info['costs'];
                    $isUserDefined  = false;
                }


                $sql = 'UPDATE
                            employees_pdp_actions
                        SET
                            ID_PDPAID = ' . $id_pdpaid . ',
                            ID_PDPTOID = ' . BaseQueries::nullableValue($id_pdptoid) . ',
                            action_owner = ' . BaseQueries::nullableValue($action_owner) . ',
                            use_action_owner = ' . $use_action_owner . ',
                            action = "' . mysql_real_escape_string($fill_action) . '",
                            provider = "' . mysql_real_escape_string($fill_provider) . '",
                            duration = "' . mysql_real_escape_string($fill_duration) . '",
                            costs = "' . mysql_real_escape_string($fill_cost) . '",
                            start_date = "' . mysql_real_escape_string($start_date) . '",
                            end_date = "' . mysql_real_escape_string($end_date) . '",
                            notes = "' . mysql_real_escape_string($notes) . '",
                            is_user_defined = ' . ($isUserDefined ? PDP_ACTION_USER_DEFINED : PDP_ACTION_FROM_LIBRARY) . ',
                            is_completed = ' . $is_completed . ',
                            modified_by_user = "' . $modified_by_user . '",
                            modified_time = "' . $modified_time . '",
                            modified_date = "' . $modified_date . '"
                        WHERE
                            customer_id = ' .CUSTOMER_ID . '
                            AND ID_E = ' . $employeeId . '
                            AND ID_PDPEA = ' . $id_pdpea;
                BaseQueries::performUpdateQuery($sql);

                // Ook de alerts aanpassen.
                // Eerst de bestaande, nog niet verstuurde action alerts verwijderen
                if (! empty($id_pdpea) ) {
                    $sql = 'DELETE
                            FROM
                                alerts
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND is_done = ' . ALERT_OPEN . '
                                AND is_level = ' . ALERT_PDPACTION . '
                                AND ID_PDPEA = ' . $id_pdpea;
                    BaseQueries::performDeleteQuery($sql);
                }
                if (!empty($start_date) && !empty($id_pds)) {
                    $sql = 'SELECT
                                *
                            FROM
                                notification_message
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                            ORDER BY
                                ID_NM';
                    $neQuery = BaseQueries::performTransactionalSelectQuery($sql);
                    $ne = @mysql_fetch_assoc($neQuery);

                    foreach ($id_pds as $id_pd) {

                        $hash_id = ModuleUtils::createUniqueHash('alerts');
                        PdpActionLibraryQueriesDeprecated::addPdpActionAlert(   $id_pdptoid,
                                                                                $action_owner,
                                                                                $id_pdpea,
                                                                                $hash_id,
                                                                                $id_pd,
                                                                                $ne['ID_NM'],
                                                                                $start_date);

                    }
                }

                PdpActionSkillServiceDeprecated::processActionSkills($id_pdpea, $employeeId, $safeFormHandler);

                BaseQueries::finishTransaction();
                $hasError = false;

                $safeFormHandler->finalizeSafeFormProcess();
                EmployeePdpActionInterfaceProcessor::finishEdit($objResponse,
                                                                $employeeId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEditUserDefined( $objResponse,
                                            $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {

            $employeeId             = $safeFormHandler->retrieveSafeValue('employeeId');
            $employeePdpActionId    = $safeFormHandler->retrieveSafeValue('employeePdpActionId');
            $prevPdpActionId        = $safeFormHandler->retrieveSafeValue('prevPdpActionId');

//            $libraryActionName  = $safeFormHandler->retrieveInputValue('hidden_action');
//            $libraryProvider    = $safeFormHandler->retrieveInputValue('hidden_provider');
//            $libraryDuration    = $safeFormHandler->retrieveInputValue('hidden_duration');
//            $libraryCost        = $safeFormHandler->retrieveInputValue('hidden_cost');

            // vergelijken bij prevPdpActionId/$pdpActionId en inhoud hidden/fill waarden om te bepalen of het een modfied is of niet!


            $pdpActionId            = $safeFormHandler->retrieveInputValue('ID_PDPAID');
            $pdpActionId            = !empty($pdpActionId) ? $pdpActionId : $prevPdpActionId;

            $userDefinedActionName  = $safeFormHandler->retrieveInputValue('fill_action');
            $userDefinedProvider    = $safeFormHandler->retrieveInputValue('fill_provider');
            $userDefinedDuration    = $safeFormHandler->retrieveInputValue('fill_duration');
            $userDefinedCost        = $safeFormHandler->retrieveInputValue('fill_cost');
            if (PdpCostConverter::isValidNumber($userDefinedCost)) {
                $userDefinedCost = PdpCostConverter::value($userDefinedCost);
            }

            $isUserDefined = true;
            if (!empty($pdpActionId)) {
                $pdpActionValueObject = PdpActionService::getValueObject($pdpActionId);
                $isCustomerLibrary  = $pdpActionValueObject->isCustomerDefined();

                if ($isCustomerLibrary) {
                    $isUserDefined      =   $pdpActionValueObject->getActionName()  != $userDefinedActionName ||
                                            $pdpActionValueObject->getProvider()    != $userDefinedProvider ||
                                            $pdpActionValueObject->getDuration()    != $userDefinedDuration ||
                                            $pdpActionValueObject->getCost()        != $userDefinedCost;
                }
            }


            $valueObject = EmployeePdpActionUserDefinedValueObject::createWithValues(   $employeeId,
                                                                                        $employeePdpActionId,
                                                                                        $pdpActionId,
                                                                                        $userDefinedActionName,
                                                                                        $userDefinedProvider,
                                                                                        $userDefinedDuration,
                                                                                        $userDefinedCost,
                                                                                        $isCustomerLibrary,
                                                                                        $isUserDefined);


            list($hasError, $messages) = EmployeePdpActionController::processEditUserDefined(   $employeeId,
                                                                                                $employeePdpActionId,
                                                                                                $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                $safeFormHandler->finalizeSafeFormProcess();
                PdpActionInterfaceProcessor::finishEditUserDefined( $objResponse,
                                                                    $pdpActionId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
