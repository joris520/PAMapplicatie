<?php

/**
 * Description of DocumentClusterGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class DocumentClusterGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/documentClusterGroup.tpl';

    static function create($displayWidth)
    {
        return new DocumentClusterGroup($displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(DocumentClusterView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
