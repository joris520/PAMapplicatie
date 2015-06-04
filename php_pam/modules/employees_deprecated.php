<?php

require_once('gino/NumberUtils.class.php');
require_once('modules/model/service/to_refactor/PdpActionSkillServiceDeprecated.class.php');
require_once('modules/model/queries/to_refactor/EmployeeScoresQueries.class.php');
require_once('modules/model/queries/to_refactor/EmployeesQueries.class.php');
require_once('modules/interface/components/select/SelectEmployees.class.php');
require_once('modules/model/service/upload/PhotoContent.class.php');
require_once('application/model/service/UserLoginService.class.php');
require_once('modules/common/moduleConsts.inc.php');
require_once('application/interface/InterfaceBuilder.class.php');

//DISPLAY PROFILE SUB MODDULES
include_once('employees_profile_deprecated.php');
//DISPLAY ATTACHMENTS SUB MODDULES
include_once('employees_attachments_deprecated.php');
//DISPLAY PDP ACTIONS SUB MODDULES
include_once('employees_pdpactions_deprecated.php');

// de nieuwe aanpak (moduleEmployeesNew)
require_once('modules/public/employee/employeeTab_xajax.php');

require_once('modules/model/service/list/EmployeeFilterService.class.php');
require_once('modules/model/service/employee/EmployeeSelectService.class.php');

/**
 * Startpagina (pagina employees)
 * @return xajaxResponse
 */

function moduleEmployees_startup()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse)) {
        EmployeesTabInterfaceProcessor::displayViewPage($objResponse);
    }
    return $objResponse;
}



// keep
function moduleEmployees_attachments_menu_deprecated($employee_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) {
        ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_ATTACHMENTS);
        showSelectedEmp_direct_deprecated($objResponse, $employee_id);
    }
    return $objResponse;
}

// keep
function  moduleEmployees_pdpActions_menu_deprecated($employee_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PDP_ACTIONS)) {
        ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_PDP_ACTIONS);
        showSelectedEmp_direct_deprecated($objResponse, $employee_id);
    }
    return $objResponse;
}

// keep
function moduleEmployees_360_menu_deprecated($employee_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_360)) {
        ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_360);
        showSelectedEmp_direct_deprecated($objResponse, $employee_id);
    }
    return $objResponse;
}

// keep
function moduleEmployees_history_menu_deprecated($employee_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_HISTORY)) {
        ApplicationNavigationService::storeLastModuleFunction(MODULE_EMPLOYEE_HISTORY);
        showSelectedEmp_direct_deprecated($objResponse, $employee_id);
    }
    return $objResponse;
}

// keep
function deselect_employee_in_menu_deprecated($objResponse, $employee_deselect)
{
    $objResponse->assign('rowLeftNav' . $employee_deselect, 'className',  'divLeftRow');
    $objResponse->assign('top_nav_emp', 'innerHTML',  '');
}

// keep
function moduleEmployees_checkTab_deprecated($id_e)
{
    return moduleEmployees_showSelectedEmp_deprecated($id_e, 1);
}

// keep
function moduleEmployees_showSelectedEmp_deprecated($id_e, $doLastModuleFunction)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) /*&& PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)*/) {
        showSelectedEmp_direct_deprecated($objResponse, $id_e, $doLastModuleFunction);
    }
    return $objResponse;
}

// keep
function showSelectedEmp_direct_deprecated($objResponse, $id_e, $doLastModuleFunction = 1)
{
    if (EmployeeSelectService::isAllowedEmployeeId($id_e)) {
        // bijhouden in sessie
        ApplicationNavigationService::storeSelectedEmployeeId($id_e);
        // naam ophalen
        $sql = 'SELECT
                    firstname,
                    lastname
                FROM
                    employees
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_E = ' . $id_e;
        $get_emp_query = BaseQueries::performQuery($sql);

        $get_emp = @mysql_fetch_assoc($get_emp_query);
        $_SESSION['employee_display_name'] = ModuleUtils::EmployeeName($get_emp['firstname'], $get_emp['lastname']);

        if ($doLastModuleFunction == 1) {
            if (!ApplicationNavigationService::hasLastModuleFunction()) {
                ApplicationNavigationService::storeLastModuleFunction(ApplicationNavigationService::getFirstAllowedModuleFunction(MODULE_EMPLOYEES));
            }
            ApplicationNavigationProcessor::process_callModuleEmployee($objResponse, ApplicationNavigationService::retrieveLastModuleFunction(), $id_e);
        }

//        if (ApplicationNavigationService::retrieveLastModuleFunction() != MODULE_EMPLOYEE_PROFILE) {
//            $displayName = $_SESSION['employee_display_name'];
//        }
        $objResponse->assign('top_nav_emp', 'innerHTML', '<br/>');//<h1>' .  $_SESSION['employee_display_name'] . '</h1>');

        $objResponse->assign('linkempname' . $id_e , 'innerHTML', $_SESSION['employee_display_name']);
    } else {
        $objResponse->assign('top_nav_emp', 'innerHTML',  '<h1>' . TXT_UCF('NO_ACCESS') . '</h1>');
        $objResponse->assign('empPrint', 'innerHTML',  '');

    }
}

?>