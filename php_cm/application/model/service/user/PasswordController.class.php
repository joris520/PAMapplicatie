<?php

/**
 * Description of PasswordController
 *
 * @author ben.dokter
 */

require_once('application/model/service/user/PasswordService.class.php');

class PasswordController
{

    static function processEdit($userId,
                                PasswordValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();
        if ($userId == USER_ID) {
            list($hasError, $message) = UserLoginService::handleChangePasswordUserRequest(  $valueObject->getCurrentPassword(),
                                                                                            $valueObject->getNewPassword(),
                                                                                            $valueObject->getConfirmPassword());
            $messages[] = $message;
        } else {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_ALL_PASSWORDS');
        }

        // altijd de transactie finishen
        BaseQueries::finishTransaction();

        return array($hasError, $messages);
    }

}

?>
