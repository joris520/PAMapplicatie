<?php

/**
 * Description of EmployeeFilterInterfaceProcessor
 *
 * @author ben.dokter
 */

require_once('modules/interface/builder/list/EmployeeListInterfaceBuilder.class.php');

class EmployeeFilterInterfaceProcessor
{

    const FILTER_WIDTH = EmployeeListInterfaceProcessor::LIST_WIDTH;

    // na een wijziging in het filter de employee lijst verversen
    static function finishProcessAction($objResponse)
    {
        self::refreshFilter($objResponse);
        EmployeeListInterfaceProcessor::refreshEmployeeList($objResponse);


    }

    static function toggleFilterVisibility($objResponse)
    {
        // togglen
        EmployeeFilterService::toggleIsFiltersVisible();
        self::refreshFilter($objResponse);
    }

    static function refreshFilter($objResponse)
    {
        $isFiltersVisible = EmployeeFilterService::retrieveIsFiltersVisible();
        // de filterToggle pijl en tekst aanpassen
        InterfaceXajax::setHtml($objResponse,
                                EmployeeFilterInterfaceBuilder::FILTER_ACTION_HTML_ID,
                                EmployeeFilterInterfaceBuilder::getFilterActionHtml(self::FILTER_WIDTH));

        if ($isFiltersVisible) {
            // de filters zijn niet zichtbaar, dus openklappen

            // en de filters toevoegen en infaden
            InterfaceXajax::setHtml($objResponse,
                                    EmployeeFilterInterfaceBuilder::FILTER_DETAIL_HTML_ID,
                                    EmployeeFilterInterfaceBuilder::getFilterDetailHtml(self::FILTER_WIDTH));

            InterfaceXajax::fadeInDetail(   $objResponse,
                                            EmployeeFilterInterfaceBuilder::FILTER_DETAIL_HTML_ID);
        } else {
            // de filters worden getoont, dus inklappen en weghalen
            InterfaceXajax::fadeOutDetailAndClearContent(   $objResponse,
                                                            EmployeeFilterInterfaceBuilder::FILTER_DETAIL_HTML_ID,
                                                            EmployeeFilterInterfaceBuilder::FILTER_DETAIL_HTML_ID);

        }
    }

}

?>
