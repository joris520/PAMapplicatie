<?php

require_once('modules/common/moduleConsts.inc.php');
require_once('application/interface/InterfaceBuilder.class.php');

// DISPLAY COMPETENCE CATEGORY
function moduleCompetence($clearLastModule = false)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        if ($clearLastModule) {
            ApplicationNavigationService::clearLastModule();
        }
        ApplicationNavigationService::setCurrentApplicationModule(MODULE_COMPETENCES);

        $button_print_dictionary = InterfaceBuilder::IconButton('print_dictionary',
                                                            TXT_BTN('PRINT_DICTIONARY'),
                                                            'MM_openBrWindow(\'print/print_dictionary.php\',\'\',\'resizable=yes, width=800,height=800\');',
                                                            ICON_PRINT,
                                                            btn_width_150);
        $getks_data ='
        <div id="mode_competence">
            <table border="0" cellspacing="0" cellpadding="0" width="100%">
                <tr>
                    <td width="20%" class="left_panel" style="min-width:250px;">
                        <div id="titel" class="titel" style="text-align:right;width:20%;float:right">';
                        $getks_data .=
                        '</div>' . get_knowledge_skill_menu_deprecated(0) . '
                    </td>
                    <td width="80%">
                        <div class="top_nav" id="top_nav" style="float:left;">
                            ' . $button_print_dictionary . ' &nbsp;
                        </div>
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td>
                                    <div class="right_panel">
                                        <table border="0" cellspacing="0" cellpadding="0" width="99%">
                                            <tr>
                                                <td>
                                                    <div id="mod_competence_dict">
                                                        <div id="empPrint">
                                                            <p class="info-text">' .
                                                                TXT_UCF('ON_THIS_SCREEN_YOU_CAN_CREATE_OR_EDIT_COMPETENCES') . '.<br />' .
                                                                TXT_UCF('YOU_CAN_CHOOSE_FROM_THREE_CATEGORIES_JOB_SPECIFIC_PERSONAL_AND_MANAGERIAL') . '.<br />' .
                                                                TXT_UCF('INSIDE_A_CATEGORY_YOU_CAN_GROUP_COMPETENCES_LOGICALLY_BY_USING_CLUSTERS') . '.<br />
                                                            </p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>';
        $objResponse->assign('module_main_panel', 'innerHTML', $getks_data);
        $objResponse->assign('modules_menu_panel', 'innerHTML', ApplicationNavigationInterfaceBuilder::buildMenuForModule(MODULE_COMPETENCES));
    }
    return $objResponse;
}

// origineel
function get_knowledge_skill_menu_deprecated($ks_id)
{
    $sql = 'SELECT
                *
            FROM
                knowledge_skill
            ORDER BY
                ID_KS';

    $getks_result = BaseQueries::performQuery($sql);

    if (@mysql_num_rows($getks_result) == 0) {
        $html = '&nbsp;&nbsp;' . TXT_UCF('NO_COMPETENCE_CATEGORY_RETURN');
    } else {
        $html = '<div id="mod_competence_left">
                    <h1>' . TXT_UCF('CATEGORY') . '</h1>
                <table width="100%" cellspacing="0">';

        while ($ks_row = @mysql_fetch_assoc($getks_result)) {
            $ks_row_id = $ks_row['ID_KS'];
            $ks_row_label = CategoryConverter::display($ks_row['knowledge_skill']);
            if ($ks_row['ID_KS'] == $ks_id) {
                $bg_class = 'divLeftWbg';
            } else {
                $bg_class = 'divLeftRow';
            }
            $html .='<div class="dashed_line mod_competence_cat_left ' . $bg_class . '">
                        <a href="" onclick="xajax_moduleCompetence_showCluster_deprecated(0, '. $ks_row_id .');return false;">' . $ks_row_label . '</a>
                    </div>
                    <div class="dashed_line mod_competence_cat_right ' . $bg_class . '">&nbsp;</div>';
        }
        $html .='</table></div><!-- mod_competence_left -->';
    }
    return $html;
}


