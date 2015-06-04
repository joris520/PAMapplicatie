<?php

/**
 * Description of PdpActionValueObject
 *
 * @author ben.dokter
 */

require_once('application/model/valueobjects/BaseValueObject.class.php');

class PdpActionValueObject extends BaseValueObject
{
    private $clusterName;
    private $clusterId;
    private $isCustomerDefined;

    private $actionName;
    private $provider;
    private $duration;
    private $cost;

    private $usageCount;

    static function createWithData( $pdpActionData)
    {
        return new PdpActionValueObject($pdpActionData[PdpActionQueries::ID_FIELD],
                                        $pdpActionData);
    }

    static function createWithValues(   $pdpActionId,
                                        $actionName,
                                        $provider,
                                        $duration,
                                        $cost)
    {
        $pdpActionData = array();
        $pdpActionData['action']    = $actionName;
        $pdpActionData['provider']  = $provider;
        $pdpActionData['duration']  = $duration;
        $pdpActionData['costs']     = $cost;

        return new PdpActionValueObject($pdpActionId,
                                        $pdpActionData);
    }

    protected function __construct( $pdpActionId,
                                    $pdpActionData)
    {
        parent::__construct($pdpActionId,
                            $pdpActionData['saved_by_user_id'], // hebben we nog niet
                            $pdpActionData['saved_by_user'],    // hebben we nog niet
                            $pdpActionData['saved_datetime']);  // hebben we nog niet

        $this->clusterName          = $pdpActionData['cluster'];
        $this->clusterId            = $pdpActionData['ID_PDPAC'];
        $this->isCustomerDefined    = $pdpActionData['is_customer_library'] = PDP_ACTION_LIBRARY_CUSTOMER;

        $this->actionName           = $pdpActionData['action'];
        $this->provider             = $pdpActionData['provider'];
        $this->duration             = $pdpActionData['duration'];
        $this->cost                 = $pdpActionData['costs'];

        // niet altijd aanwezig:
        $this->usageCount   = $pdpActionData['pdp_action_usage'];
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getClusterName()
    {
        return $this->clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isCustomerDefined()
    {
        return $this->isCustomerDefined;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setClusterId($clusterId)
    {
        $this->clusterId = $clusterId;
    }

    function getClusterId()
    {
        return $this->clusterId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getActionName()
    {
        return $this->actionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getProvider()
    {
        return $this->provider;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getDuration()
    {
        return $this->duration;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCost()
    {
        return $this->cost;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getUsageCount()
    {
        return $this->usageCount;
    }

}

?>
