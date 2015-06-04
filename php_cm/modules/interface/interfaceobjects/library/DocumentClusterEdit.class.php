<?php

/**
 * Description of DocumentClusterEdit
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class DocumentClusterEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/documentClusterEdit.tpl';

    static function createWithValueObject(  DocumentClusterValueObject $valueObject,
                                            $displayWidth)
    {
        return new DocumentClusterEdit( $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }


}


?>
