<?php
    require_once("../root_pam_config.inc.php");
    if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

    // weg hier...
//    echo 'SITE_URL';
    $location = SITE_URL . "index.php";
    header("Location: ". $location);
?>
