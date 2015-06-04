<?php

require_once('modules/model/queries/to_refactor/EmailAddressesQueries.class.php');
require_once('modules/model/queries/to_refactor/EmailMessagesQueries.class.php');

require_once('modules/interface/interfaceobjects/base/BaseBlockHtmlInterfaceObject.class.php');

function moduleEmails_displayExternalEmailAddresses()
{
    //die('***** moduleEmails_displayExternalEmailAddresses');
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMAILS)) {
        externalEmailAddresses_direct($objResponse);
    }

    return $objResponse;
}

function externalEmailAddresses_direct($objResponse)
{
    // TODO: hoofdmenu en submenu's uit elkaar trekken
    ApplicationNavigationService::setCurrentApplicationModule(MODULE_EMAILS);

    $emailQuery = EmailAddressesQueries::getExternalEmailAddresses();

    $rows = array();
    while ($row = @mysql_fetch_assoc($emailQuery)) {
        $rows[] = $row;
    }

    if (PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMAILS__EDIT_EXTERNALEMAILADDRESS);
        $safeFormHandler->storeSafeValue('ID_EXT', '');
        $safeFormHandler->addStringInputFormatType('email');
        $safeFormHandler->addStringInputFormatType('firstname');
        $safeFormHandler->addStringInputFormatType('lastname');
        $safeFormHandler->finalizeDataDefinition();
    }

    global $smarty;
    $tpl = $smarty->createTemplate('to_refactor/mod_email_messages/emailExternalEmailAdresses.tpl');
    $tpl->assign('formIdentifier',  SAFEFORM_EMAILS__EDIT_EXTERNALEMAILADDRESS); // TODO: dit is geen callback, maar formIdentifier
    $tpl->assign('formToken',       $safeFormHandler->getTokenHiddenInputHtml());  // TODO: de standaard naam gebruiken!
    $tpl->assign('emailMenu',       ApplicationNavigationInterfaceBuilder::buildEmailMenu(MODULE_EMAIL_EXTERNAL_EMAILADDRESSES));
    $tpl->assign('isEditAllowed',   PermissionsService::isEditAllowed(PERMISSION_EMAILS));
    $tpl->assign('isAddAllowed',    PermissionsService::isAddAllowed(PERMISSION_EMAILS));
    $tpl->assign('isDeleteAllowed', PermissionsService::isDeleteAllowed(PERMISSION_EMAILS));
    $tpl->assign('rows', $rows);


    $emailTitle    = TXT_UCF('MANAGE_EMAIL');
    $emailHtml     = $smarty->fetch($tpl);

    $emailBlock = BaseBlockHtmlInterfaceObject::create($emailTitle, 700);
    $emailBlock->setContentHtml($emailHtml);

    $emailSettings = $smarty->createTemplate('to_refactor/mod_email_messages/emailSettings.tpl');
    $emailSettings->assign('interfaceObject', $emailBlock);

    $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($emailSettings));

    $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_EMAILS));
}

