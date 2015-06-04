<?php

/**
 * Description of BaseDashboardCollection
 *
 * @author ben.dokter
 */

require_once('modules/model/valueobjects/BaseCollection.class.php');
require_once('modules/model/valueobjects/report/BaseDashboardCountValueObject.class.php');

class BaseDashboardCollection extends BaseCollection
{
    protected $totalCountValueObject;
    protected $keyIdValues;

    protected function __construct(BaseDashboardCountValueObject $totalCountValueObject,
                                   Array $keyIdValues)
    {
        parent::__construct();
        $this->keyIdValues              = $keyIdValues;
        $this->totalCountValueObject    = $totalCountValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function addValueObject(BaseDashboardCountValueObject $valueObject)
    {
        parent::addValueObject($valueObject);
        $this->countTotals($valueObject);
    }

    function countTotals(BaseDashboardCountValueObject $valueObject)
    {
        // totalen bijwerken
        $this->totalCountValueObject->addEmployeesTotal($valueObject->getEmployeesTotal());
        $this->totalCountValueObject->addEmployeesWithout($valueObject->getEmployeesWithout());

        // per key de getelde employees toevoegen
        $keys = $valueObject->getEmployeeCountKeys();
        foreach($keys as $key) {
            $this->totalCountValueObject->addEmployeeCountForKey($key, $valueObject->getEmployeeCountForKey($key));
        }
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getKeyIdValues()
    {
        return $this->keyIdValues;
    }



    /**
     *
     * @return BaseDashboardCountValueObject
     */
    function getTotalCountValueObject()
    {
        return $this->totalCountValueObject;
    }


}

?>
