<?php

require_once('modules/common/moduleUtils.class.php');
require_once('application/interface/ApplicationNavigationConsts.inc.php');
require_once('application/interface/builder/ApplicationNavigationInterfaceBuilder.class.php');
require_once('application/model/service/ApplicationNavigationService.class.php');


class ApplicationNavigationProcessor
{

    static function activateApplicationMenu($objResponse,
                                            $applicationMenuItem)
    {
        ApplicationNavigationService::setCurrentApplicationMenu($applicationMenuItem);
        $objResponse->assign('application_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildApplicationMenu($applicationMenuItem));
        $default_module = ApplicationNavigationService::getFirstAllowedModuleInApplicationMenu();
        $module_call = ApplicationNavigationService::getModulePublicCall($default_module);


        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // handig stukje debug code:
        //die('activateApplicationMenu:'.$applicationMenuItem.'-'.$default_module.'='.$module_call);
        //////////////////////////////////////////////////////////////////////////////////////////////////////

        if (!empty($module_call)) {
            $objResponse->call($module_call);
        }

    }

    static function activateModuleMenu( $objResponse,
                                        $moduleItem)
    {
        // generieke module menu opbouw
        ApplicationNavigationService::setCurrentApplicationModule($moduleItem);
        InterfaceXajax::setHtml($objResponse, 'modules_menu_panel', ApplicationNavigationInterfaceBuilder::buildMenuForModule($moduleItem));
    }


    static function process_callModuleEmployee($objResponse, $requestedModule, $employeeId)
    {
        switch ($requestedModule) {
            case MODULE_EMPLOYEE_PROFILE:
                EmployeeProfileInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_ATTACHMENTS:
                EmployeeDocumentInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_SCORE:
                EmployeeCompetenceInterfaceProcessor::displayView($objResponse, $employeeId, NULL);
                break;
            case MODULE_EMPLOYEE_PDP_ACTIONS:
                EmployeePdpActionInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_TARGETS:
                EmployeeTargetInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_FINAL_RESULTS:
                EmployeeFinalResultInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_TRAINING:
                EmployeeTrainingInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_INVITATIONS:
                EmployeeAssessmentInvitationReportInterfaceProcessor::displayView($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_360:
                moduleEmployees_360_direct($objResponse, $employeeId);
                break;
            case MODULE_EMPLOYEE_HISTORY:
                moduleEmployees_history_direct($objResponse, $employeeId);
                break;
            default:
                moduleEmployees_no_rights($objResponse);
        }
    }

    static function process_callModule($objResponse, $requestedModule)
    {
        switch ($requestedModule) {
            case MODULE_PDP_ACTION_LIB:
                modulePDPActionLibrary_direct($objResponse);
                break;
            case MODULE_PDP_TASK_LIB:
                modulePDPTaskLibrary_direct($objResponse);
                break;
            case MODULE_PDP_TASK_OWNER:
                modulePDPTaskOwnerLibrary_direct($objResponse);
                break;
            case MODULE_360:
                module360_display360_direct($objResponse);
                break;
            case MODULE_EMAILS:
                externalEmailAddresses_direct($objResponse);
                break;
            default: // hack!
                $moduleCall = ApplicationNavigationService::getModulePublicCall($requestedModule);
                if (!empty($moduleCall)) {
                    $objResponse->call($moduleCall);
                }
        }
    }

}


?>