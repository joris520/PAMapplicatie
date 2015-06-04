<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isViewAllowed(PERMISSION_EMPLOYEE_PORTFOLIO_PRINT)) {
        require_once("pdf/print_fullportfolio.php");
    }

?>
