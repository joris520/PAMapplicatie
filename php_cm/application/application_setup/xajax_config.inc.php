<?php

require_once('application/public/catchInvalid_xajax.php'); // moduleApplication_catchInvalidFunctionCalls en moduleApplication_beforeXajaxFunction

global $xajax;
$xajax->configure("javascript URI", SITE_URL . 'js/xajax/');

// Registreer de functie catchInvalidFunctionCalls om te voorkomen dat gebruikers geen melding krijgen wanneer hun sessie is verlopen
$xajax->register(XAJAX_PROCESSING_EVENT, XAJAX_PROCESSING_EVENT_INVALID, 'moduleApplication_catchInvalidFunctionCalls');
// Met het registreren van onderstaande functie kan ingebroken worden op het moment voordat xajax_ functies worden afgehandeld.
//$xajax->register(XAJAX_PROCESSING_EVENT, XAJAX_PROCESSING_EVENT_BEFORE, 'moduleApplication_beforeXajaxFunction');

//===========

// Bepaal de subset aan modules die geladen moet worden. Gebaseerd op de publiekelijk toegankelijke php pagina's.
switch (MODULE_SUBSET) {
    case MODULE_SUBSET_LOGIN:
        require_once('application/application_setup/module_segments/login_registered_functions.inc.php');
        require_once('application/application_setup/module_segments/login_required_modules.inc.php');
        break;
    case MODULE_SUBSET_THREESIXTY:
        require_once('application/application_setup/module_segments/threesixty_registered_functions.inc.php');
        require_once('application/application_setup/module_segments/threesixty_required_modules.inc.php');
        break;
    case MODULE_SUBSET_APPLICATION:
        require_once('application/application_setup/module_segments/application_registered_functions.inc.php');
        require_once('application/application_setup/module_segments/application_required_modules.inc.php');
        require_once('application/public/navigation_xajax.php');
        require_once('application/public/safeForm_xajax.php');

        break;
    case MODULE_SUBSET_UPLOAD_PHOTO:
        break;
    case MODULE_SUBSET_UPLOAD_LOGO:
        break;
    case MODULE_SUBSET_UPLOAD_ATTACHMENT:
        require_once('application/application_setup/module_segments/upload_registered_functions.inc.php');
        require_once('application/application_setup/module_segments/upload_required_modules.inc.php');
        break;
    case MODULE_SUBSET_CONFIRM_NOTIFICATION:
        break;
    case MODULE_SUBSET_DOWNLOAD_DB:
        break;
    case MODULE_SUBSET_CUSTOMERS:
        require_once('application/application_setup/module_segments/customers_registered_functions.inc.php');
        require_once('application/application_setup/module_segments/customers_required_modules.inc.php');
        require_once('application/public/safeForm_xajax.php');
        break;
    default:
        break;
}

$xajax->processRequest();
?>