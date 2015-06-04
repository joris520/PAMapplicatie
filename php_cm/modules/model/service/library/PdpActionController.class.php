<?php

/**
 * Description of PdpActionController
 *
 * @author ben.dokter
 */

require_once('modules/model/service/library/PdpActionService.class.php');
require_once('modules/model/service/library/PdpActionClusterService.class.php');

class PdpActionController
{

    static function processAdd( PdpActionValueObject $valueObject,
                                PdpActionClusterValueObject $clusterValueObject,
                                $clusterSelector)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        switch($clusterSelector) {
            case PdpActionClusterSelectorState::CREATE_NEW_CLUSTER:
                list($hasClusterError, $clusterMessages) = PdpActionClusterService::validateCluster($clusterValueObject);
                if (!$hasClusterError) {
                    $newClusterId = PdpActionClusterService::addValidatedCluster($clusterValueObject);
                    $valueObject->setClusterId($newClusterId);
                }
                break;
            case PdpActionClusterSelectorState::USE_EXISTING_CLUSTER:
            default:
                $hasClusterError = false;
                $clusterMessages = array();
                break;
        }

        list($hasActionError, $actionMessages) = PdpActionService::validate($valueObject);

        $messages = array_merge($clusterMessages, $actionMessages);
        $hasError = $hasClusterError || $hasActionError;

        if (!$hasError) {
            $newPdpActionId = PdpActionService::addValidated($valueObject);
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $newPdpActionId);

    }

    static function processEdit($pdpActionId,
                                PdpActionValueObject $valueObject,
                                PdpActionClusterValueObject $clusterValueObject,
                                $clusterSelector,
                                $applyToSelector)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        switch($clusterSelector) {
            case PdpActionClusterSelectorState::CREATE_NEW_CLUSTER:
                list($hasClusterError, $clusterMessages) = PdpActionClusterService::validateCluster($clusterValueObject);
                if (!$hasClusterError) {
                    $newClusterId = PdpActionClusterService::addValidatedCluster($clusterValueObject);
                    $valueObject->setClusterId($newClusterId);
                }
                break;
            case PdpActionClusterSelectorState::USE_EXISTING_CLUSTER:
            default:
                $hasClusterError = false;
                $clusterMessages = array();
                break;
        }

        list($hasActionError, $actionMessages) = PdpActionService::validate($valueObject);

        $messages = array_merge($clusterMessages, $actionMessages);
        $hasError = $hasClusterError || $hasActionError;

        if (!$hasError) {
            $updatedCount = PdpActionService::updateValidated(  $valueObject);
            if ($updatedCount > 0 && $applyToSelector == PdpActionApplyToState::APPLY_TO_EXISTING) {
                EmployeePdpActionService::updateExistingEmployeePdpActions($valueObject);
            }
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);

    }

    static function processRemove(PdpActionValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = PdpActionService::validateRemove($valueObject);

        if (!$hasError) {
            PdpActionService::remove($valueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

//    static function processAddCluster(PdpActionClusterValueObject $valueObject)
//    {
//        $hasError = false;
//        $messages = array();
//
//        BaseQueries::startTransaction();
//
//        list($hasError, $messages) = PdpActionClusterService::validateCluster($valueObject);
//
//        if (!$hasError) {
//            PdpActionClusterService::insertValidatedCluster($valueObject);
//
//            BaseQueries::finishTransaction();
//        }
//        return array($hasError, $messages);
//
//    }

    static function processEditCluster( $pdpActionClusterId,
                                        PdpActionClusterValueObject $clusterValueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = PdpActionClusterService::validateCluster($clusterValueObject);

        if (!$hasError) {
            PdpActionClusterService::updateValidatedCluster(   $pdpActionClusterId,
                                                        $clusterValueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);

    }

    static function processRemoveCluster(PdpActionClusterValueObject $clusterValueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = PdpActionClusterService::validateRemoveCluster($clusterValueObject);

        if (!$hasError) {
            PdpActionClusterService::removeCluster($clusterValueObject);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

}

?>
