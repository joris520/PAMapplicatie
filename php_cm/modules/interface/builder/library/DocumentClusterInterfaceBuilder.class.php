<?php

/**
 * Description of DocumentClusterInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/DocumentClusterService.class.php');
require_once('modules/interface/interfaceobjects/library/DocumentClusterView.class.php');
require_once('modules/interface/interfaceobjects/library/DocumentClusterEdit.class.php');
require_once('modules/interface/interfaceobjects/library/DocumentClusterDelete.class.php');
require_once('modules/interface/interfaceobjects/library/DocumentClusterGroup.class.php');
require_once('modules/interface/builder/library/DocumentClusterInterfaceBuilderComponents.class.php');

class DocumentClusterInterfaceBuilder
{

    static function getViewHtml($displayWidth, $hiliteId = NULL)
    {
        $valueObjects = DocumentClusterService::getValueObjects();

        // groep
        $groupInterfaceObject = DocumentClusterGroup::create($displayWidth);

        // omzetten naar template data
        foreach($valueObjects as $valueObject) {
            $documentClusterId = $valueObject->getId();
            $interfaceObject = DocumentClusterView::createWithValueObject(  $valueObject,
                                                                            $displayWidth);

            $interfaceObject->setHiliteRow(     $documentClusterId == $hiliteId);
            $interfaceObject->setEditLink(      DocumentClusterInterfaceBuilderComponents::getEditLink($documentClusterId));
            $interfaceObject->setRemoveLink(    DocumentClusterInterfaceBuilderComponents::getRemoveLink($documentClusterId));

            $groupInterfaceObject->addInterfaceObject($interfaceObject);
        }

        // en dat alles in een blok laten zien
        $blockInterfaceObject = BaseBlockInterfaceObject::create(   $groupInterfaceObject,
                                                                    TXT_UCF('MANAGE_ATTACHMENT_CLUSTERS'),
                                                                    $displayWidth);
        $blockInterfaceObject->addActionLink(   DocumentClusterInterfaceBuilderComponents::getAddLink());

        return $blockInterfaceObject->fetchHtml();
    }


    static function getAddHtml($displayWidth)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_DOCUMENTCLUSTERS__ADD_DOCUMENTCLUSTER);

        $safeFormHandler->addStringInputFormatType('cluster_name');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = DocumentClusterValueObject::createWithData(NULL);

        $interfaceObject = DocumentClusterEdit::createWithValueObject($valueObject, $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }


    static function getEditHtml($displayWidth, $documentClusterId)
    {
        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_DOCUMENTCLUSTERS__EDIT_DOCUMENTCLUSTER);

        $safeFormHandler->storeSafeValue('documentClusterId', $documentClusterId);
        $safeFormHandler->addStringInputFormatType('cluster_name');
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $valueObject = DocumentClusterService::getValueObjectById($documentClusterId);

        $interfaceObject = DocumentClusterEdit::createWithValueObject($valueObject, $displayWidth);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveHtml($displayWidth, $documentClusterId)
    {
        // ophalen ValueObject
        $valueObject = DocumentClusterService::getValueObjectById($documentClusterId);

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_DOCUMENTCLUSTERS__DELETE_DOCUMENTCLUSTER);

        $safeFormHandler->storeSafeValue('documentClusterId', $documentClusterId);
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $interfaceObject = DocumentClusterDelete::createWithValueObject($valueObject, $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ATTACHMENT_CLUSTER'));

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
