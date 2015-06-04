<?php

/**
 * Description of UserLevelSwitchInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('application/interface/builder/user/UserLevelSwitchPageBuilder.class.php');
require_once('application/model/service/user/UserLevelSwitchService.class.php');

class UserLevelSwitchInterfaceProcessor
{
    const EDIT_DIALOG_WIDTH = ApplicationInterfaceBuilder::DIALOG_WIDTH;
    const EDIT_CONTENT_HEIGHT = 80;

    static function displayEdit($objResponse)
    {
        if (PamApplication::isAllowedSwitchUserLevel()) {
            $currentUserLevelMode   = UserLevelSwitchService::retrieveUserLevelMode();
            $loginUserLevel         = PamApplication::retrieveLoginUserLevel();

            $popupHtml = UserLevelSwitchPageBuilder::getEditPopupHtml(  self::EDIT_DIALOG_WIDTH,
                                                                        self::EDIT_CONTENT_HEIGHT,
                                                                        $currentUserLevelMode,
                                                                        $loginUserLevel,
                                                                        ApplicationInterfaceBuilder::HIDE_WARNING);

            InterfaceXajax::showEditDialog( $objResponse,
                                            $popupHtml,
                                            self::EDIT_DIALOG_WIDTH,
                                            self::EDIT_CONTENT_HEIGHT);
        }
    }

    static function finishSwitchUserLevel($objResponse)
    {
        InterfaceXajax::closeFormDialog($objResponse);
        InterfaceXajax::reloadApplication($objResponse);
    }


}

?>
