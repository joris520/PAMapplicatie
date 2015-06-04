<?php

/**
 * Description of PdpActionInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/library/PdpActionInterfaceBuilderComponents.class.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');
require_once('modules/interface/state/PdpActionClusterSelectorState.class.php');
require_once('modules/interface/state/PdpActionApplyToState.class.php');


require_once('modules/interface/interfaceobjects/base/BaseBlockClusterInterfaceObject.class.php');

require_once('modules/interface/interfaceobjects/library/PdpActionEdit.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionDelete.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionGroup.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionClusterGroup.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionClusterView.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionClusterEdit.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionClusterDelete.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionUserDefinedClusterGroup.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionUserDefinedClusterView.class.php');
require_once('modules/interface/interfaceobjects/library/PdpActionUserDefinedView.class.php');

class PdpActionInterfaceBuilder
{

    static function getActionHtml($displayWidth)
    {
        $actionBlockInterfaceObject = BaseTitleInterfaceObject::create( TXT_UCW('PDP_ACTION_LIBRARY'),
                                                                        $displayWidth);
        $actionBlockInterfaceObject->addActionLink(   PdpActionInterfaceBuilderComponents::getPrintLink());
        $actionBlockInterfaceObject->addActionLink(   PdpActionInterfaceBuilderComponents::getAddLink());

        return $actionBlockInterfaceObject->fetchHtml();
    }

    static function getViewHtml($displayWidth,
                                PdpActionClusterGroupCollection $clusterGroupCollection,
                                $hiliteId = NULL)
    {
        $clusterKeys = $clusterGroupCollection->getKeys();

        $groupInterfaceObject = PdpActionGroup::create($displayWidth);

        foreach($clusterKeys as $clusterKey) {
            $clusterCollection = $clusterGroupCollection->getCollection($clusterKey);

            $clusterValueObject = $clusterCollection->getClusterValueObject();
            $clusterId          = $clusterValueObject->getId();
            $valueObjects       = $clusterCollection->getValueObjects();

            $clusterInterfaceObject = PdpActionClusterGroup::create($displayWidth,
                                                                    $clusterValueObject->getClusterName());

            $clusterInterfaceObject->addActionLink(   PdpActionInterfaceBuilderComponents::getEditClusterLink(  $clusterId));
            $clusterInterfaceObject->addActionLink(   PdpActionInterfaceBuilderComponents::getRemoveClusterLink($clusterId,
                                                                                                                count($valueObjects)));


            // omzetten naar template data
            foreach($valueObjects as $valueObject) {
                $pdpActionId = $valueObject->getId();
                $interfaceObject = PdpActionClusterView::createWithValueObject( $valueObject,
                                                                                $displayWidth);

                $interfaceObject->setHiliteRow(         $pdpActionId == $hiliteId);
                $interfaceObject->addActionLink(        PdpActionInterfaceBuilderComponents::getEditLink(     $pdpActionId));
                $interfaceObject->addActionLink(        PdpActionInterfaceBuilderComponents::getRemoveLink(   $pdpActionId));
                $interfaceObject->setEmployeeDetailLink(PdpActionInterfaceBuilderComponents::getEmployeeInfoLink(   $pdpActionId,
                                                                                                                    $valueObject->getUsageCount()));


                $clusterInterfaceObject->addInterfaceObject($interfaceObject);
            }
            $blockClusterInterfaceObject = BaseBlockClusterInterfaceObject::create( $clusterInterfaceObject,
                                                                                    $clusterValueObject->getClusterName(),
                                                                                    $displayWidth);
            $blockClusterInterfaceObject->addActionLink(   PdpActionInterfaceBuilderComponents::getEditClusterLink(     $clusterId));
            $blockClusterInterfaceObject->addActionLink(   PdpActionInterfaceBuilderComponents::getRemoveClusterLink(   $clusterId));
            $groupInterfaceObject->addBlockInterfaceObject($blockClusterInterfaceObject);
        }

        return $groupInterfaceObject->fetchHtml();
    }

    static function getUserDefinedViewHtml( $displayWidth,
                                            PdpActionUserDefinedGroupCollection $clusterGroupCollection)
    {
        $clusterValueObject = $clusterGroupCollection->getClusterValueObject();
        $groupInterfaceObject = PdpActionUserDefinedClusterGroup::create( $clusterValueObject->getClusterName(),
                                                                          $displayWidth);

        $clusterKeys = $clusterGroupCollection->getKeys();
        foreach($clusterKeys as $key) {
            $clusterCollection = $clusterGroupCollection->getCollection($key);

            $clusterInterfaceObject = PdpActionUserDefinedClusterView::create(  $clusterCollection->getPdpActionName(),
                                                                                $clusterCollection->isCustomerLibrary(),
                                                                                $displayWidth);

            $valueObjects       = $clusterCollection->getValueObjects();



            // omzetten naar template data
            foreach($valueObjects as $valueObject) {
                $employeePdpActionId    = $valueObject->getEmployeePdpActionId();
                $employeeId             = $valueObject->getEmployeeId();

                $interfaceObject = PdpActionUserDefinedView::createWithValueObject( $valueObject,
                                                                                    $displayWidth);

                $interfaceObject->addActionLink(        PdpActionInterfaceBuilderComponents::getEditUserDefinedLink($employeeId,
                                                                                                                    $employeePdpActionId));

                $clusterInterfaceObject->addInterfaceObject($interfaceObject);
            }
            $groupInterfaceObject->addInterfaceObject($clusterInterfaceObject);
        }

        $blockClusterInterfaceObject = BaseBlockClusterInterfaceObject::create( $groupInterfaceObject,
                                                                                $groupInterfaceObject->getClusterName(),
                                                                                $displayWidth);

        return $blockClusterInterfaceObject->fetchHtml();
    }

    static function getAddHtml( $displayWidth,
                                PdpActionValueObject $valueObject)
    {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__ADD_PDPACTION);

        // cluster
        $safeFormHandler->addIntegerInputFormatType('cluster_id');
        $safeFormHandler->addStringInputFormatType('cluster_name');
        $safeFormHandler->addStringInputFormatType('cluster_selector');

        // pdp actie
        $safeFormHandler->addStringInputFormatType('action_name');
        $safeFormHandler->addStringInputFormatType('provider');
        $safeFormHandler->addStringInputFormatType('duration');
        $safeFormHandler->addStringInputFormatType('cost'); // eigenlijk numeric of zo

        $safeFormHandler->finalizeDataDefinition();

        $clusterIdValues = PdpActionClusterService::getClusterIdValues();
        $interfaceObject = PdpActionEdit::createWithValueObject($valueObject,
                                                                $displayWidth);
        $interfaceObject->setClusterIdValues($clusterIdValues);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);

    }

    static function getEditHtml($displayWidth,
                                PdpActionValueObject $valueObject)
    {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__EDIT_PDPACTION);

        $safeFormHandler->storeSafeValue('pdpActionId', $valueObject->getId());

        // cluster
        $safeFormHandler->addIntegerInputFormatType('cluster_id');
        $safeFormHandler->addStringInputFormatType('cluster_name');
        $safeFormHandler->addIntegerInputFormatType('cluster_selector');

        // pdp actie
        $safeFormHandler->addStringInputFormatType('action_name');
        $safeFormHandler->addStringInputFormatType('provider');
        $safeFormHandler->addStringInputFormatType('duration');
        $safeFormHandler->addStringInputFormatType('cost'); // eigenlijk numeric of zo

        $safeFormHandler->addIntegerInputFormatType('apply_to');

        $safeFormHandler->finalizeDataDefinition();

        $clusterIdValues = PdpActionClusterService::getClusterIdValues();
        $interfaceObject = PdpActionEdit::createWithValueObject($valueObject,
                                                                $displayWidth);

        $interfaceObject->setClusterIdValues($clusterIdValues);

        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);

    }

    static function getRemoveHtml(  $displayWidth,
                                    PdpActionValueObject $valueObject)
    {

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__DELETE_PDPACTION);

        $safeFormHandler->storeSafeValue('pdpActionId', $valueObject->getId());
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $interfaceObject = PdpActionDelete::createWithValueObject(  $valueObject,
                                                                    $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_ACTION'));
        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getEditClusterHtml( $displayWidth,
                                        PdpActionClusterValueObject $clusterValueObject)
    {
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__EDIT_PDPCLUSTER);

        $safeFormHandler->storeSafeValue('pdpActionClusterId', $clusterValueObject->getId());
        $safeFormHandler->addStringInputFormatType('cluster_name');
        $safeFormHandler->finalizeDataDefinition();

        $interfaceObject = PdpActionClusterEdit::createWithValueObject( $clusterValueObject,
                                                                        $displayWidth);
        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

    static function getRemoveClusterHtml(   $displayWidth,
                                            PdpActionClusterValueObject $clusterValueObject)
    {

        // safeForm
        $safeFormHandler = SafeFormHandler::create(SAFEFORM_PDPACTIONLIBRARY__DELETE_PDPCLUSTER);

        $safeFormHandler->storeSafeValue('pdpActionClusterId', $clusterValueObject->getId());
        $safeFormHandler->finalizeDataDefinition();

        // vullen template
        $interfaceObject = PdpActionClusterDelete::createWithValueObject(   $clusterValueObject,
                                                                            $displayWidth);
        $interfaceObject->setConfirmQuestion(   TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_REMOVE_THIS_CLUSTER'));
        $contentHtml = $interfaceObject->fetchHtml();

        return array($safeFormHandler, $contentHtml);
    }

}

?>
