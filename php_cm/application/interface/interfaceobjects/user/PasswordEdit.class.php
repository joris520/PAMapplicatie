<?php

/**
 * Description of PasswordEdit
 *
 * @author ben.dokter
 */

require_once('application/interface/interfaceobjects/BaseApplicationInterfaceObject.class.php');

class PasswordEdit extends BaseApplicationInterfaceObject
{
    const TEMPLATE_FILE = 'user/passwordEdit.tpl';

    private $userName;

    static function create( $displayWidth,
                            $userName)
    {
        return new PasswordEdit($displayWidth,
                                $userName);
    }

    protected function __construct( $displayWidth,
                                    $userName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->userName = $userName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUserName()
    {
        return $this->userName;
    }

}

?>
