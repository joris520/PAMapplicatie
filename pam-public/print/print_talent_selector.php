<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_TALENT_SELECTOR)) {
        require_once("pdf/print_talent_selector.php");
    }

?>
