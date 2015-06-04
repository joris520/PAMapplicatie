<?php

/**
 * Description of PasswordPageBuilder
 *
 * @author ben.dokter
 */

require_once('application/interface/builder/user/PasswordInterfaceBuilder.class.php');

class PasswordPageBuilder
{
    static function getEditPopupHtml(   $displayWidth,
                                        $contentHeight,
                                        $userId,
                                        $userName)
    {
        list($safeFormHandler, $contentHtml) = PasswordInterfaceBuilder::getEditHtml(   $displayWidth,
                                                                                        $userId,
                                                                                        $userName);

        // popup
        $title = TXT_UCF('CHANGE_PASSWORD');
        $formId = 'edit_password_form';
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING);
    }

    static function getEditResultPopupHtml( $displayWidth,
                                            $contentHeight,
                                            Array $messages)
    {
        $contentHtml = PasswordInterfaceBuilder::getEditResultHtml( $displayWidth,
                                                                    $messages);

        // popup
        $title = TXT_UCF('CHANGE_PASSWORD');
        return ApplicationInterfaceBuilder::getInfoPopupHtml(   $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight);
    }

}

?>
