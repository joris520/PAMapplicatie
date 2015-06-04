<?php

/**
 * Description of EmployeesTabPageBuilder
 *
 * @author ben.dokter
 */
require_once('modules/interface/builder/tab/EmployeesTabInterfaceBuilder.class.php');

class EmployeesTabPageBuilder
{
    // het opbouwen van het medewerkers tab (nu: linkerkant lijst met medewerkers, rechterkant inhoud gekozen medewerker)

    // hier wel (linkerkant) de EmployeeList invullen
    //
    // het vullen van de rechterkant is de taak van de InterfaceProcessor...

    static function getPageHtml($leftWidth,
                                $listWidth,
                                AssessmentCycleValueObject $assessmentCycle)
    {
        return EmployeesTabInterfaceBuilder::getViewHtml($leftWidth, $listWidth, $assessmentCycle);
    }


//function moduleEmployeesDeprecated_init()
//{
//    $objResponse = new xajaxResponse();
//
//    if (PamApplication::hasValidSession($objResponse) /*&& PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PROFILE)*/) {
//
//        unset($_SESSION['s_employee']);
//        // default op evaluatie status
//        if (empty($_SESSION['s_employee_filters'])) {
//            if (PermissionsService::isAccessAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER)) {
//                $_SESSION['s_employee_filters'] = FILTER_EMPLOYEES_ASSESSMENT_STATE;
//            } else {
//                $_SESSION['s_employee_filters'] = FILTER_EMPLOYEES_ALPHABETICAL;
//            }
//        }
//
//        ApplicationNavigationService::setCurrentApplicationModule(MODULE_EMPLOYEES);
//
//
//        if (/*USER_LEVEL >= 1 && USER_LEVEL <= 3 && */PermissionsService::isEditAllowed(PERMISSION_EMPLOYEE_PROFILE)) {
//            if (APPLICATION_ICON_MODE) {
//                $add_employee_btn_search = InterfaceBuilder::IconButton('btn_add_employee',
//                                                                        TXT_BTN('ADD_NEW_EMPLOYEE'),
//                                                                        'xajax_moduleEmployees_addEmployee_deprecated();',
//                                                                        ICON_ADD);
//                $add_employee_btn = '&nbsp;';
//            } else {
//                $add_employee_btn = InterfaceBuilder::IconButton('btn_add_employee',
//                                                                TXT_UCW('ADD_NEW_EMPLOYEE'),
//                                                                'xajax_moduleEmployees_addEmployee_deprecated();',
//                                                                NO_ICON,
//                                                                'btn_width_150');
//                $add_employee_btn_search = '&nbsp;';
//            }
//        } else {
//            $add_employee_btn = '';
//        }
//        ApplicationNavigationService::initializeSelectedEmployeeId(ApplicationNavigationService::KEEP_SELECTED);
//
//        $getemp_data .= '
//        <div id="mode_employees">
//            <table border="0" cellspacing="0" cellpadding="0" width="100%">
//                <tr>
//                    <td class="left_panel" width="20%">
//                        <div id="search_e" class="search">';
//                        if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEES_SEARCH) ||
//                            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER) ||
//                            PermissionsService::isEditAllowed(PERMISSION_EMPLOYEES_USE_BOSS_FILTER)) {
////                        if (USER_LEVEL >= 1 && USER_LEVEL <= 3) {
//                            $getemp_data .= '
//                            <form name="srcForme" id="srcForme" method="post" action="javascript:void(0);">
//                                <table border="0" cellspacing="0" cellpadding="0" width="100%">';
//                                if (PERMISSION_EMPLOYEES_SEARCH <> 0) {
//                                    $getemp_data .= '
//                                        <tr>
//                                            <td width="80%">
//                                                <strong>' . TXT_UCF('SEARCH_EMPLOYEE') . ':</strong>
//                                                <input type="text" name="s_employee" name="s_employee" size="20" maxlength="250" onkeyup="xajax_moduleEmployees_searchE_deprecated(xajax.getFormValues(\'srcForme\')); return false;">
//                                            </td>
//                                            <td style="text-align:right">' . $add_employee_btn_search . '</td>
//                                        </tr>';
//                                }
//                                if (PermissionsService::isEditAllowed(PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER) ||
//                                    PermissionsService::isEditAllowed(PERMISSION_EMPLOYEES_USE_BOSS_FILTER)) {
//                                    $getemp_data .= getEmployeesFilterHtml( EmployeeFilterService::retrieveEmployeeFilter(),
//                                                                            EmployeeFilterService::retrieveBossFilter());
//                                }
//
//                                $getemp_data .='
//                                </table>
//                            </form>';
//                        }
//                        $getemp_data .= '
//                        </div><!-- search_e -->';
//
//                        $getemp_data .= '
//                        <div id="searchEmployeesResult">';
//                        $getemp_data .= getFilteredEmployeesHtml(); //filterEmployees_deprecated();
//                        $getemp_data .= '
//                        </div><!-- searchEmployeesResult -->
//                    </td>
//                    <td class="right_panel" width="80%">
//                        <div class="top_nav" >' . $add_employee_btn . '</div>
//                        <div id="tabNav"></div>';
//
//                        $label = ApplicationNavigationService::hasSelectedEmployeeId() ? TXT_UCF('LOADING_PLEASE_WAIT') : TXT_UCF('SELECT_EMPLOYEES');
//
//                        $getemp_data .= '
//                        <div class="top_nav" id="top_nav" style="margin:0px; padding:6px 0 0 0;">
//                            <table border="0" cellspacing="0" cellpadding="0" width="100%">
//                                <tr>
//                                    <td id="top_nav_emp" style="vertical-align: middle; text-align: left;">&nbsp;</td>
//                                    <td id="top_nav_btn" style="vertical-align: middle; text-align: right;">&nbsp;</td>
//                                </tr>
//                            </table>
//                        </div>
//                        <div id="empPrint">&nbsp; &nbsp;' . $label . '</div>
//                    </td>
//                </tr>
//            </table>
//        <div><!-- mode_employees -->';
//
//        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_EMPLOYEES));
//        $objResponse->assign('module_main_panel', 'innerHTML', $getemp_data);
//
//        $objResponse->call('setScroll', $_COOKIE['scrollpos']);
//        if (ApplicationNavigationService::hasSelectedEmployeeId()) {
//            $objResponse->call('xajax_moduleEmployees_checkTab_deprecated', ApplicationNavigationService::retrieveSelectedEmployeeId());
//        }
//    }
//    return $objResponse;
//}

}

?>
