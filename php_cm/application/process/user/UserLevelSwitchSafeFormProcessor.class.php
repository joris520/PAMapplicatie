<?php

/**
 * Description of UserLevelSwitchSafeFormProcessor
 *
 * @author ben.dokter
 */

require_once('application/model/service/user/UserLevelSwitchController.class.php');
require_once('application/process/user/UserLevelSwitchInterfaceProcessor.class.php');

class UserLevelSwitchSafeFormProcessor
{
    static function processEdit(xajaxResponse $objResponse,
                                SafeFormHandler $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PamApplication::isAllowedSwitchUserLevel()) {

            list($hasError, $messages) = UserLevelSwitchController::processSwitch(  $currentUserLevelMode);

            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                UserLevelSwitchInterfaceProcessor::finishSwitchUserLevel( $objResponse);
            }
        }
        return array($hasError, $messages);
    }

}

?>
