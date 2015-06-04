<?php

/**
 * Description of PasswordSafeFormProcessor
 *
 * @author ben.dokter
 */
require_once('application/model/service/user/PasswordController.class.php');
require_once('application/process/user/PasswordInterfaceProcessor.class.php');

class PasswordSafeFormProcessor
{
    static function processEdit(xajaxResponse $objResponse,
                                SafeFormHandler $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (USER_LEVEL != UserLevelValue::SYS_ADMIN && ApplicationNavigationService::isAllowedModule(MODULE_CHANGE_PASSWORD)) {

            $userId = $safeFormHandler->retrieveSafeValue('userId');

            $currentPassword     = $safeFormHandler->retrieveInputValue('current');
            $newPassword         = $safeFormHandler->retrieveInputValue('new');
            $confirmPassword     = $safeFormHandler->retrieveInputValue('confirm');

            $valueObject = PasswordValueObject::createWithValues(   $currentPassword,
                                                                    $newPassword,
                                                                    $confirmPassword);

            list($hasError, $messages) = PasswordController::processEdit(   $userId,
                                                                            $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                PasswordInterfaceProcessor::finishEdit( $objResponse,
                                                        $messages);
            }
        }
        return array($hasError, $messages);
    }
}

?>