//DISPLAY CLUSTER LIST
function moduleCompetence_showCluster_deprecated($full, $ks_id, $ksc_id = null)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        $getks_data = '';

        $full = 1; // altijd alle clusters tonen!! TODO: aanroep aanpassen
        $fullClustered = ($full == 0) ? ' AND knowledge_skill_point IS NOT NULL' : '';
        $fullClustered .= ($ksc_id == null) ? '' : ' AND ksc.ID_C = ' . $ksc_id;
        $sql = 'SELECT
                    ksc.ID_C,
                    ksc.ID_KS,
                    ksc.cluster,
                    ksp.ID_KSP,
                    ksp.scale,
                    ksp.is_key,
                    ksp.is_cluster_main,
                    ksp.modified_by_user,
                    ksp.modified_date,
                    ksp.modified_time,
                    ksp.knowledge_skill_point as knowledge_skill_point
                FROM
                    knowledge_skill_cluster ksc
                    LEFT JOIN knowledge_skills_points ksp
                        ON ksp.ID_C = ksc.ID_C
                WHERE
                    ksc.customer_id = ' . CUSTOMER_ID . '
                    AND ksc.ID_KS = ' . $ks_id . '
                    ' . $fullClustered . '
                ORDER BY
                    cluster,
                    is_cluster_main DESC,
                    knowledge_skill_point';

        $compDbArray = MysqlUtils::getData($sql, true);

        if ($compDbArray) {
            $getks_data .= '<table border="0" cellpadding="1" cellspacing="0" width="100%">';
            $has_key_comps = false;
            $ksp_prefix = '';
            $showNextAsSub = 0;
            $ksc_param = empty($ksc_id) ? '' : ',' . $ksc_id;

            $clusterId = NULL;
            foreach ($compDbArray as $comp) {
                $actionCluster = '';
                $actionCompetence = '';

                $button_label =  ' ' . TXT_LC('CLUSTER') . ' ' . ModuleUtils::Abbreviate($comp['cluster'], DEFAULT_OPTION_ABBREVIATE);
                if (PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
                    $actionCluster .= InterfaceBuilder::IconButton('edit_cluster' . $comp['ID_C'],
                                                                    TXT_UCF('EDIT') . $button_label,
                                                                    'xajax_moduleCompetence_editCluster_deprecated(' . $comp['ID_C'] . ');',
                                                                    ICON_EDIT,
                                                                    NO_BUTTON_CLASS,
                                                                    FORCE_USE_ICON);
                }
                if (PermissionsService::isDeleteAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
                    $actionCluster .= InterfaceBuilder::IconButton('delete_cluster' . $comp['ID_C'],
                                                                    TXT_UCF('DELETE') . $button_label,
                                                                    'xajax_moduleCompetence_deleteCluster_deprecated(' . $ks_id . ', ' . $comp['ID_C'] . ');',
                                                                    ICON_DELETE,
                                                                    NO_BUTTON_CLASS,
                                                                    FORCE_USE_ICON);
                }
                if (! empty($comp[ID_KSP])) {
                    $button_label = ' ' . TXT_LC('COMPETENCE') . ' ' . ModuleUtils::Abbreviate($comp[knowledge_skill_point], DEFAULT_OPTION_ABBREVIATE);
                    if (PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
                        $actionCompetence .= InterfaceBuilder::IconButton('edit_competence' . $comp['ID_KSP'],
                                                                         TXT_UCF('EDIT') . $button_label,
                                                                         'xajax_moduleCompetence_editCompetence_deprecated(' . $comp['ID_KSP'] . ', ' . $ks_id . ', ' . $comp['ID_C'] . ');',
                                                                         ICON_EDIT,
                                                                         NO_BUTTON_CLASS,
                                                                         FORCE_USE_ICON);
                    }
                    if (PermissionsService::isDeleteAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
                        $actionCompetence .= InterfaceBuilder::IconButton('delete_competence' . $comp['ID_KSP'],
                                                                          TXT_UCF('DELETE') . $button_label,
                                                                          'xajax_moduleCompetence_deleteCompetence_deprecated(' . $comp['ID_KSP'] . ');',
                                                                          ICON_DELETE,
                                                                          NO_BUTTON_CLASS,
                                                                          FORCE_USE_ICON);
                    }
                }
                $oldclusterId = $clusterId;
                $clusterId = $comp['ID_C'];
                if ($clusterId <> $oldclusterId) {
                    $ksp_prefix = '';
                    $showNextAsSub = 0;

                    $getks_data .='
                        <tr>
                            <td class="shaded_title" colspan="3">
                                &nbsp;<strong>' . $comp['cluster'] . '</strong>
                            </td>
                            <td class="shaded_title" width="100px">
                                &nbsp;' . $actionCluster . '
                            </td>
                        </tr>';
                        if (! empty($comp[knowledge_skill_point])) {
                            $getks_data .='
                                <tr>
                                    <td width="5%">&nbsp;</td>
                                    <td>
                                        <strong>' . TXT_UCF('COMPETENCE') . '</strong>
                                    </td>
                                    <td>
                                        <strong>' . TXT_UCF('SCALE') . '</strong>
                                    </td>
                                    <td>&nbsp;</td>
                                </tr>';
                        }
                        //$td = '<td></td>';
    //                    $colspan = '';
    //                    $colspan2 = 'colspan="3"';
                }
                $knowledge_skill_name = $comp[knowledge_skill_point];
                if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                    if ($comp['is_cluster_main'] == COMPETENCE_CLUSTER_IS_MAIN) {
                        $cluster_main_style = ' class="shaded_title"';
                        //$additional_indicator .= SIGN_IS_MAIN_COMP;
                        $ksp_prefix = KSP_INDENT;
                        $showNextAsSub = 1;
                        $ksp_display_prefix = '';
                    } else {
                        $cluster_main_style = '';
                        $ksp_display_prefix = $ksp_prefix;
                    }
                }

                $key_comp = ($comp[is_key] == '1') ? SIGN_IS_KEY_COMP : SIGN_IS_NOT_KEY_COMP;
                $has_key_comps = $has_key_comps || ($comp[is_key] == '1');
                $showAsSub = ($showNextAsSub && $comp['is_cluster_main'] != COMPETENCE_CLUSTER_IS_MAIN) ? 1 : 0;

                if ( ! empty($comp[knowledge_skill_point])) {
                    $competence_link = $ksp_display_prefix . '<a href="" id="link' . $comp[ID_KSP] . '" onclick="xajax_moduleCompetence_showCompetenceDetail_deprecated(' . $comp[ID_KSP] . ',' . $showAsSub . ');return false;" title="' . TXT_UCF('VIEW_DETAILS') . '">' . $knowledge_skill_name . '</a>';
                } else {
                    $competence_link = TXT_UCF('NO_COMPETENCE_RETURN');
                }

                $getks_data .='
                            <tr>
                                <td>&nbsp;</td>
                                <td class="bottom_line" id="com1' . $comp[ID_KSP] . '">
                                    <table border="0" cellspacing="0" cellpadding="0">
                                        <tr ' . $cluster_main_style .'>
                                            <td>' . $key_comp . '</td>
                                            <td id="click' . $comp[ID_KSP] .'" >' .
                                                $competence_link
                                            . '</td>
                                        </tr>
                                    </table>
                                </td>
                                <td class="bottom_line" id="com2' . $comp[ID_KSP] . '">
                                    &nbsp;' . ModuleUtils::SkillNormText($comp[scale]) . '
                                </td>
                                <td class="bottom_line" width="" id="com3' . $comp[ID_KSP] . '">&nbsp;' . $actionCompetence . '</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3" id="compID' . $comp[ID_KSP] . '"></td>
                            </tr>';

            }
            $getks_data .='
                </table>';

            if ($has_key_comps) {
                $getks_data .= '<br />' .  TXT_UCF('NOTE') . ': '. SIGN_IS_KEY_COMP .'= ' . TXT_UCF('COLLECTIVE_KEY_COMPETENCE');
            }

            $getks_data .='<div id="logs" align="right"></div>';

            $sql = 'SELECT
                        modified_by_user,
                        modified_date,
                        modified_time
                    FROM
                        knowledge_skills_points
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                    ORDER BY
                        modified_date DESC';
            $lastModifiedQuery = BaseQueries::performQuery($sql);
            $last_modified = @mysql_fetch_assoc($lastModifiedQuery);
            $objResponse->call('xajax_moduleUtils_showLastModifiedInfo', $last_modified[modified_by_user], $last_modified[modified_date], $last_modified[modified_time]);
        }

        //TOP NAV
        $sql = 'SELECT
                    knowledge_skill
                FROM
                    knowledge_skill
                WHERE
                    ID_KS = ' . $ks_id;
        $categoryQuery = BaseQueries::performQuery($sql);

        $get_rks = @mysql_fetch_assoc($categoryQuery);

        $ks1 = CategoryConverter::display($get_rks['knowledge_skill']);

        if (PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
            $top_nav_btn .=
                InterfaceBuilder::IconButton('addNewCategory',
                                                TXT_BTN('ADD_NEW_CLUSTER_TO') . ' ' . $ks1,
                                                'xajax_moduleCompetence_addCluster_deprecated(' . $ks_id . ');',
                                                NO_ICON,
                                                'btn_width_180') .
                InterfaceBuilder::IconButton('addNewCompetence',
                                                TXT_BTN('ADD_COMPETENCE'),
                                                'xajax_moduleCompetence_addCompetence_deprecated(' . $ks_id . ');',
                                                NO_ICON,
                                                'btn_width_150');
        }

        if (PermissionsService::isPrintAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
            $button_print_dictionary .= InterfaceBuilder::IconButton('print_competences',
                                                                    TXT_BTN('PRINT_DICTIONARY'),
                                                                    'MM_openBrWindow(\'print/print_dictionary.php\',\'\',\'resizable=yes,width=800,height=800\');',
                                                                    NO_ICON,
                                                                    'btn_width_150');
            $top_nav_btn .= $button_print_dictionary .
                    InterfaceBuilder::IconButton('print_comprtences',
                                                TXT_UCW('PRINT_COMPETENCES'),
                                                'MM_openBrWindow(\'print/print_competences.php\',\'\',\'resizable=yes,width=800,height=800\');',
                                                NO_ICON,
                                                'btn_width_150');
        }

        // END TOP NAV USER VALIDATION
        //left nav category
        $categ .= get_knowledge_skill_menu_deprecated($ks_id);

        $objResponse->assign('mod_competence_dict', 'innerHTML', $getks_data);
        //$objResponse->assign('mod_competence_dict2','innerHTML', '');
        $objResponse->assign('cluster_nav', 'innerHTML', $cluster_nav);
        $objResponse->assign('top_nav', 'innerHTML', $top_nav_btn);
        $objResponse->assign('mod_competence_left', 'innerHTML', $categ);
    }
    return $objResponse;
}

//END DISPLAY COMPETENCE CLUSTER

