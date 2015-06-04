<?php

/**
 * Description of TalentSelectorResultView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class TalentSelectorResultView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/talentSelectorResultView.tpl';

    static function createWithValueObject(  TalentSelectorValueObject $valueObject,
                                            $displayWidth)
    {
        return new TalentSelectorResultView($valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

}

?>
