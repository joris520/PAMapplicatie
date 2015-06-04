<?php

require_once('modules/model/queries/to_refactor/FunctionQueriesDeprecated.class.php');
require_once('modules/model/service/to_refactor/FunctionsServiceDeprecated.class.php');
require_once('modules/common/moduleUtils.class.php');
require_once('modules/common/moduleConsts.inc.php');
require_once('application/interface/InterfaceBuilder.class.php');

define('RESTORE_NAV_MENU', 1);

function getMainNavButtons($should_restore_main_nav = 0)
{
    $add_buttons = '';
    if (PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $add_buttons .= InterfaceBuilder::IconButton('btn_benchmarking',
                                                    TXT_BTN('BENCHMARKING'),
                                                    'xajax_moduleFunction_benchmarkingOptions_deprecated();',
                                                    ICON_SETTINGS,
                                                    btn_width_150);
    }
    if (PermissionsService::isAddAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $add_buttons .= InterfaceBuilder::IconButton('btn_add_profile',
                                                    TXT_BTN('ADD_NEW_PROFILE'),
                                                    'xajax_moduleFunction_addFunction_deprecated();',
                                                    ICON_ADD,
                                                    btn_width_150);
    }
    return $add_buttons;
}


function moduleFunctions($clearLastModule = false)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        if ($clearLastModule) {
            ApplicationNavigationService::clearLastModule();
        }
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_JOB_PROFILES);

        $add_buttons = getMainNavButtons();
        $html = '
        <div id="mode_function">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td class="left_panel" style="width:300px; min-width:300px;">
                        <div id="search_e" class="search" style="text-align:right;">';
                        $html .= '
                        </div>
                        <div id="scrollDiv">' . getFunctionsList(null) . '</div>
                    </td>
                    <td class="right_panel" >
                        <div id="top_nav" class="top_nav">' . $add_buttons . '<span id="top_nav_print"></span></div>
                        <div id="mod_function_right">
                            <div id="empPrint">
                                <p class="info-text">' .
                                    TXT_UCF('ON_THIS_SCREEN_YOU_CAN_CREATE_OR_EDIT_JOB_PROFILES') . '.<br />' .
                                    TXT_UCF('A_JOB_PROFILE_IS_CONSTRUCTED_FROM_COMPETENCES') . '.<br />' .
                                    TXT_UCF('YOU_CAN_ADD_COMPETENCES_THROUGH_THE_COMPETENCES_TAB') . '.<br />
                                </p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>';
        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_JOB_PROFILES));

        $objResponse->call('setScroll', $_COOKIE['scrollpos']);
    }

    return $objResponse;
}

function getFunctionsList($selected_function_id = null)
{
    $html = '';

    $getf = FunctionQueriesDeprecated::getFunctions();
    if (@mysql_num_rows($getf) == 0) {
        $html = TXT_UCF('NO_JOB_PROFILES_RETURN');
    } else {
        $html .= '
        <table border="0" cellspacing="0" cellpadding="0" style="width:280px;">';
        while ($getf_row = @mysql_fetch_assoc($getf)) {
            $function_id = $getf_row['ID_F'];
            $function = $getf_row['function'];
            $function_class = ($selected_function_id == $function_id) ? 'divLeftWbg' : 'divLeftRow';

            $buttons = '';
            $button_label = ' ' . $function;
            if (PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
                $buttons = InterfaceBuilder::IconButton('edit_function' . $function_id,
                                                       TXT_UCF('EDIT') . $button_label,
                                                       'storeScrollPos();xajax_moduleFunction_editFunctionComptence_deprecated(' . $function_id . ');',
                                                       ICON_EDIT,
                                                       NO_BUTTON_CLASS,
                                                       FORCE_USE_ICON);
            }
            if (PermissionsService::isDeleteAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
                $buttons .= InterfaceBuilder::IconButton('edit_function' . $function_id,
                                                        TXT_UCF('DELETE') . $button_label,
                                                        'storeScrollPos();xajax_moduleFunction_deleteFunction_deprecated(' . $function_id . ');',
                                                        ICON_DELETE,
                                                        NO_BUTTON_CLASS,
                                                        FORCE_USE_ICON);
            }
            $buttons = empty($buttons) ? '&nbsp;' : $buttons ;


            $html .= '
            <tr>
                <td class="dashed_line ' . $function_class . '" style="vertical-align:top;">
                    <a href="" onclick="storeScrollPos();xajax_moduleFunction_displayFunctionCompetence_deprecated(' . $function_id . ','. RESTORE_NAV_MENU . ');return false;">' . $function . '</a>
                </td>
                <td class="dashed_line ' . $function_class . '" align="right" style="min-width: 40px;">' .
                    $buttons . '
                </td>
            </tr>';
        }
        $html .='
        </table>';
    }

    return $html;
}

//DISPLAY FUNCTION COMPETENCE
function moduleFunction_displayFunctionCompetence_deprecated($id_f, $should_restore_main_nav = 0) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $function_list_html = getFunctionsList($id_f);

        $top_nav_print_btn = '';
        $function_html = '';
        $getfp = FunctionQueriesDeprecated::getCompetencesForFunction($id_f);

        if (@mysql_num_rows($getfp) > 0) {
            $top_nav_print_btn = InterfaceBuilder::IconButton('genPrint',
                                                             TXT_BTN('GENERATE_PROFILE_PRINT'),
                                                             'xajax_moduleFunction_printJobProfile_deprecated(' . $id_f . ');',
                                                             ICON_PRINT,
                                                             btn_width_150);

            $function_colspan = 5; // aantal vaste cols
            $function_html .= '
            <table border="0" cellspacing="0" width="99%">
                <tr>
                    <td class="bottom_line shaded_title" width="10%">&nbsp;<strong>' . TXT_UCF('CATEGORY') . '</strong></td>
                    <td class="bottom_line shaded_title" width="20%">&nbsp;<strong>' . TXT_UCF('CLUSTER') .  '</strong></td>
                    <td class="bottom_line shaded_title" >&nbsp;<strong>' . TXT_UCF('COMPETENCE') . '</strong></td>
                    <td class="bottom_line shaded_title" width="5%" align="center">&nbsp;<strong>'  . TXT_UCF('NORM') .          '</strong></td>
                    <td class="bottom_line shaded_title" width="5%" align="center">&nbsp;<strong>'  . TXT_UCF('SCALE') .         '</strong></td>';
                    if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                        $function_html .= '
                    <td class="bottom_line shaded_title" width="5%" align="center">&nbsp;<strong>'  . TXT_UCF('WEIGHT_FACTOR') . '</strong></td>';
                        $function_colspan ++;
                    }
                $function_html .= '
                </tr>';

                $has_key_comps = false;

                $ksp_prefix = '';
                $showNextAsSub = 0;

                while ($getfp_row = @mysql_fetch_assoc($getfp)) {
                    $scale = ModuleUtils::ScaleText($getfp_row[scale]);

                    if ($getfp_row[is_key] == 1) {
                        $key_comp = SIGN_IS_KEY_COMP;
                        $has_key_comps = true;
                    } else {
                        $key_comp = SIGN_IS_NOT_KEY_COMP;
                    }

                    $ks1 = CategoryConverter::display($getfp_row[knowledge_skill]);
                    $oldKs = $newKs;
                    $newKs = $ks1;

                    $ks_d = $newKs <> $oldKs ? $ks1 : '&nbsp;';
                    $ks_dNb = $newKs <> $oldKs ? '&nbsp;' : '&nbsp;';

                    $oldC = $newC;
                    $newC = $getfp_row[cluster];
                    $ksc_d = $newC <> $oldC ? '&nbsp;' . str_replace('zzz', EMPTY_CLUSTER_LABEL, $getfp_row[cluster]) : '&nbsp;';
                    if ($newC <> $oldC) {
                        $ksp_prefix = '';
                        $showNextAsSub = 0;
                    }

                    $rowScale = ModuleUtils::ScoreNormText($getfp_row[scale]);

                    $knowledge_skill_name =  $getfp_row[knowledge_skill_point];
                    if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                        if ($getfp_row['is_cluster_main'] == 1) {
                            $cluster_main_style = ' class="shaded_title"';
                            $ksp_prefix = KSP_INDENT;
                            $ksp_display_prefix = '';
                            $showNextAsSub = 1;
                        } else {
                            $cluster_main_style = '';
                            $ksp_display_prefix = $ksp_prefix;
                        }
                    }
                    $showAsSub = ($showNextAsSub && $getfp_row['is_cluster_main'] != 1 ) ? 1 : 0;

                    $getf_data_link = $ksp_display_prefix . '<a href="" onclick="xajax_moduleFunction_showFuncDict(' . $getfp_row[ID_KSP] . ', ' . $showAsSub . ');return false;" title="' . TXT_UCF('VIEW_DETAILS') .'">' . $knowledge_skill_name . '</a>';

                    $function_html .= '
                <tr>
                    <td class="bottom_line">&nbsp;' . $ks_d . '</td>
                    <td class="bottom_line">&nbsp;' . $ks_dNb . '' . $ksc_d . '</td>
                    <td class="bottom_line">
                        <table border="0" cellspacing="0" cellpadding="0">
                            <tr ' . $cluster_main_style .'>
                                <td>' . $key_comp . '</td>
                                <td id="click_' . $getfp_row[ID_KSP] . '">' . $getf_data_link . '</td>
                            </tr>
                        </table>
                    <td class="bottom_line" align="center">' . $rowScale . '</td>
                    <td class="bottom_line" align="center">' . ModuleUtils::SkillNormText($getfp_row[ksp_scale]) . '</td>';
                    if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                        $function_html .= '
                    <td class="bottom_line" align="center">' . $getfp_row[weight_factor] . '</td>';
                    }
                    $function_html .= '
                </tr>
                <tr>
                    <td></td>
                    <td colspan="' . ($function_colspan - 1) . '" id="Dict' . $getfp_row[ID_KSP] . '"></td>
                </tr>';

                    $modified_by = $getfp_row[modified_by_user];
                    $date_modified = $getfp_row[modified_date];
                    $time_modified = $getfp_row[modified_time];
                } // end while ($getfp_row = @mysql_fetch_assoc($getfp)

                if ($has_key_comps) {
                    $key_comps_note = TXT_UCF('NOTE') . ': '. SIGN_IS_KEY_COMP .'= ' . TXT_UCF('COLLECTIVE_KEY_COMPETENCE');
                } else {
                    $key_comps_note = '&nbsp;';
                }
                $function_html .= '
                <tr>
                    <td colspan="' . $function_colspan . '">
                        <br />' . $key_comps_note . '
                    </td>
                </tr>
            </table>
            <div id="logs" align="right"></div>';
        } else {
            $function_html .= TXT_UCF('NO_COMPETENCE_RETURN');
        }
        $objResponse->assign('scrollDiv', 'innerHTML', $function_list_html);
        $objResponse->assign('mod_function_right', 'innerHTML', $function_html);
        if ($should_restore_main_nav == RESTORE_NAV_MENU) {
            $objResponse->assign('top_nav', 'innerHTML', getMainNavButtons(RESTORE_NAV_MENU). '<span id="top_nav_print"></span>');
        }
        $objResponse->assign('top_nav_print', 'innerHTML', $top_nav_print_btn);
