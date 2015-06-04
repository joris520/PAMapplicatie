<?php
    require_once('./root_print_config.inc.php');

    if (PamApplication::hasValidSession(null) && PermissionsService::isPrintAllowed(PERMISSION_COMPETENCES_LIBRARY)) {
        require_once('pdf/print_dictionary.php');
    }
?>
