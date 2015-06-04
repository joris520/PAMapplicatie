<?php

/**
 * Description of EmployeeFilterAction
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeFilterAction extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeFilterAction.tpl';

    private $showFilters = false;
    private $isFiltersVisible = false;
    private $hasActiveFilters = false;
    private $filterLabel;
    private $filterToggleLink;

    static function create($displayWidth)
    {
        return new EmployeeFilterAction($displayWidth,
                                        self::TEMPLATE_FILE);
    }

    function warnActiveFilters()
    {
        return $this->hasActiveFilters &&
               !$this->isFiltersVisible;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $showFilters
    function setShowFilters($showFilters)
    {
        $this->showFilters = $showFilters;
    }

    function showFilters()
    {
        return $this->showFilters;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $showFilters
    function setIsFiltersVisible($isFiltersVisible)
    {
        $this->isFiltersVisible = $isFiltersVisible;
    }

    function isFiltersVisible()
    {
        return $this->isFiltersVisible;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $hasActiveFilters
    function setHasActiveFilters($hasActiveFilters)
    {
        $this->hasActiveFilters = $hasActiveFilters;
    }

    function hasActiveFilters()
    {
        return $this->hasActiveFilters;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $filterLabel
    function setFilterLabel($filterLabel)
    {
        $this->filterLabel = $filterLabel;
    }

    function getFilterLabel()
    {
        return $this->filterLabel;
    }


    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $filterToggleLink
    function setFilterToggleLink($filterToggleLink)
    {
        $this->filterToggleLink = $filterToggleLink;
    }

    function getFilterToggleLink()
    {
        return $this->filterToggleLink;
    }


}

?>