//        $objResponse->assign('module_main_panel', 'innerHTML', $getf_data);
        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $modified_by, $date_modified, $time_modified);
        $objResponse->call('setScroll', $_COOKIE['scrollpos']);
    }

    return $objResponse;
}

function getFunctionsSelectForCopy($select_message)
{
    $html = '';

    $get_f = FunctionQueriesDeprecated::getFunctions();

    if (@mysql_num_rows($get_f) > 0) {
        $html .= $select_message . '
        <select name="ID_F" id="id_f" onchange="xajax_moduleFunction_useExistingProfile_deprecated(this.options[this.selectedIndex].value);return false;">
            <option> - ' . TXT_LC('SELECT_JOB_PROFILE') . ' - </option>';
            while ($function = @mysql_fetch_assoc($get_f)) {
            $html .='
            <option value="' . $function['ID_F'] . '">' . $function['function'] . '</option>';
            }
            $html .='
        </select>';
    }
    return $html;
}

//ADD NEW FUNCTION
function moduleFunction_addFunction_deprecated() {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_FUNCTIONS__ADD_FUNCTION_DEPRECATED);

        $safeFormHandler->addStringInputFormatType('function');
        $safeFormHandler->addPrefixIntegerInputFormatType('com');
        $safeFormHandler->addPrefixStringInputFormatType('scale');
        $safeFormHandler->addPrefixIntegerInputFormatType('wf');
        //$safeFormHandler->addPrefixIntegerInputFormatType('key');

        $safeFormHandler->finalizeDataDefinition();

        $getf_data .= '
        <div id="mod_function_right">
            <form id="addFunctionForm" name="addFunctionForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $getf_data .= $safeFormHandler->getTokenHiddenInputHtml();

        $getf_data .= '
            <p>' . TXT_UCF('ADD_NEW_PROFILE') . '</p>
            <table border="0" cellspacing="2" cellpadding="0" width="80%">
                <tr>
                    <td>
                        <strong>' . TXT_UCF('JOB_PROFILE_NAME') . ':</strong>
                        <br>
                        <input type="text" id="function" name="function" size="50" autocomplete="off">
                        &nbsp;&nbsp;' . getFunctionsSelectForCopy(TXT_UCF('USE_EXISTING_JOB_PROFILE') . ': ') . '
                        <br /><br />
                    </td>
                </tr>
                <tr>
                    <td>';
                        $ksp_rec = FunctionQueriesDeprecated::getEditFunctionCompetences();
                        if (@mysql_num_rows($ksp_rec) == 0) {
                            $getf_data .= TXT_UCF('NO_COMPETENCE_RETURN');
                        } else {
                            $function_colspan = 6; // aantal fixed cols
                            $getf_data .='
                        <table border="0" cellspacing="0" cellpadding="1" width="99%">
                            <tr>
                                <td width="25px">&nbsp;</td>
                                <td width="100px"><strong>' . TXT_UCF('CATEGORY') . '</strong></td>
                                <td><strong>' . TXT_UCF('CLUSTER') . '</strong></td>
                                <td><strong>' . TXT_UCF('COMPETENCE') . '</strong></td>
                                <td><strong>' . TXT_UCF('NORM') . '</strong></td>';
                                if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                                    $getf_data .= '
                                <td><strong>' . TXT_UCF('WEIGHT_FACTOR') . '</strong></td>';
                                    $function_colspan ++;
                                }
                                $getf_data .= '
                                <td><span style="display:none"><strong>' . TXT_UCF('KEY_COMPETENCE') . '</strong></span>&nbsp;</td>
                            </tr>';

                            $ksp_prefix = '';
                            $showNextAsSub = 0;

                            while ($ksp_row = @mysql_fetch_assoc($ksp_rec)) {
                                if ($ksp_row[is_key] == '1') {
                                    $select_disabled = '';
                                    if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                            $scale = '<select name="scale' . $ksp_row[ID_KSP] . '">
                                                        <option value="Y">' . TXT_UCF('YES') . '</option>
                                                        <option value="N">' . TXT_UCF('NO') .  '</option>
                                                    </select>';
                                    } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                            $scale = '<select name="scale' . $ksp_row[ID_KSP] . '">
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5" selected>5</option>
                                                    </select>';
                                    }
                                } else {
                                    $select_disabled = 'disabled="disabled"';
                                    $scale = '<select name="scale' . $ksp_row[ID_KSP] . '" ' . $select_disabled . '>
                                    <option value="" ' . $scale_na . '>' . TXT_UCF('NA') . '</option>
                                    </select>';
                                }


                                $weight_factor3 = '
                                    <select name="wf' . $ksp_row[ID_KSP] . '" ' . $select_disabled . '>
                                        <option value="1">1</option>
                                        <option value="2" selected>2</option>
                                        <option value="3">3</option>
                                    </select>';

                                if ($ksp_row[is_key] == '1') {
                                    //$key_com = 'checked';
                                    $key_comp = SIGN_IS_KEY_COMP;
                                    $checked = 'checked';
                                    //1-5 or N/Y
                                    if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                        $click = 'onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'Y/N\');return false;"';
                                    } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                        $click = 'onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'1-5\');return false;"';
                                    }
                                } else {
                                    $key_comp = SIGN_IS_NOT_KEY_COMP;
                                    $checked = '';
                                    //1-5 or N/Y
                                    if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                        $click = 'onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'Y/N\');return false;"';
                                    } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                        $click = 'onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'1-5\');return false;"';
                                    }
                                }

                                $oldKs = $newKs;
                                $newKs = $ksp_row[knowledge_skill];
                                $ks_d = $newKs <> $oldKs ? CategoryConverter::display($ksp_row[knowledge_skill]) : '';

                                $oldcluster = $cluster;
                                $cluster = $ksp_row[cluster];
                                $clusterNew = $cluster <> $oldcluster ? str_replace('zzz', EMPTY_CLUSTER_LABEL, $ksp_row[cluster]) : '&nbsp;';

                                if ($cluster <> $oldcluster) {
                                    $ksp_prefix = '';
                                    $showNextAsSub = 0;
                                }
                                $knowledge_skill_name = $ksp_row[knowledge_skill_point];
                                if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                                    if ($ksp_row['is_cluster_main'] == 1) {
                                        $cluster_main_style = ' class="shaded_title"';
                                        $ksp_prefix = KSP_INDENT;
                                        $showNextAsSub = 1;
                                        $knowledge_skill_name = $knowledge_skill_name;
                                    } else {
                                        $cluster_main_style = '';
                                        $knowledge_skill_name = $ksp_prefix . $knowledge_skill_name;
                                    }
                                }
                                $showAsSub = ($showNextAsSub && $getfp_row['is_cluster_main'] != 1 ) ? 1 : 0;

                                $getf_data .='
                            <tr>
                                <td class="bottom_line" id="title-' . $ksp_row[ID_KSP] . '">
                                    <div id="com' . $ksp_row[ID_KSP] . '">
                                        <input type="checkbox" name="com' . $ksp_row[ID_KSP] . '" value="' . $ksp_row[ID_KSP] . '" ' . $checked . ' ' . $click . '>
                                    </div>
                                </td>
                                <td class="bottom_line" id="title' . $ksp_row[ID_KSP] . '">' . $ks_d . '</td>
                                <td class="bottom_line" id="title0_' . $ksp_row[ID_KSP] . '">' . $clusterNew . '</td>
                                <td class="bottom_line" id="title1_' . $ksp_row[ID_KSP] . '" style="padding-left:3px;">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr ' . $cluster_main_style .'>
                                            <td>' . $key_comp . '</td>
                                            <td>
                                                <div id="click_' . $ksp_row[ID_KSP] . '">
                                                    <a href="" id="link' . $ksp_row[ID_KSP] . '"  onclick="xajax_moduleFunction_showFuncDict(' . $ksp_row[ID_KSP] . ', ' . $showAsSub .');return false;" title="' . TXT_UCF('VIEW_DETAILS') .'">' . $knowledge_skill_name . '</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="bottom_line" id="title2_' . $ksp_row[ID_KSP] . '">
                                    <div id="click_scale' . $ksp_row[ID_KSP] . '">' . $scale . '</div>
                                </td>';
                                if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                                    $getf_data .='
                                <td class="bottom_line" id="title3_' . $ksp_row[ID_KSP] . '">
                                    <div id="click_weight' . $ksp_row[ID_KSP] . '">' . $weight_factor3 . '</div>
                                </td>';
                                }
                                $getf_data .='
                                <td class="bottom_line" id="title4_' . $ksp_row[ID_KSP] . '">
                                    <input style="display:none" type="checkbox" name="key' . $ksp_row[ID_KSP] . '" value="1" ' . $checked . '>
                                </td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="' . ($function_colspan - 1) . '" id="Dict' . $ksp_row[ID_KSP] . '"></td>
                            </tr>';
                        } // while $ksp_row = @mysql_fetch_assoc($ksp_rec)
                        $getf_data .='
                        </table>';

                        }
                        $getf_data .='
                    </td>
                </tr>
            </table>
            <br>' .
            TXT_UCF('NOTE') . ': ' . SIGN_IS_KEY_COMP . '= ' . TXT_UCF('COLLECTIVE_KEY_COMPETENCE') . '
            <br>
            <table border="0" cellspacing="0" cellpading="0">
                <tr>
                    <td>
                        <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                    </td>
                    <td>
                        <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleFunctions();return false;">
                    </td>
                </tr>
            </table>
            </form>
        </div>';

        $objResponse->assign('mod_function_right', 'innerHTML', $getf_data);
        $objResponse->assign('top_nav', 'innerHTML', '');
        $objResponse->script('xajax.$("function").focus();');
    }

    return $objResponse;
}

