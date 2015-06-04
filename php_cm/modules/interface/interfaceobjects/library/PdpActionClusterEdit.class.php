<?php

/**
 * Description of PdpActionClusterEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionClusterEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionClusterEdit.tpl';

    static function createWithValueObject(  PdpActionClusterValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionClusterEdit($valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

}

?>
