<?php

/**
 * Description of PdpActionDashboardGroup
 *
 * @author ben.dokter
 */


require_once('modules/interface/interfaceobjects/report/BaseDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/PdpActionDashboardView.class.php');

class PdpActionDashboardGroup extends BaseDashboardGroup
{
    const TEMPLATE_FILE = 'report/pdpActionDashboardGroup.tpl';

    static function create( PdpActionDashboardCountValueObject $valueObject,
                            $showTotals,
                            $displayWidth)
    {
        return new PdpActionDashboardGroup( $valueObject,
                                            $showTotals,
                                            $displayWidth);
    }

    protected function __construct( PdpActionDashboardCountValueObject $valueObject,
                                    $showTotals,
                                    $displayWidth)
    {
        parent::__construct($valueObject,
                            $showTotals,
                            $displayWidth,
                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(PdpActionDashboardView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>