function moduleCompetence_showCompetenceDetail_deprecated($id_ksp, $showAsSub) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        $sql = 'SELECT
                    ks.knowledge_skill,
                    CASE WHEN ksc.cluster is null
                         THEN "-"
                         ELSE ksc.cluster
                    END as cluster,
                    ksp.knowledge_skill_point,
                    ksp.description,
                    ksp.1none,
                    ksp.2basic,
                    ksp.3average,
                    ksp.4good,
                    ksp.5specialist,
                    ksp.scale,
                    ksp.modified_by_user,
                    ksp.modified_date,
                    ksp.modified_time
                FROM
                    knowledge_skills_points ksp
                    INNER JOIN knowledge_skill ks
                        ON ks.ID_KS = ksp.ID_KS
                    LEFT JOIN knowledge_skill_cluster ksc
                        ON ksc.ID_C = ksp.ID_C
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ksp.ID_KSP = ' . $id_ksp;
        $kspQuery = BaseQueries::performQuery($sql);
        $get_ksp = @mysql_fetch_assoc($kspQuery);
        $html = '<table width="100%" border="0" cellpadding="2" cellspacing="0" class="border1px">
        <tr>
                <td class="bottom_line shaded_title"><strong>' . TXT_UCF('CATEGORY') . ' : </strong></td>
                <td colspan="4" class="bottom_line shaded_title">' . CategoryConverter::display($get_ksp['knowledge_skill']) . '</td>
        </tr>
        <tr>
                <td class="bottom_line shaded_title"><strong>' . TXT_UCF('CLUSTER') . ' : </strong></td>
                <td colspan="4" class="bottom_line shaded_title">' . $get_ksp['cluster'] . '</td>
        </tr>
        <tr>
                <td class="bottom_line shaded_title"><strong>' . TXT_UCF('DESCRIPTION') . ' : </strong></td>
                <td colspan="4" class="bottom_line shaded_title">' . nl2br($get_ksp['description']) . '</td>
        </tr>';
            if ($get_ksp[scale] == ScaleValue::SCALE_1_5) {
            $html .= '<tr>
                <td class="bottom_line shaded_title" width="20%"><strong>[1] ' . SCALE_NONE . '</strong></td>
                <td class="bottom_line shaded_title" width="20%"><strong>[2] ' . SCALE_BASIC . '</strong></td>
                <td class="bottom_line shaded_title" width="20%"><strong>[3] ' . SCALE_AVERAGE . '</strong></td>
                <td class="bottom_line shaded_title" width="20%"><strong>[4] ' . SCALE_GOOD . '</strong></td>
                <td class="bottom_line shaded_title" width="20%"><strong>[5] ' . SCALE_SPECIALIST . '</strong></td>
            </tr>
            <tr>
                <td class="bottom_line shaded_title">' . nl2br($get_ksp['1none']) . '</td>
                <td class="bottom_line shaded_title">' . nl2br($get_ksp['2basic']) . '</td>
                <td class="bottom_line shaded_title">' . nl2br($get_ksp['3average']) . '</td>
                <td class="bottom_line shaded_title">' . nl2br($get_ksp['4good']) . '</td>
                <td class="bottom_line shaded_title">' . nl2br($get_ksp['5specialist']) . '</td>
            </tr>';
            } else if ($get_ksp[scale] == ScaleValue::SCALE_Y_N) {
            $html .= '<tr>
                            <td class="bottom_line shaded_title" width="20%"><strong>[' . ModuleUtils::ScoreNormLetter('Y') . '] ' . SCALE_YES . '</strong></td>
                <td class="bottom_line shaded_title" width="20%"><strong>[' . ModuleUtils::ScoreNormLetter('N') . '] ' . SCALE_NO . '</strong></td>
                <td class="bottom_line shaded_title" width="20%">&nbsp;</td>
                <td class="bottom_line shaded_title" width="20%">&nbsp;</td>
                <td class="bottom_line shaded_title" width="20%">&nbsp;</td>
            </tr>';
            }
            $log_id = 'logs2_' . $id_ksp;
            $html .=  '<tr><td colspan="5" class="shaded_title"><div id="' . $log_id . '" align="right"></div></td></tr>
            </table>';
        $ksp = $get_ksp[knowledge_skill_point];
        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
            $ksp_display_prefix = ($showAsSub != 1) ?  '' : KSP_INDENT;
        }

        $objResponse->call('xajax_moduleUtils_showLastModifiedInfo2', $log_id, $get_ksp['modified_by_user'], $get_ksp['modified_date'], $get_ksp['modified_time']);
        $objResponse->assign('click' . $id_ksp, 'innerHTML', $ksp_display_prefix . '<a href="" id="link' . $id_ksp . '" onclick="xajax_moduleCompetence_clickCompetenceHide_deprecated(' . $id_ksp . ', \'' . $get_ksp[knowledge_skill_point] . '\',' . $showAsSub . ');return false;" title="' . TXT_UCF('HIDE_DETAILS') . '" class="activated" style="font-weight:bold;">' . $ksp . '</a>');
        $objResponse->assign('compID' . $id_ksp, 'innerHTML', $html);
    }
    return $objResponse;
}

function moduleCompetence_clickCompetenceHide_deprecated($id_ksp, $ksp, $showAsSub) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
            $ksp_display_prefix = ($showAsSub != 1) ? '' : KSP_INDENT;
        }
        $objResponse->assign('click' . $id_ksp, 'innerHTML', $ksp_display_prefix . '<a href="" id="link' . $id_ksp . '" onclick="xajax_moduleCompetence_showCompetenceDetail_deprecated(' . $id_ksp . ', ' . $showAsSub . ');return false;" title="' . TXT_UCF('VIEW_DETAILS') . '">' . $ksp . '</a>');
        $objResponse->assign('compID' . $id_ksp, 'innerHTML', '');
    }
    return $objResponse;
}

//ADD cluster
function moduleCompetence_addCluster_deprecated($id_ks) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_COMPETENCES__ADD_CLUSTER_DEPRECATED);

        $safeFormHandler->addStringInputFormatType('cluster');
        $safeFormHandler->storeSafeValue('id_ks', $id_ks);

        $safeFormHandler->finalizeDataDefinition();

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill
                WHERE
                    ID_KS=' . $id_ks;
        $get_ks_q = BaseQueries::performQuery($sql);
        $get_ks = @mysql_fetch_assoc($get_ks_q);
        $ks1 =  CategoryConverter::display($get_ks[knowledge_skill]);

        $competence = '
        <div id="mode_competence">
            <form id="clusterAddForm" name="clusterAddForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $competence .= $safeFormHandler->getTokenHiddenInputHtml();

        $competence .= '
                <p>' . TXT_UCW('ADD_NEW_CLUSTER_TO') . ' ' . $ks1 . ' "' . TXT_UCW('CATEGORY') . '"</p>
                <table width="100%" border="0" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                    <td width="20%" class="bottom_line">' . TXT_UCF('CATEGORY') . ' : </td>
                    <td width="80%">' . $ks1 . '</td>
                    </tr>
                    <tr>
                    <td>' . TXT_UCF('CLUSTER') . ' : </td>
                    <td><input name="cluster" type="text" id="cluster" size="30"></td>
                    </tr>
                </table>
                <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleCompetence_showCluster_deprecated(0, ' . $id_ks . ');return false;">
            </form>
        </div>';
        //$objResponse->assign('divRight','innerHTML', $competence);
        $objResponse->assign('mod_competence_dict', 'innerHTML', $competence);
    }
    return $objResponse;
}

//EXECUTE DB QUERY ADD_COMPETENCE
//function moduleCompetence_executeForm($competenceForm) {
//    return moduleCompetence_processForm($competenceForm);
//}
function checkValidCluster_deprecated($cluster_name, $cluster_id = null)
{
    $hasError = false;
    $message = '';

    if (empty($cluster_name)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_A_CLUSTER');
    } else {
        $filter_id = (!empty($cluster_id)) ? ' AND ID_C <> ' . $cluster_id : '';
        $sql = 'SELECT
                    cluster
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID .
                    $filter_id . '
                    AND LOWER(cluster) like LOWER("' . mysql_real_escape_string($cluster_name) . '")';

        $check_cluster_qry = BaseQueries::performSelectQuery($sql);

        if (@mysql_num_rows($check_cluster_qry) > 0) {
            $hasError = true;
            $message = TXT_UCF('CLUSTER_NAME_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_CLUSTER_NAME');
        }
    }
    return array($hasError, $message);
}

//VALIDATE ADD CLUSTER AND RETURN TO EXECUTE() WHEN VALIDATED
function competences_processSafeForm_AddCluster_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $cluster_name = trim($safeFormHandler->retrieveSafeValue('cluster'));
        list($hasError, $message) = checkValidCluster_deprecated($cluster_name);

        if (!$hasError) {
            $id_ks = $safeFormHandler->retrieveSafeValue('id_ks');

            $hasError = true;
            BaseQueries::startTransaction();

            // TODO: naar query object
            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'INSERT INTO
                        knowledge_skill_cluster
                        (   customer_id,
                            ID_KS,
                            cluster,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                            ' . CUSTOMER_ID . ',
                            ' . $id_ks . ',
                           "' . mysql_real_escape_string($cluster_name) . '",
                           "' . $modified_by_user . '",
                           "' . $modified_time . '",
                           "' . $modified_date . '"
                        )';
            BaseQueries::performInsertQuery($sql);

            BaseQueries::finishTransaction();
            $hasError = false;

             // TODO: anders
            $objResponse->loadCommands(moduleCompetence_showCluster_deprecated(0, $id_ks));
        }
    }
    return array($hasError, $message);
}

