<?php

/**
 * Description of EmployeesTabInterfaceBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/tab/EmployeesTabInterfaceBuilderComponents.class.php');
require_once('modules/interface/builder/list/EmployeeListPageBuilder.class.php');
require_once('modules/interface/interfaceobjects/employee/EmployeeTabView.class.php');


class EmployeesTabInterfaceBuilder
{

    static function getViewHtml($leftWidth,
                                $listWidth,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        // template interfaceObject
        $interfaceObject = EmployeeTabView::create($leftWidth);

        $interfaceObject->setEmployeeListHtml(  EmployeeListPageBuilder::getPageHtml(   $leftWidth,
                                                                                        $listWidth,
                                                                                        $assessmentCycle));

        if (CUSTOMER_OPTION_BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD && EmployeeFilterService::hasActiveBossFilter()) {
            $interfaceObject->setWelcomeMessage(    EmployeeListInterfaceProcessor::getWelcomeMessage($assessmentCycle));
        } else {
            $interfaceObject->setWelcomeMessage(    EmployeesTabInterfaceBuilderComponents::getWelcomeMessage());
        }

        return $interfaceObject->fetchHtml();
    }




}

?>
