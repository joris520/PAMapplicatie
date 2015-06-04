<?php

/**
 * Description of PdpActionGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class PdpActionGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionGroup.tpl';

    static function create( $displayWidth)
    {
        return new PdpActionGroup($displayWidth,
                                  self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(PdpActionClusterGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    function addBlockInterfaceObject(BaseBlockClusterInterfaceObject $blockClusterInterfaceObject)
    {
        parent::addInterfaceObject($blockClusterInterfaceObject);
    }
}

?>