function moduleEmails_editExternalEmailAddresses($id_ext)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {
        $sql = 'SELECT
                    pd.ID_EC,
                    pd.email,
                    pd.firstname,
                    pd.lastname
                FROM
                    ext
                    LEFT JOIN person_data pd
                        ON ext.ID_PD = pd.ID_PD
                WHERE
                    ext.ID_EXT = ' . $id_ext;
        $notificationEmailQuery = BaseQueries::performQuery($sql);
        $ne = @mysql_fetch_assoc($notificationEmailQuery);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMAILS__EDIT_EXTERNALEMAILADDRESS);
        $safeFormHandler->storeSafeValue('ID_EXT', $id_ext);

        $safeFormHandler->addStringInputFormatType('email');
        $safeFormHandler->addStringInputFormatType('firstname');
        $safeFormHandler->addStringInputFormatType('lastname');
        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <form id="neForm" name="neForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">
        ' . $safeFormHandler->getTokenHiddenInputHtml() . '
            <table width="600" border="0" cellspacing="0" cellpadding="10" class="border1px">
                <tr>
                    <td>
                        <table border="0" cellspacing="0" cellpadding="10" class="border1px">
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('EXTERNAL_EMAIL_ADDRESS') . ' ' . REQUIRED_FIELD_INDICATOR . '</td>
                                <td class="bottom_line">
                                    <input name="email" type="text" id="email" size="30" value="' . $ne['email'] . '" maxlength="78">&nbsp;
                                </td>
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('FIRST_NAME') . ' ' . REQUIRED_FIELD_INDICATOR . '</td>
                                <td class="bottom_line"><input name="firstname" type="text" id="firstname" size="30" maxlength="250" value="'. $ne['firstname'] .'" />
                            </tr>
                            <tr>
                                <td class="bottom_line">' . TXT_UCF('LAST_NAME') . ' ' . REQUIRED_FIELD_INDICATOR . '</td>
                                <td class="bottom_line">
                                    <input name="lastname" type="text" id="lastname" size="30" maxlength="250" value="'. $ne['lastname'] .'" />
                                </td>
                            </tr>
                        </table>
                        <br />
                        <input type="submit" id="submitButton" class="btn btn_width_80" value="' . TXT_BTN('SAVE') . '">
                        <input type="button" class="btn btn_width_80" value="' . TXT_BTN('CANCEL') . '" onclick="xajax_moduleEmails_displayExternalEmailAddresses();return false;">
                    </td>
                </tr>
            </table>
        </form>';
        $objResponse->assign('neDiv', 'innerHTML', $html);
        $objResponse->assign('neEdit', 'innerHTML', '<strong>' . TXT_UCW('EDIT_EMAIL') . '</strong>');
    }

    return $objResponse;
}

function moduleEmails_deleteExternalEmailAddresses($id_ext)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMAILS)) {

        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_EMAIL'));
        $objResponse->call("xajax_moduleEmails_executeDeleteExternalEmailAddresses", $id_ext);
    }

    return $objResponse;
}

function moduleEmails_executeDeleteExternalEmailAddresses($id_ext)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_EMAILS)) {
        try {
            BaseQueries::startTransaction();

            // delete uit ext en person_data
            $sql = 'DELETE
                    FROM
                        ee,
                        pd
                    USING
                        ext ee
                        INNER JOIN person_data pd
                            ON ee.ID_PD = pd.ID_PD
                    WHERE
                        ee.customer_id = ' . CUSTOMER_ID . '
                        AND ee.ID_EXT = ' . $id_ext;

            BaseQueries::performDeleteQuery($sql);

            BaseQueries::finishTransaction();

        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException);
        }
        externalEmailAddresses_direct($objResponse);
    }
    return $objResponse;
}

