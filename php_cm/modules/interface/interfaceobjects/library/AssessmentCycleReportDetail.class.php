<?php

/**
 * Description of AssessmentCycleReportDetail
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseValueObjectInterfaceObject.class.php');

class AssessmentCycleReportDetail extends BaseValueObjectInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleReportDetail.tpl';

    var $valueObject;

    private $isCurrentAssessmentCycle;
    private $currentTitle;
    private $showCyclePrefix;

    private $prefixClass;

    static function createWithValueObject(  AssessmentCycleValueObject $valueObject,
                                            $displayWidth = '')
    {
        return new AssessmentCycleReportDetail( $valueObject,
                                                $displayWidth,
                                                self::TEMPLATE_FILE);
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowCyclePrefix($showCyclePrefix)
    {
        $this->showCyclePrefix = $showCyclePrefix;
    }

    function showCyclePrefix()
    {
        return $this->showCyclePrefix;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPrefixClass($prefixClass)
    {
        $this->prefixClass = $prefixClass;
    }

    function getPrefixClass()
    {
        return $this->prefixClass;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setCurrentTitle($currentTitle)
    {
        $this->currentTitle = $currentTitle;
    }

    function getCurrentTitle()
    {
        return $this->currentTitle;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setIsCurrentAssessmentCycle($isCurrentAssessmentCycle)
    {
        $this->isCurrentAssessmentCycle = $isCurrentAssessmentCycle;
    }

    function isCurrentAssessmentCycle()
    {
        return $this->isCurrentAssessmentCycle;
    }

}

?>
