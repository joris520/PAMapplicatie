<?php

/**
 * Description of PdpActionClusterGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class PdpActionClusterGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionClusterGroup.tpl';

    private $clusterName;

    static function create( $displayWidth,
                            $clusterName)
    {
        return new PdpActionClusterGroup(   $displayWidth,
                                            $clusterName);
    }

    protected function __construct( $displayWidth,
                                    $clusterName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->clusterName = $clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(PdpActionClusterView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getClusterName()
    {
        return $this->clusterName;
    }

}

?>