function emails_processSafeForm_editExternalEmailAddress($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {

        $id_ext = $safeFormHandler->retrieveSafeValue('ID_EXT');

        $email = $safeFormHandler->retrieveInputValue('email');
        $firstname = $safeFormHandler->retrieveInputValue('firstname');
        $lastname = $safeFormHandler->retrieveInputValue('lastname');
        $id_ec = ID_EC_EXTERNAL;

        $modified_by_user = USER;
        $modified_datetime = MODIFIED_DATETIME;

        // validatie
        $hasError = false;

        // bij een edit niet je eigen e-mail adres meetellen
        $exclude_self_condition = empty($id_ext) ? '' : 'AND ee.ID_EXT <> ' . $id_ext;
        $sql = 'SELECT
                    count(*) as existing_count
                FROM
                    ext ee
                    LEFT JOIN person_data pd
                        ON ee.ID_PD = pd.ID_PD
                WHERE
                    ee.customer_id = ' . CUSTOMER_ID . '
                    ' . $exclude_self_condition . '
                    AND pd.email = "' . mysql_real_escape_string($email) . '"';
        $emailCheckQuery = BaseQueries::performQuery($sql);
        $emailCheck = @mysql_fetch_assoc($emailCheckQuery);
        $existingCount = $emailCheck['existing_count'];

        if (empty($email)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_AN_EMAIL');
        } elseif (!ModuleUtils::IsEmailAddressValidFormat($email)) {
            $hasError = true;
            $message = TXT_UCF('EMAIL_ADDRESS_IS_INVALID');
        } elseif ($existingCount > 0) {
            $hasError = true;
            $message = TXT_UCF('EMAIL_ALREADY_ADDED_PLEASE_ENTER_A_NEW_ONE');
        } elseif(empty($firstname)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_FIRST_NAME');
        } elseif(empty($lastname)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_LAST_NAME');
        }
        // einde validatie


        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            if (empty($id_ext)) { // nieuw
                $sql = 'INSERT INTO
                            person_data
                            (   customer_id,
                                ID_EC,
                                email,
                                firstname,
                                lastname,
                                modified_by_user,
                                modified_datetime
                            ) VALUES (
                                ' . CUSTOMER_ID . ',
                                ' . ID_EC_EXTERNAL . ',
                               "' . mysql_real_escape_string($email) . '",
                               "' . mysql_real_escape_string($firstname) . '",
                               "' . mysql_real_escape_string($lastname) . '",
                               "' . $modified_by_user . '",
                               "' . $modified_datetime . '"
                            )';

                $id_pd = BaseQueries::performInsertQuery($sql);
                $sql = 'INSERT INTO
                            ext
                            (   ID_PD,
                                customer_id,
                                modified_by_user,
                                modified_datetime
                            ) VALUES (
                                ' . $id_pd . ',
                                ' . CUSTOMER_ID . ',
                               "' . $modified_by_user . '",
                               "' . $modified_datetime . '"
                            )';
                BaseQueries::performInsertQuery($sql);

            } else { // bestaand
                $sql = 'UPDATE
                            person_data pd,
                            ext
                        SET
                            pd.firstname = "' . mysql_real_escape_string($firstname) . '",
                            pd.lastname = "' . mysql_real_escape_string($lastname) . '",
                            pd.ID_EC = ' . ID_EC_EXTERNAL . ',
                            pd.email = "' . mysql_real_escape_string($email) . '",
                            pd.modified_by_user = "' . $modified_by_user . '",
                            pd.modified_datetime  = "' . $modified_datetime . '"
                        WHERE
                            pd.ID_PD = ext.ID_PD
                            AND ext.ID_EXT = ' . $id_ext;
                BaseQueries::performUpdateQuery($sql);
            }

            BaseQueries::finishTransaction();
            $hasError = false;
            // verwerken klaar
            $message = TXT_UCF('SUCCESSFULLY_SAVED');

            externalEmailAddresses_direct($objResponse);
        }
    }
    return array($hasError, $message);
}

