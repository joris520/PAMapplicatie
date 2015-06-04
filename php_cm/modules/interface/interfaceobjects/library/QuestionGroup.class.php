<?php

/**
 * Description of QuestionGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class QuestionGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/questionGroup.tpl';

    static function create($displayWidth)
    {
        return new QuestionGroup(   $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(QuestionView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
