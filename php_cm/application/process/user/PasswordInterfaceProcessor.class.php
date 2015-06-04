<?php

/**
 * Description of PasswordInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('application/interface/builder/user/PasswordPageBuilder.class.php');

class PasswordInterfaceProcessor
{
    const PASSWORD_DIALOG_WIDTH = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const PASSWORD_CONTENT_HEIGHT = 150;

    static function displayEdit($objResponse)
    {
        if (USER_LEVEL != UserLevelValue::SYS_ADMIN &&
            ApplicationNavigationService::isAllowedModule(MODULE_CHANGE_PASSWORD)) {

            global $user;
            $userId = USER_ID;
            if ( isset($user) && !empty($userId)) {
                $popupHtml = PasswordPageBuilder::getEditPopupHtml( self::PASSWORD_DIALOG_WIDTH,
                                                                    self::PASSWORD_CONTENT_HEIGHT,
                                                                    USER_ID,
                                                                    USER);

                InterfaceXajax::showEditDialog( $objResponse,
                                                $popupHtml,
                                                self::PASSWORD_DIALOG_WIDTH,
                                                self::PASSWORD_CONTENT_HEIGHT);
            }
        }
    }

    static function finishEdit($objResponse, $messages)
    {
        $popupHtml = PasswordPageBuilder::getEditResultPopupHtml( self::PASSWORD_DIALOG_WIDTH,
                                                                  self::PASSWORD_CONTENT_HEIGHT,
                                                                  $messages);

        InterfaceXajax::showInfoDialog( $objResponse,
                                        $popupHtml,
                                        self::PASSWORD_DIALOG_WIDTH,
                                        self::PASSWORD_CONTENT_HEIGHT);

        InterfaceXajax::changePopupBorderColor($objResponse, COLOUR_MESSAGE_SUCCESS);
    }

}

?>