function moduleEmails_displayNotificationMessage()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {

        $messageRows = EmailMessagesQueries::getEmailNotificationMessages();

        // TODO: 0 en 1 wegwerken via defines, de logica van eerste en tweede in dataobject oplossen!
        $ACTION = 0;
        $TASK = 1;
        $messages = array();
        while ($messageRow = @mysql_fetch_assoc($messageRows)) {
            $messages[] = $messageRow;
        }

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMAILS__EDIT_NOTIFICATIONMESSAGES);
        $safeFormHandler->storeSafeValue('action_id', $messages[$ACTION]['ID_NM']);
        $safeFormHandler->storeSafeValue('task_id',   $messages[$TASK]['ID_NM']);
        $safeFormHandler->addStringInputFormatType('action_message');
        $safeFormHandler->addStringInputFormatType('task_message');
        $safeFormHandler->finalizeDataDefinition();

        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_email_messages/emailNotificationMessage.tpl');
        $tpl->assign('formIdentifier', SAFEFORM_EMAILS__EDIT_NOTIFICATIONMESSAGES);
        $tpl->assign('formToken', $safeFormHandler->getTokenHiddenInputHtml());
        $tpl->assign('emailMenu', ApplicationNavigationInterfaceBuilder::buildEmailMenu(MODULE_EMAIL_PDP_NOTIFICATION_MESSAGE));
        $tpl->assign('actionNotificationTitle', TXT_UCW('PDP_ACTION_NOTIFICATION_MESSAGE'));
        $tpl->assign('taskNotificationTitle',   TXT_UCW('PDP_TASK_NOTIFICATION_MESSAGE'));
        $tpl->assign('actionMessage', $messages[$ACTION]['message']);
        $tpl->assign('taskMessage', $messages[$TASK]['message']);
        $tpl->assign('subsitutionText', TXT_UCF('THESE_TOKENS_WILL_BE_SUBSTITUTED_WITH_RELEVANT_DATA_WHEN_SENT'));

        $emailTitle    = TXT_UCF('MANAGE_EMAIL');
        $emailHtml     = $smarty->fetch($tpl);

        $emailBlock = BaseBlockHtmlInterfaceObject::create($emailTitle, 700);
        $emailBlock->setContentHtml($emailHtml);

        $emailSettings = $smarty->createTemplate('to_refactor/mod_email_messages/emailSettings.tpl');
        $emailSettings->assign('interfaceObject', $emailBlock);

        $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($emailSettings));
    }
    return $objResponse;

}

function emails_processSafeForm_editNotificationMessages($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {

        $action_id = $safeFormHandler->retrieveSafeValue('action_id');
        $task_id = $safeFormHandler->retrieveSafeValue('task_id');

        $action_message = $safeFormHandler->retrieveInputValue('action_message');
        $task_message = $safeFormHandler->retrieveInputValue('task_message');

        $hasError = false;
        if (empty($action_message) || empty($task_message)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_NOTIFICATION_MESSAGE');
        }

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            EmailMessagesQueries::updateEmailNotificationMessage($action_id, $action_message);
            EmailMessagesQueries::updateEmailNotificationMessage($task_id, $task_message);

            BaseQueries::finishTransaction();
            $hasError = false;

            $message = TXT_UCF('NOTIFICATION_MESSAGE_SAVED');
        }
    }
    return array($hasError, $message);
}

function moduleEmails_showPDPActionsNotificationAlerts() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_ALERTS_OVERVIEW)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_EMAIL_PDP_NOTIFICATION_ALERTS);

        $pdpactionalerts = PdpActionsServiceDeprecated::getPDPactionNotificationMessageAlerts();
        $pdpactiontaskalerts = PdpActionsServiceDeprecated::getPDPactionTaskNotificationMessageAlerts();

        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_pdpactions/pdpaction_notication_message_alerts.tpl');

        $tpl->assign('pdpactionalerts', $pdpactionalerts);
        $tpl->assign('pdpactiontasksalerts', $pdpactiontaskalerts);

        $html = $smarty->fetch($tpl);

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_EMAIL_PDP_NOTIFICATION_ALERTS));
        $objResponse->assign('module_main_panel', 'innerHTML', $html);
    }

    return $objResponse;
}

function getActionOwnersSelect()
{
    $html = '<select name="actionowners[]" size="15" style="width:200px" multiple>';

    $action_owners = PdpActionsServiceDeprecated::getPDPActionOwners();

    foreach ($action_owners as $amsg) {
        $html .= '<option value="' . $amsg['user_id'] . '">' . $amsg['name'] . '</option>';
    }
    $html .= '</select>';

    return $html;
}

function getActionTaskOwnersSelect()
{
    $html = '<select name="taskowners[]" size="15" style="width:200px" multiple>';

    $action_task_owners = PdpActionsServiceDeprecated::getPDPActionTaskOwners();

    foreach ($action_task_owners as $tmsg) {
        $html .= '<option value="' . $tmsg['ID_PDPTO'] . '">' . $tmsg['name'] . '</option>';
    }
    $html .= '</select>';

    return $html;
}

