<?php

/**
 * Description of FinalResultDashboardView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/report/BaseDashboardView.class.php');

require_once('modules/model/valueobjects/report/FinalResultDashboardValueObject.class.php');

class FinalResultDashboardView extends BaseDashboardView

{
    const TEMPLATE_FILE = 'report/finalResultDashboardView.tpl';

    static function create( FinalResultDashboardValueObject $valueObject,
                            $displayWidth)
    {
        return new FinalResultDashboardView($valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

}

?>
