<?php


/**
 * Description of QuestionEdit
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class QuestionEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/questionEdit.tpl';

    static function createWithValueObject(  QuestionValueObject $valueObject,
                                            $displayWidth)
    {
        return new QuestionEdit($valueObject,
                                $displayWidth,
                                self::TEMPLATE_FILE);
    }

}

?>
