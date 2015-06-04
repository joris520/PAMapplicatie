<?php

/**
 * Description of PdpActionClusterService
 *
 * @author ben.dokter
 */

require_once('modules/model/queries/library/PdpActionQueries.class.php');
require_once('modules/model/valueobjects/library/PdpActionClusterValueObject.class.php');
require_once('modules/model/valueobjects/library/PdpActionClusterCollection.class.php');
require_once('modules/model/valueobjects/library/PdpActionClusterGroupCollection.class.php');

require_once('modules/model/valueobjects/employee/pdpAction/EmployeePdpActionUserDefinedValueObject.class.php');

class PdpActionClusterService
{

    /**
     * voor code completion:
     * @return PdpActionClusterGroupCollection
     */
    static function getClusterCollections()
    {
        $clusterGroupCollection = PdpActionClusterGroupCollection::create();

        $query = PdpActionQueries::getClusteredPdpActions();
        while ($pdpActionClusterData = mysql_fetch_assoc($query)) {
            $clusterValueObject = PdpActionClusterValueObject::createWithData($pdpActionClusterData);
            $clusterId = $clusterValueObject->getClusterId();

            $clusterCollection = $clusterGroupCollection->getCollection($clusterId);
            if (empty($clusterCollection)) {
                $clusterCollection = PdpActionClusterCollection::create($clusterValueObject);
            }

            $valueObject = PdpActionValueObject::createWithData($pdpActionClusterData);
            $pdpActionId = $valueObject->getId();

            if (!empty($pdpActionId)) {
                $clusterCollection->addValueObject($valueObject);
            }

            $clusterGroupCollection->setCollection( $clusterId,
                                                    $clusterCollection);
        }

        mysql_free_result($query);

        return $clusterGroupCollection;
    }

    static function getUserDefinedClusterValueObject()
    {
        // user defined cluster opduiken
        $query = PdpActionQueries::getUserDefinedCluster();
        $userDefinedClusterData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        $clusterValueObject = PdpActionClusterValueObject::createWithData($userDefinedClusterData);
        $clusterValueObject->setClusterName(    TXT_UCF('USER_DEFINED_CLUSTER_NAME'));

        return $clusterValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * voor code completion:
     * @return PdpActionClusterValueObject
     */
    static function getCluster($clusterId)
    {
        $query = PdpActionQueries::getCluster($clusterId);
        $clusterData = mysql_fetch_assoc($query);

        $clusterValueObject = PdpActionClusterValueObject::createWithData($clusterData);
        mysql_free_result($query);

        return $clusterValueObject;
    }

    static function getClusterIdValues()
    {
        $clusterIdValues = array();

        $query = PdpActionQueries::getClusters();
        while ($clusterData = mysql_fetch_assoc($query)) {
            $clusterValueObject = PdpActionClusterValueObject::createWithData($clusterData);
            $clusterIdValues[] = IdValue::create(   $clusterValueObject->getId(),
                                                    $clusterValueObject->getClusterName());
        }
        mysql_free_result($query);

        return $clusterIdValues;
    }

    static function getPdpClusterIdWithName($clusterName)
    {
        $query = PdpActionQueries::findPdpActionClusterWithName($clusterName);
        $pdpActionClusterData = mysql_fetch_assoc($query);
        mysql_free_result($query);

        return $pdpActionClusterData[PdpActionQueries::CLUSTER_ID_FIELD];
    }


    static function validateCluster(PdpActionClusterValueObject $clusterValueObject)
    {
        $hasError = false;
        $messages = array();

        $clusterId   = $clusterValueObject->getId();
        $clusterName = $clusterValueObject->getClusterName();
        if (empty($clusterName)) {
            $hasError = true;
            $messages[] = TXT_UCF('PLEASE_ENTER_A_PDP_CLUSTER');
        } else {
            $foundId = self::getPdpClusterIdWithName($clusterName);
            if (!empty($foundId) && (empty($clusterId) || $clusterId != $foundId)) {
                $hasError = true;
                $messages[] = TXT_UCF('CLUSTER_NAME_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_CLUSTER_NAME');
            }
        }
        return array($hasError, $messages);
    }

    static function addValidatedCluster(PdpActionClusterValueObject $clusterValueObject)
    {
        return PdpActionQueries::insertCluster($clusterValueObject->getClusterName());
    }

    static function updateValidatedCluster( $clusterId,
                                            PdpActionClusterValueObject $clusterValueObject)
    {
        return PdpActionQueries::updateCluster( $clusterId,
                                                $clusterValueObject->getClusterName());
    }


    static function isRemovableCluster(PdpActionClusterValueObject $clusterValueObject)
    {
        return $clusterValueObject->hasId() && !$clusterValueObject->hasPdpActions();
    }

    static function validateRemoveCluster(PdpActionClusterValueObject $clusterValueObject)
    {
        $hasError = false;
        $messages = array();

        if (!self::isRemovableCluster($clusterValueObject)) {
            $hasError = true;
            $messages[] = TXT_UCF('YOU_CANNOT_DELETE_THIS_CLUSTER_BECAUSE_IT_IS_USED_BY_PDP_ACTIONS');
        }
        return array($hasError, $messages);
    }

    static function removeCluster(PdpActionClusterValueObject $clusterValueObject)
    {
        if (self::isRemovableCluster($clusterValueObject)) {
            PdpActionQueries::deleteCluster($clusterValueObject->getId());
        }
    }
}

?>
