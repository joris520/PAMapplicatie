<?php

/**
 * Description of PdpActionSelectClusterGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class PdpActionSelectClusterGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionSelectClusterGroup.tpl';

    private $clusterName;

    static function create( $displayWidth,
                            $clusterName)
    {
        return new PdpActionSelectClusterGroup( $displayWidth,
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
    function addInterfaceObject(PdpActionSelectClusterView $interfaceObject)
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
