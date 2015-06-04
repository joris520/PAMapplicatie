<?php

/**
 * Description of DocumentClusterController
 *
 * @author ben.dokter
 */
require_once('modules/model/service/library/DocumentClusterService.class.php');

class DocumentClusterController
{
    static function processAdd(DocumentClusterValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = DocumentClusterService::validate($valueObject);
        if (!$hasError) {
            $documentClusterId = DocumentClusterService::addValidated($valueObject);
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages, $documentClusterId);
    }

    static function processEdit($documentClusterId,
                                DocumentClusterValueObject$valueObject)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = DocumentClusterService::validate($valueObject);
        if (!$hasError) {
            DocumentClusterService::updateValidated($documentClusterId, $valueObject);
            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }

    static function processRemove($documentClusterId)
    {
        $hasError = false;
        $messages = array();

        BaseQueries::startTransaction();

        list($hasError, $messages) = DocumentClusterService::validateRemove($documentClusterId);

        if (!$hasError) {
            DocumentClusterService::remove($documentClusterId);

            BaseQueries::finishTransaction();
        }
        return array($hasError, $messages);
    }
}

?>
