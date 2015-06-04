<?php

/**
 * Description of EmployeesTabInterfaceProcessor
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/tab/EmployeesTabPageBuilder.class.php');

class EmployeesTabInterfaceProcessor
{
    const LEFT_WIDTH = 300;
    const LIST_WIDTH = EmployeeListInterfaceProcessor::LIST_WIDTH;

    static function displayViewPage(xajaxResponse $objResponse)
    {
        if (PermissionsService::isViewAllowed(PERMISSION_MODULE_EMPLOYEES)) {

            ApplicationNavigationService::setCurrentApplicationModule(MODULE_EMPLOYEES);

            // assessment cycles ophalen
            $currentAssessmentCycle  = AssessmentCycleService::getCurrentValueObject();

            // pagina opbouw
            $viewHtml = EmployeesTabPageBuilder::getPageHtml(   self::LEFT_WIDTH,
                                                                self::LIST_WIDTH,
                                                                $currentAssessmentCycle);
            InterfaceXajax::setHtml($objResponse,
                                    'module_main_panel',
                                    $viewHtml);

            // menu opbouw
            ApplicationNavigationProcessor::activateModuleMenu($objResponse, MODULE_EMPLOYEES);
//            InterfaceXajax::setHtml($objResponse,
//                                    'modules_menu_panel',
//                                    ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_EMPLOYEES));

            // als er al een medewerker gekozen is dan hiervan de gegevens tonen
            // TODO: refactor zonder call
            if (ApplicationNavigationService::hasSelectedEmployeeId()) {
                $objResponse->call('xajax_moduleEmployees_checkTab_deprecated', ApplicationNavigationService::retrieveSelectedEmployeeId());
            }

        }
    }

    static function displayMenu(xajaxResponse $objResponse,
                                $employeeId,
                                $employeeModule)
    {
        ApplicationNavigationService::storeLastModuleFunction($employeeModule);

        // employee tab menu opbouw
        $employeeTabMenu = '';
        if (!empty($employeeId)) {
            $employeeTabMenu = ApplicationNavigationInterfaceBuilder::buildEmployeesMenu(   $employeeId,
                                                                                            $employeeModule);
            InterfaceXajax::setHtml($objResponse,
                                    'modules_menu_panel',
                                    $employeeTabMenu);
            InterfaceXajax::setHtml($objResponse,
                                    'tabNav',
                                    '');
        }

        // voor nu toch altijd leeg...
        InterfaceXajax::setHtml($objResponse,
                                EMPLOYEE_TAB_NAV_TOP,
                                '');
    }


    static function displayContent( xajaxResponse $objResponse,
                                    $contentHtml)
    {
        InterfaceXajax::setHtml($objResponse,
                                EMPLOYEE_CONTENT,
                                $contentHtml);
    }

}

?>