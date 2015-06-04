<?php

/**
 * Description of EmployeePdpActionView
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class EmployeePdpActionView extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'employee/pdpAction/employeePdpActionView.tpl';

    private $relatedCompetences;
    private $showDetailInfo;
    private $dateWarning;


    static function createWithValueObject(  EmployeePdpActionValueObject $valueObject,
                                            $displayWidth)
    {
        return new EmployeePdpActionView(   $valueObject,
                                            $displayWidth,
                                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowDetailInfo($showDetailInfo)
    {
        $this->showDetailInfo = $showDetailInfo;
    }

    function showDetailInfo()
    {
        return $this->showDetailInfo;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setRelatedCompetences($relatedCompetences)
    {
        $this->relatedCompetences = $relatedCompetences;
    }

    function getRelatedCompetences()
    {
        return $this->relatedCompetences;
    }

    function hasRelatedCompetences()
    {
        return !empty($this->relatedCompetences);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setDateWarning($dateWarning)
    {
        $this->dateWarning = $dateWarning;
    }

    function hasDateWarning()
    {
        return $this->dateWarning;
    }

}

?>
