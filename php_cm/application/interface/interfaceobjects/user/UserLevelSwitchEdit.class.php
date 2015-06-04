<?php

/**
 * Description of UserLevelSwitchEdit
 *
 * @author ben.dokter
 */

require_once('application/interface/interfaceobjects/BaseApplicationInterfaceObject.class.php');

class UserLevelSwitchEdit extends BaseApplicationInterfaceObject
{
    const TEMPLATE_FILE = 'user/userLevelSwitchEdit.tpl';

    private $switchToText;

    static function create( $displayWidth)
    {
        return new UserLevelSwitchEdit( $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setSwitchToText($switchToText)
    {
        $this->switchToText = $switchToText;
    }

    function getSwitchToText()
    {
        return  $this->switchToText;
    }
}

?>
