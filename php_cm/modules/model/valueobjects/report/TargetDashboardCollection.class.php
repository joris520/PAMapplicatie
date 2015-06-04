<?php

/**
 * Description of TargetDashboardCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseDashboardCollection.class.php');

require_once('modules/model/valueobjects/report/TargetDashboardValueObject.class.php');
require_once('modules/model/valueobjects/report/TargetDashboardCountValueObject.class.php');


class TargetDashboardCollection extends BaseDashboardCollection
{
    static function create(Array $keyIdValues)
    {
        $totalCountValueObject = TargetDashboardCountValueObject::create();
        return new TargetDashboardCollection(   $totalCountValueObject,
                                                $keyIdValues);
    }

    function addValueObject(TargetDashboardValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

}

?>
