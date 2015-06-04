<?php

/**
 * Description of PdpActionUserDefinedClusterGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class PdpActionUserDefinedClusterGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionUserDefinedClusterGroup.tpl';

    private $clusterName;

    static function create( $clusterName,
                            $displayWidth)
    {
        return new PdpActionUserDefinedClusterGroup($clusterName,
                                                    $displayWidth);
    }

    protected function __construct( $clusterName,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->clusterName = $clusterName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(PdpActionUserDefinedClusterView $interfaceObject)
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
