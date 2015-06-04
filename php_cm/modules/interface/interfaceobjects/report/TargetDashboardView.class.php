<?php

/**
 * Description of TargetDashboardView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/report/BaseDashboardView.class.php');

require_once('modules/model/valueobjects/report/TargetDashboardValueObject.class.php');

class TargetDashboardView extends BaseDashboardView
{
    const TEMPLATE_FILE = 'report/targetDashboardView.tpl';

    static function create( TargetDashboardValueObject $valueObject,
                            $displayWidth)
    {
        return new TargetDashboardView( $valueObject,
                                        $displayWidth,
                                        self::TEMPLATE_FILE);
    }

}

?>
