<?php

/**
 * Description of PamValidators
 *
 * @author ben.dokter
 */
class PamValidators {

    static function IsEmailAddressValidFormat($email_address) {
        return ereg("^([0-9a-zA-Z]+[-._+&])*[0-9a-zA-Z]+@([-0-9a-zA-Z]+[.])+[a-zA-Z]{2,6}$", $email_address);
    }

    static function IsMd5HashValidFormat($md5_hash) {
        return ereg("^[0-9a-f]{32}$", $md5_hash);
    }

    static function isPasswordValidFormat($password) {
        return !(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0);
    }

}

?>
