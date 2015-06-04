<?php

/**
 * Description of AssessmentCycleInfoDetail
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class AssessmentCycleInfoDetail extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'library/assessmentCycleInfoDetail.tpl';

    var $valueObject;
    var $previousValueObject;

    private $currentTitle;
    private $previousTitle;
    private $currentHoverIcon;
    private $previousHoverIcon;
    private $showPreviousCycle;
    private $showCyclePrefix;

    static function createWithValueObjects( AssessmentCycleValueObject $valueObject,
                                            AssessmentCycleValueObject $previousValueObject = NULL,
                                            $displayWidth = '')
    {
        return new AssessmentCycleInfoDetail(   $valueObject,
                                                $previousValueObject,
                                                $displayWidth);
    }

    function __construct(   AssessmentCycleValueObject $valueObject,
                            AssessmentCycleValueObject $previousValueObject = NULL,
                            $displayWidth = '')
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->valueObject          = $valueObject;
        $this->previousValueObject  = $previousValueObject;
        $this->showPreviousCycle    = !empty($previousValueObject);
    }

    function getValueObject()
    {
        return $this->valueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getPreviousValueObject()
    {
        return $this->previousValueObject;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowPreviousCycle($showPreviousCycle)
    {
        if (!empty($this->previousValueObject)) {
            $this->showPreviousCycle = $showPreviousCycle;
        }
    }

    function showPreviousCycle()
    {
        return $this->showPreviousCycle;
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
    function setCurrentHoverIcon($currentHoverIcon)
    {
        $this->currentHoverIcon = $currentHoverIcon;
    }

    function getCurrentHoverIcon()
    {
        return $this->currentHoverIcon;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPreviousHoverIcon($previousHoverIcon)
    {
        $this->previousHoverIcon = $previousHoverIcon;
    }

    function getPreviousHoverIcon()
    {
        return $this->previousHoverIcon;
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
    function setPreviousTitle($previousTitle)
    {
        $this->previousTitle = $previousTitle;
    }

    function getPreviousTitle()
    {
        return $this->previousTitle;
    }
}

?>