function moduleFunction_showFuncDict($id_ksp, $showAsSub) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $id_ksp;
        $competenceQuery = BaseQueries::performQuery($sql);
        $get_dict = @mysql_fetch_assoc($competenceQuery);

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill
                WHERE
                    ID_KS = ' . $get_dict[ID_KS];
        $categoryQuery = BaseQueries::performQuery($sql);
        $get_ks = @mysql_fetch_assoc($categoryQuery);

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $get_dict[ID_C];
        $clusterQuery = BaseQueries::performQuery($sql);
        $get_c = @mysql_fetch_assoc($clusterQuery);

        $get_category = empty($get_ks['knowledge_skill']) ? EMPTY_CLUSTER_LABEL : CategoryConverter::display($get_ks['knowledge_skill']);
        $get_cluster = empty($get_c['cluster']) ? EMPTY_CLUSTER_LABEL : $get_c['cluster'];

        $dict = '<table width="100%" border="0" cellpadding="2" cellspacing="0" class="border1px" style="margin: 1px 0 10px 0;">
                    <tr>
                        <td class="shaded_title bottom_line"><strong>' . TXT_UCF('CATEGORY') . ' : </strong></td>
                        <td colspan="4" class="shaded_title bottom_line">' . $get_category . '</td>
                    </tr>
                    <tr>
                        <td class="shaded_title bottom_line"><strong>' . TXT_UCF('CLUSTER') . ' : </strong></td>
                        <td colspan="4" class="shaded_title bottom_line">' . $get_cluster . '</td>
                    </tr>
                    <tr>
                        <td class="shaded_title bottom_line"><strong>' . TXT_UCF('DESCRIPTION') . ' : </strong></td>
                        <td colspan="4" class="shaded_title bottom_line">' . $get_dict['description'] . '</td>
                    </tr>';
                if ($get_dict['scale'] == ScaleValue::SCALE_1_5) {
                    $dict .= '
                    <tr>
                        <td class="shaded_title bottom_line" width="20%"><strong>[1] ' . SCALE_NONE . '</strong></td>
                        <td class="shaded_title bottom_line" width="20%"><strong>[2] ' . SCALE_BASIC . '</strong></td>
                        <td class="shaded_title bottom_line" width="20%"><strong>[3] ' . SCALE_AVERAGE . '</strong></td>
                        <td class="shaded_title bottom_line" width="20%"><strong>[4] ' . SCALE_GOOD . '</strong></td>
                        <td class="shaded_title bottom_line" width="20%"><strong>[5] ' . SCALE_SPECIALIST . '</strong></td>
                    </tr>
                    <tr>
                        <td class="shaded_title bottom_line">' . nl2br($get_dict['1none']) . '</td>
                        <td class="shaded_title bottom_line">' . nl2br($get_dict['2basic']) . '</td>
                        <td class="shaded_title bottom_line">' . nl2br($get_dict['3average']) . '</td>
                        <td class="shaded_title bottom_line">' . nl2br($get_dict['4good']) . '</td>
                        <td class="shaded_title bottom_line">' . nl2br($get_dict['5specialist']) . '</td>
                    </tr>';
                } else if ($get_dict['scale'] == ScaleValue::SCALE_Y_N) {
                            $dict .= '
                    <tr>
                        <td class="shaded_title bottom_line" width="20%"><strong>[' . ModuleUtils::ScoreNormLetter('Y') . '] ' . SCALE_YES . '</strong></td>
                        <td class="shaded_title bottom_line" width="20%"><strong>[' . ModuleUtils::ScoreNormLetter('N') . '] ' . SCALE_NO . '</strong></td>
                        <td class="shaded_title bottom_line" width="20%">&nbsp;</td>
                        <td class="shaded_title bottom_line" width="20%">&nbsp;</td>
                        <td class="shaded_title bottom_line" width="20%">&nbsp;</td>
                    </tr>';
                }

            $log_id = 'logs2_' . $id_ksp;
            $dict .= '
                    <tr>
                        <td colspan="5" class="shaded_title">
                            <div align="right" id="' . $log_id .'"></div>
                        </td>
                    </tr>
                </table>';
        $ksp = $get_dict[knowledge_skill_point];
        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
            $ksp_display_prefix = ($showAsSub != 1) ? '' : KSP_INDENT;
        }


        $objResponse->assign('Dict' . $id_ksp, 'innerHTML', $dict);
        $objResponse->assign('click_' . $id_ksp, 'innerHTML', $ksp_display_prefix . '<a href="" id="link' . $id_ksp . '"  onclick="xajax_moduleFunction_hideFuncDict(' . $id_ksp . ', ' . $showAsSub . ');return false;" title="' . TXT_UCF('HIDE_DETAILS') . '" class="activated" style="font-weight:bold;">' . $ksp . '</a>');

        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo2', $log_id, $get_dict[modified_by_user], $get_dict[modified_date], $get_dict[modified_time]);
    }

    return $objResponse;
}

