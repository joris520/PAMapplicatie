<?php
require_once('application/model/service/UserLoginService.class.php');
require_once('modules/model/service/upload/LogoService.class.php');
require_once('modules/model/service/upload/PhotoContent.class.php');

require_once('modules/interface/state/TotalScoreEditType.class.php');

function buildSysAdminMenu()
{
    global $smarty;
    $user_level_name = UserLevelConverter::display(UserLevelValue::CUSTOMER_ADMIN);
    $tpl = $smarty->createTemplate('navigation/applicationMenuCustomers.tpl');
    $tpl->assign('USER', stripslashes(USER));
    $tpl->assign('USER_LEVEL_NAME', $user_level_name);
    $tpl->assign('COMPANY_NAME', COMPANY_NAME);
    return $smarty->fetch($tpl);
}

function moduleCustomers_displayCustomers() {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminLevel()) {
        unset($_SESSION['editcid']);
        $tab_html = '
            <table border="0" align="center" width="100%" cellspacing="0" cellpadding="0">
                <tr>
                    <td class="bottom_border1px" width="50%">&nbsp;</td>
                    <td><img src="images/' . IMG_URL . 'h_left.gif"></td>
                    <td class="nav_hborder"><a href="" onclick="xajax_moduleCustomers_displayCustomers();return false;">KLANTEN</a></td>
                    <td><img src="images/' . IMG_URL . 'h_right.gif"></td>
                    <td class="bottom_border1px" width="50%">&nbsp;</td>
                </tr>
            </table>';

        $html .='
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td class="left_panel" width="20%">';
                $cust_q = "SELECT * FROM customers WHERE customers.customer_id <> 0 ORDER BY customers.company_name";
                $cust_db = MysqlUtils::getData($cust_q, true);
                if ($cust_db) {
                    $html .='
                        <table border="0" cellspacing="0" cellpadding="0" width="100%">';
                        foreach ($cust_db as $cust) {
                            $html .='
                            <tr>
                                <td class="dashed_line mod_employees_cat_left divLeftRow">
                                    <a href="#" onclick="xajax_moduleCustomers_editCustomer(' . $cust[customer_id] . '); return false;">' . $cust[company_name] . '</a>
                                </td>
                                <td class="dashed_line mod_employees_cat_right divLeftRow">&nbsp;</td>
                            </tr>';
                        }
                        $html .='
                        </table>';
                } else {
                    $html .='Geen klanten gevonden';
                }

            $html .='
                </td>
                <td class="right_panel" width="80%">
                    <div id="top_nav" class="top_nav">
                        <input id="addCust" name="addCust" type="button" class="btn btn_width_150" value="Nieuwe klant toevoegen" onclick="xajax_moduleCustomers_addCustomer();return false;">
                    </div>
                    <div id="cust_body">
                        <br><br>';
            $html .= '<p><a href="#" onClick="if (confirm(\'Exporteren?\')) xajax_moduleCustomers_utils_exportCustomerLogosAndEmployeePhotosToEnvironment(); return false;">Exporteer alle klant logo\'s en pasfoto\'s vanuit de database naar de omgeving.</p>';
            $html .= '<br>
                    </div>
                </td>
            </tr>
        </table>';

        $objResponse->assign('modules_menu_panel', 'innerHTML', $tab_html);
        $objResponse->assign('module_main_panel', 'innerHTML', $html);
        $objResponse->assign('application_menu_panel', 'innerHTML', buildSysAdminMenu());
    }
    return $objResponse;
}

