<?php

/**
 * Description of ScoreboardGroup
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class ScoreboardGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = NULL;

    static function create($displayWidth)
    {
        return new ScoreboardGroup( $displayWidth,
                                    self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(ScoreboardCompetenceGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }
}

?>