function moduleFunction_hideFuncDict($id_ksp, $showAsSub) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points
                WHERE
                    ID_KSP = ' . $id_ksp;
        $competenceQuery = BaseQueries::performQuery($sql);
        $get_dict = @mysql_fetch_assoc($competenceQuery);

        $ksp = $get_dict[knowledge_skill_point];
        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
            $ksp_display_prefix = ($showAsSub != 1) ? '' : KSP_INDENT;
        }

        $objResponse->assign('Dict' . $id_ksp, 'innerHTML', '');
        $objResponse->assign('click_' . $id_ksp, 'innerHTML', $ksp_display_prefix . '<a href="" id="link' . $id_ksp . '"  onclick="xajax_moduleFunction_showFuncDict(' . $id_ksp . ', ' . $showAsSub . ');return false;" title="' . TXT_UCF('VIEW_DETAILS') . '">' . $ksp . '</a>');
    }
    return $objResponse;
}

// dit is dus eigenlijk een edit met een lege id_f
function moduleFunction_useExistingProfile_deprecated($id_f)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $sql = 'SELECT
                    *
                FROM
                    functions
                WHERE
                    ID_F = ' . $id_f;
        $functionQuery = BaseQueries::performQuery($sql);
        $getf = @mysql_fetch_assoc($functionQuery);

        $sql = 'select
                    *
                FROM
                    function_points
                WHERE
                    ID_F = ' . $id_f;
        $functionPointQuery = BaseQueries::performQuery($sql);
        $getfp = @mysql_fetch_assoc($functionPointQuery);

        $sql = 'SELECT
                    knowledge_skill_point
                FROM
                    knowledge_skills_points
                WHERE
                    ID_KSP = ' . $getfp[ID_KSP];
        $competenceQuery = BaseQueries::performQuery($sql);
        $getksp = @mysql_fetch_assoc($competenceQuery);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_FUNCTIONS__ADD_FUNCTION_DEPRECATED);

        $safeFormHandler->addStringInputFormatType('function');
        $safeFormHandler->addPrefixIntegerInputFormatType('com');
        $safeFormHandler->addPrefixStringInputFormatType('scale');
        $safeFormHandler->addPrefixIntegerInputFormatType('wf');
        //$safeFormHandler->addPrefixIntegerInputFormatType('key');

        $safeFormHandler->finalizeDataDefinition();

        $getf_data .= '
        <div id="mod_function_right">
            <form id="addFunctionForm" name="addFunctionForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $getf_data .= $safeFormHandler->getTokenHiddenInputHtml();

        $getf_data .= '
            <p>' . TXT_UCF('ADD_NEW_PROFILE') . '</p>
            <table border="0" cellspacing="2" cellpadding="0" width="80%">
                <tr>
                    <td>
                        <strong> ' . TXT_UCF('JOB_PROFILE_NAME') . ':</strong>
                        <br>
                        <input type="text" id="function" name="function" size="30" value="' . $getf['function'] . '" autocomplete="off">
                        &nbsp;&nbsp;' . getFunctionsSelectForCopy(TXT_UCF('USE_EXISTING_JOB_PROFILE') . ': ') . '
                        <br /><br />
                    </td>
                </tr>
                <tr>
                    <td>';
                        $ksp_rec = FunctionQueriesDeprecated::getEditFunctionCompetences();
                        if (@mysql_num_rows($ksp_rec) == 0) {
                            $getf_data .= TXT_UCF('NO_COMPETENCE_RETURN');
                        } else {
                            $function_colspan = 6; // aantal fixed cols
                        $getf_data .='<table border="0" cellspacing="0" cellpadding="1" width="99%">
                                        <tr>
                                            <td width="25px">&nbsp;</td>
                                            <td width="100px"><strong>' . TXT_UCF('CATEGORY') . '</strong></td>
                                            <td><strong>' . TXT_UCF('CLUSTER') . '</strong></td>
                                            <td><strong>&nbsp;' . TXT_UCF('COMPETENCE') . '</strong></td>
                                            <td><strong>' . TXT_UCF('NORM') . '</strong></td>';
                                            if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                                                $getf_data .= '
                                                <td><strong>' . TXT_UCF('WEIGHT_FACTOR') . '</strong></td>';
                                                $function_colspan ++;
                                            }
                                            $getf_data .= '
                                            <td><span style="display:none"><strong>' . TXT_UCF('KEY_COMPETENCE') . '</strong></span>&nbsp;</td>
                                        </tr>';

                        while ($ksp_row = @mysql_fetch_assoc($ksp_rec)) {

                        $sql = 'SELECT
                                    *
                                FROM
                                    function_points
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_F = ' . $id_f . '
                                    AND ID_KSP = ' . $ksp_row[ID_KSP];
                        $competenceFunctionPointsQuery = BaseQueries::performQuery($sql);
                        $get_fpps = @mysql_fetch_assoc($competenceFunctionPointsQuery);
                        if (!empty($get_fpps[scale])) {
                            $select_disabled = '';
                            $scale_y = $get_fpps[scale] == 'Y' ? 'selected' : '';
                            $scale_n = $get_fpps[scale] == 'N' ? 'selected' : '';

                            $scale_1 = $get_fpps[scale] == '1' ? 'selected' : '';
                            $scale_2 = $get_fpps[scale] == '2' ? 'selected' : '';
                            $scale_3 = $get_fpps[scale] == '3' ? 'selected' : '';
                            $scale_4 = $get_fpps[scale] == '4' ? 'selected' : '';
                            $scale_5 = $get_fpps[scale] == '5' ? 'selected' : '';


                            if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                $scale = '<select name="scale' . $ksp_row[ID_KSP] . '">
                                            <option value="Y" ' . $scale_y . '>' . TXT_UCF('YES') . '</option>
                                            <option value="N" ' . $scale_n . '>' . TXT_UCF('NO') . '</option>
                                        </select>';
                            } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                $scale = '<select name="scale' . $ksp_row[ID_KSP] . '">
                                            <option value="1" ' . $scale_1 . '>1</option>
                                            <option value="2" ' . $scale_2 . '>2</option>
                                            <option value="3" ' . $scale_3 . '>3</option>
                                            <option value="4" ' . $scale_4 . '>4</option>
                                            <option value="5" ' . $scale_5 . '>5</option>
                                        </select>';
                            }
                        } else {
                            $select_disabled = 'disabled="disabled"';
                            $scale = '<select name="scale' . $ksp_row[ID_KSP] . '" disabled="disabled">
                            <option value="">' . TXT_UCF('NA') . '</option>
                            </select>';
                        }
                        $sql = 'SELECT
                                    *
                                FROM
                                    function_points
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_KSP = ' . $ksp_row[ID_KSP] . '
                                    AND ID_F = ' . $id_f;
                        $get_fpp = BaseQueries::performQuery($sql);
                        $get_wf = @mysql_fetch_assoc($get_fpp);

                        $weight_1 = $get_wf[weight_factor] == '1' ? 'selected' : '';
                        $weight_2 = $get_wf[weight_factor] == '2' ? 'selected' : '';
                        $weight_3 = $get_wf[weight_factor] == '3' ? 'selected' : '';

                        $weight_2 = empty($get_wf[weight_factor]) ? 'selected' : '';

                        $weight_factor3 = '<select name="wf' . $ksp_row[ID_KSP] . '" ' . $select_disabled . '>
                                            <option value="1" ' . $weight_1 . '>1</option>
                                            <option value="2" ' . $weight_2 . '>2</option>
                                            <option value="3" ' . $weight_3 . '>3</option>
                                        </select>';


                        if (@mysql_num_rows($get_fpp) > 0) {
                            $checked = 'checked';
                            $if_checked = '1';

            //                if ($get_wf[key_com] == 1) {  // niet uit fp, maar uit ksp
                            if ($ksp_row[is_key] == 1) {
                                $key_com = 'checked';
                                $key_comp = SIGN_IS_KEY_COMP;
                            } else {
                                $key_com = '';
                                $key_comp = SIGN_IS_NOT_KEY_COMP;
                            }

                            //1-5 or N/Y
                            if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                $click = 'onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'Y/N\');return false;"';
                            } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                $click = 'onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'1-5\');return false;"';
                            }
                            //end
                        } else {
                            //1-5 or N/Y
                            if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                $click = 'onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'Y/N\');return false;"';
                            } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                $click = 'onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'1-5\');return false;"';
                            }
                            //end

                            $checked = '';
                            $if_checked = '0';

                            if ($ksp_row[is_key] == '1') {
                                //$key_com = 'checked';
                                $key_comp = SIGN_IS_KEY_COMP;
                            } else {
                                $key_com = '';
                                $key_comp = SIGN_IS_NOT_KEY_COMP;
                            }
                        }

                        $oldKs = $newKs;
                        $newKs = $ksp_row[knowledge_skill];
                        $ks_d = $newKs <> $oldKs ? CategoryConverter::display($ksp_row[knowledge_skill]) : '';

                        $oldcluster = $cluster;
                        $cluster = $ksp_row[cluster];
                        $clusterNew = ($cluster <> $oldcluster) ? str_replace('zzz', EMPTY_CLUSTER_LABEL, $ksp_row[cluster]) : '&nbsp;';

                        if ($cluster <> $oldcluster) {
                            $ksp_prefix = '';
                            $showNextAsSub = 0;
                        }
                        $knowledge_skill_name = $ksp_row[knowledge_skill_point];
                        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                            if ($ksp_row['is_cluster_main'] == 1) {
                                $cluster_main_style = ' class="shaded_title"';
                                $ksp_prefix = KSP_INDENT;
                                $showNextAsSub = 1;
                                $knowledge_skill_name = $knowledge_skill_name;
                            } else {
                                $cluster_main_style = '';
                                $knowledge_skill_name = $ksp_prefix . $knowledge_skill_name;
                            }
                        }
                        $showAsSub = ($showNextAsSub && $getfp_row['is_cluster_main'] != 1 ) ? 1 : 0;

                        $getf_data .='
                                    <tr>
                                        <td class="bottom_line" id="title-' . $ksp_row[ID_KSP] . '">
                                            <div id="com' . $ksp_row[ID_KSP] . '">
                                                <input type="checkbox" name="com' . $ksp_row[ID_KSP] . '" value="' . $ksp_row[ID_KSP] . '" ' . $checked . ' ' . $click . '>
                                            </div>
                                        </td>
                                        <td class="bottom_line" id="title' . $ksp_row[ID_KSP] . '">' . $ks_d . '</td>
                                        <td class="bottom_line" id="title0_' . $ksp_row[ID_KSP] . '">' . $clusterNew . '</td>
                                        <td class="bottom_line" id="title1_' . $ksp_row[ID_KSP] . '" style="padding-left:3px;">
                                            <table border="0" cellspacing="0" cellpadding="0">
                                                <tr ' . $cluster_main_style .'>
                                                    <td>' . $key_comp . '</td>
                                                    <td>
                                                        <div id="click_' . $ksp_row[ID_KSP] . '">
                                                            <a href="" id="link' . $ksp_row[ID_KSP] . '" onclick="xajax_moduleFunction_showFuncDict(' . $ksp_row[ID_KSP] . ', ' . $showAsSub .');return false;" title="' . TXT_UCF('VIEW_DETAILS') .'">' . $ksp_row[knowledge_skill_point] . '</a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td class="bottom_line" id="title2_' . $ksp_row[ID_KSP] . '">
                                            <div id="click_scale' . $ksp_row[ID_KSP] . '">' . $scale . '</div>
                                        </td>';
                                        if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                                            $getf_data .='
                                            <td class="bottom_line" id="title3_' . $ksp_row[ID_KSP] . '">
                                                <div id="click_weight' . $ksp_row[ID_KSP] . '">' . $weight_factor3 . '</div>
                                            </td>';
                                        }
                                        $getf_data .='
                                        <td class="bottom_line" id="title4_' . $ksp_row[ID_KSP] . '">
                                            <input style="display:none" type="checkbox" name="key' . $ksp_row[ID_KSP] . '" value="1" ' . $key_com . '>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="' . ($function_colspan - 1) . '" id="Dict' . $ksp_row[ID_KSP] . '"></td>
                                    </tr>';
                        } // while ($ksp_row = @mysql_fetch_assoc($ksp_rec)
                        $getf_data .='</table>';
                    }
                    $getf_data .='</td>
                                </tr>
                            </table>
                            <br>' .
                            TXT_UCF('NOTE') . ': ' . SIGN_IS_KEY_COMP .'= ' . TXT_UCF('COLLECTIVE_KEY_COMPETENCE') . '
                            <br>

                            <table border="0" cellspacing="0" cellpading="0">
                                <tr>
                                    <td>
                                        <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                                    </td>
                                    <td>
                                        <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleFunctions();return false;">
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>';

        $objResponse->assign('mod_function_right', 'innerHTML', $getf_data);
        $objResponse->assign('top_nav', 'innerHTML', '');
        $objResponse->script('xajax.$("function").focus();');
    }

    return $objResponse;
}

