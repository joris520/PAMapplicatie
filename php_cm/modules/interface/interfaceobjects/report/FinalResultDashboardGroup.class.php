<?php

/**
 * Description of FinalResultDashboardGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/report/BaseDashboardGroup.class.php');
require_once('modules/interface/interfaceobjects/report/FinalResultDashboardView.class.php');

class FinalResultDashboardGroup extends BaseDashboardGroup
{
    const TEMPLATE_FILE = 'report/finalResultDashboardGroup.tpl';

    static function create( FinalResultDashboardCountValueObject $valueObject,
                            $showTotals,
                            $displayWidth)
    {
        return new FinalResultDashboardGroup(   $valueObject,
                                                $showTotals,
                                                $displayWidth);
    }

    protected function __construct( FinalResultDashboardCountValueObject $valueObject,
                                    $showTotals,
                                    $displayWidth)
    {
        parent::__construct($valueObject,
                            $showTotals,
                            $displayWidth,
                            self::TEMPLATE_FILE);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // type hinting
    function addInterfaceObject(FinalResultDashboardView $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setTotalScoreIdValues(Array $totalScoreIdValues)
    {
        $this->setKeyIdValues($totalScoreIdValues);
    }

    function getTotalScoreIdValues()
    {
        return $this->getKeyIdValues();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getEmployeesTotal()
    {
        return $this->totalCountValueObject->getEmployeesTotal();
    }

    function getFinalResultNoneTotal()
    {
        return $this->totalCountValueObject->getFinalResultNone();
    }

    function getFinalResultForScore($score)
    {
        return $this->totalCountValueObject->getFinalResultForScore($score);
    }



}

?>
