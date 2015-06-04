<?php

/**
 * Description of EmployeeFilterView
 *
 * @author ben.dokter
 */
require_once('modules/interface/interfaceobjects/base/BaseInterfaceObject.class.php');

class EmployeeFilterView extends BaseInterfaceObject
{
    const TEMPLATE_FILE = 'list/employeeFilterView.tpl';

    private $showSearch;
    private $showFilters;

    private $filterActionHtml;
    private $replaceActionHtmlId;

    private $filtersSafeFormHtml;
    private $replaceSafeFormHtmlId;

    private $employeeSearchValue;

    ///////////////////////////////////////////////////////
    // hack om de actie te triggeren, zie submitFunction
    private $formId;
    private $safeFormIdentifier;


    static function create( $formId,
                            $safeFormIdentifier,
                            $displayWidth)
    {
        return new EmployeeFilterView(  $formId,
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
        $this->showSearch = false;
        $this->showFilters = false;
    }

    // TODO: anders (form.submit??)
    function submitFunction()
    {
        return 'submitFilterSafeForm(\''. $this->safeFormIdentifier . '\', \'' . $this->formId . '\');return false';
        //return 'document.' . $this->formId . '.submit();return false;';
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $showSearch
    function setShowSearch($showSearch)
    {
        $this->showSearch = $showSearch;
    }

    function showSearch()
    {
        return $this->showSearch;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $employeeSearchValue
    function setEmployeeSearchValue($employeeSearchValue)
    {
        $this->employeeSearchValue = $employeeSearchValue;
    }

    function getEmployeeSearchValue()
    {
        return $this->employeeSearchValue;
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
    // $filterActionHtml
    function setFilterActionHtml($filterActionHtml)
    {
        $this->filterActionHtml = $filterActionHtml;
    }

    function getFilterActionHtml()
    {
        return $this->filterActionHtml;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $replaceActionHtmlId
    function setReplaceActionHtmlId($replaceActionHtmlId)
    {
        $this->replaceActionHtmlId = $replaceActionHtmlId;
    }

    function getReplaceActionHtmlId()
    {
        return $this->replaceActionHtmlId;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $filtersSafeFormHtml
    function setFilterDetailHtml($filterDetailHtml)
    {
        $this->filtersSafeFormHtml = $filterDetailHtml;
    }

    function getFilterDetailHtml()
    {
        return $this->filtersSafeFormHtml;
    }

    //////////////////////////////////////////////////////////////////////////////////////////////////////////
    // $filtersSafeFormHtml
    function setReplaceFormHtmlId($replaceSafeFormHtmlId)
    {
        $this->replaceSafeFormHtmlId = $replaceSafeFormHtmlId;
    }

    function getReplaceFormHtmlId()
    {
        return $this->replaceSafeFormHtmlId;
    }



}

?>
