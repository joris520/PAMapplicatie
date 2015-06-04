<?php

function moduleLevelAuthorisation_displayLevelAuthorization() {
    global $smarty;
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_LEVEL_AUTHORIZATION)) {
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_LEVEL_AUTHORIZATION);

        if (USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN) {
            $user_levels = array();
            $sql = 'SELECT
                        *
                    FROM
                        user_level
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        level_id';
            $queryResult = BaseQueries::performQuery($sql);
            while ($user_level = @mysql_fetch_assoc($queryResult)) {
                $user_level['level_name'] = UserLevelConverter::display($user_level['level_id']);
                $user_levels[] = $user_level;
            }
            $tpl = $smarty->createTemplate('to_refactor/mod_level_authorization/level_authorization.tpl');
            $tpl->assign('user_levels', $user_levels);

            $objResponse->assign('module_main_panel', 'innerHTML', $smarty->fetch($tpl));
        }

        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_LEVEL_AUTHORIZATION));
    }

    return $objResponse;
}

function moduleLevelAuth_displayAccess($level_id) {
    global $smarty;
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_LEVEL_AUTHORIZATION)) {

        $access_tabs_array = PermissionsService::GetAccessPriviliges($level_id, CUSTOMER_ID);

        $sql = 'SELECT
                    ma.*
                FROM
                    module_access ma
                WHERE
                    ma.is_active = ' . MODULE_ACCESS_SETTING_ACTIVE . '
                ORDER BY
                    category,
                    menu_label,
                    word_label';
        $queryResult_module_tabs = BaseQueries::performQuery($sql);

        $tabModuleCount = 0;
        $module_tabs_T = array(); // tabs/hoofdmenu
        $module_tabs_P1 = array(); // M
        $module_tabs_P2 = array(); // U
        $module_tabs_P3 = array(); // O
        while ($module_tab = @mysql_fetch_assoc($queryResult_module_tabs)) {
            // als de customer_option voor een permissie niet aan staat hoeft de permissie ook niet instelbaar te zijn, dus 'is_active' dan op 0 zetten
            switch ($module_tab['id']) {

                //case 14: // PERMISSION_PDP_TASK_LIBRARY: uitgezet in tabel module_access
                //case 15: // PERMISSION_PDP_TASK_OWNERS:  uitgezet in tabel module_access
                case 20: // PERMISSION_LEVEL_AUTHORIZATION hoeft niet uitgevraagt. De admin permissies worden in de PersmissionService aangezet
                    $module_tab['is_active'] = MODULE_ACCESS_SETTING_DISABLED;
                case 76: // PERMISSION_MENU_SELF_ASSESSMENT
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SELFASSESSMENT ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    $module_tab['menu_label'] = $module_tab['menu_label'];
                    break;
                case 40: // PERMISSION_BATCH_INVITE_SELF_ASSESSMENT
                case 62: // PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_INVITATIONS
                case 66: // PERMISSION_SELF_ASSESSMENTS_REPORT
                case 89: // PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_INVITATIONS
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SELFASSESSMENT ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 42: // PERMISSION_EMPLOYEE_FINAL_RESULT
                case 83: // PERMISSION_FINAL_RESULT_DASHBOARD
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_FINAL_RESULT ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 46: // PERMISSION_EMPLOYEE_TARGETS_EVALUATION_PERIOD_TARGET_DEPRECATED
                    $module_tab['is_active'] = MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 49: // PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_REMINDERS
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SELFASSESSMENT_REMINDERS ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 50: // PERMISSION_BATCH_INVITE_SELF_ASSESSMENT_SATISFACTION_LETTER
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SELFASSESSMENT_SATISFACTION_LETTER ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 51: // PERMISSION_EMPLOYEES_USE_BOSS_FILTER
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_FILTER_EMPLOYEES_BOSS ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 52: // PERMISSION_EMPLOYEES_USE_ASSESSEMENT_STATE_FILTER
                    $module_tab['is_active'] = CUSTOMER_OPTION_SHOW_FILTERS_EMPLOYEES_ASSESSMENT_STATE ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 54: // PERMISSION_ASSESSMENT_PROCESS_MARK_ASSESSMENT_DONE
                case 55: // PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATIONS_SELECTED
                //case 57: // PERMISSION_ASSESSMENT_PROCESS_MARK_EVALUATION_DONE
                case 58: // PERMISSION_ASSESSMENT_PROCESS_UNDO_MARK_ASSESSMENT_DONE
                case 59: // PERMISSION_ASSESSMENT_PROCESS_UNDO_MARK_EVALUATIONS_SELECTED
                case 75: // PERMISSION_BATCH_SELF_ASSESSMENT_DASHBOARD_PROCESS
                case 90: // PERMISSION_DASHBOARD_SELF_ASSESSMENT_DASHBOARD_PROCESS
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 56: // PERMISSION_EMPLOYEE_SCORE_FINALIZE_SCORE
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SCORE_STATUS ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 60: // PERMISSION_EMPLOYEE_SELF_ASSESSMENT_OVERVIEW
                case 61: // PERMISSION_BATCH_SELF_ASSESSMENT_OVERVIEW
                case 88: // PERMISSION_DASHBOARD_SELF_ASSESSMENT_OVERVIEW
                    $module_tab['is_active'] = CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION ? $module_tab['is_active'] : MODULE_ACCESS_SETTING_DISABLED;
                    break;
                case 67: // PERMISSION_EXECUTE_SEND_360_INVITATIONS (360 knop score scherm)
                    $module_tab['is_active'] = CUSTOMER_OPTION_USE_SELFASSESSMENT ? MODULE_ACCESS_SETTING_DISABLED : $module_tab['is_active'];
                    break;
            }

            if ($module_tab['is_active'] == MODULE_ACCESS_SETTING_ACTIVE) {
                if (array_key_exists($module_tab['id'], $access_tabs_array)) {
                    $privilege = $access_tabs_array[$module_tab['id']];
                    // privilege naar het juiste nivo terugzetten
//                    $privilege = $privileges_array[$access_tab_key];
                    if ($level_id > $module_tab['max_user_level_add_delete'] && $privilege == PermissionValue::ADD_DELETE_ACCESS) {
                        $privilege = PermissionValue::EDIT_ACCESS;
                    }
                    if ($level_id > $module_tab['max_user_level_edit'] && $privilege == PermissionValue::EDIT_ACCESS) {
                        $privilege = PermissionValue::VIEW_ACCESS;
                    }
                    if ($level_id > $module_tab['max_user_level_view'] && $privilege == PermissionValue::VIEW_ACCESS) {
                        $privilege = PermissionValue::NO_ACCESS;
                    }
                    $module_tab['privilege'] = $privilege;
                    $module_tab['tab_name'] .= ' pa' . $privileges_array[$access_tab_key] . '->' . $privilege .
                                               ':' . $level_id . '>' .  $module_tab['max_user_level_add_delete'] .
                                               ':' . $level_id . '>' .  $module_tab['max_user_level_edit'] .
                                               ':' . $level_id . '>' .  $module_tab['max_user_level_view'];
                } else {
                    $module_tab['privilege'] = PermissionValue::NO_ACCESS;
                    $module_tab['tab_name'] = 'not';
                }

                switch ($module_tab['category']) {
                    case 'T':
                        $title_tabs_T = TXT_UCF('CATEGORY_TAB');
                        $module_tab['tab_menu_label'] = !empty($module_tab['menu_label']) ? TXT_UCW($module_tab['menu_label']) : '';
                        $module_tabs_T[$module_tab['tab_menu_label']][] = $module_tab;
                        $tabModuleCount++;
                        break;
                    case 'P1':
                        $title_tabs_P1 = TXT_UCW($module_tab['menu_label']);
                        $module_tabs_P1[$title_tabs_P1][] = $module_tab;
                        break;
                    case 'P2':
                        $title_tabs_P2 = TXT_UCW($module_tab['menu_label']);
                        $module_tabs_P2[$title_tabs_P2][] = $module_tab;
                        break;
                    case 'P3':
                        $title_tabs_P3 = TXT_UCW($module_tab['menu_label']);
                        $module_tabs_P3[$title_tabs_P3][] = $module_tab;
                        break;
                }
            }
        }

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_LEVELAUTH__EDIT_ACCESS);
        $safeFormHandler->storeSafeValue('level_id', $level_id);
        $safeFormHandler->addIntegerArrayInputFormatType('sel_priv');
        $safeFormHandler->addIntegerArrayInputFormatType('id');

        $safeFormHandler->finalizeDataDefinition();

        $tpl = $smarty->createTemplate('to_refactor/mod_level_authorization/displayAccess.tpl');
        $tpl->assign('formIdentifier', SAFEFORM_LEVELAUTH__EDIT_ACCESS);
        $tpl->assign('form_token', $safeFormHandler->getTokenHiddenInputHtml());
        $tpl->assign('level_name', UserLevelConverter::display($level_id));
        $tpl->assign('level_id', $level_id);
        $tpl->assign('tabModuleCount', $tabModuleCount);
        $tpl->assign('title_tabs_T', $title_tabs_T);
        $tpl->assign('title_tabs_P1', empty($title_tabs_P1) ? TXT_UCF('CATEGORY_MENU')   : $title_tabs_P1);
        $tpl->assign('title_tabs_P2', empty($title_tabs_P2) ? TXT_UCF('CATEGORY_USER')   : $title_tabs_P2);
        $tpl->assign('title_tabs_P3', empty($title_tabs_P3) ? TXT_UCF('CATEGORY_OTHERS') : $title_tabs_P3);

        $tpl->assign('module_tabs_T', $module_tabs_T);
        $tpl->assign('module_tabs_P1', $module_tabs_P1);
        $tpl->assign('module_tabs_P2', $module_tabs_P2);
        $tpl->assign('module_tabs_P3', $module_tabs_P3);
        $objResponse->assign('div_lev_auth_main', 'innerHTML', $smarty->fetch($tpl));
    }

    return $objResponse;
}

function levelAuth_processSafeForm_editAccess($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_LEVEL_AUTHORIZATION)) {
        $level_id = $safeFormHandler->retrieveSafeValue('level_id');

        $ids_array = $safeFormHandler->retrieveInputValue('id');

        // TODO: validatie
        $i = 0;
        $allowed_privileges = array();
        foreach ($safeFormHandler->retrieveInputValue('sel_priv') as $permission) {
            $id_ma = $ids_array[$i];
            $i++;

            if ($permission != 0) {
                $allowed_privileges[$id_ma] = $permission;
            }
        }

        $hasError = true;
        BaseQueries::startTransaction();

        PermissionsService::SetAllowedPrivileges($allowed_privileges,
                                          $level_id,
                                          CUSTOMER_ID);

        BaseQueries::finishTransaction();
        $hasError = false;

        $message = TXT_UCF('LEVEL_AUTHORIZATIONS_SUCCESSFULLY_SAVED');

        // opnieuw inlezen rechten...
        // hmm, zit in pam_config, maar via define, dus niet herinstelbaar :-(
        if (USER_LEVEL == $level_id) {
            InterfaceXajax::reloadApplication($objResponse);
        }
    }
    return array($hasError, $message);
}

?>