//EXECUTE ADD NEW FUNCTION
// TODO: refactor

//VALIDATE ADD NEW FUNCTION WHEN VALIDATEED THEN EXECUTE

function functions_processSafeForm_addFunction_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

// TODO: refactor: eerst alles uit form, dan pas valideren en verwerken!

        $function = $safeFormHandler->retrieveInputValue('function');

        $sql = 'SELECT
                    *
                FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND LOWER(function) = LOWER("' . mysql_real_escape_string($function) . '")';
        $functionQuery  = BaseQueries::performSelectQuery($sql);

        $hasError = false;
        if (empty($function)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_JOB_PROFILE');
        } elseif (@mysql_num_rows($functionQuery) > 0) {
            $hasError = true;
            $message = TXT_UCF('PROFILE_NAME_YOU_ENTERED_IS_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_PROFILE_NAME');
        }


        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'INSERT INTO
                        functions
                        (   customer_id,
                            function,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                             ' . CUSTOMER_ID . ',
                            "' . mysql_real_escape_string($function) . '",
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '")';
            $new_function_id = BaseQueries::performInsertQuery($sql);

            $sql = 'SELECT
                        *
                    FROM
                        knowledge_skills_points
                    WHERE
                        customer_id = ' . CUSTOMER_ID;
            $get_ksp = BaseQueries::performTransactionalSelectQuery($sql);

            while ($ksp_row = @mysql_fetch_assoc($get_ksp)) {
                $ID_KSPT = $ksp_row['ID_KSP'];
                $com_id = $safeFormHandler->retrieveInputValue('com'.$ID_KSPT);
                if ($ksp_row['ID_KSP'] == $com_id) {

                    $wf_id = $safeFormHandler->retrieveInputValue('wf' . $ksp_row['ID_KSP']);
                    $scale = $safeFormHandler->retrieveInputValue('scale' . $ksp_row['ID_KSP']);
                    //$key_id = $safeFormHandler->retrieveSafeValue('key'.$ksp_row[ID_KSP]); // HP: Is deze key nog nodig? Hij staat in de HTML op: "display:none"

                    $function_weight_factor = empty($wf_id) ? DEFAULT_FUNCTION_WEIGHT : $wf_id;
                    //$ID_KSP .='<b>Insert '.$ksp_row[ID_KSP].' - '.$ksp_row[knowledge_skill_point].' scale'.$ksp_row[ID_KSP].' = '.$functionForm['scale'.$ksp_row[ID_KSP]].'</b><br>';
                    $key_com = empty($key_id) ? '0' : '1';

                    $sql = 'INSERT INTO
                                function_points
                                (   customer_id,
                                    ID_F,
                                    ID_KSP,
                                    scale,
                                    weight_factor,
                                    key_com,
                                    modified_by_user,
                                    modified_time,
                                    modified_date
                                ) VALUES (
                                     ' . CUSTOMER_ID . ',
                                     ' . $new_function_id . ',
                                     ' . $ksp_row['ID_KSP'] . ',
                                    "' . mysql_real_escape_string($scale) . '",
                                     ' . $function_weight_factor . ',
                                     ' . $key_com . ',
                                    "' . $modified_by_user . '",
                                    "' . $modified_time . '",
                                    "' . $modified_date . '"
                                )';
                    BaseQueries::performInsertQuery($sql);
                } else {
                    // do nothing..
                }
            }

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(moduleFunctions());
        }
    }
    return array($hasError, $message);
}

