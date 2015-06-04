<?php
/**
 * Description of PamSetup
 *
 * @author ben.dokter
 */

class PamSetup
{

    var $databaseHostname;
    var $databaseUsername;
    var $databasePassword;
    var $databaseName;

    static function create()
    {
        // applicatie disablen voor onderhoud (PAM_DISABLED -> true)
        // aanzetten voor gebruik: (PAM_DISABLED -> false)
        define('PAM_DISABLED', false);

        return new PamSetup();
    }

    function setupPamEnvironment($configPath)
    {
        $this->definePamVersionInformation();
        $this->loadPamConfigFiles($configPath);
        $this->definePamSiteInformation();
        $this->defineApplicationSettings();
    }


    private function definePamVersionInformation()
    {
        define('PAM_REVISION',  'H.1');
        define('PAM_VERSION',   'H.1');
        define('PAM_YEAR',      '2013');
    }

    private function loadPamConfigFiles($configPath)
    {
        // database
        require_once($configPath . DIRECTORY_SEPARATOR . 'config_database.inc.php');
        // beschikbaar maken in PamSetup
        $this->databaseHostname = $host;
        $this->databaseUsername = $username;
        $this->databasePassword = $password;
        $this->databaseName     = $dbase;

        // build "specifieke" config
        require_once($configPath . DIRECTORY_SEPARATOR . 'config_site.inc.php');
    }

    private function definePamSiteInformation()
    {
        define('ENVIRONMENT_DETAIL',    'Hanze');
        define('ENVIRONMENT_COLOR',     '#ffffff');

        define('SITE_TITLE',    'PAM ' . PAM_VERSION);
        define('SITE_NAME',      SITE_TITLE);
        define('FOOTER',        'PAM ' . PAM_REVISION . ' - &copy; ' . PAM_YEAR . ' All Rights Reserved - PAMpeople and Gino b.v. - ' . ENVIRONMENT_DETAIL);
        define('PDF_FOOTER',    'PAM ' . PAM_REVISION . ' - © ' . PAM_YEAR . ' All Rights Reserved - PAMpeople and Gino b.v. - ' . ENVIRONMENT_DETAIL);
    }

