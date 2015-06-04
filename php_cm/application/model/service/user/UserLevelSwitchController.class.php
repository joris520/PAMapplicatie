<?php

/**
 * Description of UserLevelSwitchController
 *
 * @author ben.dokter
 */

require_once('application/model/service/user/UserLevelSwitchService.class.php');

class UserLevelSwitchController
{
    static function processSwitch(  $currentUserLevelMode)
    {
        if (PamApplication::isAllowedSwitchUserLevel()) {
            $currentUserLevelMode = UserLevelSwitchService::retrieveUserLevelMode();
            PamApplication::restartUserSession();
            if ($currentUserLevelMode == SWITCHED_TO_USER_LEVEL_EMPLOYEE) {
                UserLevelSwitchService::clearUserLevelMode();
            } else {
                UserLevelSwitchService::storeUserLevelMode(SWITCHED_TO_USER_LEVEL_EMPLOYEE);
            }
        }
    }

}

?>
