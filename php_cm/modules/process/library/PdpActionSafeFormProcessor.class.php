<?php


/**
 * Description of PdpActionSafeFormProcessor
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/PdpActionController.class.php');

require_once('modules/interface/converter/library/pdpAction/PdpCostConverter.class.php');
require_once('modules/interface/state/PdpActionClusterSelectorState.class.php');
require_once('modules/interface/state/PdpActionApplyToState.class.php');

class PdpActionSafeFormProcessor
{

    static function processAdd( xajaxResponse $objResponse,
                                SafeFormHandler $safeFormHandler)
    {
        if (PermissionsService::isAddAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $clusterId          = $safeFormHandler->retrieveInputValue('cluster_id');
            $clusterName        = $safeFormHandler->retrieveInputValue('cluster_name');
            $clusterSelector    = $safeFormHandler->retrieveInputValue('cluster_selector');

            $actionName = $safeFormHandler->retrieveInputValue('action_name');
            $provider   = $safeFormHandler->retrieveInputValue('provider');
            $duration   = $safeFormHandler->retrieveInputValue('duration');
            $cost       = $safeFormHandler->retrieveInputValue('cost');

            if (PdpCostConverter::isValidNumber($cost)) {
                $cost = PdpCostConverter::value($cost);
            }

            $clusterValueObject = PdpActionClusterValueObject::createWithValues($clusterId,
                                                                                $clusterName);

            $valueObject = PdpActionValueObject::createWithValues(  $pdpActionId,
                                                                    $actionName,
                                                                    $provider,
                                                                    $duration,
                                                                    $cost);
            $valueObject->setClusterId($clusterId);

            list($hasError, $messages, $newPdpActionId) = PdpActionController::processAdd(  $valueObject,
                                                                                            $clusterValueObject,
                                                                                            $clusterSelector);
            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                PdpActionInterfaceProcessor::finishAdd( $objResponse,
                                                        $newPdpActionId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEdit(xajaxResponse $objResponse,
                                SafeFormHandler $safeFormHandler)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $pdpActionId = $safeFormHandler->retrieveSafeValue('pdpActionId');

            $clusterId          = $safeFormHandler->retrieveInputValue('cluster_id');
            $clusterName        = $safeFormHandler->retrieveInputValue('cluster_name');
            $clusterSelector    = $safeFormHandler->retrieveInputValue('cluster_selector');
            $applyToSelector    = $safeFormHandler->retrieveInputValue('apply_to');

            $actionName = $safeFormHandler->retrieveInputValue('action_name');
            $provider   = $safeFormHandler->retrieveInputValue('provider');
            $duration   = $safeFormHandler->retrieveInputValue('duration');
            $cost       = $safeFormHandler->retrieveInputValue('cost');

            if (PdpCostConverter::isValidNumber($cost)) {
                $cost = PdpCostConverter::value($cost);
            }

            $clusterValueObject = PdpActionClusterValueObject::createWithValues($clusterId,
                                                                                $clusterName);

            $valueObject = PdpActionValueObject::createWithValues(  $pdpActionId,
                                                                    $actionName,
                                                                    $provider,
                                                                    $duration,
                                                                    $cost);
            $valueObject->setClusterId($clusterId);

            list($hasError, $messages) = PdpActionController::processEdit(  $pdpActionId,
                                                                            $valueObject,
                                                                            $clusterValueObject,
                                                                            $clusterSelector,
                                                                            $applyToSelector);
            if (!$hasError) {
                $safeFormHandler->finalizeSafeFormProcess();
                PdpActionInterfaceProcessor::finishEdit($objResponse,
                                                        $pdpActionId);
            }
        }
        return array($hasError, $messages);
    }

    static function processRemove(  xajaxResponse $objResponse,
                                    SafeFormHandler $safeFormHandler)
    {
        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $pdpActionId = $safeFormHandler->retrieveSafeValue('pdpActionId');

            $valueObject = PdpActionService::getValueObject($pdpActionId);
            list($hasError, $messages) = PdpActionController::processRemove($valueObject);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                PdpActionInterfaceProcessor::finishRemove( $objResponse,
                                                           $pdpActionId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEditCluster( xajaxResponse $objResponse,
                                        SafeFormHandler $safeFormHandler)
    {
        if (PermissionsService::isEditAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {
            $pdpActionClusterId = $safeFormHandler->retrieveSafeValue('pdpActionClusterId');
            $clusterName = $safeFormHandler->retrieveInputValue('cluster_name');

            $valueObject = PdpActionClusterValueObject::createWithValues(   $pdpActionClusterId,
                                                                            $clusterName);
            list($hasError, $messages) = PdpActionController::processEditCluster(   $pdpActionClusterId,
                                                                                    $valueObject);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                PdpActionInterfaceProcessor::finishEditCluster( $objResponse,
                                                                $pdpActionClusterId);
            }
        }
        return array($hasError, $messages);
    }

    static function processRemoveCluster(   xajaxResponse $objResponse,
                                            SafeFormHandler $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_PDP_ACTION_LIBRARY)) {

            $pdpActionClusterId = $safeFormHandler->retrieveSafeValue('pdpActionClusterId');
            $valueObject = PdpActionClusterService::getCluster($pdpActionClusterId);

            list($hasError, $messages) = PdpActionController::processRemoveCluster($valueObject);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                PdpActionInterfaceProcessor::finishRemoveCluster(   $objResponse,
                                                                    $pdpActionClusterId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
