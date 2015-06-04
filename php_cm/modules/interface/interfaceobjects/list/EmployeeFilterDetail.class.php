<?php

/**
 * Description of EmployeeFilterDetail
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeFilterDetail extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeFilterDetail.tpl';

    private $showAssessmentFilter = false;
    private $showBossFilter = false;
    private $showDepartmentFilter = false;
    private $showFunctionFilter = false;
    private $showSortFilter = false;

    private $bossFilterIdValues;
    private $departmentFilterIdValues;
    private $functionFilterIdValues;

    private $selectedAssessmentFilterValue;
    private $selectedBossFilterValue;
    private $selectedDepartmentFilterValue;
    private $selectedFunctionFilterValue;
    private $selectedSortFilterValue;

    private $isFiltersVisible;

    ///////////////////////////////////////////////////////
    // hack om de actie te triggeren, zei submitFunction
    private $formId;
    private $safeFormIdentifier;


    static function create( $formId,
                            $safeFormIdentifier,
                            $displayWidth)
    {
        return new EmployeeFilterDetail($formId,
                                        $safeFormIdentifier,
                                        $displayWidth);
    }

    protected function __construct( $formId,
                                    $safeFormIdentifier,
                                    $displayWidth)
    {
        parent::__construct($displayWidth,
                            self::TEMPLATE_FILE);
        
        $this->formId = $formId;
        $this->safeFormIdentifier = $safeFormIdentifier;
        $this->showAssessmentFilter = false;
        $this->showSortFilter = false;

        $this->showBossFilter = false;
        $this->showDepartmentFilter = false;
        $this->showFunctionFilter = false;
        $this->isFiltersVisible = false;

        $this->bossFilterIdValues = array();
        $this->departmentFilterIdValues = array();
        $this->functionFilterIdValues = array();
    }

    // TODO: anders (form.submit??)
    function submitFunction()
    {
        return 'submitFilterSafeForm(\''. $this->safeFormIdentifier . '\', \'' . $this->formId . '\');return false';
        //return 'document.' . $this->formId . '.submit();return false;';
    }

    function showFilters()
    {
        return $this->showAssessmentFilter() ||
               $this->showSortFilter() ||
               $this->showBossFilter() ||
               $this->showDepartmentFilter() ||
               $this->showFunctionFilter();
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // search
    function setIsFiltersVisible($isFiltersVisible)
    {
        $this->isFiltersVisible = $isFiltersVisible;
    }

    function isFiltersVisible()
    {
        return $this->isFiltersVisible;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // assessment
    function setShowAssessmentFilter($showAssessmentFilter)
    {
        $this->showAssessmentFilter = $showAssessmentFilter;
    }

    function showAssessmentFilter()
    {
        return $this->showAssessmentFilter;
    }

    function setSelectedAssessmentFilterValue($selectedAssessmentFilterValue)
    {
        $this->selectedAssessmentFilterValue = $selectedAssessmentFilterValue;
    }

    function getSelectedAssessmentFilterValue()
    {
        return $this->selectedAssessmentFilterValue;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // sort
    function setShowSortFilter($showSortFilter)
    {
        $this->showSortFilter = $showSortFilter;
    }

    function showSortFilter()
    {
        return $this->showSortFilter;
    }

    function setSelectedSortFilterValue($selectedSortFilterValue)
    {
        $this->selectedSortFilterValue = $selectedSortFilterValue;
    }

    function getSelectedSortFilterValue()
    {
        return $this->selectedSortFilterValue;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // boss
    function setShowBossFilter($showBossFilter)
    {
        $this->showBossFilter = $showBossFilter;
    }

    function showBossFilter()
    {
        return $this->showBossFilter;
    }

    function setBossFilterIdValues($bossFilterIdValues)
    {
        $this->bossFilterIdValues = $bossFilterIdValues;
    }

    function getBossFilterIdValues()
    {
        return $this->bossFilterIdValues;
    }

    function setSelectedBossFilterValue($selectedBossFilterValue)
    {
        $this->selectedBossFilterValue = $selectedBossFilterValue;
    }

    function getSelectedBossFilterValue()
    {
        return $this->selectedBossFilterValue;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // department
    function setShowDepartmentFilter($showDepartmentFilter)
    {
        $this->showDepartmentFilter = $showDepartmentFilter;
    }

    function showDepartmentFilter()
    {
        return $this->showDepartmentFilter;
    }

    function setDepartmentFilterIdValues($departmentFilterIdValues)
    {
        $this->departmentFilterIdValues = $departmentFilterIdValues;
    }

    function getDepartmentFilterIdValues()
    {
        return $this->departmentFilterIdValues;
    }

    function setSelectedDepartmentFilterValue($selectedDepartmentFilterValue)
    {
        $this->selectedDepartmentFilterValue = $selectedDepartmentFilterValue;
    }

    function getSelectedDepartmentFilterValue()
    {
        return $this->selectedDepartmentFilterValue;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // function
    function setShowFunctionFilter($showFunctionFilter)
    {
        $this->showFunctionFilter = $showFunctionFilter;
    }

    function showFunctionFilter()
    {
        return $this->showFunctionFilter;
    }

    function setFunctionFilterIdValues($functionFilterIdValues)
    {
        $this->functionFilterIdValues = $functionFilterIdValues;
    }

    function getFunctionFilterIdValues()
    {
        return $this->functionFilterIdValues;
    }

    function setSelectedFunctionFilterValue($selectedFunctionFilterValue)
    {
        $this->selectedFunctionFilterValue = $selectedFunctionFilterValue;
    }

    function getSelectedFunctionFilterValue()
    {
        return $this->selectedFunctionFilterValue;
    }

}

?>