function getActionOwnersHeader()
{
    return '<strong>' . TXT_UCW('ACTION_OWNER') . '</strong><br> <span style="font-size:smaller;">(' . TXT_UCF('CTRL_CLICK_TO_SELECT_MULTIPLE_ACTION_OWNER') . ')</span>';
}

function getTaskOwnersHeader()
{
    return '<strong>' . TXT_UCW('TASK_OWNER') . '</strong><br> <span style="font-size:smaller;">(' . TXT_UCF('CTRL_CLICK_TO_SELECT_MULTIPLE_TASK_OWNER') . ')</span>';
}

function moduleEmails_printAlerts()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_ALERTS_OVERVIEW)) {

        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_pdpactions/pdpaction_notification_message_alerts_print_select.tpl');

        // de actie van printActionAlerts();
        $tpl->assign('header1', getActionOwnersHeader());
        $tpl->assign('select1', getActionOwnersSelect());
        $html = $smarty->fetch($tpl);

        $objResponse->assign('naID', 'innerHTML', $html);
    }
    return $objResponse;

}
function moduleEmails_printActionAlerts()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_ALERTS_OVERVIEW)) {
        InterfaceXajax::setHtml($objResponse, 'header1', getActionOwnersHeader());
        InterfaceXajax::setHtml($objResponse, 'select1', getActionOwnersSelect());
        InterfaceXajax::setHtml($objResponse, 'header2', '');
        InterfaceXajax::setHtml($objResponse, 'select2', '');
        $objResponse->assign('o1', 'checked', true);
        $objResponse->assign('o2', 'checked', false);
        $objResponse->assign('o3', 'checked', false);
    }
    return $objResponse;
}

function moduleEmails_printTaskAlerts()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_ALERTS_OVERVIEW)) {
        InterfaceXajax::setHtml($objResponse, 'header1', getTaskOwnersHeader());
        InterfaceXajax::setHtml($objResponse, 'select1', getActionTaskOwnersSelect());
        InterfaceXajax::setHtml($objResponse, 'header2', '');
        InterfaceXajax::setHtml($objResponse, 'select2', '');
        $objResponse->assign('o1', 'checked', false);
        $objResponse->assign('o2', 'checked', true);
        $objResponse->assign('o3', 'checked', false);
    }
    return $objResponse;
}

function moduleEmails_printActionAndTaskAlerts(){
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_ALERTS_OVERVIEW)) {

        InterfaceXajax::setHtml($objResponse, 'header1', getActionOwnersHeader());
        InterfaceXajax::setHtml($objResponse, 'select1', getActionOwnersSelect());
        InterfaceXajax::setHtml($objResponse, 'header2', getTaskOwnersHeader());
        InterfaceXajax::setHtml($objResponse, 'select2', getActionTaskOwnersSelect(true));
        $objResponse->assign('o1', 'checked', false);
        $objResponse->assign('o2', 'checked', false);
        $objResponse->assign('o3', 'checked', true);
    }
    return $objResponse;
}

function moduleEmails_processPrintAlerts($mform) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_ALERTS_OVERVIEW)) {
//die('moduleEmails_processPrintAlerts'.print_r($mform, true));
        unset($_SESSION['print_msgAlerts']);
        $printOption = $mform['printoption'];
        $actionOwners = $mform['actionowners'];
        $taskOwners = $mform['taskowners'];

        $hasError = false;
        switch($printOption) {
            case PRINT_OPTION_ACTION:
                if (empty($actionOwners)) {
                    $hasError = true;
                    $message = TXT_UCF('PLEASE_SELECT_ACTION_OWNER');
                }
                break;
            case PRINT_OPTION_TASK:
                if (empty($taskOwners)) {
                    $hasError = true;
                    $message = TXT_UCF('PLEASE_SELECT_TASK_OWNER');
                }
                break;
            case PRINT_OPTION_ACTION_AND_TASK:
                if (empty($actionOwners) || empty($taskOwners)) {
                    $hasError = true;
                    $message = TXT_UCF('PLEASE_SELECT_ACTION_OWNER_AND_TASK_OWNER');
                }
                break;
            default:
                $hasError = true;
                $message = '?';
        }

        if (!$hasError) {
             $_SESSION['print_msgAlerts']['actionowners']   = !empty($actionOwners) ? implode($actionOwners) : '';
             $_SESSION['print_msgAlerts']['taskowners']     = !empty($taskOwners) ? implode($taskOwners) : '';
             $_SESSION['print_msgAlerts']['printoption']    = $printOption;
             InterfaceXajax::openInWindow($objResponse, 'print/print_msgAlerts.php', 950, 800);
        } else {
            $objResponse->alert($message);
        }
    }
    return $objResponse;
}

