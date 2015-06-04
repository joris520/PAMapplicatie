<?php

/**
 * Description of BaseDashboardView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');


class BaseDashboardView extends BaseValueObjectInterfaceObject
{
    private $totalDetailLink;
    private $withoutDetailLink;

    private $keyIdValues;
    private $keyDetailLinks;

    protected function __construct( BaseValueObject $valueObject,
                                    $displayWidth,
                                    $templateFile)
    {
        parent::__construct($valueObject,
                            $displayWidth,
                            $templateFile);

        $this->keyIdValues              = array();
        $this->employeeKeyDetailLinks   = array();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setKeyIdValues(Array $keyIdValues)
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
    function setKeyDetailLink($key, $keyDetailLink)
    {
        $this->keyDetailLinks[$key] = $keyDetailLink;
    }

    function getkeyDetailLink($key)
    {
        return $this->keyDetailLinks[$key];
    }

}

?>
