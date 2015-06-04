<?php

/**
 * Description of PdpActionClusterGroupCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseGroupCollection.class.php');

class PdpActionClusterGroupCollection extends BaseGroupCollection
{
    static function create()
    {
        return new PdpActionClusterGroupCollection();
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCollection( $clusterId,
                            PdpActionClusterCollection $collection)
    {
        parent::setCollection(  $clusterId,
                                $collection);
    }

    /**
     * @return PdpActionClusterCollection
     */
    function  getCollection($key)
    {
        return parent::getCollection($key);
    }

}

?>