function moduleEmails_notification360Message() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {

        $messageRows = EmailMessagesQueries::getEmail360Messages();

        // TODO: 0 en 1 wegwerken via defines
        $INTERNAL = 0;
        $EXTERNAL = 1;
        $messages = array();
        while ($messageRow = @mysql_fetch_assoc($messageRows)) {
            $messages[] = $messageRow;
        }

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_EMAILS__EDIT_NOTIFICATION360MESSAGE);
        $safeFormHandler->storeSafeValue('internal_id', $messages[$INTERNAL]['ID_NM']);
        $safeFormHandler->storeSafeValue('external_id', $messages[$EXTERNAL]['ID_NM']);
        $safeFormHandler->addStringInputFormatType('internal_message');
        $safeFormHandler->addStringInputFormatType('external_message');
        $safeFormHandler->finalizeDataDefinition();

        global $smarty;
        $tpl = $smarty->createTemplate('to_refactor/mod_email_messages/emailNotification360Message.tpl');
        $tpl->assign('formIdentifier', SAFEFORM_EMAILS__EDIT_NOTIFICATION360MESSAGE);
        $tpl->assign('formToken', $safeFormHandler->getTokenHiddenInputHtml());
        $tpl->assign('emailMenu', ApplicationNavigationInterfaceBuilder::buildEmailMenu(MODULE_EMAIL_360_NOTIFICATION_MESSAGE));
        $tpl->assign('internalNotificationTitle', TXT_UCW('INTERNAL'));
        $tpl->assign('externalNotificationTitle', TXT_UCW('EXTERNAL'));
        $tpl->assign('internalMessage', $messages[$INTERNAL]['message']);
        $tpl->assign('externalMessage', $messages[$EXTERNAL]['message']);
        $tpl->assign('subsitutionText', TXT_UCF('THESE_TOKENS_WILL_BE_SUBSTITUTED_WITH_RELEVANT_DATA_WHEN_SENT'));

        $emailTitle    = TXT_UCF('MANAGE_EMAIL');
        $emailHtml     = $smarty->fetch($tpl);

        $emailBlock = BaseBlockHtmlInterfaceObject::create($emailTitle, 700);
        $emailBlock->setContentHtml($emailHtml);

        $emailSettings = $smarty->createTemplate('to_refactor/mod_email_messages/emailSettings.tpl');
        $emailSettings->assign('interfaceObject', $emailBlock);

        $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($emailSettings));
    }

    return $objResponse;
}

function emails_processSafeForm_editNotification360Message($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_EMAILS)) {

        $internal_id = $safeFormHandler->retrieveSafeValue('internal_id');
        $external_id = $safeFormHandler->retrieveSafeValue('external_id');

        $internal_message = $safeFormHandler->retrieveInputValue('internal_message');
        $external_message = $safeFormHandler->retrieveInputValue('external_message');

        $hasError = false;
        if (empty($internal_message) || empty($external_message)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_360_NOTIFICATION_MESSAGE');
        }

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            EmailMessagesQueries::updateEmail360Message ($internal_id, $internal_message);
            EmailMessagesQueries::updateEmail360Message ($external_id, $external_message);

            BaseQueries::finishTransaction();
            $hasError = false;

            $message = TXT_UCF('360_NOTIFICATION_MESSAGE_SAVED');
        }
    }
    return array($hasError, $message);
}




?>