//DELETE FUNCTION
// TODO: refactor
function moduleFunction_deleteFunction_deprecated($id_f) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        if (FunctionsServiceDeprecated::isFunctionUsedByEmployees($id_f)) {
            $objResponse->alert(TXT_UCF('YOU_CANNOT_DELETE_THE_JOB_PROFILE_BECAUSE_IT_IS_USED_BY_EMPLOYEES'));
        } else {
            $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_JOB_PROFILE') . '?');
            $objResponse->call("xajax_moduleFunction_executeDeleteFunction", $id_f);
        }
    }

    return $objResponse;
}

//EXECUTE DELETE FUNCTION
// TODO: refactor

function moduleFunction_executeDeleteFunction($id_f) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $sql = 'DELETE FROM
                    function_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_F = ' . $id_f;
        BaseQueries::performQuery($sql);

        $sql = 'DELETE FROM
                    functions
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_F = ' . $id_f;
        BaseQueries::performQuery($sql);
    }

    return moduleFunctions();
}

//EDIT COMPETENCE FUNCTION
// TODO: refactor
function moduleFunction_editFunctionComptence_deprecated($id_f) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_FUNCTIONS__EDIT_FUNCTIONCOMPETENCE_DEPRECATED);
        $safeFormHandler->storeSafeValue('id_f', $id_f);

        $safeFormHandler->addStringInputFormatType('function');
        $safeFormHandler->addPrefixIntegerInputFormatType('com');
        $safeFormHandler->addPrefixStringInputFormatType('scale');
        $safeFormHandler->addPrefixIntegerInputFormatType('wf');

        $safeFormHandler->finalizeDataDefinition();

        $sql = 'SELECT
                    *
                FROM
                    functions
                WHERE
                    ID_F = ' . $id_f ;
        $functionQuery = BaseQueries::performQuery($sql);
        $getf = @mysql_fetch_assoc($functionQuery);

        $getf_data = '';
        $getf_data .= '<div id="mode_function">
                        <form id="editFunctionCompetenceForm" name="editFunctionCompetenceForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $getf_data .= $safeFormHandler->getTokenHiddenInputHtml();

        $getf_data .= '
                        <p>' . TXT_UCF('UPDATE_PROFILE_COMPETENCE') . '</p>
                        <table border="0" cellspacing="2" cellpadding="0" width="80%">
                            <tr>
                                <td>
                                    <strong>' . TXT_UCF('JOB_PROFILE_NAME') . ':</strong>
                                    <br>
                                    <input type="text" id="function" name="function" size="50" value="' . $getf['function'] . '" autocomplete="off">
                                    <br><br>
                                </td>
                            </tr>
                            <tr>
                                <td>';
                                $sql = 'SELECT
                                            ks.knowledge_skill,
                                            CASE WHEN ksc.cluster is null
                                                 THEN "zzz"
                                                 ELSE ksc.cluster
                                            END as cluster,
                                            ksp.*
                                        FROM
                                            knowledge_skills_points ksp
                                            LEFT JOIN knowledge_skill ks
                                                ON ks.ID_KS = ksp.ID_KS
                                            LEFT JOIN knowledge_skill_cluster ksc
                                                ON ksc.ID_C = ksp.ID_C
                                        WHERE
                                            ksp.customer_id = ' . CUSTOMER_ID . '
                                        ORDER BY
                                            ks.knowledge_skill,
                                            cluster,
                                            ksp.is_cluster_main DESC,
                                            ksp.knowledge_skill_point';
                                $ksp_rec = BaseQueries::performQuery($sql);

                                if (@mysql_num_rows($ksp_rec) == 0) {
                                    $getf_data .= TXT_UCF('NO_COMPETENCE_RETURN');
                                } else {
                                    $function_colspan = 6; // aantal vaste cols
                                    $getf_data .='<table border="0" cellspacing="0" cellpadding="1" width="99%">
                                                    <tr>
                                                        <td width="25px">&nbsp;</td>
                                                        <td width="100px"><strong>' . TXT_UCF('CATEGORY') . '</strong></td>
                                                        <td><strong>' . TXT_UCF('CLUSTER') . '</strong></td>
                                                        <td><strong>' . TXT_UCF('COMPETENCE') . '</strong></td>
                                                        <td><strong>' . TXT_UCF('NORM') . '</strong></td>';
                                                        if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                                                            $getf_data .= '
                                                            <td><strong>' . TXT_UCF('WEIGHT_FACTOR') . '</strong></td>';
                                                            $function_colspan ++;
                                                        }
                                                        $getf_data .= '
                                                        <td>&nbsp;</td>
                                                    </tr>';

                                    while ($ksp_row = @mysql_fetch_assoc($ksp_rec)) {

                                        $sql = 'SELECT
                                                    *
                                                FROM
                                                    function_points
                                                WHERE
                                                    ID_F = ' . $id_f . '
                                                    AND ID_KSP = ' . $ksp_row[ID_KSP];
                                        $competenceFunctionpointQuery = BaseQueries::performQuery($sql);
                                        $get_fpps = @mysql_fetch_assoc($competenceFunctionpointQuery);

                                        $scale_y = $get_fpps[scale] == 'Y' ? 'selected' : '';
                                        $scale_n = $get_fpps[scale] == 'N' ? 'selected' : '';

                                        $scale_1 = $get_fpps[scale] == '1' ? 'selected' : '';
                                        $scale_2 = $get_fpps[scale] == '2' ? 'selected' : '';
                                        $scale_3 = $get_fpps[scale] == '3' ? 'selected' : '';
                                        $scale_4 = $get_fpps[scale] == '4' ? 'selected' : '';
                                        $scale_5 = $get_fpps[scale] == '5' ? 'selected' : '';
                                        $scale_na = $get_fpps[scale] == '' ? 'selected' : '';


                                        if (!empty($get_fpps[scale])) {
                                            $select_disabled = '';
                                            if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                                    $scale = '<select name="scale' . $ksp_row[ID_KSP] . '">
                                                    <option value="Y" ' . $scale_y . '>' . TXT_UCF('YES') . '</option>
                                                    <option value="N" ' . $scale_n . '>' . TXT_UCF('NO') .  '</option>
                                                    </select>';
                                            } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                                    $scale = '<select name="scale' . $ksp_row[ID_KSP] . '">
                                                                <option value="1" ' . $scale_1 . '>1</option>
                                                                <option value="2" ' . $scale_2 . '>2</option>
                                                                <option value="3" ' . $scale_3 . '>3</option>
                                                                <option value="4" ' . $scale_4 . '>4</option>
                                                                <option value="5" ' . $scale_5 . '>5</option>
                                                            </select>';
                                            }
                                        } else {
                                            $select_disabled = 'disabled="disabled"';
                                            $scale = '<select name="scale' . $ksp_row[ID_KSP] . '" ' . $select_disabled . '>
                                                        <option value="" ' . $scale_na . '>' . TXT_UCF('NA') . '</option>
                                                    </select>';
                                        }

                                        $sql = 'SELECT
                                                    *
                                                FROM
                                                    function_points
                                                WHERE
                                                    ID_KSP = ' . $ksp_row['ID_KSP'] . '
                                                    AND ID_F = ' . $id_f;
                                        $get_fpp = BaseQueries::performQuery($sql);
                                        $get_wf = @mysql_fetch_assoc($get_fpp);
                                        $weight_1 = $get_wf[weight_factor] == 1 ? 'selected' : '';
                                        // als er nog niets is ingevuld is 2 de default
                                        $weight_2 = $get_wf[weight_factor] == 2 || empty($get_wf['weight_factor']) ? 'selected' : '';
                                        $weight_3 = $get_wf[weight_factor] == 3 ? 'selected' : '';



                                        $weight_factor3 = '
                                        <select name="wf' . $ksp_row[ID_KSP] . '" ' . $select_disabled . '>
                                                <option value="1" ' . $weight_1 . '>1</option>
                                                <option value="2" ' . $weight_2 . '>2</option>
                                                <option value="3" ' . $weight_3 . '>3</option>
                                            </select>';



                                        if (@mysql_num_rows($get_fpp) > 0) {
                                            $checked = 'checked';
                                            $if_checked = '1';

                            //                if ($get_wf[key_com] == 1) {  // hbd: niet uit fp, maar uit ksp
                                            //1-5 or N/Y
                                            if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                                $click = 'onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'Y/N\');return false;"';
                                            } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                                $click = 'onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'1-5\');return false;"';
                                            }
                                            //end
                                        } else {
                                            //1-5 or N/Y
                                            if ($ksp_row[scale] == ScaleValue::SCALE_Y_N) {
                                                $click = 'onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'Y/N\');return false;"';
                                            } elseif ($ksp_row[scale] == ScaleValue::SCALE_1_5) {
                                                $click = 'onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_row[ID_KSP] . ', \'1-5\');return false;"';
                                            }
                                            //end

                                            $checked = '';
                                            $if_checked = '0';
                                        }

                                        if ($ksp_row[is_key] == 1) {
                                            $key_comp = SIGN_IS_KEY_COMP;
                                        } else {
                                            $key_comp = SIGN_IS_NOT_KEY_COMP;
                                        }

                                        $oldKs = $newKs;
                                        $newKs = $ksp_row[knowledge_skill];
                                        $ks_d = $newKs <> $oldKs ? CategoryConverter::display($ksp_row[knowledge_skill]) : '';

                                        $oldcluster = $cluster;
                                        $cluster = $ksp_row[cluster];
                                        $clusterNew = $cluster <> $oldcluster ? str_replace('zzz', EMPTY_CLUSTER_LABEL, $ksp_row[cluster]) : '&nbsp;';

                                        if ($cluster <> $oldcluster) {
                                            $ksp_prefix = '';
                                            $showNextAsSub = 0;
                                        }
                                        $knowledge_skill_name = $ksp_row[knowledge_skill_point];
                                        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                                            if ($ksp_row['is_cluster_main'] == 1) {
                                                $cluster_main_style = ' class="shaded_title"';
                                                $ksp_prefix = KSP_INDENT;
                                                $showNextAsSub = 1;
                                                $knowledge_skill_name = $knowledge_skill_name;
                                            } else {
                                                $cluster_main_style = '';
                                                $knowledge_skill_name = $ksp_prefix . $knowledge_skill_name;
                                            }
                                        }
                                        $showAsSub = ($showNextAsSub && $getfp_row['is_cluster_main'] != 1 ) ? 1 : 0;

                                        //if($get_fpp[is_key]==1) { $kc_checked = 'checked'; } else { $kc_checked = ''; }
                                        $getf_data .='
                                                    <tr>
                                                        <td class="bottom_line" id="title-' . $ksp_row[ID_KSP] . '">
                                                            <div id="com' . $ksp_row[ID_KSP] . '">
                                                                <input type="checkbox" name="com' . $ksp_row[ID_KSP] . '" value="' . $ksp_row[ID_KSP] . '" ' . $checked . ' ' . $click . '>
                                                            </div>
                                                        </td>
                                                        <td class="bottom_line" id="title' . $ksp_row[ID_KSP] . '">' . $ks_d . '</td>
                                                        <td class="bottom_line" id="title0_' . $ksp_row[ID_KSP] . '">' . $clusterNew . '</td>
                                                        <td class="bottom_line" id="title1_' . $ksp_row[ID_KSP] . '" style="padding-left:3px;">
                                                            <table border="0" cellspacing="0" cellpadding="0">
                                                                <tr ' . $cluster_main_style .'>
                                                                    <td>' . $key_comp . '&nbsp;</td>
                                                                    <td>
                                                                        <div id="click_' . $ksp_row[ID_KSP] . '">
                                                                            <a href="" id="link' . $ksp_row[ID_KSP] . '" onclick="xajax_moduleFunction_showFuncDict(' . $ksp_row[ID_KSP] . ', ' . $showAsSub . ');return false;" title="' . TXT_UCF('VIEW_DETAILS') .'">' . $knowledge_skill_name . '</a>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                        <td class="bottom_line" id="title2_' . $ksp_row[ID_KSP] . '">
                                                            <div id="click_scale' . $ksp_row[ID_KSP] . '">' . $scale . '</div>
                                                        </td>';
                                                        if (CUSTOMER_OPTION_SHOW_WEIGHT) {
                                                            $getf_data .='
                                                            <td class="bottom_line" id="title3_' . $ksp_row[ID_KSP] . '">
                                                                <div id="click_weight' . $ksp_row[ID_KSP] . '">' . $weight_factor3 . '</div>
                                                            </td>';
                                                        }
                                                        $getf_data .='
                                                        <td class="bottom_line" id="title4_' . $ksp_row[ID_KSP] . '">&nbsp;
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td></td>
                                                        <td colspan="'. ($function_colspan - 1) . '" id="Dict' . $ksp_row[ID_KSP] . '"></td>
                                                    </tr>';
                                    } // while $ksp_row = @mysql_fetch_assoc($ksp_rec)

                                    $getf_data .= '</table>';

                                }
                                $getf_data .='
                                </td>
                            </tr>
                        </table>
                        <br>' . TXT_UCF('NOTE'). ': ' . SIGN_IS_KEY_COMP . '= ' . TXT_UCF('COLLECTIVE_KEY_COMPETENCE') . '
                        <br>
                        <table border="0" cellspacing="0" cellpading="0">
                            <tr>
                                <td>
                                    <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                                </td>
                                <td>
                                    <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleFunction_displayFunctionCompetence_deprecated(' . $id_f . ', ' . RESTORE_NAV_MENU . ');return false;">
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>';

        $objResponse->assign('mod_function_right', 'innerHTML', $getf_data);
        $objResponse->assign('scrollDiv', 'innerHTML', getFunctionsList($id_f));
        $objResponse->assign('top_nav', 'innerHTML', '');
    }

    return $objResponse;
}

