<?php

/**
 * Description of PdpActionDashboardView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/report/BaseDashboardView.class.php');

require_once('modules/model/valueobjects/report/PdpActionDashboardValueObject.class.php');

class PdpActionDashboardView extends BaseDashboardView
{
    const TEMPLATE_FILE = 'report/pdpActionDashboardView.tpl';

    static function create( PdpActionDashboardValueObject $valueObject,
                            $displayWidth)
    {
        return new PdpActionDashboardView(  $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

}

?>
