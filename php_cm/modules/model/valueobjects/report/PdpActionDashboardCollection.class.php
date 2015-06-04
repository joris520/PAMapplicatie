<?php

/**
 * Description of PdpActionDashboardCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseDashboardCollection.class.php');

require_once('modules/model/valueobjects/report/PdpActionDashboardValueObject.class.php');
require_once('modules/model/valueobjects/report/PdpActionDashboardCountValueObject.class.php');

class PdpActionDashboardCollection extends BaseDashboardCollection
{

    static function create(Array $keyIdValues)
    {
        $totalCountValueObject = PdpActionDashboardCountValueObject::create();
        
        return new PdpActionDashboardCollection($totalCountValueObject,
                                                $keyIdValues);
    }

    function addValueObject(PdpActionDashboardValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
