<?php

date_default_timezone_set('Europe/Amsterdam');

//define('MODIFIED_TIME', date('G:i', time()));
require_once('application/library/applicationConsts.inc.php');

if (!PAM_DISABLED) {
    require_once('gino/MysqlUtils.class.php');
    require_once('application/application_setup/database_config.inc.php');
    require_once('application/model/value/databaseValueConsts.inc.php');
    require_once('application/library/PamApplication.class.php');
    require_once('application/model/service/PermissionsService.class.php');
    require_once('modules/common/moduleUtils.class.php');
    require_once('application/model/queries/ConfigQueries.class.php');
    require_once('application/model/queries/CustomerQueries.class.php');
    require_once('modules/model/service/upload/LogoContent.class.php');
    require_once('modules/model/service/settings/StandardDateService.class.php');

    define('MODIFIED_TIME', date('H:i:s', time()));
    define('REFERENCE_DATE', PamApplication::getReferenceDate());
    define('MODIFIED_DATE', REFERENCE_DATE);
    define('REFERENCE_DATETIME', PamApplication::getReferenceDate() . ' ' . MODIFIED_TIME);
    define('MODIFIED_DATETIME', REFERENCE_DATETIME);
//    define('DISPLAY_TODAY_DATE', date(DEFAULT_DATE_DISPLAY_FORMAT, time()));

    // hbd: user uit de sessie halen
    $user = PamApplication::retrieveCurrentUser();
} else {
    PamApplication::clearCurrentUser();
    unset($user);
}

define('MODIFIED_TIME', date('H:i:s', time()));
define('MODIFIED_DATE', date('Y-m-d', time()));
define('MODIFIED_DATETIME', date('Y-m-d H:i:s'));

$cf = CSS_DEFAULT . '/'; // hbd: ????
$theme = CSS_DEFAULT;

$displayable_logo = APPLICATION_DEFAULT_LOGO_FILE_URL;
$logo_width = DEFAULT_LOGO_WIDTH;
$logo_height = DEFAULT_LOGO_HEIGHT;

