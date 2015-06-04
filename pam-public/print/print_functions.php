<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_JOB_PROFILES_LIBRARY)) {
        require_once("pdf/print_functions.php");
    }
?>
