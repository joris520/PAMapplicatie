<?php

/**
 * Description of PasswordValueObject
 *
 * @author ben.dokter
 */

// require_once('application/model/valueobjects/BaseValueObject.class.php');

class PasswordValueObject // extends BaseValueObject
{

    private $currentPassword;
    private $newPassword;
    private $confirmPassword;

    static function createWithValues(   $currentPassword,
                                        $newPassword,
                                        $confirmPassword)
    {
        return new PasswordValueObject( $currentPassword,
                                        $newPassword,
                                        $confirmPassword);
    }


    protected function __construct( $currentPassword,
                                    $newPassword,
                                    $confirmPassword)
    {
        $this->currentPassword  = $currentPassword;
        $this->newPassword      = $newPassword;
        $this->confirmPassword  = $confirmPassword;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCurrentPassword()
    {
        return $this->currentPassword;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getNewPassword()
    {
        return $this->newPassword;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getConfirmPassword()
    {
        return $this->confirmPassword;
    }
}

?>