//ADD ANOTHER NEW COMPETENCE
function moduleCompetence_addCompetence_deprecated($ks_id, $cluster_id = null) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        // categeorie informatie ophalen
        $sql = 'SELECT
                    ID_KS,
                    knowledge_skill
                FROM
                    knowledge_skill
                WHERE
                    ID_KS = ' . $ks_id;
        $getks_q = BaseQueries::performQuery($sql);
        $getks = @mysql_fetch_assoc($getks_q);

        // alle competences binnen categorie ophalen ivm 'kopieer van' functionaliteit.
        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KS = ' . $ks_id . '
                ORDER BY
                    knowledge_skill_point';
        $get_competence_q = BaseQueries::performQuery($sql);

        $knowledge_skill = CategoryConverter::display($getks[knowledge_skill]);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_COMPETENCES__ADD_COMPETENCE_DEPRECATED);
        $safeFormHandler->storeSafeValue('id_ks', $getks['ID_KS']);
        //$safeFormHandler->storeSafeValue('id_c', $cluster_id);

        $safeFormHandler->addIntegerInputFormatType('ID_C');
        $safeFormHandler->addStringInputFormatType('competence');
        $safeFormHandler->addIntegerInputFormatType('is_key');
        $safeFormHandler->addStringInputFormatType('description');
        $safeFormHandler->addIntegerInputFormatType('is_na_allowed');
        $safeFormHandler->addStringInputFormatType('scale');
        $safeFormHandler->addStringInputFormatType('norm1');
        $safeFormHandler->addStringInputFormatType('norm2');
        $safeFormHandler->addStringInputFormatType('norm3');
        $safeFormHandler->addStringInputFormatType('norm4');
        $safeFormHandler->addStringInputFormatType('norm5');

        $safeFormHandler->finalizeDataDefinition();

        $competence = '
        <div id="mode_competence">
            <form id="competenceAddForm" name="competenceAddForm"onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $competence .= $safeFormHandler->getTokenHiddenInputHtml();

        $competence .= '
                <p>' . TXT_UCW('ADD_NEW_COMPETENCE') . '</p>
                <table width="100%%" border="0" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                        <td width="20%" class="bottom_line">' . TXT_UCF('CATEGORY') . ' : </td>
                        <td width="80%">' . $knowledge_skill . '</td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('CLUSTER') . ' : </td>
                        <td>
                            <div id="clusterSelect">';
                            $competence .= getClusterSelector_deprecated($getks[ID_KS], $cluster_id);
                            $competence .= '
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('COMPETENCE') . ' : </td>
                        <td>
                            <input name="competence" type="text" id="competence" size="30"> <br>' .
                            TXT_UCF('COPY_COMPETENCE_FROM') . ': <br />
                            <select name="copy_comp" onchange="xajax_moduleCompetence_copyCompetence_deprecated(this.options[this.selectedIndex].value);return false;">
                                <option value="0"> - ' . TXT_LC('SELECT') . ' - </option>';
                                if (@mysql_num_rows($get_competence_q) > 0) {
                                    while ($get_comp_row = @mysql_fetch_assoc($get_competence_q)) {
                                        $competence .= '
                                        <option value="' . $get_comp_row[ID_KSP] . '">' . ModuleUtils::Abbreviate($get_comp_row[knowledge_skill_point], DEFAULT_OPTION_ABBREVIATE) . '</option>';
                                    }
                                }
                            $competence .= '
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('KEY_COMPETENCE') . ' : </td>
                        <td>
                            <input name="is_key" type="radio" value="1"> ' . TXT_UCF('YES') . '
                            <input name="is_key" type="radio" value="0" checked> ' . TXT_UCF('NO') . '
                        </td>
                    </tr>
                    <tr>
                    <td class="bottom_line">' . TXT_UCF('DESCRIPTION') . ' : </td>
                    <td><textarea name="description" cols="40" rows="5" id="description"></textarea></td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('IS_NA_ALLOWED') . ' : </td>
                        <td>
                            <div id="is_na_allowed_choice">
                                <input name="is_na_allowed" type="radio" value="1" checked="checked">' . TXT_UCF('YES') . '
                                <input name="is_na_allowed" type="radio" value="0" >' . TXT_UCF('NO') . '
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('SCALE') . ' : </td>
                        <td>
                            <!--onchange="xajax_moduleCompetence_selectControlScaleAddmode_deprecated(this.options[this.selectedIndex].value);return false;"-->
                            <select name="scale" id="scale" onchange="xajax_moduleCompetence_selectControlScaleAddmode_deprecated(this.options[this.selectedIndex].value);return false;">
                                <option value="0"> - ' . TXT_LC('SELECT') . ' - </option>
                                <option value="' . ScaleValue::SCALE_1_5 . '">1-5</option>
                                <option value="' . ScaleValue::SCALE_Y_N . '">' . TXT('Y_N') . '</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="scale_div"></div>
                        </td>
                    </tr>
                </table>
                <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleCompetence_showCluster_deprecated(0, ' . $ks_id . ');return false;">
            </form>
        </div>';
        $dict = '
        <div id="scale_legend">
            <p>&nbsp; ' . TXT_UCF('SCALE') . '</p>
            &nbsp; <strong>[1]-</strong>' . SCALE_NONE . ' <br>
            &nbsp; <strong>[2]-</strong>' . SCALE_BASIC . ' <br>
            &nbsp; <strong>[3]-</strong>' . SCALE_AVERAGE . ' <br>
            &nbsp; <strong>[4]-</strong>' . SCALE_GOOD . ' <br>
            &nbsp; <strong>[5]-</strong>' . SCALE_SPECIALIST . ' <br>
            &nbsp; <strong>[' . TXT('Y_N') . ']-</strong>' . SCALE_YES . '/' . SCALE_NO . '
        </div>';
        //$objResponse->assign('divRight','innerHTML', $competence);
        $objResponse->assign('mod_competence_dict', 'innerHTML', $competence);
        $objResponse->assign('mod_competence_dict2', 'innerHTML', $dict);
    }
    return $objResponse;
}

function moduleCompetence_copyCompetence_deprecated($id_ksp) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points
                WHERE
                    ID_KSP = ' . $id_ksp;
        $getc_q = BaseQueries::performQuery($sql);
        $getc = @mysql_fetch_assoc($getc_q);

        if ($getc['scale'] == ScaleValue::SCALE_1_5) {
            $scale_div = '<table border="0" width="100%%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                <td width="20%" align="center" class="bottom_line">1<br />' . SCALE_NONE . '</td>
                <td width="80%"><textarea name="norm1" cols="40" rows="3" id="norm1">' . $getc['1none'] . '</textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">2<br />' . SCALE_BASIC . '</td>
                <td><textarea name="norm2" cols="40" rows="3" id="norm2">' . $getc['2basic'] . '</textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">3<br />' . SCALE_AVERAGE . '</td>
                <td><textarea name="norm3" cols="40" rows="3" id="norm3">' . $getc['3average'] . '</textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">4<br />' . SCALE_GOOD . '</td>
                <td><textarea name="norm4" cols="40" rows="3" id="norm4">' . $getc['4good'] . '</textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">5<br />' . SCALE_SPECIALIST . '</td>
                <td><textarea name="norm5" cols="40" rows="3" id="norm5">' . $getc['5specialist'] . '</textarea></td>
                </tr>
                </table>';
            $objResponse->assign('scale_div', 'innerHTML', $scale_div);
            $objResponse->assign('scale', 'selectedIndex', '1');
        } elseif ($getc['scale'] == ScaleValue::SCALE_Y_N) {
            $objResponse->assign('scale_div', 'innerHTML', '');
            $objResponse->assign('scale', 'selectedIndex', '2');
        } else {
            $objResponse->assign('scale_div', 'innerHTML', '');
            $objResponse->assign('scale', 'selectedIndex', '0');
        }

        $is_na_allowed_Yes = $getc[is_na_allowed] != '0' ? 'checked' : '';
        $is_na_allowed_No  = $getc[is_na_allowed] == '0' ? 'checked' : '';

        $is_na_allowed_input = '<input name="is_na_allowed" type="radio" value="1" ' . $is_na_allowed_Yes . '>' . TXT_UCF('YES') .
                            '<input name="is_na_allowed" type="radio" value="0" ' . $is_na_allowed_No .  '>' . TXT_UCF('NO') ;

        $objResponse->assign('is_na_allowed_choice', 'innerHTML', $is_na_allowed_input);
        $objResponse->assign('clusterSelect', 'innerHTML', getClusterSelector_deprecated($getc['ID_KS'], $getc['ID_C']));

        $objResponse->assign('competence', 'value', $getc[knowledge_skill_point]);
        $objResponse->assign('description', 'value', $getc[description]);
    }
    return $objResponse;
}

