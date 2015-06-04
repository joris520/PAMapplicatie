<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_PERFORMANCE_GRID)) {
        require_once("pdf/perfomance_grid.php");
    }
?>
