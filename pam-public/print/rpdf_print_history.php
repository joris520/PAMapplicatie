<?php
    require_once("./root_print_config.inc.php");
    require_once("modules/common/moduleConsts.inc.php");

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_HISTORY)) {
        $mode = strtolower($_GET['mode']);
        if ($mode == RATING_FUNCTION_PROFILE) {
            require_once("pdf/rpdf/print_history_f.php");
        } else {
            require_once("pdf/rpdf/print_history.php");
        }
    }
?>
