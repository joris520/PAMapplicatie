<?php
    require_once("./root_print_config.inc.php");
    if ($pam_ini_done != TRUE) die('pam configuratie niet gelukt');

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_PDP_TODO_LIST)) {
        require_once("pdf/print_pdptodolist.php");
    }
?>
