<?php

/**
 * Description of TalentSelectorGroup
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class TalentSelectorGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/talentSelectorGroup.tpl';

    static function create($displayWidth)
    {
        return new TalentSelectorGroup( $displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(TalentSelectorView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