    private function defineApplicationSettings()
    {
        /**
        * De applicatie specifieke instellingen worden via de config_site aangestuurt.
        * DE APPLICATION_ settings worden in de applicatie gebruikt, en aangestuurt met de conditionele defined(...)
        * Om een instelling aan te passen moet je de conditionele defined(....) in je config_site definieren, en niet de default wijzigen.
        */
        define('APPLICATION_IS_PRODUCTION_ENVIRONMENT',                     false);

        // dateutils configuratie settings
        define('APPLICATION_DATE_DISPLAY_FORMAT',                           (defined('DEFAULT_DATE_DISPLAY_FORMAT') ? DEFAULT_DATE_DISPLAY_FORMAT : 'd-m-Y'));
        define('APPLICATION_DATETIME_FLAT_FORMAT',                          (defined('DEFAULT_DATETIME_FLAT_FORMAT') ? DEFAULT_DATETIME_FLAT_FORMAT : 'Ymd-His'));
        define('APPLICATION_DATETIME_DISPLAY_FORMAT',                       (defined('DEFAULT_DATETIME_DISPLAY_FORMAT') ? DEFAULT_DATETIME_DISPLAY_FORMAT : APPLICATION_DATE_DISPLAY_FORMAT . ' H:i'));
//        define('APPLICATION_DATELONGTIME_DISPLAY_FORMAT',                   (defined('DEFAULT_DATELONGTIME_DISPLAY_FORMAT') ? DEFAULT_DATETIME_DISPLAY_FORMAT : APPLICATION_DATE_DISPLAY_FORMAT . ' H:i:s'));
        define('APPLICATION_TIME_DISPLAY_FORMAT',                           (defined('DEFAULT_TIME_DISPLAY_FORMAT') ? DEFAULT_TIME_DISPLAY_FORMAT : 'H:i'));
        // formatstring voor display format naar database
        define('APPLICATION_DATE_DATABASE_FORMAT',                          (defined('DEFAULT_DATE_DATABASE_FORMAT') ? DEFAULT_DATE_DATABASE_FORMAT : 'Y-m-d'));
        define('APPLICATION_DATE_DISPLAY_TO_DATABASE_FORMAT',               (defined('DEFAULT_DATE_DISPLAY_TO_DATABASE_FORMAT') ? DEFAULT_DATE_DISPLAY_TO_DATABASE_FORMAT : '%d-%m-%Y'));

        // email settings
        define('APPLICATION_NO_REPLY_EMAIL_ADDRESS',                        (defined('NO_REPLY_EMAIL_ADDRESS')  ? NO_REPLY_EMAIL_ADDRESS    : 'noreply'));

        // profiel scherm
        define('APPLICATION_SHOW_JOB_PROFILE_IN_PROFILE',                   (defined('SHOW_JOB_PROFILE_IN_PROFILE')         ? SHOW_JOB_PROFILE_IN_PROFILE : false));

        // score edit keep alive laten doen
        define('APPLICATION_EDIT_SCORE_KEEP_ALIVE',                         (defined('EDIT_SCORE_KEEP_ALIVE')       ? EDIT_SCORE_KEEP_ALIVE     : false));
        define('APPLICATION_EMPLOYEE_LIST_ARROW_KEYS',                      (defined('EMPLOYEE_LIST_ARROW_KEYS')    ? EMPLOYEE_LIST_ARROW_KEYS  : false));

        // selfassessment
        define('APPLICATION_DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS',  (defined('DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS')    ? DEFAULT_SELFASSESSMENT_INVITATION_VALID_DAYS  : 320));
        define('APPLICATION_ASSESSMENT_SCORE_DIFF_TRESHOLD',                (defined('ASSESSMENT_SCORE_DIFF_TRESHOLD')                  ? ASSESSMENT_SCORE_DIFF_TRESHOLD                : 36));
        define('APPLICATION_ASSESSMENT_RANK_COUNT',                         (defined('ASSESSMENT_RANK_COUNT')                           ? ASSESSMENT_RANK_COUNT                         : 1));
        define('APPLICATION_SHOW_INVITATION_INFORMATION',                   (defined('SHOW_INVITATION_INFORMATION')                     ? SHOW_INVITATION_INFORMATION                   : true));

        // filters
        define('APPLICATION_SHOW_SELECTOR_EMPLOYEES_COUNT',                 (defined('SHOW_SELECTOR_EMPLOYEES_COUNT')   ? SHOW_SELECTOR_EMPLOYEES_COUNT : false));
        define('APPLICATION_EMPLOYEES_LIMIT_NUMBER',                        (defined('EMPLOYEES_LIMIT_NUMBER')          ? EMPLOYEES_LIMIT_NUMBER : 350));
        // leidinggevende dashboard tonen bij filter
        define('APPLICATION_BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD',        (defined('BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD') ? BOSS_FILTER_SHOWS_ASSESSMENT_DASHBOARD : false));

        //
        define('APPLICATION_REFERENCE_DATE_EDITOR_ALLOWED',                 (defined('REFERENCE_DATE_EDITOR_ALLOWED')           ? REFERENCE_DATE_EDITOR_ALLOWED : false));

        // develop
        define('APPLICATION_SHOW_UNLOADED_WORDS',                           (defined('DEVELOPER_SHOW_UNLOADED_WORDS')           ? DEVELOPER_SHOW_UNLOADED_WORDS : false));
        define('APPLICATION_CHECK_AND_FAIL_UNFOUND_WORDS',                  (defined('DEVELOPER_CHECK_AND_FAIL_UNFOUND_WORDS')  ? DEVELOPER_CHECK_AND_FAIL_UNFOUND_WORDS : false));
        define('APPLICATION_DEBUG_INTERFACE',                               (defined('DEVELOPER_DEBUG_INTERFACE')               ? DEVELOPER_DEBUG_INTERFACE : false));

    }

}

?>
