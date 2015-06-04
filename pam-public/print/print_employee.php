<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::hasValidSession(null)) {
        // TODO: via interface print processor
        require_once("pdf/print_employee.php");
    }

?>