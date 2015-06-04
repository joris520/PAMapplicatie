<?php
require_once('modules/model/service/to_refactor/ThreesixtyEmailService.class.php');
require_once('modules/interface/components/select/SelectEmployees.class.php');
require_once('modules/model/queries/to_refactor/BatchQueries.class.php');

require_once('modules/process/tab/OrganisationTabInterfaceProcessor.class.php');

/**
 * Displays form for adding PDP actions in Batch.
 */


function moduleOrganisation_pdpActionsBatchForm()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_PDP_ACTIONS)) {
        unset($_SESSION['ID_E']);

        $limitActionOwner = CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER;

        $labelWidth = 130;
        $selectEmps = new SelectEmployees();
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ORGANISATION__PDPACTIONS_ADD_BATCH);

        $safeFormHandler->addIntegerInputFormatType('ID_PDPAID');
        $safeFormHandler->addStringInputFormatType('start_date');
        $safeFormHandler->addStringInputFormatType('end_date');
        $safeFormHandler->addStringInputFormatType('notes');

        $safeFormHandler->addStringInputFormatType('fill_action');
        $safeFormHandler->addStringInputFormatType('fill_provider');
        $safeFormHandler->addStringInputFormatType('fill_duration');
        $safeFormHandler->addStringInputFormatType('fill_cost');

        if ($limitActionOwner) {
            $safeFormHandler->addIntegerInputFormatType('action_owner');
        } else {
            $safeFormHandler->addIntegerInputFormatType('user_id');
            $safeFormHandler->addIntegerArrayInputFormatType('ID_PD');
        }

        $selectEmps->fillSafeFormValues($safeFormHandler);

        $safeFormHandler->finalizeDataDefinition();

        $pdpActionLibrarySelector = EmployeePdpActionInterfaceBuilder::getPdpActionLibrarySelector( EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_WIDTH,
                                                                                                    $labelWidth,
                                                                                                    EmployeePdpActionInterfaceProcessor::PDP_ACTION_LIBRARY_HEIGHT,
                                                                                                    NULL);

//        $selectablePdpActionLibraryId = $isUserDefined ? $pdpActionLibraryId : NULL;
        //$selectablePdpActionClusterId = $isUserDefined ? $pdpActionClusterId : NULL;

        $deadline_date = DEFAULT_DATE;
        $strStartDate  = DateUtils::calculateRelativeDisplayDate($deadline_date, DEFAULT_ALERTDATE_OFFSET);

        $calendarInputDeadlineDate = DateUtils::convertToDatabaseDate($deadline_date);
        $calendarInputDeadlineOnChangeFunction = 'showDateRelative(\'end_date\', ' . JS_DEFAULT_DATE_FORMAT . ', \'start_date\', ' . JS_RELATIVE_DAYS_DEADLINE . ');';
        $calendarInputNotificationDate = DateUtils::convertToDatabaseDate($strStartDate);


        $calendarInputDeadlineDateHtml = InterfaceBuilderComponents::getCalendarInputHtml(  'end_date',
                                                                                            $calendarInputDeadlineDate,
                                                                                            InterfaceBuilderComponents::CALENDAR_INPUT_NO_CLASS,
                                                                                            InterfaceBuilderComponents::CALENDAR_INPUT_READONLY,
                                                                                            $calendarInputDeadlineOnChangeFunction);

        $calendarInputNotificationDateHtml = InterfaceBuilderComponents::getCalendarInputHtml(  'start_date',
                                                                                                $calendarInputNotificationDate) ;


        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_organisation/pdpActionsBatchForm.tpl');
        $tpl->assign('formIdentifier', $safeFormHandler->getFormIdentifier());
        $tpl->assign('formToken', $safeFormHandler->getTokenHiddenInputHtml());
        $tpl->assign('labelWidth', $labelWidth);
        $tpl->assign('pdpActionLibrarySelectorHtml', $pdpActionLibrarySelector->fetchHtml());

        $tpl->assign('calendarInputDeadlineDateHtml', $calendarInputDeadlineDateHtml);
        $tpl->assign('calendarInputNotificationDateHtml', $calendarInputNotificationDateHtml);

        $tpl->assign('limitActionOwner', $limitActionOwner);
        if ($limitActionOwner) {
            $tpl->assign('boss_selected_value', SELECT_PDP_ACTION_OWNER_BOSS);
            $tpl->assign('employee_selected_value', SELECT_PDP_ACTION_OWNER_EMPLOYEE);
        }
        $selectEmps->fillComponent($tpl);

        if (!$limitActionOwner) {
            $tpl->assign('emails_for_notification', getEmailsForNotificationHtml(1, ''));

            // get owners
            $sql = 'SELECT
                        *
                    FROM
                        users
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        name';
            $get_pdpto = BaseQueries::performQuery($sql);

            $owners = array();
            while ($get_pdpto_row = @mysql_fetch_assoc($get_pdpto)) {
                $owners[] = $get_pdpto_row;
            }
            $tpl->assign('owners', $owners);  //
        }


        $pdpActionsTitle = TXT_UCW('ADD_COLLECTIVE_PDP_ACTION');
        $pdpActionsBlock = BaseBlockHtmlInterfaceObject::create($pdpActionsTitle, 1100);
        $pdpActionsBlock->setContentHtml($smarty->fetch($tpl));
        $pdpActionsHtml = $pdpActionsBlock->fetchHtml();

        OrganisationTabInterfaceProcessor::displayContent(  $objResponse, 1100, $pdpActionsHtml);
        ApplicationNavigationProcessor::activateModuleMenu( $objResponse, MODULE_ORGANISATION_MENU_PDP_ACTIONS_BATCH);
    }
    return $objResponse;
}

