<?php

/**
 * Description of StandardDateView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class StandardDateView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'settings/standardDateView.tpl';

    static function createWithValueObject(  StandardDateValueObject $valueObject,
                                            $displayWidth)
    {
        return new StandardDateView($valueObject,
                                    $displayWidth,
                                    self::TEMPLATE_FILE);
    }

}

?>
