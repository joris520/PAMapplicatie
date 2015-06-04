<?php

/**
 * Description of TalentSelectorResultGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class TalentSelectorResultGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'report/talentSelectorResultGroup.tpl';

    static function create($displayWidth)
    {
        return new TalentSelectorResultGroup(   $displayWidth,
                                                self::TEMPLATE_FILE);
    }

    function addInterfaceObject(TalentSelectorResultCompetenceGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }


}

?>
