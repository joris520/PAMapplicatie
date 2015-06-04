<?php

/**
 * Description of UserLevelSwitchInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('application/interface/interfaceobjects/user/UserLevelSwitchEdit.class.php');

class UserLevelSwitchInterfaceBuilder
{
    static function getEditHtml($displayWidth,
                                $currentUserLevelMode,
                                $loginUserLevel)
    {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_USERS__SWITCH_USER_LEVEL_POPUP);
//        $safeFormHandler->storeSafeValue('currentUserLevelMode', $currentUserLevelMode);
//        $safeFormHandler->storeSafeValue('loginUserLevel', $loginUserLevel);

        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = UserLevelSwitchEdit::create($displayWidth);
        if ($currentUserLevelMode == SWITCHED_TO_USER_LEVEL_EMPLOYEE) {
            $switchToText = TXT_UCF_VALUE(  'SWITCH_TO_ORIGINAL_USER_LEVEL_TEXT',
                                            array(UserLevelConverter::display($loginUserLevel)),
                                            array('%ROLE%'));
        } else {
            $switchToText = TXT_UCF('SWITCH_TO_EMPLOYEE_USER_LEVEL_TEXT');
        }

        $interfaceObject->setSwitchToText($switchToText);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