if (isset($user)) {
    $sql_user_result = CustomerQueries::GetCustomerInfoByUser($user);
    $user_result_count = @mysql_numrows($sql_user_result);
    if ($user_result_count != 1) {
        ModuleUtils::ForceLogout();
        header("Location: " . SITE_URL);
        exit;
    } else {
        $u = @mysql_fetch_assoc($sql_user_result);
        define('APPLICATION_DEFAULT_LOGO_FILE_PATH', ModuleUtils::createPath(array(PAM_BASE_DIR . 'images', 'logo')) . 'default_logo.jpg');
        define('APPLICATION_LOGO_BASE_URL', 'user_logo/');
        define('APPLICATION_LOGO_BASE_DIR', ModuleUtils::createPath(array(PAM_BASE_DIR . 'pam-public', 'user_logo')));
        define('APPLICATION_UPLOADS_BASE_DIR', ModuleUtils::createPath(array(PAM_BASE_DIR . 'uploads')));

        define('CUSTOMER_ID',         $u['calculated_customer_id']);
        define('CUSTOMER_FOLDER',     'c' . CUSTOMER_ID);
        define('UPLOAD_PATH',         APPLICATION_UPLOADS_BASE_DIR . CUSTOMER_FOLDER . DIRECTORY_SEPARATOR); // upload path buiten publieke www dir, en met DIRECTORY_SEPARATOR.
        define('CUSTOMER_LOGO_URL',   APPLICATION_LOGO_BASE_URL . CUSTOMER_FOLDER . '/');
        define('CUSTOMER_LOGO_PATH',  APPLICATION_LOGO_BASE_DIR . CUSTOMER_FOLDER . DIRECTORY_SEPARATOR);
        define('CUSTOMER_PHOTO_PATH', UPLOAD_PATH);

        define('LANG_ID', $u['lang_id']);
        define('EMPLOYEE_ID', $u['ID_E']);
        define('USER_EMPLOYEE_IS_BOSS', $u['is_boss'] == EMPLOYEE_IS_MANAGER);

        define('MAX_EMPLOYEES', $u[num_employees]);

        define('CUSTOMER_OPTION_USE_SKILL_NOTES', $u['use_skill_notes'] == 1);
        define('CUSTOMER_OPTION_SHOW_360', $u['show_skill_360'] == 1);
        define('CUSTOMER_OPTION_SHOW_WEIGHT', $u['show_skill_weight'] == 1);
        define('CUSTOMER_OPTION_SHOW_NORM', $u['show_skill_norm'] == 1);
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        // hbd: tijdelijk uitgezet tot pdp acties refactored is$u['show_skill_actions'] == 1);
        define('CUSTOMER_OPTION_SHOW_ACTIONS', FALSE);
        //define('CUSTOMER_OPTION_SHOW_ACTIONS', $u['show_skill_actions'] == 1);
        //////////////////////////////////////////////////////////////////////////////////////////////////////
        define('CUSTOMER_OPTION_SHOW_SCORE_AS_NORM_TEXT', $u['show_score_as_norm_text'] == 1);
        define('CUSTOMER_OPTION_USE_SELFASSESSMENT',  $u['use_selfassessment'] == 1);
        // TODO: bossfilter_shows_dashboard in tabel
        define('CUSTOMER_OPTION_BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD',    CUSTOMER_OPTION_USE_SELFASSESSMENT &&
                                                                            APPLICATION_BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD &&
                                                                            $u['bossfilter_shows_dashboard'] == 1);
        define('CUSTOMER_OPTION_USE_SELFASSESSMENT_REMINDERS',  CUSTOMER_OPTION_USE_SELFASSESSMENT && $u['use_selfassessment_reminders'] == 1);
        define('CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS',    CUSTOMER_OPTION_USE_SELFASSESSMENT && $u['use_selfassessment_process'] == 1);
        define('CUSTOMER_OPTION_USE_SELFASSESSMENT_SATISFACTION_LETTER',  CUSTOMER_OPTION_USE_SELFASSESSMENT_PROCESS && $u['use_selfassessment_satisfaction_letter'] == 1);
        define('CUSTOMER_OPTION_SHOW_INVITATION_INFORMATION', CUSTOMER_OPTION_USE_SELFASSESSMENT && APPLICATION_SHOW_INVITATION_INFORMATION && $u['show_selfassessment_invitation_information'] == 1 );
        define('CUSTOMER_OPTION_SELFASSESSMENT_INVITATION_VALID_DAYS',  !isset($u['selfassessment_validity_period']) ? APPLICATION_DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS : $u['selfassessment_validity_period']);
        define('CUSTOMER_OPTION_REQUIRED_EMP_EMAIL',  $u['required_emp_email'] == 1);

        define('CUSTOMER_OPTION_SHOW_DUMMY_THUMBNAIL', $u['show_dummy_thumbnail'] == 1);

        define('CUSTOMER_OPTION_USE_FINAL_RESULT', $u['use_final_result'] == 1);
        define('CUSTOMER_OPTION_TOTAL_SCORE_EDIT_TYPE', $u['total_score_edit_type']);
        define('CUSTOMER_OPTION_SHOW_FINAL_RESULT_TIMESHOTS', CUSTOMER_OPTION_USE_FINAL_RESULT && $u['show_final_result_timeshots'] == 1);
        define('CUSTOMER_OPTION_SHOW_FINAL_RESULT_DETAIL_SCORES', CUSTOMER_OPTION_USE_FINAL_RESULT && $u['show_final_result_detail_scores'] == 1);

        define('CUSTOMER_OPTION_ALLOW_USER_DEFINED_PDP_ACTION', $u['allow_pdp_action_user_defined'] == 1);
        define('CUSTOMER_OPTION_USE_PDP_ACTION_LIMIT_ACTION_OWNER', $u['use_pdp_action_limit_action_owner'] == 1);

        define('CUSTOMER_OPTION_USE_CLUSTER_MAIN_COMPETENCE', $u['use_cluster_main_competence'] == 1);
        define('CUSTOMER_OPTION_SHOW_KS', $u['show_skill_category'] == 1);
        define('CUSTOMER_OPTION_USE_RATING_DICTIONARY', $u['use_rating_dictionary'] == 1);

        define('CUSTOMER_OPTION_SHOW_360_EVAL_CATEGORY_HEADER', $u['show_360_eval_category_header'] == 1);
        define('CUSTOMER_OPTION_SHOW_360_EVAL_DEPARTMENT', $u['show_360_eval_department'] == 1);
        define('CUSTOMER_OPTION_SHOW_360_EVAL_JOB_PROFILE', $u['show_360_eval_job_profile'] == 1);
        define('CUSTOMER_OPTION_SHOW_360_COMPETENCE_DETAILS', $u['show_360_competence_details']);
        define('CUSTOMER_OPTION_SHOW_360_REMARKS', $u['show_360_remarks']);
        define('CUSTOMER_OPTION_SHOW_360_DIFFERENCE', $u['show_360_difference']);
        define('CUSTOMER_OPTION_SHOW_GENERATE_TIMESHOT', $u['show_generate_timeshot'] == 1);
        define('CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT', $u['use_employees_limit'] == 1);
        define('CUSTOMER_OPTION_USE_EMPLOYEES_LIMIT_NUMBER', $u['employees_limit_number']);
        define('CUSTOMER_OPTION_SHOW_EMPLOYEES_COUNT', APPLICATION_SHOW_SELECTOR_EMPLOYEES_COUNT);
        define('CUSTOMER_OPTION_USE_FILTER_EMPLOYEES_BOSS', $u['use_employees_boss_filter'] == 1);
        define('CUSTOMER_OPTION_USE_SCORE_STATUS', $u['use_score_status'] == 1);
        define('CUSTOMER_OPTION_SHOW_SCORE_STATUS_ICONS', CUSTOMER_OPTION_USE_SCORE_STATUS && $u['show_score_status_icons'] == 1);
        define('CUSTOMER_OPTION_SHOW_FILTERS_EMPLOYEES_ASSESSMENT_STATE', (CUSTOMER_OPTION_USE_SCORE_STATUS || CUSTOMER_OPTION_USE_SELFASSESSMENT) && $u['use_employees_assessment_filter'] == 1);
        define('CUSTOMER_OPTION_ALLOW_USER_LEVEL_SWITCH', $u['allow_user_level_switch'] == 1);

        define('CUSTOMER_MGR_SCORE_LABEL', $u['define_mgr_score_label']);
        define('CUSTOMER_360_SCORE_LABEL',  $u['define_360_score_label']);
        define('CUSTOMER_SCORE_TAB_LABEL', $u['define_score_tab_label']);
        define('CUSTOMER_TARGETS_TAB_LABEL', $u['define_targets_tab_label']);
        define('CUSTOMER_MANAGER_REMARKS_LABEL', $u['define_mgr_remarks_label']);

        // begin xajax_debug settings
        $prefered_xajax_debug_setting = ($_SESSION['XAJAX_DEBUG_VIA_ADMIN'] == true) ||
                                        (defined('SITE_AJAX_DEBUG') ? SITE_AJAX_DEBUG : false);

        if (!$prefered_xajax_debug_setting) {
            $qDebugResult = !empty($u['user_id']) ? ConfigQueries::GetXajaxDebugInfo($u['user_id']) :  null;
            $prefered_xajax_debug_setting = (@mysql_num_rows($qDebugResult) > 0);
        }
        define('XAJAX_DEBUG_SETTING', $prefered_xajax_debug_setting);
        // end xajax_debug settings

        if (!empty($u[customer_id])) {
            $logo_content = new LogoContent();
            list($displayable_logo, $logo_width, $logo_height, $is_default_logo) = $logo_content->getCustomerDisplayableLogo($u['logo'], $u['logo_size_width'], $u['logo_size_height']);

            list($printable_logo) = $logo_content->getCustomerPrintableLogo($u['logo'], $u['logo_size_width'], $u['logo_size_height']);
            define('PDF_LOGO', $printable_logo);
            $image_pdf_scale_divider = $is_default_logo ? PDF_DEFAULT_LOGO_FACTOR : PDF_CUSTOMER_LOGO_FACTOR;
            define('LOGO_WIDTH_PDF', $logo_width / $image_pdf_scale_divider);
            define('LOGO_HEIGHT_PDF', $logo_height / $image_pdf_scale_divider);
        }

        if (CUSTOMER_ID == 0) {
            $theme  = CSS_DEFAULT;
        } else {
            $theme  = CSS_BLUE;
//            if (!empty($u['css_file'])) {
//                $theme = $u['css_file'];
//            }
        }
        $cf = $theme . '/';

        define('USER', addslashes($u['name'])); // hbd: hack om overal de USER goed in de database te krijgen
        define('COMPANY_NAME', CUSTOMER_ID == 0 ? 'Gino PAM People' : $u['company_name']);
        define('USER_ID', $u['user_id']);
        define('IS_PRIMARY_CUSTOMER_ADMIN', $u['isprimary'] == USER_PRIMARY_ADMIN);
        define('USER_EMAIL', $u['email']);
        PamApplication::storeLoginUserLevel($u['user_level']);
        define('USER_LEVEL', PamApplication::getActualUserLevel());
        define('IMG_URL', $cf); // hbd: letop, dit is eigenlijk CSS_IMG_URL!

        if (!defined('MODULE_SUBSET')) {
            if (CUSTOMER_ID == 0) {
                define('MODULE_SUBSET', MODULE_SUBSET_CUSTOMERS);
            } else {
                define('MODULE_SUBSET', MODULE_SUBSET_APPLICATION);
            }
        }

        $allow_access_all_departments = USER_LEVEL == UserLevelValue::CUSTOMER_ADMIN ||
                                        ((USER_LEVEL == UserLevelValue::HR || USER_LEVEL == UserLevelValue::MANAGER) && $u['allow_access_all_departments'] == ALLOW_ACCESS_DEPARTMENT) ? true : false;
        define('USER_ALLOW_ACCESS_ALL_DEPARTMENTS', $allow_access_all_departments);

        PermissionsService::loadPermissions();

        define('DEFAULT_DATE', DateUtils::convertToDisplayDate(StandardDateService::getDefaultDate()));

        ModuleUtils::DefineScales(CUSTOMER_ID);
    }

} else {
    if (!defined('MODULE_SUBSET')) {
        define('MODULE_SUBSET', MODULE_SUBSET_LOGIN);
    }
    define('CUSTOMER_ID', 'no_customer_id'); // voor het ophalen van de juiste taal
}

define('USER_LOGO_FILE_URL', $displayable_logo);
define('LOGO_WIDTH', $logo_width);
define('LOGO_HEIGHT', $logo_height);

define('THEME', $theme);
if (!PAM_DISABLED) {
    require_once('application/application_setup/language_config.inc.php');
}

define('CUSTOMER_ID', ''); // dit doet mogelijk niks, omdat CUSTOMER_ID al eerder gedefined is.


?>