<?php

/**
 * Description of CompetenceInterfaceObject
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class CompetenceInterfaceObject extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/competenceDetail.tpl';

    var $hideLink;
    var $editLink;
    var $removeLink;
    var $hiliteRow;

    var $hasNumericScale;
    var $hasYNScale;

    static function createWithValueObject(  CompetenceValueObject $valueObject,
                                            $displayWidth)
    {
        return new CompetenceInterfaceObject(   $valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }
}
?>
