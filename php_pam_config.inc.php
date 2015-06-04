<?php
    function setPamIncludePath()
    {
        define('PAM_BASE_DIR', dirname(__file__) . DIRECTORY_SEPARATOR); // sdj: base dir path
        ini_set('include_path', ini_get('include_path') . PATH_SEPARATOR
                                        . PAM_BASE_DIR . 'php_pam' . DIRECTORY_SEPARATOR . PATH_SEPARATOR
                                        . PAM_BASE_DIR . 'php_cm' . DIRECTORY_SEPARATOR . PATH_SEPARATOR
                                        . PAM_BASE_DIR . 'php_library' . DIRECTORY_SEPARATOR);
    }

    $pam_ini_done = FALSE;
    // zoekpad goedzetten
    setPamIncludePath();

    // applicatie configureren
    require_once('application/application_setup/application_config.inc.php');

    $pam_ini_done = TRUE;
?>
