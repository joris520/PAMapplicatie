<?php

/**
 * Description of InvitationMessageValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class InvitationMessageValueObject extends BaseValueObject
{
    private $type;
    private $date;
    private $subject;
    private $from;
    private $message;
    private $languageText;

    static function createWithValues($invitationMessageId, $messageType, $subject, $message)
    {
        $invitationMessageData = array();

        $invitationMessageData[InvitationMessageQueries::ID_FIELD] = $invitationMessageId;
        $invitationMessageData['message_type']      = $messageType;
        $invitationMessageData['message_date']      = DateUtils::getCurrentDatabaseDate();
        $invitationMessageData['message_subject']   = $subject;
        $invitationMessageData['message_template']  = $message;

        return new InvitationMessageValueObject($invitationMessageId, $invitationMessageData);

    }

    static function createWithData($invitationMessageData)
    {
        return new InvitationMessageValueObject($invitationMessageData[InvitationMessageQueries::ID_FIELD] , $invitationMessageData);
    }


    protected function __construct($invitationMessageId, $invitationMessageData)
    {
        parent::__construct($invitationMessageId,
                            $invitationMessageData['saved_by_user_id'],
                            $invitationMessageData['saved_by_user'],
                            $invitationMessageData['saved_datetime']);

        $this->type         = $invitationMessageData['message_type'];
        $this->date         = $invitationMessageData['message_date'];
        $this->subject      = $invitationMessageData['message_subject'];
        $this->message      = $invitationMessageData['message_template'];
        $this->from         = $invitationMessageData['message_from'];
        $this->languageText = $invitationMessageData['message_lang_txt'];
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $from
    function setFrom($from)
    {
        $this->from = $from;
    }

    function getFrom()
    {
        return $this->from;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $languageText
    function setLanguageText($languageText)
    {
        $this->languageText = $languageText;
    }

    function getLanguageText()
    {
        return $this->languageText;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $type
    function getType()
    {
        return $this->type;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $date
    function getDate()
    {
        return $this->date;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $subject
    function getSubject()
    {
        return $this->subject;
    }

    function setSubject($subject)
    {
        $this->subject = $subject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $message
    function getMessage()
    {
        return $this->message;
    }


}

?>