function moduleCompetence_selectControlScaleEditmode_deprecated($scale, $id_ksp) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $id_ksp;
        $getc_q = BaseQueries::performQuery($sql);
        $getc = @mysql_fetch_assoc($getc_q);

        //$objResponse->alert($scale);
        if ($scale == ScaleValue::SCALE_1_5) {
            $scale_div = '
            <table border="0" width="100%%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                    <td width="20%" align="center" class="bottom_line">1<br />' . SCALE_NONE . '</td>
                    <td width="47%">
                        <textarea name="norm1" cols="40" rows="3" id="norm1">' . $getc['1none'] . '</textarea>
                    </td>
                <tr>
                    <td align="center" class="bottom_line">2<br />' . SCALE_BASIC . '</td>
                    <td>
                        <textarea name="norm2" cols="40" rows="3" id="norm2" >' . $getc['2basic'] . '</textarea>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="bottom_line">3<br />' . SCALE_AVERAGE . '</td>
                    <td>
                        <textarea name="norm3" cols="40" rows="3" id="norm3">' . $getc['3average'] . '</textarea>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="bottom_line">4<br />' . SCALE_GOOD . '</td>
                    <td>
                        <textarea name="norm4" cols="40" rows="3" id="norm4">' . $getc['4good'] . '</textarea>
                    </td>
                </tr>
                <tr>
                    <td align="center" class="bottom_line">5<br />' . SCALE_SPECIALIST . '</td>
                    <td>
                        <textarea name="norm5" cols="40" rows="3" id="norm5">' . $getc['5specialist'] . '</textarea>
                    </td>
                </tr>
            </table>';
            $objResponse->assign('scale_div', 'innerHTML', $scale_div);
            $objResponse->assign('scale_legend', 'style.visibility', 'visible');
        } else {
//        if ($scale == ScaleValue::SCALE_Y_N) {
            $scale_div = '';
            $objResponse->assign('scale_div', 'innerHTML', $scale_div);
            $objResponse->assign('scale_legend', 'style.visibility', 'hidden');
        }
    }
    return $objResponse;
}

function moduleCompetence_selectControlScaleAddmode_deprecated($scale) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        //$objResponse->alert($scale);
        if ($scale == ScaleValue::SCALE_1_5 || $scale == '-4') {
            $scale_div = '
            <table border="0" width="100%%" border="0" cellspacing="0" cellpadding="2">
                <tr>
                <td width="20%" align="center" class="bottom_line">1<br />' . SCALE_NONE . '</td>
                <td width="80%"><textarea name="norm1" cols="40" rows="3" id="norm1"></textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">2<br />' . SCALE_BASIC . '</td>
                <td><textarea name="norm2" cols="40" rows="3" id="norm2"></textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">3<br />' . SCALE_AVERAGE . '</td>
                <td><textarea name="norm3" cols="40" rows="3" id="norm3"></textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">4<br />' . SCALE_GOOD . '</td>
                <td><textarea name="norm4" cols="40" rows="3" id="norm4"></textarea></td>
                </tr>
                <tr>
                <td align="center" class="bottom_line">5<br />' . SCALE_SPECIALIST . '</td>
                <td><textarea name="norm5" cols="40" rows="3" id="norm5"></textarea></td>
                </tr>
            </table>';
            $objResponse->assign('scale_div', 'innerHTML', $scale_div);
            $objResponse->assign('scale_legend', 'style.visibility', 'visible');
        } elseif ($scale == ScaleValue::SCALE_Y_N) {
            $objResponse->assign('scale_div', 'innerHTML', '');
            $objResponse->assign('scale_legend', 'style.visibility', 'hidden');
        }
    }
    return $objResponse;
}

//EXECUTE DB QUERY ADD_NEW_COMPETENCE
//function competences_processSafeForm_addCompetence_deprecated($competenceForm) {
//    return moduleCompetence_processNewForm($competenceForm);
//}

function checkValidCompetence_deprecated($category_id,
                                         $cluster_id,
                                         $competence,
                                         $description,
                                         $scale,
                                         $norm1,
                                         $norm2,
                                         $norm3,
                                         $norm4,
                                         $norm5,
                                         $competence_id =  null)
{
    $hasError = false;
    $message = '';
    // TODO: controle op onterecht gewijzigde scale
    if (empty($competence)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_A_COMPETENCE');
    } elseif (empty($description)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_ENTER_A_DESCRIPTION');
    } elseif(empty($cluster_id)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
    } elseif (empty($scale)) {
        $hasError = true;
        $message = TXT_UCF('PLEASE_SELECT_A_SCALE');
    } elseif (($scale == ScaleValue::SCALE_Y_N) &&
              (!empty($norm1) ||
               !empty($norm2) ||
               !empty($norm3) ||
               !empty($norm4) ||
               !empty($norm5))) {
        $hasError = true;
        $message = TXT_UCF('SCALE_INVALID_WHEN_YOU_SELECT_A_SCALE_Y_N_PLEASE_EMPTY_ALL_FIELDS_1_2_3_4_5');
    } else {
        $sql = 'SELECT
                    count(*) as counted
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KS = ' . $category_id . '
                    AND ID_C = ' . $cluster_id . '
                ORDER BY
                    cluster';
        $get_cluster = BaseQueries::performSelectQuery($sql);
        $cluster_count = @mysql_fetch_assoc($get_cluster);
        if ($cluster_count['counted'] == 0) {
            $hasError = true;
            $message = TXT_UCF('PLEASE_SELECT_A_CLUSTER');
        } else {
            // controleer bestaande competentienaam
            $filter_ksp = !empty($competence_id) ? ' AND ID_KSP <> ' . $competence_id :  '';
            $sql = 'SELECT
                        knowledge_skill_point
                    FROM
                        knowledge_skills_points
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND LOWER(knowledge_skill_point) like LOWER("' . mysql_real_escape_string($competence) . '")' .
                        $filter_ksp;
            $get_cn = BaseQueries::performSelectQuery($sql);
            if (@mysql_num_rows($get_cn) > 0) {
                $hasError = true;
                $message = TXT_UCF('COMPETENCE_NAME_ALREADY_EXISTS_PLEASE_ENTER_A_NEW_COMPETENCE_NAME');
            }
        }
    }

    return array($hasError, $message);
}

//VALIDATE ADD NEW COMPETENCE AND RETURN TO EXECUTE_NEW_FORM() WHEN VALIDATED
function competences_processSafeForm_addCompetence_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    $message = '';
    if (PermissionsService::isAddAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        // retrieve
        $id_ks = $safeFormHandler->retrieveSafeValue('id_ks');

        $id_c = $safeFormHandler->retrieveInputValue('ID_C');
        $competence = trim(($safeFormHandler->retrieveInputValue('competence')));
        $description = $safeFormHandler->retrieveInputValue('description');
        $scale = $safeFormHandler->retrieveInputValue('scale');
        $is_na_allowed = $safeFormHandler->retrieveInputValue('is_na_allowed');
        $is_key = $safeFormHandler->retrieveInputValue('is_key');
        $norm1 = $safeFormHandler->retrieveInputValue('norm1');
        $norm2 = $safeFormHandler->retrieveInputValue('norm2');
        $norm3 = $safeFormHandler->retrieveInputValue('norm3');
        $norm4 = $safeFormHandler->retrieveInputValue('norm4');
        $norm5 = $safeFormHandler->retrieveInputValue('norm5');

        // validatie

        list($hasError, $message) = checkValidCompetence_deprecated($id_ks,
                                                                    $id_c,
                                                                    $competence,
                                                                    $description,
                                                                    $scale,
                                                                    $norm1,
                                                                    $norm2,
                                                                    $norm3,
                                                                    $norm4,
                                                                    $norm5);

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            $sql = 'INSERT INTO
                        knowledge_skills_points
                        (   customer_id,
                            ID_KS,
                            ID_C,
                            knowledge_skill_point,
                            description,
                            is_key,
                            scale,
                            1none,
                            2basic,
                            3average,
                            4good,
                            5specialist,
                            is_na_allowed,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES (
                             ' . CUSTOMER_ID . ',
                             ' . $id_ks . ',
                             ' . $id_c . ',
                            "' . mysql_real_escape_string($competence) . '",
                            "' . mysql_real_escape_string($description) . '",
                             ' . $is_key . ',
                            "' . mysql_real_escape_string($scale) . '",
                            "' . mysql_real_escape_string($norm1) . '",
                            "' . mysql_real_escape_string($norm2) . '",
                            "' . mysql_real_escape_string($norm3) . '",
                            "' . mysql_real_escape_string($norm4) . '",
                            "' . mysql_real_escape_string($norm5) . '",
                             ' . $is_na_allowed . ',
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '"
                        )';
            BaseQueries::performInsertQuery($sql);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(moduleCompetence_showCluster_deprecated(0, $id_ks));
        }
    }
    return array($hasError, $message);
}

