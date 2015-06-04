<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_ALERTS_OVERVIEW)) {
        require_once("pdf/print_msgAlerts.php");
    }
?>
