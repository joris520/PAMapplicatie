<?php

/**
 * Description of PdpActionUserDefinedView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class PdpActionUserDefinedView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionUserDefinedView.tpl';

    static function createWithValueObject(  EmployeePdpActionUserDefinedValueObject $valueObject,
                                            $displayWidth)
    {
        return new PdpActionUserDefinedView($valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }
}

?>
