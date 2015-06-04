<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_HISTORY)) {
        require_once("pdf/history_prev_f.php");
    }
?>
