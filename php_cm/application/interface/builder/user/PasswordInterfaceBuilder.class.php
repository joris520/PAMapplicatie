<?php

/**
 * Description of PasswordInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('application/interface/interfaceobjects/user/PasswordEdit.class.php');
require_once('application/interface/interfaceobjects/user/PasswordEditResult.class.php');

class PasswordInterfaceBuilder
{
    static function getEditHtml($displayWidth,
                                $userId,
                                $userName)
    {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_USERS__EDIT_PASSWORD_POPUP);
        $safeFormHandler->storeSafeValue('userId', $userId);


        $safeFormHandler->addStringInputFormatType('current');
        $safeFormHandler->addStringInputFormatType('new');
        $safeFormHandler->addStringInputFormatType('confirm');

        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = PasswordEdit::create($displayWidth,
                                                $userName);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getEditResultHtml(  $displayWidth,
                                        Array $messages)
    {
        $interfaceObject = PasswordEditResult::create(  $displayWidth);

        $messagesHtml = ApplicationInterfaceBuilder::getMessagesHtml($messages);
        $interfaceObject->setMessagesHtml($messagesHtml);

        return $interfaceObject->fetchHtml();
    }

}

?>