function moduleFunction_showScaleDetails_deprecated($ksp_id, $scale2) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        if ($scale2 == ScaleValue::SCALE_Y_N) {
            $scale = '<select name="scale' . $ksp_id . '">
                        <option value="Y" selected>' . TXT_UCF('YES') . '</option>
                        <option value="N">' . TXT_UCF('NO') . '</option>
                    </select>';
        } elseif ($scale2 == ScaleValue::SCALE_1_5) {
            $scale = '<select name="scale' . $ksp_id . '">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5" selected>5</option>
                    </select>';
        }

        $weight_factor3 = '<select name="wf' . $ksp_id . '" ' . $select_disabled . '>
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                                <option value="3">3</option>
                        </select>';

        $objResponse->assign('click_scale' . $ksp_id, 'innerHTML', $scale);
        $objResponse->assign('click_weight' . $ksp_id, 'innerHTML', $weight_factor3);
        $objResponse->assign('com' . $ksp_id, 'innerHTML', '<input type="checkbox" name="com' . $ksp_id . '" value="' . $ksp_id . '" checked onclick="xajax_moduleFunction_hideScaleDetails_deprecated(' . $ksp_id . ', \'' . $scale2 . '\');return false;">');
    }

    return $objResponse;
}

function moduleFunction_hideScaleDetails_deprecated($ksp_id, $scale2) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        if ($scale2 == ScaleValue::SCALE_Y_N) {
            $scale = '<select name="scale' . $ksp_id . '" disabled="disabled">';
            $scale .= '   <option value="" selected>' . TXT_UCF('NA') . '</option>
                    </select>';
        } elseif ($scale2 == ScaleValue::SCALE_1_5) {
            $scale = '<select name="scale' . $ksp_id . '" disabled="disabled">
                        <option value="" selected>' . TXT_UCF('NA') . '</option>';
            $scale .= '</select>';
        }

        $weight_factor3 = '<select name="wf' . $ksp_id . '" disabled="disabled">
                                <option value="1">1</option>
                                <option value="2" selected>2</option>
                                <option value="3">3</option>
                        </select>';

        $objResponse->assign('click_scale' . $ksp_id, 'innerHTML', $scale);
        $objResponse->assign('click_weight' . $ksp_id, 'innerHTML', $weight_factor3);
        $objResponse->assign('com' . $ksp_id, 'innerHTML', '<input type="checkbox" name="com' . $ksp_id . '" value="' . $ksp_id . '" onclick="xajax_moduleFunction_showScaleDetails_deprecated(' . $ksp_id . ', \'' . $scale2 . '\');return false;">');
        $objResponse->assign('key' . $ksp_id, 'checked', false);
    }

    return $objResponse;
}