function moduleCustomers_editCustomer($customer_id)
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminLevel()) {

        $_SESSION['editcid'] = $customer_id;
        $sql = 'SELECT
                    username
                FROM
                    users
                WHERE
                    customer_id = ' . $customer_id . '
                    AND isprimary = 1
                LIMIT 1';
        $userNameResult = BaseQueries::performQuery($sql);
        $get_username = @mysql_fetch_assoc($userNameResult);

        $sql = 'SELECT
                    c.customer_id,
                    c.firstname,
                    c.lastname,
                    c.company_name,
                    c.email_address,
                    c.telephone,
                    c.theme_id,
                    c.lang_id,
                    c.logo,
                    c.num_employees,
                    co.*,
                    cl.*
                FROM
                    customers c
                    INNER JOIN customers_options co
                        ON c.customer_id = co.customer_id
                    INNER JOIN customers_labels cl
                        ON c.customer_id = cl.customer_id
                WHERE
                    c.customer_id = ' . $customer_id;

        $result = BaseQueries::performQuery($sql);
        $result_row = @mysql_fetch_assoc($result);

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_CUSTOMERS__EDIT_CUSTOMER);

        $safeFormHandler->storeSafeValue('customer_id', $customer_id);
        $safeFormHandler->storeSafeValue('cur_username', $get_username['username']);
        $safeFormHandler->storeSafeValue('customer_id', $customer_id);
        $safeFormHandler->addStringInputFormatType('company');
        $safeFormHandler->addStringInputFormatType('email');
        $safeFormHandler->addStringInputFormatType('num_employees');
        $safeFormHandler->addStringInputFormatType('firstname');
        $safeFormHandler->addStringInputFormatType('lastname');
        $safeFormHandler->addStringInputFormatType('telephone');
        $safeFormHandler->addStringInputFormatType('company_info');
        $safeFormHandler->addStringInputFormatType('use_score_status');
        $safeFormHandler->addStringInputFormatType('use_skill_notes');
        $safeFormHandler->addStringInputFormatType('show_skill_category');
        $safeFormHandler->addStringInputFormatType('show_skill_360');
        $safeFormHandler->addStringInputFormatType('show_360_remarks');
        $safeFormHandler->addStringInputFormatType('show_360_difference');
        $safeFormHandler->addStringInputFormatType('show_skill_norm');
        $safeFormHandler->addStringInputFormatType('show_skill_actions');
        $safeFormHandler->addStringInputFormatType('show_skill_weight');
        $safeFormHandler->addStringInputFormatType('show_score_as_norm_text');
        $safeFormHandler->addStringInputFormatType('show_generate_timeshot');
        $safeFormHandler->addStringInputFormatType('label_skill_result');
        $safeFormHandler->addStringInputFormatType('label_skill_360');
        $safeFormHandler->addStringInputFormatType('label_manager_remarks');
        $safeFormHandler->addStringInputFormatType('use_cluster_main_competence');
        $safeFormHandler->addStringInputFormatType('use_rating_dictionary');
        $safeFormHandler->addStringInputFormatType('required_emp_email');
        $safeFormHandler->addStringInputFormatType('allow_pdp_action_user_defined');
        $safeFormHandler->addStringInputFormatType('use_pdp_action_limit_action_owner');
        $safeFormHandler->addStringInputFormatType('use_final_result');
        $safeFormHandler->addStringInputFormatType('total_score_edit_type');
        $safeFormHandler->addStringInputFormatType('show_final_result_detail_scores');
        $safeFormHandler->addStringInputFormatType('use_employees_limit');
        $safeFormHandler->addIntegerInputFormatType('employees_limit_number');
        $safeFormHandler->addStringInputFormatType('show_score_status_icons');
        $safeFormHandler->addStringInputFormatType('use_employees_boss_filter');
        $safeFormHandler->addStringInputFormatType('use_employees_assessment_filter');
        $safeFormHandler->addStringInputFormatType('use_selfassessment');
        $safeFormHandler->addStringInputFormatType('use_selfassessment_process');
        $safeFormHandler->addStringInputFormatType('use_selfassessment_reminders');
        $safeFormHandler->addStringInputFormatType('allow_user_level_switch');
        $safeFormHandler->addStringInputFormatType('use_selfassessment_satisfaction_letter');
        $safeFormHandler->addStringInputFormatType('show_selfassessment_invitation_information');
        $safeFormHandler->addIntegerInputFormatType('selfassessment_validity_period');
        $safeFormHandler->addStringInputFormatType('show_360_eval_category_header');
        $safeFormHandler->addStringInputFormatType('show_360_eval_department');
        $safeFormHandler->addStringInputFormatType('show_360_eval_job_profile');
        $safeFormHandler->addStringInputFormatType('show_360_competence_details');
        $safeFormHandler->addStringInputFormatType('label_tab_scores');
        $safeFormHandler->addStringInputFormatType('label_tab_targets');
        $safeFormHandler->addStringInputFormatType('update_admin_account');
        $safeFormHandler->addStringInputFormatType('username');
        $safeFormHandler->addStringInputFormatType('password');
        $safeFormHandler->addStringInputFormatType('confirmpassword');

        $safeFormHandler->finalizeDataDefinition();

        $html = '&nbsp;
            <table>
            <tr><td>
            <form action="javascript:void(null);" id="frm_cust" name="frm_cust" onsubmit="submitSafeForm(\'' . SAFEFORM_CUSTOMERS__EDIT_CUSTOMER . '\', this.name); return false;">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
        <p style="margin:2px;">' . $title . '</p>
        <table width="650" border="0" cellspacing="2" cellpadding="2" class="border1px">
            <tr>
                <td style="width:50%; margin-bottom: 5px;"><strong>Klantinformatie</strong><br></td>
                <td></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Bedrijfsnaam:</td>
                <td><input type="text" size="35" id="company" name="company" value="' . $result_row['company_name'] . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Default (Admin) e-mail adres: </td>
                <td><input type="text" size="35" id="email" name="email" value="' . $result_row['email_address'] . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toegestane aantal medewerkers:</td>
                <td><input type="text" size="10" maxlength="5" id="num_employees" name="num_employees" value="' . $result_row['num_employees'] . '" style="width:40px;"  onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr>
                <td colspan="2"><br><strong>Contactpersoon</strong></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Voornaam: </td>
                <td ><input type="text" size="35" id="firstname" name="firstname" value="' . $result_row['firstname'] . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Achternaam: </td>
                <td><input type="text" size="35" id="lastname" name="lastname" value="' . $result_row['lastname'] . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">telefoonnummer: </td>
                <td><input type="text" size="30" id="telephone" name="telephone" value="' . $result_row['telephone'] . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>
        </table>

        <div id="open_customer_settings" style="margin-top: 20px; margin-bottom: 20px;">
            <a href="" onclick="javascript:showSettingsInDiv(\'edit_customer_settings\', \'open_customer_settings\'); return false;"><strong>Wijzing klant applicatie instellingen</strong></a>
        </div>

        <div id="edit_customer_settings" style="display:none; margin-top: 20px; margin-bottom: 20px;">
        <table width="650" border="0" cellspacing="2" cellpadding="2" class="border1px">

            <tr>
                <td style="width:50%;"><strong>Klant specifieke instellingen</strong></td>
                <td></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>Resultaat</em></strong></td>
            </tr>

            <tr>
            <td class="bottom_line inspring">Gebruik score status: </td>';
                $check_use_score_status = $result_row['use_score_status'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="use_score_status" name="use_score_status" ' . $check_use_score_status . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik opmerkingen: </td>';
                $check_use_skill_notes = $result_row['use_skill_notes'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="use_skill_notes" name="use_skill_notes" ' . $check_use_skill_notes . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon kolom Categorie: </td>';
                $check_show_skill_category = $result_row['show_skill_category'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_skill_category" name="show_skill_category" ' . $check_show_skill_category . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon kolom 360/zelfevaluatie: </td>';
                $check_show_skill_360 = $result_row['show_skill_360'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_skill_360" name="show_skill_360" ' . $check_show_skill_360 . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon kolom zelfevaluatie opmerkingen: </td>';
                $checked_show_360_remarks = $result_row['show_360_remarks'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_360_remarks" name="show_360_remarks" ' . $checked_show_360_remarks .  ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;" />&nbsp;<em>let op: check ook Toon kolom 360/zelfevaluatie</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon 360/zelfevaluatie afwijkingen van score: </td>';
                $checked_show_360_difference = $result_row['show_360_difference'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_360_difference" name="show_360_difference" ' . $checked_show_360_difference .  ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;" />&nbsp;<em>let op: check ook Toon kolom 360/zelfevaluatie</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon kolom norm: </td>';
                $check_show_skill_norm = $result_row['show_skill_norm'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_skill_norm" name="show_skill_norm" ' . $check_show_skill_norm . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon kolom aantal acties: </td>';
                $check_show_skill_actions = $result_row['show_skill_actions'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_skill_actions" name="show_skill_actions" ' . $check_show_skill_actions . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik weegfactor: </td>';
                $check_show_skill_weight = $result_row['show_skill_weight'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_skill_weight" name="show_skill_weight" ' . $check_show_skill_weight . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon Score als Norm tekst: </td>';
                $check_show_score_as_norm_text = $result_row['show_score_as_norm_text'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_score_as_norm_text" name="show_score_as_norm_text" ' . $check_show_score_as_norm_text . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="botton_line inspring">Toon "Genereer timeshot na opslaan": </td>';
                $check_show_generate_timeshot = $result_row['show_generate_timeshot'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_generate_timeshot" name="show_generate_timeshot" ' . $check_show_generate_timeshot .  ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;" /></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Label voor kolom Resultaat:</td>
                <td>
                    <select name="label_skill_result" id="label_skill_result" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;">
                        <option value="SCORE_DEFAULT_LABEL"'  .  ($result_row['define_mgr_score_label'] == 'SCORE_DEFAULT_LABEL' ? 'selected="selected"' : '') . '>Resultaat</option>
                        <option value="SCORE_COORD_LABEL"'  .  ($result_row['define_mgr_score_label'] == 'SCORE_COORD_LABEL' ? 'selected="selected"' : '') . '>Zorgcoord.</option>
                        <option value="SCORE_MANAGER_LABEL"'  .  ($result_row['define_mgr_score_label'] == 'SCORE_MANAGER_LABEL' ? 'selected="selected"' : '') . '>Manager</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Label voor kolom 360:</td>
                <td>
                    <select name="label_skill_360" id="label_skill_360" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;">
                        <option value="360_DEFAULT_LABEL"'  .  ($result_row['define_360_score_label'] == '360_DEFAULT_LABEL' ? 'selected="selected"' : '') . '>360</option>
                        <option value="360_EMPL_LABEL"'  .  ($result_row['define_360_score_label'] == '360_EMPL_LABEL' ? 'selected="selected"' : '') . '>medew.</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Label voor manager opmerkingen:</td>
                <td>
                    <select name="label_manager_remarks" id="label_manager_remarks" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;">
                        <option value="MANAGER_REMARKS"'  .  ($result_row['define_mgr_remarks_label'] == 'MANAGER_REMARKS' ? 'selected="selected"' : '') . '>Manager opmerkingen</option>
                        <option value="REMARKS"'  .  ($result_row['define_mgr_remarks_label'] == 'REMARKS' ? 'selected="selected"' : '') . '>Opmerkingen</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2"><br /><strong><em>Competenties</em></strong></td>
            </tr>


            <tr>
                <td class="bottom_line inspring">Gebruik cluster hoofdcompetentie: </td>';
                $check_use_cluster_main_competence = $result_row['use_cluster_main_competence'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="use_cluster_main_competence" name="use_cluster_main_competence" ' . $check_use_cluster_main_competence . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik weging woordenboek: </td>';
                $check_use_rating_dictionary = $result_row['use_rating_dictionary'] ? 'checked="checked"': '';
                $html .= '
                <td><input type="checkbox" id="use_rating_dictionary" name="use_rating_dictionary" ' . $check_use_rating_dictionary. ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;" /></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>Profiel</em></strong></td>
            </tr>

            <tr>
                <td class="bottom_line inspring">Medewerker e-mail verplicht: </td>';
                $check_required_emp_email = $result_row['required_emp_email'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="required_emp_email" name="required_emp_email" ' . $check_required_emp_email . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>POP acties</em></strong></td>
            </tr>

            <tr>
                <td class="bottom_line inspring">Eigen POP acties aanmaken: </td>';
                $check_allow_pdp_action_user_defined = $result_row['allow_pdp_action_user_defined'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="allow_pdp_action_user_defined" name="allow_pdp_action_user_defined" ' . $check_allow_pdp_action_user_defined . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Actie-eigenaar beperken: </td>';
                $check_use_pdp_action_limit_action_owner = $result_row['use_pdp_action_limit_action_owner'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="use_pdp_action_limit_action_owner" name="use_pdp_action_limit_action_owner" ' . $check_use_pdp_action_limit_action_owner . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>Eindoordeel</em></strong></td>
            </tr>

            <tr>
                <td class="bottom_line inspring">Gebruik medewerker eindoordeel: </td>';
                $check_use_final_result = $result_row['use_final_result'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="use_final_result" name="use_final_result" ' . $check_use_final_result . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <td class="bottom_line inspring">Eindoordeel score edit:</td>
                <td>
                    <select name="total_score_edit_type" id="total_score_edit_type" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;">
                        <option value="' . TotalScoreEditType::SELECT_LIST . '" '   . ($result_row['total_score_edit_type'] == TotalScoreEditType::SELECT_LIST ? 'selected="selected"' : '') . '>dropdown keuzelijst</option>
                        <option value="' . TotalScoreEditType::RADIO_BUTTONS . '" ' . ($result_row['total_score_edit_type'] == TotalScoreEditType::RADIO_BUTTONS ? 'selected="selected"' : '') . '>radiobuttons</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon eindoordeel detail scores: </td>';
                $check_show_final_result_detail_scores = $result_row['show_final_result_detail_scores'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_final_result_detail_scores" name="show_final_result_detail_scores" ' . $check_show_final_result_detail_scores . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>Medewerkers</em></strong></td>
            </tr>

            <tr>
                <td class="bottom_line inspring">Beperken zoekresultaten bij medewerkerlijst: </td>';
                $check_use_employees_limit = $result_row['use_employees_limit'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="use_employees_limit" name="use_employees_limit" ' . $check_use_employees_limit . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Aantal medewerkers bij beperking zoekresultaten: </td>';
                $employees_limit_number = empty($result_row['employees_limit_number']) ? APPLICATION_EMPLOYEES_LIMIT_NUMBER : $result_row['employees_limit_number'];
                $html .= '<td><input type="text" size="5" id="employees_limit_number" name="employees_limit_number" value="' . $employees_limit_number . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Beperk zoekresultaten bij medewerkerlijst</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon score status icoontjes: </td>';
                $check_show_score_status_icons = $result_row['show_score_status_icons'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="show_score_status_icons" name="show_score_status_icons" ' . $check_show_score_status_icons . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Gebruik score status</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik medewerkerlijst leidinggevende/afdeling/functie filter: </td>';
                $check_use_employees_boss_filter = $result_row['use_employees_boss_filter'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="use_employees_boss_filter" name="use_employees_boss_filter" ' . $check_use_employees_boss_filter . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik medewerkerlijst evaluatie filter: </td>';
                $check_use_employees_assessment_filter = $result_row['use_employees_assessment_filter'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="use_employees_assessment_filter" name="use_employees_assessment_filter" ' . $check_use_employees_assessment_filter . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>360/zelfevaluatie instellingen</em></strong></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik zelfevaluatie: </td>';
                $check_use_selfassessment = $result_row['use_selfassessment'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="use_selfassessment" name="use_selfassessment" ' . $check_use_selfassessment . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook medew. e-mail verplicht</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik zelfevaluatie proces: </td>';
                $check_use_selfassessment_process = $result_row['use_selfassessment_process'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="use_selfassessment_process" name="use_selfassessment_process" ' . $check_use_selfassessment_process . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik zelfevaluatie herinneringsmail: </td>';
                $check_use_selfassessment_reminders = $result_row['use_selfassessment_reminders'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="use_selfassessment_reminders" name="use_selfassessment_reminders" ' . $check_use_selfassessment_reminders . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Gebruik zelfevaluatie tevredenheidsbrief: </td>';
                $check_use_selfassessment_satisfaction_letter = $result_row['use_selfassessment_satisfaction_letter'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="use_selfassessment_satisfaction_letter" name="use_selfassessment_satisfaction_letter" ' . $check_use_selfassessment_satisfaction_letter . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Gebruik zelfevaluatie proces</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon extra zelfevaluatie uitnodigingsinformatie: </td>';
                $check_show_selfassessment_invitation_information = $result_row['show_selfassessment_invitation_information'] == '1' ? 'checked="checked"' : '';
                $html .= '<td><input type="checkbox" id="show_selfassessment_invitation_information" name="show_selfassessment_invitation_information" ' . $check_show_selfassessment_invitation_information . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Zelfevaluatie geldigheidsduur (<em>dagen</em>): </td>';
                $selfassessment_validity_period = empty($result_row['selfassessment_validity_period']) ? APPLICATION_DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS : $result_row['selfassessment_validity_period'];
                $html .= '<td><input type="text" size="5" id="selfassessment_validity_period" name="selfassessment_validity_period" value="' . $selfassessment_validity_period . '" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>360/zelfevaluatie formulier</em></strong></td>
            </tr>

            <tr>
                <td class="bottom_line inspring">Toon categorie in 360 evaluatieformulier: </td>';
                $check_show_360_eval_category_header = $result_row['show_360_eval_category_header'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_360_eval_category_header" name="show_360_eval_category_header" ' . $check_show_360_eval_category_header . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon afdeling in 360 evaluatieformulier: </td>';
                $check_show_360_eval_department = $result_row['show_360_eval_department'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_360_eval_department" name="show_360_eval_department" ' . $check_show_360_eval_department . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon functieprofiel in 360 evaluatieformulier: </td>';
                $check_show_360_eval_job_profile = $result_row['show_360_eval_job_profile'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_360_eval_job_profile" name="show_360_eval_job_profile" ' . $check_show_360_eval_job_profile . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Toon competentie details in 360 evaluatieformulier: </td>';
                $check_show_360_competence_details = $result_row['show_360_competence_details'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="show_360_competence_details" name="show_360_competence_details" ' . $check_show_360_competence_details . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>Medewerker Tab labels</em></strong></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Label voor Tab \'Resultaat\':</td>
                <td>
                    <select name="label_tab_scores" id="label_tab_scores" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;">
                        <option value="SCORE" '  .  ($result_row['define_score_tab_label'] == 'SCORE' ? 'selected="selected"' : '') . '>Resultaat</option>
                        <option value="TAB_BEHAVIOUR" '  .  ($result_row['define_score_tab_label'] == 'TAB_BEHAVIOUR' ? 'selected="selected"' : '') . '>Competenties</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Label voor Tab \'Taakdoelen\':</td>
                <td>
                    <select name="label_tab_targets" id="label_tab_targets" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;">
                        <option value="TARGETS"'  .  ($result_row['define_targets_tab_label'] == 'TARGETS' ? 'selected="selected"' : '') . '>Taakdoelen</option>
                        <option value="TAB_RESULTS"'  .  ($result_row['define_targets_tab_label'] == 'TAB_RESULTS' ? 'selected="selected"' : '') . '>Resultaten</option>
                    </select>
                </td>
            </tr>

            <tr>
                <td colspan="2"><br><strong><em>Gebruikers</em></strong></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Omschakelen naar medewerker rol:</td>';
                $check_allow_user_level_switch = $result_row['allow_user_level_switch'] == '1' ? 'checked="checked"' : '';
                $html .= '
                <td><input type="checkbox" id="allow_user_level_switch" name="allow_user_level_switch" ' . $check_allow_user_level_switch . ' onClick="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return true;"></td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
        </table>
        </div>';


        $sql = 'SELECT
                    user_id,
                    username
                FROM
                    users
                WHERE
                    customer_id = ' . $customer_id . '
                    AND isprimary = 1';

        $result = BaseQueries::performQuery($sql);
        $result_row = @mysql_fetch_assoc($result);

        $safeFormHandler->storeSafeValue('user_id', $result_row['user_id']);

        $safeFormHandler->finalizeDataDefinition();

        $html .= '
        <table width="650" border="0" cellspacing="2" cellpadding="2" class="border1px">
            <tr>
                <td style="width:50%;"><strong>Klant admin account</strong><br></td>
                <td></td>
            </tr>
            <tr>
                <td class="bottom_line inspring">Wijzig admin account gegevens: </td>
                <td><input type="checkbox" id="update_admin_account" name="update_admin_account" onClick="javascript:showCustomerAdminAccount(\'update_admin_account\');return false;" onChange="disableButton(\'inlogbtn\', \'eerst Opslaan\'); return false;"></td>
            </tr>
            <tr id="update_admin_account_username" style="display:none;">
                <td class="bottom_line inspring">Gebruikersnaam: </td>
                <td><input type="text" size="20" id="username" name="username" value="' . $get_username['username'] . '"></td>
            </tr>
            <tr id="update_admin_account_password1" style="display:none;">
                <td class="bottom_line inspring">Wachtwoord: </td>
                <td><input type="password" size="20" id="password" name="password" value=""=></td>
            </tr>
            <tr id="update_admin_account_password2" style="display:none;">
                <td class="bottom_line inspring">Bevestig wachtwoord: </td>
                <td><input type="password" size="20" id="confirmpassword" name="confirmpassword" value=""></td>
            </tr>
            <tr><td colspan="2">&nbsp;</td></tr>

        </table>
        <br>';
        $html .= '
        <input type="submit" value="Opslaan" class="btn btn_width_80" id="submitButton" />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="button" value="Inloggen als klant admin' /* . ': ' . $get_username['username']*/ . '" class="btn btn_width_150" id="inlogbtn" onclick="xajax_moduleCustomers_account(xajax.getFormValues(\'frm_cust\'));return false;" />
        <br /><br />';

        $html .= '
        <input type="checkbox" id="gino_xajax_debug" name="gino_xajax_debug"><label for="gino_xajax_debug"><em>Gino debug mode gebruiken</em></label>';

        $html .= '
        </form>
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <td>';


        $html .= '<table>
                        <tr>
                            <td><br /><input type="button" value="Verwijder klant" class="btn btn_width_150" id="deletebtn" onclick="xajax_moduleCustomers_deleteCustomer(' . $customer_id . ');return false;" /></td>
                        </tr>
                    </table>';

        $objResponse->assign('cust_body', 'innerHTML', $html);
    }

    return $objResponse;
}

function moduleCustomers_account($aFormValues) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminLevel()) {
        $username = mysql_real_escape_string(trim($aFormValues['username']));

        $customer_id = $_SESSION['editcid'];
        $sql = 'SELECT
                    username,
                    user_id
                FROM
                    users
                WHERE
                    username = "' . $username . '"
                    AND customer_id =  ' . $customer_id . '
                    AND isprimary = 1
                LIMIT 1';
        $userInfoQuery = BaseQueries::performQuery($sql);

        $hasError = true;
        if (@mysql_num_rows($userInfoQuery) == 1) {
            $hasError = false;
        } else {
            $objResponse->alert('Inloggen als klantenaccount lukt niet');
        }


        if (!$hasError) {

            $userInfo = @mysql_fetch_assoc($userInfoQuery);
            // hbd: we gaan inloggen als een andere gebruiker, dus nieuwe sessie starten
            $_SESSION = array();
            session_destroy();
            // hbd: aanmaken nieuwe sessieid
            session_start();
            session_regenerate_id(true);
            // hbd: gebruiker in sessie bewaren
            $user_name = $userInfo['username'];
            $user_id = $userInfo['user_id'];

            PamApplication::storeCurrentUser($user_name);
            $_SESSION['XAJAX_DEBUG_VIA_ADMIN'] = !empty($aFormValues['gino_xajax_debug']);

            $sql = 'UPDATE
                        users
                    SET
                        last_login = "' . MODIFIED_DATE . ' | ' . MODIFIED_TIME . '"
                    WHERE
                        user_id = ' . $user_id;
            BaseQueries::performQuery($sql);

            InterfaceXajax::reloadApplication($objResponse);
        } else {
            $objResponse->assign("submitButton", "disabled", false);
        }
    }

    return $objResponse;
}


function customers_safeProcessEditCustomer($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PamApplication::isSysAdminLevel()) {
        // begin fetching variables from $safeFormHandler object
        $customer_id = $safeFormHandler->retrieveSafeValue('customer_id');
        $cur_username = $safeFormHandler->retrieveSafeValue('cur_username');

        // input values
        $firstname = $safeFormHandler->retrieveInputValue('firstname');
        $lastname = $safeFormHandler->retrieveInputValue('lastname');
        $company = $safeFormHandler->retrieveInputValue('company');
        $email = $safeFormHandler->retrieveInputValue('email');
        $telephone = $safeFormHandler->retrieveInputValue('telephone');
        $company_info_text = $safeFormHandler->retrieveInputValue('company_info');
        $num_employees = $safeFormHandler->retrieveInputValue('num_employees');
        $use_skill_notes = $safeFormHandler->retrieveInputValue('use_skill_notes');
        $show_skill_category = $safeFormHandler->retrieveInputValue('show_skill_category');
        $show_skill_360 = $safeFormHandler->retrieveInputValue('show_skill_360');
        $show_skill_weight = $safeFormHandler->retrieveInputValue('show_skill_weight');
        $show_skill_norm = $safeFormHandler->retrieveInputValue('show_skill_norm');
        $show_generate_timeshot = $safeFormHandler->retrieveInputValue('show_generate_timeshot');
        $show_skill_actions = $safeFormHandler->retrieveInputValue('show_skill_actions');
        $show_score_as_norm_text = $safeFormHandler->retrieveInputValue('show_score_as_norm_text');
        $show_360_eval_category_header = $safeFormHandler->retrieveInputValue('show_360_eval_category_header');
        $show_360_eval_department = $safeFormHandler->retrieveInputValue('show_360_eval_department');
        $show_360_eval_job_profile = $safeFormHandler->retrieveInputValue('show_360_eval_job_profile');
        $show_360_competence_details = $safeFormHandler->retrieveInputValue('show_360_competence_details');
        $show_360_remarks = $safeFormHandler->retrieveInputValue('show_360_remarks');
        $show_360_difference = $safeFormHandler->retrieveInputValue('show_360_difference');
        $use_selfassessment = $safeFormHandler->retrieveInputValue('use_selfassessment');
        $use_selfassessment_process = $safeFormHandler->retrieveInputValue('use_selfassessment_process') ? 1 : 0;
        $use_selfassessment_reminders = $safeFormHandler->retrieveInputValue('use_selfassessment_reminders') ? 1 : 0;
        $allow_user_level_switch = $safeFormHandler->retrieveInputValue('allow_user_level_switch') ? 1 : 0;
        $use_selfassessment_satisfaction_letter = $safeFormHandler->retrieveInputValue('use_selfassessment_satisfaction_letter') ? 1 : 0;
        $show_selfassessment_invitation_information = $safeFormHandler->retrieveInputValue('show_selfassessment_invitation_information') ? 1 : 0;
        // TODO: check of dit zo werkt!?!?!
        $selfassessment_validity_period = $safeFormHandler->retrieveInputValue('selfassessment_validity_period') ? $safeFormHandler->retrieveInputValue('selfassessment_validity_period') : APPLICATION_DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS;
        $required_emp_email = $safeFormHandler->retrieveInputValue('required_emp_email');
        $allow_pdp_action_user_defined = $safeFormHandler->retrieveInputValue('allow_pdp_action_user_defined');
        $use_pdp_action_limit_action_owner = $safeFormHandler->retrieveInputValue('use_pdp_action_limit_action_owner');
        $use_final_result = $safeFormHandler->retrieveInputValue('use_final_result');
        $total_score_edit_type = $safeFormHandler->retrieveInputValue('total_score_edit_type');
        $show_final_result_detail_scores = $safeFormHandler->retrieveInputValue('show_final_result_detail_scores');
        $use_cluster_main_competence = $safeFormHandler->retrieveInputValue('use_cluster_main_competence');
        $use_rating_dictionary = $safeFormHandler->retrieveInputValue('use_rating_dictionary');
        $use_employees_limit = $safeFormHandler->retrieveInputValue('use_employees_limit');
        $employees_limit_number =  $safeFormHandler->retrieveInputValue('employees_limit_number') ? $safeFormHandler->retrieveInputValue('employees_limit_number') : APPLICATION_EMPLOYEES_LIMIT_NUMBER;
        $use_score_status = $safeFormHandler->retrieveInputValue('use_score_status') ? 1: 0;
        $show_score_status_icons = $safeFormHandler->retrieveInputValue('show_score_status_icons') ? 1: 0;
        $use_employees_boss_filter = $safeFormHandler->retrieveInputValue('use_employees_boss_filter') ? 1: 0;
        $use_employees_assessment_filter = $safeFormHandler->retrieveInputValue('use_employees_assessment_filter') ? 1: 0;

        $label_skill_result = $safeFormHandler->retrieveInputValue('label_skill_result');
        $label_skill_360 = $safeFormHandler->retrieveInputValue('label_skill_360');
        $label_tab_scores = $safeFormHandler->retrieveInputValue('label_tab_scores');
        $label_tab_targets = $safeFormHandler->retrieveInputValue('label_tab_targets');
        $label_manager_remarks = $safeFormHandler->retrieveInputValue('label_manager_remarks');
        $update_admin_account = $safeFormHandler->retrieveInputValue('update_admin_account');
        $username = $safeFormHandler->retrieveInputValue('username');
        $password = $safeFormHandler->retrieveInputValue('password');
        $confirmpassword = $safeFormHandler->retrieveInputValue('confirmpassword');
        // end fetching variables from $safeFormHandler object

        $company_info_text = htmlentities($company_info_text);
        $use_skill_notes = ($use_skill_notes) ? 1 : 0;
        $show_skill_category = ($show_skill_category) ? 1 : 0;
        $show_skill_360 = ($show_skill_360) ? 1 : 0;
        $show_skill_weight = ($show_skill_weight) ? 1 : 0;
        $show_skill_norm = ($show_skill_norm) ? 1 : 0;
        $show_generate_timeshot = ($show_generate_timeshot) ? 1 : 0;
        $show_skill_actions = ($show_skill_actions) ? 1 : 0;
        $show_score_as_norm_text = ($show_score_as_norm_text) ? 1 : 0;
        $show_360_eval_category_header = ($show_360_eval_category_header) ? 1 : 0;
        $show_360_eval_department = ($show_360_eval_department) ? 1 : 0;
        $show_360_eval_job_profile = ($show_360_eval_job_profile) ? 1 : 0;
        $show_360_competence_details = ($show_360_competence_details) ? 1 : 0;
        $show_360_remarks = ($show_360_remarks) ? 1 : 0;
        $show_360_difference = ($show_360_difference) ? 1 : 0;
        $use_selfassessment = ($use_selfassessment) ? 1 : 0;
        $required_emp_email = ($required_emp_email) ? 1 : 0;
        $allow_pdp_action_user_defined = ($allow_pdp_action_user_defined) ? 1 : 0;
        $use_pdp_action_limit_action_owner = ($use_pdp_action_limit_action_owner) ? 1 : 0;
        $use_final_result = ($use_final_result) ? 1 : 0;
        $show_final_result_detail_scores = ($show_final_result_detail_scores) ? 1 : 0;
        $use_cluster_main_competence = ($use_cluster_main_competence) ? 1 : 0;
        $use_rating_dictionary = ($use_rating_dictionary) ? 1 : 0;
        $use_employees_limit = ($use_employees_limit) ? 1 : 0;

        // validatie
        $hasError = false;
        if (empty($company)) {
            $hasError = true;
            $message = 'Bedrijfsnaam mag niet leeg zijn.';
        } elseif (empty($email)){
            $hasError = true;
            $message = 'E-mail mag niet leeg zijn.';
            $objResponse->script('xajax.$("email").focus();');
        } elseif (!PamValidators::IsEmailAddressValidFormat($email)) {
            $hasError = true;
            $message = 'Geen correct E-mail adres';
            $objResponse->script('xajax.$("email").focus();');
            $objResponse->assign('email', 'value', '');
        } elseif (empty($num_employees) || !is_numeric($num_employees)) { // dat doet het safeform al...
            $hasError = true;
            $message = 'Toegestane aantal medewerkers moet met een numerieke waarde gevuld worden.';
            $objResponse->assign('num_employees', 'value', '');
            $objResponse->script('xajax.$("num_employees").focus();');
        } elseif (empty($firstname)) {
            $hasError = true;
            $message = 'Voornaam mag niet leeg zijn.';
        } elseif (empty($lastname)) {
            $hasError = true;
            $message = 'Achternaam mag niet leeg zijn.';
        } elseif ($update_admin_account == "on") { // change admin account

            $sql = 'SELECT
                        username
                    FROM
                        users
                    WHERE
                        customer_id = ' . $customer_id . '
                        AND username = "' . mysql_real_escape_string($username) . '"
                        AND username <> "' . mysql_real_escape_string($cur_username) . '"';
            $usernameQuery = BaseQueries::performSelectQuery($sql);

            if (empty($username)) {
                $hasError = true;
                $message = 'Admin gebruikersnaam mag niet leeg zijn.';
            } elseif (!empty($username) && @mysql_num_rows($usernameQuery) > 0) {
                $hasError = true;
                $message = 'Gebruikersnaam is al in gebruik.';
            } elseif (!empty($username) && empty($password)) {
                $hasError = true;
                $message = 'Wachtwoord mag niet leeg zijn.';
            } elseif (!PamValidators::isPasswordValidFormat ($password)) {
                $hasError = true;
                $message = 'Wachtwoord moet minimaal 8 tekens lang zijn, en ten minste 1 kleine letter, 1 hoofdletter en 1 cijfer bevatten.';
                $objResponse->assign('password', 'value', '');
                $objResponse->script('xajax.$("password").focus();');
            } elseif (!empty($username) && trim($password) <> trim($confirmpassword)) {
                $hasError = true;
                $message = 'Bevestigde wachtwoord is niet gelijk aan Wachtwoord.';
                $objResponse->assign('confirmpassword', 'value', '');
                $objResponse->script('xajax.$("confirmpassword").focus();');
            }
        }

        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $sql = 'UPDATE
                        customers
                    SET
                        firstname = "' . mysql_real_escape_string($firstname) . '",
                        lastname = "' . mysql_real_escape_string($lastname) . '",
                        company_name = "' . mysql_real_escape_string($company) . '",
                        email_address = "' . mysql_real_escape_string($email) . '",
                        telephone = "' . mysql_real_escape_string($telephone) . '",
                        num_employees = ' . $num_employees . '
                    WHERE
                        customer_id =' . $customer_id;

            BaseQueries::performUpdateQuery($sql);

            $sql = 'UPDATE
                        customers_options
                    SET
                        use_skill_notes = ' . $use_skill_notes . ',
                        show_skill_category = ' . $show_skill_category . ',
                        show_skill_360 = ' . $show_skill_360 . ',
                        show_skill_weight = ' . $show_skill_weight . ',
                        show_skill_norm = ' . $show_skill_norm . ',
                        show_skill_actions = ' . $show_skill_actions . ',
                        show_score_as_norm_text = ' . $show_score_as_norm_text . ',
                        show_360_eval_category_header = ' . $show_360_eval_category_header . ',
                        show_360_eval_department = ' . $show_360_eval_department . ',
                        show_360_eval_job_profile = ' . $show_360_eval_job_profile . ',
                        show_360_competence_details = ' . $show_360_competence_details . ',
                        show_360_remarks = '. $show_360_remarks . ',
                        show_360_difference = '. $show_360_difference . ',
                        use_selfassessment = ' . $use_selfassessment . ',
                        use_selfassessment_process = ' . $use_selfassessment_process . ',
                        use_selfassessment_reminders = ' . $use_selfassessment_reminders . ',
                        use_selfassessment_satisfaction_letter = ' . $use_selfassessment_satisfaction_letter . ',
                        show_selfassessment_invitation_information = ' . $show_selfassessment_invitation_information . ',
                        selfassessment_validity_period = ' . $selfassessment_validity_period . ',
                        required_emp_email = ' . $required_emp_email . ',
                        use_final_result = ' . $use_final_result . ',
                        total_score_edit_type = ' . $total_score_edit_type . ',
                        show_final_result_detail_scores = ' . $show_final_result_detail_scores . ',
                        use_cluster_main_competence = ' . $use_cluster_main_competence . ',
                        use_rating_dictionary = ' . $use_rating_dictionary . ',
                        show_generate_timeshot = ' . $show_generate_timeshot. ',
                        use_employees_limit = ' . $use_employees_limit .  ',
                        employees_limit_number = ' . $employees_limit_number .  ',
                        use_score_status = ' . $use_score_status . ',
                        show_score_status_icons = ' . $show_score_status_icons . ',
                        use_employees_boss_filter = ' . $use_employees_boss_filter . ',
                        use_employees_assessment_filter = ' . $use_employees_assessment_filter . ',
                        allow_user_level_switch = ' . $allow_user_level_switch . ',
                        allow_pdp_action_user_defined = ' . $allow_pdp_action_user_defined . ',
                        use_pdp_action_limit_action_owner = ' . $use_pdp_action_limit_action_owner . '
                    WHERE
                        customer_id = ' . $customer_id . '
                    LIMIT 1';
            BaseQueries::performUpdateQuery($sql);

            $sql = 'UPDATE
                        customers_labels
                    SET
                        define_mgr_score_label = "' . mysql_real_escape_string($label_skill_result) . '",
                        define_360_score_label = "' . mysql_real_escape_string($label_skill_360) . '",
                        define_score_tab_label = "' . mysql_real_escape_string($label_tab_scores) . '",
                        define_targets_tab_label = "' . mysql_real_escape_string($label_tab_targets) . '",
                        define_mgr_remarks_label = "' . mysql_real_escape_string($label_manager_remarks) . '"
                    WHERE
                        customer_id = ' . $customer_id . '
                    LIMIT 1';
            BaseQueries::performUpdateQuery($sql);

            if ($update_admin_account == "on") {
                if (!empty($username)) {
                    $sql = 'UPDATE
                                users
                            SET
                                username = "' . mysql_real_escape_string($username) . '"
                            WHERE
                                customer_id = ' . $customer_id . '
                                AND isprimary =  ' . USER_PRIMARY_ADMIN;
                    BaseQueries::performUpdateQuery($sql);

                    $sql = 'SELECT
                                user_id
                            FROM
                                users
                            WHERE
                                customer_id = ' . $customer_id . '
                                AND isprimary = ' . USER_PRIMARY_ADMIN . '
                            LIMIT 1';
                    $sql_user_id_result = BaseQueries::performUpdateQuery($sql);

                    $sql_user_id_row = @mysql_fetch_assoc($sql_user_id_result);

                    UserLoginService::changePassword($sql_user_id_row['user_id'], $password, true, USER);
                }
            }

            BaseQueries::finishTransaction();
            $hasError = false;

            $objResponse->call('xajax_moduleCustomers_editCustomer', $customer_id);
        }
    }
    return array($hasError, $message);
}

function moduleCustomers_deleteCustomer($customer_id) {
    $objResponse = new xajaxResponse();

    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminLevel()) {
        $sql = 'SELECT
                    company_name
                FROM
                    customers
                WHERE
                    customer_id = ' . $customer_id;
        $customerQuery = BaseQueries::performQuery($sql);

        $get_c = @mysql_fetch_assoc($customerQuery);
        $objResponse->confirmCommands(2, 'Please make sure that you downloaded the Sign Off files. Are you sure you want to delete the customer ' . $get_c['company_name'] . '?');
        $objResponse->assign("deletebtn", "disabled", true);
        $objResponse->call("xajax_moduleCustomers_executeDeleteCustomer", $customer_id);
    }

    return $objResponse;
}

function deleteCustomerTable($customer_id, $table, $additional_where = null)
{
    error_log('deleteCustomerTable ' . $table);
    $sql = 'DELETE
            FROM
                ' . $table . '
            WHERE
                customer_id = ' . $customer_id . '
                ' . $additional_where;
            ;
    error_log('               done ' . $table);
    BaseQueries::performDeleteQuery($sql);
}

function moduleCustomers_executeDeleteCustomer($customer_id)
{
    $objResponse = new xajaxResponse();
    $hasError = executeDeleteCustomer_direct($objResponse, $customer_id);
    if (!$hasError) {
        $objResponse->loadCommands(moduleCustomers_displayCustomers());
    }
    return $objResponse;
}

function executeDeleteCustomer_direct($objResponse, $customer_id)
{
    $hasError = false;
    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminLevel()) {
        try {
            $hasError = deleteCustomerService($customer_id);
        } catch (TimecodeException $timecodeException) {
            PamExceptionProcessor::handleInterfaceException($objResponse, $timecodeException, 'VERWIJDEREN KLANTGEGEVENS NIET GELUKT');
        }
    }
    return $hasError;
}

// private
function deleteCustomerService($customer_id)
{
    $hasError = true; // bewijs maar dat het goed ging...
    error_log('DeleteCustomer: ' . $customer_id);
    BaseQueries::startTransaction();

    error_log('DeleteCustomer ' . 'users');
    // volgorde probleem met FK's voorkomen
    $sql = 'UPDATE
                employees
            SET
                boss_fid = NULL,
                id_contents = NULL
            WHERE
                customer_id = ' . $customer_id;
    BaseQueries::performUpdateQuery($sql);

    $sql = 'UPDATE
                customers
            SET
                id_contents = NULL
            WHERE
                customer_id = ' . $customer_id;
    BaseQueries::performUpdateQuery($sql);

    // deactivate users (remove passwords?)
    $sql = 'UPDATE
                users
            SET
                is_inactive = ' . USER_IS_DISABLED . '
            WHERE
                customer_id = ' . $customer_id;
    BaseQueries::performUpdateQuery($sql);

    // verwijderen van data in nieuwe tabellen (sprint 12)
    deleteCustomerTable($customer_id, 'boss_assessment_process');
    deleteCustomerTable($customer_id, 'employee_assessment');
    deleteCustomerTable($customer_id, 'employee_assessment_process');
    deleteCustomerTable($customer_id, 'employee_assessment_evaluation');
    deleteCustomerTable($customer_id, 'employee_assessment_final_result');
    deleteCustomerTable($customer_id, 'employee_assessment_question_answer');
    deleteCustomerTable($customer_id, 'employee_competence_score');
    deleteCustomerTable($customer_id, 'employee_job_profile_function');
    deleteCustomerTable($customer_id, 'employee_job_profile');
    deleteCustomerTable($customer_id, 'employee_target_data');
    deleteCustomerTable($customer_id, 'employee_target');

    deleteCustomerTable($customer_id, 'assessment_cycle');
    deleteCustomerTable($customer_id, 'assessment_question');
    deleteCustomerTable($customer_id, 'organisation_info');
    deleteCustomerTable($customer_id, 'standard_date');

    // alle tabellen leeggooien in de juiste volgorde
    deleteCustomerTable($customer_id, 'alerts');
    deleteCustomerTable($customer_id, 'employees_documents');
    deleteCustomerTable($customer_id, 'document_clusters');
    deleteCustomerTable($customer_id, 'document_contents');
    deleteCustomerTable($customer_id, 'employees_misc_answers');
    deleteCustomerTable($customer_id, 'employees_history_total_scores');
    deleteCustomerTable($customer_id, 'employees_history_points');
    deleteCustomerTable($customer_id, 'employees_history_misc_answers');
    deleteCustomerTable($customer_id, 'employees_history_points_date');
    deleteCustomerTable($customer_id, 'employees_objectives_eval');
    deleteCustomerTable($customer_id, 'employees_objectives');
    deleteCustomerTable($customer_id, 'employees_objective_period');
    deleteCustomerTable($customer_id, 'employees_pdp_tasks');
    deleteCustomerTable($customer_id, 'employees_pdp_actions');
    deleteCustomerTable($customer_id, 'employees_points');
    deleteCustomerTable($customer_id, 'employees_additional_functions');
    deleteCustomerTable($customer_id, 'employees_topics');
    deleteCustomerTable($customer_id, 'threesixty_evaluation');
    deleteCustomerTable($customer_id, 'threesixty_invitations');
    deleteCustomerTable($customer_id, 'threesixty_invitations_messages');
    deleteCustomerTable($customer_id, 'function_points');
    deleteCustomerTable($customer_id, 'knowledge_skills_points');
    deleteCustomerTable($customer_id, 'knowledge_skill_cluster');
    deleteCustomerTable($customer_id, 'notification_message');
    deleteCustomerTable($customer_id, 'notification360_message');
    deleteCustomerTable($customer_id, 'pdp_actions');
    deleteCustomerTable($customer_id, 'pdp_action_cluster');
    deleteCustomerTable($customer_id, 'pdp_task');
    deleteCustomerTable($customer_id, 'pdp_task_ownership');
    deleteCustomerTable($customer_id, 'scale');
    deleteCustomerTable($customer_id, 'user_level_module_access');
    deleteCustomerTable($customer_id, 'user_level');
    deleteCustomerTable($customer_id, 'users_department');
    deleteCustomerTable($customer_id, 'xajax_debug', ' OR ID_USER in (SELECT user_id FROM users where customer_id = ' . $customer_id . ')');
    deleteCustomerTable($customer_id, 'users');
    deleteCustomerTable($customer_id, 'employees');
    deleteCustomerTable($customer_id, 'functions');
    deleteCustomerTable($customer_id, 'ext');
    deleteCustomerTable($customer_id, 'person_data');
    deleteCustomerTable($customer_id, 'department');

    deleteCustomerTable($customer_id, 'customers_labels');
    deleteCustomerTable($customer_id, 'customers_options');
    deleteCustomerTable($customer_id, 'assessment_question');

    deleteCustomerTable($customer_id, 'customers');

    BaseQueries::finishTransaction();

    error_log('DeleteCustomer ' . 'removing files');

    // execute delete here
    //delete files and folders
    foreach (@glob("./user_logo/c" . $customer_id . "/*.*") as $filename) {
        @unlink($filename);
    }
    @rmdir('./user_logo/c' . $customer_id);
    //foreach (@glob("./uploads/" . $customer_id . "/*.*") as $filename) {
    foreach (@glob(PAM_BASE_DIR . "uploads/c" . $customer_id . "/*.*") as $filename) {
        @unlink($filename);
    }
    //@rmdir('./uploads/c' . $customer_id);
    @rmdir(PAM_BASE_DIR . '/uploads/c' . $customer_id);
    //end delete files and folders

    error_log('          done ' . 'removing files');

    // end execute delete here
    $hasError = false;
    error_log('DeleteCustomer: done ' . $customer_id);

    return $hasError;
}

function moduleCustomers_addCustomer()
{
    $objResponse = new xajaxResponse();
    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminLevel()) {
        $title = 'Toevoegen nieuwe klant';

        $safeFormHandler = SafeFormHandler::create(SAFEFORM_CUSTOMERS__ADD_CUSTOMER);

        $safeFormHandler->addStringInputFormatType('company');
        $safeFormHandler->addStringInputFormatType('email');
        $safeFormHandler->addStringInputFormatType('num_employees');
        $safeFormHandler->addStringInputFormatType('firstname');
        $safeFormHandler->addStringInputFormatType('lastname');
        $safeFormHandler->addStringInputFormatType('telephone');
        $safeFormHandler->addStringInputFormatType('use_score_status');
        $safeFormHandler->addStringInputFormatType('use_skill_notes');
        $safeFormHandler->addStringInputFormatType('show_skill_category');
        $safeFormHandler->addStringInputFormatType('show_skill_360');
        $safeFormHandler->addStringInputFormatType('show_360_remarks');
        $safeFormHandler->addStringInputFormatType('show_360_difference');
        $safeFormHandler->addStringInputFormatType('show_skill_norm');
        $safeFormHandler->addStringInputFormatType('show_skill_actions');
        $safeFormHandler->addStringInputFormatType('show_skill_weight');
        $safeFormHandler->addStringInputFormatType('show_score_as_norm_text');
        $safeFormHandler->addStringInputFormatType('show_generate_timeshot');
        $safeFormHandler->addStringInputFormatType('label_skill_result');
        $safeFormHandler->addStringInputFormatType('label_skill_360');
        $safeFormHandler->addStringInputFormatType('label_manager_remarks');
        $safeFormHandler->addStringInputFormatType('use_cluster_main_competence');
        $safeFormHandler->addStringInputFormatType('use_rating_dictionary');
        $safeFormHandler->addStringInputFormatType('required_emp_email');
        $safeFormHandler->addStringInputFormatType('allow_pdp_action_user_defined');
        $safeFormHandler->addStringInputFormatType('use_pdp_action_limit_action_owner');
        $safeFormHandler->addStringInputFormatType('use_final_result');
        $safeFormHandler->addStringInputFormatType('total_score_edit_type');
        $safeFormHandler->addStringInputFormatType('show_final_result_detail_scores');
        $safeFormHandler->addStringInputFormatType('use_employees_limit');
        $safeFormHandler->addIntegerInputFormatType('employees_limit_number');
        $safeFormHandler->addStringInputFormatType('show_score_status_icons');
        $safeFormHandler->addStringInputFormatType('use_employees_boss_filter');
        $safeFormHandler->addStringInputFormatType('use_employees_assessment_filter');
        $safeFormHandler->addStringInputFormatType('use_selfassessment');
        $safeFormHandler->addStringInputFormatType('use_selfassessment_process');
        $safeFormHandler->addStringInputFormatType('use_selfassessment_reminders');
        $safeFormHandler->addStringInputFormatType('allow_user_level_switch');
        $safeFormHandler->addStringInputFormatType('use_selfassessment_satisfaction_letter');
        $safeFormHandler->addStringInputFormatType('show_selfassessment_invitation_information');
        $safeFormHandler->addIntegerInputFormatType('selfassessment_validity_period');
        $safeFormHandler->addStringInputFormatType('show_360_eval_category_header');
        $safeFormHandler->addStringInputFormatType('show_360_eval_department');
        $safeFormHandler->addStringInputFormatType('show_360_eval_job_profile');
        $safeFormHandler->addStringInputFormatType('show_360_competence_details');
        $safeFormHandler->addStringInputFormatType('label_tab_scores');
        $safeFormHandler->addStringInputFormatType('label_tab_targets');
        $safeFormHandler->addStringInputFormatType('username');
        $safeFormHandler->addStringInputFormatType('password');
        $safeFormHandler->addStringInputFormatType('confirmpassword');

        $safeFormHandler->finalizeDataDefinition();

        $html = '
        <form id="custForm" name="custForm" method="post" action="javascript:void(0);" onsubmit="submitSafeForm(\'' . SAFEFORM_CUSTOMERS__ADD_CUSTOMER . '\', \'custForm\');">';

        $html .= $safeFormHandler->getTokenHiddenInputHtml();

        $html .= '
            <p style="margin:2px;">' . $title . '</p>
            <table width="800" border="0" cellspacing="2" cellpadding="2" class="border1px">
                <tr>
                    <td style="width:50%" colspan="2"><strong>Klantinformatie</strong><br></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Bedrijfsnaam:</td>
                    <td><input type="text" size="35" id="company" name="company"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Default (Admin) e-mail adres: </td>
                    <td><input type="text" size="35" id="email" name="email"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toegestane aantal medewerkers:</td>
                    <td><input type="text" size="10" maxlength="5" id="num_employees" name="num_employees" style="width:40px;"></td>
                </tr>
                <tr>
                    <td colspan="2"><br><strong>Contactpersoon</strong></td>
                </tr>
                <tr>
                    <td width="200" class="bottom_line inspring">Voornaam: </td>
                    <td width="300"><input type="text" size="35" id="firstname" name="firstname"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Achternaam: </td>
                    <td><input type="text" size="35" id="lastname" name="lastname"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">telefoonnummer: </td>
                    <td><input type="text" size="30" id="telephone" name="telephone"></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>';
            $html .= '
            </table>
            <table width="850" border="0" cellspacing="2" cellpadding="2" class="border1px" style="margin-top: 20px; margin-bottom: 20px;">
                <tr>
                    <td style="width:50%"><strong>Klant specifieke instellingen</strong></td>
                    <td></td>
                </tr>
                <tr>
                    <td colspan="2"><br><strong><em>Resultaat</em></strong></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik score status: </td>
                    <td><input type="checkbox" id="use_score_status" name="use_score_status"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik opmerkingen: </td>
                    <td><input type="checkbox" id="use_skill_notes" name="use_skill_notes" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon kolom Categorie: </td>
                    <td><input type="checkbox" id="show_skill_category" name="show_skill_category" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon kolom 360/zelfevaluatie: </td>
                    <td><input type="checkbox" id="show_skill_360" name="show_skill_360"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon kolom zelfevaluatie opmerkingen: </td>
                    <td><input type="checkbox" id="show_360_remarks" name="show_360_remarks" />&nbsp;<em>let op: check ook Toon kolom 360/zelfevaluatie</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon 360/zelfevaluatie afwijkingen van score: </td>
                    <td><input type="checkbox" id="show_360_difference" name="show_360_difference" />&nbsp;<em>let op: check ook Toon kolom 360/zelfevaluatie</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon kolom norm: </td>
                    <td><input type="checkbox" id="show_skill_norm" name="show_skill_norm" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon kolom aantal acties: </td>
                    <td><input type="checkbox" id="show_skill_actions" name="show_skill_actions" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik weegfactor: </td>
                    <td><input type="checkbox" id="show_skill_weight" name="show_skill_weight"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon Score als Norm tekst: </td>
                    <td><input type="checkbox" id="show_score_as_norm_text" name="show_score_as_norm_text"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon "Genereer timeshot na opslaan": </td>
                    <td><input type="checkbox" id="show_generate_timeshot" name="show_generate_timeshot" checked="checked" /></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Label voor kolom Resultaat: </td>
                    <td>
                        <select name="label_skill_result" id="label_skill_result">
                            <option value="SCORE_DEFAULT_LABEL" >Resultaat</option>
                            <option value="SCORE_COORD_LABEL" >Zorgcoord.</option>
                        </select>
                    </td>
                </tr>
                <tr>
                <td class="bottom_line inspring">Label voor kolom 360: </td>
                    <td>
                        <select name="label_skill_360" id="label_skill_360">
                            <option value="360_DEFAULT_LABEL" >360</option>
                            <option value="360_EMPL_LABEL" >medew.</option>
                        </select>
                    </td>
                </tr>
                <tr>
                <td class="bottom_line inspring">Label voor manager opmerkingen:</td>
                    <td>
                        <select name="label_manager_remarks" id="label_manager_remarks">
                            <option value="REMARKS">Opmerkingen</option>
                            <option value="MANAGER_REMARKS">Manager opmerkingen</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><br /><strong><em>Competenties</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Gebruik cluster hoofdcompetentie: </td>
                    <td><input type="checkbox" id="use_cluster_main_competence" name="use_cluster_main_competence"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik weging woordenboek: </td>
                    <td><input type="checkbox" id="use_rating_dictionary" name="use_rating_dictionary"></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>Profiel</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Medewerker e-mail verplicht: </td>
                    <td><input type="checkbox" id="required_emp_email" name="required_emp_email"></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>POP acties</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Eigen POP acties aanmaken: </td>
                    <td><input type="checkbox" id="allow_pdp_action_user_defined" name="allow_pdp_action_user_defined"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Actie-eigenaar beperken: </td>
                    <td><input type="checkbox" id="use_pdp_action_limit_action_owner" name="use_pdp_action_limit_action_owner"></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>Eindoordeel</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Gebruik medewerker eindoordeel: </td>
                    <td><input type="checkbox" id="use_final_result" name="use_final_result"></td>
                </tr>
                <td class="bottom_line inspring">Eindoordeel score edit:</td>
                    <td>
                        <select name="total_score_edit_type" id="total_score_edit_type">
                            <option value="' . TotalScoreEditType::SELECT_LIST . '">dropdown keuzelijst</option>
                            <option value="' . TotalScoreEditType::RADIO_BUTTONS . '">radiobuttons</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon eindoordeel detail scores: </td>
                    <td><input type="checkbox" id="show_final_result_detail_scores" name="show_final_result_detail_scores"></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>Medewerkers</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Beperken zoekresultaten bij medewerkerlijst: </td>
                    <td><input type="checkbox" id="use_employees_limit" name="use_employees_limit" /></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Aantal medewerkers bij beperking zoekresultaten: </td>
                    <td><input type="text" size="5" id="employees_limit_number" name="employees_limit_number" value="' . APPLICATION_EMPLOYEES_LIMIT_NUMBER . '">&nbsp;<em>let op: check ook Beperk zoekresultaten bij medewerkerlijst</em></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Toon score status icoontjes: </td>
                    <td><input type="checkbox" id="show_score_status_icons" name="show_score_status_icons" /></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik medewerkerlijst leidinggevende/afdeling/functie filter: </td>
                    <td><input type="checkbox" id="use_employees_boss_filter" name="use_employees_boss_filter" /></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik medewerkerlijst evaluatie filter: </td>
                    <td><input type="checkbox" id="use_employees_assessment_filter" name="use_employees_assessment_filter" /></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>360/zelfevaluatie instellingen</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Gebruik zelfevaluatie: </td>
                    <td><input type="checkbox" id="use_selfassessment" name="use_selfassessment">&nbsp;<em>let op: check ook Medew. e-mail verplicht</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik zelfevaluatie process: </td>
                    <td><input type="checkbox" id="use_selfassessment_process" name="use_selfassessment_process">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik zelfevaluatie herinneringsmail: </td>
                    <td><input type="checkbox" id="use_selfassessment_reminders" name="use_selfassessment_reminders">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruik zelfevaluatie tevredenheidsbrief: </td>
                    <td><input type="checkbox" id="use_selfassessment_satisfaction_letter" name="use_selfassessment_satisfaction_letter">&nbsp;<em>let op: check ook Gebruik zelfevaluatie proces</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon extra zelfevaluatie uitnodingsinformatie: </td>
                    <td><input type="checkbox" id="show_selfassessment_invitation_information" name="show_selfassessment_invitation_information">&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Zelfevaluatie geldigheidsduur (<em>dagen</em>): </td>
                    <td><input type="text" size="5" id="selfassessment_validity_period" name="selfassessment_validity_period" value="' . APPLICATION_DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS . '" >&nbsp;<em>let op: check ook Gebruik zelfevaluatie</em></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>360/zelfevaluatie formulier</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Toon categorie in 360 evaluatieformulier: </td>
                    <td><input type="checkbox" id="show_360_eval_category_header" name="show_360_eval_category_header" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon afdeling in 360 evaluatieformulier: </td>
                    <td><input type="checkbox" id="show_360_eval_department" name="show_360_eval_department" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon functieprofiel in 360 evaluatieformulier: </td>
                    <td><input type="checkbox" id="show_360_eval_job_profile" name="show_360_eval_job_profile" checked="checked"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Toon competentie details bij 360 evaluatieformulier: </td>
                    <td><input type="checkbox" id="show_360_competence_details" name="show_360_competence_details" /></td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>Medewerker Tab labels</em></strong></td>
                </tr>

                <tr>
                    <td class="bottom_line inspring">Label voor Tab \'Resultaat\': </td>
                    <td>
                        <select name="label_tab_scores" id="label_tab_scores">
                            <option value="SCORE" >Resultaat</option>
                            <option value="TAB_BEHAVIOUR" >Competenties</option>
                        </select>
                    </td>
                </tr>
                <tr>
                <td class="bottom_line inspring">Label voor Tab \'Taakdoelen\': </td>
                    <td>
                        <select name="label_tab_targets" id="label_tab_targets">
                            <option value="TARGETS" >Taakdoelen</option>
                            <option value="TAB_RESULTS" >Resultaten</option>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td colspan="2"><br><strong><em>Gebruikers</em></strong></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Omschakelen naar medewerker rol:</td>
                    <td><input type="checkbox" id="allow_user_level_switch" name="allow_user_level_switch"></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>

            <table width="800" border="0" cellspacing="2" cellpadding="2" class="border1px">';
                $html .= '
                <tr>
                    <td style="width:50%"><strong>Klant admin account (krijgt default e-mail adres)</strong><br></td>
                    <td></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Gebruikersnaam: </td>
                    <td>
                        <input type="hidden" value="' . $result_row['user_id'] . '" name="user_id"/>
                        <input type="text" size="20" id="username" name="username" value="' . $get_username['username'] . '">
                    </td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Wachtwoord: </td>
                    <td><input type="password" size="20" id="password" name="password" value="' . $get_username['password'] . '"></td>
                </tr>
                <tr>
                    <td class="bottom_line inspring">Bevestig wachtwoord: </td>
                    <td><input type="password" size="20" id="confirmpassword" name="confirmpassword" value="' . $get_username['password'] . '"></td>
                </tr>
                <tr>
                    <td colspan="2">&nbsp;</td>
                </tr>
            </table>';

        $html .= '
        <input id="submitButton" type="submit" class="btn btn_width_80" value="opslaan">
        <input id="cancelButton" type="button" class="btn btn_width_80" value="Annuleren" onclick="xajax_moduleCustomers_displayCustomers();return false;">
        </form>';

        $objResponse->assign('cust_body', 'innerHTML', $html);
        $objResponse->assign('addCust', 'disabled', true);
        $objResponse->script('xajax.$("company").focus();');
    }

    return $objResponse;
}

function customers_safeProcessAddCustomer($objResponse, $safeFormHandler)
{
    $hasError = true;
    if (PamApplication::isSysAdminLevel()) {

        // ophalen gegevens
        // begin fetching variables from $safeFormHandler object

        $firstname = $safeFormHandler->retrieveInputValue('firstname');
        $lastname = $safeFormHandler->retrieveInputValue('lastname');
        $company = $safeFormHandler->retrieveInputValue('company');
        $email = $safeFormHandler->retrieveInputValue('email');
        $telephone = $safeFormHandler->retrieveInputValue('telephone');
        $num_employees = $safeFormHandler->retrieveInputValue('num_employees');
        $use_skill_notes = $safeFormHandler->retrieveInputValue('use_skill_notes');
        $show_skill_category = $safeFormHandler->retrieveInputValue('show_skill_category');
        $show_skill_360 = $safeFormHandler->retrieveInputValue('show_skill_360');
        $show_skill_weight = $safeFormHandler->retrieveInputValue('show_skill_weight');
        $show_skill_norm = $safeFormHandler->retrieveInputValue('show_skill_norm');
        $show_generate_timeshot = $safeFormHandler->retrieveInputValue('show_generate_timeshot');
        $show_skill_actions = $safeFormHandler->retrieveInputValue('show_skill_actions');
        $show_score_as_norm_text = $safeFormHandler->retrieveInputValue('show_score_as_norm_text');
        $show_360_eval_category_header = $safeFormHandler->retrieveInputValue('show_360_eval_category_header');
        $show_360_eval_department = $safeFormHandler->retrieveInputValue('show_360_eval_department');
        $show_360_eval_job_profile = $safeFormHandler->retrieveInputValue('show_360_eval_job_profile');
        $show_360_competence_details = $safeFormHandler->retrieveInputValue('show_360_competence_details');
        $show_360_remarks = $safeFormHandler->retrieveInputValue('show_360_remarks');
        $show_360_difference = $safeFormHandler->retrieveInputValue('show_360_difference');
        $use_selfassessment = $safeFormHandler->retrieveInputValue('use_selfassessment');
        $use_selfassessment_process = $safeFormHandler->retrieveInputValue('use_selfassessment_process') ? 1 : 0;
        $use_selfassessment_reminders = $safeFormHandler->retrieveInputValue('use_selfassessment_reminders') ? 1 : 0;
        $allow_user_level_switch = $safeFormHandler->retrieveInputValue('allow_user_level_switch') ? 1 : 0;
        $use_selfassessment_satisfaction_letter = $safeFormHandler->retrieveInputValue('use_selfassessment_satisfaction_letter') ? 1 : 0;
        $show_selfassessment_invitation_information = $safeFormHandler->retrieveInputValue('show_selfassessment_invitation_information') ? 1 : 0;
        $selfassessment_validity_period = $safeFormHandler->retrieveInputValue('selfassessment_validity_period') ? $safeFormHandler->retrieveInputValue('selfassessment_validity_period') : APPLICATION_DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS;
        $required_emp_email = $safeFormHandler->retrieveInputValue('required_emp_email');
        $allow_pdp_action_user_defined = $safeFormHandler->retrieveInputValue('allow_pdp_action_user_defined');
        $use_pdp_action_limit_action_owner = $safeFormHandler->retrieveInputValue('use_pdp_action_limit_action_owner');
        $use_final_result = $safeFormHandler->retrieveInputValue('use_final_result');
        $total_score_edit_type = $safeFormHandler->retrieveInputValue('total_score_edit_type');
        $show_final_result_detail_scores = $safeFormHandler->retrieveInputValue('show_final_result_detail_scores');
        $use_cluster_main_competence = $safeFormHandler->retrieveInputValue('use_cluster_main_competence');
        $use_rating_dictionary = $safeFormHandler->retrieveInputValue('use_rating_dictionary');
        $use_employees_limit = $safeFormHandler->retrieveInputValue('use_employees_limit');
        $employees_limit_number = $safeFormHandler->retrieveInputValue('employees_limit_number') ? $safeFormHandler->retrieveInputValue('employees_limit_number') : APPLICATION_EMPLOYEES_LIMIT_NUMBER;
        $use_score_status = $safeFormHandler->retrieveInputValue('use_score_status') ? 1 : 0;
        $show_score_status_icons = $safeFormHandler->retrieveInputValue('show_score_status_icons') ? 1 : 0;
        $use_employees_boss_filter = $safeFormHandler->retrieveInputValue('use_employees_boss_filter') ? 1 : 0;
        $use_employees_assessment_filter = $safeFormHandler->retrieveInputValue('use_employees_assessment_filter') ? 1 : 0;
        $label_skill_result = $safeFormHandler->retrieveInputValue('label_skill_result');
        $label_skill_360 = $safeFormHandler->retrieveInputValue('label_skill_360');
        $label_tab_scores = $safeFormHandler->retrieveInputValue('label_tab_scores');
        $label_tab_targets = $safeFormHandler->retrieveInputValue('label_tab_targets');
        $label_manager_remarks = $safeFormHandler->retrieveInputValue('label_manager_remarks');
        $username = trim($safeFormHandler->retrieveInputValue('username'));
        $password = $safeFormHandler->retrieveInputValue('password');
        $confirm = $safeFormHandler->retrieveInputValue('confirmpassword');
        // end fetching variables from $safeFormHandler object

        $company_info_text = htmlentities($company_info_text);
        $use_skill_notes = ($use_skill_notes) ? 1 : 0;
        $show_skill_category = ($show_skill_category) ? 1 : 0;
        $show_skill_360 = ($show_skill_360) ? 1 : 0;
        $show_skill_weight = ($show_skill_weight) ? 1 : 0;
        $show_skill_norm = ($show_skill_norm) ? 1 : 0;
        $show_generate_timeshot = ($show_generate_timeshot) ? 1 : 0;
        $show_skill_actions = ($show_skill_actions) ? 1 : 0;
        $show_score_as_norm_text = ($show_score_as_norm_text) ? 1 : 0;
        $show_360_eval_category_header = ($show_360_eval_category_header) ? 1 : 0;
        $show_360_eval_department = ($show_360_eval_department) ? 1 : 0;
        $show_360_eval_job_profile = ($show_360_eval_job_profile) ? 1 : 0;
        $show_360_competence_details = ($show_360_competence_details) ? 1 : 0;
        $show_360_remarks = ($show_360_remarks) ? 1 : 0;
        $show_360_difference = ($show_360_difference) ? 1 : 0;
        $use_selfassessment = ($use_selfassessment) ? 1 : 0;
        $required_emp_email = ($required_emp_email) ? 1 : 0;
        $allow_pdp_action_user_defined = ($allow_pdp_action_user_defined) ? 1 : 0;
        $use_pdp_action_limit_action_owner = ($use_pdp_action_limit_action_owner) ? 1 : 0;
        $use_final_result = ($use_final_result) ? 1 : 0;
        $show_final_result_detail_scores = ($show_final_result_detail_scores) ? 1 : 0;
        $use_cluster_main_competence = ($use_cluster_main_competence) ? 1 : 0;
        $use_rating_dictionary = ($use_rating_dictionary) ? 1 : 0;
        $use_employees_limit = ($use_employees_limit) ? 1 : 0;

        // validatie
        $hasError = false;
        if (empty($company)) {
            $hasError = true;
            $message = 'Bedrijfsnaam mag niet leeg zijn.';
            $objResponse->script('xajax.$("company").focus();');
        } elseif (empty($email)) {
            $hasError = true;
            $message = 'E-mail mag niet leeg zijn.';
            $objResponse->script('xajax.$("email").focus();');
        } elseif (!PamValidators::IsEmailAddressValidFormat($email)) {
            $hasError = true;
            $message = 'Geen correct E-mail adres';
            $objResponse->script('xajax.$("email").focus();');
            $objResponse->assign('email', 'value', '');
        } elseif (empty($num_employees) || !is_numeric($num_employees)) {
            $hasError = true;
            $message = 'Toegestane aantal medewerkers moet met een numerieke waarde gevuld worden.';
            $objResponse->script('xajax.$("num_employees").focus();');
            $objResponse->assign('num_employees', 'value', '');
        } elseif (empty($firstname)) {
            $hasError = true;
            $message = 'Voornaam mag niet leeg zijn.';
            $objResponse->script('xajax.$("firstname").focus();');
        } elseif (empty($lastname)) {
            $hasError = true;
            $message = 'Achternaam mag niet leeg zijn.';
            $objResponse->script('xajax.$("lastname").focus();');
        } else {

            $sql = 'SELECT
                        *
                    FROM
                        users
                    WHERE
                        username = "' . mysql_real_escape_string($username) . '"';
            $check_usernameIfExist = BaseQueries::performSelectQuery($sql);


            if (empty($username)) {
                $hasError = true;
                $message = 'Admin gebruikersnaam mag niet leeg zijn.';
                $objResponse->script('xajax.$("username").focus();');
            } elseif (@mysql_num_rows($check_usernameIfExist) > 0) {
                $hasError = true;
                $message = 'Gebruikersnaam is al in gebruik.';
                $objResponse->assign('username', 'value', '');
                $objResponse->script('xajax.$("username").focus();');
            } elseif (empty($password)) {
                $hasError = true;
                $message = 'Wachtwoord mag niet leeg zijn.';
                $objResponse->script('xajax.$("password").focus();');
            } elseif ($username == $password) {
                $hasError = true;
                $message = 'Wachtwoord mag niet gelijk zijn aan de gebruikersnaam.';
                $objResponse->script('xajax.$("password").focus();');
                $objResponse->assign('password', 'value', '');
            } elseif (!PamValidators::isPasswordValidFormat($password)) {
                $hasError = true;
                $message = 'Wachtwoord moet minimaal 8 tekens lang zijn, en ten minste 1 kleine letter, 1 hoofdletter en 1 cijfer bevatten.';
                $objResponse->assign('password', 'value', '');
                $objResponse->script('xajax.$("password").focus();');
            } elseif ($password <> $confirm) {
                $hasError = true;
                $message = 'Herhaalde wachtwoord is niet gelijk aan Wachtwoord.';
                $objResponse->script('xajax.$("confirmpassword").focus();');
            }
        }

        // verwerken
        if (!$hasError) {
            $hasError = true;
            BaseQueries::startTransaction();

            $default_language = LanguageValue::LANG_ID_NL; // nederlands
            $default_theme = 6; // blue
            $company_info_text = 'Bedrijfsinformatie tekst.';

            $modified_by_user = 'SysAdmin';
            $modified_by_userID = USER_ID;
            $modified_time = MODIFIED_TIME;
            $modified_date = MODIFIED_DATE;
            $modified_datetime = MODIFIED_DATETIME;

            $sql = 'INSERT INTO
                        customers
                        (   firstname,
                            lastname,
                            company_name,
                            email_address,
                            telephone,
                            theme_id,
                            lang_id,
                            num_employees
                        ) VALUES (
                            "' . mysql_real_escape_string($firstname) . '",
                            "' . mysql_real_escape_string($lastname) . '",
                            "' . mysql_real_escape_string($company) . '",
                            "' . mysql_real_escape_string($email) . '",
                            "' . mysql_real_escape_string($telephone) . '",
                             ' . $default_theme . ',
                             ' . $default_language . ',
                            "' . mysql_real_escape_string($num_employees) . '"
                        )';

            $new_customer_id = BaseQueries::performInsertQuery($sql);
            // default values voor options en labels

            $sql = 'INSERT INTO
                        organisation_info
                        (   customer_id,
                            info_text,
                            saved_by_user_id,
                            saved_by_user,
                            saved_datetime
                        ) VALUES (
                             ' . $new_customer_id . ',
                            "' . mysql_real_escape_string($company_info_text) . '",
                             ' . $modified_by_userID . ',
                            "' . $modified_by_user . '",
                            "' . $modified_datetime . '"
                        )';
            BaseQueries::performInsertQuery($sql);

            $sql = 'INSERT INTO
                        customers_options
                        (   customer_id,
                            use_skill_notes,
                            show_skill_category,
                            show_skill_360,
                            show_skill_weight,
                            show_skill_norm,
                            show_skill_actions,
                            show_score_as_norm_text,
                            show_360_eval_category_header,
                            show_360_eval_department,
                            show_360_eval_job_profile,
                            show_360_competence_details,
                            show_360_remarks,
                            show_360_difference,
                            show_generate_timeshot,
                            use_selfassessment,
                            use_selfassessment_process,
                            use_selfassessment_reminders,
                            use_selfassessment_satisfaction_letter,
                            show_selfassessment_invitation_information,
                            selfassessment_validity_period,
                            required_emp_email,
                            use_final_result,
                            total_score_edit_type,
                            show_final_result_detail_scores,
                            use_cluster_main_competence,
                            use_rating_dictionary,
                            use_employees_limit,
                            employees_limit_number,
                            use_score_status,
                            show_score_status_icons,
                            use_employees_boss_filter,
                            use_employees_assessment_filter,
                            allow_user_level_switch,
                            allow_pdp_action_user_defined,
                            use_pdp_action_limit_action_owner
                        ) VALUES (
                            ' . $new_customer_id . ',
                            ' . $use_skill_notes . ',
                            ' . $show_skill_category . ',
                            ' . $show_skill_360 . ',
                            ' . $show_skill_weight . ',
                            ' . $show_skill_norm . ',
                            ' . $show_skill_actions . ',
                            ' . $show_score_as_norm_text . ',
                            ' . $show_360_eval_category_header . ',
                            ' . $show_360_eval_department . ',
                            ' . $show_360_eval_job_profile . ',
                            ' . $show_360_competence_details . ',
                            ' . $show_360_remarks . ',
                            ' . $show_360_difference . ',
                            ' . $show_generate_timeshot . ',
                            ' . $use_selfassessment . ',
                            ' . $use_selfassessment_process . ',
                            ' . $use_selfassessment_reminders . ',
                            ' . $use_selfassessment_satisfaction_letter . ',
                            ' . $show_selfassessment_invitation_information . ',
                            ' . $selfassessment_validity_period . ',
                            ' . $required_emp_email . ',
                            ' . $use_final_result . ',
                            ' . $total_score_edit_type . ',
                            ' . $show_final_result_detail_scores . ',
                            ' . $use_cluster_main_competence . ',
                            ' . $use_rating_dictionary . ',
                            ' . $use_employees_limit . ',
                            ' . $employees_limit_number . ',
                            ' . $use_score_status . ',
                            ' . $show_score_status_icons . ',
                            ' . $use_employees_boss_filter . ',
                            ' . $use_employees_assessment_filter . ',
                            ' . $allow_user_level_switch . ',
                            ' . $allow_pdp_action_user_defined . ',
                            ' . $use_pdp_action_limit_action_owner . '
                        )';
            BaseQueries::performInsertQuery($sql);

            $sql = 'INSERT INTO
                        customers_labels
                        (   customer_id,
                            define_mgr_score_label,
                            define_360_score_label,
                            define_score_tab_label,
                            define_targets_tab_label,
                            define_mgr_remarks_label
                        ) VALUES (
                                ' . $new_customer_id . ',
                            "' . mysql_real_escape_string($label_skill_result) . '",
                            "' . mysql_real_escape_string($label_skill_360) . '",
                            "' . mysql_real_escape_string($label_tab_scores) . '",
                            "' . mysql_real_escape_string($label_tab_targets) . '",
                            "' . mysql_real_escape_string($label_manager_remarks) . '"
                        )';
            BaseQueries::performInsertQuery($sql);

            $sql = 'INSERT INTO
                        users
                        (   customer_id,
                            username,
                            name,
                            email,
                            user_level,
                            modified_by_user,
                            modified_time,
                            modified_date,
                            created_date,
                            isprimary
                        ) VALUES (
                            ' . $new_customer_id . ',
                            "' . mysql_real_escape_string($username) . '",
                            "Admin",
                            "' . mysql_real_escape_string($email) . '",
                            1,
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '",
                            "' . $modified_date . '",
                            1
                        )';

            $user_id = BaseQueries::performInsertQuery($sql);

            UserLoginService::changePassword($user_id, $password, true, USER);

            $sql = 'INSERT INTO
                        user_level
                        (   level_id,
                            customer_id,
                            level_name
                        ) VALUES
                            (1, ' . $new_customer_id . ', "0 - Admin"),
                            (2, ' . $new_customer_id . ', "1 - HR"),
                            (3, ' . $new_customer_id . ', "2 - Management"),
                            (4, ' . $new_customer_id . ', "3 - Medewerker"),
                            (5, ' . $new_customer_id . ', "4 - Medewerker inzien")';
            BaseQueries::performInsertQuery($sql);

            $sql = 'INSERT INTO
                        scale
                        (   scale_id, customer_id,
                            scale_name,
                            default_desc,
                            description,
                            total_score_description
                        ) VALUES
                            (  1, ' . $new_customer_id . ',
                                "1",
                                "Geen",
                                "Geen",
                                ""
                            ),
                            (   2, ' . $new_customer_id . ',
                                "2",
                                "Basis",
                                "Basis",
                                "Onder taakstelling"
                            ),
                            (   3, ' . $new_customer_id . ',
                                "3",
                                "Gemiddeld",
                                "Gemiddeld",
                                "Conform taakstelling"
                            ),
                            (   4, ' . $new_customer_id . ',
                                "4",
                                "Goed",
                                "Goed",
                                "Boven taakstelling"
                            ),
                            (   5, ' . $new_customer_id . ',
                                "5",
                                "Specialist",
                                "Specialist",
                                ""
                            ),
                            (   6, ' . $new_customer_id . ',
                                "N",
                                "Nee",
                                "Nee",
                                ""
                            ),
                            (   7, ' . $new_customer_id . ',
                                "Y",
                                "Ja",
                                "Ja",
                                ""
                            )';
            BaseQueries::performInsertQuery($sql);

            require_once('modules/emails_defaults.inc.php');

            if ($default_language == LanguageValue::LANG_ID_EN) { // en
                $default_notification_message_action = ACTION_MESSAGE_EN;
                $default_notification_message_task = TASK_MESSAGE_EN;
                $default_notification_message360_internal = EVALUATION_MESSAGE_INTERNAL_EN;
                $default_notification_message360_external = EVALUATION_MESSAGE_EXTERNAL_EN;
            } else {
                $default_notification_message_action = ACTION_MESSAGE_NL;
                $default_notification_message_task = TASK_MESSAGE_NL;
                $default_notification_message360_internal = EVALUATION_MESSAGE_INTERNAL_NL;
                $default_notification_message360_external = EVALUATION_MESSAGE_EXTERNAL_NL;
            }

            $sql = 'INSERT INTO
                        notification_message
                        (   customer_id,
                            message,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES
                            (   ' . $new_customer_id . ',
                                "' . mysql_real_escape_string($default_notification_message_action) . '",
                                "' . $modified_by_user . '",
                                "' . $modified_time . '",
                                "' . $modified_date . '"
                            ),
                            (   ' . $new_customer_id . ',
                                "' . mysql_real_escape_string($default_notification_message_task)   . '",
                                "' . $modified_by_user . '",
                                "' . $modified_time . '",
                                "' . $modified_date . '"
                            )';
            BaseQueries::performInsertQuery($sql);

            $sql = 'INSERT INTO
                        notification360_message
                        (   customer_id,
                            message,
                            modified_by_user,
                            modified_time,
                            modified_date
                        ) VALUES
                            (   ' . $new_customer_id . ',
                                "' . mysql_real_escape_string($default_notification_message360_internal) . '",
                                "' . $modified_by_user . '",
                                "' . $modified_time . '",
                                "' . $modified_date . '"
                            ),
                            (   ' . $new_customer_id . ',
                                "' . mysql_real_escape_string($default_notification_message360_external)   . '",
                                "' . $modified_by_user . '",
                                "' . $modified_time . '",
                                "' . $modified_date . '"
                            )';
            BaseQueries::performInsertQuery($sql);

            $default_date = DateUtils::getCurrentDisplayDate();
            $sql = 'INSERT INTO
                        standard_date
                        (   customer_id,
                            default_end_date,
                            saved_by_user_id,
                            saved_by_user,
                            saved_datetime,
                            database_datetime
                        ) VALUES (
                            ' . $new_customer_id . ',
                            "' . $default_date . '",
                            ' .  $modified_by_userID . ',
                            "' . $modified_by_user . '",
                            "' . $modified_date . '' . $modified_time . '",
                            NOW()
                        )';
            BaseQueries::performInsertQuery($sql);

            // de pdp acties voor eigen gedefinieerde acties
            $sql = 'INSERT INTO
                    `pdp_action_cluster`
                    ( 	`customer_id`,
                        `cluster`,
                        `is_customer_library`
                    ) VALUES (
                        ' . $new_customer_id . ',
                        "PAM intern cluster",
                        ' . PDP_ACTION_LIBRARY_CLUSTER_SYSTEM . '
                    )';
            $pdpActionClusterId = BaseQueries::performInsertQuery($sql);

            $sql = 'INSERT INTO
                        `pdp_actions`
                        (   `customer_id`,
                            `action`,
                            `ID_PDPAC`,
                            `is_customer_library`,
                            `provider`,
                            `duration`,
                            `start_date`,
                            `end_date`,
                            `costs`,
                            `modified_by_user`,
                            `modified_time`,
                            `modified_date`
                        ) VALUES (
                            ' . $new_customer_id . ',
                            "",
                            ' . $pdpActionClusterId . ',
                            ' . PDP_ACTION_LIBRARY_SYSTEM . ',
                            "",
                            "",
                            "",
                            "",
                            "",
                            "' . $modified_by_user . '",
                            "' . $modified_time . '",
                            "' . $modified_date . '"
                        )';
            BaseQueries::performInsertQuery($sql);

            // Tab permissies
            PermissionsService::SetAllowedPrivileges( PermissionsService::GetDefaultAccessPrivileges(UserLevelValue::CUSTOMER_ADMIN),   UserLevelValue::CUSTOMER_ADMIN, $new_customer_id);
            PermissionsService::SetAllowedPrivileges( PermissionsService::GetDefaultAccessPrivileges(UserLevelValue::HR),               UserLevelValue::HR,             $new_customer_id);
            PermissionsService::SetAllowedPrivileges( PermissionsService::GetDefaultAccessPrivileges(UserLevelValue::MANAGER),          UserLevelValue::MANAGER,        $new_customer_id);
            PermissionsService::SetAllowedPrivileges( PermissionsService::GetDefaultAccessPrivileges(UserLevelValue::EMPLOYEE_EDIT),    UserLevelValue::EMPLOYEE_EDIT,  $new_customer_id);
            PermissionsService::SetAllowedPrivileges( PermissionsService::GetDefaultAccessPrivileges(UserLevelValue::EMPLOYEE_VIEW),    UserLevelValue::EMPLOYEE_VIEW,  $new_customer_id);

            // mappen aanmaken
            mkdir('user_logo/c' . $new_customer_id, DIRECTORY_ACCESS_SETTINGS);
            mkdir(PAM_BASE_DIR . 'uploads/c' . $new_customer_id, DIRECTORY_ACCESS_SETTINGS);

            BaseQueries::finishTransaction();
            $hasError = false;

            $message = 'Nieuwe klant ' . $company . ' opgeslagen';
            $objResponse->loadCommands(moduleCustomers_displayCustomers());
        }
    }
    return array($hasError, $message);
}


function moduleCustomers_utils_exportCustomerLogosAndEmployeePhotosToEnvironment()
{
    $objResponse = new xajaxResponse();

    // Alleen de mensen van Gino zouden deze functie mogen gebruiken
    if (PamApplication::hasValidSession($objResponse) && PamApplication::isSysAdminUser()) {
        $hasError = false;
        $message  = '';

        if (!file_exists(APPLICATION_LOGO_BASE_DIR)) {
            $hasError = true;
            $message .= 'Directory ' . APPLICATION_LOGO_BASE_DIR . ' bestaat niet.' . "\n";
        }

        if (!file_exists(APPLICATION_UPLOADS_BASE_DIR)) {
            $hasError = true;
            $message .= 'Directory ' . APPLICATION_UPLOADS_BASE_DIR . ' bestaat niet.' . "\n";
        }

        if (!$hasError) {
            // eerst voor alle customers mappen aanmaken
            $sql = 'SELECT
                        c.customer_id
                    FROM
                        customers c
                    WHERE
                        c.customer_id > 0';
            $customersQuery = mysql_query($sql);
            if (!$customersQuery) {
                $hasError = true;
                $message .= BaseQueries::LogOnError($sql);
            } else {
                while ($customer_row = @mysql_fetch_assoc($customersQuery)) {
                    $customer_id = $customer_row['customer_id'];

                    // pad voor customer logo aanmaken
                    $customer_logo_path = ModuleUtils::getCustomerLogoPath($customer_id);

                    if (!file_exists($customer_logo_path) && !mkdir($customer_logo_path, DIRECTORY_ACCESS_SETTINGS)) {
                        $hasError = true;
                        $message .= 'Kan de benodigde directory ' . $customer_logo_path . ' niet aanmaken.' . "\n";
                    }

                    // pad voor foto's aanmaken
                    $customer_photo_path = ModuleUtils::getCustomerPhotoPath($customer_id);

                    if (!file_exists($customer_photo_path) && !mkdir($customer_photo_path, DIRECTORY_ACCESS_SETTINGS)) {
                        $hasError = true;
                        $message .= 'Kan de benodigde directory ' . $customer_photo_path . ' niet aanmaken.' . "\n";
                    }
                }
                @mysql_free_result($customersQuery);
            }
        }

        if (!$hasError) {
            // Customer logo's
            $sql = 'SELECT
                        c.customer_id
                    FROM
                        customers c
                        INNER JOIN document_contents dc
                            ON (c.id_contents = dc.id_contents
                                AND c.customer_id = dc.customer_id)';
            $logoQuery = mysql_query($sql);
            if (!$logoQuery) {
                $hasError = true;
                $message .= BaseQueries::LogOnError($sql);
            } else {
                while ($customer_logo_row = @mysql_fetch_assoc($logoQuery)) {
                    $customer_id = $customer_logo_row['customer_id'];

                    LogoService::placeLogoInCustomerFilePath($customer_id);
                }

                @mysql_free_result($logoQuery);
            }

            // Employee mugshots
            $sql = 'SELECT
                        e.customer_id,
                        e.ID_E
                    FROM
                        employees e
                        INNER JOIN customers c
                            ON c.customer_id = e.customer_id
                        INNER JOIN document_contents dc
                            ON dc.id_contents = e.id_contents';
            $employeesQueries = @mysql_query($sql);
            if (!$employeesQueries) {
                $hasError = true;
                $message .= BaseQueries::LogOnError($sql);
            } else {

                $photo = new PhotoContent();

                while ($employee_photo_row = @mysql_fetch_assoc($employeesQueries)) {
                    $customer_id = $employee_photo_row['customer_id'];
                    $id_e = $employee_photo_row['ID_E'];

                    $photo->copyDBPhotoToCustomerPhotoPath($customer_id, $id_e);
                }

                @mysql_free_result($employeesQueries);
            }
            $message .= 'Klaar met bestanden exporteren vanuit de database naar omgeving.';
        }
        $objResponse->alert($message);
    }

    return $objResponse;
}

?>