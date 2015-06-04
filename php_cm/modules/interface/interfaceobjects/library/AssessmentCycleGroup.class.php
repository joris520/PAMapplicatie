<?php

/**
 * Description of AssessmentCycleGroup
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class AssessmentCycleGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleGroup.tpl';

    static function create($displayWidth)
    {
        return new AssessmentCycleGroup($displayWidth,
                                        self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(AssessmentCycleView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
