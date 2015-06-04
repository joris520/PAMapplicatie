<?php

/**
 * Description of EmployeeFilterInterfaceBuilderComponents
 *
 * @author ben.dokter
 */

class EmployeeFilterInterfaceBuilderComponents
{
    static function getToggleLink($isFiltersVisible)
    {
        $html = '';
        if (EmployeeFilterService::getShowFilterPermission()) {
            $html .= InterfaceBuilder::iconLink('toggle_filter_visibility',
                                                $isFiltersVisible ? TXT_LC('HIDE_FILTERS') : TXT_UCF('SHOW_FILTERS'),
                                                'xajax_public_employeeList__toggleFilterVisibility();',
                                                $isFiltersVisible ? ICON_UP : ICON_DOWN);
        }
        return $html;
    }
}

?>
