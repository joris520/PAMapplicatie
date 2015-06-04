<?php

/**
 * Description of AssessmentEmailMessageTemplateValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

// TODO: refactor tabel
class AssessmentEmailMessageTemplateValueObject extends BaseValueObject
{
    private $internalMessage;
    private $externalMessage;

    static function createWithValues(   $messageId,
                                        $internalMessage,
                                        $externalMessage)
    {
        $messageData = array();
        $messageData['internal'] = $internalMessage;
        $messageData['external'] = $externalMessage;

        return new AssessmentEmailMessageTemplateValueObject($messageId, $messageData);
    }

    function __construct($messageId, $messageData)
    {
        parent::__construct($messageId,
                            $messageData['saved_by_user_id'],  // bestaan nog niet...
                            $messageData['saved_by_user'],
                            $messageData['saved_datetime']);
        $this->internalMessage = $messageData['internal'];
        $this->externalMessage = $messageData['external'];

    }


    function getInternalMesssage()
    {
        return $this->internalMessage;
    }

    function getExternalMesssage()
    {
        return $this->externalMessage;
    }
}

?>