/**
 * Processes form for adding PDP actions in Batch.
 */
function organisation__processSafeForm_addPdpActionsBatch($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_PDP_ACTIONS)) {
        unset($_SESSION['ID_E']);

        $limitActionOwner = CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER;

        $selectEmployees = new SelectEmployees();

        $pdpActionId        = $safeFormHandler->retrieveInputValue('ID_PDPAID');
        $emailToIds         = $safeFormHandler->retrieveInputValue('ID_PD');
        if ($limitActionOwner) {
            $actionOwnerType    = $safeFormHandler->retrieveInputValue('action_owner');
        } else {
            $actionOwnerUserId  = $safeFormHandler->retrieveInputValue('user_id');
        }
        $notficationDate    = $safeFormHandler->retrieveInputValue('start_date');
        $deadlineDate       = $safeFormHandler->retrieveInputValue('end_date');
        $notes              = $safeFormHandler->retrieveInputValue('notes');


        // validatie
        $hasError = false;
        if (empty($pdpActionId)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_PDP_ACTION');
        } elseif (empty($actionOwnerUserId) && empty($actionOwnerType)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
        } elseif (empty($deadlineDate)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_DEADLINE_DATE');
        } elseif (!empty($notficationDate) && strtotime($notficationDate) > strtotime($deadlineDate)) {
            $hasError = true;
            $message = TXT_UCF('NOTIFICATION_DATE_CANNOT_BE_GREATER_THAN_DEADLINE_DATE');
        } elseif (!$selectEmployees->validateFormInput($safeFormHandler->retrieveCleanedValues())) {
            $hasError = true;
            $message = $selectEmployees->getErrorTxt();
        }

        // verwerken
        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            // gekozen pdp actie ophalen
            $sql = 'SELECT
                        *
                    FROM
                        pdp_actions
                    WHERE
                        ID_PDPA = ' . $pdpActionId;

            $query = BaseQueries::performTransactionalSelectQuery($sql);
            $pdpAction = @mysql_fetch_assoc($query);

            $pdpAction_action   = $pdpAction['action'];
            $pdpAction_provider = $pdpAction['provider'];
            $pdpAction_duration = $pdpAction['duration'];
            $pdpAction_costs    = $pdpAction['costs'];
            $pdpAction_completed = PdpActionCompletedStatusValue::NOT_COMPLETED;

            // voor elke geselecteerde employee_id de employee_pdp_actie aamaken
            $employeeIds = $selectEmployees->processResults($safeFormHandler->retrieveCleanedValues());

            $employeePdIds = batch_pdpAction_getEmployeePdIds(  $actionOwnerType,
                                                                $employeeIds);
            $actionOwnerIds = batch_pdpAction_getActionOwnerIds($actionOwnerType,
                                                                $employeeIds);

            if (!empty($notficationDate)) {
                // ophalen message id
                $sql = 'SELECT
                            ID_NM
                        FROM
                            notification_message
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                        ORDER BY
                            ID_NM';
                $neQuery = BaseQueries::performTransactionalSelectQuery($sql);
                $ne = @mysql_fetch_assoc($neQuery);
                $notificationMessageId = $ne['ID_NM'];
            }
            foreach ($employeeIds as $employeeId) {
                if ($limitActionOwner) {
                    $actionOwnerId = $actionOwnerIds[$employeeId];
                    $personDataId  = $employeePdIds[$employeeId];
                    $sql = 'INSERT INTO
                                employees_pdp_actions
                                (   customer_id,
                                    ID_E,
                                    ID_PDPAID,
                                    action_owner,
                                    use_action_owner,
                                    action,
                                    provider,
                                    duration,
                                    costs,
                                    is_completed,
                                    start_date,
                                    end_date,
                                    notes,
                                    modified_by_user,
                                    modified_time,
                                    modified_date
                                )
                                SELECT
                                    ' . CUSTOMER_ID . ',
                                    ' . $employeeId . ',
                                    ' . $pdpActionId . ',
                                    ' . $actionOwnerId . ',
                                    ' . PDP_ACTION_OWNER_EMPLOYEE . ',
                                    "' . mysql_real_escape_string($pdpAction_action) . '",
                                    "' . mysql_real_escape_string($pdpAction_provider) . '",
                                    "' . mysql_real_escape_string($pdpAction_duration) . '",
                                    "' . mysql_real_escape_string($pdpAction_costs) . '",
                                    ' . $pdpAction_completed . ',
                                    "' . mysql_real_escape_string($notficationDate) . '",
                                    "' . mysql_real_escape_string($deadlineDate) . '",
                                    "' . mysql_real_escape_string($notes) . '",
                                    "' . $modified_by_user . '",
                                    "' . $modified_time . '",
                                    "' . $modified_date . '"
                                FROM
                                    employees e
                                WHERE
                                    e.customer_id = ' . CUSTOMER_ID . '
                                    AND e.ID_E = ' . $employeeId;

                    $employeePdpActionId = BaseQueries::performInsertQuery($sql);

                    if (!empty($notficationDate)) {
                        $hash_id = ModuleUtils::createUniqueHash('alerts');
                        PdpActionLibraryQueriesDeprecated::addPdpActionAlert(   NULL,
                                                                                $actionOwnerId,
                                                                                $employeePdpActionId,
                                                                                $hash_id,
                                                                                $personDataId,
                                                                                $notificationMessageId,
                                                                                $notficationDate);
                    }

                } else { // oude stijl
                    $sql = 'INSERT INTO
                                employees_pdp_actions
                                (   customer_id,
                                    ID_E,
                                    ID_PDPAID,
                                    ID_PDPTOID,
                                    action,
                                    provider,
                                    duration,
                                    costs,
                                    is_completed,
                                    start_date,
                                    end_date,
                                    notes,
                                    modified_by_user,
                                    modified_time,
                                    modified_date
                                ) VALUES (
                                    ' . CUSTOMER_ID . ',
                                    ' . $employeeId . ',
                                    ' . $pdpActionId . ',
                                    ' . $actionOwnerUserId . ',
                                    "' . mysql_real_escape_string($pdpAction_action) . '",
                                    "' . mysql_real_escape_string($pdpAction_provider) . '",
                                    "' . mysql_real_escape_string($pdpAction_duration) . '",
                                    "' . mysql_real_escape_string($pdpAction_costs) . '",
                                    ' . $pdpAction_completed . ',
                                    "' . mysql_real_escape_string($notficationDate) . '",
                                    "' . mysql_real_escape_string($deadlineDate) . '",
                                    "' . mysql_real_escape_string($notes) . '",
                                    "' . $modified_by_user . '",
                                    "' . $modified_time . '",
                                    "' . $modified_date . '"
                                )';

                    $employeePdpActionId = BaseQueries::performInsertQuery($sql);

                    if (!empty($notficationDate)) {

                        // voor elk gekozen e-mail adres de alert aanmaken
                        foreach ($emailToIds as $emailToId) {

                            $hash_id = ModuleUtils::createUniqueHash('alerts');
                            PdpActionLibraryQueriesDeprecated::addPdpActionAlert(   $actionOwnerUserId,
                                                                                    NULL,
                                                                                    $employeePdpActionId,
                                                                                    $hash_id,
                                                                                    $emailToId,
                                                                                    $notificationMessageId,
                                                                                    $notficationDate);
                        }
                    }
                }
            }

            BaseQueries::finishTransaction();
            $hasError = false;
        }

        // resultaat tonen
        // ****************
        // TODO: dit hoort niet meer hier. aparte functie voor maken!
        if (!$hasError) {

            if ($limitActionOwner) {
                $actionOwnerTypeName = $actionOwnerType == SELECT_PDP_ACTION_OWNER_BOSS ? TXT_UCF('MANAGER') : TXT_UCF('EMPLOYEE');
            } else {
                // generate response
                $sql = 'SELECT
                            name
                        FROM
                            users
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND user_id = ' . $actionOwnerUserId;
                $pdpTaskOwnerQuery = BaseQueries::performSelectQuery($sql);

                $get_pdpto = @mysql_fetch_assoc($pdpTaskOwnerQuery);
                $actionOwnerTypeName = $get_pdpto['name'];
            }

            $pdpActionData = array();
            $pdpActionData['action']   = $pdpAction_action;
            $pdpActionData['provider'] = $pdpAction_provider;
            $pdpActionData['duration'] = $pdpAction_duration;
            $pdpActionData['costs']    = $pdpAction_costs;

            $pdpActionData['canEdit']       = false;
            $pdpActionData['owner']         = $actionOwnerTypeName;
            $pdpActionData['start_date']    = $notficationDate;
            $pdpActionData['end_date']      = $deadlineDate;
            $pdpActionData['notes']         = $notes;
            $pdpActionData['is_completed']  = false;

            global $smarty;
            $tpl = $smarty->createTemplate('to_refactor/mod_organisation/pdpActionsBatchDetails.tpl');
            $tpl->assign('actionsCreated', count($employeeIds));
            $tpl->assign('action', $pdpActionData);
            $tpl->assign('tasks', array());
            $tpl->assign('showButtons', false);

            $pdpActionsTitle = TXT_UCW('ADD_COLLECTIVE_PDP_ACTION');
            $pdpActionsHtml = $smarty->fetch($tpl);
            $pdpActionsBlock = BaseBlockHtmlInterfaceObject::create($pdpActionsTitle, 800);
            $pdpActionsBlock->setContentHtml($pdpActionsHtml);
            $pdpActionsHtml = $pdpActionsBlock->fetchHtml();

            OrganisationTabInterfaceProcessor::displayContent($objResponse, 800, $pdpActionsHtml);

        }
    }
    return array($hasError, $message);
}

