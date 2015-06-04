<?php

/**
 * Description of DocumentClusterService
 *
 * @author ben.dokter
 */
require_once('modules/model/queries/library/DocumentClusterQueries.class.php');
require_once('modules/model/valueobjects/library/DocumentClusterValueObject.class.php');

class DocumentClusterService
{

    static function getValueObjects()
    {
        $valueObjects = array();

        $query = DocumentClusterQueries::getDocumentClusters();
        while ($documentClusterData = @mysql_fetch_assoc($query)) {
            $valueObjects[] = DocumentClusterValueObject::createWithData($documentClusterData);
        }
        mysql_free_result($query);

        return $valueObjects;
    }

    static function getValueObjectById($documentClusterId)
    {
        $valueObject = NULL;

        $query = DocumentClusterQueries::selectDocumentCluster($documentClusterId);
        $documentClusterData = @mysql_fetch_assoc($query);
        $valueObject = DocumentClusterValueObject::createWithData($documentClusterData);

        mysql_free_result($query);
        return $valueObject;
    }

    static function getDocumentClusterIdWithName($clusterName)
    {
        $query = DocumentClusterQueries::findDocumentClusterWithName($clusterName);
        $documentClusterData = @mysql_fetch_assoc($query);

        mysql_free_result($query);
        return $documentClusterData[DocumentClusterQueries::ID_FIELD];
    }

    static function validate(DocumentClusterValueObject $valueObject)
    {
        $hasError = false;
        $messages = array();

        $clusterId   = $valueObject->getId();
        $clusterName = $valueObject->clusterName;
        if (empty($clusterName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_AN_ATTACHMENT_CLUSTER_NAME');
        } else {
            $foundId = self::getDocumentClusterIdWithName($clusterName);
            if (!empty($foundId) && (empty($clusterId) || $clusterId != $foundId)) {
                $hasError = true;
                $messages[] = TXT_UCF('NAME_ALREADY_EXISTS_FOR_ANOTHER_ATTACHMENT_CLUSTER');
            }
        }
        return array($hasError, $messages);
    }

    static function addValidated(DocumentClusterValueObject $valueObject)
    {
        return DocumentClusterQueries::insertDocumentCluster($valueObject->clusterName);
    }

    static function updateValidated($documentClusterId,
                                    DocumentClusterValueObject $valueObject)
    {
        return DocumentClusterQueries::updateDocumentCluster(   $documentClusterId,
                                                                $valueObject->clusterName);
    }

    static function isRemovable($documentClusterId)
    {
        $usageCounterQuery = DocumentClusterQueries::countUsage($documentClusterId);
        $usageCounter = mysql_fetch_assoc($usageCounterQuery);
        mysql_free_result($usageCounterQuery);

        return $usageCounter['counted'] == 0;
    }

    static function validateRemove($documentClusterId)
    {
        $hasError = false;
        $messages = array();

        if (!self::isRemovable($documentClusterId)) {
            $hasError = true;
            $messages[] = TXT_UCF('YOU_CANNOT_DELETE_THIS_ATTACHMENT_CLUSTER_WHILE_THERE_ARE_ATTACHMENTS_CONNECTED_TO_IT');
        }
        return array($hasError, $messages);
    }

    static function remove($documentClusterId)
    {
        if (self::isRemovable($documentClusterId)) {
            DocumentClusterQueries::deleteDocumentCluster($documentClusterId);
        }
    }

}

?>
