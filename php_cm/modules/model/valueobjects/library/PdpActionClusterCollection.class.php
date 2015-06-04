<?php
/**
 * Description of PdpActionClusterCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');

class PdpActionClusterCollection extends BaseCollection
{
    private $clusterValueObject;

    static function create(PdpActionClusterValueObject $pdpActionClusterValueObject)
    {
        return new PdpActionClusterCollection($pdpActionClusterValueObject);
    }

    function __construct(PdpActionClusterValueObject $pdpActionClusterValueObject)
    {
        parent::__construct();
        $this->clusterValueObject = $pdpActionClusterValueObject;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addValueObject(PdpActionValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

    function hasPdpActions()
    {
        return parent::hasValueObjects();
    }

    /**
     * @return PdpActionValueObject
     */
    function getValueObjects()
    {
        return parent::getValueObjects();
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    /**
     * @return PdpActionClusterValueObject
     */
    function getClusterValueObject()
    {
        return $this->clusterValueObject;
    }

    function getClusterId()
    {
        return $this->clusterValueObject->getId();
    }
}

?>
