<?php

require_once('modules/common/moduleUtils.class.php');

ModuleUtils::ForceLogout();

if (!PAM_DISABLED) {

    require_once('threesixty/360evaluation_deprecated.php');

} else {
    echo 'Wegens onderhoudwerkzaamheden is het op dit moment helaas niet mogelijk het evaluatieformulier in te vullen.';
}
?>