//EDIT COMPETENCE
function moduleCompetence_editCompetence_deprecated($id_ksp, $id_ks, $id_c) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        $sql = 'SELECT
                    ks.knowledge_skill,
                    ksp.*
                FROM
                    knowledge_skill ks
                    INNER JOIN knowledge_skills_points ksp
                        ON ks.ID_KS = ksp.ID_KS
                WHERE
                    ksp.customer_id = ' . CUSTOMER_ID . '
                    AND ks.ID_KS = ' . $id_ks . '
                    AND ksp.ID_KSP = ' . $id_ksp;
        $competenceQuery = BaseQueries::performQuery($sql);

        $getCom = @mysql_fetch_assoc($competenceQuery);

        if ($getCom['scale'] == ScaleValue::SCALE_Y_N) {
            $scale1 = 'selected="selected"';
        }
        if ($getCom['scale'] == ScaleValue::SCALE_1_5) {
            $scale2 = 'selected="selected"';
        }
        $scale = $getCom['scale'] == ScaleValue::SCALE_1_5 ? 'scale1' : 'scale2';

        $is_keyYes = $getCom[is_key] == '1' ? 'checked' : '';
        $is_keyNo  = $getCom[is_key] == '0' ? 'checked' : '';

        $is_na_allowed_Yes = $getCom[is_na_allowed] == '1' ? 'checked' : '';
        $is_na_allowed_No  = $getCom[is_na_allowed] == '0' ? 'checked' : '';

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_COMPETENCES__EDIT_COMPETENCE_DEPRECATED);
        $safeFormHandler->storeSafeValue('id_ksp', $id_ksp);

        $safeFormHandler->addIntegerInputFormatType('ID_KS');
        $safeFormHandler->addIntegerInputFormatType('ID_C');
        $safeFormHandler->addStringInputFormatType('competence');
        $safeFormHandler->addIntegerInputFormatType('is_key');
        $safeFormHandler->addStringInputFormatType('description');
        $safeFormHandler->addIntegerInputFormatType('is_na_allowed');
        $safeFormHandler->addStringInputFormatType('scale');
        $safeFormHandler->addStringInputFormatType('norm1');
        $safeFormHandler->addStringInputFormatType('norm2');
        $safeFormHandler->addStringInputFormatType('norm3');
        $safeFormHandler->addStringInputFormatType('norm4');
        $safeFormHandler->addStringInputFormatType('norm5');
        //$safeFormHandler->storeSafeValue('id_ks', $id_ks);

        $safeFormHandler->finalizeDataDefinition();


        $competence .= '
            <div id="mode_competence">

                <form id="competenceEditForm" name="competenceEditForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $competence .= $safeFormHandler->getTokenHiddenInputHtml();

        $competence .= '
                <p>' . TXT_UCF('UPDATE_COMPETENCE') . '</p>
                <!--<input type="hidden" name="ID_KSP" value="' . $id_ksp . '">-->
                <!--<input type="hidden" name="ID_KS" value="' . $id_ks . '">-->
                <table width="90%" border="0" cellspacing="0" cellpadding="2" class="border1px">
                    <tr>
                        <td width="30%" class="bottom_line">' . TXT_UCF('CATEGORY') . ' : </td>
                        <td width="70%">';

                            //begin display category
                            $sql = 'SELECT
                                        *
                                    FROM
                                        knowledge_skill
                                    ORDER BY
                                        ID_KS';
                            $categoryQuery = BaseQueries::performQuery($sql);

                            $competence .= '
                                <select name="ID_KS" onchange="xajax_moduleCompetence_displayClusterByCategory_deprecated(this.options[this.selectedIndex].value);return false;">';
                                while ($categ_r = @mysql_fetch_assoc($categoryQuery)) {
                                    $selected = $categ_r[ID_KS] == $id_ks ? 'selected' : '';
                                    $competence .= '
                                    <option value="' . $categ_r[ID_KS] . '" ' . $selected . '>' .
                                        CategoryConverter::display($categ_r[knowledge_skill]) . '
                                    </option>';
                                }
                                $competence .= '
                                </select>';
                                //end display category
                            $competence .='
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('CLUSTER'). ' : </td>
                        <td>
                            <div id="clusterSelect">';
                            $competence .= getClusterSelector_deprecated($id_ks, $id_c);
                            $competence .= '
                            </div>
                        </td>
                    </tr>';

                    $sql = 'SELECT
                                *
                            FROM
                                function_points
                            WHERE
                                customer_id = ' . CUSTOMER_ID . '
                                AND ID_KSP = ' . $id_ksp;
                    $functionPointsQuery = BaseQueries::performQuery($sql);
                    if (@mysql_num_rows($functionPointsQuery) > 0) {
                        $scale_disabled = 'disabled';
                        $scale_msg = '( ' . TXT_UCF('YOU_CANNOT_CHANGE_THIS_SCALE_THERE_ARE_JOB_PROFILES_AND_EMPLOYEES_CONNECTED_TO_THIS_SCALE') . ' ) <input type="hidden" name="scale" id="scale" value="' . $getCom[scale] . '">';
                    } else {
                        $scale_disabled = '';
                        $scale_msg = '';
                    }


                    $competence .= '
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('COMPETENCE') . ' : </td>
                        <td>
                            <input name="competence" type="text" id="competence" size="30" value="' . $getCom[knowledge_skill_point] . '">
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('KEY_COMPETENCE') . ' : </td>
                        <td>
                            <input name="is_key" type="radio" value="1" ' . $is_keyYes . '>' . TXT_UCF('YES') . '
                            <input name="is_key" type="radio" value="0" ' . $is_keyNo . '>' . TXT_UCF('NO') . '
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('DESCRIPTION') . ' : </td>
                        <td>
                            <textarea name="description" cols="40" rows="5" id="description">' . $getCom[description] . '</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('IS_NA_ALLOWED') . ' : </td>
                        <td>
                            <input name="is_na_allowed" type="radio" value="1" ' . $is_na_allowed_Yes . '>' . TXT_UCF('YES') . '
                            <input name="is_na_allowed" type="radio" value="0" ' . $is_na_allowed_No .  '>' . TXT_UCF('NO') . '
                        </td>
                    </tr>
                    <tr>
                        <td class="bottom_line">' . TXT_UCF('SCALE') . ' : </td>
                        <td>
                            <select name="scale" id="scale" ' . $scale_disabled . ' onchange="xajax_moduleCompetence_selectControlScaleEditmode_deprecated(\' . this.options[this.selectedIndex].value\', ' . $id_ksp . ');return false;">
                                <option value="' . ScaleValue::SCALE_1_5 . '" ' . $scale2 . '>1-5</option>
                                <option value="' . ScaleValue::SCALE_Y_N . '" ' . $scale1 . '>' . TXT('Y_N') . '</option>
                            </select> <em><span class="smalltext">' . $scale_msg . '</span></em>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <div id="scale_div"></div>
                        </td>
                    </tr>';
            $competence .= '
                </table>
                <input type="submit" id="submitButton" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                <input type="button" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleCompetence_showCluster_deprecated(0, ' . $id_ks . ');return false;">
                </form>
            </div><!-- id="mode_competence" -->';
            $dict = '<p>&nbsp; ' . TXT_UCF('SCALE') . '</p>
                    &nbsp; <strong>[1]-</strong>' . SCALE_NONE . ' <br>
                    &nbsp; <strong>[2]-</strong>' . SCALE_BASIC . ' <br>
                    &nbsp; <strong>[3]-</strong>' . SCALE_AVERAGE . ' <br>
                    &nbsp; <strong>[4]-</strong>' . SCALE_GOOD . ' <br>
                    &nbsp; <strong>[5]-</strong>' . SCALE_SPECIALIST . ' <br>
                    &nbsp; <strong>' . TXT('Y_N') . '-</strong>' . SCALE_YES . '/' . SCALE_NO . '';

        $objResponse->assign('mod_competence_dict', 'innerHTML', $competence);
        $objResponse->assign('mod_competence_dict2', 'innerHTML', $dict);
        $objResponse->call('xajax_moduleCompetence_selectControlScaleEditmode_deprecated(\'' . $getCom['scale'] . '\',' . $id_ksp . ')');

    }
    return $objResponse;
}

