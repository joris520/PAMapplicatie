<?php

/**
 * Description of PdpActionCountValueObject
 *
 * @author ben.dokter
 */


require_once('modules/model/valueobjects/report/BaseDashboardCountValueObject.class.php');

class PdpActionDashboardCountValueObject extends BaseDashboardCountValueObject
{

    // de create kan zonder id, aangeroepen vanuit de collection
    static function create()
    {
        return new PdpActionDashboardCountValueObject(NULL);
    }

}

?>
