<?php

/**
 * Description of OrganisationInfoEdit
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class OrganisationInfoEdit extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'organisation/organisationInfoEdit.tpl';

    static function createWithValueObject(  OrganisationInfoValueObject $valueObject,
                                            $displayWidth)
    {
        return new OrganisationInfoEdit($valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }
}

?>
