<?php

/**
 * Description of PasswordEditResult
 *
 * @author ben.dokter
 */

require_once('application/interface/interfaceobjects/BaseApplicationInterfaceObject.class.php');

class PasswordEditResult extends BaseApplicationInterfaceObject
{
    const TEMPLATE_FILE = 'user/passwordEditResult.tpl';

    private $messagesHtml;

    static function create( $displayWidth)
    {
        return new PasswordEditResult(  $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setMessagesHtml($messagesHtml)
    {
        $this->messagesHtml = $messagesHtml;
    }

    function getMessagesHtml()
    {
        return $this->messagesHtml;
    }
}

?>
