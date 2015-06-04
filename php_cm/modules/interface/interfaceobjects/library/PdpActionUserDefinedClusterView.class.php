<?php

/**
 * Description of PdpActionUserDefinedClusterView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class PdpActionUserDefinedClusterView extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'library/pdpActionUserDefinedClusterView.tpl';

    private $pdpActionName;
    private $isCustomerLibrary;

    static function create( $pdpActionName,
                            $isCustomerLibrary,
                            $displayWidth)
    {
        return new PdpActionUserDefinedClusterView( $pdpActionName,
                                                    $isCustomerLibrary,
                                                    $displayWidth);
    }

    protected function __construct( $pdpActionName,
                                    $isCustomerLibrary,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->pdpActionName        = $pdpActionName;
        $this->isCustomerLibrary    = $isCustomerLibrary;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addInterfaceObject(PdpActionUserDefinedView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPdpActionName()
    {
        return $this->pdpActionName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function isCustomerLibrary()
    {
        return $this->isCustomerLibrary;
    }

}

?>
