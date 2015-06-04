<?php

/**
 * Description of OrganisationInfoInterfaceObject
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class OrganisationInfoView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/organisationInfoView.tpl';

    static function createWithValueObject(  OrganisationInfoValueObject $valueObject,
                                            $displayWidth)
    {
        return new OrganisationInfoView($valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

}

?>
