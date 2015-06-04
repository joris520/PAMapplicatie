<?php
    require_once("./root_print_config.inc.php");
    require_once('modules/common/moduleConsts.inc.php');

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_HISTORY)) {
        $mode = strtolower($_GET['mode']);
        if ($mode == RATING_FUNCTION_PROFILE) {
            require_once("pdf/print_history_prev_f.php");
        } else {
            require_once("pdf/print_history_prev.php");
        }
    }
?>
