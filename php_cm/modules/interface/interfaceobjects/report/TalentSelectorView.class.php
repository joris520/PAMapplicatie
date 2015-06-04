<?php

/**
 * Description of TalentSelectorView
 *
 * @author hans.prins
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class TalentSelectorView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'report/talentSelectorView.tpl';

    static function createWithValueObject(  TalentSelectorCompetenceValueObject $valueObject,
                                            $displayWidth)
    {
        return new TalentSelectorView(  $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

}

?>
