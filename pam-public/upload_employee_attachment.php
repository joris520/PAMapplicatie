<?php
    require_once("./root_pam_config.inc.php");
    if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

    require_once('application/application_setup/pam_config.inc.php');

$upload_html = '<script type="text/javascript">parent.location.reload();</script>';
if (isset($user) && defined('CUSTOMER_ID') && PermissionsService::isAddAllowed(PERMISSION_EMPLOYEE_ATTACHMENTS)) { // korte check of we ingelogd zijn volgens pam_config
//    global $smarty;

    require_once('application/application_setup/smarty_config.inc.php');

    require_once("xajax/xajax_core/xajaxAIO.inc.php");   // xajax compiled
    //require_once("xajax/xajax_core/xajax.inc.php");    // xajax minimal
    define('MODULE_SUBSET', MODULE_SUBSET_UPLOAD_ATTACHMENT);

    $xajax = new xajax();
    $xajax->configure('debug', SITE_AJAX_DEBUG);
    require_once('application/application_setup/xajax_config.inc.php');  // hbd: hiervan is ook veel code niet nodig!

    require_once('modules/public/uploads/employee_attachment_upload.inc.php');
    $employeeId = $_SESSION['ID_E'];
    $upload_html = handle_upload_employee_attachment($xajax, $employeeId);
}
echo $upload_html;

?>