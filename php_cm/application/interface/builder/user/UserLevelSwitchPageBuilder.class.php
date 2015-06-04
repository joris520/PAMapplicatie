<?php

/**
 * Description of UserLevelSwitchPageBuilder
 *
 * @author ben.dokter
 */

require_once('application/interface/builder/user/UserLevelSwitchInterfaceBuilder.class.php');

class UserLevelSwitchPageBuilder
{
    static function getEditPopupHtml(   $displayWidth,
                                        $contentHeight,
                                        $currentUserLevelMode,
                                        $loginUserLevel)
    {
        list($safeFormHandler, $contentHtml) = UserLevelSwitchInterfaceBuilder::getEditHtml($displayWidth,
                                                                                            $currentUserLevelMode,
                                                                                            $loginUserLevel);

        // popup
        $title = TXT_UCF('SWITCH_USER_LEVEL');
        $formId = 'edit_switch_user_level_form';
        return ApplicationInterfaceBuilder::getEditPopupHtml(   $formId,
                                                                $safeFormHandler,
                                                                $title,
                                                                $contentHtml,
                                                                $displayWidth,
                                                                $contentHeight,
                                                                ApplicationInterfaceBuilder::HIDE_WARNING,
                                                                TXT_BTN('SWITCH_USER_LEVEL'));
    }
}

?>
