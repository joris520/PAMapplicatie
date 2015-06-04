<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_SCOREBOARD)) {
        require_once("pdf/rpdf/sb_individual.php");
    }
?>
