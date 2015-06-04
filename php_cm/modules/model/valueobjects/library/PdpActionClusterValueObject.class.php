<?php

/**
 * Description of PdpActionClusterValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class PdpActionClusterValueObject extends BaseValueObject
{
    private $clusterName;
    private $usageCount;


    static function createWithData($pdpActionClusterData)
    {
        return new PdpActionClusterValueObject( $pdpActionClusterData[PdpActionQueries::CLUSTER_ID_FIELD],
                                                $pdpActionClusterData);
    }

    static function createWithValues(   $pdpActionClusterId,
                                        $clusterName)
    {
        $pdpActionClusterData = array();
        $pdpActionClusterData[PdpActionQueries::CLUSTER_ID_FIELD] = $pdpActionClusterId;
        $pdpActionClusterData['cluster'] = $clusterName;

        return new PdpActionClusterValueObject( $pdpActionClusterId,
                                                $pdpActionClusterData);
    }

    protected function __construct( $pdpActionClusterId,
                                    $pdpActionClusterData)
    {
        parent::__construct($pdpActionClusterId,
                            $pdpActionClusterData['saved_by_user_id'], // hebben we nog niet
                            $pdpActionClusterData['saved_by_user'],    // hebben we nog niet
                            $pdpActionClusterData['saved_datetime']);  // hebben we nog niet

        $this->clusterName  = $pdpActionClusterData['cluster'];
        // niet altijd aanwezig:
        $this->usageCount = $pdpActionClusterData['cluster_usage'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClusterName($clusterName)
    {
        $this->clusterName = $clusterName;
    }

    function getClusterName()
    {
        return $this->clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUsageCount()
    {
        return $this->usageCount;
    }

    function hasPdpActions()
    {
        return ($this->usageCount > 0);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getClusterId()
    {
        return $this->getId();
    }

}

?>
