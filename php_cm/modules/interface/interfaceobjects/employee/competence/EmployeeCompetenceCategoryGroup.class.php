<?php

/**
 * Description of EmployeeCompetenceCategoryGroup
 *
 * @author ben.dokter
 */

require_once('modules/interface/interfaceobjects/base/BaseGroupInterfaceObject.class.php');

class EmployeeCompetenceCategoryGroup extends BaseGroupInterfaceObject
{
    const TEMPLATE_FILE = 'employee/competence/employeeCompetenceCategoryGroup.tpl';

    // display data
    private $categoryName;

    private $showCategory;
    private $show360;
    private $showNorm;
    private $showWeight;
    private $showPdpActions;
    private $showAnyRemarks;

    private $currentPeriodName;
    private $previousPeriodName;

    private $currentPeriodIconView;
    private $previousPeriodIconView;

    private $currentPeriodEmployeeIconView;
    private $previousPeriodEmployeeIconView;



    static function create( $displayWidth,
                            $categoryName)
    {
        return new EmployeeCompetenceCategoryGroup( $displayWidth,
                                                    $categoryName);
    }

    protected function __construct( $displayWidth,
                                    $categoryName)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);

        $this->categoryName = $categoryName;
    }

    function addInterfaceObject(EmployeeCompetenceClusterGroup $interfaceObject)
    {
        parent::addInterfaceObject($interfaceObject);
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function getCategoryName()
    {
        return $this->categoryName;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowCategory($showCategory)
    {
        $this->showCategory = $showCategory;
    }

    function showCategory()
    {
        return $this->showCategory;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowAnyRemarks($showAnyRemarks)
    {
        $this->showAnyRemarks = $showAnyRemarks;
    }

    function showAnyRemarks()
    {
        return $this->showAnyRemarks;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShow360($show360)
    {
        $this->show360 = $show360;
    }

    function show360()
    {
        return $this->show360;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowNorm($showNorm)
    {
        $this->showNorm = $showNorm;
    }

    function showNorm()
    {
        return $this->showNorm;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowWeight($showWeight)
    {
        $this->showWeight = $showWeight;
    }

    function showWeight()
    {
        return $this->showWeight;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setShowPdpActions($showPdpActions)
    {
        $this->showPdpActions = $showPdpActions;
    }

    function showPdpActions()
    {
        return $this->showPdpActions;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $periodIconView
    function setPeriodIconViews(AssessmentIconView $currentPeriodIconView,
                                AssessmentIconView $previousPeriodIconView)
    {
        $this->currentPeriodIconView    = $currentPeriodIconView;
        $this->previousPeriodIconView   = $previousPeriodIconView;
    }

    function getCurrentPeriodIconView()
    {
        return $this->currentPeriodIconView;
    }

    function getPreviousPeriodIconView()
    {
        return $this->previousPeriodIconView;
    }

    /////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $periodEmployeeIconView
    function setPeriodEmployeeIconViews(AssessmentIconView $currentPeriodEmployeeIconView,
                                        AssessmentIconView $previousPeriodEmployeeIconView)
    {
        $this->currentPeriodEmployeeIconView = $currentPeriodEmployeeIconView;
        $this->previousPeriodEmployeeIconView = $previousPeriodEmployeeIconView;
    }

    function getCurrentPeriodEmployeeIconView()
    {
        return $this->currentPeriodEmployeeIconView;
    }

    function getPreviousPeriodEmployeeIconView()
    {
        return $this->previousPeriodEmployeeIconView;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    function setPeriodNames($currentPeriodName,
                            $previousPeriodName)
    {
        $this->currentPeriodName    = $currentPeriodName;
        $this->previousPeriodName   = $previousPeriodName;
    }

    function getCurrentPeriodName()
    {
        return $this->currentPeriodName;
    }

    function getPreviousPeriodName()
    {
        return  $this->previousPeriodName;
    }

}

?>
