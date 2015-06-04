<?php

/**
 * Description of EmployeeFilterInterfaceBuilder
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/list/EmployeeFilterInterfaceBuilderComponents.class.php');

// service
require_once('modules/model/service/list/EmployeeFilterService.class.php');
require_once('modules/model/service/organisation/DepartmentService.class.php');
require_once('modules/model/service/library/FunctionService.class.php');

// value
require_once('modules/interface/interfaceobjects/list/EmployeeFilterView.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeFilterAction.class.php');
require_once('modules/interface/interfaceobjects/list/EmployeeFilterDetail.class.php');

// converter
require_once('modules/interface/converter/list/EmployeeAssessmentFilterConverter.class.php');
require_once('modules/interface/converter/list/EmployeeSortFilterConverter.class.php');

class EmployeeFilterInterfaceBuilder
{

    const FILTER_ACTION_HTML_ID = 'filter_action';
    const FILTER_DETAIL_HTML_ID = 'filter_detail';

    const FILTER_FORM_ID        = 'employee_list_filter';
    const FILTER_SAFEFORM_ID    = SAFEFORM_EMPLOYEE__LIST_FILTER;


    static function getViewHtml($displayWidth, $listWidth)
    {
        $viewHtml = '';


        $showAssessmentFilter = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER);
        $showBossFilter       = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_BOSS_FILTER);
        $showDepartmentFilter = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_DEPARTMENT_FILTER);
        $showFunctionFilter   = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_FUNCTION_FILTER);
        $showSortFilter       = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER) ||
                                PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE);

        $showFilters        = EmployeeFilterService::getShowFilterPermission();
        $showSearch         = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_SEARCH);
        $isFiltersVisible   = EmployeeFilterService::retrieveIsFiltersVisible();

        // safeform
        $safeFilterHandler = SafeFilterHandler::create(self::FILTER_SAFEFORM_ID);
        $safeFilterHandler->storeSafeValue('showSearch', $showSearch);
        $safeFilterHandler->storeSafeValue('showAssessmentFilter', $showAssessmentFilter);
        $safeFilterHandler->storeSafeValue('showBossFilter', $showBossFilter);
        $safeFilterHandler->storeSafeValue('showDepartmentFilter', $showDepartmentFilter);
        $safeFilterHandler->storeSafeValue('showFunctionFilter', $showFunctionFilter);
        $safeFilterHandler->storeSafeValue('showSortFilter', $showSortFilter);

        $safeFilterHandler->addStringInputFormatType ('filter_boss');
        $safeFilterHandler->addStringInputFormatType ('filter_department');
        $safeFilterHandler->addStringInputFormatType ('filter_function');
        $safeFilterHandler->addIntegerInputFormatType('filter_assessment');
        $safeFilterHandler->addIntegerInputFormatType('filter_sort');
        $safeFilterHandler->addStringInputFormatType ('search_employee');


        $safeFilterHandler->finalizeDataDefinition();

        // interface
        $formId = self::FILTER_FORM_ID;
        $interfaceObject = EmployeeFilterView::create(  $formId,
                                                        $safeFilterHandler->getFormIdentifier(),
                                                        $displayWidth);
        $interfaceObject->setEmployeeSearchValue(   EmployeeFilterService::retrieveEmployeeSearch());
        $interfaceObject->setShowSearch(            $showSearch);
        $interfaceObject->setShowFilters(           $showFilters);
        $interfaceObject->setFilterActionHtml(      self::getFilterActionHtml($listWidth));
        $interfaceObject->setReplaceActionHtmlId(   self::FILTER_ACTION_HTML_ID);
        $interfaceObject->setFilterDetailHtml(      $isFiltersVisible ? self::getFilterDetailHtml($listWidth) : '');
        $interfaceObject->setReplaceFormHtmlId(     self::FILTER_DETAIL_HTML_ID);


        if ($showSearch || $showFilters) {
            // vullen template
            $contentHtml = $interfaceObject->fetchHtml();

            // in een safeform samenvoegen
            $viewHtml = ApplicationInterfaceBuilder::getFilterSafeFormHtml($formId, $safeFilterHandler, $contentHtml);
        }

        return $viewHtml;

    }

    static function getFilterActionHtml($displayWidth)
    {
        $filterActionHtml = '';

        $showFilters = EmployeeFilterService::getShowFilterPermission();
        if ($showFilters) {
            $hasActiveFilters   = EmployeeFilterService::hasActiveFilters();
            $isFiltersVisible   = EmployeeFilterService::retrieveIsFiltersVisible();
            $filterLabel        = $isFiltersVisible ? TXT_UCF('HIDE_FILTERS') : TXT_UCF('SHOW_FILTERS');
            $filterWarningLabel = $hasActiveFilters ? TXT_UCF('FILTERS_ACTIVE') . ' - ' : '';

            $interfaceObject = EmployeeFilterAction::create($displayWidth);
            $interfaceObject->setShowFilters(       $showFilters);
            $interfaceObject->setHasActiveFilters(  $hasActiveFilters);
            $interfaceObject->setIsFiltersVisible(  $isFiltersVisible);
            $interfaceObject->setFilterLabel(       $filterWarningLabel . $filterLabel );
            $interfaceObject->setFilterToggleLink(  EmployeeFilterInterfaceBuilderComponents::getToggleLink($isFiltersVisible));

            $filterActionHtml = $interfaceObject->fetchHtml();
        }
        return $filterActionHtml;
    }

    static function getFilterDetailHtml($displayWidth)
    {
        $contentHtml = '';
        $showAssessmentFilter = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER);
        $showBossFilter       = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_BOSS_FILTER);
        $showDepartmentFilter = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_DEPARTMENT_FILTER);
        $showFunctionFilter   = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_FUNCTION_FILTER);
        $showSortFilter       = PermissionsService::isViewAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER) ||
                                PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE);

        $interfaceObject = EmployeeFilterDetail::create(self::FILTER_FORM_ID, self::FILTER_SAFEFORM_ID, $displayWidth);
        $interfaceObject->setShowAssessmentFilter(  $showAssessmentFilter);
        $interfaceObject->setShowBossFilter(        $showBossFilter);
        $interfaceObject->setShowDepartmentFilter(  $showDepartmentFilter);
        $interfaceObject->setShowFunctionFilter(    $showFunctionFilter);
        $interfaceObject->setShowSortFilter(        $showSortFilter);

        $isFiltersVisible = EmployeeFilterService::retrieveIsFiltersVisible();
        $interfaceObject->setIsFiltersVisible(  $isFiltersVisible);

        $interfaceObject->setSelectedAssessmentFilterValue( EmployeeFilterService::retrieveAssessmentFilter());
        $interfaceObject->setSelectedBossFilterValue(       EmployeeFilterService::retrieveBossFilter());
        $interfaceObject->setSelectedDepartmentFilterValue( EmployeeFilterService::retrieveDepartmentFilter());
        $interfaceObject->setSelectedFunctionFilterValue(   EmployeeFilterService::retrieveFunctionFilter());
        $interfaceObject->setSelectedSortFilterValue(       EmployeeFilterService::retrieveSortFilter());
        if ($showBossFilter) {
            $interfaceObject->setBossFilterIdValues(EmployeeFilterService::getBossFilterIdValues());
        }
        if ($showDepartmentFilter) {
            $interfaceObject->setDepartmentFilterIdValues(DepartmentService::getDepartmentIdValues());
        }
        if ($showFunctionFilter) {
            $interfaceObject->setFunctionFilterIdValues(FunctionService::getFunctionIdValues());
        }

        if ($interfaceObject->showFilters()) {
            // vullen template
            $contentHtml = $interfaceObject->fetchHtml();
        }

        return $contentHtml;
    }

}

?>
