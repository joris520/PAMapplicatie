<?php

/**
 * Description of StandardDateInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/settings/StandardDateEdit.class.php');
require_once('modules/interface/interfaceobjects/settings/StandardDateView.class.php');
require_once('modules/interface/builder/settings/StandardDateInterfaceBuilderComponents.class.php');

class StandardDateInterfaceBuilder
{

    static function getViewHtml($displayWidth)
    {
        // data
        $valueObject = StandardDateService::getValueObject();

        // omzetten naar template data
        $interfaceObject = StandardDateView::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->editLink = StandardDateInterfaceBuilderComponents::getEditLink();


        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $interfaceObject,
                                                                    TXT_UCF('MANAGE_STANDARD_DATE'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   StandardDateInterfaceBuilderComponents::getEditLink());

        return $blockInterfaceObject->fetchHtml();

    }

    static function getEditHtml($displayWidth)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_ORGANISATION__EDIT_STANDARD_DATE);

        $safeFormHandler->addDateInputFormatType('default_end_date');
        $safeFormHandler->finalizeDataDefinition();

        // data
        $valueObject = StandardDateService::getValueObject();

        // omzetten naar template data
        $interfaceObject = StandardDateEdit::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setDefaultEndDatePicker(  InterfaceBuilderComponents::getCalendarInputPopupHtml(  'default_end_date',
                                                                                                            $valueObject->defaultEndDate));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
