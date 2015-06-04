<?php

/**
 * Description of CompetenceInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/CompetenceService.class.php');
require_once('modules/interface/interfaceobjects/library/CompetenceInterfaceObject.class.php');
require_once('modules/interface/builder/library/CompetenceInterfaceBuilderComponents.class.php');

class CompetenceInterfaceBuilder
{
    const DISPLAY_WIDTH       = 0;
    const DISPLAY_MODE_NORMAL = 1;
    const DISPLAY_MODE_POPUP  = 2;

    static function getCompetenceDetailHtml($competenceId, $showLastModifiedLog = false)
    {
        $competenceValueObject = CompetenceService::getValueObjectById($competenceId);

        $competenceInterfaceObject = CompetenceInterfaceObject::createWithValueObject(  $competenceValueObject,
                                                                                        self::DISPLAY_WIDTH);

        $competenceInterfaceObject->hasNumericScale = $competenceValueObject->scale == ScaleValue::SCALE_1_5;
        $competenceInterfaceObject->hasYNScale      = $competenceValueObject->scale == ScaleValue::SCALE_Y_N;

        return $competenceInterfaceObject->fetchHtml();
    }

}

?>
