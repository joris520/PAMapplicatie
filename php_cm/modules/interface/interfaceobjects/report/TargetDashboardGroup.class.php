<?php

/**
 * Description of TargetDashboardGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/report/BaseDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/TargetDashboardView.class.php');

class TargetDashboardGroup extends BaseDashboardGroup
{
    const TEMPLATE_FILE = 'report/targetDashboardGroup.tpl';

    static function create( TargetDashboardCountValueObject $valueObject,
                            $showTotals,
                            $displayWidth)
    {
        return new TargetDashboardGroup($valueObject,
                                        $showTotals,
                                        $displayWidth);
    }

    protected function __construct( TargetDashboardCountValueObject $valueObject,
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
    function addInterfaceObject(TargetDashboardView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

}

?>