function batch_pdpAction_getEmployeePdIds(  $actionOwnerType,
                                            $employeeIds)
{
    $employeePdIds = array();

    if ($actionOwnerType == SELECT_PDP_ACTION_OWNER_BOSS) {
        $sql_personDataId = 'IF(e.boss_fid is NULL,e.ID_PD,b.ID_PD) as person_data_id';
    } else {
        $sql_personDataId = 'e.ID_PD as person_data_id';
    }

    $employeeIdList = implode(',',$employeeIds);

    $sql = 'SELECT
                e.ID_E,
                ' . $sql_personDataId . '
            FROM
                employees e
                LEFT JOIN employees b
                    on b.ID_E = e.boss_fid
            WHERE
                e.customer_id = ' . CUSTOMER_ID .'
                and e.ID_E in (' .  $employeeIdList. ')';

    $query = BaseQueries::performSelectQuery($sql);
    while ($employeeData = mysql_fetch_assoc($query)) {
        $employeeId     = $employeeData['ID_E'];
        $personDataId   = $employeeData['person_data_id'];
        $employeePdIds[$employeeId] = $personDataId;
    }

    return $employeePdIds;
}


function batch_pdpAction_getActionOwnerIds( $actionOwnerType,
                                            $employeeIds)
{
    $actionOwnerIds = array();

    if ($actionOwnerType == SELECT_PDP_ACTION_OWNER_BOSS) {
        $sql_actionOwnerId = 'IF(e.boss_fid is NULL,e.ID_E,e.boss_fid) as action_owner_id';
    } else {
        $sql_actionOwnerId = 'e.ID_E as action_owner_id';
    }

    $employeeIdList = implode(',',$employeeIds);

    $sql = 'SELECT
                e.ID_E,
                ' . $sql_actionOwnerId . '
            FROM
                employees e
            WHERE
                e.customer_id = ' . CUSTOMER_ID .'
                and e.ID_E in (' .  $employeeIdList. ')';

    $query = BaseQueries::performSelectQuery($sql);
    while ($employeeData = mysql_fetch_assoc($query)) {
        $employeeId     = $employeeData['ID_E'];
        $actionOwnerId  = $employeeData['action_owner_id'];
        $actionOwnerIds[$employeeId] = $actionOwnerId;
    }

    return $actionOwnerIds;
}

function moduleOrganisation_attachmentBatchForm()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_BATCH_ADD_EMPLOYEE_ATTACHMENT)) {
        unset($_SESSION['ID_E']);
        $attachmentsHtml .= '
        <iframe src ="upload_batch_attachment.php?showSelectEmployees=true" width="99%" height="750" frameBorder="0">
            <p>Your browser does not support iframes.</p>
        </iframe>
        ';

        $uploadTitle = TXT_UCW('UPLOAD_NEW_ATTACHMENT');
        $uploadBlock = BaseBlockHtmlInterfaceObject::create($uploadTitle, 1100);
        $uploadBlock->setContentHtml($attachmentsHtml);
        $attachmentsHtml = $uploadBlock->fetchHtml();
        OrganisationTabInterfaceProcessor::displayContent(  $objResponse, 1100, $attachmentsHtml);
        ApplicationNavigationProcessor::activateModuleMenu( $objResponse,MODULE_ORGANISATION_MENU_ATTACHMENT_BATCH);
    }
    return $objResponse;
}



?>