//EXECUTE ADD NEW FUNCTION
function functions_processSafeForm_editFunctionCompetence_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {

        $id_f = $safeFormHandler->retrieveSafeValue('id_f');
        $function = $safeFormHandler->retrieveInputValue('function');

        $hasError = false;
        if (empty($function)) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_ENTER_A_JOB_PROFILE');
        } else {
            $sql = 'SELECT
                        *
                    FROM
                        functions
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND LOWER(function) = LOWER("' . mysql_real_escape_string($function) . '")
                        AND ID_F <> ' . $id_f ;
            $get_fc = BaseQueries::performSelectQuery($sql);

            if (@mysql_num_rows($get_fc) > 0) {
                $hasError = true;
                $message = TXT_UCF('PROFILE_NAME_YOU_ENTERED_IS_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_PROFILE_NAME');
            }
        }


        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;


            $sql = 'SELECT
                        *
                    FROM
                        knowledge_skills_points
                    WHERE
                        customer_id = ' . CUSTOMER_ID;
            $get_ksp = BaseQueries::performTransactionalSelectQuery($sql);

            while ($ksp_row = @mysql_fetch_assoc($get_ksp)) {
                $ID_KSPT = $ksp_row['ID_KSP'];
                $com_id = $safeFormHandler->retrieveInputValue('com'.$ID_KSPT);
                if ($ksp_row['ID_KSP'] == $com_id) {
                    // TODO: eerst alle waarden uit scherm ophalen in array, dan valideren en  daarna pas verwerken in database
                    $wf_id = $safeFormHandler->retrieveInputValue('wf' . $ksp_row['ID_KSP']);
                    $scale = $safeFormHandler->retrieveInputValue('scale' . $ksp_row['ID_KSP']); // kan 1..5, Y, N zijn

                    $function_weight_factor = empty($wf_id) ? DEFAULT_FUNCTION_WEIGHT : $wf_id;
                    //execute updation query and addition if new competence is selected
                    $sql = 'SELECT
                                *
                            FROM
                                function_points
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND ID_F = ' . $id_f . '
                                AND ID_KSP = ' . $ksp_row['ID_KSP'];
                    $chk_ifExist = BaseQueries::performTransactionalSelectQuery($sql);

                    if (@mysql_num_rows($chk_ifExist) > 0) {
                        // TODO: replace into??
                        $get_fp = @mysql_fetch_assoc($chk_ifExist);
                        //$ID_KSP .=$get_fp[ID_FP].' <i>Update '.$ksp_row[ID_KSP].' - '.$ksp_row[knowledge_skill_point].' scale'.$ksp_row[ID_KSP].' = '.$functionForm['scale'.$ksp_row[ID_KSP]].'</i><br>';
                        //update
                        $sql = 'UPDATE
                                    function_points
                                SET
                                    scale= "' . mysql_real_escape_string($scale) . '",
                                    weight_factor  = ' . $function_weight_factor . ',
                                    modified_by_user = "' . $modified_by_user . '",
                                    modified_time = "' . $modified_time . '",
                                    modified_date = "' . $modified_date . '"
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_FP = ' . $get_fp['ID_FP'];
                        BaseQueries::performUpdateQuery($sql);
                        //$objResponse->alert('key com'.$functionForm['key'.$ksp_row[ID_KSP]]);
                    } else {
                        //insert
                        //$ID_KSP .='ID_F='.$id_f.' , ID_KSP='.$ksp_row[ID_KSP].' , scale='.$functionForm['scale'.$ksp_row[ID_KSP]].' , weight_faction='.$functionForm['wf'.$ksp_row[ID_KSP]].' , is_key='.$functionForm['kc'.$ksp_row[ID_KSP]];
                        $sql = 'INSERT INTO
                                    function_points
                                    (   customer_id,
                                        ID_F,
                                        ID_KSP,
                                        scale,
                                        weight_factor,
                                        key_com,
                                        modified_by_user,
                                        modified_time,
                                        modified_date
                                    ) VALUES (
                                        ' . CUSTOMER_ID . ',
                                        ' . $id_f . ',
                                        ' . $ksp_row['ID_KSP'] . ',
                                       "' . mysql_real_escape_string($scale) . '",
                                        ' . $function_weight_factor . ',
                                        ' . FUNCTION_NOT_KEY_COMPETENCE . ',
                                       "' . $modified_by_user . '",
                                       "' . $modified_time . '",
                                       "' . $modified_date . '")';
                        BaseQueries::performInsertQuery($sql);
                    }
                } else {
                    // TODO: dit kan ook in 1 query
                    //execute deletion query if exist but not selected
                    $sql = 'SELECT
                                *
                            FROM
                                function_points
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND ID_F = ' . $id_f . '
                                AND ID_KSP = ' . $ksp_row['ID_KSP'];
                    $chk_ifExistD = BaseQueries::performTransactionalSelectQuery($sql);

                    if (@mysql_num_rows($chk_ifExistD) > 0) {
                        $get_fpD = @mysql_fetch_assoc($chk_ifExistD);
                        //$ID_KSP .= $get_fpD[ID_FP].' <b><i>Delete '.$ksp_row[ID_KSP].' - '.$ksp_row[knowledge_skill_point].'</i></b><br>';
                        //delete
                        $sql = 'DELETE FROM
                                    function_points
                                WHERE
                                    customer_id = ' . CUSTOMER_ID . '
                                    AND ID_FP = ' . $get_fpD['ID_FP'];
                        BaseQueries::performDeleteQuery($sql);
                    }
                }
            }
            //update function name
            //$ID_KSP .='ID '.$id_f.' | update '.$function;
            $sql = 'UPDATE
                        functions
                    SET
                        function = "' . mysql_real_escape_string($function) . '"
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_F = ' . $id_f;
            BaseQueries::performUpdateQuery($sql);
            //$objResponse->assign('module_main_panel','innerHTML', $ID_KSP);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(moduleFunctions());
        }
    }
    return array($hasError, $message);
}


function moduleFunction_printJobProfile_deprecated($id_f)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
//        <form id="empPrintForm" method="POST" action="javascript:void(0);" onsubmit="empPrintProfileExecute();return false;">
        $html = '
        <form id="empPrintForm" method="POST" action="javascript:void(0);" onsubmit="return false;">
            <input type="hidden" value="3" name="op">
            <table border="0" width="600" cellspacing="0" cellpadding="0" align="center" class="border1px">
                <tr>
                    <td>
                        <div class="mod_employees_empPrint">
                            <table width="100%" border="0" cellspacing="3" cellpadding="0">
                                <tr>
                                    <td width="30%">
                                        <strong>' . TXT_UCF('OPTIONS') . '</strong>
                                    </td>
                                    <td>
                                        <strong>' . TXT_UCF('PROFILES') . '</strong> (<span style="font-size:smaller;">' . TXT_UCF('CTRL_CLICK_TO_SELECT_MULTIPLE_JOB_PROFILES') . '</span>)
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border1px">
                                        <input type="radio" name="option" value="1" checked> ' . TXT_UCF('NORMAL') . ' </input><br>
                                        <input type="radio" name="option" value="2"> ' . TXT_UCF('DETAILS') . ' </input>
                                    </td>
                                    <td class="border1px">
                                        <select name="function[]" id="function" size="20" style="width:100%" multiple="multiple">';
                                        $getFunc = FunctionQueriesDeprecated::getFunctions();
                                        if (@mysql_num_rows($getFunc) > 0) {
                                            $i = 1;
                                            while ($func_row = @mysql_fetch_assoc($getFunc)) {
                                                $selected = $func_row[ID_F] == $id_f ? 'selected' : '';
                                                $html .='
                                            <option value="' . $func_row[ID_F] . '" ' . $selected . '>' . $func_row['function'] . '</option>';
                                                $i++;
                                            }
                                        }
                                        $html .='
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </td>
                </tr>
            </table>
        </form>';
        $print_btns = '<input type="button" id="btnEmpPrint" value="&laquo; ' . TXT_BTN('BACK') . '" class="btn btn_width_80" onclick="xajax_moduleFunction_displayFunctionCompetence_deprecated(' . $id_f . ', ' . RESTORE_NAV_MENU . ');return false;">
                       <input type="button" id="btnEmpPrint" value="' . TXT_BTN('PRINT_PROFILE') . '" class="btn btn_width_80" onclick="xajax_moduleFunction_executePrintFunctions_deprecated(xajax.getFormValues(\'empPrintForm\')); return false;">';

        $objResponse->assign('mod_function_right', 'innerHTML', $html);
        $objResponse->assign('top_nav', 'innerHTML', $print_btns);
    }

    return $objResponse;
}

function moduleFunction_executePrintFunctions_deprecated($fForm)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isPrintAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        $total_text = '';
        foreach ($fForm['function'] as $value => $text) {
            $total_text = $total_text . $text . '*';
        }
        $_SESSION['func'] = $total_text;

        $objResponse->script('window.open(\'print/print_functions.php?c=' . $fForm['option'] . '&func[]=' . implode('&func[]=', $fForm['function']) . '\',\'\',\'resizable=yes,width=950,height=800\')');
    }

    return $objResponse;
}

?>