<?php
// hbd: dit komt telkens voor bovenin elk print bestand...
    require_once('application/application_setup/pam_config.inc.php');
    // voor fpdf
    define('FPDF_FONTPATH', 'fpdf/font/');

    if (USER == '') {
        header("Location: ".SITE_URL);
    }

?>