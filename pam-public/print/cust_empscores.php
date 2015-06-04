<?php
    require_once("./root_print_config.inc.php");

    if (PamApplication::isSysAdminLevel()) {
        require_once("pdf/cust_empscores.php");
    }
?>
