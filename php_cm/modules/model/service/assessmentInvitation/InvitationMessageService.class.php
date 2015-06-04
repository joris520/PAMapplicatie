<?php

/**
 * Description of InvitationMessageService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/assessmentInvitation/InvitationMessageQueries.class.php');
require_once('modules/model/value//batch/InvitationMessageTypeValue.class.php');

require_once('application/model/service/CustomerService.class.php');

class InvitationMessageService
{

    static function insertInvitationMessage(InvitationMessageValueObject $valueObject)
    {
        // regelen opslaan message template...
        $messageFrom = self::createMessageFrom(CUSTOMER_ID);
        $languageText = self::createLanguageText();  // om de emails vertaalt te kunnen versturen van te voren de nodige woorden opslaan.
        $invitationMessageId = InvitationMessageQueries::insertInvitationMessage(   $valueObject->getType(),
                                                                                    $valueObject->getSubject(),
                                                                                    $messageFrom,
                                                                                    $valueObject->getMessage(),
                                                                                    $languageText);
        return $invitationMessageId;

    }

    static function createLanguageText()
    {
        $messages = array();
        $messages[] = TXT_UCF('EVALUATION_FORM');
        $messages[] = TXT_UCF('EMPLOYEE');
        $messages[] = TXT_UCF('DEPARTMENT');
        $messages[] = TXT_UCF('JOB_PROFILE');
        return implode("|", $messages);
    }

    static function createMessageFrom($customerId)
    {
        $valueObject = CustomerService::getInfoValueObject($customerId);
        return $valueObject->getCompanyName();
    }

    static function validate(InvitationMessageValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $subject = $valueObject->getSubject();
        if (empty($subject)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_SUBJECT');
        }

        $message = $valueObject->getMessage();
        if (empty($message)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_MESSAGE');
        }

// fout van de programmeur...
//        if (InvitationMessageTypeValue::isValidValue($valueObject->getType())) {
//            $hasError = true;
//            $messages[] = TXT_UCF('NO_MESSAGE_TYPE');
//        }
        return array($hasError, $messages);
    }

    static function getLastInvitationMessage($messageTypeFilter)
    {
        $query = InvitationMessageQueries::getLastInvitationMessage($messageTypeFilter);

        $invitationMessageData = mysql_fetch_assoc($query);
        return InvitationMessageValueObject::createWithData($invitationMessageData);
    }

    static function getReminderMessage()
    {
        $messageTypeFilter = InvitationMessageTypeValue::INVITATION . ',' . InvitationMessageTypeValue::REMINDER;
        $valueObject = self::getLastInvitationMessage($messageTypeFilter);

        $messageSubject = $valueObject->getSubject();
        if ($valueObject->getType() == InvitationMessageTypeValue::INVITATION) {
            $valueObject->setSubject(TXT_UCF('REMINDER') . ': ' . $messageSubject);
        }
        if (empty($messageSubject)) {
            $valueObject->setSubject(TXT_UCF('REMINDER_SELF_EVALUATION_MESSAGE_SUBJECT'));
        }

        return $valueObject;
    }

}

?>