function getClusterSelector_deprecated($id_ks, $id_c)
{
    //display cluster
    $sql = 'SELECT
                *
            FROM
                knowledge_skill_cluster
            WHERE
                customer_id = ' . CUSTOMER_ID . '
                AND ID_KS=' . $id_ks . '
            ORDER BY
                cluster';
    $get_cluster = BaseQueries::performQuery($sql);

    $clusterSelector = '';

    if (@mysql_num_rows($get_cluster) > 0) {
        $clusterSelector .= '
        <select name="ID_C">';
        $has_cluster_selection = false;
        while ($cluster_r = @mysql_fetch_assoc($get_cluster)) {

            if ($cluster_r[ID_C] == $id_c) {
                $selected = 'selected';
                $has_cluster_selection = true;
            } else {
                $selected = '';
            }
            $clusterSelector .= '
            <option value="' . $cluster_r[ID_C] . '" ' . $selected . '>' . $cluster_r[cluster] . '</option>';
        }
    } else {
        $clusterSelector = TXT_UCF('NO_COMPETENCE_CLUSTERS_HAVE_BEEN_ADDED') . '.';
    }

//    $no_cluster_selected = $has_cluster_selection ? '' : 'selected';
//    $clusterSelector .= '
//        <option value="0"' . $no_cluster_selected  . '>' . TXT_UCF('NO_CLUSTER') . '</option>
//    </select>';
    ///end display cluster

    return $clusterSelector;
}

function moduleCompetence_displayClusterByCategory_deprecated($id_ks) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isViewAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KS = ' . $id_ks . '
                ORDER BY
                    cluster';
        $get_cluster = BaseQueries::performQuery($sql);

        $competence .= '<select name="ID_C">';
        while ($cluster_r = @mysql_fetch_assoc($get_cluster)) {

            $selected = $cluster_r['ID_C'] == $id_c ? 'selected' : '';
            $competence .= '<option value="' . $cluster_r['ID_C'] . '" ' . $selected . '>' . $cluster_r['cluster'] . '</option>';
        }
        $competence .= '</select>';
        $objResponse->assign('clusterSelect', 'innerHTML', $competence);
    }
    return $objResponse;
}

//EXECUTE THE EDITED COMPETENCE
//function competences_processSafeForm_editCompetence_deprecated($competenceForm) {
//    return moduleCompetence_processEditForm($competenceForm);
//}

//VALIDATE AND RETURN TO EDIT_EXECTUTE() WHEN VALIDATED
function competences_processSafeForm_editCompetence_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    $message = '';
    if (PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        // ophalen
        $competence_id = $safeFormHandler->retrieveSafeValue('id_ksp');
//        $current_scale = $safeFormHandler->retrieveSafeValue('current_scale');

        $id_c = $safeFormHandler->retrieveInputValue('ID_C');
        $id_ks = $safeFormHandler->retrieveInputValue('ID_KS');
        $id_ksp = $safeFormHandler->retrieveInputValue('id_ksp');
        $competence = trim($safeFormHandler->retrieveInputValue('competence'));
        $description = $safeFormHandler->retrieveInputValue('description');
        $scale = $safeFormHandler->retrieveInputValue('scale');
        $is_key = $safeFormHandler->retrieveInputValue('is_key');
        $is_na_allowed = $safeFormHandler->retrieveInputValue('is_na_allowed');
        $norm1 = $safeFormHandler->retrieveInputValue('norm1');
        $norm2 = $safeFormHandler->retrieveInputValue('norm2');
        $norm3 = $safeFormHandler->retrieveInputValue('norm3');
        $norm4 = $safeFormHandler->retrieveInputValue('norm4');
        $norm5 = $safeFormHandler->retrieveInputValue('norm5');

        // valideren
        list($hasError, $message) = checkValidCompetence_deprecated($id_ks,
                                                                    $id_c,
                                                                    $competence,
                                                                    $description,
                                                                    $scale,
                                                                    $norm1,
                                                                    $norm2,
                                                                    $norm3,
                                                                    $norm4,
                                                                    $norm5,
                                                                    $competence_id);

        // verwerken
        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            //update query
            $sql = 'UPDATE
                        knowledge_skills_points
                    SET
                        ID_C = ' . $id_c . ',
                        ID_KS = ' . $id_ks . ',
                        knowledge_skill_point = "' . mysql_real_escape_string($competence) . '",
                        description = "' . mysql_real_escape_string($description) . '",
                        is_key = ' . $is_key . ',
                        scale = "' . mysql_real_escape_string($scale) . '",
                        1none = "' . mysql_real_escape_string($norm1) . '",
                        2basic = "' . mysql_real_escape_string($norm2) . '",
                        3average = "' . mysql_real_escape_string($norm3) . '",
                        4good = "' . mysql_real_escape_string($norm4) . '",
                        5specialist = "' . mysql_real_escape_string($norm5) . '",
                        is_na_allowed = ' . $is_na_allowed. ',
                        modified_by_user = "' . $modified_by_user . '",
                        modified_time = "' . $modified_time . '",
                        modified_date = "' . $modified_date . '"
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_KSP = ' . $id_ksp;

            BaseQueries::performUpdateQuery($sql);

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(moduleCompetence_showCluster_deprecated(0, $id_ks));
        }
    }
    return array($hasError, $message);
}

