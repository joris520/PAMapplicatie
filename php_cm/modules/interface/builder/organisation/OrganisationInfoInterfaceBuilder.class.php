<?php

/**
 * Description of OrganisationInfoInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/model/service/organisation/OrganisationInfoService.class.php');
require_once('modules/interface/interfaceobjects/organisation/OrganisationInfoView.class.php');
require_once('modules/interface/interfaceobjects/organisation/OrganisationInfoEdit.class.php');
require_once('modules/interface/builder/organisation/OrganisationInfoInterfaceBuilderComponents.class.php');

class OrganisationInfoInterfaceBuilder
{
    static function getViewHtml($displayWidth)
    {
        // data
        $valueObject = OrganisationInfoService::getValueObject();

        // omzetten naar template data
        $interfaceObject = OrganisationInfoView::createWithValueObject( $valueObject,
                                                                        $displayWidth);

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('COMPANY_INFORMATION'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   OrganisationInfoInterfaceBuilderComponents::getEditLink());

        return $blockInterfaceObject->fetchHtml();
    }

    static function getEditHtml($displayWidth)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ORGANISATION__EDIT_ORGANISATION_INFO);

        $safeFormHandler->addStringInputFormatType ('company_info');
        $safeFormHandler->finalizeDataDefinition();

        // data
        $valueObject = OrganisationInfoService::getValueObject($displayWidth);

        // omzetten naar template data
        $interfaceObject = OrganisationInfoEdit::createWithValueObject($valueObject, $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }
}

?>
