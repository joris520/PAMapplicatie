<?php

/**
 * Description of PdpActionUserDefinedCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseGroupCollection.class.php');
require_once('modules/model/valueobjects/library/PdpActionClusterValueObject.class.php');

class PdpActionUserDefinedGroupCollection extends BaseGroupCollection
{
    private $clusterValueObject;

    static function create(PdpActionClusterValueObject $userDefinedClusterValueObject)
    {
        return new PdpActionUserDefinedGroupCollection($userDefinedClusterValueObject);
    }

    protected function __construct(PdpActionClusterValueObject $pdpActionClusterValueObject)
    {
        parent::__construct();
        $this->clusterValueObject = $pdpActionClusterValueObject;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getClusterValueObject()
    {
        return $this->clusterValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCollection( $pdpActionId,
                            EmployeePdpActionUserDefinedCollection $collection)
    {
        parent::setCollection(  $pdpActionId,
                                $collection);
    }

    /**
     * @return EmployeePdpActionUserDefinedCollection
     */
    function getCollection($key)
    {
        return parent::getCollection($key);
    }


}

?>
