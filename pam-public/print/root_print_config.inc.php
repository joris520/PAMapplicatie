<?php
    require_once("../root_pam_config.inc.php");

    if ($pam_ini_done != TRUE) {
        die('pam configuratie niet gelukt');
    }

    if (!isset($_SESSION['user'])) die();

    require_once('application/application_setup/pam_config.inc.php');
?>
