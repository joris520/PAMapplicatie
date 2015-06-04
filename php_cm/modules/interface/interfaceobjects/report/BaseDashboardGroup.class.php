<?php

/**
 * Description of BaseDashboardGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class BaseDashboardGroup extends BaseGroupInterfaceObject
{
    private $totalCountValueObject;

    private $showTotals;

    private $employeesWithout;

    private $totalDetailLink;
    private $withoutDetailLink;

    private $keyDetailLinks;
    private $keyIdValues;

    protected function __construct( BaseDashboardCountValueObject $valueObject,
                                    $showTotals,
                                    $displayWidth,
                                    $templateFile)
    {
        parent::__construct($displayWidth,
                            $templateFile);

        $this->totalCountValueObject = $valueObject;

        $this->showTotals       = $showTotals;

        $this->employeesWithout = 0;

        $this->keyDetailLinks   = array();
        $this->keyIdValues      = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(BaseDashboardView $interfaceObject)
    {
        $this->employeesWithout += $interfaceObject->getValueObject()->getEmployeesWithout();
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getValueObject()
    {
        return $this->totalCountValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function showTotals()
    {
        return $this->showTotals;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeesWithout()
    {
        return $this->employeesWithout;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setKeyIdValues($keyIdValues)
    {
        $this->keyIdValues = $keyIdValues;
    }

    function getKeyIdValues()
    {
        return $this->keyIdValues;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalDetailLink($totalDetailLink)
    {
        $this->totalDetailLink = $totalDetailLink;
    }

    function getTotalDetailLink()
    {
        return $this->totalDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setWithoutDetailLink($withoutDetailLink)
    {
        $this->withoutDetailLink = $withoutDetailLink;
    }

    function getWithoutDetailLink()
    {
        return $this->withoutDetailLink;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setKeyDetailLink($key, $detailLink)
    {
        $this->keyDetailLinks[$key] = $detailLink;
    }

    function getKeyDetailLink($key)
    {
        return $this->keyDetailLinks[$key];
    }

    function getEmployeeCountKeys()
    {
        return array_keys($this->employeeCounts);
    }

}

?>
