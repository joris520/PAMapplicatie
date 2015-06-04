<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_REPORT_360)) {
        require_once("pdf/print_threesixty.php");
    }
?>
