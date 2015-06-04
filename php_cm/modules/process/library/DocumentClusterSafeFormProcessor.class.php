<?php

/**
 * Description of DocumentClusterSafeFormProcessor
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/DocumentClusterController.class.php');

class DocumentClusterSafeFormProcessor
{
    static function processAdd($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();
        if (PermissionsService::isAddAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {

            $newClusterId = null;
            $clusterName  = $safeFormHandler->retrieveInputValue('cluster_name');

            $valueObject = DocumentClusterValueObject::createWithValues($newClusterId,
                                                                        $clusterName);

            list($hasError, $messages, $newClusterId) = DocumentClusterController::processAdd($valueObject);
            if (!$hasError) {
                // klaar met add
                $safeFormHandler->finalizeSafeFormProcess();
                DocumentClusterInterfaceProcessor::finishAdd($objResponse, $newClusterId);
            }
        }
        return array($hasError, $messages);
    }

    static function processEdit($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isEditAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {

            $documentClusterId = $safeFormHandler->retrieveSafeValue('documentClusterId');

            $clusterName = $safeFormHandler->retrieveInputValue('cluster_name');

            $valueObject = DocumentClusterValueObject::createWithValues($documentClusterId,
                                                                        $clusterName);

            list($hasError, $messages) = DocumentClusterController::processEdit($documentClusterId, $valueObject);
            if (!$hasError) {
                // klaar met edit
                $safeFormHandler->finalizeSafeFormProcess();
                DocumentClusterInterfaceProcessor::finishEdit($objResponse, $documentClusterId);
            }
        }
        return array($hasError, $messages);
    }

    static function processRemove($objResponse, $safeFormHandler)
    {
        $hasError = true;
        $messages = array();

        if (PermissionsService::isDeleteAllowed(PERMISSION_DOCUMENT_CLUSTERS_LIBRARY)) {

            $documentClusterId = $safeFormHandler->retrieveSafeValue('documentClusterId');

            list($hasError, $messages) = DocumentClusterController::processRemove($documentClusterId);
            if (!$hasError) {
                // klaar met delete
                $safeFormHandler->finalizeSafeFormProcess();
                DocumentClusterInterfaceProcessor::finishRemove($objResponse, $documentClusterId);
            }
        }
        return array($hasError, $messages);
    }

}

?>