//EDIT COMPETENCE CATEGORY
function moduleCompetence_editCluster_deprecated($id_c) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_COMPETENCES__EDIT_CLUSTER_DEPRECATED);

        $safeFormHandler->addStringInputFormatType('cluster');
        $safeFormHandler->addIntegerInputFormatType('ID_KS');
        $safeFormHandler->addIntegerInputFormatType('is_cluster_main_ksp', true);
        $safeFormHandler->storeSafeValue('id_c', $id_c);

        $safeFormHandler->finalizeDataDefinition();

        $sql = 'SELECT
                    *
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $id_c;
        $competenceClusterQuery = BaseQueries::performQuery($sql);
        $getCat = @mysql_fetch_assoc($competenceClusterQuery);

        $competence .= '
        <div id="mode_competence">
            <form id="clusterEditForm" name="clusterEditForm" onsubmit="submitSafeForm(\'' . $safeFormHandler->getFormIdentifier() . '\', this.name); return false;">';

        $competence .= $safeFormHandler->getTokenHiddenInputHtml();

        $competence .= '
                <p>' . TXT_UCW('UPDATE_CLUSTER') . '</p>
                <table width="100%" border="0" cellpadding="0" cellspacing="2">
                    <tr>
                        <td class="border1px">
                            <table width="100%" border="0" cellspacing="0" cellpadding="4">
                                <tr>
                                    <td width="25%" class="bottom_line">' . TXT_UCF('CATEGORY') . ' : </td>
                                    <td width="75%">';
                                    $sql = 'SELECT
                                                *
                                            FROM
                                                knowledge_skill
                                            ORDER BY
                                                ID_KS';
                                    $categoryQuery = BaseQueries::performQuery($sql);
                                    while ($get_ksrow = @mysql_fetch_assoc($categoryQuery)) {
                                        $checked = $get_ksrow[ID_KS] == $getCat[ID_KS] ? 'checked' : '';
                                        $ksl = CategoryConverter::display($get_ksrow[knowledge_skill]);
                                        $competence .='<input name="ID_KS" type="radio" value="' . $get_ksrow[ID_KS] . '" ' . $checked . '> ' . $ksl . ' ';
                                    }
                    $competence .= '</td>
                                </tr>
                                <tr>
                                    <td class="bottom_line">' . TXT_UCF('CLUSTER') . ' : </td>
                                    <td><input name="cluster" type="text" id="cluster" size="47" value="' . $getCat[cluster] . '"></td>
                                </tr>';
                    if (CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE) {
                        $competence .= '
                                <tr>
                                    <td class="bottom_line">' . TXT_UCF('CLUSTER_MAIN_COMPETENCE') . ' : </td>
                                    <td>';
                                    $sql = 'SELECT
                                                ksp.ID_KSP,
                                                ksp.knowledge_skill_point,
                                                ksp.is_cluster_main
                                            FROM
                                                knowledge_skills_points ksp
                                            WHERE
                                                ksp.customer_id = ' . CUSTOMER_ID . '
                                                AND ksp.ID_C = ' . $id_c . '
                                            ORDER BY
                                                ksp.knowledge_skill_point';
                                    $get_ksp_result = BaseQueries::performQuery($sql);

                                    $competence .= '
                                        <select name="is_cluster_main_ksp">';
                                    $competence .= '
                                            <option value="0">- ' . TXT_LC('SELECT') . ' -</option>';
                                            while ($ksp_row = @mysql_fetch_assoc($get_ksp_result)) {
                                                $selected = $ksp_row['is_cluster_main'] == 1 ? 'selected' : '';

                                                $competence .= '<option value="' . $ksp_row['ID_KSP'] . '" ' . $selected . '>' . ModuleUtils::Abbreviate($ksp_row['knowledge_skill_point'], DEFAULT_OPTION_ABBREVIATE) . '</option>';
                                    }
                                    $competence .= '</select>';

                        $competence .= '
                                    </td>
                                </tr>';
                    }
                    $competence .= '
                            </table>
                            <br />
                        </td>
                    </tr>
                </table>
                <input type="submit" id="submitButton" name="editbtn" value="' . TXT_BTN('SAVE') . '" class="btn btn_width_80">
                <input type="button" id="returnbtn" value="' . TXT_BTN('CANCEL') . '" class="btn btn_width_80" onclick="xajax_moduleCompetence_showCluster_deprecated(0, ' . $getCat[ID_KS] . ');return false;">
            </form>
        </div>';

        $objResponse->assign('mod_competence_dict', 'innerHTML', $competence);
        $objResponse->assign('mod_competence_dict2', 'innerHTML', '');
    }
    return $objResponse;
}

//EXECUTE AND VALIDATE EDITED COMPETENCE CATEGORY
//function competences_processSafeForm_editCluster_deprecated($competenceCatForm) {
//    return moduleCompetence_processEditCatForm($competenceCatForm);
//}

//WHEN EXECUTED UPDATE DB QUERY
function competences_processSafeForm_editCluster_deprecated($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PermissionsService::isEditAllowed(PERMISSION_COMPETENCES_LIBRARY)) {

        $id_c = $safeFormHandler->retrieveSafeValue('id_c');
        $cluster_name = $safeFormHandler->retrieveInputValue('cluster');
        $id_ks = $safeFormHandler->retrieveSafeValue('ID_KS');
        $id_main_ksp = $safeFormHandler->retrieveSafeValue('is_cluster_main_ksp');

        list($hasError, $message) = checkValidCluster_deprecated($cluster_name, $id_c);

        if (!$hasError) {

            $hasError = true;
            BaseQueries::startTransaction();

            $modified_by_user = USER;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;

            //update query
            $sql = 'UPDATE
                        knowledge_skill_cluster
                    SET
                        ID_KS = ' . $id_ks . ',
                        cluster = "' . mysql_real_escape_string($cluster_name) . '",
                        modified_by_user = "' . $modified_by_user . '",
                        modified_time = "' . $modified_time . '",
                        modified_date = "' . $modified_date . '"
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_C  = ' . $id_c;
            BaseQueries::performUpdateQuery($sql);

            // update competences too
            // hbd: WAAROM MOET DAT NU WEER???
            $sql = 'UPDATE
                        knowledge_skills_points
                    SET
                        ID_KS = ' . $id_ks . '
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_C = ' . $id_c;
            BaseQueries::performUpdateQuery($sql);

            // eerst alles uitzetten...
            $sql = 'UPDATE
                        knowledge_skills_points
                    SET
                        is_cluster_main = ' . COMPETENCE_CLUSTER_IS_NORMAL . '
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_C = ' . $id_c . '
                        AND is_cluster_main = 1';
            BaseQueries::performUpdateQuery($sql);

            // dan geselecterde aanzetten...
            if (!empty($id_main_ksp) && $id_main_ksp > 0) {
                $sql = 'UPDATE
                            knowledge_skills_points
                        SET
                            is_cluster_main = ' . COMPETENCE_CLUSTER_IS_MAIN . '
                        WHERE
                            customer_id = ' . CUSTOMER_ID . '
                            AND ID_C = ' . $id_c . '
                            AND ID_KSP = ' . $id_main_ksp . '
                        LIMIT 1';
                BaseQueries::performUpdateQuery($sql);
            }

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->loadCommands(moduleCompetence_showCluster_deprecated(0, $id_ks));
        }
    }
    return array($hasError, $message);
}

//DELETE CLUSTER
function moduleCompetence_deleteCluster_deprecated($id_ks, $id_c)
{
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        try {
            $sql = 'SELECT
                        *
                    FROM
                        knowledge_skills_points
                    WHERE
                        customer_id = ' . CUSTOMER_ID . '
                        AND ID_KS = ' . $id_ks . '
                        AND ID_C = ' . $id_c;
            $competenceQuery = BaseQueries::performSelectQuery($sql);

            if (@mysql_num_rows($competenceQuery) > 0) {
                $objResponse->confirmCommands(1, TXT_UCF('YOU_CANNOT_DELETE_THIS_CLUSTER_WHILE_THERE_ARE_COMPETENCE_S_CONNECTED_TO_IT'));
                $objResponse->call("xajax_moduleCompetence_showCluster_deprecated", 0, $id_ks);
            } else {
                $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_CLUSTER'));
                $objResponse->call("xajax_moduleCompetence_executeDeleteCluster_deprecated", $id_ks, $id_c);
            }
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException);
        }
    }
    return $objResponse;
}

//EXECUTE DELETE CLUSTEr
function moduleCompetence_executeDeleteCluster_deprecated($id_ks, $id_c) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        $sql = 'DELETE
                FROM
                    knowledge_skill_cluster
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_C = ' . $id_c;
        BaseQueries::performQuery($sql);
        return moduleCompetence_showCluster_deprecated(0, $id_ks);
    }
    return $objResponse;
}

//DELETE COMPETENCE
function moduleCompetence_deleteCompetence_deprecated($id_ksp) {
    $sql = 'SELECT
                ID_KS,
                knowledge_skill_point
            FROM
                knowledge_skills_points
            WHERE
                customer_id = ' . CUSTOMER_ID . '
                AND ID_KSP = ' . $id_ksp;
    $competenceQuery = BaseQueries::performQuery($sql);
    $getksp = @mysql_fetch_assoc($competenceQuery);
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        $objResponse->confirmCommands(1, TXT_UCF('ARE_YOU_SURE_YOU_WANT_TO_DELETE_THIS_COMPETENCE'));
        $objResponse->call("xajax_moduleCompetence_executeDeleteCompetence_deprecated", $id_ksp, $getksp[ID_KS]);
    }
    return $objResponse;
}

//EXECUTE DELETE COMPETENCE
function moduleCompetence_executeDeleteCompetence_deprecated($id_ksp, $id_ks) {
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PermissionsService::isDeleteAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        $sql = 'DELETE
                FROM
                    employees_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $id_ksp;
        BaseQueries::performQuery($sql);

        $sql = 'DELETE
                FROM
                    function_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP = ' . $id_ksp;
        BaseQueries::performQuery($sql);

        $sql = 'DELETE
                FROM
                    knowledge_skills_points
                WHERE
                    customer_id = ' . CUSTOMER_ID . '
                    AND ID_KSP= '  . $id_ksp;
        BaseQueries::performQuery($sql);
        return moduleCompetence_showCluster_deprecated(0, $id_ks);
    }
    return $objResponse;
}

?>