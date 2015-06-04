<?php

/**
 * Description of FinalResultDashboardCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/report/BaseDashboardCollection.class.php');

require_once('modules/model/valueobjects/report/FinalResultDashboardValueObject.class.php');
require_once('modules/model/valueobjects/report/FinalResultDashboardCountValueObject.class.php');

class FinalResultDashboardCollection extends BaseDashboardCollection
{
    static function create(Array $keyIdValues)
    {
        $totalCountValueObject = FinalResultDashboardCountValueObject::create();
        return new FinalResultDashboardCollection(  $totalCountValueObject,
                                                    $keyIdValues);
    }

    function addValueObject(FinalResultDashboardValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
    }

    function countTotals(BaseDashboardCountValueObject $valueObject)
    {
        // totalen bijwerken
        $this->totalCountValueObject->addEmployeesTotal(count($valueObject->getEmployeesTotal()));

        // per key de getelde employees toevoegen
        $keys = $valueObject->getEmployeeCountKeys();
        foreach($keys as $key) {
            $this->totalCountValueObject->addEmployeeCountForKey($key, count($valueObject->getEmployeeCountForKey($key)));
        }
    }


}

?>
